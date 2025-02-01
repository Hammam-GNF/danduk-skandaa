@extends('wakel.layout.main')
@section('title', 'Hasil Pengelolaan Presensi Kelas - ' . ($wakels->first()->kelas->kelas_tingkat ?? 'Kelas') . ' - ' . ($wakels->first()->kelas->jurusan->kode_jurusan ?? 'Jurusan') . ' - ' . ($wakels->first()->kelas->rombel ?? 'Rombel'))
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

    <div class="row mt-3">
        <div class="container-fluid py-4">
            <div class="card shadow-lg">
                <div class="card-body">
                    <h5 class="font-weight-bold"> DAFTAR PRESENSI
                        {{ $wakel->kelas->kelas_tingkat }} - {{ $wakel->kelas->jurusan->kode_jurusan }} - {{ $wakel->kelas->rombel }}
                    </h5>
                    <form action="{{ route('wakel.exportPresensiAllPdf', ['id' => $wakel->kelas->id]) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary">Export All Presensi</button>
                    </form>
                    <div class="table-responsive mt-3">
                        <table id="daftarSiswa" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">NIS</th>
                                    <th>Nama Siswa</th>
                                    <th class="text-center">Mata Pelajaran</th>
                                    <th class="text-center">Total Izin</th>
                                    <th class="text-center">Total Sakit</th>
                                    <th class="text-center">Total Alpa</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $siswaGrouped = [];
                                foreach ($kelolapresensi as $siswaNis => $mapelData) {
                                foreach ($mapelData as $kodeMapel => $presensi) {
                                if (!isset($siswaGrouped[$presensi->siswa->nis])) {
                                $siswaGrouped[$presensi->siswa->nis] = $mapelData;
                                }
                                }
                                }
                                @endphp

                                @foreach ($siswaGrouped as $siswaNis => $mapelData)
                                @foreach ($mapelData as $kodeMapel => $presensi)
                                @php
                                $siswa = $wakels->first()->kelas->siswa->firstWhere('nis', $siswaNis);
                                $mapelCount = count($mapelData);
                                @endphp
                                <tr>
                                    @if ($loop->first)
                                    <td class="text-center" rowspan="{{ $mapelCount }}">{{ $loop->parent->iteration }}</td>
                                    <td class="text-center" rowspan="{{ $mapelCount }}">{{ $siswaNis }}</td>
                                    <td rowspan="{{ $mapelCount }}">{{ $siswa ? $siswa->nama_siswa : '-' }}</td>
                                    @endif
                                    <td class="text-center">{{ $presensi ? $presensi->mapel->nama_mapel : '-' }}</td>
                                    <td class="text-center">{{ $presensi ? $presensi->totalizin : '-' }}</td>
                                    <td class="text-center">{{ $presensi ? $presensi->totalsakit : '-' }}</td>
                                    <td class="text-center">{{ $presensi ? $presensi->totalalpa : '-' }}</td>
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

@endsection