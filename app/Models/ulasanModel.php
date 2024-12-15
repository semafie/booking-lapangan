<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ulasanModel extends Model
{
    protected $table = 'ulasan';

    protected $fillable = [
        'id_user',
        'komentar',
        'rating',

    ];
}
