@extends('admin.layout.main')
@section('title', 'Pengguna')
@section('content')

<div class="container-fluid py-0 mt-4">

    <!-- Button trigger modal -->
    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#tambahPengguna">
        Tambah Pengguna
    </button>

    <!-- Modal Tambah Pengguna -->
    <div class="modal fade" id="tambahPengguna" tabindex="-1" aria-labelledby="tambahPenggunaLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahPenggunaLabel">Tambah Pengguna</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('admin.pengguna.store') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="role_id" class="form-label">Role:</label>
                            <select class="form-control" id="role_id" name="role_id">
                                <option value="">--Pilih Role--</option>
                                @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->level }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="jns_kelamin" class="form-label">Jenis Kelamin:</label>
                            <select class="form-select" id="jns_kelamin" name="jns_kelamin" required>
                                <option value="" selected disabled hidden>--Pilih Jenis Kelamin--</option>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Nama Lengkap (Username):</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="nip" class="form-label">NIP:</label>
                            <input type="number" class="form-control" id="nip" name="nip" min="0" required>
                        </div>
                        <div class="mb-3">
                            <label for="no_hp" class="form-label">No HP:</label>
                            <input type="number" class="form-control" id="no_hp" name="no_hp" min="0" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password:</label>
                            <input type="password" class="form-control" id="password" name="password" min="8" required>
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password:</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required placeholder="Harus sama dengan isi password">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="container-fluid py-4">
            <div class="card shadow-lg">
                <div class="card-body">
                    <h5 class="font-weight-bold">DAFTAR PENGGUNA</h5>
                    <div class="table-responsive mt-3">
                        <table id="daftarPengguna" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Role</th>
                                    <th>Nama Lengkap (Username)</th>
                                    <th>NIP</th>
                                    <th>Jenis Kelamin</th>
                                    <th>No HP</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $user->role->level }}</td>
                                        <td>{{ $user->username }}</td>
                                        <td>{{ $user->nip }}</td>
                                        <td>{{ $user->jns_kelamin }}</td>
                                        <td>{{ $user->no_hp }}</td>
                                        <td style="display: flex; align-items: center; justify-content: center;">
                                            <button type="button" class="btn btn-primary btn-sm me-2"
                                                data-bs-toggle="modal" data-bs-target="#editPengguna{{ $user->id }}">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>

                                            <!-- Modal Edit Pengguna -->
                                            <div class="modal fade" id="editPengguna{{ $user->id }}" tabindex="-1" aria-labelledby="editPenggunaLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="editPenggunaLabel">Edit Pengguna</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form method="POST" action="{{ route('admin.pengguna.update', $user->id) }}">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label for="edit_role_id" class="form-label">Role:</label>
                                                                    <select class="form-select" id="edit_role_id" name="role_id" required>
                                                                        <option value="">--Pilih Role--</option>
                                                                        @foreach($wakel as $w)
                                                                            <option value="{{ $w->id }}" {{ $w->id == $user->role_id ? 'selected' : '' }}>
                                                                                {{ $w->level }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="edit_jns_kelamin" class="form-label">Jenis Kelamin:</label>
                                                                    <select class="form-select" id="edit_jns_kelamin" name="jns_kelamin" required>
                                                                        <option value="" selected disabled hidden>--Pilih Jenis Kelamin--</option>
                                                                        <option value="Laki-laki" {{ $user->jns_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                                                        <option value="Perempuan" {{ $user->jns_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                                                    </select>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="edit_nip" class="form-label">NIP:</label>
                                                                    <input type="number" class="form-control" id="edit_nip" name="nip" value="{{ $user->nip }}" min="0" required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="edit_no_hp" class="form-label">No HP:</label>
                                                                    <input type="number" class="form-control" id="edit_no_hp" name="no_hp" value="{{ $user->no_hp }}" min="0" required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="edit_username" class="form-label">Nama Lengkap (Username):</label>
                                                                    <input type="text" class="form-control" id="edit_username" name="username" value="{{ $user->username }}" required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="edit_password" class="form-label">Password Baru:</label>
                                                                    <input type="password" class="form-control" id="edit_password" name="password" placeholder="masukkan password baru">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="edit_password_confirmation" class="form-label">Konfirmasi Password:</label>
                                                                    <input type="password" class="form-control" id="edit_password_confirmation" name="password_confirmation">
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-success">Save changes</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Form Delete -->
                                            <form action="{{ route('admin.pengguna.destroy', $user->id) }}" method="POST" class="delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger btn-sm deleteButton">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.deleteButton').forEach(button => {
        button.addEventListener('click', function() {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data ini akan dihapus secara permanen! Jika data ini terkait dengan entitas lain, penghapusan tidak akan dilakukan.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = this.closest('form');
                    fetch(form.action, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Content-Type': 'application/json',
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            Swal.fire(
                                'Dihapus!',
                                data.message,
                                'success'
                            ).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire(
                                'Gagal!',
                                data.message,
                                'error'
                            );
                        }
                    })
                    .catch(error => {
                        Swal.fire(
                            'Gagal!',
                            'Terjadi kesalahan saat menghapus data.',
                            'error'
                        );
                    });
                }
            });
        });
    });
</script>

@push('scripts')
<script>
    $(document).ready(function() {
        $('#daftarPengguna').DataTable();
    });
</script>
@endpush

@endsection
