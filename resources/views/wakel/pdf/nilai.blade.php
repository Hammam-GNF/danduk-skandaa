<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Transkrip Nilai Kelas {{ $kelas->nama_kelas }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
        }

        .kop-surat {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid black;
        }

        .kop-surat h2, .kop-surat p {
            margin: 0;
            padding: 0;
        }

        .kop-surat h2 {
            margin-bottom: 5px;
        }

        .kop-surat p {
            margin-bottom: 2px;
        }

        .info {
            text-align: left;
            margin-bottom: 20px;
        }

        .info p {
            margin: 0;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .table,
        .table th,
        .table td {
            border: 1px solid black;
        }

        .table th,
        .table td {
            padding: 8px;
            text-align: center;
        }

        .signature {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
            padding: 0 40px;
        }

        .signature div {
            text-align: center;
            width: 40%;
        }

        .signature .name {
            margin-top: 50px;
            border-top: 1px solid black;
            padding-top: 5px;
        }
    </style>
</head>

<body>
    <div class="kop-surat">
        <h2>PEMERINTAH PROVINSI JAWA TENGAH</h2>
        <h2>DINAS PENDIDIKAN DAN KEBUDAYAAN</h2>
        <h2>SEKOLAH MENENGAH KEJURUAN NEGERI 2 CILACAP</h2>
        <p>Jalan Budi Utomo Nomor 8 Cilacap Kode Pos 53212</p>
        <p>Telepon 0282-534736 | Faksimile 0282-520595</p>
        <p>Surat Elektronik smk2cilacap@yahoo.com</p>
    </div>
    <!-- <h2>TRANSKRIP NILAI SISWA</h2> -->
    <div class="header">
        <h3>DAFTAR NILAI</h3>
        <div class="info">
            <p>Kelas        : {{ $kelas->kelas_tingkat }} - {{ $kelas->jurusan->kode_jurusan }} - {{ $kelas->rombel }}</p>
            <p>Semester     : {{ $tahunAjaranAktif->semester }}</p>
            <p>Tahun Ajaran : {{ $tahunAjaranAktif->thajaran }}</p>
        </div>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Siswa</th>
                @foreach ($kelas->pembelajaran as $pembelajaran)
                    <th>{{ $pembelajaran->mapel->nama_mapel }}</th>
                @endforeach
                <th>Rata - Rata</th>
                <th>Nilai Huruf</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($siswa as $index => $s)
                @php
                    $totalAverage = 0;
                    $subjectCount = $kelas->pembelajaran->count();
                @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $s->nama_siswa }}</td>
                    @foreach ($kelas->pembelajaran as $pembelajaran)
                        @php
                            $nilaiSiswa = $pembelajaran->nilai->firstWhere('nis', $s->nis);
                            $average =
                                $nilaiSiswa != null
                                    ? $nilaiSiswa->uh1 * 0.15 +
                                        $nilaiSiswa->uh2 * 0.15 +
                                        $nilaiSiswa->uh3 * 0.15 +
                                        $nilaiSiswa->uts * 0.25 +
                                        $nilaiSiswa->uas * 0.3
                                    : 0;
                            $totalAverage += $average;
                        @endphp

                        <td>{{ $average ? number_format($average, 2) : '-' }}</td>
                    @endforeach
                    <td>{{ $subjectCount ? number_format($totalAverage / $subjectCount, 2) : '-' }}</td>
                    <td>
                        @php
                            $overallAverage = $subjectCount ? $totalAverage / $subjectCount : 0;
                        @endphp
                        @if ($overallAverage >= 90)
                            A
                        @elseif ($overallAverage >= 80)
                            B
                        @elseif ($overallAverage >= 70)
                            C
                        @else
                            D
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="signature">
        <div>
            <p>Wakel</p>
            <div class="name">{{ $wakel->user->username }}</div>
        </div>
    </div>
</body>

</html>
