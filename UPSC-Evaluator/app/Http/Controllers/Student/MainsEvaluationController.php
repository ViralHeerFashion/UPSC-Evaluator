<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Smalot\PdfParser\Parser;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\{
    StudentAnswerSheet,
    StudentAnswerEvaluation,
    QuestionMicroMarkingGrid,
    StrengthSnapShot,
    GapAnalysisPriorityFixes,
    ModelAnswer,
    Wallet
};

class MainsEvaluationController extends Controller
{
    private $per_page_evaluation_charge = 5;
    private $api_base_url = "https://upsc-ai-evaluator.onrender.com";
    public function index(string $process_id = null)
    {
        $student_answer_sheet = null;
        if (!is_null($process_id)) {
            $student_answer_sheet = StudentAnswerSheet::with([
                'student_answer_evaluation' => function ($query) {
                    $query->with([
                        'micro_marking_grid',
                        'strength_snapshot',
                        'gap_analysis_priority_fix',
                        'model_answer'
                    ]);
                }
            ])
            ->where('task_id', $process_id)
            ->first();

            if (is_null($student_answer_sheet)) {
                abort(404);
            }
        }

        return view('student.mains-evaluation.index', compact('student_answer_sheet'));
    }

    public function list()
    {
        $student_answer_sheets = StudentAnswerSheet::where('user_id', Auth::id())
                                    ->where('is_evaluated', 1)
                                    ->orderBy('created_at', 'desc')
                                    ->get()
                                    ->groupBy(function($item) {
                                        return $item->created_at->format('d-m-Y');
                                    });

        return view('student.mains-evaluation.list', compact('student_answer_sheets'));
    }

