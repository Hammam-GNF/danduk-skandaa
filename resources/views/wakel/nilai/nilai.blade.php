@extends('wakel.layout.main')
@section('title', 'Daftar Nilai')
@section('content')

<div class="container-fluid py-0 mt-4">

    <div class="row mt-3">
        <div class="container-fluid py-4">
            <div class="card shadow-lg">
                <div class="card-body">
                    <h5 class="font-weight-bold">DAFTAR NILAI</h5>
                    <form action="{{ route('wakel.nilai.all.export', ['kelas'=>$kelas->id]) }}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-success">Cetak Transkip</button>
                    </form>''

                    <div class="table-responsive mt-3">
                        <table id="daftarpembelajaran" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Mapel</th>
                                    <th>Nama Kelas</th>
                                    <th>Wali Kelas</th>
                                    <th>Tahun Ajaran</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pembelajaran as $x)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $x->mapel->kode_mapel }} - {{ $x->mapel->nama_mapel }}</td>
                                        <td>{{ $x->kelas->kelas_tingkat }} - {{ $x->jurusan->kode_jurusan }} - {{ $x->kelas->rombel }}</td>
                                        <td>{{ $x->wakel->nama_wakel}}</td>
                                        <td>{{ $x->thajaran->thajaran }} - {{ $x->thajaran->semesterLabel }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <form action="{{ route('wakel.nilai.kelola',['id_pembelajaran' => $x->id]) }}" method="GET" class="d-inline" title="Detail Nilai">
                                                    <button type="submit" class="btn btn-info btn-sm detailButton">
                                                        <i class="bi bi-info-circle"></i>
                                                    </button>
                                                </form>
                                            </div>
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

<script>
    $(document).ready(function() {
        $('#daftarpembelajaran').DataTable();
    });

    $('.deleteButton').click(function() {
        var id = $(this).data('id');

        Swal.fire({
            title: 'Apakah Anda yakin menghapus pembelajaran ini?',
            text: "Data akan dihapus dan tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus saja!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#deleteForm' + id).submit();
            }
        });
    });
</script>

@endsection
