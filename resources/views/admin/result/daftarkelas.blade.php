@extends('admin.layout.main')
@section('title', 'REKAP HASIL PEMBELAJARAN')
@section('content')

<div class="container-fluid py-0 mt-4">
    @if (isset($message))
    <div class="alert alert-danger d-flex align-items-center" style="width: 300px; margin-left: 0; text-align: center;">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        {{ $message }}
    </div>
    @endif


    <div class="row mt-3">
        <div class="container-fluid py-4">
            <div class="card shadow-lg">
                <div class="card-body">
                    <h5 class="font-weight-bolder">REKAP HASIL PEMBELAJARAN</h5>
                    <div class="table-responsive mt-3">

                        <table id="daftarhasil" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Nama Kelas</th>
                                    <th>Nama Wali Kelas</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pembelajaran as $p)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $p->kelas->kelas_tingkat }} - {{ $p->kelas->jurusan->kode_jurusan }} - {{ $p->kelas->rombel }}</td>
                                    <td>{{ $p->wakel ? $p->wakel->guru->username : 'Data Tidak Ada' }}</td>

                                    <td class="text-center">
                                        <form action="{{ route('admin.result.rekap.presensi', ['id' => $p->id]) }}" method="GET" class="d-inline" title="Detail Presensi">
                                            <button type="submit" class="btn btn-primary btn-sm">
                                                <i class="bi bi-calendar-check"></i>
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.result.rekap.nilai', ['id' => $p->id]) }}" method="GET" class="d-inline" title="Detail Nilai">
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
        $('#daftarhasil').DataTable();
    });
</script>
@endpush