@extends('admin.layout.main')
@section('title', 'DAFTAR PRESENSI')
@section('content')

<div class="container-fluid py-0 mt-4">
    <div class="row mt-3">
        <div class="container-fluid py-4">
            <div class="card shadow-lg">
                <div class="card-body">
                    <h5 class="font-weight-bold">DAFTAR PRESENSI</h5>
                    <div class="table-responsive mt-3">
                        <table id="daftarpresensi" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Nama Kelas</th>
                                    <th>Nama Wali Kelas</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kelas as $k)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $k->kelas_tingkat }} - {{ $k->jurusan->kode_jurusan }} {{ $k->rombel }}</td>
                                    <td>
                                        @if($k->wakel)
                                            {{ $k->wakel->user->username }}
                                        @else
                                            Kelas belum mempunyai wali kelas
                                        @endif
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.result.presensi.rekaptranskrip', ['id' => $k->id]) }}" method="GET" class="d-inline" title="Detail Presensi">
                                            <button type="submit" class="btn btn-info btn-sm">
                                                <i class="bi bi-calendar-check"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.result.nilai.rekaptranskrip', ['id' => $k->id]) }}" method="GET" class="d-inline" title="Detail Nilai">
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

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#daftarpresensi').DataTable();
    });
</script>
@endpush
