@extends('kepsek.layout.main')
@section('title', 'Daftar Mata Pelajaran')
@section('content')

    <div class="container-fluid py-0 mt-4">

        <div class="row mt-3">
            <div class="container-fluid py-4">
                <div class="card shadow-lg">
                    <div class="card-body">
                        <h5 class="font-weight-bold">DAFTAR MATA PELAJARAN</h5>
                        <div class="table-responsive mt-3">
                            <table id="daftarmapel" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Kode Mata Pelajaran</th>
                                        <th>Nama Mata Pelajaran</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($mapel as $x)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $x->kode_mapel }}</td>
                                            <td>{{ $x->nama_mapel }}</td>
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
        $('#daftarmapel').DataTable();
    });
</script>
@endpush