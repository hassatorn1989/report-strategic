<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_project_output extends Model
{
    use HasFactory;

    protected $table = 'tbl_project_output';

    public function get_project_output_gallery()
    {
        return $this->hasMany(tbl_project_output_gallery::class, 'project_output_id', 'id');
    }

    public function get_project_output_detail()
    {
        return $this->hasMany(tbl_project_output_detail::class, 'project_output_id', 'id');
    }
}
