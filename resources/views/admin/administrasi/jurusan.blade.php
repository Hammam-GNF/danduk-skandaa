@extends('admin.layout.main')
@section('title', 'Daftar Jurusan')
@section('content')

<div class="container-fluid py-0 mt-4">

    <!-- Button trigger modal -->
    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#tambahjurusan">
        Tambah Jurusan
    </button>
    <!-- Modal -->
    <form method="POST" action="{{ route('admin.jurusan.store') }}">
        @csrf
        <div class="modal fade" id="tambahjurusan" tabindex="-1" aria-labelledby="tambahjurusanLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="tambahjurusanLabel">Tambah Jurusan</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-1">
                            <label for="kode_jurusan" class="col-form-label">Kode Jurusan:</label>
                            <input type="text" class="form-control" id="kode_jurusan" name="kode_jurusan" placeholder="contoh : TKR" required>
                        </div>
                        <div class="mb-1">
                            <label for="nama_jurusan" class="col-form-label">Nama Jurusan:</label>
                            <input type="text" class="form-control" id="nama_jurusan" name="nama_jurusan" placeholder="contoh : Teknik Kendaraan Ringan" required>
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

    <div class="row mt-3">
        <div class="col-xl-12 col-sm-5 mb-xl-0 mb-4">
            <div class="card" style="box-shadow: 0px 0px 10px 7px rgba(76, 0, 255, 0.401);">
                <div class="card-body p-3">
                    <h5 class="font-weight-bolder">DAFTAR JURUSAN</h5>
                    <div class="table-responsive">
                        <table id="daftarjurusan" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Kode Jurusan</th>
                                    <th>Nama Jurusan</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($jurusan as $x)
                                <tr id="row{{ $x->id }}">
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $x->kode_jurusan }}</td>
                                    <td>{{ $x->nama_jurusan }}</td>
                                    <td style="display: flex; align-items: center; justify-content: center;">
                                        <!-- Button Edit -->
                                        <button type="button" class="btn btn-primary btn-sm me-2" data-bs-toggle="modal" data-bs-target="#editjurusan{{ $x->id }}">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>

                                        <!-- Modal Edit -->
                                        <div class="modal fade" id="editjurusan{{ $x->id }}" tabindex="-1" aria-labelledby="editjurusanLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <form method="POST" action="{{ route('admin.jurusan.update', $x->id) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Edit Jurusan</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <!-- Input ID Jurusan -->
                                                            <div class="mb-3">
                                                                <label for="kode_jurusan" class="form-label">ID Jurusan:</label>
                                                                <input type="text" class="form-control" id="kode_jurusan" name="kode_jurusan" value="{{ $x->kode_jurusan }}">
                                                            </div>
                                                            <!-- Input Nama Jurusan -->
                                                            <div class="mb-3">
                                                                <label for="nama_jurusan" class="form-label">Nama Jurusan:</label>
                                                                <input type="text" class="form-control" id="nama_jurusan" name="nama_jurusan" value="{{ $x->nama_jurusan }}">
                                                            </div>
                                                            <!-- Checklist -->
                                                            <div class="mb-3 form-check">
                                                                <input type="checkbox" class="form-check-input" id="checkEditConfirmation{{ $x->id }}" required>
                                                                <label class="form-check-label" for="checkEditConfirmation{{ $x->id }}">Saya telah memeriksa dan mengonfirmasi perubahan ini.</label>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-success">Save changes</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                        <!-- Form Delete -->
                                        <form action="{{ route('admin.jurusan.destroy', $x->id) }}" method="POST" class="delete-form">
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

<!-- SweetAlert JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- SweetAlert Delete Confirmation -->
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
        $('#daftarjurusan').DataTable();
    });
</script>
@endpush