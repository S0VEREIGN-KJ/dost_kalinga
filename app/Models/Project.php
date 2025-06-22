<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $table = 'tbl_kalinga';

    protected $primaryKey = 'proj_id';

    public $timestamps = false;

    protected $fillable = [
        'proj_loc',
        'proj_name',
        'proj_desc',
        'org_name',
        'proj_type',
        'proj_municipality',
        'proj_address',
        'sector',
        'status',
        'proj_created'
    ];

    public function coordinate()
    {
        return $this->belongsTo(Coordinate::class, 'proj_loc', 'loc_id');
    }

    public function scopeByMunicipality($query, $municipality)
    {
        return $query->where('proj_municipality', $municipality);
    }

    // Scope to get active projects
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
