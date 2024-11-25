@extends('kepsek.layout.main')
@section('title', 'Pengguna')
@section('content')

<div class="container-fluid py-0 mt-4">

    <div class="row mt-3">
        <div class="container-fluid py-4">
            <div class="card shadow-lg">
                <div class="card-body">
                    <h5 class="font-weight-bold">DAFTAR PENGGUNA</h5>
                    <div class="table-responsive mt-3">
                        <table id="daftarPengguna" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Role</th>
                                    <th>Nama Lengkap (Username)</th>
                                    <th>NIP</th>
                                    <th>Jenis Kelamin</th>
                                    <th>No HP</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $user->role->level }}</td>
                                        <td>{{ $user->username }}</td>
                                        <td>{{ $user->nip }}</td>
                                        <td>{{ $user->jns_kelamin }}</td>
                                        <td>{{ $user->no_hp }}</td>
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

@push('scripts')
<script>
    $(document).ready(function() {
        $('#daftarPengguna').DataTable();
    });
</script>
@endpush

@endsection
