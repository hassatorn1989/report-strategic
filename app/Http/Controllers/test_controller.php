<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\view_equipment_user;
class test_controller extends Controller
{
    public function index()
    {
        $user = view_equipment_manager::where('user_id', '655163')->where('user_password', caesar_encode('655163', '1234', 3))->get();

        // dd($user);

    }
}
