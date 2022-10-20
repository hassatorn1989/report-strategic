<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_year_strategic_detail extends Model
{
    use HasFactory;

    protected $table = 'tbl_year_strategic_detail';

    public function get_project()
    {
        return $this->hasMany(view_project::class, 'year_strategic_detail_id', 'id');
    }

    public function get_project1()
    {
        return $this->get_project()->where('budget_id', '2');
    }
    public function get_project2()
    {
        return $this->get_project()->where('budget_id', '3');
    }
    public function get_project3()
    {
        return $this->get_project()->where('budget_id', '4');
    }

}
