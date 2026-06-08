<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Antrian extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_antrian',
        'nomor_antrian',
        'nama',
        'jenis_kelamin',
        'nik',
        'foto_identitas',
        'alamat',
        'no_tlp',
        'hubungan',
        'tanggal_kunjungan',
        'sesi_id',
        'status',
    ];

    public function sesi()
    {
        return $this->belongsTo(Sesi::class);
    }

    public function kunjungan()
    {
        return $this->hasOne(Kunjungan::class);
    }
}
