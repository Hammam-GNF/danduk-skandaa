<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Transkrip Presensi Kelas {{ $kelas->nama_kelas }}</title>
</head>

<body>
    <div>
        <p>Tahun Ajaran: {{ $thajaran->thajaran }}</p>
        <p>Wali Kelas: {{ $wakel->nama_wakel }}</p>
    </div>

    <table>
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
</body>

</html>
