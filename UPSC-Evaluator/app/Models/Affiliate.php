<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\{
    User
};

class Affiliate extends Model
{
    public function students()
    {
        return $this->hasMany(User::class, 'affiliate_id');    
    }
}
