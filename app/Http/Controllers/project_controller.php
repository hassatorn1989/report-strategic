<?php

namespace App\Http\Controllers;

use App\Models\tbl_budget;
use App\Models\tbl_faculty;
use App\Models\tbl_location;
use App\Models\tbl_plan_type;
use App\Models\tbl_project;
use App\Models\tbl_project_file;
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
use App\Models\view_project_main;
use App\Models\view_project_output_gallery;
use App\Models\tbl_project_output_detail;
use App\Models\tbl_project_sub_type;
use App\Models\tbl_project_tag;
use App\Models\tbl_project_project_sub_type;
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
        $faculty = tbl_faculty::all();
        $project_sub_type = tbl_project_sub_type::all();
        $plan_type = tbl_plan_type::all();
        return view('project', compact('year', 'faculty', 'project_sub_type', 'plan_type'));
    }

    public function lists(Request $request)
    {
        $year = tbl_year::where('year_status', 'active')->first();
        $q = view_project::with(
            [
                'get_project_responsible_person',
                'get_project_target_group',
                'get_project_problem',
                'get_project_problem_solution',
                'get_project_quantitative_indicators',
                'get_project_qualitative_indicators',
                'get_project_output',
                'get_project_outcome',
                'get_project_location',
                'get_project_impact',
                'get_project_file',
                'get_year_strategic_detail',
            ]
        )
            ->where('year_id', $year->id)
            ->where('project_main_id', $request->project_main_id);
        if (auth()->user()->user_role == 'user') {
            $q->where('faculty_id', auth()->user()->faculty_id);
        }
        return DataTables::eloquent($q)
            ->filter(function ($q) use ($request) {
                if ($request->filter_project_name != '') {
                    $q->whereRaw("project_name like '%{$request->filter_project_name}%'");
                }
            })
            ->addColumn('project_code', function ($q) {
                return ($q->project_code == '') ? '<span class="text-danger">ไม่ระบุ</span>' : $q->project_code;
            })
            ->addColumn('project_status', function ($q) {
                $data = '';
                switch ($q->project_status) {
                case 'draff':
                    $data = '<span class="badge badge-warning">' . __('msg.project_status_draff') . '</span>';
                    break;
                case 'pending':
                    $data = '<span class="badge badge-info">' . __('msg.project_status_pending') . '</span>';
                    break;
                case 'publish':
                    $data = '<span class="badge badge-success">' . __('msg.project_status_publish') . '</span>';
                    break;
                case 'unpublish':
                    $data = '<span class="badge badge-danger">' . __('msg.project_status_unpublish') . '</span>';
                    break;
                case 'reject':
                    $data = '<span class="badge badge-danger">' . __('msg.project_status_reject') . '</span>';
                    break;
                }
                return $data;
            })
            ->addColumn('plan_type_name', function ($q) {
                return ($q->plan_type_name != '') ? $q->plan_type_name : '<small class="text-danger">ไม่ระบุ</small>';
            })
            ->addColumn('project_name', function ($q) {
                $data = $q->project_name;
                $data .= ($q->project_sub_type_name != '') ? '<br><small><strong>ประเภท : </strong>' . $q->project_sub_type_name . '</small>' : '';
                return $data;
            })
            ->addColumn('project_percentage', function ($q) {
                $i = 0;
                ($q->project_name != '' && $q->project_period_start != '')  ? $i++ : 0;
                count($q->get_project_responsible_person) > 0  ? $i++ : '';
                count($q->get_project_target_group) > 0 ? $i++ : '';
                count($q->get_project_problem) > 0 ? $i++ : '';
                count($q->get_project_problem_solution) > 0 ? $i++ : '';
                count($q->get_project_quantitative_indicators) > 0 ? $i++ : '';
                count($q->get_project_qualitative_indicators) > 0 ? $i++ : '';
                count($q->get_project_output) > 0 ? $i++ : '';
                count($q->get_project_outcome) > 0 ? $i++ : '';
                count($q->get_project_location) > 0 ? $i++ : '';
                count($q->get_project_impact) > 0 ? $i++ : '';
                $cal =  number_format(($i * 100) / 11, 2);
                return '<div class="progress progress-xxs mt-3">
                <div class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: ' . $cal . '%">
                <span class="sr-only">60% Complete (warning)</span>
                </div>
                </div><small>' . __('msg.project_percentage') . ' : ' . $cal . '%</small>';
            })
            ->addColumn('action', function ($q) {
                $action = '<div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                <div class="btn-group" role="group">
                    <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    ' . __('msg.action') . '
                    </button>
                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">';
                $action .= '<a class="dropdown-item text-info" href="' . route('project.manage', ['id' => $q->id]) . '"><i class="fas fa-sliders-h"></i> ' . __('msg.btn_manage_project') . '</a>';
                $action .= '<a class="dropdown-item text-danger" href="#" onclick="destroy(\'' . $q->id . '\')"><i class="fas fa-trash-alt"></i> ' . __('msg.btn_delete') . '</a>';
                $action .= '</div>
                </div>
                </div>';


                return $action;
            })
            ->rawColumns(['project_status', 'project_percentage', 'action', 'project_name', 'project_code', 'plan_type_name'])
            ->make();
    }

    public function store(Request $request)
    {
        $request->validate([
            'project_code' => 'required',
            'project_name' => 'required',
            'year_id' => 'required',
            'project_main_id' => 'required',
            'plan_type_id' => 'required',
            // 'project_sub_type_id' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $q = new tbl_project();
            $q->project_code = $request->project_code;
            $q->project_name = $request->project_name;
            $q->year_id = $request->year_id;
            $q->faculty_id = (auth()->user()->user_role == 'admin') ? $request->faculty_id : auth()->user()->faculty_id;
            $q->project_status = 'draff';
            $q->project_main_id = $request->project_main_id;
            $q->plan_type_id = $request->plan_type_id;
            // $q->project_sub_type_id = $request->project_sub_type_id;
            $q->user_created = auth()->user()->id;
            $q->save();


            if (!empty($request->project_sub_type_id)) {

                foreach ($request->project_sub_type_id as $key => $value) {
                    $qtag = new tbl_project_project_sub_type();
                    $qtag->project_id = $q->id;
                    $qtag->project_sub_type_id = $value;
                    $qtag->save();
                }
            }

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
            'project_code' => 'required',
            'project_name' => 'required',
            'project_type_id' => 'required',
            // 'project_sub_type_id' => 'required',
            'project_budget' => 'required',
            'project_period' => 'required',
            'plan_type_id' => 'required',
            // 'project_main_id' => 'required'
        ]);

        DB::beginTransaction();
        try {
            $project_tag_arr =   explode(',', $request->project_tag);
            $project_period = explode(' - ', $request->project_period);
            $project_period_start = date('Y-m-d', strtotime(str_replace('/', '-', $project_period[0])));
            $project_period_end = date('Y-m-d', strtotime(str_replace('/', '-', $project_period[1])));

            $q = tbl_project::find($request->id);
            $q->project_code = $request->project_code;
            $q->project_name = $request->project_name;
            $q->project_type_id = $request->project_type_id;
            $q->project_budget = $request->project_budget;
            $q->project_period_start = $project_period_start;
            $q->project_period_end = $project_period_end;
            $q->plan_type_id = $request->plan_type_id;
            // $q->project_sub_type_id = $request->project_sub_type_id;
            $q->user_updated = auth()->user()->id;
            $q->save();

            tbl_project_project_sub_type::where('project_id', $q->id)->delete();
            if (!empty($request->project_sub_type_id)) {
                foreach ($request->project_sub_type_id as $key => $value) {
                    $qtag = new tbl_project_project_sub_type();
                    $qtag->project_id = $q->id;
                    $qtag->project_sub_type_id = $value;
                    $qtag->save();
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

    public function check_publish(Request $request)
    {
        $project = view_project::with(
            [
                'get_project_responsible_person',
                'get_project_target_group',
                'get_project_problem',
                'get_project_problem_solution',
                'get_project_quantitative_indicators',
                'get_project_qualitative_indicators',
                'get_project_output',
                'get_project_outcome',
                'get_project_location',
                'get_year_strategic_detail',
            ]
        )->find($request->id);
        echo ($project->project_name != '' &&
            $project->project_period_start != '' &&
            count($project->get_project_responsible_person) > 0 &&
            count($project->get_project_target_group) > 0 &&
            count($project->get_project_problem) > 0 &&
            count($project->get_project_problem_solution) > 0 &&
            count($project->get_project_quantitative_indicators) > 0 &&
            count($project->get_project_qualitative_indicators) > 0 &&
            count($project->get_project_output) > 0 &&
            count($project->get_project_outcome) > 0 &&
            count($project->get_project_location) > 0 &&
            count($project->get_project_impact) > 0
        ) ? 'true' : 'false';
    }

    public function publish(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'project_status' => 'required',
        ]);
        DB::beginTransaction();
        try {
            $q = tbl_project::find($request->id);
            $q->project_status = $request->project_status;
            $q->save();
            DB::commit();
            return redirect()->back()->with(['message' => __('msg.msg_create_success')]);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return back()->withError($e->getMessage())->withInput();
        }
    }

    public function manage(Request $request)
    {
        $project = view_project::with(
            [
                'get_project_responsible_person' => function ($q) {
                    $q->orderBy('project_responsible_person_name', 'ASC');
                },
                'get_project_target_group' => function ($q) {
                    $q->orderBy('project_target_group_detail', 'ASC');
                },
                'get_project_problem' => function ($q) {
                    $q->orderBy('project_problem_detail', 'ASC');
                },
                'get_project_problem_solution' => function ($q) {
                    $q->orderBy('project_problem_solution_detail', 'ASC');
                },
                'get_project_quantitative_indicators' => function ($q) {
                    $q->orderBy('project_quantitative_indicators_value', 'ASC');
                },
                'get_project_qualitative_indicators' => function ($q) {
                    $q->orderBy('project_qualitative_indicators_value', 'ASC');
                },
                'get_project_file' => function ($q) {
                    $q->orderBy('created_at', 'ASC');
                },
                'get_project_output' => function ($q) {
                    $q->selectRaw("*,
                    IF (
                    (
                        tbl_project_output.indicators_type = 'quantitative'
                    ),
                    (
                        SELECT
                            tbl_project_quantitative_indicators.project_quantitative_indicators_value
                        FROM
                            `tbl_project_quantitative_indicators`
                        WHERE
                            tbl_project_quantitative_indicators.id = tbl_project_output.indicators_id
                    ),
                    (
                        SELECT
                            tbl_project_qualitative_indicators.project_qualitative_indicators_value
                        FROM
                            `tbl_project_qualitative_indicators`
                        WHERE
                            tbl_project_qualitative_indicators.id = tbl_project_output.indicators_id
                    ) ) AS indicators_value,
                    IF (
                        (
                            tbl_project_output.indicators_type = 'quantitative'
                        ),
                        (
                            SELECT
                                tbl_project_quantitative_indicators.project_quantitative_indicators_unit
                            FROM
                                `tbl_project_quantitative_indicators`
                            WHERE
                                tbl_project_quantitative_indicators.id = tbl_project_output.indicators_id
                        ),
                        (
                            SELECT
                                tbl_project_qualitative_indicators.project_qualitative_indicators_unit
                            FROM
                                `tbl_project_qualitative_indicators`
                            WHERE
                                tbl_project_qualitative_indicators.id = tbl_project_output.indicators_id
                    )) AS indicators_unit,
                    (select count(*) from tbl_project_output_gallery where tbl_project_output_gallery.project_output_id = tbl_project_output.id) as total_gallery")
                        ->orderBy('project_output_detail', 'ASC');
                },
                'get_project_outcome' => function ($q) {
                    $q->selectRaw("*,
                    IF (
                    (
                        tbl_project_outcome.indicators_type = 'quantitative'
                    ),
                    (
                        SELECT
                            tbl_project_quantitative_indicators.project_quantitative_indicators_value
                        FROM
                            `tbl_project_quantitative_indicators`
                        WHERE
                            tbl_project_quantitative_indicators.id = tbl_project_outcome.indicators_id
                    ),
                    (
                        SELECT
                            tbl_project_qualitative_indicators.project_qualitative_indicators_value
                        FROM
                            `tbl_project_qualitative_indicators`
                        WHERE
                            tbl_project_qualitative_indicators.id = tbl_project_outcome.indicators_id
                    ) ) AS indicators_value,
                    IF(indicators_id != 'N', IF (
                        (
                            tbl_project_outcome.indicators_type = 'quantitative'
                        ),
                        (
                            SELECT
                                tbl_project_quantitative_indicators.project_quantitative_indicators_unit
                            FROM
                                `tbl_project_quantitative_indicators`
                            WHERE
                                tbl_project_quantitative_indicators.id = tbl_project_outcome.indicators_id
                        ),
                        (
                            SELECT
                                tbl_project_qualitative_indicators.project_qualitative_indicators_unit
                            FROM
                                `tbl_project_qualitative_indicators`
                            WHERE
                                tbl_project_qualitative_indicators.id = tbl_project_outcome.indicators_id
                    )), 'ไม่ระบุ') AS indicators_unit")
                        ->orderBy('project_outcome_detail', 'ASC');
                },
                'get_project_location' => function ($q) {
                    $q->orderBy('id', 'DESC');
                },
                'get_project_impact' => function ($q) {
                    $q->orderBy('id', 'DESC');
                },
                'get_year_strategic_detail',
                'get_project_tag',
            ]
        )->find($request->id);
        $i = 0;
        ($project->project_name != '' &&
            $project->project_period_start != '')  ? $i++ : 0;
        count($project->get_project_responsible_person) > 0  ? $i++ : '';
        count($project->get_project_target_group) > 0 ? $i++ : '';
        count($project->get_project_problem) > 0 ? $i++ : '';
        count($project->get_project_problem_solution) > 0 ? $i++ : '';
        count($project->get_project_quantitative_indicators) > 0 ? $i++ : '';
        count($project->get_project_qualitative_indicators) > 0 ? $i++ : '';
        count($project->get_project_output) > 0 ? $i++ : '';
        count($project->get_project_outcome) > 0 ? $i++ : '';
        count($project->get_project_location) > 0 ? $i++ : '';
        count($project->get_project_impact) > 0 ? $i++ : '';
        $cal =  number_format(($i * 100) / 11, 2);
        $year_strategic = view_year_strategic::with('get_year_strategic_detail')->select('id', 'strategic_name', 'count_year_strategic_detail')->where('year_id', $project->year_id)->get();
        $budget = tbl_budget::all();
        $project_type = tbl_project_type::all();
        // $project_sub_type = tbl_project_sub_type::all();
        $project_sub_type = tbl_project_sub_type::selectRaw("*,
        (select count(id) from tbl_project_project_sub_type where tbl_project_project_sub_type.project_sub_type_id = tbl_project_sub_type.id  and tbl_project_project_sub_type.project_id = '{$request->id}') as project_count")->get();
        $province = view_location::selectRaw("DISTINCT(pcode), pname")->whereIn('pcode', ['67', '66'])->orderBy('pcode', 'ASC')->get();
        if (auth()->user()->faculty_id == 'other') {
            $project_main = view_project_main::all();
        } else {
            $project_main = view_project_main::where('faculty_id', auth()->user()->faculty_id)->get();
        }
        $plan_type = tbl_plan_type::all();

        return view('project_manage', compact('project', 'year_strategic', 'budget', 'project_type', 'province', 'cal', 'project_main', 'project_sub_type', 'plan_type'));
    }

    public function manage_location_store(Request $request)
    {
        $request->validate([
            'project_id' => 'required',
            'pcode' => 'required',
            'acode' => 'required',
            'tcode' => 'required',
            'mcode' => 'required',
            // 'address' => 'required',
        ]);


        DB::beginTransaction();
        try {
            $q = new tbl_project_location();
            $q->project_id = $request->project_id;
            $q->pcode = $request->pcode;
            $q->acode = $request->acode;
            $q->tcode = $request->tcode;
            $q->mcode = $request->mcode;
            $q->address = $request->address;
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
            $q->address = $request->address;
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
            'project_responsible_person_position' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $q = new tbl_project_responsible_person();
            $q->project_responsible_person_name = $request->project_responsible_person_name;
            $q->project_responsible_person_tel = $request->project_responsible_person_tel;
            $q->project_responsible_person_position = $request->project_responsible_person_position;
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
            'project_responsible_person_position' => 'required',
        ]);


        DB::beginTransaction();
        try {
            $q = tbl_project_responsible_person::find($request->id);
            $q->project_responsible_person_name = $request->project_responsible_person_name;
            $q->project_responsible_person_tel = $request->project_responsible_person_tel;
            $q->project_responsible_person_position = $request->project_responsible_person_position;
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
            'project_problem_sub_detail' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $q = new tbl_project_problem();
            $q->project_problem_detail = $request->project_problem_detail;
            $q->project_problem_sub_detail = nl2br($request->project_problem_sub_detail);
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
            'project_problem_sub_detail' => 'required',
        ]);


        DB::beginTransaction();
        try {
            $q = tbl_project_problem::find($request->id);
            $q->project_problem_detail = $request->project_problem_detail;
            $q->project_problem_sub_detail =    nl2br($request->project_problem_sub_detail);
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


    public function manage_get_problem_summary(Request $request)
    {
        $q = tbl_project::select('project_problem_summary')->find($request->id);
        return response()->json($q);
    }

    public function manage_problem_summary_update(Request $request)
    {
        $request->validate([
            'project_id3' => 'required',
            'project_problem_summary' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $q = tbl_project::find($request->project_id3);
            $q->project_problem_summary = nl2br($request->project_problem_summary);
            $q->save();
            DB::commit();
            return redirect()->back()->with(['message' => __('msg.msg_update_success')]);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return back()->withError($e->getMessage())->withInput();
        }
    }

    public function manage_problem_solution_store(Request $request)
    {
        $request->validate([
            'project_id' => 'required',
            'project_problem_solution_detail' => 'required',
            'project_problem_solution_budget' => 'required',
            'project_problem_solution_sub_detail' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $q = new tbl_project_problem_solution();
            $q->project_problem_solution_detail = $request->project_problem_solution_detail;
            $q->project_problem_solution_budget = $request->project_problem_solution_budget;
            $q->project_problem_solution_sub_detail = nl2br($request->project_problem_solution_sub_detail);
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
            'project_problem_solution_sub_detail' => 'required',
            'project_problem_solution_budget' => 'required',
        ]);


        DB::beginTransaction();
        try {
            $q = tbl_project_problem_solution::find($request->id);
            $q->project_problem_solution_detail = $request->project_problem_solution_detail;
            $q->project_problem_solution_budget = $request->project_problem_solution_budget;
            $q->project_problem_solution_sub_detail =   nl2br($request->project_problem_solution_sub_detail);
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


    public function manage_get_problem_solution_summary(Request $request)
    {
        $q = tbl_project::select('project_problem_solution_summary')->find($request->id);
        return response()->json($q);
    }

    public function manage_problem_solution_summary_update(Request $request)
    {
        $request->validate([
            'project_id4' => 'required',
            'project_problem_solution_summary' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $q = tbl_project::find($request->project_id4);
            $q->project_problem_solution_summary = nl2br($request->project_problem_solution_summary);
            $q->save();
            DB::commit();
            return redirect()->back()->with(['message' => __('msg.msg_update_success')]);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return back()->withError($e->getMessage())->withInput();
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
            'indicators_output_type' => 'required',
            'indicators_output_id' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $q = new tbl_project_output();
            $q->project_output_detail = $request->project_output_detail;
            $q->project_output_upgrading = nl2br($request->project_output_upgrading);
            $q->indicators_type = $request->indicators_output_type;
            $q->indicators_id = $request->indicators_output_id;
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
        $output = tbl_project_output::find($request->id);
        if ($output->indicators_type == 'quantitative') {
            $indicators = tbl_project_quantitative_indicators::selectRaw("id, project_quantitative_indicators_value as indicators_value, project_quantitative_indicators_unit as indicators_unit")->where('project_id', $request->project_id)->get();
        } else if ($output->indicators_type == 'qualitative') {
            $indicators = tbl_project_qualitative_indicators::selectRaw("id, project_qualitative_indicators_value as indicators_value, project_qualitative_indicators_unit as indicators_unit")->where('project_id', $request->project_id)->get();
        }
        return response()->json(compact('output', 'indicators'));
    }

    public function manage_output_update(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'project_id' => 'required',
            'project_output_detail' => 'required',
            'indicators_output_type' => 'required',
            'indicators_output_id' => 'required',
        ]);


        DB::beginTransaction();
        try {
            $q = tbl_project_output::find($request->id);
            $q->project_output_detail = $request->project_output_detail;
            $q->project_output_upgrading = nl2br($request->project_output_upgrading);
            $q->indicators_type = $request->indicators_output_type;
            $q->indicators_id = $request->indicators_output_id;
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

    public function manage_output_detail_store(Request $request)
    {
        $request->validate([
            'project_output_id2' => 'required',
            'project_output_detail_produce' => 'required',
            'project_output_detail_process' => 'required',
            'project_output_detail_elevate' => 'required',
            'project_output_detail_image' => 'required',
        ]);
        // dd($request->all());

        DB::beginTransaction();
        try {
            $q = new tbl_project_output_detail();
            $q->project_output_detail_produce = $request->project_output_detail_produce;
            $q->project_output_detail_elevate = nl2br($request->project_output_detail_elevate);
            $q->project_output_detail_process = nl2br($request->project_output_detail_process);
            if ($request->has('project_output_detail_image')) {
                $path =
                    $request->file('project_output_detail_image')->store('file-output-detail');
                $q->project_output_detail_image = $path;
            }
            $q->project_output_id = $request->project_output_id2;
            $q->save();
            DB::commit();
            return redirect()->back()->with(['message' => __('msg.msg_create_success')]);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return back()->withError($e->getMessage())->withInput();
        }
    }


    public function manage_output_detail_edit(Request $request)
    {
        $q = tbl_project_output_detail::where('id', $request->id)->first();
        return response()->json($q);
    }

    public function manage_output_detail_update(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'project_output_detail_produce' => 'required',
            'project_output_detail_process' => 'required',
            'project_output_detail_elevate' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $q = tbl_project_output_detail::find($request->id);
            $q->project_output_detail_produce = $request->project_output_detail_produce;
            $q->project_output_detail_elevate = nl2br($request->project_output_detail_elevate);
            $q->project_output_detail_process = nl2br($request->project_output_detail_process);
            if ($request->has('project_output_detail_image')) {
                $path =
                    $request->file('project_output_detail_image')->store('file-output-detail');
                $q->project_output_detail_image = $path;
            }
            $q->save();
            DB::commit();
            return redirect()->back()->with(['message' => __('msg.msg_update_success')]);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return back()->withError($e->getMessage())->withInput();
        }
    }

    public function manage_output_detail_destroy(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);
        DB::beginTransaction();
        try {
            $q = tbl_project_output_detail::find($request->id);
            Storage::delete($q->project_output_detail_image);
            $q->delete();
            DB::commit();
            return response()->json(['status' => 'success']);
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
            'indicators_outcome_type' => 'required',
            'indicators_outcome_id' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $q = new tbl_project_outcome();
            $q->project_outcome_detail = $request->project_outcome_detail;
            $q->indicators_type = $request->indicators_outcome_type;
            $q->indicators_id = $request->indicators_outcome_id;
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
        $outcome = tbl_project_outcome::find($request->id);
        if ($outcome->indicators_type == 'quantitative') {
            $indicators = tbl_project_quantitative_indicators::selectRaw("id, project_quantitative_indicators_value as indicators_value, project_quantitative_indicators_unit as indicators_unit")->where('project_id', $request->project_id)->get();
        } else if ($outcome->indicators_type == 'qualitative') {
            $indicators = tbl_project_qualitative_indicators::selectRaw("id, project_qualitative_indicators_value as indicators_value, project_qualitative_indicators_unit as indicators_unit")->where('project_id', $request->project_id)->get();
        }
        return response()->json(compact('outcome', 'indicators'));
    }

    public function manage_outcome_update(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'project_id' => 'required',
            'project_outcome_detail' => 'required',
            'indicators_outcome_type' => 'required',
            'indicators_outcome_id' => 'required',
        ]);


        DB::beginTransaction();
        try {
            $q = tbl_project_outcome::find($request->id);
            $q->project_outcome_detail = $request->project_outcome_detail;
            $q->indicators_type = $request->indicators_outcome_type;
            $q->indicators_id = $request->indicators_outcome_id;
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

    public function get_project_indicators(Request $request)
    {
        if ($request->indicators_type == 'quantitative') {
            $q = tbl_project_quantitative_indicators::selectRaw("id, project_quantitative_indicators_value as indicators_value, project_quantitative_indicators_unit as indicators_unit")->where('project_id', $request->project_id)->get();
        } else if ($request->indicators_type == 'qualitative') {
            $q = tbl_project_qualitative_indicators::selectRaw("id, project_qualitative_indicators_value as indicators_value, project_qualitative_indicators_unit as indicators_unit")->where('project_id', $request->project_id)->get();
        }
        return response()->json($q);
    }


    public function manage_file_store(Request $request)
    {

        $request->validate([
            'file' => 'required',
            'file_project_id' => 'required',
        ]);

        DB::beginTransaction();
        try {
            if ($request->has('file')) {
                foreach ($request->file as $key => $value) {
                    $path = $value->store('file-project-fileupload');
                    $q = new tbl_project_file();
                    $q->project_file_path = $path;
                    $q->project_file_name = $value->getClientOriginalName();
                    $q->project_id = $request->file_project_id;
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

    public function manage_file_destroy(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);
        DB::beginTransaction();
        try {
            $q = tbl_project_file::find($request->id);
            $q->delete();
            DB::commit();
            return response()->json(['status' => 'success']);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['status' => 'error']);
        }
    }
}
