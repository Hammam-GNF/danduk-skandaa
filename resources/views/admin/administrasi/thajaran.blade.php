@extends('admin.layout.main')
@section('title', 'Daftar Tahun Ajaran')
@section('content')

    <div class="container-fluid py-0 mt-4">

        <!-- Button trigger modal -->
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#tambahthajaran">
            Tambah Tahun Ajaran
        </button>

        <!-- Modal Tambah Tahun Ajaran -->
        <form method="POST" action="{{ route('admin.thajaran.store') }}">
            @csrf
            <div class="modal fade" id="tambahthajaran" tabindex="-1" aria-labelledby="tambahthajaranLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="tambahthajaranLabel">Tambah Tahun Ajaran</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="thajaran" class="form-label">Tahun Ajaran:</label>
                                <input type="text" class="form-control" id="thajaran" name="thajaran"
                                    placeholder="contoh : 2022/2023" required>
                            </div>
                            <div class="mb-3">
                                <label for="semester" class="form-label">Semester:</label>
                                <select class="form-select" id="semester" name="semester" required>
                                    <option value="">---Pilih Semester---</option>
                                    <option value="Ganjil">Ganjil</option>
                                    <option value="Genap">Genap</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <!-- Daftar Tahun Ajaran -->
        <div class="row mt-3">
            <div class="container-fluid py-4">
                <div class="row">
                    <div class="col-xl-12 col-sm-5 mb-xl-0 mb-4">
                        <div class="card" style="box-shadow: 0px 0px 10px 7px rgba(76, 0, 255, 0.401);">
                            <div class="card-body p-3">
                                <div class="row">
                                    <div class="col-50">
                                        <div class="numbers">
                                            <h5 class="font-weight-bolder">DAFTAR TAHUN AJARAN</h5>
                                            <div class="card-body px-0 pt-0 pb-2">
                                                <div class="table-responsive p-0">
                                                    <table id="daftarthajaran" class="table table-striped table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th class="text-center"> No</th>
                                                                <th> Tahun Ajaran</th>
                                                                <th> Semester</th>
                                                                <th class="text-center"> Status</th>
                                                                <th class="text-center"> Aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($thajaran as $t)
                                                                <tr>
                                                                    <td class="text-center">{{ $loop->iteration }}</td>
                                                                    <td>{{ $t->thajaran }}</td>
                                                                    <td>{{ $t->semester }}</td>
                                                                    <td class="text-center">
                                                                        @if ($t->status == 'aktif')
                                                                            <span class="badge bg-success">Aktif</span>
                                                                        @else
                                                                            <a href="{{ route('admin.thajaran.aktifkan', $t->id) }}" class="badge bg-danger">Tidak Aktif</a>
                                                                        @endif
                                                                    </td>
                                                                    <td class="align-middle-center"
                                                                        style="display: flex; align-items: center; justify-content: center;">
                                                                        <!-- Button Edit -->
                                                                        <button type="button"
                                                                            class="btn btn-primary btn-sm me-2"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#editthajaran{{ $t->id }}">
                                                                            <i class="bi bi-pencil-square"></i>
                                                                        </button>

                                                                        <!-- Modal Edit -->
                                                                        <div class="modal fade"
                                                                            id="editthajaran{{ $t->id }}"
                                                                            tabindex="-1"
                                                                            aria-labelledby="editthajaranLabel"
                                                                            aria-hidden="true">
                                                                            <div class="modal-dialog">
                                                                                <form method="POST"
                                                                                    action="{{ route('admin.thajaran.update', $t->id) }}">
                                                                                    @csrf
                                                                                    @method('PUT')
                                                                                    <div class="modal-content">
                                                                                        <div class="modal-header">
                                                                                            <h5 class="modal-title"
                                                                                                id="editthajaranLabel">Edit
                                                                                                Tahun Ajaran</h5>
                                                                                            <button type="button"
                                                                                                class="btn-close"
                                                                                                data-bs-dismiss="modal"
                                                                                                aria-label="Close"></button>
                                                                                        </div>
                                                                                        <div class="modal-body">
                                                                                            <div class="mb-3">
                                                                                                <label for="edit_thajaran"
                                                                                                    class="form-label">Tahun
                                                                                                    Ajaran:</label>
                                                                                                <input type="text"
                                                                                                    class="form-control"
                                                                                                    id="edit_thajaran"
                                                                                                    name="thajaran"
                                                                                                    value="{{ $t->thajaran }}"
                                                                                                    required>
                                                                                            </div>
                                                                                            <div class="mb-3">
                                                                                                <label for="edit_semester"
                                                                                                    class="form-label">Semester:</label>
                                                                                                <select class="form-select"
                                                                                                    id="edit_semester"
                                                                                                    name="semester"
                                                                                                    required>
                                                                                                    <option value="Ganjil"
                                                                                                        {{ $t->semester == 'Ganjil' ? 'selected' : '' }}>
                                                                                                        Ganjil</option>
                                                                                                    <option value="Genap"
                                                                                                        {{ $t->semester == 'Genap' ? 'selected' : '' }}>
                                                                                                        Genap</option>
                                                                                                </select>
                                                                                            </div>
                                                                                            <!-- Checklist -->
                                                                                            <div class="mb-3 form-check">
                                                                                                <input type="checkbox"
                                                                                                    class="form-check-input"
                                                                                                    id="checkEditConfirmation{{ $t->id }}"
                                                                                                    required>
                                                                                                <label
                                                                                                    class="form-check-label"
                                                                                                    for="checkEditConfirmation{{ $t->id }}">Saya telah memeriksa dan mengonfirmasi perubahan ini.</label>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="modal-footer">
                                                                                            <button type="button"
                                                                                                class="btn btn-secondary"
                                                                                                data-bs-dismiss="modal">Close</button>
                                                                                            <button type="submit"
                                                                                                class="btn btn-success">Save
                                                                                                changes</button>
                                                                                        </div>
                                                                                    </div>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                        <!-- Form Delete -->
                                                                        <form
                                                                            action="{{ route('admin.thajaran.destroy', $t->id) }}"
                                                                            method="POST" class="d-inline">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="button"
                                                                                class="btn btn-danger btn-sm deleteButton">
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
        $('#daftarthajaran').DataTable();
    });
</script>
@endpush