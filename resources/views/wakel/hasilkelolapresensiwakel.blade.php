@extends('wakel.layout.main')
@section('title', 'Hasil Presensi Kelas ' . ($pembelajaran->kelas->kelas_tingkat ?? 'Kelas') . ' - ' . ($pembelajaran->kelas->jurusan->kode_jurusan ?? 'Jurusan') . ' - ' . ($pembelajaran->kelas->rombel ?? 'Rombel'))
@section('content')

<div class="container-fluid py-0 mt-4">

    @if ($wakels->isNotEmpty())
        @foreach ($wakels as $wakel)
            @if ($wakel->kelas && $wakel->kelas->siswa->isNotEmpty())
                <p class="text-white"> 
                    Selamat Datang {{ $wakel->user->username }} sebagai {{ $wakel->user->role->level }} di 
                    {{ $wakel->kelas->kelas_tingkat }} - {{ $wakel->kelas->jurusan->kode_jurusan }} - {{ $wakel->kelas->rombel }}.                    </p>
            @else
                <p class="text-white">
                    Selamat Datang {{ $wakel->user->username }} sebagai {{ $wakel->user->role->level }}, anda belum memiliki kelas atau kelas ini tidak memiliki siswa.
                </p>
            @endif
        @endforeach
        @else
            <p class="text-white">Anda tidak memiliki Wali Kelas yang terdaftar.</p>
    @endif

    <a href="{{ route('wakel.presensi.kelola', ['id_pembelajaran' => $pembelajaran->id]) }}" class="btn btn-secondary">Kembali</a>

    <div class="row">
        <div class="container-fluid py-4">
            <div class="card shadow-lg">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="numbers">
                                <h5 class="font-weight-bolder">
                                    <!-- {{ $pembelajaran->first()->mapel->nama_mapel ?? 'Data Tidak Tersedia' }} -->
                                </h5>
                                <div class="card-body px-0 pt-0 pb-2">
                                    <div class="table-responsive">
                                        @foreach ($kelolapresensi as $kode_mapel => $presensiGroup)
                                            <table id="daftarsiswa" class="table table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-0 text-center">NO</th>
                                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3 text-center">NIS</th>
                                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3 text-center">Nama Siswa</th>
                                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3 text-center">Mata Pelajaran</th>
                                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">Total Izin</th>
                                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">Total Sakit</th>
                                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">Total Alpa</th>
                                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">Keterangan</th>
                                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($presensiGroup as $presensi)
                                                        <tr>
                                                            <td class="text-center">{{ $loop->iteration }}</td>
                                                            <td class="text-center">{{ $presensi->nis }}</td>
                                                            <td>{{ $presensi->siswa->nama_siswa ?? 'Data Tidak Tersedia' }}</td>
                                                            <td class="text-center">{{ $presensi->mapel->nama_mapel }}</td>
                                                            <td class="text-center">{{ $presensi->totalizin }}</td>
                                                            <td class="text-center">{{ $presensi->totalsakit }}</td>
                                                            <td class="text-center">{{ $presensi->totalalpa }}</td>
                                                            <td class="text-center">{{ $presensi->keterangan }}</td>
                                                            <td class="text-center">
                                                                <button class="btn btn-warning btn-sm" title="Edit" data-bs-toggle="modal" data-bs-target="#editModal" 
                                                                    data-id="{{ $presensi->id }}"
                                                                    data-nis="{{ $presensi->nis }}"
                                                                    data-nama_siswa="{{ $presensi->siswa->nama_siswa }}"
                                                                    data-totalizin="{{ $presensi->totalizin }}"
                                                                    data-totalsakit="{{ $presensi->totalsakit }}"
                                                                    data-totalalpa="{{ $presensi->totalalpa }}"
                                                                    data-keterangan="{{ $presensi->keterangan }}"
                                                                    data-pembelajaran_id="{{ $presensi->pembelajaran_id }}"
                                                                    data-mapel_id="{{ $presensi->mapel_id }}"
                                                                    data-kelas_id="{{ $kelas->id }}"
                                                                    data-jurusan_id="{{ $presensi->jurusan_id }}"
                                                                    data-thajaran_id="{{ $presensi->thajaran_id }}"
                                                                    data-wakel_id="{{ $presensi->wakel_id }}">
                                                                    <i class="bi bi-pencil"></i>
                                                                </button>
                                                                <form id="delete-form-{{ $presensi->id }}" method="POST" action="{{ route('wakel.presensi.destroy', ['id' => $presensi->id]) }}" style="display: none;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                </form>
                                                                <button type="button" class="btn btn-danger btn-sm delete-btn" data-id="{{ $presensi->id }}" title="Hapus">
                                                                    <i class="bi bi-trash"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        @endforeach
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

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Presensi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('wakel.presensi.update', 0) }}" method="POST" id="editForm">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nis" class="form-label">NIS</label>
                        <input type="text" class="form-control" id="nis" name="nis" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="nama_siswa" class="form-label">Nama Siswa</label>
                        <input type="text" class="form-control" id="nama_siswa" name="nama_siswa" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="totalsakit" class="form-label">Total Sakit</label>
                        <input type="number" class="form-control" id="totalsakit" name="totalsakit">
                    </div>
                    <div class="mb-3">
                        <label for="totalizin" class="form-label">Total Izin</label>
                        <input type="number" class="form-control" id="totalizin" name="totalizin">
                    </div>
                    <div class="mb-3">
                        <label for="totalalpa" class="form-label">Total Alpa</label>
                        <input type="number" class="form-control" id="totalalpa" name="totalalpa">
                    </div>
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea class="form-control" id="keterangan" name="keterangan"></textarea>
                    </div>
                    <input type="text" id="presensi_id" name="id" hidden>
                    <input type="text" id="pembelajaran_id" name="pembelajaran_id" hidden>
                    <input type="text" id="mapel_id" name="mapel_id" hidden>
                    <input type="text" id="kelas_id" name="kelas_id" hidden>
                    <input type="text" id="jurusan_id" name="jurusan_id" hidden>
                    <input type="text" id="thajaran_id" name="thajaran_id" hidden>
                    <input type="text" id="wakel_id" name="wakel_id" hidden>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var editModal = document.getElementById('editModal');
        editModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget; 
            var id = button.getAttribute('data-id');
            var nis = button.getAttribute('data-nis');
            var nama_siswa = button.getAttribute('data-nama_siswa');
            var totalizin = button.getAttribute('data-totalizin');
            var totalsakit = button.getAttribute('data-totalsakit');
            var totalalpa = button.getAttribute('data-totalalpa');
            var keterangan = button.getAttribute('data-keterangan');
            var pembelajaran_id = button.getAttribute('data-pembelajaran_id');
            var mapel_id = button.getAttribute('data-mapel_id');
            var kelas_id = button.getAttribute('data-kelas_id');
            var jurusan_id = button.getAttribute('data-jurusan_id');
            var thajaran_id = button.getAttribute('data-thajaran_id');
            var wakel_id = button.getAttribute('data-wakel_id');

            var modal = this;
            modal.querySelector('#presensi_id').value = id;
            modal.querySelector('#nis').value = nis;
            modal.querySelector('#nama_siswa').value = nama_siswa;
            modal.querySelector('#totalizin').value = totalizin;
            modal.querySelector('#totalsakit').value = totalsakit;
            modal.querySelector('#totalalpa').value = totalalpa;
            modal.querySelector('#keterangan').value = keterangan;
            modal.querySelector('#pembelajaran_id').value = pembelajaran_id;
            modal.querySelector('#mapel_id').value = mapel_id;
            modal.querySelector('#kelas_id').value = kelas_id;
            modal.querySelector('#jurusan_id').value = jurusan_id;
            modal.querySelector('#thajaran_id').value = thajaran_id;
            modal.querySelector('#wakel_id').value = wakel_id;

            var formAction = "{{ route('wakel.presensi.update', '') }}/" + id;
            modal.querySelector('#editForm').action = formAction;
        });

        document.querySelectorAll('.delete-btn').forEach(function (button) {
            button.addEventListener('click', function () {
                var presensiId = this.getAttribute('data-id');
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('delete-form-' + presensiId).submit();
                    }
                });
            });
        });
    });
</script>
@endpush
