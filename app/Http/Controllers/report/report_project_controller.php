<?php

namespace App\Http\Controllers\report;

use App\Http\Controllers\Controller;
use App\Models\tbl_year;
use App\Models\view_project;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class report_project_controller extends Controller
{
    public function index()
    {
        return view('report.report_project');
    }

    public function lists(Request $request)
    {
        $year = tbl_year::where('year_status', 'active')->first();
        $q = view_project::with(
            [
                'get_project_responsible_person',
                'get_project_target_group',
                'get_project_problem',
                'get_project_problem_solution',
                'get_project_quantitative_indicators',
                'get_project_qualitative_indicators',
                'get_project_output',
                'get_project_outcome',
                'get_project_location',
                'get_project_impact',
                'get_year_strategic_detail',
            ]
        )
            ->where('project_status', 'publish')
            ->where('year_id', $year->id);
        return DataTables::eloquent($q)
            ->filter(function ($q) use ($request) {
                if ($request->filter_project_name != '') {
                    $q->whereRaw("project_name like '%{$request->filter_project_name}%'");
                }
            })
            ->addColumn('project_budget', function ($q) {
                return num1($q->project_budget);
            })
            ->addColumn('action', function ($q) {
                $action = '<a class="btn btn-info btn-sm waves-effect waves-light" href="' . route('project.manage', ['id' => $q->id]) . '"> <i class="fas fa-sliders-h"></i> ' . __('msg.btn_manage_project') . '</a> ';
                $action .= '<button class="btn btn-danger btn-sm waves-effect waves-light" onclick="destroy(\'' . $q->id . '\')"> <i class="fas fa-trash-alt"></i> ' . __('msg.btn_delete') . '</button> ';
                return $action;
            })
            ->rawColumns(['project_status', 'project_percentage', 'action'])
            ->make();
    }
}
