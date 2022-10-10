<?php

namespace App\Http\Controllers;

use App\Models\tbl_budget;
use App\Models\tbl_location;
use App\Models\tbl_project;
use App\Models\tbl_project_impact;
use App\Models\tbl_project_location;
use App\Models\tbl_project_outcome;
use App\Models\tbl_project_output;
use App\Models\tbl_project_output_gallery;
use App\Models\tbl_project_problem;
use App\Models\tbl_project_problem_solution;
use App\Models\tbl_project_qualitative_indicators;
use App\Models\tbl_project_quantitative_indicators;
use App\Models\tbl_project_responsible_person;
use App\Models\tbl_project_target_group;
use App\Models\tbl_project_type;
use App\Models\tbl_year;
use App\Models\view_location;
use App\Models\view_project;
use App\Models\view_project_location;
use App\Models\view_project_output_gallery;
use App\Models\view_year_strategic;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
            'project_name' => 'required',
            'project_type_id' => 'required',
            'project_budget' => 'required',
            'project_period' => 'required',
            'year_strategic_id' => 'required',
            'budget_id' => 'required',
        ]);

        DB::beginTransaction();
        try {
            // dd($request->all());
            $project_period = explode(' - ', $request->project_period);
            $project_period_start = date('Y-m-d', strtotime(str_replace('/', '-', $project_period[0])));
            $project_period_end = date('Y-m-d', strtotime(str_replace('/', '-', $project_period[1])));

            $q = tbl_project::find($request->id);
            $q->project_name = $request->project_name;
            $q->project_type_id = $request->project_type_id;
            $q->project_budget = $request->project_budget;
            $q->project_period_start = $project_period_start;
            $q->project_period_end = $project_period_end;
            $q->year_strategic_id = $request->year_strategic_id;
            $q->year_strategic_detail_id = (!empty($request->year_strategic_detail_id)) ? $request->year_strategic_detail_id : null;
            $q->budget_id = $request->budget_id;
            $q->budget_specify_other = (!empty($request->budget_specify_other))  ? $request->budget_specify_other : null;
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
            $q1 = view_project_output_gallery::where('project_id', $request->id)->get();
            if ($q1->count() > 0) {
                foreach ($q1 as $key => $value) {
                    Storage::delete($value->project_output_gallery_path);
                }
            }
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
                'get_project_responsible_person' => function ($q) {
                    $q->orderBy('id', 'DESC');
                },
                'get_project_target_group' => function ($q) {
                    $q->orderBy('id', 'DESC');
                },
                'get_project_problem' => function ($q) {
                    $q->orderBy('id', 'DESC');
                },
                'get_project_problem_solution' => function ($q) {
                    $q->orderBy('id', 'DESC');
                },
                'get_project_quantitative_indicators' => function ($q) {
                    $q->orderBy('id', 'DESC');
                },
                'get_project_qualitative_indicators' => function ($q) {
                    $q->orderBy('id', 'DESC');
                },
                'get_project_output' => function ($q) {
                    $q->selectRaw("*,
                    (select count(*) from tbl_project_output_gallery where tbl_project_output_gallery.project_output_id = tbl_project_output.id) as total_gallery")
                        ->orderBy('id', 'DESC');
                },
                'get_project_outcome' => function ($q) {
                    $q->orderBy('id', 'DESC');
                },
                'get_project_location' => function ($q) {
                    $q->orderBy('id', 'DESC');
                },
                'get_year_strategic_detail',
            ]
        )->find($request->id);
        // dd($project);
        $year_strategic = view_year_strategic::with('get_year_strategic_detail')->select('id', 'strategic_name', 'count_year_strategic_detail')->where('year_id', $project->year_id)->get();
        $budget = tbl_budget::all();
        $project_type = tbl_project_type::all();
        $province = view_location::selectRaw("DISTINCT(pcode), pname")->orderBy('pcode', 'ASC')->get();
        return view('project_manage', compact('project', 'year_strategic', 'budget', 'project_type', 'province'));
    }


    public function manage_location_store(Request $request)
    {
        $request->validate([
            'project_id' => 'required',
            'pcode' => 'required',
            'acode' => 'required',
            'tcode' => 'required',
            'mcode' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $q = new tbl_project_location();
            $q->project_id = $request->project_id;
            $q->pcode = $request->pcode;
            $q->acode = $request->acode;
            $q->tcode = $request->tcode;
            $q->mcode = $request->mcode;
            $q->save();
            DB::commit();
            return redirect()->back()->with(['message' => __('msg.msg_create_success')]);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return back()->withError($e->getMessage())->withInput();
        }
    }

    public function manage_location_edit(Request $request)
    {
        $q = view_project_location::with(['get_district', 'get_subdistrict', 'get_village'])->find($request->id);
        return response()->json($q);
    }

    public function manage_location_update(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'pcode' => 'required',
            'acode' => 'required',
            'tcode' => 'required',
            'mcode' => 'required',
        ]);


        DB::beginTransaction();
        try {
            $q = tbl_project_location::find($request->id);
            $q->pcode = $request->pcode;
            $q->acode = $request->acode;
            $q->tcode = $request->tcode;
            $q->mcode = $request->mcode;
            $q->save();
            DB::commit();
            return redirect()->back()->with(['message' => __('msg.msg_update_success')]);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return back()->withError($e->getMessage())->withInput();
        }
    }

    public function manage_location_destroy(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);
        DB::beginTransaction();
        try {
            $q = tbl_project_location::find($request->id);
            $q->delete();
            DB::commit();
            return response()->json(['status' => 'success']);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['status' => 'error']);
        }
    }

    public function get_location_district(Request $request)
    {
        $q = view_location::selectRaw("DISTINCT(acode), aname")->whereRaw("substr(pcode,1,2) = {$request->pcode}")->orderBy('acode', 'ASC')->get();
        return response()->json($q);
    }

    public function get_location_subdistrict(Request $request)
    {
        $q = view_location::selectRaw("DISTINCT(tcode), tname")->whereRaw("substr(acode,1,4) = {$request->acode}")->orderBy('tcode', 'ASC')->get();
        return response()->json($q);
    }

    public function get_location_village(Request $request)
    {
        $q = view_location::selectRaw("DISTINCT(mcode), mname")->whereRaw("substr(tcode,1,6) = '" . substr($request->tcode, 0, 6) . "'")->orderBy('mcode', 'ASC')->get();
        return response()->json($q);
    }

    public function manage_responsible_person_store(Request $request)
    {
        $request->validate([
            'project_id' => 'required',
            'project_responsible_person_name' => 'required',
            'project_responsible_person_tel' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $q = new tbl_project_responsible_person();
            $q->project_responsible_person_name = $request->project_responsible_person_name;
            $q->project_responsible_person_tel = $request->project_responsible_person_tel;
            $q->project_id = $request->project_id;
            $q->save();
            DB::commit();
            return redirect()->back()->with(['message' => __('msg.msg_create_success')]);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return back()->withError($e->getMessage())->withInput();
        }
    }

    public function manage_responsible_person_edit(Request $request)
    {
        $q = tbl_project_responsible_person::find($request->id);
        return response()->json($q);
    }

    public function manage_responsible_person_update(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'project_id' => 'required',
            'project_responsible_person_name' => 'required',
            'project_responsible_person_tel' => 'required',
        ]);


        DB::beginTransaction();
        try {
            $q = tbl_project_responsible_person::find($request->id);
            $q->project_responsible_person_name = $request->project_responsible_person_name;
            $q->project_responsible_person_tel = $request->project_responsible_person_tel;
            $q->project_id = $request->project_id;
            $q->save();
            DB::commit();
            return redirect()->back()->with(['message' => __('msg.msg_update_success')]);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return back()->withError($e->getMessage())->withInput();
        }
    }

    public function manage_responsible_person_destroy(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);
        DB::beginTransaction();
        try {
            $q = tbl_project_responsible_person::find($request->id);
            $q->delete();
            DB::commit();
            return response()->json(['status' => 'success']);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['status' => 'error']);
        }
    }

    public function manage_target_group_store(Request $request)
    {
        $request->validate([
            'project_id' => 'required',
            'project_target_group_detail' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $q = new tbl_project_target_group();
            $q->project_target_group_detail = $request->project_target_group_detail;
            $q->project_id = $request->project_id;
            $q->save();
            DB::commit();
            return redirect()->back()->with(['message' => __('msg.msg_create_success')]);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return back()->withError($e->getMessage())->withInput();
        }
    }

    public function manage_target_group_edit(Request $request)
    {
        $q = tbl_project_target_group::find($request->id);
        return response()->json($q);
    }

    public function manage_target_group_update(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'project_id' => 'required',
            'project_target_group_detail' => 'required',
        ]);


        DB::beginTransaction();
        try {
            $q = tbl_project_target_group::find($request->id);
            $q->project_target_group_detail = $request->project_target_group_detail;
            $q->project_id = $request->project_id;
            $q->save();
            DB::commit();
            return redirect()->back()->with(['message' => __('msg.msg_update_success')]);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return back()->withError($e->getMessage())->withInput();
        }
    }

    public function manage_target_group_destroy(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);
        DB::beginTransaction();
        try {
            $q = tbl_project_target_group::find($request->id);
            $q->delete();
            DB::commit();
            return response()->json(['status' => 'success']);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['status' => 'error']);
        }
    }


    public function manage_problem_store(Request $request)
    {
        $request->validate([
            'project_id' => 'required',
            'project_problem_detail' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $q = new tbl_project_problem();
            $q->project_problem_detail = $request->project_problem_detail;
            $q->project_id = $request->project_id;
            $q->save();
            DB::commit();
            return redirect()->back()->with(['message' => __('msg.msg_create_success')]);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return back()->withError($e->getMessage())->withInput();
        }
    }

    public function manage_problem_edit(Request $request)
    {
        $q = tbl_project_problem::find($request->id);
        return response()->json($q);
    }

    public function manage_problem_update(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'project_id' => 'required',
            'project_problem_detail' => 'required',
        ]);


        DB::beginTransaction();
        try {
            $q = tbl_project_problem::find($request->id);
            $q->project_problem_detail = $request->project_problem_detail;
            $q->project_id = $request->project_id;
            $q->save();
            DB::commit();
            return redirect()->back()->with(['message' => __('msg.msg_update_success')]);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return back()->withError($e->getMessage())->withInput();
        }
    }

    public function manage_problem_destroy(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);
        DB::beginTransaction();
        try {
            $q = tbl_project_problem::find($request->id);
            $q->delete();
            DB::commit();
            return response()->json(['status' => 'success']);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['status' => 'error']);
        }
    }

    public function manage_problem_solution_store(Request $request)
    {
        $request->validate([
            'project_id' => 'required',
            'project_problem_solution_detail' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $q = new tbl_project_problem_solution();
            $q->project_problem_solution_detail = $request->project_problem_solution_detail;
            $q->project_id = $request->project_id;
            $q->save();
            DB::commit();
            return redirect()->back()->with(['message' => __('msg.msg_create_success')]);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return back()->withError($e->getMessage())->withInput();
        }
    }

    public function manage_problem_solution_edit(Request $request)
    {
        $q = tbl_project_problem_solution::find($request->id);
        return response()->json($q);
    }

    public function manage_problem_solution_update(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'project_id' => 'required',
            'project_problem_solution_detail' => 'required',
        ]);


        DB::beginTransaction();
        try {
            $q = tbl_project_problem_solution::find($request->id);
            $q->project_problem_solution_detail = $request->project_problem_solution_detail;
            $q->project_id = $request->project_id;
            $q->save();
            DB::commit();
            return redirect()->back()->with(['message' => __('msg.msg_update_success')]);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return back()->withError($e->getMessage())->withInput();
        }
    }

    public function manage_problem_solution_destroy(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);
        DB::beginTransaction();
        try {
            $q = tbl_project_problem_solution::find($request->id);
            $q->delete();
            DB::commit();
            return response()->json(['status' => 'success']);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['status' => 'error']);
        }
    }

    public function manage_quantitative_indicators_store(Request $request)
    {
        $request->validate([
            'project_id' => 'required',
            'project_quantitative_indicators_value' => 'required',
            'project_quantitative_indicators_unit' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $q = new tbl_project_quantitative_indicators();
            $q->project_quantitative_indicators_value = $request->project_quantitative_indicators_value;
            $q->project_quantitative_indicators_unit = $request->project_quantitative_indicators_unit;
            $q->project_id = $request->project_id;
            $q->save();
            DB::commit();
            return redirect()->back()->with(['message' => __('msg.msg_create_success')]);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return back()->withError($e->getMessage())->withInput();
        }
    }

    public function manage_quantitative_indicators_edit(Request $request)
    {
        $q = tbl_project_quantitative_indicators::find($request->id);
        return response()->json($q);
    }

    public function manage_quantitative_indicators_update(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'project_id' => 'required',
            'project_quantitative_indicators_value' => 'required',
            'project_quantitative_indicators_unit' => 'required',
        ]);


        DB::beginTransaction();
        try {
            $q = tbl_project_quantitative_indicators::find($request->id);
            $q->project_quantitative_indicators_value = $request->project_quantitative_indicators_value;
            $q->project_quantitative_indicators_unit = $request->project_quantitative_indicators_unit;
            $q->project_id = $request->project_id;
            $q->save();
            DB::commit();
            return redirect()->back()->with(['message' => __('msg.msg_update_success')]);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return back()->withError($e->getMessage())->withInput();
        }
    }

    public function manage_quantitative_indicators_destroy(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);
        DB::beginTransaction();
        try {
            $q = tbl_project_quantitative_indicators::find($request->id);
            $q->delete();
            DB::commit();
            return response()->json(['status' => 'success']);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['status' => 'error']);
        }
    }

    public function manage_qualitative_indicators_store(Request $request)
    {
        $request->validate([
            'project_id' => 'required',
            'project_qualitative_indicators_value' => 'required',
            'project_qualitative_indicators_unit' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $q = new tbl_project_qualitative_indicators();
            $q->project_qualitative_indicators_value = $request->project_qualitative_indicators_value;
            $q->project_qualitative_indicators_unit = $request->project_qualitative_indicators_unit;
            $q->project_id = $request->project_id;
            $q->save();
            DB::commit();
            return redirect()->back()->with(['message' => __('msg.msg_create_success')]);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return back()->withError($e->getMessage())->withInput();
        }
    }

    public function manage_qualitative_indicators_edit(Request $request)
    {
        $q = tbl_project_qualitative_indicators::find($request->id);
        return response()->json($q);
    }

    public function manage_qualitative_indicators_update(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'project_id' => 'required',
            'project_qualitative_indicators_value' => 'required',
            'project_qualitative_indicators_unit' => 'required',
        ]);


        DB::beginTransaction();
        try {
            $q = tbl_project_qualitative_indicators::find($request->id);
            $q->project_qualitative_indicators_value = $request->project_qualitative_indicators_value;
            $q->project_qualitative_indicators_unit = $request->project_qualitative_indicators_unit;
            $q->project_id = $request->project_id;
            $q->save();
            DB::commit();
            return redirect()->back()->with(['message' => __('msg.msg_update_success')]);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return back()->withError($e->getMessage())->withInput();
        }
    }

    public function manage_qualitative_indicators_destroy(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);
        DB::beginTransaction();
        try {
            $q = tbl_project_qualitative_indicators::find($request->id);
            $q->delete();
            DB::commit();
            return response()->json(['status' => 'success']);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['status' => 'error']);
        }
    }

    public function manage_output_store(Request $request)
    {
        $request->validate([
            'project_id' => 'required',
            'project_output_detail' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $q = new tbl_project_output();
            $q->project_output_detail = $request->project_output_detail;
            $q->project_id = $request->project_id;
            $q->save();
            DB::commit();
            return redirect()->back()->with(['message' => __('msg.msg_create_success')]);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return back()->withError($e->getMessage())->withInput();
        }
    }

    public function manage_output_edit(Request $request)
    {
        $q = tbl_project_output::find($request->id);
        return response()->json($q);
    }

    public function manage_output_update(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'project_id' => 'required',
            'project_output_detail' => 'required',
        ]);


        DB::beginTransaction();
        try {
            $q = tbl_project_output::find($request->id);
            $q->project_output_detail = $request->project_output_detail;
            $q->project_id = $request->project_id;
            $q->save();
            DB::commit();
            return redirect()->back()->with(['message' => __('msg.msg_update_success')]);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return back()->withError($e->getMessage())->withInput();
        }
    }

    public function manage_output_destroy(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);
        DB::beginTransaction();
        try {
            $q = tbl_project_output::find($request->id);
            $q->delete();
            DB::commit();
            return response()->json(['status' => 'success']);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['status' => 'error']);
        }
    }

    public function manage_output_gallery_store(Request $request)
    {
        $request->validate([
            'file' => 'required',
            'project_output_id' => 'required',
        ]);

        DB::beginTransaction();
        try {
            if ($request->has('file')) {
                foreach ($request->file as $key => $value) {
                    $path = $value->store('file-project-output');
                    $q = new tbl_project_output_gallery();
                    $q->project_output_gallery_path = $path;
                    $q->project_output_id = $request->project_output_id;
                    $q->save();
                }
            }
            DB::commit();
            return response()->json(['status' => 'success']);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['status' => 'error']);
        }
    }

    public function manage_output_gallery_show(Request $request)
    {
        $q = tbl_project_output_gallery::where('project_output_id', $request->id)->get();
        return response()->json($q);
    }

    public function manage_output_gallery_destroy(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'project_output_id' => 'required',
        ]);
        DB::beginTransaction();
        try {
            $q = tbl_project_output_gallery::find($request->id);
            Storage::delete($q->project_output_gallery_path);
            $q->delete();

            $project_output = tbl_project_output_gallery::selectRaw("count(id) as count_id")->where('project_output_id', $request->project_output_id)->first();
            DB::commit();
            return response()->json(compact('project_output'));
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['status' => 'error']);
        }
    }

    public function manage_outcome_store(Request $request)
    {
        $request->validate([
            'project_id' => 'required',
            'project_outcome_detail' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $q = new tbl_project_outcome();
            $q->project_outcome_detail = $request->project_outcome_detail;
            $q->project_id = $request->project_id;
            $q->save();
            DB::commit();
            return redirect()->back()->with(['message' => __('msg.msg_create_success')]);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return back()->withError($e->getMessage())->withInput();
        }
    }

    public function manage_outcome_edit(Request $request)
    {
        $q = tbl_project_outcome::find($request->id);
        return response()->json($q);
    }

    public function manage_outcome_update(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'project_id' => 'required',
            'project_outcome_detail' => 'required',
        ]);


        DB::beginTransaction();
        try {
            $q = tbl_project_outcome::find($request->id);
            $q->project_outcome_detail = $request->project_outcome_detail;
            $q->project_id = $request->project_id;
            $q->save();
            DB::commit();
            return redirect()->back()->with(['message' => __('msg.msg_update_success')]);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return back()->withError($e->getMessage())->withInput();
        }
    }

    public function manage_outcome_destroy(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);
        DB::beginTransaction();
        try {
            $q = tbl_project_outcome::find($request->id);
            $q->delete();
            DB::commit();
            return response()->json(['status' => 'success']);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['status' => 'error']);
        }
    }

    public function manage_impact_store(Request $request)
    {
        $request->validate([
            'project_id' => 'required',
            'project_impact_detail' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $q = new tbl_project_impact();
            $q->project_impact_detail = $request->project_impact_detail;
            $q->project_id = $request->project_id;
            $q->save();
            DB::commit();
            return redirect()->back()->with(['message' => __('msg.msg_create_success')]);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return back()->withError($e->getMessage())->withInput();
        }
    }

    public function manage_impact_edit(Request $request)
    {
        $q = tbl_project_impact::find($request->id);
        return response()->json($q);
    }

    public function manage_impact_update(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'project_id' => 'required',
            'project_impact_detail' => 'required',
        ]);


        DB::beginTransaction();
        try {
            $q = tbl_project_impact::find($request->id);
            $q->project_impact_detail = $request->project_impact_detail;
            $q->project_id = $request->project_id;
            $q->save();
            DB::commit();
            return redirect()->back()->with(['message' => __('msg.msg_update_success')]);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return back()->withError($e->getMessage())->withInput();
        }
    }

    public function manage_impact_destroy(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);
        DB::beginTransaction();
        try {
            $q = tbl_project_impact::find($request->id);
            $q->delete();
            DB::commit();
            return response()->json(['status' => 'success']);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['status' => 'error']);
        }
    }
}
