<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class auth_controller extends Controller
{
    public function index()
    {
        return view('signin');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $credentials = $request->only('username', 'password');

        if (auth()->attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('dashboard');
        }

        return redirect()->route('auth.index')->with([
            'message' => __('msg.msg_login_false'),
        ]);
    }

    public function logout(Request $request)
    {
        auth()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('auth.index');
    }
}
