<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class jadwalModel extends Model
{
    protected $table = 'jadwal';

    protected $fillable = [
        'jam_mulai',
        'jam_selesai',
        'status',
    ];

    public function lapangan()
    {
        return $this->belongsTo(lapanganModel::class, 'id_jadwal');
    }
}
