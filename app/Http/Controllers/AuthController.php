<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        // Jika pengguna sudah login, arahkan mereka ke dashboard yang sesuai
        if (Auth::check()) {
            $user = Auth::user();
            
            // Redirect berdasarkan role pengguna
            return $this->redirectUserBasedOnRole($user->role_id);
        }
        
        // Tampilkan halaman login jika pengguna belum login
        return view('login');
    }

    public function actionLogin(Request $request)
    {
        // Validasi input login
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('username', 'password');

        // Cek kredensial dan login
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            
            // Redirect berdasarkan role pengguna setelah login berhasil
            return $this->redirectUserBasedOnRole($user->role_id);
        } else {
            // Kembali dengan pesan error jika login gagal
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
        // Redirect berdasarkan role pengguna
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
