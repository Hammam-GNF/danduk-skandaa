@extends('admin.layout.main')
@section('title', 'Wali Kelas')
@section('content')

<div class="container-fluid py-0 mt-4">

    <!-- Button trigger modal -->
    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#tambahwakel">
        Tambah Wali Kelas
    </button>

    <!-- Modal Tambah Wali Kelas -->
    <div class="modal fade" id="tambahwakel" tabindex="-1" aria-labelledby="tambahwakelLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahwakelLabel">Tambah Wali Kelas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('admin.wakel.store') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="user_id" class="form-label">Pilih Guru:</label>
                            <select class="form-select" id="user_id" name="user_id" required>
                                <option value="">Pilih Nama Guru</option>
                                @foreach($guru as $g)
                                    <option value="{{ $g->id }}">{{ $g->username }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="kelas_id" class="form-label">Pilih Kelas:</label>
                            <select class="form-select" id="kelas_id" name="kelas_id" required>
                                <option value="">Pilih Kelas</option>
                                @foreach($kelas as $k)
                                    <option value="{{ $k->id }}">{{ $k->kelas_tingkat }} - {{ $k->jurusan->kode_jurusan }} - {{ $k->rombel }}</option>
                                @endforeach
                            </select>
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
                    <h5 class="font-weight-bold">DAFTAR WALI KELAS</h5>
                    <div class="table-responsive mt-3">
                        <table id="daftarwakel" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Nama Wali Kelas</th>
                                    <th>NIP</th>
                                    <th>Nama Kelas</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($wakel as $x)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $x->user->username }}</td>
                                        <td>{{ $x->user->nip }}</td>
                                        <td>{{ $x->kelas->kelas_tingkat }} - {{ $x->kelas->jurusan->kode_jurusan }} - {{ $x->kelas->rombel }}</td>
                                        <td style="display: flex; align-items: center; justify-content: center;">
                                            <button type="button" class="btn btn-primary btn-sm me-2"
                                                data-bs-toggle="modal" data-bs-target="#editwakel{{ $x->id }}">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>

                                            <!-- Modal Edit Wali Kelas -->
                                            <div class="modal fade" id="editwakel{{ $x->id }}" tabindex="-1" aria-labelledby="editwakelLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="editwakelLabel">Edit Wali Kelas</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form method="POST" action="{{ route('admin.wakel.update', $x->id) }}">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label for="edit_user_id" class="form-label">Pilih Guru</label>
                                                                    <select class="form-select" id="edit_user_id" name="user_id" required>
                                                                        @foreach($user as $u)
                                                                            <option value="{{ $u->id }}" {{ $u->id == $x->user_id ? 'selected' : '' }}>
                                                                                {{ $u->username }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="edit_kelas_id" class="form-label">Pilih Kelas</label>
                                                                    <select class="form-select" id="edit_kelas_id" name="kelas_id" required>
                                                                    @foreach($kelas as $k)
                                                                    <option value="{{ $k->id }}" {{ $k->id == $x->kelas_id ? 'selected' : '' }}>
                                                                        {{ $k->kelas_tingkat }} - {{ $k->jurusan->kode_jurusan }} - {{ $k->rombel }}
                                                                    @endforeach
                                                                </div>
                                                                <div class="mb-3 form-check">
                                                                    <input type="checkbox" class="form-check-input" id="checkEditConfirmation{{ $x->id }}" required>
                                                                    <label class="form-check-label" for="checkEditConfirmation{{ $x->id }}">Saya telah memeriksa dan mengonfirmasi perubahan ini.</label>
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

                                            <!-- Form delete -->
                                            <form action="{{ route('admin.wakel.destroy', $x->id) }}" method="POST" class="delete-form" id="deleteForm{{ $x->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger btn-sm deleteButton" onclick="confirmDelete('{{ $x->id }}')">
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
                        fetch(this.closest('form').action, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            }
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

@endsection
@push('scripts')
<script>
    $(document).ready(function() {
        $('#daftarwakel').DataTable();
    });
</script>
@endpush