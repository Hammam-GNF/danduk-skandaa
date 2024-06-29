@extends('layout.main')
@section('title', 'Jurusan')
@section('content')

    <div class="container-fluid py-0 mt-4">

        <!-- Button trigger modal -->
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#tambahjurusan">
            Tambah Jurusan
        </button>
        <!-- Modal -->
        <form method="POST" action="{{ route('jurusan.store') }}">
            @csrf
            <div class="modal fade" id="tambahjurusan" tabindex="-1" aria-labelledby="tambahjurusanLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="tambahjurusanLabel">Tambah Jurusan</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-1">
                                <label for="id_jurusan" class="col-form-label">Kode Jurusan:</label>
                                <input type="text" class="form-control" id="id_jurusan" name="id_jurusan" placeholder="contoh : TKR" required>
                            </div>
                            <div class="mb-1">
                                <label for="nama_jurusan" class="col-form-label">Nama Jurusan:</label>
                                <input type="text" class="form-control" id="nama_jurusan" name="nama_jurusan" placeholder="contoh : Teknik Kendaraan Ringan" required>
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
                                            <h5 class="font-weight-bolder">DAFTAR JURUSAN</h5>
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
                                                                    Kode Jurusan</th>
                                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3"
                                                                    style="width: 20%;">
                                                                    Nama Jurusan</th>
                                                                <th class="text-secondary opacity-7" style="width: 20%;">
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        @foreach ($jurusan as $x)
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
                                                                                    {{ $x->id_jurusan }}</h6>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="d-flex px-2 py-1">
                                                                            <div
                                                                                class="d-flex flex-column justify-content-center">
                                                                                <h6 class="mb-0 text-sm">
                                                                                    {{ $x->nama_jurusan }}</h6>
                                                                            </div>
                                                                        </div>
                                                                    </td>

                                                                    <td class="align-middle-center"
                                                                        style="display: flex; align-items: center; justify-content: center;">
                                                                        <button type="button"
                                                                            class="btn btn-primary btn-sm me-2"
                                                                            data-toggle="tooltip"
                                                                            data-original-title="Edit jurusan"
                                                                            data-bs-target="#editjurusan{{ $x->id_jurusan }}"
                                                                            data-bs-toggle="modal">Edit</button>

                                                                        <form method="POST"
                                                                            action="{{ route('jurusan.update', $x->id_jurusan) }}">
                                                                            @csrf
                                                                            @method('PUT')
                                                                            <div class="modal fade"
                                                                                id="editjurusan{{ $x->id_jurusan }}"
                                                                                tabindex="-1"
                                                                                aria-labelledby="editjurusanLabel"
                                                                                aria-hidden="true">
                                                                                <div
                                                                                    class="modal-dialog modal-dialog-centered">
                                                                                    <div class="modal-content">
                                                                                        <div class="modal-header">
                                                                                            <h1 class="modal-title fs-5">
                                                                                                Edit Jurusan</h1>
                                                                                            <button type="button"
                                                                                                class="btn-close"
                                                                                                data-bs-dismiss="modal"
                                                                                                aria-label="Close"></button>
                                                                                        </div>
                                                                                        <div class="modal-body">

                                                                                            <div class="mb-1">
                                                                                                <label for="id"
                                                                                                    class="col-form-label">ID
                                                                                                    Jurusan:</label>
                                                                                                <input type="text"
                                                                                                    class="form-control"
                                                                                                    id="id"
                                                                                                    name="id_jurusan"
                                                                                                    value="{{ $x->id_jurusan }}">
                                                                                            </div>
                                                                                            <div class="mb-1">
                                                                                                <label for="nama_jurusan"
                                                                                                    class="col-form-label">Nama
                                                                                                    Jurusan:</label>
                                                                                                <input type="text"
                                                                                                    class="form-control"
                                                                                                    id="nama_jurusan"
                                                                                                    name="nama_jurusan"
                                                                                                    value="{{ $x->nama_jurusan }}">
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



                                                                        <form action="{{ route('jurusan.destroy', $x->id_jurusan) }}" method="POST" class="delete-form" id="deleteForm{{ $x->id_jurusan }}">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="button" class="btn btn-danger btn-sm deleteButton" data-id="{{ $x->id_jurusan }}">Hapus</button>
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
                    const id_jurusan = this.getAttribute('data-id'); // Fixed this line
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
                            document.getElementById('deleteForm' + id_jurusan).submit();
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



@endsection
