<?php

namespace App\Http\Controllers;

use App\Models\tbl_year;
use App\Models\view_project;
use App\Models\view_year_strategic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class home_controller extends Controller
{
    public function index()
    {
        $year = tbl_year::where('year_status', 'active')->first();
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

        $year_strategic = view_year_strategic::with([
            'get_project' => function ($query) {
                $query->where('project_status', 'publish');
            },
            'get_year_strategic_detail' => function ($query) {
                $query->with([
                    'get_project' => function ($query) {
                        $query->where('project_status', 'publish');
                    }
                ]);
            }
        ])->where('year_id', $year->id)->get();
        return view('report.home', compact('data1', 'data2', 'year', 'year_strategic'));
    }

    public function get_project(Request $request)
    {
        $project1 = view_project::where('year_strategic_id', $request->year_strategic_id)
        ->where('project_status', 'publish')
        ->where('budget_id', '2')
        ->get();
        $project2 = view_project::where('year_strategic_id', $request->year_strategic_id)
        ->where('project_status', 'publish')
        ->where('budget_id', '3')
        ->get();
        $project3 = view_project::where('year_strategic_id', $request->year_strategic_id)
        ->where('project_status', 'publish')
        ->where('budget_id', '4')
        ->get();
        return response()->json(compact('project1', 'project2', 'project3'));
    }

    public function get_project_detail(Request $request)
    {
        $project1 = view_project::where('year_strategic_detail_id', $request->year_strategic_detail_id)
        ->where('project_status', 'publish')
        ->where('budget_id', '2')
        ->get();
        $project2 = view_project::where('year_strategic_detail_id', $request->year_strategic_detail_id)
        ->where('project_status', 'publish')
        ->where('budget_id', '3')
        ->get();
        $project3 = view_project::where('year_strategic_detail_id', $request->year_strategic_detail_id)
        ->where('project_status', 'publish')
        ->where('budget_id', '4')
        ->get();
        return response()->json(compact('project1', 'project2', 'project3'));
    }
}
