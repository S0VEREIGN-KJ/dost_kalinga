<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PstcoKalinga extends Model
{
    protected $table = 'pstco_kalinga'; // Make sure it matches your table name

    protected $fillable = [
        'name',
        'description',
        'latitude',
        'longitude'
    ];
}

