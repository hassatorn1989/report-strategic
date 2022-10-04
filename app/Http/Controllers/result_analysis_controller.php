<?php

namespace App\Http\Controllers;

use App\Models\tbl_result_analysis;
use App\Models\tbl_year;
use App\Models\tbl_year_strategic;
use App\Models\view_year_strategic;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class result_analysis_controller extends Controller
{
    public function index()
    {
        $year = tbl_year::where('year_status', 'active')->first();
        $strategic = view_year_strategic::with(['get_result_analysis'])->where('year_id', $year->id)->get();
        // dd($strategic);
        return view('result_analysis', compact('strategic'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'year_strategic_id' => 'required',
            'swot_strength' => 'required',
            'swot_weakness' => 'required',
            'swot_opportunity' => 'required',
            'swot_threat' => 'required',
            'tow_so' => 'required',
            'tow_st' => 'required',
            'tow_wo' => 'required',
            'tow_wt' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $q = new tbl_result_analysis();
            $q->year_strategic_id = $request->year_strategic_id;
            $q->swot_strength = nl2br($request->swot_strength);
            $q->swot_weakness = nl2br($request->swot_weakness);
            $q->swot_opportunity = nl2br($request->swot_opportunity);
            $q->swot_threat = nl2br($request->swot_threat);
            $q->tow_so = nl2br($request->tow_so);
            $q->tow_st = nl2br($request->tow_st);
            $q->tow_wo = nl2br($request->tow_wo);
            $q->tow_wt = nl2br($request->tow_wt);
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
        $q = tbl_result_analysis::find($request->id);
        return response()->json($q);
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'year_strategic_id' => 'required',
            'swot_strength' => 'required',
            'swot_weakness' => 'required',
            'swot_opportunity' => 'required',
            'swot_threat' => 'required',
            'tow_so' => 'required',
            'tow_st' => 'required',
            'tow_wo' => 'required',
            'tow_wt' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $q = tbl_result_analysis::find($request->id);
            $q->year_strategic_id = $request->year_strategic_id;
            $q->swot_strength = nl2br($request->swot_strength);
            $q->swot_weakness = nl2br($request->swot_weakness);
            $q->swot_opportunity = nl2br($request->swot_opportunity);
            $q->swot_threat = nl2br($request->swot_threat);
            $q->tow_so = nl2br($request->tow_so);
            $q->tow_st = nl2br($request->tow_st);
            $q->tow_wo = nl2br($request->tow_wo);
            $q->tow_wt = nl2br($request->tow_wt);
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
            $q = tbl_result_analysis::find($request->id);
            $q->delete();
            DB::commit();
            return response()->json(['status' => 'success']);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['status' => 'error']);
        }
    }
}
