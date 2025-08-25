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

    private function modelAnswer()
    {
        $student_answer_sheet = StudentAnswerSheet::where('task_id', '9456ff83-6f7b-4975-b160-6919da494908')->first();
        $student_answer_sheet = json_decode($student_answer_sheet->api_response);

        $model_answer = $student_answer_sheet->result->questions[0]->model_answer;
        $model_answer = <<<EOD
        $model_answer
        EOD;

    
        $model_answer_parts =  $this->parseModelAnswer($model_answer);

        dd($model_answer, $model_answer_parts);

        /**
         * 
         1) generate a php code for extract before \n\n** string as model_answer_intro
         2) then extract all the points between ** and \n\n as points array [key => value] here key is point title and value is point description
         3) then extract after last \n\n as model_answer_conclution
         */


    }

    private function parseModelAnswer($text) 
    {
        $model_answer_parts = [
            'model_answer_intro' => null,
            'points' => [],
            'model_answer_conclution' => null
        ];

        // Extract intro (everything before first **)
        $introEndPos = strpos($text, '**');
        if ($introEndPos !== false) {
            $intro = substr($text, 0, $introEndPos);
            if (!empty(trim($intro))) {
                $model_answer_parts['model_answer_intro'] = trim($intro);
            }
        }

        // Extract all points between ** and \n\n
        $pointsPattern = '/\*\*([^*]+?)\*\*([^*]+?)(?=\n\n\*\*|\n\n$|\n\n[^*]|$)/s';
        preg_match_all($pointsPattern, $text, $pointMatches, PREG_SET_ORDER);
        
        foreach ($pointMatches as $match) {
            $key = trim($match[1]);
            $value = trim($match[2]);
            $model_answer_parts['points'][$key] = $value;
        }

        // Extract conclusion by finding the position after the last **
        $lastDoubleAsteriskPos = strrpos($text, '**');
        if ($lastDoubleAsteriskPos !== false) {
            // Find the position of the next ** after the current one to get the end of the last point
            $nextAsteriskPos = strpos($text, '**', $lastDoubleAsteriskPos + 2);
            
            if ($nextAsteriskPos === false) {
                // This is the last **, so everything after the content of the last point is conclusion
                $conclusionStart = strpos($text, "\n\n", $lastDoubleAsteriskPos);
                if ($conclusionStart !== false) {
                    $conclusion = substr($text, $conclusionStart + 2);
                    if (!empty(trim($conclusion))) {
                        $model_answer_parts['model_answer_conclution'] = trim($conclusion);
                    }
                }
            }
        }


        return $model_answer_parts;
    }


}
