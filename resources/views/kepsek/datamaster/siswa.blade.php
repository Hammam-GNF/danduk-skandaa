@extends('kepsek.layout.main')
@section('title', 'Daftar Siswa')
@section('content')

    <div class="container-fluid py-0 mt-4">
        <div class="row">
            <div class="container-fluid py-4">
                <div class="row">
                    <div class="col-xl-12 col-sm-5 mb-xl-0 mb-4">
                        <div class="card" style="box-shadow: 0px 0px 10px 7px rgba(76, 0, 255, 0.401);">
                            <div class="card-body p-3">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="numbers">
                                            <h5 class="font-weight-bolder">DAFTAR SISWA</h5>

                                            <div class="table-responsive">
                                                <table id="daftarsiswa" class="table table-striped table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">NO</th>
                                                            <th>NIS</th>
                                                            <th>Nama Siswa</th>
                                                            <th>Jenis Kelamin</th>
                                                            <th class="text-center">Nama Kelas</th>
                                                            <th>Status</th>
                                                            <th>Tahun Ajaran</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($siswa as $x)
                                                            <tr>
                                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                                <td class="text-center">{{ $x->nis }}</td>
                                                                <td>{{ $x->nama_siswa }}</td>
                                                                <td class="text-center">{{ $x->jns_kelamin }}</td>
                                                                <td class="text-center">
                                                                    {{ $x->kelas->kelas_tingkat }} - {{ $x->kelas->jurusan->kode_jurusan }} - {{ $x->kelas->rombel }}
                                                                </td>
                                                                <td class="text-center">
                                                                    @if ($x->status == 'Aktif')
                                                                        <span
                                                                            class="badge bg-success">{{ $x->status }}</span>
                                                                    @else
                                                                        <span
                                                                            class="badge bg-danger">{{ $x->status }}</span>
                                                                    @endif
                                                                </td>
                                                                <td class="text-center">{{ $x->thajaran->thajaran }} - {{ $x->thajaran->semesterLabel }}</td>

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
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#daftarsiswa').DataTable();
    });
</script>
@endpush