<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformasiSidang extends Model
{
    use HasFactory;

    protected $fillable = ['file_path', 'original_name'];
}
