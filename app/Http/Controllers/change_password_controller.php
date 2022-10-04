<?php

namespace App\Http\Controllers;

use App\Models\tbl_user;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class change_password_controller extends Controller
{
    public function check(Request $request)
    {
        $this->validate($request, [
            'current_password' => 'required',
        ]);
        echo (Hash::check($request->current_password, Auth::user()->password) == true)  ? "true" : "false";
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'new_password' => 'required',
        ]);
        DB::beginTransaction();
        try {
            $q = tbl_user::find(Auth::user()->id);
            $q->password = Hash::make($request->new_password);
            $q->save();
            DB::commit();
            return redirect()->back();
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return back()->withError($e->getMessage())->withInput();
        }
    }
}
