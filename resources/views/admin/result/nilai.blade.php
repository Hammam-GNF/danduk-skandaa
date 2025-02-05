@extends('admin.layout.main')
@section('title', 'Nilai')
@section('content')

<div class="container-fluid py-0 mt-4">

    <div class="row mt-3">
        <div class="container-fluid py-4">
            <div class="card shadow-lg">
                <div class="card-body">
                    <h5 class="font-weight-bold">DAFTAR NILAI</h5>
                    <div class="table-responsive mt-3">
                        <table id="daftarnilai" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Mapel</th>
                                    <th>Nama Kelas</th>
                                    <th>Guru Pengampu</th>
                                    <th>Tahun Ajaran</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pembelajaran as $x)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $x->mapel->kode_mapel }} - {{ $x->mapel->nama_mapel }}</td>
                                        <td>{{ $x->kelas->kelas_tingkat }} - {{ $x->jurusan->kode_jurusan }} - {{ $x->kelas->rombel }}</td>
                                        <td>{{ $x->wakel->nama_wakel}}</td>
                                        <td>{{ $x->thajaran->thajaran }} - {{ $x->thajaran->semester }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <form action="{{ route('admin.nilai.indexrekapnilai',['id' => $x->id]) }}" method="GET" class="d-inline" title="Detail Presensi">
                                                    <button type="submit" class="btn btn-info btn-sm detailButton">
                                                        <i class="bi bi-info-circle"></i>
                                                    </button>
                                                </form>
                                            </div>
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
        $('#daftarnilai').DataTable();
    });
</script>
@endpush