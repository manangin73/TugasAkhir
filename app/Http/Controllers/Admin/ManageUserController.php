<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth; 


class ManageUserController extends Controller
{
    /**
     * Tampilkan halaman manajemen user
     */
    public function index()
    {
        return view('admin.users.users');
    }

    /**
     * Ambil data user untuk DataTables (AJAX)
     */
    public function data_index()
    {
        $users = User::select('id_user', 'username', 'no_wa', 'email', 'user_role')->get();

        return DataTables::of($users)
            ->addIndexColumn()
            ->make(true);
    }

    /**
     * Simpan user baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'no_wa'    => 'required|string|max:20',
            'email'    => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['user_role'] = 'user';

        User::create($validated);

        return response()->json(['message' => 'User berhasil ditambahkan.'], 200);
    }

    /**
     * Tampilkan detail user berdasarkan ID
     */
    public function showById($id_user)
    {
        $user = User::find($id_user);

        if (!$user) {
            return response()->json(['error' => 'Data user tidak ditemukan'], 404);
        }

        return response()->json($user, 200);
    }

    /**
     * Update data user
     */
    public function update(Request $request, $id_user)
    {
        try {
            $user = User::find($id_user);
    
            if (!$user) {
                return response()->json(['error' => 'Data user tidak ditemukan'], 404);
            }
    
            $validated = $request->validate([
                'username' => 'required|string|max:255',
                'no_wa'    => 'required|string|max:20',
                'email'    => 'required|email|max:255|unique:users,email,' . $id_user . ',id_user',
                'password' => 'nullable|string|min:6',
            ]);
    
            if ($request->filled('password')) {
                $validated['password'] = Hash::make($request->password);
            } else {
                unset($validated['password']);
            }
    
            $user->update($validated);
    
            return response()->json(['message' => 'Data user berhasil diubah.'], 200);
    
        } catch (\Exception $e) {
            Log::error('User update error: ' . $e->getMessage());
            return response()->json([
                'error' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Hapus data user (beserta foto jika ada)
     */
    public function destroy($id_user)
    {
        $user = User::find($id_user);

        if (!$user) {
            return response()->json(['error' => 'Data user tidak ditemukan'], 404);
        }

        // Jika user memiliki foto, hapus juga file-nya
        if (!empty($user->foto_user)) {
            $path = public_path('storage/img_upload/data_user/' . $user->foto_user);
            if (File::exists($path)) {
                File::delete($path);
            }
        }

        $user->delete();

        return response()->json(['message' => 'Data user berhasil dihapus.'], 200);
    }

    public function updateRole(Request $request, $id_user)
{
    // 1. Validasi Input
    $validated = $request->validate([
        'user_role' => 'required|in:admin,k3l,ukmbs,user', // Pastikan roles valid
    ]);

    // 2. Cari User
    $user = User::find($id_user);

    if (!$user) {
        return response()->json(['error' => 'Data user tidak ditemukan'], 404);
    }
    
    // Opsional: Larang Admin mengubah role-nya sendiri (opsi keamanan)
    if ($user->id_user === Auth::id() && $user->user_role !== $validated['user_role']) {
         return response()->json(['error' => 'Anda tidak bisa mengubah role Anda sendiri.'], 403);
    }

    // 3. Update Role
    $user->user_role = $validated['user_role'];
    $user->save();

    return response()->json(['message' => 'Role user berhasil diubah menjadi ' . $user->user_role . '.'], 200);
}
}
