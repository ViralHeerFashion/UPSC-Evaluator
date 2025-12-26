<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\{
    User
};

class StudentSheet extends Model
{
    protected $table = 'student_sheet';

    public function users()
    {
        return $this->hasMany(User::class, 'institute_id');    
    }
}