    public function generateTask(Request $request)
    {
        $current_running_tasks = StudentAnswerSheet::where('is_evaluated', 0)->count();
        if ($current_running_tasks > 20) {
            return response()->json([
                'success' => false,
                'server_busy' => true,
                'message' => "Please try again after sometime. Our servers are busy right now."
            ]);
        }

        $parser = new Parser();
        $pdf = $parser->parseFile($request->file('answer_sheet')->getPathname());
        $total_page_available_in_pdf = count($pdf->getPages());
        $wallet_amount = $this->getWalleTotal();
        $evaluation_charge = $this->per_page_evaluation_charge * $total_page_available_in_pdf;
        if ($evaluation_charge > $wallet_amount) {
            return response()->json([
                'success' => false,
                'message' => "Do don't have enough balance for this evaluation"
            ]);
        }

        $student_answer_sheet = new StudentAnswerSheet;
        $student_answer_sheet->user_id = Auth::id();
        $student_answer_sheet->pdf = ($request->hasFile('answer_sheet')) ? $request->file('answer_sheet')->store('answer_sheets') : "";
        $student_answer_sheet->file_name = $request->file('answer_sheet')->getClientOriginalName();
        $student_answer_sheet->evaluation_charge = $evaluation_charge;
        $student_answer_sheet->subject_id = 1;
        $student_answer_sheet->save();

        $ch = curl_init();
        $filePath = storage_path("app/private/".$student_answer_sheet->pdf);

        $payload = [
            'answer_sheet' => new \CURLFile($filePath, 'application/pdf', $student_answer_sheet->file_name)
        ];

        curl_setopt_array($ch, [
            CURLOPT_URL => $this->api_base_url."/api/evaluate",
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

        $student_answer_sheet->api_response = $response;
        $student_answer_sheet->save();

        $response = json_decode($response);

        if (isset($response->task_id) && !empty($response->task_id)) {
            $student_answer_sheet->task_id = $response->task_id;
            $student_answer_sheet->save();
            Storage::delete($student_answer_sheet->pdf);
        }

        return response()->json([
            'success' => true,
            'message' => "Task generated successfully. Please wait for evaluation.",
            'task_id' => $student_answer_sheet->task_id,
            'loader_second' => $total_page_available_in_pdf * 4
        ]);

    }

    public function processTask(string $task_id)
    {
        $student_answer_sheet = StudentAnswerSheet::where('task_id', $task_id)->first();
        if(!is_null($student_answer_sheet)){
            $url = $this->api_base_url."/api/results/".$student_answer_sheet->task_id;
            
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
                curl_close($ch);

                $api_status = isset($response->result) && !empty($response->result) ? "SUCCESS" : $response->status;
                if($api_status == "SUCCESS") {
                    $student_answer_sheet->api_response = json_encode($response);
                    $student_answer_sheet->save();
                }
                sleep(5);
            } while ($api_status != "SUCCESS" || $api_status == "FAILURE");

            if($api_status == "FAILURE") {
                return response()->json([
                    'success' => false,
                    'message' => "Something went wrong while processing your answersheet. Please try again later or contact our support team."
                ]);
            }   
            
            foreach ($response->result->questions as $key => $question) {
                
                $model_answer = <<<EOD
                {$question->model_answer}
                EOD;

                $model_answer_parts = $this->parseModelAnswer($model_answer);

                $student_answer_evaluation = new StudentAnswerEvaluation;
                $student_answer_evaluation->student_answersheet_id = $student_answer_sheet->id;
                $student_answer_evaluation->question = $question->question_text;
                $student_answer_evaluation->deconstruction = $question->question_deconstruction;
                $student_answer_evaluation->micro_marking_grid_total_marks = $question->micro_marking_grid->total_marks;
                $student_answer_evaluation->max_marks = $question->max_marks;
                $student_answer_evaluation->marks_awarded = $question->marks_awarded;
                $student_answer_evaluation->question_no = $question->question_number;
                $student_answer_evaluation->model_answer_intro = isset($model_answer_parts['model_answer_intro']) && !empty($model_answer_parts['model_answer_intro']) ? $model_answer_parts['model_answer_intro'] : null;
                $student_answer_evaluation->model_answer_conclusion = isset($model_answer_parts['model_answer_conclution']) && !empty($model_answer_parts['model_answer_conclution']) ? $model_answer_parts['model_answer_conclution'] : null;
                $student_answer_evaluation->save();

                if (isset($model_answer_parts['points']) && count($model_answer_parts['points']) > 0) {
                    foreach($model_answer_parts['points'] as $key => $point){
                        $modelAnswer = new ModelAnswer;
                        $modelAnswer->student_answer_evaluation_id = $student_answer_evaluation->id;
                        $modelAnswer->title = $key;
                        $modelAnswer->description = $point;
                        $modelAnswer->save();
                    }
                }

                if (isset($question->micro_marking_grid) && isset($question->micro_marking_grid->components)) {
                    foreach ($question->micro_marking_grid->components as $key => $micro_marking_grid) {
                        $question_micro_markng_grid = new QuestionMicroMarkingGrid;
                        $question_micro_markng_grid->student_answer_evaluation_id = $student_answer_evaluation->id;
                        $question_micro_markng_grid->component = $micro_marking_grid->name;
                        $question_micro_markng_grid->weight = $micro_marking_grid->weight_percentage;
                        $question_micro_markng_grid->max_marks = $micro_marking_grid->max_marks;
                        $question_micro_markng_grid->marks_awarded = $micro_marking_grid->given_marks;
                        $question_micro_markng_grid->justifications = $micro_marking_grid->justification;
                        $question_micro_markng_grid->save();
                    }
                }

                if (isset($question->strengths)) {
                    foreach ($question->strengths as $key => $strength) {
                        $strength_snapshot = new StrengthSnapShot;
                        $strength_snapshot->student_answer_evaluation_id = $student_answer_evaluation->id;
                        $strength_snapshot->snapshot = $strength;
                        $strength_snapshot->save();
                    }
                }

                if (isset($question->gaps)) {
                    foreach ($question->gaps as $key => $gap) {
                        $gap_analysis_priority_fix = new GapAnalysisPriorityFixes;
                        $gap_analysis_priority_fix->student_answer_evaluation_id = $student_answer_evaluation->id;
                        $gap_analysis_priority_fix->gap = $gap->gap;
                        $gap_analysis_priority_fix->impact = $gap->impact;
                        $gap_analysis_priority_fix->correct_action = $gap->corrective_action;
                        $gap_analysis_priority_fix->save();
                    }
                }
            }

            $student_answer_sheet->is_evaluated = 1;
            $student_answer_sheet->save();

            $student_answer_sheet = StudentAnswerSheet::with([
                'student_answer_evaluation' => function ($query) {
                    $query->with([
                        'micro_marking_grid',
                        'strength_snapshot',
                        'gap_analysis_priority_fix',
                        'model_answer'
                    ]);
                }
            ])->findOrFail($student_answer_sheet->id);

            $wallet = new Wallet;
            $wallet->user_id = Auth::id();
            $wallet->student_answersheet_id = $student_answer_sheet->id;
            $wallet->amount = -$student_answer_sheet->evaluation_charge;
            $wallet->save();

            return response()->json([
                'success' => true,
                'message' => "PDF proccess successfully...",
                'view' => view('student.mains-evaluation.partials.questions', compact(
                    'student_answer_sheet'
                ))->render(),
                'student_answer_sheet_id' => $student_answer_sheet->id
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => "Task ID not found"
        ]);
    }

    public function makeEvaluate(Request $request)
    {
        $parser = new Parser();
        $pdf = $parser->parseFile($request->file('answer_sheet')->getPathname());
        $total_page_available_in_pdf = count($pdf->getPages());
        $wallet_amount = $this->getWalleTotal();
        $evaluation_charge = $this->per_page_evaluation_charge * $total_page_available_in_pdf;
        if ($evaluation_charge > $wallet_amount) {
            return response()->json([
                'success' => false,
                'message' => "Do don't have enough balance for this evaluation"
            ]);
        }

        $student_answer_sheet = new StudentAnswerSheet;
        $student_answer_sheet->user_id = Auth::id();
        $student_answer_sheet->pdf = ($request->hasFile('answer_sheet')) ? $request->file('answer_sheet')->store('answer_sheets') : "";
        $student_answer_sheet->save();

        $response = Storage::disk('public')->get('response/response.json');
        $student_answer_sheet->api_response = $response;
        $student_answer_sheet->save();

        $response = json_decode($response, true);

        foreach ($response['questions'] as $key => $question) {

            $model_answer = <<<EOD
            {$question['model_answer']}
            EOD;

            preg_match('/^(.*?)\n\*\*/s', $model_answer, $intro_match);
            $model_answer_intro = isset($intro_match[1]) ? trim($intro_match[1]) : null;

            $student_answer_evaluation = new StudentAnswerEvaluation;
            $student_answer_evaluation->student_answersheet_id = $student_answer_sheet->id;
            $student_answer_evaluation->question = $question['question_text'];
            $student_answer_evaluation->deconstruction = $question['question_deconstruction'];
            $student_answer_evaluation->micro_marking_grid_total_marks = $question['micro_marking_grid']['total_marks'];
            $student_answer_evaluation->max_marks = $question['max_marks'];
            $student_answer_evaluation->marks_awarded = $question['marks_awarded'];
            $student_answer_evaluation->model_answer_intro = $model_answer_intro;
            $student_answer_evaluation->save();

            preg_match_all('/\*\*(.+?)\:\*\*\s*(.+?)(?=\n\n|\z)/s', $model_answer, $matches, PREG_OFFSET_CAPTURE);

            foreach ($matches[1] as $i => $titleMatch) {
                $key   = trim($titleMatch[0]);
                $value = trim($matches[2][$i][0]);

                $modelAnswer = new ModelAnswer;
                $modelAnswer->student_answer_evaluation_id = $student_answer_evaluation->id;
                $modelAnswer->title = $key;
                $modelAnswer->description = $value;
                $modelAnswer->save();
            }

            $last_match_end = 0;
            if (!empty($matches[0])) {
                $last = end($matches[0]);
                $last_match_end = $last[1] + strlen($last[0]); // works now (offset + length)
            }

            $student_answer_evaluation->model_answer_conclusion = trim(substr($model_answer, $last_match_end));
            $student_answer_evaluation->save();

            if (isset($question['micro_marking_grid']) && isset($question['micro_marking_grid']['components'])) {
                foreach ($question['micro_marking_grid']['components'] as $key => $micro_marking_grid) {
                    $question_micro_markng_grid = new QuestionMicroMarkingGrid;
                    $question_micro_markng_grid->student_answer_evaluation_id = $student_answer_evaluation->id;
                    $question_micro_markng_grid->component = $micro_marking_grid['name'];
                    $question_micro_markng_grid->weight = $micro_marking_grid['weight_percentage'];
                    $question_micro_markng_grid->max_marks = $micro_marking_grid['max_marks'];
                    $question_micro_markng_grid->marks_awarded = $micro_marking_grid['given_marks'];
                    $question_micro_markng_grid->justifications = $micro_marking_grid['justification'];
                    $question_micro_markng_grid->save();
                }
            }

            if (isset($question['strengths'])) {
                foreach ($question['strengths'] as $key => $strength) {
                    $strength_snapshot = new StrengthSnapShot;
                    $strength_snapshot->student_answer_evaluation_id = $student_answer_evaluation->id;
                    $strength_snapshot->snapshot = $strength;
                    $strength_snapshot->save();
                }
            }

            if (isset($question['gaps'])) {
                foreach ($question['gaps'] as $key => $gap) {
                    $gap_analysis_priority_fix = new GapAnalysisPriorityFixes;
                    $gap_analysis_priority_fix->student_answer_evaluation_id = $student_answer_evaluation->id;
                    $gap_analysis_priority_fix->gap = $gap['gap'];
                    $gap_analysis_priority_fix->impact = $gap['impact'];
                    $gap_analysis_priority_fix->correct_action = $gap['corrective_action'];
                    $gap_analysis_priority_fix->save();
                }
            }
        }

        $student_answer_sheet = StudentAnswerSheet::with([
            'student_answer_evaluation' => function ($query) {
                $query->with([
                    'micro_marking_grid',
                    'strength_snapshot',
                    'gap_analysis_priority_fix',
                    'model_answer'
                ]);
            }
        ])->findOrFail($student_answer_sheet->id);

        $wallet = new Wallet;
        $wallet->user_id = Auth::id();
        $wallet->student_answersheet_id = $student_answer_sheet->id;
        $wallet->amount = -$evaluation_charge;
        $wallet->save();

        return response()->json([
            'success' => true,
            'message' => "PDF proccess successfully...",
            'view' => view('student.mains-evaluation.partials.questions', compact(
                'student_answer_sheet'
            ))->render(),
            'student_answer_sheet_id' => $student_answer_sheet->id
        ]);
    }

    public function downloadEvaluation(string $process_id)
    {  
        $student_answer_sheet = StudentAnswerSheet::with([
            'student_answer_evaluation' => function ($query) {
                $query->with([
                    'micro_marking_grid',
                    'strength_snapshot',
                    'gap_analysis_priority_fix',
                    'model_answer'
                ]);
            }
        ])
        ->where('task_id', $process_id)
        ->first(); 

        $pdf = Pdf::loadView('student.mains-evaluation.pdf', compact(
            'student_answer_sheet'
        ));
        return $pdf->download('Evaluation-'.$student_answer_sheet->file_name);

        // return view('student.mains-evaluation.pdf', compact(
        //     'student_answer_sheet'
        // ));

    }

    private function getWalleTotal()
    {
        return Wallet::where('user_id', Auth::id())->sum('amount');
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

        error_log(json_encode($model_answer_parts), 0);


        return $model_answer_parts;
    }
}
