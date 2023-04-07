<?php

namespace App\Http\Controllers;


use App\Models\tbl_budget;
use App\Models\tbl_faculty;
use App\Models\tbl_location;
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

class check_project_controller extends Controller
{

    public function index()
    {
        $year = tbl_year::where('year_status', 'active')->first();
        $faculty = tbl_faculty::all();
        $project_sub_type = tbl_project_sub_type::all();
        return view('check_project', compact('year', 'faculty', 'project_sub_type'));
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
            ->where('project_status', 'pending');
        // if (auth()->user()->user_role == 'user') {
        //     $q->where('faculty_id', auth()->user()->faculty_id);
        // }
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
                $action .= '<a class="dropdown-item text-info" href="' . route('check-project.detail', ['id' => $q->id]) . '"><i class="fas fa-sliders-h"></i> ' . __('msg.btn_manage_project') . '</a>';
                // $action .= '<a class="dropdown-item text-danger" href="#" onclick="destroy(\'' . $q->id . '\')"><i class="fas fa-trash-alt"></i> ' . __('msg.btn_delete') . '</a>';
                $action .= '</div>
                </div>
                </div>';


                return $action;
            })
            ->rawColumns(['project_status', 'project_percentage', 'action', 'project_name', 'project_code'])
            ->make();
    }

    public function detail(Request $request)
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

        return view('check_project_detail', compact('project', 'year_strategic', 'budget', 'project_type', 'province', 'cal', 'project_main', 'project_sub_type'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required', 
            'project_status' => 'required', 
        ]); 
        DB::beginTransaction();
        try {
            $q = tbl_project::find($request->id);
            $q->project_status = $request->project_status;
            $q->project_status_reject_detail = nl2br($request->project_status_reject_detail);
            $q->save();
            DB::commit();
            return redirect()->route('check-project.index')->with(['message' => __('msg.msg_create_success')]);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return back()->withError($e->getMessage())->withInput();
        }
    }
}
