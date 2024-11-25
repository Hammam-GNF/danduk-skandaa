@extends('admin.layout.main')
@section('title', 'TRANSKRIP')
@section('content')

<div class="container-fluid py-0 mt-4">

    <div class="row mt-3">
        <div class="container-fluid py-4">
            <div class="card shadow-lg">
                <div class="card-body">
                    <h5 class="font-weight-bold">DAFTAR TRANSKRIP</h5>
                    <div class="table-responsive m-t3">
                        <table id="daftarnilai" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Kelas</th>
                                    <th>Wali Kelas</th>
                                    <th>Tahun Ajaran</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kelas as $tahunAjaran)
                                    @foreach ($tahunAjaran->kelas as $x)
                                        <tr>
                                            <td>{{ $loop->parent->iteration }}.{{ $loop->iteration }}</td>
                                            <td>{{ $x->kelas_tingkat }} - {{ $x->jurusan->kode_jurusan }} {{ $x->rombel }}</td>
                                            <td>{{ $x->wakel->nama_wakel }}</td>
                                            <td>{{ $x->thajaran->thajaran }} - {{ $x->thajaran->semester }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <form action="{{ route('admin.result.nilai.rekaptranskrip', ['id' => $x->id]) }}" method="GET" class="d-inline" title="Detail Rekapan">
                                                        <button type="submit" class="btn btn-info btn-sm">
                                                            <i class="bi bi-info-circle"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
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

@push('scripts')
<script>
    $(document).ready(function() {
        $('#daftarnilai').DataTable();
    });
</script>
@endpush