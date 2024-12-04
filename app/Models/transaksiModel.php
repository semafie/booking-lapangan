<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class transaksiModel extends Model
{
    protected $table = 'pembayaran';

    protected $fillable = [
        'id_user',
        'nama',
        'metode',
        'status',
        'bukti_pembayaran',
        'tanggal',
        'total_harga',
    ];
}
