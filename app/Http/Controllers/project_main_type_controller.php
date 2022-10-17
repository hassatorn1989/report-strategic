<?php

namespace App\Http\Controllers;

use App\Models\tbl_project_main_type;
use App\Models\tbl_year;
use App\Models\view_project_main_type;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class project_main_type_controller extends Controller
{
    public function index(Request $request)
    {
        $year = tbl_year::where('year_status', 'active')->first();
        return view('project_main_type', compact('year'));
    }

    public function lists(Request $request)
    {
        $year = tbl_year::where('year_status', 'active')->first();
        $q = view_project_main_type::where('year_id', $year->id);
        return DataTables::eloquent($q)
            ->filter(function ($q) use ($request) {
                if ($request->filter_project_main_type_name != '') {
                    $q->whereRaw("project_main_type_name like '%{$request->filter_project_main_type_name}%'");
                }
            })
            ->addColumn('project_main_type_budget', function ($q) {
                return num1($q->project_main_type_budget);
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
            'project_main_type_name' => 'required',
            'project_main_type_budget' => 'required',
            'year_id' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $q = new tbl_project_main_type();
            $q->project_main_type_name = $request->project_main_type_name;
            $q->project_main_type_budget = $request->project_main_type_budget;
            $q->year_id = $request->year_id;
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
        $q = tbl_project_main_type::find($request->id);
        return response()->json($q);
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'project_main_type_name' => 'required',
            'project_main_type_budget' => 'required',
            'year_id' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $q = tbl_project_main_type::find($request->id);
            $q->project_main_type_name = $request->project_main_type_name;
            $q->project_main_type_budget = $request->project_main_type_budget;
            $q->year_id = $request->year_id;
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
            $q = tbl_project_main_type::find($request->id);
            $q->delete();
            DB::commit();
            return response()->json(['status' => 'success']);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['status' => 'error']);
        }
    }
}
