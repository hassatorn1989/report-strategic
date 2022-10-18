<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_project_main extends Model
{
    use HasFactory;
    protected $table = 'tbl_project_main';

    public function get_year_strategic_detail()
    {
        return $this->hasMany(tbl_year_strategic_detail::class, 'year_strategic_id', 'year_strategic_id');
    }
}
