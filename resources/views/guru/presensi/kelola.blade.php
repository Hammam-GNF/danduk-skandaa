@extends('guru.layout.main')
@section('title', 'Kelola Presensi')
@section('content')

<div class="container-fluid py-0 mt-4">
    <a href="{{ route('guru.mengajar', ['roleId' => auth()->user()->role_id]) }}" class="btn btn-secondary">Kembali</a>
    <a href="{{ route('guru.presensi.hasilkelola', ['id_pembelajaran' => $pembelajaran->id]) }}" class="btn btn-danger">Hasil Kelola Presensi</a>
    <br>
    <div class="row">
        <div class="col-xl-12 col-sm-12 mb-4">
            <div class="card" style="box-shadow: 0px 0px 10px 7px rgba(76, 0, 255, 0.401);">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-12">
                            <div class="numbers">
                                <h5 class="font-weight-bolder">
                                    {{ $pembelajaran->mapel->nama_mapel ?? 'Mata Pelajaran' }} -
                                    {{ $pembelajaran->guru->username ?? 'Guru Pengampu' }} 
                                </h5>
                                <div class="card-body px-0 pt-0 pb-2">
                                    <div class="table-responsive">
                                        <table id="daftarsiswa" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-0 text-center">NO</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3 text-center">NIS</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3 text-center">Nama Siswa</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">Jenis Kelamin</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">Nama Kelas</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">Status</th>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3 text-center">Tambah Presensi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($siswa as $s)
                                                <tr>
                                                    <td class="text-center">{{ $loop->iteration }}</td>
                                                    <td>{{ $s->nis }}</td>
                                                    <td>{{ $s->nama_siswa }}</td>
                                                    <td class="text-center">{{ $s->jns_kelamin }}</td>
                                                    <td class="text-center">
                                                        {{ optional($s->kelas)->kelas_tingkat ?? 'Kelas' }} -
                                                        {{ optional($s->kelas->jurusan)->kode_jurusan ?? 'Jurusan' }} -
                                                        {{ optional($s->kelas)->rombel ?? 'Rombel' }}
                                                    </td>
                                                    <td class="text-center">
                                                        @if ($s->status == 'Aktif')
                                                            <span class="badge bg-success">{{ $s->status }}</span>
                                                        @else
                                                            <span class="badge bg-danger">{{ $s->status }}</span>
                                                        @endif
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <!-- Button trigger modal -->
                                                        <button type="button" class="btn btn-primary btn-sm me-2"  data-bs-toggle="modal"  data-bs-target="#tambahPertemuanModal"
                                                                data-nis="{{ $s->nis }}" 
                                                                data-nama_siswa="{{ $s->nama_siswa }}" 
                                                                data-pembelajaran_id="{{ $pembelajaran->id }}" 
                                                                data-wakel_id="{{ $kelas->wakel->id }}" 
                                                                data-mapel_id="{{ $pembelajaran->mapel->id }}"
                                                                data-kelas_id="{{ $kelas->id }}" 
                                                                data-thajaran_id="{{ $kelas->thajaran_id }}" 
                                                                data-jurusan_id="{{ $kelas->jurusan->id }}"
                                                                data-id_guru="{{ $pembelajaran->guru->id }}">
                                                            <i class="bi bi-plus-square" title="Tambah Presensi"></i>
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
            </div>
        </div>
    </div>

    <!-- Modal Tambah Pertemuan -->
    <div class="modal fade" id="tambahPertemuanModal" tabindex="-1" aria-labelledby="tambahPertemuanModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahPertemuanModalLabel">Tambah Presensi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('guru.presensi.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="pembelajaran_id" id="pembelajaranIdInput">
                        <input type="hidden" name="nis" id="nisInput">
                        <input type="hidden" name="wakel_id" id="wakelIdInput">
                        <input type="hidden" name="mapel_id" id="mapelIdInput">
                        <input type="hidden" name="kelas_id" id="kelasIdInput">
                        <input type="hidden" name="thajaran_id" id="thajaranIdInput">
                        <input type="hidden" name="jurusan_id" id="jurusanIdInput">
                        <input type="hidden" name="id_guru" id="idGuruInput">

                        <div class="form-group">
                            <label for="nisDisplay">NIS</label>
                            <input type="text" class="form-control" id="nisDisplay" readonly>
                        </div>

                        <div class="form-group">
                            <label for="namaSiswaDisplay">Nama Siswa</label>
                            <input type="text" class="form-control" id="namaSiswaDisplay" readonly>
                        </div>
                        
                        <div class="form-group">
                            <label for="totalsakit">Total Sakit</label>
                            <input type="number" class="form-control" id="totalsakit" name="totalsakit" placeholder="Masukkan Total Sakit" required min="0">
                        </div>

                        <div class="form-group">
                            <label for="totalizin">Total Izin</label>
                            <input type="number" class="form-control" id="totalizin" name="totalizin" placeholder="Masukkan Total Izin" required min="0">
                        </div>

                        <div class="form-group">
                            <label for="totalalpa">Total Alpa</label>
                            <input type="number" class="form-control" id="totalalpa" name="totalalpa" placeholder="Masukkan Total Alpa" required min="0">
                        </div>
                        
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea class="form-control" id="keterangan" name="keterangan" placeholder="Masukkan Keterangan"></textarea>
                        </div>
                        
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var tambahPertemuanModal = document.getElementById('tambahPertemuanModal');
        tambahPertemuanModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var nis = button.getAttribute('data-nis');
            var namaSiswa = button.getAttribute('data-nama_siswa');
            var wakelId = button.getAttribute('data-wakel_id');
            var mapelId = button.getAttribute('data-mapel_id');
            var pembelajaranId = button.getAttribute('data-pembelajaran_id');
            var kelasId = button.getAttribute('data-kelas_id');
            var thajaranId = button.getAttribute('data-thajaran_id');
            var jurusanId = button.getAttribute('data-jurusan_id');
            var idGuru = button.getAttribute('data-id_guru');

            var nisInput = document.getElementById('nisInput');
            var namaSiswaDisplay = document.getElementById('namaSiswaDisplay');
            var pembelajaranIdInput = document.getElementById('pembelajaranIdInput');
            var wakelIdInput = document.getElementById('wakelIdInput');
            var mapelIdInput = document.getElementById('mapelIdInput');
            var kelasIdInput = document.getElementById('kelasIdInput');
            var thajaranIdInput = document.getElementById('thajaranIdInput');
            var jurusanIdInput = document.getElementById('jurusanIdInput');
            var idGuruInput = document.getElementById('idGuruInput');
            var nisDisplay = document.getElementById('nisDisplay');

            nisInput.value = nis;
            nisDisplay.value = nis;
            namaSiswaDisplay.value = namaSiswa;
            pembelajaranIdInput.value = pembelajaranId;
            wakelIdInput.value = wakelId;
            mapelIdInput.value = mapelId;
            kelasIdInput.value = kelasId;
            thajaranIdInput.value = thajaranId;
            jurusanIdInput.value = jurusanId;
            idGuruInput.value = idGuru;
        });
    });
</script>
@endpush

@endsection
