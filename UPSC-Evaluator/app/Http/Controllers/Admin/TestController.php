<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
}
