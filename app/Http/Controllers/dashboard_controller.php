<?php

namespace App\Http\Controllers;

use App\Models\tbl_year;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class dashboard_controller extends Controller
{
    public function index()
    {
        $year = tbl_year::where('year_status', 'active')->first();
        // $cond = ;
        $sql1 = "SELECT
        IFNULL((SELECT COUNT(tbl_project.id) FROM `tbl_project` WHERE tbl_project.project_status = 'publish' AND tbl_project.year_id = '{$year->id}'),0) as count_project,
        IFNULL((SELECT SUM(tbl_project.project_budget) FROM `tbl_project` WHERE tbl_project.project_status = 'publish' AND tbl_project.year_id = '{$year->id}'),0) as sum_budget,
        IFNULL((SELECT COUNT(tbl_faculty.id) FROM `tbl_faculty`),0) as count_faculty";
        $data1 = DB::selectOne($sql1);

        $sql2 = "SELECT
        *,
        (SELECT COUNT(id) FROM `tbl_project` WHERE tbl_project.faculty_id = tbl_faculty.id AND tbl_project.project_status = 'publish' AND tbl_project.year_id = '{$year->id}') AS count_project,
        IFNULL((SELECT SUM(tbl_project.project_budget) FROM `tbl_project` WHERE tbl_project.faculty_id = tbl_faculty.id AND tbl_project.project_status = 'publish' AND tbl_project.year_id = '{$year->id}'),0) as sum_budget
        FROM `tbl_faculty`";
        $data2 = DB::select($sql2);
        return view('dashboard', compact('data1', 'data2', 'year'));
    }
}
