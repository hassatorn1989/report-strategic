<?php

namespace App\Http\Controllers;

use App\Models\tbl_strategic;
use App\Models\tbl_year;
use App\Models\tbl_year_strategic;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class year_controller extends Controller
{
    public function index(Request $request)
    {
        return view('year');
    }

    public function lists(Request $request)
    {
        $q = tbl_year::query();
        return DataTables::eloquent($q)
            ->filter(function ($q) use ($request) {
                if ($request->filter_year_name != '') {
                    $q->whereRaw("year_name like '%{$request->filter_year_name}%'");
                }
            })
            ->addColumn('year_status', function ($q) {
                return $q->year_status == 'active' ? '<span class="badge badge-success">' . __('msg.year_status_active') . '</span>' : '<span class="badge badge-danger">' . __('msg.year_status_inactive') . '</span>';
            })
            ->addColumn('action', function ($q) {
                $action = '<button class="btn btn-warning btn-sm waves-effect waves-light" data-toggle="modal" data-target="#modal-default"onclick="edit_data(\'' . $q->id . '\')"> <i class="fas fa-edit"></i> ' . __('msg.btn_edit') . '</button> ';
                $action .= '<button class="btn btn-danger btn-sm waves-effect waves-light" data-toggle="modal" data-target="#modal-default-detail" onclick="destroy(\'' . $q->id . '\')"> <i class="fas fa-trash-alt"></i> ' . __('msg.btn_delete') . '</button> ';
                return $action;
            })
            ->rawColumns(['year_status', 'action'])
            ->make();
    }

    public function store(Request $request)
    {
        $request->validate([
            'year_name' => 'required',
            'year_status' => 'required'
        ]);

        DB::beginTransaction();
        try {
            if ($request->year_status == 'active') {
                tbl_year::where('id', '!=', 0)->update(['year_status' => 'inactive']);
            }
            $q = new tbl_year();
            $q->year_name = $request->year_name;
            $q->year_status = $request->year_status;
            $q->save();

            if (!empty($request->strategic_id)) {
                foreach ($request->strategic_id as $value) {
                    $q1 = new tbl_year_strategic();
                    $q1->year_id = $q->id;
                    $q1->strategic_id = $value;
                    $q1->save();
                }
            }

            DB::commit();
            return redirect()->back()->with(['message' => __('msg.msg_create_success')]);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return back()->withError($e->getMessage())->withInput();
        }
    }

    public function edit(Request $request)
    {
        $year = tbl_year::find($request->id);
        $strategic = tbl_strategic::selectRaw(
            "*, (select count(id) from tbl_year_strategic where year_id = '{$request->id}' and strategic_id = tbl_strategic.id) as count_strategic"
        )->get();
        return response()->json(compact('year', 'strategic'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'year_name' => 'required',
            'year_status' => 'required'
        ]);

        DB::beginTransaction();
        try {
            if ($request->year_status == 'active') {
                tbl_year::where('id', '!=', 0)->update(['year_status' => 'inactive']);
            }
            $q = tbl_year::find($request->id);
            $q->year_name = $request->year_name;
            $q->year_status = $request->year_status;
            $q->save();

            tbl_year_strategic::where('year_id', $request->id)->delete();
            if (!empty($request->strategic_id)) {
                foreach ($request->strategic_id as $value) {
                    $q1 = new tbl_year_strategic();
                    $q1->year_id = $q->id;
                    $q1->strategic_id = $value;
                    $q1->save();
                }
            }

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
            $q = tbl_year::find($request->id);
            $q->delete();

            tbl_year_strategic::where('year_id', $request->id)->delete();

            DB::commit();
            return response()->json(['status' => 'success']);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['status' => 'error']);
        }
    }

    public function get_strategic(Request $request)
    {
        $q = tbl_strategic::all();
        return response()->json($q);
    }
}
