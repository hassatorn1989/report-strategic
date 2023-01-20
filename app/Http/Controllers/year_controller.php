<?php

namespace App\Http\Controllers;

use App\Models\tbl_strategic;
use App\Models\tbl_year;
use App\Models\tbl_year_strategic;
use App\Models\tbl_year_strategic_detail;
use App\Models\view_year_strategic;
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
        $q = tbl_year::with('get_year_strategic');
        return DataTables::eloquent($q)
            ->filter(function ($q) use ($request) {
                if ($request->filter_year_name != '') {
                    $q->whereRaw("year_name like '%{$request->filter_year_name}%'");
                }
            })
            ->addColumn('year_status', function ($q) {
                return $q->year_status == 'active' ? '<span class="badge badge-success">' . __('msg.year_status_active') . '</span>' : '<span class="badge badge-danger">' . __('msg.year_status_inactive') . '</span>';
            })
            ->addColumn('strategic', function ($q) {
                $data = '';
                if (count($q->get_year_strategic) > 0) {
                    $i = 1;
                    foreach ($q->get_year_strategic as $key => $value) {
                        $data .=  $value->strategic_name . '<br>';
                        $data .= '<small><strong>' . __('msg.sub_strategic') . ' : </strong>';
                        if (count($value->get_year_strategic_detail) > 0) {
                            $ii = 1;
                            foreach ($value->get_year_strategic_detail as $key1 => $value1) {
                                $data .= $value1->year_strategic_detail_detail;
                                if ($ii < count($value->get_year_strategic_detail)) {
                                    $data .= ', ';
                                }
                                $ii++;
                            }
                        } else {
                            $data .= '-';
                        }
                        $data .= '</small>';
                        $data .= '<br>';
                    }
                } else {
                    $data = '-';
                }
                return $data;
            })
            ->addColumn('action', function ($q) {
                $action = '<div class="btn-group" role="group">';
                $action .= '<button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' . __('msg.btn_action') . '</button>';
                $action .= '<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">';
                $action .= ' <a class="dropdown-item text-info" href="' . route('setting.year.manage-strategic', [
                    'id' => $q->id
                ]) . '"><i class="fas fa-flag"></i> ' . __('msg.btn_config_strategic') . '</a>';
                $action .= ' <a class="dropdown-item text-warning" href="#" data-toggle="modal" data-target="#modal-default "onclick="edit_data(\'' . $q->id . '\')"><i class="fas fa-edit"></i> ' . __('msg.btn_edit') . '</a>';
                $action .= ' <a class="dropdown-item text-danger" href="#" onclick="destroy(\'' . $q->id . '\')"><i class="fas fa-trash-alt"></i> ' . __('msg.btn_delete') . '</a>';
                $action .= '</div>';
                $action .= '</div>';
                $action .= '</div>';
                return $action;
            })
            ->rawColumns(['strategic', 'year_status', 'action'])
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
            DB::commit();
            return redirect()->route('setting.year.manage-strategic', [
                'id' => $q->id
            ])->with(['message' => __('msg.msg_create_success')]);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return back()->withError($e->getMessage())->withInput();
        }
    }

    public function edit(Request $request)
    {
        $year = tbl_year::find($request->id);
        return response()->json(compact('year'));
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

            // tbl_year_strategic::where('year_id', $request->id)->delete();
            // if (!empty($request->strategic_id)) {
            //     foreach ($request->strategic_id as $value) {
            //         $q1 = new tbl_year_strategic();
            //         $q1->year_id = $q->id;
            //         $q1->strategic_id = $value;
            //         $q1->save();
            //     }
            // }

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


    public function manage_strategic(Request $request)
    {
        $year = tbl_year::find($request->id);
        $strategic = tbl_strategic::all();
        return view('year_manage', compact('year', 'strategic'));
    }

    public function manage_strategic_lists(Request $request)
    {
        $q = view_year_strategic::with('get_year_strategic_detail')->where('year_id', $request->year_id);
        return DataTables::eloquent($q)
            ->filter(function ($q) use ($request) {
                if ($request->filter_year_name != '') {
                    $q->whereRaw("year_name like '%{$request->filter_year_name}%'");
                }
            })
            ->addColumn('strategic_detail', function ($q) {
                $data = '';
                if (count($q->get_year_strategic_detail) > 0) {
                    $i = 1;
                    foreach ($q->get_year_strategic_detail as $key => $value) {
                        $data .= $value->year_strategic_detail_detail;
                        if ($i < count($q->get_year_strategic_detail)) {
                            $data .= ', ';
                        }
                        $i++;
                    }
                } else {
                    $data = '-';
                }
                return $data;
            })
            ->addColumn('flag_sub_strategic', function ($q) {
                return $q->flag_sub_strategic == 'Y' ? 'Yes' : 'No';
            })
            ->addColumn('action', function ($q) {
                $action = '<button class="btn btn-warning btn-sm waves-effect waves-light" data-toggle="modal" data-target="#modal-default"onclick="edit_data(\'' . $q->id . '\')"> <i class="fas fa-edit"></i> ' . __('msg.btn_edit') . '</button> ';
                $action .= '<button class="btn btn-danger btn-sm waves-effect waves-light" data-toggle="modal"  onclick="destroy(\'' . $q->id . '\')"> <i class="fas fa-trash-alt"></i> ' . __('msg.btn_delete') . '</button> ';
                return $action;
            })
            ->rawColumns(['action'])
            ->make();
    }

    public function manage_strategic_store(Request $request)
    {
        $request->validate([
            'strategic_id' => 'required',
            // 'year_strategic_detail_detail' => 'required'
        ]);

        DB::beginTransaction();
        try {
            $q = new tbl_year_strategic();
            $q->year_id = $request->year_id;
            $q->strategic_id = $request->strategic_id;
            $q->flag_sub_strategic =  !empty($request->flag_sub) ? 'yes' : 'no';
            $q->save();

            if (!empty($request->flag_sub)) {
                foreach ($request->year_strategic_detail_detail as $value) {
                    $q1 = new tbl_year_strategic_detail();
                    $q1->year_strategic_id = $q->id;
                    $q1->year_strategic_detail_detail = $value;
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

    public function manage_strategic_edit(Request $request)
    {
        $q = view_year_strategic::find($request->id);
        return response()->json($q);
    }

    public function manage_strategic_update(Request $request)
    {
        $request->validate([
            'strategic_id' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $q = tbl_year_strategic::find($request->id);
            $q->strategic_id = $request->strategic_id;
            $q->save();

            tbl_year_strategic_detail::where('year_strategic_id', $request->id)->delete();
            if (!empty($request->flag_sub)) {
                foreach ($request->year_strategic_detail_detail as $value) {
                    $q1 = new tbl_year_strategic_detail();
                    $q1->year_strategic_id = $q->id;
                    $q1->year_strategic_detail_detail = $value;
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


    public function manage_strategic_destroy(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);
        DB::beginTransaction();
        try {
            $q = tbl_year_strategic::find($request->id);
            $q->delete();
            tbl_year_strategic_detail::where('year_strategic_id', $request->id)->delete();
            DB::commit();
            return response()->json(['status' => 'success']);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['status' => 'error']);
        }
    }

    public function manage_strategic_check(Request $request)
    {
        $q = tbl_year_strategic::where('year_id', $request->year_id)->where('strategic_id', $request->strategic_id)->count();
        echo ($q == 0) ? 'true' : 'false';
    }



    public function manage_sub_strategic(Request $request)
    {
        return view('year_manage_sub_strategic');
    }


    public function manage_sub_strategic_lists(Request $request)
    {
        $q = tbl_year_strategic_detail::where('year_strategic_id', $request->year_strategic_id);
        return DataTables::eloquent($q)
            ->filter(function ($q) use ($request) {
                if ($request->filter_year_strategic_detail_detail != '') {
                    $q->whereRaw("year_strategic_detail_detail like '%{$request->filter_year_strategic_detail_detail}%'");
                }
            })
            ->addColumn('action', function ($q) {
                $action = '<button class="btn btn-warning btn-sm waves-effect waves-light" data-toggle="modal" data-target="#modal-default"onclick="edit_data(\'' . $q->id . '\')"> <i class="fas fa-edit"></i> ' . __('msg.btn_edit') . '</button> ';
                $action .= '<button class="btn btn-danger btn-sm waves-effect waves-light" data-toggle="modal"  onclick="destroy(\'' . $q->id . '\')"> <i class="fas fa-trash-alt"></i> ' . __('msg.btn_delete') . '</button> ';
                return $action;
            })
            ->rawColumns(['action'])
            ->make();
    }


    public function manage_sub_strategic_store(Request $request)
    {
        $request->validate([
            'year_strategic_detail_detail' => 'required'
        ]);

        DB::beginTransaction();
        try {
            $q = new tbl_year_strategic_detail();
            $q->year_strategic_id = $request->year_strategic_id;
            $q->year_strategic_detail_detail = $request->year_strategic_detail_detail;
            $q->save();

            DB::commit();
            return redirect()->back()->with(['message' => __('msg.msg_create_success')]);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return back()->withError($e->getMessage())->withInput();
        }
    }

    public function manage_sub_strategic_edit(Request $request)
    {
        $q = tbl_year_strategic_detail::find($request->id);
        return response()->json($q);
    }

    public function manage_sub_strategic_update(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'year_strategic_detail_detail' => 'required'
        ]);

        DB::beginTransaction();
        try {
            $q = tbl_year_strategic_detail::find($request->id);
            $q->year_strategic_detail_detail = $request->year_strategic_detail_detail;
            $q->save();

            DB::commit();
            return redirect()->back()->with(['message' => __('msg.msg_update_success')]);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return back()->withError($e->getMessage())->withInput();
        }
    }

    public function manage_sub_strategic_destroy(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);
        DB::beginTransaction();
        try {
            $q = tbl_year_strategic_detail::find($request->id);
            $q->delete();
            DB::commit();
            return response()->json(['status' => 'success']);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['status' => 'error']);
        }
    }
}
