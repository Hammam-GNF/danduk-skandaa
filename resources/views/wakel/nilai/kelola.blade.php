@extends('wakel.layout.main')
@section('title', 'Kelola Nilai')
@section('content')

<div class="container-fluid py-0 mt-4">
    <a href="{{ route('wakel.mengajar', ['roleId' => auth()->user()->role_id]) }}" class="btn btn-secondary">Kembali</a>
    <a href="{{ route('wakel.nilai.hasilkelola', ['id_pembelajaran' => $pembelajaran->id]) }}" class="btn btn-danger">Hasil Kelola Nilai</a>
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
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3 text-center">Tambah Nilai</th>
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
                                                        {{ optional(optional($s->kelas)->jurusan)->kode_jurusan ?? 'Jurusan' }} -
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
                                                        <button type="button" class="btn btn-primary btn-sm me-2" data-bs-toggle="modal" data-bs-target="#tambahNilaiModal" 
                                                            data-nis="{{ $s->nis }}" 
                                                            data-nama_siswa="{{ $s->nama_siswa }}" 
                                                            data-mapel="{{ $pembelajaran->mapel->nama_mapel }}" 
                                                            data-mapel_kode="{{ $pembelajaran->mapel->kode_mapel }}" 
                                                            data-pembelajaran_id="{{ $pembelajaran->id }}" 
                                                            data-kelas_id="{{ $kelas->id }}" 
                                                            data-mapel_id="{{ $pembelajaran->mapel_id }}"
                                                            data-thajaran_id="{{ $pembelajaran->thajaran_id }}"
                                                            data-wakel_id="{{ $kelas->wakel->id }}"
                                                            data-jurusan_id="{{ $kelas->jurusan_id }}"
                                                            data-id_guru="{{ $pembelajaran->guru->id }}">
                                                            <i class="bi bi-plus-square" title="Tambah Nilai"></i>
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

    <!-- Modal Tambah Nilai -->
    <div class="modal fade" id="tambahNilaiModal" tabindex="-1" aria-labelledby="tambahNilaiModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahNilaiModalLabel">Tambah Nilai</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('wakel.nilai.store') }}">
                    @csrf
                    <div class="modal-body">
                        <!-- Hidden inputs for internal use -->
                        <input type="hidden" name="pembelajaran_id" id="pembelajaranIdInput">
                        <input type="hidden" name="nis" id="nisInput">
                        <input type="hidden" name="mapel_id" id="mapelIdInput">
                        <input type="hidden" name="kelas_id" id="kelasIdInput">
                        <input type="hidden" name="thajaran_id" id="thajaranIdInput">
                        <input type="hidden" name="wakel_id" id="wakelIdInput">
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

                        <div class="mb-3">
                            <label for="mapelDisplay" class="form-label">Mata Pelajaran:</label>
                            <input type="text" class="form-control" id="mapelDisplay" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="uh1" class="form-label">UH 1:</label>
                            <input type="number" class="form-control" id="uh1" name="uh1" min="0" max="100">
                        </div>
                        <div class="mb-3">
                            <label for="uh2" class="form-label">UH 2:</label>
                            <input type="number" class="form-control" id="uh2" name="uh2" min="0" max="100">
                        </div>
                        <div class="mb-3">
                            <label for="uh3" class="form-label">UH 3:</label>
                            <input type="number" class="form-control" id="uh3" name="uh3" min="0" max="100">
                        </div>
                        <div class="mb-3">
                            <label for="uts" class="form-label">UTS:</label>
                            <input type="number" class="form-control" id="uts" name="uts" min="0" max="100">
                        </div>
                        <div class="mb-3">
                            <label for="uas" class="form-label">UAS:</label>
                            <input type="number" class="form-control" id="uas" name="uas" min="0" max="100">
                        </div>
                        <div class="mb-3">
                            <label for="rata_rata" class="form-label">Nilai Akhir:</label>
                            <input type="number" class="form-control" id="rata_rata" readonly>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var tambahNilaiModal = document.getElementById('tambahNilaiModal');
    tambahNilaiModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget; 
        var nis = button.getAttribute('data-nis');
        var nama_siswa = button.getAttribute('data-nama_siswa');
        var mapel = button.getAttribute('data-mapel');
        var pembelajaran_id = button.getAttribute('data-pembelajaran_id');
        var kelas_id = button.getAttribute('data-kelas_id');
        var mapel_id = button.getAttribute('data-mapel_id');
        var thajaran_id = button.getAttribute('data-thajaran_id');
        var wakel_id = button.getAttribute('data-wakel_id');
        var jurusan_id = button.getAttribute('data-jurusan_id');
        var idGuru = button.getAttribute('data-id_guru');

        var modalTitle = tambahNilaiModal.querySelector('.modal-title');
        var nisDisplay = tambahNilaiModal.querySelector('#nisDisplay');
        var namaSiswaDisplay = tambahNilaiModal.querySelector('#namaSiswaDisplay');
        var idGuruInput = tambahNilaiModal.querySelector('#idGuruInput');
        var mapelDisplay = tambahNilaiModal.querySelector('#mapelDisplay');

        modalTitle.textContent = 'Tambah Nilai';
        nisDisplay.value = nis;
        namaSiswaDisplay.value = nama_siswa;
        idGuruInput.value = idGuru;
        mapelDisplay.value = mapel;

        tambahNilaiModal.querySelector('#pembelajaranIdInput').value = pembelajaran_id;
        tambahNilaiModal.querySelector('#nisInput').value = nis;
        tambahNilaiModal.querySelector('#mapelIdInput').value = mapel_id;
        tambahNilaiModal.querySelector('#kelasIdInput').value = kelas_id;
        tambahNilaiModal.querySelector('#thajaranIdInput').value = thajaran_id;
        tambahNilaiModal.querySelector('#wakelIdInput').value = wakel_id;
        tambahNilaiModal.querySelector('#jurusanIdInput').value = jurusan_id;
        
        var uh1 = tambahNilaiModal.querySelector('#uh1');
        var uh2 = tambahNilaiModal.querySelector('#uh2');
        var uh3 = tambahNilaiModal.querySelector('#uh3');
        var uts = tambahNilaiModal.querySelector('#uts');
        var uas = tambahNilaiModal.querySelector('#uas');
        var rata_rata = tambahNilaiModal.querySelector('#rata_rata');

        function calculateFinalScore() {
            var uh1Value = parseFloat(uh1.value) || 0;
            var uh2Value = parseFloat(uh2.value) || 0;
            var uh3Value = parseFloat(uh3.value) || 0;
            var utsValue = parseFloat(uts.value) || 0;
            var uasValue = parseFloat(uas.value) || 0;

            var finalScore = (uh1Value * 0.15) + (uh2Value * 0.15) + (uh3Value * 0.15) + (utsValue * 0.25) + (uasValue * 0.30);
            rata_rata.value = finalScore.toFixed(2);
        }

        uh1.addEventListener('input', calculateFinalScore);
        uh2.addEventListener('input', calculateFinalScore);
        uh3.addEventListener('input', calculateFinalScore);
        uts.addEventListener('input', calculateFinalScore);
        uas.addEventListener('input', calculateFinalScore);
    });
});
</script>


@endsection
