<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Simpanan extends Model
{
    protected $table = 'simpanans';

    protected $fillable = [
        'user_id',
        'jenis_simpanan',
        'jumlah',
        'tanggal_transaksi',
        'keterangan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
