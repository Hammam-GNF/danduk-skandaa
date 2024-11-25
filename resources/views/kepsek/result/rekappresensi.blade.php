@extends('kepsek.layout.main')
@section('title', 'Rekap Presensi Kelas ' . $kelas->kelas_tingkat . ' - ' . $kelas->jurusan->kode_jurusan . ' - ' . $kelas->rombel)
@section('content')

<div class="container-fluid py-0 mt-4">
    <a href="{{ route('kepsek.result.index') }}" class="btn btn-secondary">Kembali</a>

    <div class="col-md-6">
        <div class="card mb-2" style="box-shadow: 0px 0px 10px 7px rgba(76, 0, 255, 0.401);">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <td><strong>Tahun Ajaran</strong></td>
                                <td>: {{ $thajaran->thajaran ?? 'Tahun ajaran tidak ditemukan' }} - {{ $thajaran->semesterLabel ?? '' }}</td>
                            </tr>
                        </tbody>
                    </table>
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
                                    {{ $kelas->kelas_tingkat }} - {{ $kelas->jurusan->kode_jurusan }} - {{ $kelas->rombel }}
                                </h5>

                                <div class="card-body px-0 pt-0 pb-2">
                                        <div class="table-responsive">
                                            <table id="daftarsiswa" class="table table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>NIS</th>
                                                        <th>Nama Siswa</th>
                                                        <th>Mata Pelajaran</th>
                                                        <th>Total Izin</th>
                                                        <th>Total Sakit</th>
                                                        <th>Total Alpa</th>
                                                        <th>Keterangan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $tahunAjaranAktif = App\Models\Admin\TahunAjaran::where('status', 'aktif')->first();

                                                        $siswaGrouped = $presensi->groupBy('nis');
                                                    @endphp

                                                    @foreach ($siswaGrouped as $nis => $presensiPerSiswa)
                                                        @php
                                                            $siswa = \App\Models\Admin\Siswa::where('nis', $nis)
                                                            ->where('thajaran_id', $tahunAjaranAktif->id)
                                                            ->first();

                                                            if (!$siswa) {
                                                                continue;
                                                            }

                                                            $rowspan = count($presensiPerSiswa);
                                                        @endphp

                                                        @foreach ($presensiPerSiswa as $index => $p)
                                                            <tr>
                                                                @if ($index === 0)
                                                                    <td rowspan="{{ $rowspan }}">{{ $loop->parent->iteration }}</td>
                                                                    <td rowspan="{{ $rowspan }}">{{ $nis }}</td>
                                                                    <td rowspan="{{ $rowspan }}">{{ $p->siswa->nama_siswa }}</td>
                                                                @endif
                                                                <td>{{ $p->mapel->nama_mapel }}</td>
                                                                <td>{{ $p->totalizin }}</td>
                                                                <td>{{ $p->totalsakit }}</td>
                                                                <td>{{ $p->totalalpa }}</td>
                                                                <td>{{ $p->keterangan }}</td>
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
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#daftarsiswa').DataTable();
    });
</script>

@endsection
