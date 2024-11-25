<?php
namespace App\Http\Controllers\Admin\Administrasi;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PenggunaController extends Controller
{
    public function index()
    {
        $users = User::all();
        $roles = Role::where('id', '!=', 3)->get();
        $wakel = Role::all();
        return view('admin.administrasi.pengguna', compact('users','roles', 'wakel'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'role_id' => 'required|exists:role,id',
            'jns_kelamin' => 'required|in:Laki-laki,Perempuan',
            'no_hp' => 'required|numeric',
            'nip' => 'required|numeric',
            'username' => 'required|string|max:70|unique:users,username',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'role_id' => $request->role_id, 
            'jns_kelamin' => $request->jns_kelamin,
            'nip' => $request->nip,
            'no_hp' => $request->no_hp,
            'username' => $request->username,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('admin.pengguna.index')
            ->with('suksestambah', 'Data berhasil ditambahkan');
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'role_id' => 'required|exists:role,id',
            'jns_kelamin' => 'required|in:Laki-laki,Perempuan',
            'nip' => 'required|numeric',
            'no_hp' => 'required|numeric',
            'username' => 'required|string|max:70|unique:users,username,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->update([
            'role_id' => $request->role_id,
            'jns_kelamin' => $request->jns_kelamin,
            'nip' => $request->nip,
            'no_hp' => $request->no_hp,
            'username' => $request->username,
            'password' => $request->filled('password') ? Hash::make($request->input('password')) : $user->password,
        ]);

        return redirect()->route('admin.pengguna.index')
            ->with('suksesedit', 'Data berhasil diperbarui');
    }

    public function destroy($id)
    {
        $pengguna = User::find($id);

        if ($pengguna->siswa()->exists() ||
            $pengguna->pembelajaran()->exists()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data ini tidak bisa dihapus karena memiliki relasi yang terkait.'
                ], 400);
            }

        $pengguna->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil dihapus.'
        ], 200);

        return redirect()->route('admin.pengguna.index')->with('sukseshapus', 'Data berhasil dihapus.');
        // try {
        //     $user = User::findOrFail($id);
        //     $user->delete();
            
        //     return response()->json([
        //         'status' => 'success',
        //         'message' => 'Pengguna berhasil dihapus.'
        //     ]);
        // } catch (\Exception $e) {
        //     return response()->json([
        //         'status' => 'error',
        //         'message' => 'Terjadi kesalahan saat menghapus pengguna.'
        //     ]);
        // }
    }


    public function resetPassword(User $user)
    {
        $user->password = Hash::make('12345678');
        $user->save();

        return redirect()->route('admin.pengguna.index')
            ->with('suksesreset', 'Password berhasil direset');
    }
}
