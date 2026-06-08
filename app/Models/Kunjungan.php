<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kunjungan extends Model
{
    use HasFactory;

    protected $fillable = [
        'antrian_id',
        'warga_binaan_id',
        'nama_warga_binaan_manual',
        'status_verifikasi',
        'catatan',
    ];

    public function antrian()
    {
        return $this->belongsTo(Antrian::class);
    }

    public function wargaBinaan()
    {
        return $this->belongsTo(WargaBinaan::class);
    }
}
