@extends('layout.main')
@section('title', 'User')
@section('content')

    <div class="container-fluid py-0 mt-4">

        <!-- Button trigger modal -->
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#tambahuser">
            Tambah User
        </button>
        <!-- Modal -->
        <form method="POST" action="{{ route('user.store') }}">
            @csrf
            <div class="modal fade" id="tambahuser" tabindex="-1" aria-labelledby="tambahuserLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="tambahuserLabel">Tambah User</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-1">
                                <label for="id" class="col-form-label">Level:</label>
                                <select class="form-control" id="id" name="role_id" required>
                                    <option value="" disabled selected>Pilih Level</option>
                                    <option value="2">Guru</option>
                                    <option value="3">Siswa</option>
                                </select>
                            </div>
                            <div class="mb-1">
                                <label for="username" class="col-form-label">Nama User:</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="mb-1">
                                <label for="password" class="col-form-label">Password:</label>
                                <input type="password" class="form-control" id="password" name="password" required>
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
                                            <h5 class="font-weight-bolder">DAFTAR USER</h5>
                                            <div class="card-body px-0 pt-0 pb-2">
                                                <div class="table-responsive p-0">
                                                    <table class="table align-items-center mb-0">
                                                        <thead>
                                                            <tr>
                                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                                                                    style="width: 8%;">
                                                                    NO</th>
                                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                                                                    style="width: 20%;">
                                                                    Foto</th>
                                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                                                                    style="width: 20%;">
                                                                    Level</th>
                                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"
                                                                    style="width: 30%;">
                                                                    Nama User</th>
                                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center"
                                                                    style="width: 20%;">
                                                                    Action</th>
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        @foreach ($user as $x)
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
                                                                                    {{ $x->foto }}</h6>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="d-flex px-2 py-1">
                                                                            <div
                                                                                class="d-flex flex-column justify-content-center">
                                                                                <h6 class="mb-0 text-sm">
                                                                                    {{ $x->role->level }}</h6>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="d-flex px-2 py-1">
                                                                            <div
                                                                                class="d-flex flex-column justify-content-center">
                                                                                <h6 class="mb-0 text-sm">
                                                                                    {{ $x->username }}</h6>
                                                                            </div>
                                                                        </div>
                                                                    </td>

                                                                    <td class="align-middle-center"
                                                                        style="display: flex; align-items: center; justify-content: center;">
                                                                        <button type="button"
                                                                            class="btn btn-primary btn-sm me-2"
                                                                            data-toggle="tooltip"
                                                                            data-original-title="Edit user"
                                                                            data-bs-target="#edituser{{ $x->id }}"
                                                                            data-bs-toggle="modal">Edit</button>

                                                                        {{-- <form
                                                                            action="{{ route('user.resetpassword', $x->id) }}"
                                                                            method="POST" class="reset-form">
                                                                            @csrf
                                                                            @method('PUT')
                                                                            <button type="submit"
                                                                                class="btn btn-success btn-sm me-2">Reset</button>
                                                                        </form> --}}

                                                                        <form method="POST"
                                                                            action="{{ route('user.update', $x->id) }}">
                                                                            @csrf
                                                                            @method('PUT')
                                                                            <div class="modal fade"
                                                                                id="edituser{{ $x->id }}"
                                                                                tabindex="-1"
                                                                                aria-labelledby="edituserLabel"
                                                                                aria-hidden="true">
                                                                                <div
                                                                                    class="modal-dialog modal-dialog-centered">
                                                                                    <div class="modal-content">
                                                                                        <div class="modal-header">
                                                                                            <h1 class="modal-title fs-5">
                                                                                                Edit User</h1>
                                                                                            <button type="button"
                                                                                                class="btn-close"
                                                                                                data-bs-dismiss="modal"
                                                                                                aria-label="Close"></button>
                                                                                        </div>
                                                                                        <div class="modal-body">
                                                                                            <div class="mb-1">
                                                                                                <label for="level"
                                                                                                    class="col-form-label">Level:</label>
                                                                                                <input type="text"
                                                                                                    class="form-control"
                                                                                                    id="username"
                                                                                                    name="username"
                                                                                                    value="{{ $x->role->level }}"
                                                                                                    disabled>
                                                                                            </div>

                                                                                            <div class="mb-1">
                                                                                                <label for="username"
                                                                                                    class="col-form-label">Nama
                                                                                                    User:</label>
                                                                                                <input type="text"
                                                                                                    class="form-control"
                                                                                                    id="username"
                                                                                                    name="username"
                                                                                                    value="{{ $x->username }}">
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

                                                                        <form action="{{ route('user.destroy', $x->id) }}"
                                                                            method="POST" class="delete-form"
                                                                            id="deleteForm{{ $x->id }}">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="button"
                                                                                class="btn btn-danger btn-sm deleteButton"
                                                                                data-id="{{ $x->id }}">Hapus</button>
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
                    const id = this.getAttribute('data-id'); // Fixed this line
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
                            document.getElementById('deleteForm' + id).submit();
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
