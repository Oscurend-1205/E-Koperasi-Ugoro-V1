<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable = [
        'nia', 
        'name', 
        'deposit_pokok', 
        'deposit_wajib', 
        'deposit_monosuko', 
        'deposit_dpu', 
        'deposit_total'
    ];
}
