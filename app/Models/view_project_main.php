<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class view_project_main extends Model
{
    use HasFactory;
    protected $table = 'view_project_main';

    public function get_project_main_faculty()
    {
        return $this->hasMany(view_project_main_faculty::class, 'project_main_id', 'id');
    }
}
