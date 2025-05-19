<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class transaksiModel extends Model
{
    protected $table = 'pembayaran';

    protected $fillable = [
        'user_id',
        'tanggal',
        'total_harga',
        'status',
        'metode',
        'snap_token'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'total_harga' => 'integer'
    ];
}
