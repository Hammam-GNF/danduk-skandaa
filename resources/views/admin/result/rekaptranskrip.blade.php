@extends('admin.layout.main')
@section('title', 'Rekap Transkrip Kelas ' . $kelas->kelas_tingkat . ' - ' . $kelas->jurusan->kode_jurusan . ' - ' .
    $kelas->rombel)
@section('content')

    <div class="container-fluid py-0 mt-4">
        <a href="{{ route('admin.result.indextranskripnilai') }}" class="btn btn-secondary">Kembali</a>

        <div class="col-md-6">
            <div class="card mb-2" style="box-shadow: 0px 0px 10px 7px rgba(76, 0, 255, 0.401);">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <td><strong>Tahun Ajaran</strong></td>
                                    <td>: {{ $kelas->thajaran->thajaran }} - {{ $kelas->thajaran->semester }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <form class="d-inline"
                            action="{{ route('admin.result.nilai.rekaptranskrip.export-all', ['id' => $kelas->id]) }}"
                            method="post">
                            @csrf
                            <button class="btn btn-primary">Cetak Transkip PDF</button>
                        </form>
                        <form class="d-inline"
                            action="{{ route('admin.result.nilai.rekaptranskrip.export-excel', ['id' => $kelas->id]) }}"
                            method="post">
                            @csrf
                            <button class="btn btn-success">Cetak Rekap Excel</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-xl-12 col-sm-12 mb-4">
                <div class="card" style="box-shadow: 0px 0px 10px 7px rgba(76, 0, 255, 0.401);">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-12">
                                <div class="numbers">
                                    <h5 class="font-weight-bolder">
                                        {{ $kelas->kelas_tingkat }} -
                                        {{ $kelas->jurusan->kode_jurusan }} -
                                        {{ $kelas->rombel }}
                                    </h5>
                                    {{-- <form method="GET"
                                        action="{{ route('admin.result.exportpdf', ['kelas' => $kelas->id]) }}">
                                        <button type="submit" class="btn btn-success mt-3">Cetak Transkrip
                                            <i class="fas fa-print"></i>
                                        </button>
                                    </form> --}}
                                    <div class="card-body px-0 pt-0 pb-2">
                                        <div class="table-responsive mt-3">
                                            <table id="daftarnilai" class="table table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Nama Siswa</th>
                                                        <th>Mata Pelajaran</th>
                                                        <th>UH 1</th>
                                                        <th>UH 2</th>
                                                        <th>UH 3</th>
                                                        <th>UTS</th>
                                                        <th>UAS</th>
                                                        <th>Rata-Rata</th>
                                                        <th>Predikat</th>
                                                        <th>Actions</th> <!-- Added column header -->
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($siswa as $s)
                                                        @php
                                                            $numSubjects = $kelas->pembelajaran->count();
                                                        @endphp
                                                        <tr>
                                                            <td rowspan="{{ $numSubjects }}">{{ $loop->iteration }}</td>
                                                            <td rowspan="{{ $numSubjects }}">{{ $s->nama_siswa }}</td>
                                                            @foreach ($kelas->pembelajaran as $pIndex => $pembelajaran)
                                                                @if ($pIndex != 0)
                                                        <tr>
                                                    @endif
                                                    @php
                                                        $nilaiSiswa = $s->nilai->firstWhere(
                                                            'pembelajaran_id',
                                                            $pembelajaran->id,
                                                        );
                                                        $presensiSiswa = $s->presensi->firstWhere(
                                                            'pembelajaran_id',
                                                            $pembelajaran->id,
                                                        );
                                                        $average = $nilaiSiswa
                                                            ? ($nilaiSiswa->uh1 +
                                                                    $nilaiSiswa->uh2 +
                                                                    $nilaiSiswa->uh3 +
                                                                    $nilaiSiswa->uts +
                                                                    $nilaiSiswa->uas) /
                                                                5
                                                            : 0;
                                                    @endphp
                                                    <td>{{ $pembelajaran->mapel->nama_mapel }}</td>
                                                    <td>{{ $nilaiSiswa->uh1 ?? '-' }}</td>
                                                    <td>{{ $nilaiSiswa->uh2 ?? '-' }}</td>
                                                    <td>{{ $nilaiSiswa->uh3 ?? '-' }}</td>
                                                    <td>{{ $nilaiSiswa->uts ?? '-' }}</td>
                                                    <td>{{ $nilaiSiswa->uas ?? '-' }}</td>
                                                    <td>{{ $average ? number_format($average, 2) : '-' }}</td>
                                                    <td>
                                                        @if ($average == null)
                                                            -
                                                        @elseif ($average >= 90)
                                                            A
                                                        @elseif ($average >= 80)
                                                            B
                                                        @elseif ($average >= 70)
                                                            C
                                                        @else
                                                            D
                                                        @endif
                                                    </td>
                                                    @if ($pIndex == 0)
                                                        <td>
                                                            <form method="GET"
                                                                action="{{ route('admin.result.rekaptranskrip.siswa.pdf', ['id' => $s->nis]) }}">
                                                                <button type="submit" class="btn btn-primary btn-sm">Cetak
                                                                    Transkip Siswa</button>
                                                            </form>
                                                        </td>
                                                        </tr>
                                                    @endif
                                                    @endforeach

                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            {{ $siswa->links() }}
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
