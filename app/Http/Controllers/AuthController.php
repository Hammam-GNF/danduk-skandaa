<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        $user = Auth::user();
        if ($user) {
            if ($user->role_id == '1')
                return redirect()->intended('dashboard');
        }
        return view('login');
    }

    public function actionLogin(Request $request)
    {
        $data = [
            'username' => $request->input('username'),
            'password' => $request->input('password'),
            'role_id' => $request->input('role_id'),
        ];

        if (Auth::attempt($data)) {
            if (auth()->user()->role_id == '1') {
                return redirect()->route('dashboard');
            }
        } else {
            return back()->withErrors(['gagal' => 'Username or password invalid.']);
        }
    }

    public function actionLogout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function error()
    {
        return view('login');
    }
}