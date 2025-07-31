<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\{
    QuestionMicroMarkingGrid,
    StrengthSnapShot,
    GapAnalysisPriorityFixes,
    ModelAnswer
};

class StudentAnswerEvaluation extends Model
{
    protected $table = 'student_answer_evaluation';
    public $timestamps = false;

    public function micro_marking_grid()
    {
        return $this->hasMany(QuestionMicroMarkingGrid::class, 'student_answer_evaluation_id', 'id');    
    }

    public function strength_snapshot()
    {
        return $this->hasMany(StrengthSnapShot::class, 'student_answer_evaluation_id');    
    }

    public function gap_analysis_priority_fix()
    {
        return $this->hasMany(GapAnalysisPriorityFixes::class, 'student_answer_evaluation_id');    
    }

    public function model_answer()
    {
        return $this->hasMany(ModelAnswer::class, 'student_answer_evaluation_id');    
    }
}
