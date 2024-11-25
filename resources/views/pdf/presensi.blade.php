<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Transkrip Presensi Kelas {{ $kelas->nama_kelas }}</title>
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
            justify-content: center;
            align-items: center;
            padding: 0 40px;
            width: 100%;
            text-align: center;
        }

        .signature div {
            text-align: center;
            width: 45%;
        }

        .signature .name {
            margin-top: 50px;
            border-top: 1px solid black;
            padding-top: 5px;
            width: 100%;
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

    <div class="header">
        <h3>DAFTAR PRESENSI</h3>
        <div class="info">
            <p>Kelas        : {{ $kelas->kelas_tingkat }} - {{ $kelas->jurusan->kode_jurusan }} - {{ $kelas->rombel }}</p>
            <p>Semester     : {{ $tahunAjaranAktif->semester }}</p>
            <p>Tahun Ajaran : {{ $tahunAjaranAktif->thajaran }}</p>
        </div>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th rowspan="2">No</th>
                <th rowspan="2">Nama Siswa</th>
                @foreach ($kelas->pembelajaran as $pembelajaran)
                    <th colspan="3">{{ $pembelajaran->mapel->nama_mapel }}</th>
                @endforeach
                <th rowspan="2">Total Izin</th>
                <th rowspan="2">Total Sakit</th>
                <th rowspan="2">Total Alpha</th>
                <th rowspan="2">Keterangan</th>
            </tr>
            <tr>
                @foreach ($kelas->pembelajaran as $pembelajaran)
                    <th>Izin</th>
                    <th>Sakit</th>
                    <th>Alpha</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($siswa as $index => $student)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $student->nama_siswa }}</td>
                    @php
                        $totalIzin = 0;
                        $totalSakit = 0;
                        $totalAlpa = 0;
                        $keterangan = '';
                    @endphp
                    @foreach ($kelas->pembelajaran as $pembelajaran)
                        @php
                            $presensi = $kelas->presensi
                                ->where('nis', $student->nis)
                                ->where('mapel_id', $pembelajaran->mapel_id)
                                ->first();

                            $izin = $presensi ? $presensi->totalizin : 0;
                            $sakit = $presensi ? $presensi->totalsakit : 0;
                            $alpa = $presensi ? $presensi->totalalpa : 0;

                            $totalIzin += $izin;
                            $totalSakit += $sakit;
                            $totalAlpa += $alpa;

                            if ($presensi) {
                                $keterangan = $presensi->keterangan;
                            }
                        @endphp
                        <td>{{ $izin }}</td>
                        <td>{{ $sakit }}</td>
                        <td>{{ $alpa }}</td>
                    @endforeach
                    <td>{{ $totalIzin }}</td>
                    <td>{{ $totalSakit }}</td>
                    <td>{{ $totalAlpa }}</td>
                    <td>{{ $keterangan }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="signature">
        @foreach ($guruPengampu as $guru)
        <div>
            <p>Guru Pengampu</p>
            <div class="name">{{ $guru->username }}</div>
        </div>
        @endforeach
    </div>
</body>

</html>
