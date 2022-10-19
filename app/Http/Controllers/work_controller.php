<?php

namespace App\Http\Controllers;

use App\Models\tbl_project;
use App\Models\tbl_work;
use App\Models\tbl_year;
use App\Models\view_work;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class work_controller extends Controller
{
    public function index()
    {
        $year = tbl_year::where('year_status', 'active')->first();
        $project = tbl_project::where('project_status', 'publish')->where('year_id', $year->id)->get();
        $year_all = tbl_year::all();
        $work = view_work::where('year_id', $year->id)->get();
        return view('work', compact('project', 'year_all', 'year', 'work'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'project_id' => 'required',
            'year_now_id' => 'required',
            'work_detail' => 'required',
            'year_id_compare' => 'required',
            'work_detail_compare' => 'required',
            'work_change' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $q = new tbl_work();
            $q->project_id = $request->project_id;
            $q->year_id = $request->year_now_id;
            $q->work_detail = nl2br($request->work_detail);
            $q->year_id_compare = $request->year_id_compare;
            $q->work_detail_compare = nl2br($request->work_detail_compare);
            $q->work_change = nl2br($request->work_change);
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
        $q = tbl_work::find($request->id);
        return response()->json($q);
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'project_id' => 'required',
            'year_now_id' => 'required',
            'work_detail' => 'required',
            'year_id_compare' => 'required',
            'work_detail_compare' => 'required',
            'work_change' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $q = tbl_work::find($request->id);
            $q->project_id = $request->project_id;
            $q->year_id = $request->year_now_id;
            $q->work_detail = nl2br($request->work_detail);
            $q->year_id_compare = $request->year_id_compare;
            $q->work_detail_compare = nl2br($request->work_detail_compare);
            $q->work_change = nl2br($request->work_change);
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
        $this->validate($request, [
            'id' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $q = tbl_work::find($request->id);
            $q->delete();
            DB::commit();
            return redirect()->back()->with(['message' => __('msg.msg_delete_success')]);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return back()->withError($e->getMessage())->withInput();
        }
    }
}
