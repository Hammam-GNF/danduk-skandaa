<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $user = User::all();
        return view('user', compact('user'));
    }

    public function store(Request $request)
    {
        $user = new User;
        $user->role_id = $request->input('role_id');
        $user->username = $request->input('username');
        $user->password = $request->input('password');
        $user->save();

        return redirect()->route('user.index')
            ->with('suksestambah', 'Data berhasil ditambahkan')
            ->with('hideAlert', false); // Pastikan hideAlert disetel ke false setelah operasi penambahan data
    }

    public function update(Request $request, $id)
    {
        $user = User::findorFail($id);
        $user->update($request->all());

        return redirect()->back()
            ->with('suksesedit', 'Data berhasil diperbarui')
            ->with('hideAlert', false); // Pastikan hideAlert disetel ke false setelah operasi pembaruan data
    }

    public function destroy($id)
    {
        $user = User::where('id', $id)->first();
        $user = User::find($id);
        $user->delete();
        return redirect()->route('user.index');
    }

    public function resetpassword($id)
    {
        $user = User::findorFail($id);
        $user->password = Hash::make(12345678);
        $user->save();
        
        return redirect()-> back();
    }
}