<?php

namespace App\Http\Controllers;

use App\Models\tbl_driven;
use App\Models\tbl_year;
use App\Models\view_driven;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class driven_controller extends Controller
{
    public function index(Request $request)
    {
        $year = tbl_year::where('year_status', 'active')->first();
        $year_all = tbl_year::all();
        $driven = view_driven::where('year_id', $year->id)->get();
        return view('driven', compact('year_all', 'year', 'driven'));
    }

    public function lists(Request $request)
    {
        $q = tbl_driven::query();
        return DataTables::eloquent($q)
            ->filter(function ($q) use ($request) {
                if ($request->filter_driven_name != '') {
                    $q->whereRaw("driven_name like '%{$request->filter_driven_name}%'");
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
            'driven_key_indicator' => 'required',
            'year_id' => 'required',
            'year_id_compare' => 'required',
            'driven_detail' => 'required',
            'driven_detail_compare' => 'required',
            'driven_change' => 'required',
            'driven_type' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $q = new tbl_driven();
            $q->driven_key_indicator = $request->driven_key_indicator;
            $q->year_id = $request->year_id;
            $q->driven_detail = $request->driven_detail;
            $q->year_id_compare = $request->year_id_compare;
            $q->driven_detail_compare = $request->driven_detail_compare;
            $q->driven_change = $request->driven_change;
            $q->driven_type = $request->driven_type;
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
        $q = tbl_driven::find($request->id);
        return response()->json($q);
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'driven_key_indicator' => 'required',
            'year_id' => 'required',
            'driven_detail' => 'required',
            'year_id_compare' => 'required',
            'driven_detail_compare' => 'required',
            'driven_change' => 'required',
            'driven_type' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $q = tbl_driven::find($request->id);
            $q->driven_key_indicator = $request->driven_key_indicator;
            $q->year_id = $request->year_id;
            $q->driven_detail = $request->driven_detail;
            $q->year_id_compare = $request->year_id_compare;
            $q->driven_detail_compare = $request->driven_detail_compare;
            $q->driven_change = $request->driven_change;
            $q->driven_type = $request->driven_type;
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
            $q = tbl_driven::find($request->id);
            $q->delete();
            DB::commit();
            return response()->json(['status' => 'success']);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['status' => 'error']);
        }
    }
}
