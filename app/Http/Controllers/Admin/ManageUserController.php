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
// --- PERBAIKAN FATAL ERROR: Tambahkan Facades yang Hilang ---
use Illuminate\Support\Facades\Validator; 
use Illuminate\Support\Facades\Storage; // Ditambahkan karena fitur destroy/update foto butuh ini
// -----------------------------------------------------------


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
        // Menggunakan $request->validate() yang sudah benar
        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'no_wa'    => 'required|string|max:20',
            'email'    => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
            // Tambahkan validasi user_role jika ada di form tambah
            'user_role' => 'required|in:admin,k3l,ukmbs,user', 
        ]);

        $validated['password'] = Hash::make($validated['password']);
        
        // Hapus: $validated['user_role'] = 'user'; jika sudah divalidasi di atas

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
     * Update data user (Termasuk Role)
     */
    public function update(Request $request, $id_user)
    {
        try {
            $user = User::find($id_user);
    
            if (!$user) {
                return response()->json(['error' => 'Data user tidak ditemukan'], 404);
            }
            
            // 1. VALIDASI INPUT (TERMASUK user_role)
            $validated = $request->validate([
                'username' => 'required|string|max:255',
                'no_wa'    => 'required|string|max:20',
                // Unique email kecuali ID user saat ini
                'email'    => 'required|email|max:255|unique:users,email,' . $id_user . ',id_user', 
                'password' => 'nullable|string|min:6',
                // Logika Role
                'user_role' => 'required|in:admin,k3l,ukmbs,user', 
                // Logika Foto
                'foto_user' => 'nullable|image|mimes:png,jpg,jpeg|max:1024', 
            ]);
            
            // 2. LOGIC UPDATE DATA & ROLE
            
            // Hapus field password jika kosong (mempertahankan password lama)
            if ($request->filled('password')) {
                $validated['password'] = Hash::make($request->password);
            } else {
                unset($validated['password']);
            }
            
            // 3. LOGIC FOTO (Anda harus memasukkan ini jika ingin fitur upload foto berfungsi di method update)
            if ($request->hasFile('foto_user')) {
                // Hapus foto lama
                if ($user->foto_user) {
                    Storage::disk('public')->delete('img_upload/data_user/' . $user->foto_user);
                }
                
                // Simpan foto baru
                $img = $request->file('foto_user');
                $nama_img = time() . '-' . str_replace(' ', '_', $validated['username']) . '.' . $img->getClientOriginalExtension();
                $img->storeAs('img_upload/data_user', $nama_img, 'public');
                $validated['foto_user'] = $nama_img;
            } else {
                // Hapus foto_user dari validated array jika tidak ada file baru (untuk mempertahankan foto lama)
                unset($validated['foto_user']);
            }
            
            // 4. JALANKAN UPDATE
            $user->update($validated);
    
            return response()->json(['message' => 'Data user berhasil diubah.'], 200);
    
        } catch (\Exception $e) {
            // Log::error('User update error: ' . $e->getMessage()); // Aktifkan ini untuk debugging server
            
            // Mengatasi Error Validasi untuk dikembalikan ke AJAX (Jika status 422)
            if (isset($e->status) && $e->status === 422) {
                 return response()->json(['msg' => $e->errors()], 422);
            }

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
        // ... (metode destroy tidak berubah) ...
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
        // Catatan: Method ini sudah tidak diperlukan jika logic update role dipindahkan ke method update()
        // Namun, jika route Anda masih menggunakannya, ini tetap harus ada.
        
        // 1. Validasi Input
        $validated = $request->validate([
            'user_role' => 'required|in:admin,k3l,ukmbs,user', 
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