<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tbl_budget;
use DataTables;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class budget_controller extends Controller
{
    public function index(Request $request)
    {
        return view('budget');
    }

    public function lists(Request $request)
    {
        $q = tbl_budget::query();
        return DataTables::eloquent($q)
            ->filter(function ($q) use ($request) {
                if ($request->filter_budget_name != '') {
                    $q->whereRaw("budget_name like '%{$request->filter_budget_name}%'");
                }
            })
            ->addColumn('budget_specify_status', function ($q) {
                return $q->budget_specify_status == 'active' ? '<span class="badge badge-success">ระบุข้อมูล</span>' : '<span class="badge badge-danger">ไม่ระบุข้อมูล</span>';
            })
            ->addColumn('action', function ($q) {
                $action = '<button class="btn btn-warning btn-sm waves-effect waves-light" data-toggle="modal" data-target="#modal-default"onclick="edit_data(\'' . $q->id . '\')"> <i class="fas fa-edit"></i> ' . __('msg.btn_edit') . '</button> ';
                $action .= '<button class="btn btn-danger btn-sm waves-effect waves-light" data-toggle="modal"  onclick="destroy(\'' . $q->id . '\')"> <i class="fas fa-trash-alt"></i> ' . __('msg.btn_delete') . '</button> ';
                return $action;
            })
            ->rawColumns(['budget_specify_status', 'action'])
            ->make();
    }

    public function store(Request $request)
    {
        $request->validate([
            'budget_name' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $q = new tbl_budget();
            $q->budget_name = $request->budget_name;
            $q->budget_specify_status = (!empty($request->budget_specify_status)) ? 'active' : 'inactive';
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
        $q = tbl_budget::find($request->id);
        return response()->json($q);
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'budget_name' => 'required'
        ]);

        DB::beginTransaction();
        try {
            $q = tbl_budget::find($request->id);
            $q->budget_name = $request->budget_name;
            $q->budget_specify_status = (!empty($request->budget_specify_status)) ? 'active' : 'inactive';
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
            $q = tbl_budget::find($request->id);
            $q->delete();
            DB::commit();
            return response()->json(['status' => 'success']);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['status' => 'error']);
        }
    }
}
