<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\{
    Language,
    Subject,
    InstituteUploadFile,
    Institute
};

class InstituteUploadBatch extends Model
{
    protected $table = 'institute_upload_batches';
    public $timestamps = false;

    public function institute()
    {
        return $this->belongsTo(Institute::class, 'institute_id', 'id');    
    }

    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id', 'id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'id');    
    }
    
    public function files()
    {
        return $this->hasMany(InstituteUploadFile::class, 'institute_upload_batch_id', 'id');    
    }
}
