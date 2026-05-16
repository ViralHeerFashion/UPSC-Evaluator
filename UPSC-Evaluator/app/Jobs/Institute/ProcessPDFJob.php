<?php

namespace App\Jobs\Institute;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\Institute\{
    CompleteUploadedFileBatch
};
use App\Models\{
    Institute,
    InstituteUploadBatch,
    InstituteUploadFile,
    Error
};

class ProcessPDFJob implements ShouldQueue
{
    use Queueable;
    public $timeout = 1200;
    public $tries = 2;
    private $institute_upload_file_id;
    private $api_base_url = "https://upsc-ai-evaluator.onrender.com";
    private $api_secret_key = "1_Vm83n4ZJrVTMJGgVPqmXZGWKx-d0MlvEk3i6frwEE";

    /**
     * Create a new job instance.
     */
    public function __construct(int $institute_upload_file_id)
    {
        $this->institute_upload_file_id = $institute_upload_file_id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $institute_upload_file = InstituteUploadFile::find($this->institute_upload_file_id);
        $this->createTask($institute_upload_file);
        
        do {
            $is_success = false;
            $url = $this->api_base_url."/api/annotated-pdf/".$institute_upload_file->task_id;
            
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => [
                    "X-API-KEY: ".$this->api_secret_key
                ],
                CURLOPT_TIMEOUT => 1200,
                CURLOPT_CONNECTTIMEOUT => 60,
                CURLOPT_TIMEOUT_MS => 1200000
            ]);
            $response = curl_exec($curl);
            $content_type = curl_getinfo($curl, CURLINFO_CONTENT_TYPE);
            curl_close($curl);

            if ($content_type == 'application/pdf') {
                $file_name = 'evaluate_' . time() . '_' .$institute_upload_file->file_name. '.pdf';
                $file_path = 'institute_bulk_answer_sheets_output/' . $file_name;
                Storage::disk('public')->put(
                    'institute_bulk_answer_sheets_output/' . $file_name,
                    $response
                );
                $institute_upload_file->status = 1;
                $institute_upload_file->success_file_path = $file_path;
                $institute_upload_file->success_at = date("Y-m-d H:i:s");
                $institute_upload_file->save();

                $is_success = true;
            } elseif($content_type == 'application/json'){
                $response = json_decode($response);
                if ($response->status == "FAILURE") {
                    $is_success = true;
                    $institute_upload_file->status = 2;
                    $institute_upload_file->api_response = json_encode($response);
                    $institute_upload_file->success_at = date("Y-m-d H:i:s");
                    $institute_upload_file->save();
                } else {
                    sleep(10);
                }
            }
        } while (!$is_success); 
        
        $is_unproccess_files = InstituteUploadFile::where('institute_upload_batch_id', $institute_upload_file->institute_upload_batch_id)
                                                    ->where('status', 0)
                                                    ->exists();
        if (!$is_unproccess_files) {
            $institute_upload_batch = InstituteUploadBatch::find($institute_upload_file->institute_upload_batch_id);
            $institute_upload_batch->is_proccesed = 1;
            $institute_upload_batch->save();

            try {
                Mail::to($institute_upload_batch->institute->email)->send(
                    new CompleteUploadedFileBatch($institute_upload_batch)
                );
            } catch (\Exception $e) {
                $error = new Error;
                $error->message = "Error in Complete Batch file send email";
                $error->error = $e->getMessage();
                $error->file_name = __FILE__;
                $error->line_number = __LINE__;
                $error->save();
            }
        }
    }

    private function createTask($institute_upload_file)
    {
        $filePath = storage_path("app/private/".$institute_upload_file->file_path);
        $institute = Institute::find($institute_upload_file->upload_batch->institute_id, ['id', 'institute_api_name']);

        $payload = [
            'answer_sheet' => new \CURLFile($filePath, 'application/pdf', $institute_upload_file->file_name),
            'language' => $institute_upload_file->upload_batch->language->name,
            'institute_name' => $institute->institute_api_name
        ];

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $this->api_base_url."/api/evaluate-annotated",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $payload,
            CURLOPT_HTTPHEADER => [
                "X-API-KEY: ".$this->api_secret_key,
                "api_key: ".$this->api_secret_key
            ],
        ]);
        $response = curl_exec($curl);
        curl_close($curl);

        $institute_upload_file->api_response = $response;
        $institute_upload_file->save();

        $response = json_decode($response);

        if (isset($response->task_id) && !empty($response->task_id)) {
            $institute_upload_file->task_id = $response->task_id;
            $institute_upload_file->save();
            Storage::delete($institute_upload_file->file_path);
        }
    }
}
