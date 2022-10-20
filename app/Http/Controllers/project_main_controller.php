<?php

namespace App\Http\Controllers;

use App\Models\tbl_faculty;
use App\Models\tbl_project_main;
use App\Models\tbl_project_main_faculty;
use App\Models\tbl_project_main_type;
use App\Models\tbl_year;
use App\Models\view_project_main;
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
        $q = view_project_main::where('year_id', $year->id);
        return DataTables::eloquent($q)
            ->filter(function ($q) use ($request) {
                if ($request->filter_project_main_name != '') {
                    $q->whereRaw("project_main_name like '%{$request->filter_project_main_name}%'");
                }
            })
            ->addColumn('project_main_budget', function ($q) {
                return num1($q->project_main_budget);
            })
            ->addColumn('strategic_name', function ($q) {
                $data = $q->strategic_name;
                $data .= ($q->year_strategic_detail_id != '') ? '<br><small><strong>' . __('msg.sub_strategic') . ' : </strong>' . $q->year_strategic_detail_detail . '</small>' : '';
                return $data;
            })
            ->addColumn('action', function ($q) {
                $action = '<button class="btn btn-warning btn-sm waves-effect waves-light" data-toggle="modal" data-target="#modal-default" onclick="edit_data(\'' . $q->id . '\')"> <i class="fas fa-edit"></i> ' . __('msg.btn_edit') . '</button> ';
                $action .= '<button class="btn btn-danger btn-sm waves-effect waves-light" data-toggle="modal"  onclick="destroy(\'' . $q->id . '\')"> <i class="fas fa-trash-alt"></i> ' . __('msg.btn_delete') . '</button> ';
                return $action;
            })
            ->rawColumns(['strategic_name', 'action'])
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
            'year_id' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $q = new tbl_project_main();
            $q->year_id = $request->year_id;
            $q->project_main_name = $request->project_main_name;
            $q->project_main_budget = $request->project_main_budget;
            $q->project_main_guidelines = nl2br($request->project_main_guidelines);
            $q->project_main_target = nl2br($request->project_main_target);
            $q->faculty_id = $request->faculty_id;
            $q->project_main_type_id = $request->project_main_type_id;
            $q->year_strategic_id = $request->year_strategic_id;
            $q->year_strategic_detail_id = (!empty($request->year_strategic_detail_id)) ? $request->year_strategic_detail_id : null;
            $q->save();

            if (count($request->faculty_join_id) > 0) {
                foreach ($request->faculty_join_id as $key => $value) {
                    $q1 = new tbl_project_main_faculty();
                    $q1->project_main_id = $q->id;
                    $q1->faculty_id = $value;
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
        $project_main = tbl_project_main::with('get_year_strategic_detail')->find($request->id);
        $faculty = tbl_faculty::selectRaw("
        *,
        (select count(*) from tbl_project_main_faculty where tbl_project_main_faculty.project_main_id = {$request->id} and tbl_project_main_faculty.faculty_id = tbl_faculty.id) as faculty_join
        ")->get();
        return response()->json(compact('project_main', 'faculty'));
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
            'year_strategic_id' => 'required',
            'year_id' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $q = tbl_project_main::find($request->id);
            $q->year_id = $request->year_id;
            $q->project_main_name = $request->project_main_name;
            $q->project_main_budget = $request->project_main_budget;
            $q->project_main_guidelines = nl2br($request->project_main_guidelines);
            $q->project_main_target = nl2br($request->project_main_target);
            $q->faculty_id = $request->faculty_id;
            $q->project_main_type_id = $request->project_main_type_id;
            $q->year_strategic_id = $request->year_strategic_id;
            $q->year_strategic_detail_id = (!empty($request->year_strategic_detail_id)) ? $request->year_strategic_detail_id : null;
            $q->save();

            tbl_project_main_faculty::where('project_main_id', $request->id)->delete();
            if (count($request->faculty_join_id) > 0) {
                foreach ($request->faculty_join_id as $key => $value) {
                    $q1 = new tbl_project_main_faculty();
                    $q1->project_main_id = $q->id;
                    $q1->faculty_id = $value;
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

    public function check_budget(Request $request)
    {
        $project_main_type = tbl_project_main_type::find($request->id);
        $sql = "SELECT
            IFNULL((SUM(tbl_project_main.project_main_budget)),0) as project_main_budget
        FROM
            tbl_project_main WHERE tbl_project_main.project_main_type_id = '{$request->id}'";
        $q = DB::selectOne($sql);
        $sum = $q->project_main_budget + $request->project_main_budget;
        echo ($sum > $project_main_type->project_main_type_budget) ? 'false' : 'true';

    }
}