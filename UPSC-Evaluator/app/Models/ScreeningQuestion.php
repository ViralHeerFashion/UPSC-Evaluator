<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\UserAttemptQuestion;

class ScreeningQuestion extends Model
{
    protected $table = 'screening_question';
    public $timestamps = false;

    public function user_attempt_question()
    {
        return $this->hasOne(UserAttemptQuestion::class, 'question_id', 'id');    
    }
}
