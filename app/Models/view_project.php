<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class view_project extends Model
{
    use HasFactory;

    protected $table = 'view_project';

    public function get_project_responsible_person()
    {
        return $this->hasMany(tbl_project_responsible_person::class, 'project_id', 'id');
    }
}
