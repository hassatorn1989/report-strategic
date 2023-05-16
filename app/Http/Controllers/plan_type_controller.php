<?php

namespace App\Http\Controllers;

use App\Models\tbl_plan_type;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class plan_type_controller extends Controller
{
    public function index(Request $request)
    {
        return view('plan_type');
    }

    public function lists(Request $request)
    {
        $q = tbl_plan_type::query();
        return DataTables::eloquent($q)
            ->filter(function ($q) use ($request) {
                if ($request->filter_plan_type_name != '') {
                    $q->whereRaw("plan_type_name like '%{$request->filter_plan_type_name}%'");
                }
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
            'plan_type_name' => 'required'
        ]);

        DB::beginTransaction();
        try {
            $q = new tbl_plan_type();
            $q->plan_type_name = $request->plan_type_name;
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
        $q = tbl_plan_type::find($request->id);
        return response()->json($q);
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'plan_type_name' => 'required'
        ]);

        DB::beginTransaction();
        try {
            $q = tbl_plan_type::find($request->id);
            $q->plan_type_name = $request->plan_type_name;
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
            $q = tbl_plan_type::find($request->id);
            $q->delete();
            DB::commit();
            return response()->json(['status' => 'success']);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['status' => 'error']);
        }
    }
}
