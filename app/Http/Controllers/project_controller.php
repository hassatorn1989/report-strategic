<?php

namespace App\Http\Controllers;

use App\Models\tbl_budget;
use App\Models\tbl_project;
use App\Models\tbl_project_type;
use App\Models\tbl_year;
use App\Models\view_project;
use App\Models\view_year_strategic;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class project_controller extends Controller
{
    public function index(Request $request)
    {
        $year = tbl_year::where('year_status', 'active')->first();
        return view('project', compact('year'));
    }

    public function lists(Request $request)
    {
        $year = tbl_year::where('year_status', 'active')->first();
        $q = view_project::where('year_id', $year->id);
        return DataTables::eloquent($q)
            ->filter(function ($q) use ($request) {
                if ($request->filter_project_name != '') {
                    $q->whereRaw("project_name like '%{$request->filter_project_name}%'");
                }
            })
            ->addColumn('action', function ($q) {
                $action = '<a class="btn btn-info btn-sm waves-effect waves-light" href="' . route('project.manage', ['id' => $q->id]) . '"> <i class="fas fa-sliders-h"></i> ' . __('msg.btn_manage_project') . '</a> ';
                $action .= '<button class="btn btn-danger btn-sm waves-effect waves-light" onclick="destroy(\'' . $q->id . '\')"> <i class="fas fa-trash-alt"></i> ' . __('msg.btn_delete') . '</button> ';
                return $action;
            })
            ->rawColumns(['action'])
            ->make();
    }

    public function store(Request $request)
    {
        $request->validate([
            'project_name' => 'required',
            'year_id' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $q = new tbl_project();
            $q->project_name = $request->project_name;
            $q->year_id = $request->year_id;
            $q->project_status = 'draff';
            $q->save();
            DB::commit();
            return redirect()->route('project.manage', ['id' => $q->id])->with(['message' => __('msg.msg_create_success')]);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return back()->withError($e->getMessage())->withInput();
        }
    }

    public function edit(Request $request)
    {
        $q = tbl_project::find($request->id);
        return response()->json($q);
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'project_name' => 'required'
        ]);

        DB::beginTransaction();
        try {
            $q = tbl_project::find($request->id);
            $q->project_name = $request->project_name;
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
            $q = tbl_project::find($request->id);
            $q->delete();
            DB::commit();
            return response()->json(['status' => 'success']);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['status' => 'error']);
        }
    }

    public function manage(Request $request)
    {
        $project = view_project::with(
            [
                'get_project_responsible_person'
            ]
        )->find($request->id);
        $year_strategic = view_year_strategic::select('id', 'strategic_name', 'count_year_strategic_detail')->where('year_id', $project->year_id)->get();
        $budget = tbl_budget::all();
        $project_type = tbl_project_type::all();
        return view('project_manage', compact('project', 'year_strategic', 'budget', 'project_type'));
    }
}
