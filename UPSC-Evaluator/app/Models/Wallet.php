<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\{
    Recharge,
    Institute
};

class Wallet extends Model
{
    protected $table = 'wallet';

    public function institute()
    {
        return $this->belongsTo(Institute::class, 'institute_id');    
    }

    public function recharge()
    {
        return $this->belongsTo(Recharge::class, 'recharge_id');
    }
}
