<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login()
    {
        return view('login', [
            'tittle' => 'Login',
            'active' => 'login'
        ]);
    }

    public function actionLogin(Request $request)
    {
        $data = [
            'username' => $request->input('username'),
            'password' => $request->input('password'),
            'role' => $request->input('role'),
        ];

        if (Auth::attempt($data)) {
            if (auth()->user()->role == 'Admin') {
                return redirect()->route('dashboard')->with(['success' => 'You are logged in.']);
            }   
        }
        else{
            return back()->withErrors(['gagal' => 'Username or password invalid.']);
        }
    }
    
    public function actionLogout(Request $request)
    {
        Auth::logout();
        return redirect('/')->with(['success' => 'You\'ve been logged out.']);
    }

    public function error()
    {
        return view('login');
    }

}