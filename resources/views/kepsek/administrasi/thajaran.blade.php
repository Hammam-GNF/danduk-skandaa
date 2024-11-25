@extends('kepsek.layout.main')
@section('title', 'Daftar Tahun Ajaran')
@section('content')

    <div class="container-fluid py-0 mt-4">

        <!-- Daftar Tahun Ajaran -->
        <div class="row mt-3">
            <div class="container-fluid py-4">
                <div class="row">
                    <div class="col-xl-12 col-sm-5 mb-xl-0 mb-4">
                        <div class="card" style="box-shadow: 0px 0px 10px 7px rgba(76, 0, 255, 0.401);">
                            <div class="card-body p-3">
                                <div class="row">
                                    <div class="col-50">
                                        <div class="numbers">
                                            <h5 class="font-weight-bolder">DAFTAR TAHUN AJARAN</h5>
                                            <div class="card-body px-0 pt-0 pb-2">
                                                <div class="table-responsive p-0">
                                                    <table id="daftarthajaran" class="table table-striped table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th class="text-center"> No</th>
                                                                <th> Tahun Ajaran</th>
                                                                <th> Semester</th>
                                                                <th class="text-center"> Status</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($thajaran as $t)
                                                                <tr>
                                                                    <td class="text-center">{{ $loop->iteration }}</td>
                                                                    <td>{{ $t->thajaran }}</td>
                                                                    <td>{{ $t->semester }}</td>
                                                                    <td class="text-center">
                                                                        @if ($t->status == 'aktif')
                                                                            <span class="badge bg-success">Aktif</span>
                                                                        @else
                                                                            <span class="badge bg-danger">Tidak Aktif</a>
                                                                        @endif
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
        $('#daftarthajaran').DataTable();
    });
</script>
@endpush