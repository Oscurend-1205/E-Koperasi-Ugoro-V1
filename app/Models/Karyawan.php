<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    protected $fillable = [
        'name',
        'position',
        'type',
        'nip',
        'photo',
        'status',
        'bio',
        'order_num'
    ];
}
