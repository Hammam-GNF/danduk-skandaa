@extends('admin.layout.main')
@section('title', 'Daftar Mata Pelajaran')
@section('content')

    <div class="container-fluid py-0 mt-4">

        <!-- Button trigger modal -->
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#tambahmapel">
            Tambah Mata Pelajaran
        </button>
        <!-- Modal -->
        <form method="POST" action="{{ route('admin.mapel.store') }}">
            @csrf
            <div class="modal fade" id="tambahmapel" tabindex="-1" aria-labelledby="tambahmapelLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="tambahmapelLabel">Tambah Mata Pelajaran</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="kode_mapel" class="form-label">Kode Mata Pelajaran:</label>
                                <input type="text" class="form-control" id="kode_mapel" name="kode_mapel" placeholder="contoh: TKR" required>
                            </div>
                            <div class="mb-3">
                                <label for="nama_mapel" class="form-label">Nama Mapel:</label>
                                <input type="text" class="form-control" id="nama_mapel" name="nama_mapel"
                                    placeholder="contoh: Teknik Kendaraan Ringan" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Tambah</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <div class="row mt-3">
            <div class="container-fluid py-4">
                <div class="card shadow-lg">
                    <div class="card-body">
                        <h5 class="font-weight-bold">DAFTAR MATA PELAJARAN</h5>
                        <div class="table-responsive mt-3">
                            <table id="daftarmapel" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Kode Mata Pelajaran</th>
                                        <th>Nama Mata Pelajaran</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($mapel as $x)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $x->kode_mapel }}</td>
                                            <td>{{ $x->nama_mapel }}</td>
                                            <td style="display: flex; align-items: center; justify-content: center;">
                                                <button type="button" class="btn btn-primary btn-sm me-2"
                                                    data-bs-toggle="modal" data-bs-target="#editmapel{{ $x->id }}">
                                                    <i class="bi bi-pencil-square"></i>
                                                </button>

                                                <!-- Modal Edit -->
                                                <form method="POST" action="{{ route('admin.mapel.update', $x->id) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal fade" id="editmapel{{ $x->id }}"
                                                        tabindex="-1" aria-labelledby="editmapelLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="editmapelLabel">Edit Mata
                                                                        Pelajaran</h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="mb-3">
                                                                        <label for="kode_mapel" class="form-label">Kode
                                                                            Mapel:</label>
                                                                        <input type="text" class="form-control"
                                                                            id="kode_mapel" name="kode_mapel"
                                                                            value="{{ $x->kode_mapel }}" required>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="nama_mapel" class="form-label">Nama
                                                                            Mapel:</label>
                                                                        <input type="text" class="form-control"
                                                                            id="nama_mapel" name="nama_mapel"
                                                                            value="{{ $x->nama_mapel }}" required>
                                                                    </div>
                                                                    <div class="mb-3 form-check">
                                                                        <input type="checkbox" class="form-check-input"
                                                                            id="checkEditConfirmation{{ $x->kode_mapel }}"
                                                                            required>
                                                                        <label class="form-check-label"
                                                                            for="checkEditConfirmation{{ $x->kode_mapel }}">Saya telah memeriksa dan mengonfirmasi perubahan ini.</label>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Close</button>
                                                                    <button type="submit"
                                                                        class="btn btn-primary">Update</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>

                                                <!-- Form Delete -->
                                                <form action="{{ route('admin.mapel.destroy', ['mapel' => $x->id]) }}"
                                                    method="POST" class="d-inline">
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
                        // Submit the form
                        this.closest('form').submit();
                    }
                });
            });
        });
    </script>

@endsection
@push('scripts')
<script>
    $(document).ready(function() {
        $('#daftarmapel').DataTable();
    });
</script>
@endpush