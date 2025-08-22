<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\{
    StudentAnswerSheet,
    StudentAnswerEvaluation,
    QuestionMicroMarkingGrid,
    StrengthSnapShot,
    GapAnalysisPriorityFixes,
    ModelAnswer
};

class TestController extends Controller
{
    public function index(Request $request)
    {
        $method_name = $request->filled('method_name') ? $request->method_name : null;
        if (!is_null($method_name)) {
            $this->$method_name($request);
        }
    }

    private function deleteEvaluation()
    {
        StudentAnswerSheet::truncate();
        StudentAnswerEvaluation::truncate();
        QuestionMicroMarkingGrid::truncate();
        StrengthSnapShot::truncate();
        GapAnalysisPriorityFixes::truncate();
        ModelAnswer::truncate();
    }

    // http://127.0.0.1:8001/admin/test?method_name=testProcessTast

    private function testProcessTast()
    {
        $file_path = "answer_sheets/yHLuZljjZu8wnNJtnd5cxlB72912BzlfXlfe4MBK.pdf";
        $payload = [
            "answer_sheet" => new \CURLFile(
                storage_path('app/' . $file_path), 
                "application/pdf", 
                "Testing_file_for_Superkalam.pdf"
            )
        ];

        $tempPath = tempnam(sys_get_temp_dir(), 'upload_');
        file_put_contents($tempPath, $file_path);

        $payload = [
            'answer_sheet' => new \CURLFile($tempPath, 'application/pdf', 'Testing_file_for_Superkalam.pdf')
        ];


        $ch = curl_init();

        // dd($payload);

        curl_setopt_array($ch, [
            CURLOPT_URL => "https://upsc-ai-evaluator.onrender.com/api/evaluate",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_TIMEOUT => 600,
            CURLOPT_POSTFIELDS => $payload,
            CURLOPT_HTTPHEADER => [
                "X-API-KEY: 1_Vm83n4ZJrVTMJGgVPqmXZGWKx-d0MlvEk3i6frwEE"
            ],
        ]);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        $response = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($response);
        echo "<pre>";
        print_r($response);
        $this->processTask($response->task_id);
    }

    public function processTask($task_id)
    {
        $url = "https://upsc-ai-evaluator.onrender.com/api/results/".urlencode($task_id);
            
        $api_status = "PENDING";

        $ch = curl_init();

        do {
            curl_setopt_array($ch, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => [
                    "X-API-KEY: 1_Vm83n4ZJrVTMJGgVPqmXZGWKx-d0MlvEk3i6frwEE"
                ],
                CURLOPT_TIMEOUT => 30
            ]);

            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        
            $response = json_decode(curl_exec($ch));
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            echo "<pre>";
            print_r($response);
            
            error_log(json_encode($response), 0);

            $api_status = isset($response->status) && !empty($response->status) ? $response->status : null;
            if (is_null($api_status)) {
                dd($response);
            }
            sleep(20);
        } while (!is_null($api_status));
    }

    private function deleteMyPDF()
    {
        $student_answer_sheet = StudentAnswerSheet::find(1);
        Storage::delete($student_answer_sheet->pdf);
        dd("PDF deleted successfully");
    }
}
