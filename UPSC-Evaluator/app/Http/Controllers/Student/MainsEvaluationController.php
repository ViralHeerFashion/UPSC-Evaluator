<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\{
    StudentAnswerSheet,
    StudentAnswerEvaluation,
    QuestionMicroMarkingGrid,
    StrengthSnapShot,
    GapAnalysisPriorityFixes,
    ModelAnswer
};

class MainsEvaluationController extends Controller
{
    public function index()
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
        ])->findOrFail(1);

        return view('student.mains-evaluation.index', compact('student_answer_sheet'));
    }

    public function makeEvaluate(Request $request)
    {
        $student_answer_sheet = new StudentAnswerSheet;
        $student_answer_sheet->user_id = Auth::id();
        $student_answer_sheet->pdf = ($request->hasFile('answer_sheet')) ? $request->file('answer_sheet')->store('answer_sheets') : "";
        $student_answer_sheet->save();

        $response = Storage::disk('public')->get('response/response.json');
        $response = json_decode($response, true);

        foreach ($response['questions'] as $key => $question) {

            $model_answer = <<<EOD
            {$question['model_answer']}
            EOD;

            preg_match('/^(.*?)\n\*\*/s', $model_answer, $intro_match);
            $model_answer_intro = isset($intro_match[1]) ? trim($intro_match[1]) : '';

            $student_answer_evaluation = new StudentAnswerEvaluation;
            $student_answer_evaluation->student_answersheet_id = 1;
            $student_answer_evaluation->question = $question['question_text'];
            $student_answer_evaluation->deconstruction = $question['question_deconstruction'];
            $student_answer_evaluation->micro_marking_grid_total_marks = $question['micro_marking_grid']['total_marks'];
            $student_answer_evaluation->max_marks = $question['max_marks'];
            $student_answer_evaluation->marks_awarded = $question['marks_awarded'];
            $student_answer_evaluation->model_answer_intro = $model_answer_intro;
            $student_answer_evaluation->save();

            preg_match_all('/\*\*(.+?)\:\*\*\s*(.+?)(?=\n\n|\z)/s', $model_answer, $matches, PREG_SET_ORDER);

            foreach ($matches as $match) {
                $key = trim($match[1]);
                $value = trim($match[2]);

                $model_answer = new ModelAnswer;
                $model_answer->student_answer_evaluation_id = $student_answer_evaluation->id;
                $model_answer->title = $key;
                $model_answer->description = $value;
                $model_answer->save();
            }

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

        return view('student.mains-evaluation.partials.questions', compact(
            'student_answer_sheet'
        ));
    }
}
