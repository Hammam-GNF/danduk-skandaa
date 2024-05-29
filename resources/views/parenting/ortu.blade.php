{{-- @extends('layout.main')
@section('title', 'Orang Tua')
@section('content')

    <div class="container-fluid py-0 mt-4">

        <!-- Button trigger modal -->
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#tambahortu">
            Tambah Orang Tua
        </button>
        <!-- Modal -->
        <form method="POST" action="{{ route('ortu.store') }}">
            @csrf
            <div class="modal fade" id="tambahortu" tabindex="-1" aria-labelledby="tambahortuLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="tambahortuLabel">Tambah OrangTua</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-1">
                                <label for="nama_ayah" class="col-form-label">Nama Ayah:</label>
                                <input type="text" class="form-control" id="nama_ayah" name="nama_ayah" required>
                            </div>
                            <div class="mb-1">
                                <label for="no_hp" class="col-form-label">Nomor HP:</label>
                                <input type="text" class="form-control" id="no_hp" name="no_hp" required>
                            </div>
                            <div class="mb-1">
                                <label for="alamat" class="col-form-label">Alamat:</label>
                                <input type="text" class="form-control" id="alamat" name="alamat" required>
                            </div>
                            <div class="mb-1">
                                <label for="tgl_lahir" class="col-form-label">Tanggal Lahir:</label>
                                <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir" required>
                            </div>
                            <div class="mb-1">
                                <label for="pekerjaan" class="col-form-label">Pekerjaan:</label>
                                <input type="date" class="form-control" id="pekerjaan" name="pekerjaan" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <div class="row mt-3">

            <div class="container-fluid py-4">
                <div class="row">
                    <div class="col-xl-12 col-sm-5 mb-xl-0 mb-4">
                        <div class="card" style="box-shadow: 0px 0px 10px 7px rgba(76, 0, 255, 0.401);">
                            <div class="card-body p-3">
                                <div class="row">
                                    <div class="col-50">
                                        <div class="numbers">
                                            <h5 class="font-weight-bolder">DAFTAR ORANGTUA</h5>
                                            <div class="card-body px-0 pt-0 pb-2">
                                                <div class="table-responsive p-0">
                                                    <table class="table align-items-center mb-0">
                                                        <thead>
                                                            <tr>
                                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3"
                                                                    style="width: 8%;">
                                                                    NO</th>
                                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3"
                                                                    style="width: 20%;">
                                                                    NIS</th>
                                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3"
                                                                    style="width: 20%;">
                                                                    Nama Siswa</th>
                                                                <th class="text-secondary opacity-7" style="width: 20%;">
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        @foreach ($ortu as $x)
                                                            <tbody>
                                                                <tr>
                                                                    <td>
                                                                        <div class="d-flex px-2 py-1">
                                                                            <div
                                                                                class="d-flex flex-column justify-content-center">
                                                                                <h6 class="mb-0 text-sm">
                                                                                    {{ $loop->iteration }}</h6>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="d-flex px-2 py-1">
                                                                            <div
                                                                                class="d-flex flex-column justify-content-center">
                                                                                <h6 class="mb-0 text-sm">
                                                                                    {{ $x->nis }}</h6>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="d-flex px-2 py-1">
                                                                            <div
                                                                                class="d-flex flex-column justify-content-center">
                                                                                <h6 class="mb-0 text-sm">
                                                                                    {{ $x->nama_siswa }}</h6>
                                                                            </div>
                                                                        </div>
                                                                    </td>

                                                                    <td class="align-middle-center"
                                                                        style="display: flex; align-items: center; justify-content: center;">
                                                                        <button type="button"
                                                                            class="btn btn-primary btn-sm me-2"
                                                                            data-toggle="tooltip"
                                                                            data-original-title="Edit siswa"
                                                                            data-bs-target="#editsiswa{{ $x->nis }}"
                                                                            data-bs-toggle="modal">Edit</button>

                                                                        <form method="POST"
                                                                            action="{{ route('siswa.update', $x->nis) }}">
                                                                            @csrf
                                                                            @method('PUT')
                                                                            <div class="modal fade"
                                                                                id="editsiswa{{ $x->nis }}"
                                                                                tabindex="-1"
                                                                                aria-labelledby="editsiswaLabel"
                                                                                aria-hidden="true">
                                                                                <div
                                                                                    class="modal-dialog modal-dialog-centered">
                                                                                    <div class="modal-content">
                                                                                        <div class="modal-header">
                                                                                            <h1 class="modal-title fs-5">
                                                                                                Edit Siswa</h1>
                                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                        </div>
                                                                                        <div class="modal-body">

                                                                                            <div class="mb-1">
                                                                                                <label for="nis" class="col-form-label">NIS:</label>
                                                                                                <input type="text" class="form-control" id="nis" name="nis" value="{{ $x->nis }}">
                                                                                            </div>
                                                                                            <div class="mb-1">
                                                                                                <label for="nama_siswa" class="col-form-label">Nama Siswa:</label>
                                                                                                <input type="text" class="form-control" id="nama_siswa" name="nama_siswa" value="{{ $x->nama_siswa }}">
                                                                                            </div>

                                                                                        </div>

                                                                                        <div class="modal-footer">
                                                                                            <button type="button"
                                                                                                class="btn btn-secondary"
                                                                                                data-bs-dismiss="modal">Close</button>
                                                                                            <button type="submit"
                                                                                                class="btn btn-success">Save
                                                                                                changes</button>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </form>



                                                                        <form action="{{ route('siswa.destroy', $x->nis) }}" method="POST" class="delete-form" id="deleteForm{{ $x->nis }}">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="button" class="btn btn-danger btn-sm deleteButton" data-id="{{ $x->nis }}">Hapus</button>
                                                                        </form>
                                                                    </td>

                                                                </tr>
                                                            </tbody>
                                                        @endforeach
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


    <div class="container-fluid py-4">

        <footer class="footer pt-3">
            <div class="container-fluid">
                <div class="row align-items-center justify-content-lg-between">
                    <div class="col-lg-6 mb-lg-0 mb-4">
                        <div class="copyright text-center text-sm text-muted text-lg-start">
                            ©
                            <script>
                                document.write(new Date().getFullYear())
                            </script>,
                            made with <i class="fa fa-heart"></i> by
                            <a href="https://www.creative-tim.com" class="font-weight-bold" target="_blank">Creative
                                Tim</a>
                            for a better web.
                        </div>
                    </div>
                </div>
            </div>
        </footer>

    </div>


    <script src="{{ asset('/') }}js/plugins/chartjs.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.deleteButton');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const nis = this.getAttribute('data-id'); // Fixed this line
                    Swal.fire({
                        title: "Are you sure?",
                        text: "You won't be able to revert this!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Yes, delete it!"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById('deleteForm' + nis).submit();
                            // Tambahkan blok Swal.fire() di sini
                            Swal.fire({
                                title: "Deleted!",
                                text: "Your file has been deleted.",
                                icon: "success"
                            });
                        }
                    });
                });
            });
        });
    </script>



@endsection --}}
