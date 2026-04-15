<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pinjaman extends Model
{
    protected $table = 'pinjamans';

    protected $fillable = [
        'user_id',
        'jumlah_pinjaman',
        'tenor',
        'bunga',
        'status',
        'tanggal_pengajuan',
        'keterangan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function angsurans()
    {
        return $this->hasMany(Angsuran::class);
    }
}
