@extends('admin.layout.main')
@section('title', 'Daftar Siswa')
@section('content')

    <div class="container-fluid py-0 mt-4">
        <div class="row">
            <div class="container-fluid py-4">
                <div class="row">
                    <div class="col-xl-12 col-sm-5 mb-xl-0 mb-4">
                        <div class="card" style="box-shadow: 0px 0px 10px 7px rgba(76, 0, 255, 0.401);">
                            <div class="card-body p-3">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="numbers">
                                            <h5 class="font-weight-bolder">DAFTAR SISWA</h5>
                                            <br>
                                            <a href="{{ route('admin.siswa.create') }}" class="btn btn-danger">
                                                <i class="bi bi-plus-square"></i>
                                                Siswa
                                            </a>

                                            <div class="table-responsive">
                                                <table id="daftarsiswa" class="table table-striped table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">NO</th>
                                                            <th>NIS</th>
                                                            <th>Nama Siswa</th>
                                                            <th>Jenis Kelamin</th>
                                                            <th class="text-center">Nama Kelas</th>
                                                            <th>Status</th>
                                                            <th>Tahun Ajaran</th>
                                                            <th class="text-center">Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($siswa as $x)
                                                            <tr>
                                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                                <td class="text-center">{{ $x->nis }}</td>
                                                                <td>{{ $x->nama_siswa }}</td>
                                                                <td class="text-center">{{ $x->jns_kelamin }}</td>
                                                                <td class="text-center">
                                                                    {{ $x->kelas->kelas_tingkat }} - {{ $x->kelas->jurusan->kode_jurusan }} - {{ $x->kelas->rombel }}
                                                                </td>
                                                                <td class="text-center">
                                                                    @if ($x->status == 'Aktif')
                                                                        <span
                                                                            class="badge bg-success">{{ $x->status }}</span>
                                                                    @else
                                                                        <span
                                                                            class="badge bg-danger">{{ $x->status }}</span>
                                                                    @endif
                                                                </td>
                                                                <td class="text-center">{{ $x->thajaran->thajaran }} - {{ $x->thajaran->semesterLabel }}</td>

                                                                <td class="align-middle-center"
                                                                    style="display: flex; align-items: center; justify-content: center;">
                                                                    <a href="{{ route('admin.siswa.edit', ['nis' => $x->nis]) }}"
                                                                        class="btn btn-primary btn-sm me-2"
                                                                        data-toggle="tooltip"
                                                                        data-original-title="Edit siswa">
                                                                        <i class="bi bi-pencil-square"></i>
                                                                    </a>
                                                                    <button type="button" class="btn btn-danger btn-sm"
                                                                        data-toggle="tooltip"
                                                                        data-original-title="Hapus siswa"
                                                                        data-nis="{{ $x->nis }}"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#hapusSiswa{{ $x->nis }}">
                                                                        <i class="bi bi-trash"></i>
                                                                    </button>
                                                                    <form id="deleteForm{{ $x->nis }}" method="POST"
                                                                        action="{{ route('admin.siswa.destroy', ['nis' => $x->nis]) }}">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <div class="modal fade"
                                                                            id="hapusSiswa{{ $x->nis }}"
                                                                            tabindex="-1"
                                                                            aria-labelledby="hapusSiswaLabel{{ $x->nis }}"
                                                                            aria-hidden="true">
                                                                            <div class="modal-dialog modal-dialog-centered">
                                                                                <div class="modal-content">
                                                                                    <div class="modal-header">
                                                                                        <h1 class="modal-title fs-5"
                                                                                            id="hapusSiswaLabel{{ $x->nis }}">
                                                                                            Hapus Siswa</h1>
                                                                                        <button type="button"
                                                                                            class="btn-close"
                                                                                            data-bs-dismiss="modal"
                                                                                            aria-label="Close"></button>
                                                                                    </div>
                                                                                    <div class="modal-body">
                                                                                        Apakah Anda yakin ingin menghapus
                                                                                        siswa dengan NIS
                                                                                        {{ $x->nis }}?
                                                                                    </div>
                                                                                    <div class="modal-footer">
                                                                                        <button type="button"
                                                                                            class="btn btn-secondary"
                                                                                            data-bs-dismiss="modal">Batal</button>
                                                                                        <button type="submit"
                                                                                            class="btn btn-danger">Hapus</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
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

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.delete-siswa').forEach(button => {
                button.addEventListener('click', function() {
                    const nis = button.getAttribute('data-nis');
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Data siswa ini akan dihapus!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById('deleteForm' + nis).submit();
                        }
                    });
                });
            });
        });
    </script>
@endpush
@push('scripts')
<script>
    $(document).ready(function() {
        $('#daftarsiswa').DataTable();
    });
</script>
@endpush