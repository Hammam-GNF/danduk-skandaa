@extends('layout.main')
@section('title', 'Kelas')
@section('content')

    <div class="container-fluid py-0 mt-4">

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
                                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link active" id="home-tab" data-bs-toggle="tab"
                                                        data-bs-target="#home-tab-pane" type="button" role="tab"
                                                        aria-controls="home-tab-pane" aria-selected="true">Kelas X</button>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab"
                                                        data-bs-target="#profile-tab-pane" type="button" role="tab"
                                                        aria-controls="profile-tab-pane" aria-selected="false">Kelas
                                                        XI</button>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link" id="contact-tab" data-bs-toggle="tab"
                                                        data-bs-target="#contact-tab-pane" type="button" role="tab"
                                                        aria-controls="contact-tab-pane" aria-selected="false">Kelas
                                                        XII</button>
                                                </li>
                                            </ul>
                                            <div class="tab-content" id="myTabContent">
                                                
                                                <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel"
                                                    aria-labelledby="home-tab" tabindex="0">
                                                    <br>
                                                    <!-- Button trigger modal -->
                                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                                        data-bs-target="#tambahkelasx">
                                                        Tambah
                                                    </button>
                                                    <!-- Modal -->
                                                    <form method="POST" action="{{ route('kelas.store') }}">
                                                        @csrf
                                                        <div class="modal fade" id="tambahkelasx" tabindex="-1"
                                                            aria-labelledby="tambahkelasLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h1 class="modal-title fs-5" id="tambahkelasLabel">
                                                                            Tambah
                                                                            Kelas</h1>
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal"
                                                                            aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="mb-1">
                                                                            <label for="kelas_tingkat"
                                                                                class="col-form-label">Kelas
                                                                                Tingkat:</label>
                                                                            <select class="form-control" id="kelas_tingkat"
                                                                                name="kelas_tingkat" required>
                                                                                <option value="X">X</option>
                                                                                {{-- <option value="XI">XI</option>
                                                                                <option value="XII">XII</option> --}}
                                                                            </select>
                                                                        </div>
                                                                        <div class="mb-1">
                                                                            <label for="jurusan_id"
                                                                                class="col-form-label">Jurusan:</label>
                                                                            <select class="form-control" id="jurusan_id"
                                                                                name="jurusan_id" required>
                                                                                <option value="">Pilih Jurusan
                                                                                </option>
                                                                                @foreach ($jurusan as $j)
                                                                                    <option value="{{ $j->id_jurusan }}">
                                                                                        {{ $j->nama_jurusan }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <div class="mb-1">
                                                                            <label for="rombel"
                                                                                class="col-form-label">Rombongan
                                                                                Belajar ke:</label>
                                                                            <input type="number" class="form-control @error('rombel') is-invalid @enderror" id="rombel" name="rombel" placeholder="contoh : 1 atau 2 atau 3" min="1" required>
                                                                            @error('rombel')
                                                                                <span class="invalid-feedback" role="alert">
                                                                                    <strong>
                                                                                        {{ $message }}
                                                                                    </strong>
                                                                                </span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-bs-dismiss="modal">Close</button>
                                                                        <button type="submit"
                                                                            class="btn btn-success">Save
                                                                            changes</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>

                                                    <div class="card-body px-0 pt-0 pb-2">
                                                        <div class="table-responsive p-0">
                                                            <table class="table align-items-center mb-0" id="myTablex">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2"
                                                                            style="width: 8%;"> NO</th>
                                                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-3"
                                                                            style="width: 50%;"> Nama Kelas</th>
                                                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-9"
                                                                            style="width: 30%;"> Aksi</th>
                                                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-4"
                                                                            style="width: 12%;"> Detail</th>
                                                                    </tr>
                                                                </thead>
                                                                @foreach ($kelas_X as $x)
                                                                    <tbody>
                                                                        <tr style="border-bottom: 1px solid #ddd;">
                                                                            <td>{{ $loop->iteration }}</td>
                                                                            <td>{{ $x->kelas_tingkat}} - {{ $x->jurusan->id_jurusan }} ({{ $x->jurusan->nama_jurusan }}) - {{ $x->rombel }}</td>
                                                                            <td class="align-middle-center"
                                                                                style="display: flex; align-items: center; justify-content: center;">
                                                                                <button type="button"
                                                                                    class="btn btn-primary btn-sm me-2"
                                                                                    data-toggle="tooltip"
                                                                                    data-original-title="Edit kelas"
                                                                                    data-bs-target="#editkelas{{ $x->id_kelas }}"
                                                                                    data-bs-toggle="modal"> <i
                                                                                        class="bi bi-pencil-square"></i>
                                                                                </button>

                                                                                <form method="POST"
                                                                                    action="{{ route('kelas.update', $x->id_kelas) }}">
                                                                                    @csrf
                                                                                    @method('PUT')
                                                                                    <div class="modal fade"
                                                                                        id="editkelas{{ $x->id_kelas }}"
                                                                                        tabindex="-1"
                                                                                        aria-labelledby="editkelasLabel"
                                                                                        aria-hidden="true">
                                                                                        <div
                                                                                            class="modal-dialog modal-dialog-centered">
                                                                                            <div class="modal-content">
                                                                                                <div class="modal-header">
                                                                                                    <h1
                                                                                                        class="modal-title fs-5">
                                                                                                        Edit Kelas</h1>
                                                                                                    <button type="button"
                                                                                                        class="btn-close"
                                                                                                        data-bs-dismiss="modal"
                                                                                                        aria-label="Close"></button>
                                                                                                </div>
                                                                                                <div class="modal-body">

                                                                                                    <div class="mb-1">
                                                                                                        <label
                                                                                                            for="kelas_tingkat"
                                                                                                            class="col-form-label">Kelas
                                                                                                            Tingkat:</label>
                                                                                                        <select
                                                                                                            class="form-control"
                                                                                                            id="kelas_tingkat"
                                                                                                            name="kelas_tingkat"
                                                                                                            disabled>
                                                                                                            <option
                                                                                                                value="">
                                                                                                                Pilih Kelas
                                                                                                            </option>
                                                                                                            <option
                                                                                                                value="X"
                                                                                                                @if ($x->kelas_tingkat == 'X') selected @endif>
                                                                                                                X</option>
                                                                                                            <option
                                                                                                                value="XI"
                                                                                                                @if ($x->kelas_tingkat == 'XI') selected @endif>
                                                                                                                XI</option>
                                                                                                            <option
                                                                                                                value="XII"
                                                                                                                @if ($x->kelas_tingkat == 'XII') selected @endif>
                                                                                                                XII</option>
                                                                                                        </select>
                                                                                                    </div>
                                                                                                    <div class="mb-1">
                                                                                                        <label
                                                                                                            for="nama_jurusan"
                                                                                                            class="col-form-label">Nama
                                                                                                            Jurusan:</label>
                                                                                                        <select
                                                                                                            class="form-control"
                                                                                                            id="jurusan_nama"
                                                                                                            name="jurusan_nama"
                                                                                                            required>
                                                                                                            <option
                                                                                                                value="">
                                                                                                                Pilih
                                                                                                                Jurusan
                                                                                                            </option>
                                                                                                            @foreach ($jurusan as $j)
                                                                                                                <option
                                                                                                                    value="{{ $j->id_jurusan }}"
                                                                                                                    @if ($j->id_jurusan == $x->jurusan_id) selected @endif>
                                                                                                                    {{ $j->nama_jurusan }}
                                                                                                                </option>
                                                                                                            @endforeach
                                                                                                        </select>
                                                                                                    </div>
                                                                                                    <div class="mb-1">
                                                                                                        <label
                                                                                                            for="rombel"
                                                                                                            class="col-form-label">Rombongan
                                                                                                            Belajar
                                                                                                            ke:</label>
                                                                                                        <input
                                                                                                            type="number"
                                                                                                            class="form-control"
                                                                                                            id="rombel"
                                                                                                            name="rombel"
                                                                                                            value="{{ $x->rombel }}"
                                                                                                            min="1"
                                                                                                            required>
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

                                                                                <form
                                                                                    action="{{ route('kelas.destroy', $x->id_kelas) }}"
                                                                                    method="POST" class="delete-form"
                                                                                    id="deleteForm{{ $x->id_kelas }}">
                                                                                    @csrf
                                                                                    @method('DELETE')
                                                                                    <button type="button"
                                                                                        class="btn btn-danger btn-sm deleteButton"
                                                                                        data-id="{{ $x->id_kelas }}">
                                                                                        <i class="bi bi-trash"></i>
                                                                                    </button>
                                                                                </form>
                                                                            </td>

                                                                            <td>
                                                                                <a href="{{ route('submenu.siswa.index', $x->id_kelas) }}"
                                                                                    class="btn btn-success btn-sm me-2"
                                                                                    role="button">
                                                                                    <i class="bi bi-archive"></i>
                                                                                </a>
                                                                            </td>

                                                                        </tr>
                                                                        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                                                                        @if ($errors->any())
                                                                            <script>
                                                                                Swal.fire({
                                                                                    icon: 'error',
                                                                                    title: 'Validation Error',
                                                                                    html: '<ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
                                                                                    confirmButtonText: 'OK'
                                                                                });
                                                                            </script>
                                                                        @endif
                                                                    </tbody>
                                                                @endforeach
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>

                                                <br>
                                                <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel"
                                                    aria-labelle\dby="profile-tab" tabindex="0">
                                                    <!-- Button trigger modal -->
                                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                                        data-bs-target="#tambahkelasxi">
                                                        Tambah
                                                    </button>
                                                    <!-- Modal -->
                                                    <form method="POST" action="{{ route('kelas.store') }}">
                                                        @csrf
                                                        <div class="modal fade" id="tambahkelasxi" tabindex="-1"
                                                            aria-labelledby="tambahkelasLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h1 class="modal-title fs-5"
                                                                            id="tambahkelasLabel">Tambah
                                                                            Kelas</h1>
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal"
                                                                            aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="mb-1">
                                                                            <label for="kelas_tingkat"
                                                                                class="col-form-label">Kelas
                                                                                Tingkat:</label>
                                                                            <select class="form-control"
                                                                                id="kelas_tingkat" name="kelas_tingkat"
                                                                                required>
                                                                                {{-- <option value="X">X</option> --}}
                                                                                <option value="XI">XI</option>
                                                                                {{-- <option value="XII">XII</option> --}}
                                                                            </select>
                                                                        </div>
                                                                        <div class="mb-1">
                                                                            <label for="jurusan_id"
                                                                                class="col-form-label">Jurusan:</label>
                                                                            <select class="form-control" id="jurusan_id"
                                                                                name="jurusan_id" required>
                                                                                <option value="">Pilih Jurusan
                                                                                </option>
                                                                                @foreach ($jurusan as $j)
                                                                                    <option value="{{ $j->id_jurusan }}">
                                                                                        {{ $j->nama_jurusan }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <div class="mb-1">
                                                                            <label for="rombel"
                                                                                class="col-form-label">Rombongan
                                                                                Belajar ke:</label>
                                                                            <input type="number" class="form-control"
                                                                                id="rombel" name="rombel"
                                                                                placeholder="contoh : 1 atau 2 atau 3"
                                                                                min="1" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-bs-dismiss="modal">Close</button>
                                                                        <button type="submit"
                                                                            class="btn btn-success">Save
                                                                            changes</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>

                                                    <div class="card-body px-0 pt-0 pb-2">
                                                        <div class="table-responsive p-0">
                                                            <table class="table align-items-center mb-0" id="myTablexi">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2"
                                                                            style="width: 8%;"> NO</th>
                                                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-3"
                                                                            style="width: 50%;"> Nama Kelas</th>
                                                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-9"
                                                                            style="width: 30%;"> Aksi</th>
                                                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-4"
                                                                            style="width: 12%;"> Detail</th>
                                                                    </tr>
                                                                </thead>
                                                                @foreach ($kelas_XI as $x)
                                                                    <tbody>
                                                                        <tr style="border-bottom: 1px solid #ddd;">
                                                                            <td>{{ $loop->iteration }}</td>
                                                                            <td>{{ $x->kelas_tingkat}} - {{ $x->jurusan->id_jurusan }} ({{ $x->jurusan->nama_jurusan }}) - {{ $x->rombel }}</td>
                                                                            <td class="align-middle-center"
                                                                                style="display: flex; align-items: center; justify-content: center;">
                                                                                <button type="button"
                                                                                    class="btn btn-primary btn-sm me-2"
                                                                                    data-toggle="tooltip"
                                                                                    data-original-title="Edit kelas"
                                                                                    data-bs-target="#editkelas{{ $x->id_kelas }}"
                                                                                    data-bs-toggle="modal"> <i
                                                                                        class="bi bi-pencil-square"></i>
                                                                                </button>

                                                                                <form method="POST"
                                                                                    action="{{ route('kelas.update', $x->id_kelas) }}">
                                                                                    @csrf
                                                                                    @method('PUT')
                                                                                    <div class="modal fade"
                                                                                        id="editkelas{{ $x->id_kelas }}"
                                                                                        tabindex="-1"
                                                                                        aria-labelledby="editkelasLabel"
                                                                                        aria-hidden="true">
                                                                                        <div
                                                                                            class="modal-dialog modal-dialog-centered">
                                                                                            <div class="modal-content">
                                                                                                <div class="modal-header">
                                                                                                    <h1
                                                                                                        class="modal-title fs-5">
                                                                                                        Edit Kelas</h1>
                                                                                                    <button type="button"
                                                                                                        class="btn-close"
                                                                                                        data-bs-dismiss="modal"
                                                                                                        aria-label="Close"></button>
                                                                                                </div>
                                                                                                <div class="modal-body">

                                                                                                    <div class="mb-1">
                                                                                                        <label
                                                                                                            for="kelas_tingkat"
                                                                                                            class="col-form-label">Kelas
                                                                                                            Tingkat:</label>
                                                                                                        <select
                                                                                                            class="form-control"
                                                                                                            id="kelas_tingkat"
                                                                                                            name="kelas_tingkat"
                                                                                                            disabled>
                                                                                                            <option
                                                                                                                value="">
                                                                                                                Pilih Kelas
                                                                                                            </option>
                                                                                                            <option
                                                                                                                value="X"
                                                                                                                @if ($x->kelas_tingkat == 'X') selected @endif>
                                                                                                                X</option>
                                                                                                            <option
                                                                                                                value="XI"
                                                                                                                @if ($x->kelas_tingkat == 'XI') selected @endif>
                                                                                                                XI</option>
                                                                                                            <option
                                                                                                                value="XII"
                                                                                                                @if ($x->kelas_tingkat == 'XII') selected @endif>
                                                                                                                XII</option>
                                                                                                        </select>
                                                                                                    </div>
                                                                                                    <div class="mb-1">
                                                                                                        <label
                                                                                                            for="nama_jurusan"
                                                                                                            class="col-form-label">Nama
                                                                                                            Jurusan:</label>
                                                                                                        <select
                                                                                                            class="form-control"
                                                                                                            id="jurusan_nama"
                                                                                                            name="jurusan_nama"
                                                                                                            required>
                                                                                                            <option
                                                                                                                value="">
                                                                                                                Pilih
                                                                                                                Jurusan
                                                                                                            </option>
                                                                                                            @foreach ($jurusan as $j)
                                                                                                                <option
                                                                                                                    value="{{ $j->id_jurusan }}"
                                                                                                                    @if ($j->id_jurusan == $x->jurusan_id) selected @endif>
                                                                                                                    {{ $j->nama_jurusan }}
                                                                                                                </option>
                                                                                                            @endforeach
                                                                                                        </select>
                                                                                                    </div>
                                                                                                    <div class="mb-1">
                                                                                                        <label
                                                                                                            for="rombel"
                                                                                                            class="col-form-label">Rombongan
                                                                                                            Belajar
                                                                                                            ke:</label>
                                                                                                        <input
                                                                                                            type="number"
                                                                                                            class="form-control"
                                                                                                            id="rombel"
                                                                                                            name="rombel"
                                                                                                            value="{{ $x->rombel }}"
                                                                                                            min="1"
                                                                                                            required>
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

                                                                                <form
                                                                                    action="{{ route('kelas.destroy', $x->id_kelas) }}"
                                                                                    method="POST" class="delete-form"
                                                                                    id="deleteForm{{ $x->id_kelas }}">
                                                                                    @csrf
                                                                                    @method('DELETE')
                                                                                    <button type="button"
                                                                                        class="btn btn-danger btn-sm deleteButton"
                                                                                        data-id="{{ $x->id_kelas }}">
                                                                                        <i class="bi bi-trash"></i>
                                                                                    </button>
                                                                                </form>
                                                                            </td>

                                                                            <td>
                                                                                <a href="{{ route('submenu.siswa.index', $x->id_kelas) }}"
                                                                                    class="btn btn-success btn-sm me-2"
                                                                                    role="button">
                                                                                    <i class="bi bi-archive"></i>
                                                                                </a>
                                                                            </td>

                                                                        </tr>
                                                                    </tbody>
                                                                @endforeach
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="tab-pane fade" id="contact-tab-pane" role="tabpanel"
                                                    aria-labelledby="contact-tab" tabindex="0">

                                                    <!-- Button trigger modal -->
                                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                                        data-bs-target="#tambahkelasxii">
                                                        Tambah
                                                    </button>
                                                    <!-- Modal -->
                                                    <form method="POST" action="{{ route('kelas.store') }}">
                                                        @csrf
                                                        <div class="modal fade" id="tambahkelasxii" tabindex="-1"
                                                            aria-labelledby="tambahkelasLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h1 class="modal-title fs-5"
                                                                            id="tambahkelasLabel">Tambah
                                                                            Kelas</h1>
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal"
                                                                            aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="mb-1">
                                                                            <label for="kelas_tingkat"
                                                                                class="col-form-label">Kelas
                                                                                Tingkat:</label>
                                                                            <select class="form-control"
                                                                                id="kelas_tingkat" name="kelas_tingkat"
                                                                                required>
                                                                                {{-- <option value="X">X</option> --}}
                                                                                {{-- <option value="XI">XI</option> --}}
                                                                                <option value="XII">XII</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="mb-1">
                                                                            <label for="jurusan_id"
                                                                                class="col-form-label">Jurusan:</label>
                                                                            <select class="form-control" id="jurusan_id"
                                                                                name="jurusan_id" required>
                                                                                <option value="">Pilih Jurusan
                                                                                </option>
                                                                                @foreach ($jurusan as $j)
                                                                                    <option value="{{ $j->id_jurusan }}">
                                                                                        {{ $j->nama_jurusan }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <div class="mb-1">
                                                                            <label for="rombel"
                                                                                class="col-form-label">Rombongan
                                                                                Belajar ke:</label>
                                                                            <input type="number" class="form-control"
                                                                                id="rombel" name="rombel"
                                                                                placeholder="contoh : 1 atau 2 atau 3"
                                                                                min="1" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-bs-dismiss="modal">Close</button>
                                                                        <button type="submit"
                                                                            class="btn btn-success">Save
                                                                            changes</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>

                                                    <div class="card-body px-0 pt-0 pb-2">
                                                        <div class="table-responsive p-0">
                                                            <table class="table align-items-center mb-0" id="myTablexii">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2"
                                                                            style="width: 8%;"> NO</th>
                                                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-3"
                                                                            style="width: 50%;"> Nama Kelas</th>
                                                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-9"
                                                                            style="width: 30%;"> Aksi</th>
                                                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-4"
                                                                            style="width: 12%;"> Detail</th>
                                                                    </tr>
                                                                </thead>
                                                                @foreach ($kelas_XII as $x)
                                                                    <tbody>
                                                                        <tr style="border-bottom: 1px solid #ddd;">
                                                                            <td>{{ $loop->iteration }}</td>
                                                                            <td>{{ $x->kelas_tingkat}} - {{ $x->jurusan->id_jurusan }} ({{ $x->jurusan->nama_jurusan }}) - {{ $x->rombel }}</td>
                                                                            <td class="align-middle-center"
                                                                                style="display: flex; align-items: center; justify-content: center;">
                                                                                <button type="button"
                                                                                    class="btn btn-primary btn-sm me-2"
                                                                                    data-toggle="tooltip"
                                                                                    data-original-title="Edit kelas"
                                                                                    data-bs-target="#editkelas{{ $x->id_kelas }}"
                                                                                    data-bs-toggle="modal"> <i
                                                                                        class="bi bi-pencil-square"></i>
                                                                                </button>

                                                                                <form method="POST"
                                                                                    action="{{ route('kelas.update', $x->id_kelas) }}">
                                                                                    @csrf
                                                                                    @method('PUT')
                                                                                    <div class="modal fade"
                                                                                        id="editkelas{{ $x->id_kelas }}"
                                                                                        tabindex="-1"
                                                                                        aria-labelledby="editkelasLabel"
                                                                                        aria-hidden="true">
                                                                                        <div
                                                                                            class="modal-dialog modal-dialog-centered">
                                                                                            <div class="modal-content">
                                                                                                <div class="modal-header">
                                                                                                    <h1
                                                                                                        class="modal-title fs-5">
                                                                                                        Edit Kelas</h1>
                                                                                                    <button type="button"
                                                                                                        class="btn-close"
                                                                                                        data-bs-dismiss="modal"
                                                                                                        aria-label="Close"></button>
                                                                                                </div>
                                                                                                <div class="modal-body">

                                                                                                    <div class="mb-1">
                                                                                                        <label
                                                                                                            for="kelas_tingkat"
                                                                                                            class="col-form-label">Kelas
                                                                                                            Tingkat:</label>
                                                                                                        <select
                                                                                                            class="form-control"
                                                                                                            id="kelas_tingkat"
                                                                                                            name="kelas_tingkat"
                                                                                                            disabled>
                                                                                                            <option
                                                                                                                value="">
                                                                                                                Pilih Kelas
                                                                                                            </option>
                                                                                                            <option
                                                                                                                value="X"
                                                                                                                @if ($x->kelas_tingkat == 'X') selected @endif>
                                                                                                                X</option>
                                                                                                            <option
                                                                                                                value="XI"
                                                                                                                @if ($x->kelas_tingkat == 'XI') selected @endif>
                                                                                                                XI</option>
                                                                                                            <option
                                                                                                                value="XII"
                                                                                                                @if ($x->kelas_tingkat == 'XII') selected @endif>
                                                                                                                XII</option>
                                                                                                        </select>
                                                                                                    </div>
                                                                                                    <div class="mb-1">
                                                                                                        <label
                                                                                                            for="nama_jurusan"
                                                                                                            class="col-form-label">Nama
                                                                                                            Jurusan:</label>
                                                                                                        <select
                                                                                                            class="form-control"
                                                                                                            id="jurusan_nama"
                                                                                                            name="jurusan_nama"
                                                                                                            required>
                                                                                                            <option
                                                                                                                value="">
                                                                                                                Pilih
                                                                                                                Jurusan
                                                                                                            </option>
                                                                                                            @foreach ($jurusan as $j)
                                                                                                                <option
                                                                                                                    value="{{ $j->id_jurusan }}"
                                                                                                                    @if ($j->id_jurusan == $x->jurusan_id) selected @endif>
                                                                                                                    {{ $j->nama_jurusan }}
                                                                                                                </option>
                                                                                                            @endforeach
                                                                                                        </select>
                                                                                                    </div>
                                                                                                    <div class="mb-1">
                                                                                                        <label
                                                                                                            for="rombel"
                                                                                                            class="col-form-label">Rombongan
                                                                                                            Belajar
                                                                                                            ke:</label>
                                                                                                        <input
                                                                                                            type="number"
                                                                                                            class="form-control"
                                                                                                            id="rombel"
                                                                                                            name="rombel"
                                                                                                            value="{{ $x->rombel }}"
                                                                                                            min="1"
                                                                                                            required>
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

                                                                                <form
                                                                                    action="{{ route('kelas.destroy', $x->id_kelas) }}"
                                                                                    method="POST" class="delete-form"
                                                                                    id="deleteForm{{ $x->id_kelas }}">
                                                                                    @csrf
                                                                                    @method('DELETE')
                                                                                    <button type="button"
                                                                                        class="btn btn-danger btn-sm deleteButton"
                                                                                        data-id="{{ $x->id_kelas }}">
                                                                                        <i class="bi bi-trash"></i>
                                                                                    </button>
                                                                                </form>
                                                                            </td>

                                                                            <td>
                                                                                <a href="{{ route('submenu.siswa.index', $x->id_kelas) }}"
                                                                                    class="btn btn-success btn-sm me-2"
                                                                                    role="button">
                                                                                    <i class="bi bi-archive"></i>
                                                                                </a>
                                                                            </td>

                                                                        </tr>
                                                                    </tbody>
                                                                @endforeach
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="disabled-tab-pane" role="tabpanel"
                                                    aria-labelledby="disabled-tab" tabindex="0">...</div>
                                            </div>
                                            <br>

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


    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <!-- Initialize DataTables -->
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
        });
    </script>

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
