@extends('guru.layout.main')
@section('title', 'Daftar Mengajar')
@section('content')

<div class="container-fluid py-0 mt-4">
    @if ($guru->isNotEmpty())
        @php
            $firstGuru = $guru->first();
            $mapelPertama = $firstGuru->mapel->nama_mapel;  // Mengambil nama mapel pertama yang diajar guru
        @endphp
        <p class="text-white">
            Selamat Datang {{ $firstGuru->guru->username }} sebagai guru Mata Pelajaran {{ $mapelPertama }}.
        </p>
    @else
        <p class="text-white">Anda tidak terdaftar sebagai guru dalam sistem.</p>
    @endif

        <div class="row mt-3">
            <div class="container-fluid py-4">
                <div class="card shadow-lg">
                    <div class="card-body">
                        <h5 class="font-weight-bold">DAFTAR MENGAJAR</h5>

                        <div class="table-responsive mt-3">
                            <table id="daftarpembelajaran" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Nama Mapel</th>
                                        <th>Nama Kelas</th>
                                        <th>Nama Wali Kelas</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    @foreach ($mapelWakel as $index => $pembelajaran)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $pembelajaran->mapel->nama_mapel ?? '-' }}</td>
                                            <td>{{ $pembelajaran->kelas->kelas_tingkat ?? '-' }} - {{ $pembelajaran->kelas->jurusan->kode_jurusan ?? '-' }} - {{ $pembelajaran->kelas->rombel ?? '-' }}</td>
                                            <td>{{ $pembelajaran->kelas->wakel->user->username ?? '-' }}</td>
                                            <td class="text-center">
                                                <form action="{{ route('guru.presensi.kelola', ['id_pembelajaran' => $pembelajaran->id]) }}" method="GET" class="d-inline" title="Detail Presensi">
                                                    <button type="submit" class="btn btn-info btn-sm">
                                                        <i class="bi bi-calendar-check"></i>
                                                    </button>
                                                </form>
                                                <form action="{{ route('guru.nilai.kelola', ['id_pembelajaran' => $pembelajaran->id]) }}" method="GET" class="d-inline" title="Detail Nilai">
                                                    <button type="submit" class="btn btn-info btn-sm">
                                                        <i class="bi bi-journal-check"></i>
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
        $(document).ready(function() {
            $('#daftarpembelajaran').DataTable();
        });
    </script>

@endsection
