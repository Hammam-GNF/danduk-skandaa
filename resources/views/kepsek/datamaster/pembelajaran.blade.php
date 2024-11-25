@extends('kepsek.layout.main')
@section('title', 'Daftar Pembelajaran')
@section('content')

<div class="container-fluid py-0 mt-4">

    <div class="row mt-3">
        <div class="container-fluid py-4">
            <div class="card shadow-lg">
                <div class="card-body">
                    <h5 class="font-weight-bold">DAFTAR PEMBELAJARAN</h5>
                    <div class="table-responsive mt-3">
                        <table id="daftarpembelajaran" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Mapel</th>
                                    <th>Nama Kelas</th>
                                    <th>Guru Pengampu</th>
                                    <th>Tahun Ajaran</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pembelajaran as $x)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $x->mapel ? $x->mapel->kode_mapel . ' - ' . $x->mapel->nama_mapel : 'Data Tidak Ada' }}</td>
                                        <td>
                                            {{ $x->kelas ? $x->kelas->kelas_tingkat : 'Data Tidak Ada' }} -
                                            {{ $x->kelas->jurusan ? $x->kelas->jurusan->kode_jurusan : 'Data Tidak Ada' }} -
                                            {{ $x->kelas ? $x->kelas->rombel : 'Data Tidak Ada' }}
                                        </td>
                                        <td>{{ $x->guru ? $x->guru->username : 'Data Tidak Ada' }}</td>
                                        <td>
                                            {{ $x->thajaran ? $x->thajaran->thajaran . ' - ' . $x->thajaran->semesterLabel : 'Data Tidak Ada' }}
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

@endsection




@push('scripts')
<script>
    $(document).ready(function() {
        $('#daftarpembelajaran').DataTable();
    });
</script>
@endpush