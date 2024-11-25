<!DOCTYPE html>
<html>

<head>
    <title>Transkrip Nilai Siswa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 8px;
            text-align: center;
        }

        h2 {
            text-align: center;
            margin-top: 0;
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
            margin-bottom: 20px;
        }

        .info div {
            margin: 5px 0;
        }

        .student-details {
            text-align: left;
            margin-bottom: 20px;
        }

        .student-details div {
            margin: 5px 0;
        }

        .signature {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
            padding: 0 40px;
        }

        .signature div {
            text-align: center;
            width: 45%;
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
    
    <div class="header">
        <h3>TRANSKRIP NILAI SISWA</h3>
        <div class="info">
            
        </div>
    </div>

    <div class="student-details">
        <div><strong>Nama Siswa:</strong> {{ $siswa->nama_siswa }}</div>
        <div><strong>NIS:</strong> {{ $siswa->nis }}</div>
        <div><strong>Jenis Kelamin:</strong> {{ $siswa->jns_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</div>
        <div><strong>Jurusan:</strong> {{ $siswa->kelas->jurusan->nama_jurusan }}</div>
        <div><strong>Kelas:</strong> {{ $siswa->kelas->kelas_tingkat }} - {{ $siswa->kelas->jurusan->kode_jurusan }} - {{ $siswa->kelas->rombel }}</div>
    </div>
    
    <div class="info">
        <div><strong>Wali Kelas:</strong> {{ $wakel->user->username }}</div>
        @if ($thajaran)
            <div><strong>Tahun Ajaran:</strong> {{ $thajaran->thajaran }} - {{ $thajaran->semester }}</div>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Mapel</th>
                <th>Nilai</th>
                <th>Nilai Huruf</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalScore = 0;
                $subjectCount = 0;
            @endphp
            @foreach ($siswa->kelas->pembelajaran as $pIndex => $pembelajaran)
                @php
                    $nilaiSiswa = $siswa->nilai->firstWhere('pembelajaran_id', $pembelajaran->id);
                    $average =
                        $nilaiSiswa != null
                            ? $nilaiSiswa->uh1 * 0.15 +
                                $nilaiSiswa->uh2 * 0.15 +
                                $nilaiSiswa->uh3 * 0.15 +
                                $nilaiSiswa->uts * 0.25 +
                                $nilaiSiswa->uas * 0.3
                            : 0;
                    $totalScore += $average;
                    $subjectCount++;
                @endphp
                <tr>
                    <td>{{ $pIndex + 1 }}</td>
                    <td>{{ $pembelajaran->mapel->nama_mapel }}</td>
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
                </tr>
            @endforeach
            @php
                $overallAverage = $subjectCount ? $totalScore / $subjectCount : 0;
            @endphp
            <tr>
                <td colspan="3"><strong>Jumlah/Rata-rata</strong></td>

                <td>{{ $overallAverage ? number_format($overallAverage, 2) : '-' }}</td>
            </tr>
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
