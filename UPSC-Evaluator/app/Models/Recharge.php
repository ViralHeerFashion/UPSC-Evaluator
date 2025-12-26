<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\{
    Institute,
    Wallet
};

class Recharge extends Model
{
    protected $table = "recharge";

    public function institute()
    {
        return $this->hasOne(Institute::class, 'id', 'institute_id');    
    }

    public function total_fund()
    {
        return true;
    }
}
