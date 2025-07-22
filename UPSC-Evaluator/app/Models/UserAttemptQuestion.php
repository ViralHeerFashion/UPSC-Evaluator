<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\{
	ScreeningQuestion
};

class UserAttemptQuestion extends Model
{
    protected $table = 'user_attempt_questions';

    public function screening_questions()
    {
    	return $this->belongsTo(ScreeningQuestion::class, 'question_id', 'id');
    }
}
