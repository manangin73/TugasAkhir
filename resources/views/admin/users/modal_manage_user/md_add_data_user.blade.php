{{-- File: admin.users.modal_manage_user.md_add_data_user.blade.php --}}

<div class="modal fade" id="UserModal" tabindex="-1" aria-labelledby="UserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="UserModalLabel">Form Manajemen User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="UserForm" method="POST" enctype="multipart/form-data">
                @csrf
                {{-- Field Tersembunyi: ID User dan Method (PUT untuk update) --}}
                <input type="hidden" name="id_user" id="id_user_modal">
                <input type="hidden" name="_method" id="_method_modal" value="POST"> 

                <div class="modal-body">
                    
                    {{-- FIELD ROLE BARU --}}
                    <div class="form-group" id="role-group">
                        <label for="user_role">Role User</label>
                        <select name="user_role" id="user_role" class="form-control" required>
                            <option value="">-- Pilih Role --</option>
                            <option value="user">USER (Peminjam)</option>
                            <option value="ukmbs">UKMBS (Admin Alat)</option>
                            <option value="k3l">K3L (Validator)</option>
                            <option value="admin">ADMIN (Super Admin)</option>
                        </select>
                    </div>
                    
                    {{-- Field Input Lainnya --}}
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" name="username" id="username" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="no_wa">No. WA</label>
                        <input type="text" name="no_wa" id="no_wa" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password (Kosongkan jika tidak diubah)</label>
                        <input type="password" name="password" id="password" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="foto_user">Foto Profil</label>
                        <input type="file" name="foto_user" id="foto_user" class="form-control">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary" id="btnSave">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>