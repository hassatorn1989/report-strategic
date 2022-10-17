<?php

namespace App\Http\Controllers;

use App\Models\tbl_faculty;
use App\Models\tbl_project_main;
use App\Models\tbl_project_main_type;
use App\Models\tbl_year;
use App\Models\view_year_strategic;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class project_main_controller extends Controller
{
    public function index(Request $request)
    {
        $year = tbl_year::where('year_status', 'active')->first();
        $faculty = tbl_faculty::all();
        $project_main_type = tbl_project_main_type::where('year_id', $year->id)->get();
        $year_strategic = view_year_strategic::with('get_year_strategic_detail')->select('id', 'strategic_name', 'count_year_strategic_detail')->where('year_id', $year->id)->get();
        return view('project_main', compact('year', 'faculty', 'project_main_type', 'year_strategic'));
    }

    public function lists(Request $request)
    {
        $year = tbl_year::where('year_status', 'active')->first();
        $q = tbl_project_main::where('year_id', $year->id);
        return DataTables::eloquent($q)
            ->filter(function ($q) use ($request) {
                if ($request->filter_project_main_name != '') {
                    $q->whereRaw("project_main_name like '%{$request->filter_project_main_name}%'");
                }
            })
            ->addColumn('project_main_budget', function ($q) {
                return num1($q->project_main_budget);
            })
            ->addColumn('action', function ($q) {
                $action = '<button class="btn btn-warning btn-sm waves-effect waves-light" data-toggle="modal" data-target="#modal-default" onclick="edit_data(\'' . $q->id . '\')"> <i class="fas fa-edit"></i> ' . __('msg.btn_edit') . '</button> ';
                $action .= '<button class="btn btn-danger btn-sm waves-effect waves-light" data-toggle="modal"  onclick="destroy(\'' . $q->id . '\')"> <i class="fas fa-trash-alt"></i> ' . __('msg.btn_delete') . '</button> ';
                return $action;
            })
            ->rawColumns(['action'])
            ->make();
    }

    public function store(Request $request)
    {
        $request->validate([
            'project_main_name' => 'required',
            'project_main_budget' => 'required',
            'project_main_guidelines' => 'required',
            'project_main_target' => 'required',
            'faculty_id' => 'required',
            'project_main_type_id' => 'required',
            'year_strategic_id' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $q = new tbl_project_main();
            $q->project_main_name = $request->project_main_name;
            $q->project_main_budget = $request->project_main_budget;
            $q->project_main_guidelines = nl2br($request->project_main_guidelines);
            $q->project_main_target = nl2br($request->project_main_target);
            $q->faculty_id = $request->faculty_id;
            $q->project_main_type_id = $request->project_main_type_id;
            $q->year_strategic_id = $request->year_strategic_id;
            $q->save();
            DB::commit();
            return redirect()->back()->with(['message' => __('msg.msg_create_success')]);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return back()->withError($e->getMessage())->withInput();
        }
    }

    public function edit(Request $request)
    {
        $q = tbl_project_main::find($request->id);
        return response()->json($q);
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'project_main_name' => 'required',
            'project_main_budget' => 'required',
            'project_main_guidelines' => 'required',
            'project_main_target' => 'required',
            'faculty_id' => 'required',
            'project_main_type_id' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $q = tbl_project_main::find($request->id);
            $q->project_main_name = $request->project_main_name;
            $q->project_main_budget = $request->project_main_budget;
            $q->project_main_guidelines = nl2br($request->project_main_guidelines);
            $q->project_main_target = nl2br($request->project_main_target);
            $q->faculty_id = $request->faculty_id;
            $q->project_main_type_id = $request->project_main_type_id;
            $q->save();
            DB::commit();
            return redirect()->back()->with(['message' => __('msg.msg_update_success')]);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return back()->withError($e->getMessage())->withInput();
        }
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);
        DB::beginTransaction();
        try {
            $q = tbl_project_main::find($request->id);
            $q->delete();
            DB::commit();
            return response()->json(['status' => 'success']);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['status' => 'error']);
        }
    }

    public function get_faculty(Request $request)
    {
        $q = tbl_faculty::all();
        return response()->json($q);
    }
}
