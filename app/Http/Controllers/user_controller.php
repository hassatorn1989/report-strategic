<?php

namespace App\Http\Controllers;

use App\Models\tbl_faculty;
use Illuminate\Http\Request;
use App\Models\tbl_user;
use App\Models\view_user;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use DataTables;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class user_controller extends Controller
{
    public function index(Request $request)
    {
        $faculty = tbl_faculty::all();
        return view('user', compact('faculty'));
    }

    public function lists(Request $request)
    {
        $q = view_user::query();
        return DataTables::eloquent($q)
            ->filter(function ($q) use ($request) {
                if ($request->filter_user_name != '') {
                    $q->whereRaw("full_name like '%{$request->filter_user_name}%'");
                }
            })
            ->addColumn('user_role', function ($q) {
                return $q->user_role == 'admin' ? '<span class="badge badge-info">' . __('msg.user_role_admin') . '</span>' : '<span class="badge badge-success">' . __('msg.user_role_user') . '</span>';
            })
            ->addColumn('action', function ($q) {
                $action = '<button class="btn btn-warning btn-sm waves-effect waves-light" data-toggle="modal" data-target="#modal-default"onclick="edit_data(\'' . $q->id . '\')"> <i class="fas fa-edit"></i> ' . __('msg.btn_edit') . '</button> ';
                $action .= '<button class="btn btn-danger btn-sm waves-effect waves-light" data-toggle="modal" data-target="#modal-default-detail" onclick="destroy(\'' . $q->id . '\')"> <i class="fas fa-trash-alt"></i> ' . __('msg.btn_delete') . '</button> ';
                return $action;
            })
            ->rawColumns(['user_role', 'action'])
            ->make();
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_prefix' => 'required',
            'user_name' => 'required',
            'user_last' => 'required',
            'username' => 'required',
            'password' => 'required',
            'user_role' => 'required',
            'faculty_id' => 'required'
        ]);

        DB::beginTransaction();
        try {
            $q = new tbl_user();
            $q->user_prefix = $request->user_prefix;
            $q->user_name = $request->user_name;
            $q->user_last = $request->user_last;
            $q->username = $request->username;
            $q->password = Hash::make($request->password);
            $q->user_role = $request->user_role;
            $q->faculty_id = $request->faculty_id;
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
        $q = tbl_user::find($request->id);
        return response()->json($q);
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'user_prefix' => 'required',
            'user_name' => 'required',
            'user_last' => 'required',
            'username' => 'required',
            'password' => 'required',
            'user_role' => 'required',
            'faculty_id' => 'required'
        ]);

        DB::beginTransaction();
        try {
            $q = tbl_user::find($request->id);
            $q->user_prefix = $request->user_prefix;
            $q->user_name = $request->user_name;
            $q->user_last = $request->user_last;
            $q->username = $request->username;
            if ($request->password != '') {
                $q->password = Hash::make($request->password);
            }
            $q->user_role = $request->user_role;
            $q->faculty_id = $request->faculty_id;
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
            $q = tbl_user::find($request->id);
            $q->delete();
            DB::commit();
            return response()->json(['status' => 'success']);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['status' => 'error']);
        }
    }

    public function check_username(Request $request)
    {
        $c = tbl_user::where('username', $request->username)->count();
        echo ($c == 0)  ? "true" : "false";
    }
}
