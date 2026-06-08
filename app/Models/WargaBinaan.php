<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WargaBinaan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'no_registrasi',
        'blok',
        'keterangan',
        'tgl_msk_upt',
        'tgl_ekspirasi',
        'nm_alias_1',
        'nm_alias_2',
        'nm_alias_3',
        'nm_kecil_1',
        'nm_kecil_2',
        'nm_kecil_3',
        'lokasi_sel',
    ];

    public function kunjungans()
    {
        return $this->hasMany(Kunjungan::class);
    }
}
