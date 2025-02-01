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
                        @if($kelas->isEmpty() && $wakel->isEmpty() && $siswa->isEmpty())
                            <p>Data tidak tersedia. Pastikan data kelas, wali kelas, dan siswa sudah ada.</p>
                        @else
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
                                    @forelse ($wakel as $w)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $w->kelas->kelas_tingkat }} - {{ $w->kelas->jurusan->kode_jurusan }} {{ $w->kelas->rombel }}</td>
                                            <td>
                                                @if($w->user)
                                                    {{ $w->user->username }}
                                                @else
                                                    Kelas belum mempunyai wali kelas
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <form action="{{ route('admin.result.rekap.presensi', ['id' => $w->kelas_id]) }}" method="GET" class="d-inline" title="Detail Presensi">
                                                    <button type="submit" class="btn btn-primary btn-sm">
                                                        <i class="bi bi-calendar-check"></i>
                                                    </button>
                                                </form>

                                                <form action="{{ route('admin.result.rekap.nilai', ['id' => $w->kelas_id]) }}" method="GET" class="d-inline" title="Detail Nilai">
                                                    <button type="submit" class="btn btn-info btn-sm">
                                                        <i class="bi bi-journal-check"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">Tidak ada data kelas yang ditemukan.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        @endif
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
