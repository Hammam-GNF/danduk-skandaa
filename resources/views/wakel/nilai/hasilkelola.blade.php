@extends('wakel.layout.main')
@section('title', 'Hasil Pengelolaan Nilai Kelas - ' . ($wakels->first()->kelas->kelas_tingkat ?? 'Kelas') . ' - ' . ($wakels->first()->kelas->jurusan->kode_jurusan ?? 'Jurusan') . ' - ' . ($wakels->first()->kelas->rombel ?? 'Rombel'))
@section('content')

<div class="container-fluid py-0 mt-4">

    @if ($wakels->isNotEmpty())
        @foreach ($wakels as $wakel)
            @if ($wakel->kelas && $wakel->kelas->siswa->isNotEmpty())
                <p class="text-white">
                    Selamat Datang {{ $wakel->user->username }} sebagai {{ $wakel->user->role->level }} di 
                    {{ $wakel->kelas->kelas_tingkat }} - {{ $wakel->kelas->jurusan->kode_jurusan }} - {{ $wakel->kelas->rombel }}.
                </p>
            @else
                <p class="text-white">
                    Selamat Datang {{ $wakel->user->username }} sebagai {{ $wakel->user->role->level }}, anda belum memiliki kelas atau kelas ini tidak memiliki siswa.
                </p>
            @endif
        @endforeach
    @else
        <p class="text-white">Anda tidak memiliki Wali Kelas yang terdaftar.</p>
    @endif

    <div class="row">
        <div class="container-fluid py-4">
            <div class="card shadow-lg">
                <div class="card-body">
                    <h5 class="font-weight-bolder">DAFTAR NILAI
                        {{ $wakel->kelas->kelas_tingkat }} - {{ $wakel->kelas->jurusan->kode_jurusan }} - {{ $wakel->kelas->rombel }}
                    </h5>
                    <form action="{{ route('wakel.exportNilaiAllPdf', ['id' => $wakel->kelas->id]) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary">Export All Presensi</button>
                    </form>
                    <div class="table-responsive mt-3">
                        <table id="daftarnilai" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">NIS</th>
                                    <th>Nama Siswa</th>
                                    <th class="text-center">Mata Pelajaran</th>
                                    <th class="text-center">UH 1</th>
                                    <th class="text-center">UH 2</th>
                                    <th class="text-center">UH 3</th>
                                    <th class="text-center">UTS</th>
                                    <th class="text-center">UAS</th>
                                    <th class="text-center">Rata-Rata</th>
                                    <th class="text-center">Predikat</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $siswaGrouped = [];
                                    foreach ($kelolanilai as $siswaNis => $mapelData) {
                                        foreach ($mapelData as $kodeMapel => $nilai) {
                                            if (!isset($siswaGrouped[$nilai->siswa->nis])) {
                                                $siswaGrouped[$nilai->siswa->nis] = $mapelData;
                                            }
                                        }
                                    }
                                @endphp

                                @foreach ($siswaGrouped as $siswaNis => $mapelData)
                                    @foreach ($mapelData as $kodeMapel => $nilai)
                                        @php
                                            $average = ($nilai->uh1 + $nilai->uh2 + $nilai->uh3 + $nilai->uts + $nilai->uas) / 5;
                                        @endphp
                                        <tr>
                                            @if ($loop->first)
                                                <td class="text-center" rowspan="{{ count($mapelData) }}">{{ $loop->parent->iteration }}</td>
                                                <td class="text-center" rowspan="{{ count($mapelData) }}">{{ $nilai->siswa->nis }}</td>
                                                <td rowspan="{{ count($mapelData) }}">{{ $nilai->siswa->nama_siswa }}</td>
                                            @endif
                                            <td class="text-center">{{ $nilai->mapel->nama_mapel }}</td>
                                            <td class="text-center">{{ $nilai->uh1 }}</td>
                                            <td class="text-center">{{ $nilai->uh2 }}</td>
                                            <td class="text-center">{{ $nilai->uh3 }}</td>
                                            <td class="text-center">{{ $nilai->uts }}</td>
                                            <td class="text-center">{{ $nilai->uas }}</td>
                                            <td class="text-center">{{ number_format($average, 2) }}</td>
                                            <td class="text-center">
                                                @if ($average >= 90)
                                                    A
                                                @elseif ($average >= 80)
                                                    B
                                                @elseif ($average >= 70)
                                                    C
                                                @else
                                                    D
                                                @endif
                                            </td>
                                            @if ($loop->first)
                                            <td rowspan="{{ count($mapelData) }}" class="text-center align-middle">
                                                <form action="{{ route('admin.rekapNilaiSiswaPdf', ['nis' => $nilai->siswa->nis]) }}" method="GET" style="display:inline;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-primary">Export Nilai</button>
                                                </form>
                                            </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>



@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
    $('#daftarnilai').DataTable();

    $('#editModal').on('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var id = button.getAttribute('data-id');
        var nis = button.getAttribute('data-nis');
        var nama_siswa = button.getAttribute('data-nama_siswa');
        var uh1 = parseFloat(button.getAttribute('data-uh1')) || 0;
        var uh2 = parseFloat(button.getAttribute('data-uh2')) || 0;
        var uh3 = parseFloat(button.getAttribute('data-uh3')) || 0;
        var uts = parseFloat(button.getAttribute('data-uts')) || 0;
        var uas = parseFloat(button.getAttribute('data-uas')) || 0;
        var mapel_kode = button.getAttribute('data-mapel_kode');
        var pembelajaran_id = button.getAttribute('data-pembelajaran_id');
        var kelas_id = button.getAttribute('data-kelas_id');
        var jurusan_id = button.getAttribute('data-jurusan_id');
        var thajaran_id = button.getAttribute('data-thajaran_id');
        var wakel_id = button.getAttribute('data-wakel_id');

        document.getElementById('editId').value = id;
        document.getElementById('mapel_kode').value = mapel_kode;
        document.getElementById('pembelajaran_id').value = pembelajaran_id;
        document.getElementById('kelas_id').value = kelas_id;
        document.getElementById('jurusan_id').value = jurusan_id;
        document.getElementById('thajaran_id').value = thajaran_id;
        document.getElementById('wakel_id').value = wakel_id;
        document.getElementById('nis').value = nis;
        document.getElementById('nama_siswa').value = nama_siswa;
        document.getElementById('editUh1').value = uh1;
        document.getElementById('editUh2').value = uh2;
        document.getElementById('editUh3').value = uh3;
        document.getElementById('editUts').value = uts;
        document.getElementById('editUas').value = uas;

        var average = (uh1 + uh2 + uh3 + uts + uas) / 5;
        document.getElementById('editRataRata').value = average.toFixed(2);

        var formAction = "{{ route('wakel.nilai.update', '') }}/" + id;
        document.getElementById('editForm').action = formAction;
    });

    document.querySelectorAll('#editUh1, #editUh2, #editUh3, #editUts, #editUas').forEach(function(element) {
        element.addEventListener('input', function() {
            var uh1 = parseFloat(document.getElementById('editUh1').value) || 0;
            var uh2 = parseFloat(document.getElementById('editUh2').value) || 0;
            var uh3 = parseFloat(document.getElementById('editUh3').value) || 0;
            var uts = parseFloat(document.getElementById('editUts').value) || 0;
            var uas = parseFloat(document.getElementById('editUas').value) || 0;

            var average = (uh1 + uh2 + uh3 + uts + uas) / 5;
            document.getElementById('editRataRata').value = average.toFixed(2);
        });
    });
});

</script>
@endpush
@endsection
