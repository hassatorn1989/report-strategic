<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\view_project_main;
use App\Models\tbl_year;
use App\Models\view_project_main_faculty;

class test_controller extends Controller
{
    public function index()
    {

        // $year = tbl_year::where('year_status', 'active')->first();
        // $cond = "
        //     AND (SELECT COUNT(tbl_project_main_faculty.id) FROM `tbl_project_main_faculty` WHERE tbl_project_main_faculty.faculty_id = '" . auth()->user()->faculty_id . "' and tbl_project_main_faculty.project_main_id = view_project_main.id)";
        $q = view_project_main::take(1)->with('get_project_main_faculty')->get();
        dd($q);
    }
}
