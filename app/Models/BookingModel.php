<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingModel extends Model
{
    protected $table = 'booking';

    protected $fillable = [
        'id_pembayaran',
        'id_jadwal',
        'tanggal',
        'sub_total',

    ];
}
