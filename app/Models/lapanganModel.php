<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class lapanganModel extends Model
{
    protected $table = 'lapangan';

    protected $fillable = [
        'nama',
        'deskripsi',
        'ukuran',
        'tipe',
        'harga_per_jam',
        'status',
        'gambar',
    ];
}
