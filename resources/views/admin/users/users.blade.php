@extends('partials.main')

@section('MainContent')
<div class="page-heading mb-4">
    <h3 class="fw-bold text-white">Manajemen Akun User</h3>
</div>

<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <div>
        <button class="btn btn-info text-white" onclick="$('#UserTable').DataTable().ajax.reload()">
            <i class="bi bi-arrow-repeat"></i> Refresh
        </button>

        <button type="button" class="btn btn-primary" onclick="openModal('add')">
            <i class="bi bi-plus-lg"></i> Tambah User
        </button>
    </div>
</div>

<section class="section">
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Daftar Akun User</h5>
        </div>
        <div class="card-body bg-dark text-white">
            <div class="table-responsive">
                <table class="table table-dark table-striped align-middle text-center" id="UserTable" width="100%">
                    <thead class="table-light text-dark">
                        <tr>
                            <th style="width: 5%">No.</th>
                            <th style="width: 15%">Username</th>
                            <th style="width: 10%">Role</th>
                            <th style="width: 15%">No. WA</th>
                            <th style="width: 25%">Email</th>
                            <th style="width: 20%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</section>

@include('admin.users.modal_manage_user.md_add_data_user')

@push('style')
<style>
    /* ======================= THEME STYLING ======================= */
    body {
        background-color: #0d0d1a;
        color: #fff;
    }

    .page-heading h3 {
        color: #fff;
        border-left: 4px solid #0dcaf0;
        padding-left: 10px;
    }

    .table thead th {
        vertical-align: middle;
        font-weight: 600;
    }

    .table td, .table th {
        white-space: nowrap;
    }

    .btn-sm {
        padding: 5px 10px !important;
        font-size: 0.85rem !important;
    }

    /* DataTables Search & Pagination Styling */
    .dataTables_wrapper .dataTables_filter input {
        border-radius: 6px;
        border: 1px solid #444;
        background: #1e1e2e;
        color: #fff;
        padding: 5px 10px;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        border-radius: 6px;
        color: #fff !important;
        background: #1e1e2e !important;
        margin: 0 2px;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: #0dcaf0 !important;
        color: #000 !important;
    }

    .card {
        background-color: #1b1b2f !important;
        color: #fff;
    }

    .card-header {
        background-color: #141428 !important;
        border-bottom: 1px solid #222;
    }

    .btn-info {
        background-color: #0dcaf0;
        border-color: #0dcaf0;
    }

    .btn-info:hover {
        background-color: #31d2f2;
        border-color: #25cff2;
    }

    .btn-danger {
        background-color: #e74c3c;
        border-color: #e74c3c;
    }

    .btn-danger:hover {
        background-color: #c0392b;
        border-color: #c0392b;
    }
</style>
@endpush

@push('script')
<script>
$(document).ready(function() {
    // ==================== DATATABLE INIT ====================
    $('#UserTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ url('/fetch_data_user') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'username', name: 'username' },
            { data: 'user_role', name: 'user_role', render: function(data) { return data.toUpperCase(); } },
            { data: 'no_wa', name: 'no_wa' },
            { data: 'email', name: 'email' },
            {
                data: null,
                render: function(data) {
                    return `
                        <div class="d-flex justify-content-center gap-2">
                            <button class="btn btn-info btn-sm text-white" onclick="openModal('edit', '${data.id_user}')">
                                <i class='bi bi-pencil-square'></i> Edit
                            </button>
                            <button class="btn btn-danger btn-sm text-white" onclick="hapus_user(${data.id_user})">
                                <i class='bi bi-trash'></i> Hapus
                            </button>
                        </div>
                    `;
                }
            }
        ],
    });

    // ==================== FORM HANDLER ====================
    $('#UserForm').on('submit', function(e) {
        e.preventDefault();

        const form = $(this);
        const url = form.attr('action');
        const formData = new FormData(this); 

        if ($('#_method_modal').val() === 'PUT') {
            formData.append('_method', 'PUT'); 
        }

        $.ajax({
            url: url,
            type: 'POST', 
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                Swal.fire('Berhasil!', response.message || 'Data berhasil disimpan.', 'success'); 
                $('#UserModal').modal('hide'); 
                $('#UserTable').DataTable().ajax.reload(); 
            },
            error: function(xhr) {
                let errorMessage = 'Gagal menyimpan data.';
                if (xhr.responseJSON) {
                    if (xhr.responseJSON.msg) {
                        const errors = xhr.responseJSON.msg;
                        errorMessage = 'Validasi Gagal! ' + Object.keys(errors).map(key => errors[key][0]).join('; ');
                    } else if (xhr.responseJSON.error) {
                        errorMessage = xhr.responseJSON.error;
                    }
                }
                Swal.fire('Gagal!', errorMessage, 'error');
            }
        });
    });
});

// ==================== MODAL HANDLER ====================
function openModal(mode, id_user = null) {
    $('#UserForm')[0].reset();
    $('#_method_modal').val('POST'); 
    $('#user_role').prop('disabled', false); 

    if (mode === 'add') {
        $('#UserModalLabel').text('Tambah User Baru');
        $('#UserForm').attr('action', '{{ url("/add_data_user") }}');
        $('#password').attr('required', true); 
    } 
    else if (mode === 'edit') {
        $('#UserModalLabel').text('Edit User dan Role');
        $('#UserForm').attr('action', `/edit_data_user/${id_user}`); 
        $('#_method_modal').val('PUT'); 
        $('#id_user_modal').val(id_user);
        $('#password').attr('required', false); 

        $.ajax({
            url: `/showById_data_user/${id_user}`,
            type: 'POST', 
            data: { "_token": "{{ csrf_token() }}" },
            success: function(data) {
                $('#username').val(data.username);
                $('#email').val(data.email);
                $('#no_wa').val(data.no_wa);
                $('#user_role').val(data.user_role); 
            },
            error: function() {
                alert('Gagal memuat data user.');
            }
        });
    }
    $('#UserModal').modal('show');
}

// ==================== HAPUS USER ====================
function hapus_user(id_user) {
    Swal.fire({
        title: "Apakah yakin ingin hapus?",
        text: "Data user akan dihapus permanen.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya, hapus!"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/hapus_data_user/${id_user}`,
                type: 'DELETE',
                data: { "_token": "{{ csrf_token() }}" },
                success: function() {
                    Swal.fire('Berhasil!', 'User telah dihapus.', 'success');
                    $('#UserTable').DataTable().ajax.reload();
                },
                error: function() {
                    Swal.fire('Gagal!', 'Terjadi kesalahan saat menghapus.', 'error');
                }
            });
        }
    });
}
</script>
@endpush
@endsection
