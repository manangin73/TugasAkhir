{{-- MODAL TAMBAH / EDIT USER --}}
<div class="modal fade" id="add_user" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="title_header"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="form-group mb-3">
                    <label for="username_edit">Username</label>
                    <input type="text" id="username_edit" name="username" class="form-control" required>
                </div>

                <div class="form-group mb-3">
                    <label for="no_wa_edit">No. WA</label>
                    <input type="text" id="no_wa_edit" name="no_wa" class="form-control" required>
                </div>

                <div class="form-group mb-3">
                    <label for="email_edit">Email</label>
                    <input type="email" id="email_edit" name="email" class="form-control" required>
                </div>

                <div class="form-group mb-3">
                    <label for="password_edit">Password</label>
                    <input type="password" id="password_edit" name="password" class="form-control">
                    <small class="text-muted">Kosongkan jika tidak ingin mengubah password || Minimal 6 karakter</small>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="BtnDataUser"></button>
            </div>
        </div>
    </div>
</div>

@push('script')
<script>
    // === FUNGSI UNTUK BUKA MODAL TAMBAH / EDIT ===
    function openModal(action, id_user = null) {
        $("#add_user").modal("show");

        const $title_header = $("#title_header");
        const $btnDataUser = $("#BtnDataUser");

        // Reset input
        $('#username_edit').val("");
        $('#no_wa_edit').val("");
        $('#email_edit').val("");
        $('#password_edit').val("");

        if (action === 'add') {
            $title_header.text("Tambah Data User");
            $btnDataUser.text("Simpan");
            $btnDataUser.off('click').on("click", function() {
                saveuser("add");
            });
        } else if (action === 'edit') {
            $title_header.text("Edit Data User");
            $btnDataUser.text("Ubah");
            show_byId_user(id_user);
            $btnDataUser.off('click').on("click", function() {
                saveuser("edit", id_user);
            });
        }
    }

    // === AMBIL DATA USER BERDASARKAN ID ===
    function show_byId_user(id_user) {
        $.ajax({
            url: "{{ url('/showById_data_user') }}/" + id_user,
            method: 'POST',
            data: { "_token": "{{ csrf_token() }}" },
            dataType: 'json',
            success: function(response) {
                $('#username_edit').val(response.username);
                $('#no_wa_edit').val(response.no_wa);
                $('#email_edit').val(response.email);
                $('#password_edit').val('');
            },
            error: function(xhr, status, error) {
                console.error('Terjadi kesalahan:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Terjadi kesalahan saat mengambil data user.',
                });
            }
        });
    }

    // === SIMPAN / UPDATE DATA USER ===
    function saveuser(action, id_user = null) {
        const username = $('#username_edit').val();
        const no_wa = $('#no_wa_edit').val();
        const email = $('#email_edit').val();
        const password = $('#password_edit').val();

        if (!username || !no_wa || !email) {
            Swal.fire({
                icon: 'warning',
                title: 'Form belum lengkap!',
                text: 'Harap isi semua kolom yang diperlukan.',
            });
            return;
        }

        const url = action === 'add'
            ? "{{ url('/add_data_user') }}"
            : "{{ url('/edit_data_user') }}/" + id_user;

        const method = action === 'add' ? 'POST' : 'PUT';

        $.ajax({
            url: url,
            type: method,
            data: {
                "_token": "{{ csrf_token() }}",
                username: username,
                no_wa: no_wa,
                email: email,
                password: password
            },
            success: function(response) {
                Swal.fire('Berhasil!', response.message, 'success');
                $('#UserTable').DataTable().ajax.reload();
                $("#add_user").modal('hide');
            },
            error: function(xhr) {
                console.error(xhr.responseText);
                let res = JSON.parse(xhr.responseText);
                Swal.fire('Gagal!', res.error ?? 'Terjadi kesalahan saat menyimpan data.', 'error');
            }
        });
    }
</script>
@endpush
