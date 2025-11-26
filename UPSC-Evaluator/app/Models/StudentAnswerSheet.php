<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\{
    StudentAnswerEvaluation,
    Language
};

class StudentAnswerSheet extends Model
{
    protected $table = 'student_answersheet';

    public function student_answer_evaluation()
    {
        return $this->hasMany(StudentAnswerEvaluation::class, 'student_answersheet_id', 'id');    
    }

    public function language()
    {
        return $this->hasOne(Language::class, 'id', 'language_id');    
    }
}
