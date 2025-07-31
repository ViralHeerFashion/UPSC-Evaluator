<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\{
    StudentAnswerEvaluation
};

class StudentAnswerSheet extends Model
{
    protected $table = 'student_answersheet';

    public function student_answer_evaluation()
    {
        return $this->hasMany(StudentAnswerEvaluation::class, 'student_answersheet_id', 'id');    
    }
}
