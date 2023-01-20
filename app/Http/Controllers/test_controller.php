<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\view_project_main;
class test_controller extends Controller
{
    public function index()
    {
        $q = view_project_main::where('year_id', '1')->get();

        dd($q);

    }
}
