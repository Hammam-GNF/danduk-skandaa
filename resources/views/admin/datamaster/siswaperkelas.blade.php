@extends('admin.layout.main')
@section('title', 'Daftar Siswa Kelas ' . 
    ($siswa->isNotEmpty() ? $siswa->first()->kelas->kelas_tingkat : 'Kelas') . ' - ' . 
    ($siswa->isNotEmpty() ? $siswa->first()->kelas->jurusan->kode_jurusan : 'Jurusan') . ' - ' . 
    ($siswa->isNotEmpty() ? $siswa->first()->kelas->rombel : 'Rombel'))
@section('content')

<div class="container-fluid py-0 mt-4">
    <a href="{{ route('admin.kelas.index') }}" class="btn btn-secondary">Kembali</a>

    <!-- Button trigger modal -->
    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#importModal">
        <i class="bi bi-file-earmark-arrow-up"></i>
        Import
    </button>

    <!-- Modal Import -->
    <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalLabel">Import Excel File</h5>
                </div>
                <form action="{{ route('admin.siswa.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="kelas_id">Nama Kelas</label>
                            <select class="form-control" id="kelas_id{{ $kelas->id }}" name="kelas_id" disabled>
                                <option value="{{ $kelas->id }}">{{ $kelas->kelas_tingkat }} - {{ $kelas->jurusan->kode_jurusan }} - {{ $kelas->rombel }}</option>
                            </select>
                            <input type="hidden" name="kelas_id" id="kelas_id" value="{{ $kelas->id }}">
                        </div>
                        <div class="form-group mb-1">
                            <label for="file">Download Format Excel</label>
                            <a href="{{ route('admin.siswa.export') }}" class="btn btn-success w-100">Download Format</a>
                        </div>
                        <div class="form-group mb-3">
                            <label for="file">Upload File Excel</label>
                            <input type="file" name="file" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-xl-12 col-sm-5 mb-xl-0 mb-4">
                    <div class="card" style="box-shadow: 0px 0px 10px 7px rgba(76, 0, 255, 0.401);">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-12">
                                    <div class="numbers">
                                        <h5 class="font-weight-bolder">
                                            {{ $siswa->isNotEmpty() ? $siswa->first()->kelas->kelas_tingkat : 'Kelas' }} - 
                                            {{ $siswa->isNotEmpty() ? $siswa->first()->kelas->jurusan->kode_jurusan : 'Jurusan' }} - 
                                            {{ $siswa->isNotEmpty() ? $siswa->first()->kelas->rombel : 'Rombel' }}
                                        </h5>
                                        <br>
                                        <div class="card-body px-0 pt-0 pb-2">
                                            <a href="{{ route('admin.siswaperkelas.create', ['id' => $kelas->id]) }}" class="btn btn-danger">
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
                                                            <th>Nama Kelas</th>
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
                                                            <td class="text-center">{{ $x->kelas->kelas_tingkat }} - {{ $x->kelas->jurusan->kode_jurusan }} - {{ $x->kelas->rombel }}</td>
                                                            <td class="text-center">
                                                                @if($x->status == 'Aktif')
                                                                <span class="badge bg-success">{{ $x->status }}</span>
                                                                @else
                                                                <span class="badge bg-danger">{{ $x->status }}</span>
                                                                @endif
                                                            </td>
                                                            <td class="text-center">{{ $x->thajaran->thajaran }} - {{ $x->thajaran->semesterLabel }}</td>

                                                            <td class="align-middle-center" style="display: flex; align-items: center; justify-content: center;">
                                                                <a href="{{ route('admin.siswaperkelas.edit', ['nis' => $x->nis]) }}" class="btn btn-primary btn-sm me-2" data-toggle="tooltip" data-original-title="Edit siswa">
                                                                    <i class="bi bi-pencil-square"></i>
                                                                </a>

                                                                <form id="delete-form-{{ $x->nis }}" method="POST" action="{{ route('admin.siswaperkelas.destroy', ['nis' => $x->nis, 'kelas_id' => $kelas]) }}">
                                                                @csrf
                                                                    @method('DELETE')
                                                                    <button type="button" class="btn btn-danger btn-sm me-2 delete-siswa" data-toggle="tooltip" data-original-title="Hapus siswa" data-nis="{{ $x->nis }}">
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

<!-- Include SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('kelas_id').addEventListener('change', function() {
            var kelas_id = this.value;
            var wakelDisplay = document.getElementById('wakel_display');
            var wakelInput = document.getElementById('wakel_id');

            wakelDisplay.value = '';
            wakelInput.value = '';

            if (kelas_id) {
                fetch(`/admin/datamaster/siswaperkelas/getWakel/${kelas_id}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.wakel) {
                            wakelDisplay.value = data.wakel.user.username;
                            wakelInput.value = data.wakel.id;
                        } else {
                            wakelDisplay.value = 'Tidak ditemukan';
                            console.error('Wali kelas tidak ditemukan.');
                        }
                    })
                    .catch(error => console.error('Error fetching wali kelas:', error));
            }
        });
    });

</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.delete-siswa');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const nis = this.getAttribute('data-nis');
                const formId = `delete-form-${nis}`;
                const form = document.getElementById(formId);

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Anda tidak akan dapat mengembalikan ini!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Hapus!',
                    cancelButtonText: 'Batalkan'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#daftarsiswa').DataTable();
    });
</script>

@endsection
