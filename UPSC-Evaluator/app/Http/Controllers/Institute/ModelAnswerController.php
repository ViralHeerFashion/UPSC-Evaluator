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

            Storage::delete($upload_path);

            /*$payload = [
                'model_answer' => new \CURLFile($filePath, 'application/pdf', $institute_model_answer->file_name)
            ];

            curl_setopt_array($ch, [
                CURLOPT_URL => "",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_TIMEOUT => 600,
                CURLOPT_POSTFIELDS => $payload,
                CURLOPT_HTTPHEADER => [
                    "X-API-KEY: 1_Vm83n4ZJrVTMJGgVPqmXZGWKx-d0MlvEk3i6frwEE"
                ],
            ]);

            $response = json_decode(curl_exec($ch));
            curl_close($ch);*/

            $response = json_decode(Storage::get('/model_answer/response_1.json'));

            Storage::delete($filePath);

            $institute_model_answer->model_answer = json_encode($response);
            $institute_model_answer->save();

            if (isset($response->status) && !empty($response->status)) {
                return redirect()->route('institute.model-answer.view', ['id' => $institute_model_answer->id])->with('alert_success', "Model Answer Uploaded successfully...");
            } else {
                $institute_model_answer->error_detect = 1;
                $institute_model_answer->save();
                return back()->with('alert_error', "Something Went wrong please upload valid pdf or contact our team.");
            }
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
