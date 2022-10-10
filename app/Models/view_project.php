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

    public function get_project_target_group()
    {
        return $this->hasMany(tbl_project_target_group::class, 'project_id', 'id');
    }

    public function get_project_problem()
    {
        return $this->hasMany(tbl_project_problem::class, 'project_id', 'id');
    }

    function get_project_problem_solution()
    {
        return $this->hasMany(tbl_project_problem_solution::class, 'project_id', 'id');
    }

    function get_project_quantitative_indicators()
    {
        return $this->hasMany(tbl_project_quantitative_indicators::class, 'project_id', 'id');
    }

    function get_project_qualitative_indicators()
    {
        return $this->hasMany(tbl_project_qualitative_indicators::class, 'project_id', 'id');
    }

    function get_project_output()
    {
        return $this->hasMany(tbl_project_output::class, 'project_id', 'id');
    }

    function get_project_outcome()
    {
        return $this->hasMany(tbl_project_outcome::class, 'project_id', 'id');
    }

    function get_project_impact()
    {
        return $this->hasMany(tbl_project_impact::class, 'project_id', 'id');
    }

    function get_year_strategic_detail()
    {
        return $this->hasMany(tbl_year_strategic_detail::class, 'year_strategic_id', 'year_strategic_id');
    }

    function get_project_location()
    {
        return $this->hasMany(view_project_location::class, 'project_id', 'id');
    }
}
