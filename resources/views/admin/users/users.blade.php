@extends('partials.main')

@section('MainContent')
<div class="page-heading">
    <h3>Manajemen Akun User</h3>
</div>

<div class="mb-3">
    <button class="btn btn-info icon icon-left text-white" onclick="$('#UserTable').DataTable().ajax.reload()">
        <i class="bi bi-arrow-repeat"></i> Refresh
    </button>

    <button type="button" class="btn btn-primary icon icon-left" onclick="openModal('add')">
        <i class="bi bi-plus-lg"></i> Tambah User
    </button>
</div>

<section class="section">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table" id="UserTable">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Username</th>
                            <th>No. WA</th>
                            <th>Email</th>
                            <th>Password</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</section>

@include('admin.users.modal_manage_user.md_add_data_user')

@push('script')
<script>
    $(document).ready(function() {
        $('#UserTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('/fetch_data_user') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                { data: 'username', name: 'username' },
                { data: 'no_wa', name: 'no_wa' },
                { data: 'email', name: 'email' },
                {
                    data: null,
                    render: function() { return '********'; }
                },
                {
                    data: null,
                    render: function(data) {
                        return `
                            <button class="btn btn-info text-white" onclick="openModal('edit', '${data.id_user}')">
                                <i class='bi bi-pencil-square'></i>
                            </button>
                            <button class="btn btn-danger text-white" onclick="hapus_user(${data.id_user})">
                                <i class='bi bi-trash'></i>
                            </button>
                        `;
                    }
                }
            ],
        });
    });

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
