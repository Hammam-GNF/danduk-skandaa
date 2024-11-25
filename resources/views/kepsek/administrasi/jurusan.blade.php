@extends('kepsek.layout.main')
@section('title', 'Daftar Jurusan')
@section('content')

<div class="container-fluid py-0 mt-4">

    <div class="row mt-3">
        <div class="col-xl-12 col-sm-5 mb-xl-0 mb-4">
            <div class="card" style="box-shadow: 0px 0px 10px 7px rgba(76, 0, 255, 0.401);">
                <div class="card-body p-3">
                    <h5 class="font-weight-bolder">DAFTAR JURUSAN</h5>
                    <div class="table-responsive">
                        <table id="daftarjurusan" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Kode Jurusan</th>
                                    <th>Nama Jurusan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($jurusan as $x)
                                <tr id="row{{ $x->id }}">
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $x->kode_jurusan }}</td>
                                    <td>{{ $x->nama_jurusan }}</td>
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
        $('#daftarjurusan').DataTable();
    });
</script>
@endpush