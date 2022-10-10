<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class view_project_location extends Model
{
    use HasFactory;
    protected $table = 'view_project_location';

    public function get_district()
    {
        return $this->hasMany(view_district::class, 'pcode', 'pcode');
    }

    public function get_subdistrict()
    {
        return $this->hasMany(view_subdistrict::class, 'acode', 'acode');
    }

    public function get_village()
    {
        return $this->hasMany(view_village::class, 'tcode', 'tcode');
    }
}
