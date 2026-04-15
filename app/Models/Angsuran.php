<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Angsuran extends Model
{
    protected $table = 'angsurans';

    protected $fillable = [
        'pinjaman_id',
        'angsuran_ke',
        'jumlah_bayar',
        'tanggal_bayar',
        'status',
    ];

    public function pinjaman()
    {
        return $this->belongsTo(Pinjaman::class);
    }
}
