@extends('kepsek.layout.main')
@section('title', 'Wali Kelas')
@section('content')

<div class="container-fluid py-0 mt-4">

    <div class="row mt-3">
        <div class="container-fluid py-4">
            <div class="card shadow-lg">
                <div class="card-body">
                    <h5 class="font-weight-bold">DAFTAR WALI KELAS</h5>
                    <div class="table-responsive mt-3">
                        <table id="daftarwakel" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Nama Wali Kelas</th>
                                    <th>NIP</th>
                                    <th>Nama Kelas</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($wakel as $x)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $x->user->username }}</td>
                                        <td>{{ $x->user->nip }}</td>
                                        <td>{{ $x->kelas->kelas_tingkat }} - {{ $x->kelas->jurusan->kode_jurusan }} - {{ $x->kelas->rombel }}</td>
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
        $('#daftarwakel').DataTable();
    });
</script>
@endpush