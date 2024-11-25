<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            $user = Auth::user();
            
            return $this->redirectUserBasedOnRole($user->role_id);
        }
        
        return view('login');
    }

    public function actionLogin(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            
            return $this->redirectUserBasedOnRole($user->role_id);
        } else {
            return back()->withErrors(['gagal' => 'Username atau password tidak valid.']);
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

    private function redirectUserBasedOnRole($roleId)
    {
        switch ($roleId) {
            case 1:
                return redirect()->route('admin.dashboard');
            case 2:
                return redirect()->route('kepsek.dashboard');
            case 3:
                return redirect()->route('wakel.dashboard');
            case 4:
                return redirect()->route('guru.dashboard');
            default:
                return redirect('/');
        }
    }
}
