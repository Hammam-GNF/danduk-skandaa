@extends('admin.layout.main')
@section('title', 'Daftar Siswa')
@section('content')

<div class="container-fluid py-0 mt-4">

    <!-- Button trigger modal -->
    <a href="{{ route('admin.siswa.create') }}" class="btn btn-danger">
        <i class="bi bi-plus-square"></i>
        Siswa
    </a>

    <div class="row mt-3">
        <div class="container-fluid py-4">
            <div class="card shadow-lg">
                <div class="card-body">
                    <h5 class="font-weight-bolder">DAFTAR SISWA</h5>
                    <br>
                    @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                    @endif

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
                                        <span class="badge bg-success">{{ $x->status }}</span>
                                        @else
                                        <span class="badge bg-danger">{{ $x->status }}</span>
                                        @endif
                                    </td>
                                    <td class="text-center">{{ $x->thajaran->thajaran }} - {{ $x->thajaran->semesterLabel }}</td>

                                    <td class="align-middle-center" style="display: flex; align-items: center; justify-content: center;">
                                        <a href="{{ route('admin.siswa.edit', ['nis' => $x->nis]) }}" class="btn btn-primary btn-sm me-2" data-toggle="tooltip" data-original-title="Edit siswa">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <button type="button" class="btn btn-danger btn-sm delete-siswa" data-nis="{{ $x->nis }}" data-id="{{ $x->id }}" data-toggle="tooltip" data-original-title="Hapus siswa">
                                            <i class="bi bi-trash"></i>
                                        </button>
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

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.delete-siswa').forEach(button => {
            button.addEventListener('click', function() {
                const nis = button.getAttribute('data-nis');
                const id = button.getAttribute('data-id');
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
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = '{{ route("admin.siswa.destroy", ":nis") }}'.replace(':nis', nis);
                        const csrfToken = document.createElement('input');
                        csrfToken.type = 'hidden';
                        csrfToken.name = '_token';
                        csrfToken.value = '{{ csrf_token() }}';
                        form.appendChild(csrfToken);

                        const methodInput = document.createElement('input');
                        methodInput.type = 'hidden';
                        methodInput.name = '_method';
                        methodInput.value = 'DELETE';
                        form.appendChild(methodInput);

                        document.body.appendChild(form);
                        form.submit();
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