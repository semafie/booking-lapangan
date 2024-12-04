<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ulasanModel extends Model
{
    protected $table = 'ulasan';

    protected $fillable = [
        'user_id',
        'komentar',
        'rating',

    ];
}
