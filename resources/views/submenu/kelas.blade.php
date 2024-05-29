@extends('layout.main')
@section('title', 'Kelas')
@section('content')

    <div class="container-fluid py-0 mt-4">

        <!-- Button trigger modal -->
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#tambahkelas">
            Tambah Kelas
        </button>
        <!-- Modal -->
        <form method="POST" action="{{ route('kelas.store') }}">
            @csrf
            <div class="modal fade" id="tambahkelas" tabindex="-1" aria-labelledby="tambahkelasLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="tambahkelasLabel">Tambah Kelas</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-1">
                                <label for="kelas_tingkat" class="col-form-label">Kelas Tingkat:</label>
                                <select class="form-control" id="kelas_tingkat" name="kelas_tingkat" required>
                                    <option value="">Pilih Kelas</option>
                                    <option value="X">X</option>
                                    <option value="XI">XI</option>
                                    <option value="XII">XII</option>
                                </select>
                            </div>
                            
                            <div class="mb-1">
                                <label for="nama_jurusan" class="col-form-label">Jurusan:</label>
                                <select class="form-control" id="jurusan" name="jurusan_id" required>
                                    <option value="">Pilih Jurusan</option>
                                    @foreach($jurusan as $j)
                                        <option value="{{ $j->id_jurusan }}">{{ $j->nama_jurusan }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-1">
                                <label for="id_rombel" class="col-form-label">Rombel:</label>
                                <select class="form-control" id="rombel" name="rombel_id" required>
                                    <option value="">Pilih Rombel</option>
                                    @foreach($rombel as $r)
                                        <option value="{{ $r->id_rombel }}">{{ $r->id_rombel }}</option>
                                    @endforeach
                                </select>                            
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
                                            <h5 class="font-weight-bolder">DAFTAR KELAS</h5>
                                            <div class="card-body px-0 pt-0 pb-2">
                                                <div class="table-responsive p-0">
                                                    <table class="table align-items-center mb-0">
                                                        <thead>
                                                            <tr>
                                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-3" style="width: 8%;"> NO</th>
                                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-3" style="width: 20%;"> Kelas Tingkat</th>
                                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-3" style="width: 20%;"> Jurusan</th>
                                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-3" style="width: 30%;"> Rombel</th>
                                                                <th class="text-secondary" style="width: 20%;"> </th>
                                                            </tr>
                                                        </thead>
                                                        @foreach ($kelas as $x)
                                                            <tbody>
                                                                <tr style="border-bottom: 1px solid #ddd;">
                                                                    <td>
                                                                        <div class="d-flex px-2 py-1">
                                                                            <div class="d-flex flex-column justify-content-center">
                                                                                <h6 class="mb-0 text-sm">
                                                                                    {{ $loop->iteration }}
                                                                                </h6>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="d-flex px-2 py-1">
                                                                            <div
                                                                                class="d-flex flex-column justify-content-center">
                                                                                <h6 class="mb-0 text-sm">
                                                                                    {{ $x->kelas_tingkat }}</h6>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="d-flex px-2 py-1">
                                                                            <div class="d-flex flex-column justify-content-center">
                                                                                <h6 class="mb-0 text-sm">
                                                                                    @foreach($jurusan as $j)
                                                                                    @if ($j->id_jurusan == $x->jurusan_id) {{ $j->nama_jurusan }}
                                                                                    @endif
                                                                                    @endforeach
                                                                                </h6>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="d-flex px-2 py-1">
                                                                            <div class="d-flex flex-column justify-content-center">
                                                                                <h6 class="mb-0 text-sm">
                                                                                    @foreach($rombel as $r)
                                                                                        @if($r->id_rombel == $x->rombel_id) {{ $r->id_rombel }}@endif                                                                                
                                                                                    @endforeach                                                                                
                                                                                </h6>
                                                                            </div>
                                                                        </div>
                                                                    </td>

                                                                    <td class="align-middle-center"
                                                                        style="display: flex; align-items: center; justify-content: center;">
                                                                        <button type="button"
                                                                            class="btn btn-primary btn-sm me-2"
                                                                            data-toggle="tooltip"
                                                                            data-original-title="Edit kelas"
                                                                            data-bs-target="#editkelas{{ $x->id_kelas }}"
                                                                            data-bs-toggle="modal">Edit</button>

                                                                        <form method="POST"
                                                                            action="{{ route('kelas.update', $x->id_kelas) }}">
                                                                            @csrf
                                                                            @method('PUT')
                                                                            <div class="modal fade" id="editkelas{{ $x->id_kelas }}" tabindex="-1" aria-labelledby="editkelasLabel" aria-hidden="true">
                                                                                <div
                                                                                    class="modal-dialog modal-dialog-centered">
                                                                                    <div class="modal-content">
                                                                                        <div class="modal-header">
                                                                                            <h1 class="modal-title fs-5"> Edit Kelas</h1>
                                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                        </div>
                                                                                        <div class="modal-body">

                                                                                            <div class="mb-1">
                                                                                                <label for="nama_jurusan" class="col-form-label">Nama Jurusan:</label>
                                                                                                    <select class="form-control" id="jurusan_id" name="jurusan_id" required>
                                                                                                        <option value="">Pilih Jurusan</option>
                                                                                                        @foreach($jurusan as $j)
                                                                                                            <option value="{{ $j->id_jurusan }}" @if($j->id_jurusan == $x->jurusan_id) selected @endif>{{ $j->nama_jurusan }}</option>
                                                                                                        @endforeach
                                                                                                    </select>
                                                                                            </div>
                                                                                            <div class="mb-1">
                                                                                                <label for="kelas_tingkat" class="col-form-label">Kelas Tingkat:</label>
                                                                                                <select class="form-control" id="kelas_tingkat" name="kelas_tingkat" required>
                                                                                                    <option value="">Pilih Kelas</option>
                                                                                                    <option value="X" @if($x->kelas_tingkat == 'X') selected @endif>X</option>
                                                                                                    <option value="XI" @if($x->kelas_tingkat == 'XI') selected @endif>XI</option>
                                                                                                    <option value="XII" @if($x->kelas_tingkat == 'XII') selected @endif>XII</option>
                                                                                                </select>
                                                                                            </div>                                                                                            
                                                                                            <div class="mb-1">
                                                                                                <label for="id_rombel" class="col-form-label">Rombel:</label>
                                                                                                <select class="form-control" id="rombel" name="rombel_id" required>
                                                                                                    <option value="">Pilih Rombel</option>
                                                                                                    @foreach($rombel as $r)
                                                                                                        <option value="{{ $r->id_rombel }}" @if($r->id_rombel == $x->rombel_id) selected @endif>{{ $r->id_rombel }}</option>
                                                                                                    @endforeach
                                                                                                </select>
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



                                                                        <form action="{{ route('kelas.destroy', $x->id_kelas) }}" method="POST" class="delete-form" id="deleteForm{{ $x->id_kelas }}">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="button" class="btn btn-danger btn-sm deleteButton" data-id="{{ $x->id_kelas }}">Hapus</button>
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
                    const id_kelas = this.getAttribute('data-id'); // Fixed this line
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
                            document.getElementById('deleteForm' + id_kelas).submit();
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
