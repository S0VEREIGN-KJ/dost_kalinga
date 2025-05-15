<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coordinate extends Model
{
    use HasFactory;

    protected $table = 'coordinates'; // or your actual coordinates table name

    protected $primaryKey = 'loc_id';

    public $timestamps = false;

    protected $fillable = ['latitude', 'longitude'];
}
