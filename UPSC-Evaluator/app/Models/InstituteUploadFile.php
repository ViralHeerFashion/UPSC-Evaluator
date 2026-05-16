<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\InstituteUploadBatch;

class InstituteUploadFile extends Model
{
    protected $table = 'institute_upload_files';

    public function upload_batch()
    {
        return $this->belongsTo(InstituteUploadBatch::class, 'institute_upload_batch_id', 'id');    
    }
}
