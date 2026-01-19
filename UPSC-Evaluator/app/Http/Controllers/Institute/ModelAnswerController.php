<?php

namespace App\Http\Controllers\Institute;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\{
    InstituteModelAnswer
};

class ModelAnswerController extends Controller
{
    private $api_base_url = "https://upsc-ai-evaluator.onrender.com";
    public function index(Request $request)
    {
        $model_answers = InstituteModelAnswer::select('id', 'file_name', 'created_at')
                                            ->where('institute_id', Auth::guard('institute')->id())
                                            ->orderByDesc('id')
                                            ->paginate(100);

        return view('institute.model-answer.index', compact(
            'model_answers'
        ));    
    }

    public function add()
    {
        return view('institute.model-answer.add');
    }

    public function create(Request $request)
    {
        if ($request->hasFile('model_answer_pdf')) {
            $institute_model_answer = new InstituteModelAnswer;
            $institute_model_answer->institute_id = Auth::guard('institute')->id();
            $institute_model_answer->file_name = $request->file('model_answer_pdf')->getClientOriginalName();
            $institute_model_answer->save();

            $upload_path = $request->file('model_answer_pdf')->store('model_answer');

            $ch = curl_init();
            $filePath = storage_path("app/private/".$upload_path);

            // Auth::guard('institute')->user()->institute_api_name
            $payload = [
                'model_answers' => new \CURLFile($filePath, 'application/pdf', $institute_model_answer->file_name),
                'institute_name' => Auth::guard('institute')->user()->institute_api_name
            ];

            curl_setopt_array($ch, [
                CURLOPT_URL => $this->api_base_url."/api/model-answers/ingest",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_TIMEOUT => 600,
                CURLOPT_POSTFIELDS => $payload,
                CURLOPT_HTTPHEADER => [
                    "X-API-KEY: 1_Vm83n4ZJrVTMJGgVPqmXZGWKx-d0MlvEk3i6frwEE"
                ],
            ]);

            $response = curl_exec($ch);
            curl_close($ch);

            $institute_model_answer->model_answer = $response;
            $institute_model_answer->save();

            $response = json_decode($response);

            // $response = json_decode(Storage::get('/model_answer/response_1.json'));           

            Storage::delete($filePath);

            if (isset($response->task_id) && !empty($response->task_id)) {
                
                $institute_model_answer->task_id = $response->task_id;
                $institute_model_answer->save();
                
                // return redirect()->route('institute.model-answer.view', ['id' => $institute_model_answer->id])->with('alert_success', "Model Answer Uploaded successfully...");
                
                return response()->json([
                    'success' => true,
                    'message' => "Task generated successfully. Please wait for evaluation.",
                    'task_id' => $response->task_id,
                ]);
            } else {
                $institute_model_answer->error_detect = 1;
                $institute_model_answer->save();
                
                return response()->json([
                    'success' => true,
                    'message' => "Something Went wrong please upload valid pdf or contact our team.",
                ]);
            }
        }
    }

    public function processTask(string $task_id)
    {
        $institute_model_answer = InstituteModelAnswer::where('task_id', $task_id)
                                                    ->where('institute_id', Auth::guard('institute')->id())
                                                    ->first();
        if (!is_null($institute_model_answer)) {
            $url = $this->api_base_url."/api/results/".$institute_model_answer->task_id;
            
            $api_status = "PENDING";

            $ch = curl_init();

            curl_setopt_array($ch, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => [
                    "X-API-KEY: 1_Vm83n4ZJrVTMJGgVPqmXZGWKx-d0MlvEk3i6frwEE"
                ],
                CURLOPT_TIMEOUT => 1200,
                CURLOPT_CONNECTTIMEOUT => 60,
                CURLOPT_TIMEOUT_MS => 1200000
            ]);

            $response = json_decode(curl_exec($ch));
            curl_close($ch);

            $api_status = isset($response->result) && !empty($response->result) ? "SUCCESS" : $response->status;

            if($api_status == "SUCCESS") {
                $institute_model_answer->model_answer = json_encode($response);
                $institute_model_answer->save();

                return response()->json([
                    'success' => true,
                    'redirect_url' => route('institute.model-answer.view', ['id' => $institute_model_answer->id]),
                    'message' => "Model Answer proccess successfully..."
                ]);
            }

            if($api_status == "FAILURE") {
                
                $institute_model_answer->model_answer = json_encode($response);
                $institute_model_answer->error_detect = 1;
                $institute_model_answer->save();
                
                return response()->json([
                    'success' => false,
                    'message' => "Something went wrong while processing your answersheet. Please try again later or contact our support team."
                ]);
            }

            return response()->json([
                'success' => false,
                'process_task' => true,
                'message' => "Your file is being process"
            ]);
        } 
    }

    public function view(int $id)
    {
        $institute_model_answer = InstituteModelAnswer::where('id', $id)
                                                    ->where('institute_id', Auth::guard('institute')->id())
                                                    ->first();

        if (is_null($institute_model_answer)) {
            abort(404);
        }

        return view('institute.model-answer.view', compact(
            'institute_model_answer'
        ));
    }

    public function delete(int $id)
    {
        InstituteModelAnswer::where('id', $id)
                            ->where('institute_id', Auth::guard('institute')->id())
                            ->delete();

        return back()->with('alert_success', "Model answer deleted successfully...");
    }
}
