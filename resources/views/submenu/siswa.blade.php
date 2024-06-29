@extends('layout.main')
@section('title', 'Daftar Siswa')
@section('content')

    <div class="container-fluid py-0 mt-4">

        
        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                                        data-bs-target="#tambahkelasx">
                                                        Tambah
                                                    </button>
                                                    <!-- Modal -->
                                                    <form method="POST" action="{{ route('siswa.store') }}">
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
                                                                                <option value="XI">XI</option>
                                                                                <option value="XII">XII</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="mb-1">
                                                                            <label for="kelas_tingkat"
                                                                                class="col-form-label">Kelas
                                                                                Tingkat:</label>
                                                                            <select class="form-control" id="kelas_tingkat"
                                                                                name="kelas_tingkat" required>
                                                                                <option value="X">X</option>
                                                                                <option value="XI">XI</option>
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

        {{-- <form action="{{ route('submenu.siswa.store', ['id_kelas' => $id_kelas]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="file">Import Excel File</label>
                <input type="file" name="file" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-danger">Import</button>
        </form>         --}}

        <div class="row mt-3">

            <div class="container-fluid py-4">
                <div class="row">
                    <div class="col-xl-12 col-sm-5 mb-xl-0 mb-4">
                        <div class="card" style="box-shadow: 0px 0px 10px 7px rgba(76, 0, 255, 0.401);">
                            <div class="card-body p-3">
                                <div class="row">
                                    <div class="col-50">
                                        <div class="numbers">
                                            <h5 class="font-weight-bolder">
                                                @if ($kelas_X->isNotEmpty() || $kelas_XI->isNotEmpty() || $kelas_XII->isNotEmpty())
                                                    {{-- Ambil nilai pertama dari kumpulan data --}}
                                                    @php
                                                        $firstSiswa = $kelas_X->isNotEmpty() ? $kelas_X->first() : ($kelas_XI->isNotEmpty() ? $kelas_XI->first() : $kelas_XII->first());
                                                    @endphp
                                                    {{ $firstSiswa->kelas->kelas_tingkat }} {{ $firstSiswa->jurusan_id }} {{ $firstSiswa->kelas->rombel }}
                                                @endif
                                            </h5>

                                            <div class="card-body px-0 pt-0 pb-2">
                                                <div class="table-responsive p-0">
                                                    <br>
                                                    <table class="table align-items-center mb-0" id="myTablex">
                                                        <thead>
                                                            <tr>
                                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3"
                                                                    style="width: 8%;">NO</th>
                                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3"
                                                                    style="width: 20%;">NIS</th>
                                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3"
                                                                    style="width: 20%;">Nama Siswa</th>
                                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3"
                                                                    style="width: 20%;">Jenis Kelamin</th>
                                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3"
                                                                    style="width: 20%;">Kelas Tingkat</th>
                                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3"
                                                                    style="width: 20%;">Jurusan</th>
                                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3"
                                                                    style="width: 20%;">Rombel</th>
                                                                <th class="text-secondary opacity-7" style="width: 20%;">
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($kelas_X as $x)
                                                                <tr>
                                                                    <td>{{ $loop->iteration }}</td>
                                                                    <td>{{ $x->nis }}</td>
                                                                    <td>{{ $x->nama_siswa }}</td>
                                                                    <td>{{ $x->jns_kelamin }}</td>
                                                                    <td>{{ $x->kelas->kelas_tingkat }}</td>
                                                                    <td>{{ $x->jurusan_id }}</td>
                                                                    <td>{{ $x->kelas->rombel }}</td>

                                                                    <td class="align-middle-center"
                                                                        style="display: flex; align-items: center; justify-content: center;">
                                                                        <button type="button"
                                                                            class="btn btn-primary btn-sm me-2"
                                                                            data-toggle="tooltip"
                                                                            data-original-title="Edit siswa"
                                                                            data-bs-target="#editsiswa{{ $x->nis }}"
                                                                            data-bs-toggle="modal">Edit</button>

                                                                        <form method="POST"
                                                                            action="{{ route('submenu.siswa.update', ['id' => $x->nis]) }}">
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
                                                                                            <h1 class="modal-title fs-5"
                                                                                                id="editsiswaLabel{{ $x->nis }}">
                                                                                                Edit Siswa</h1>
                                                                                            <button type="button"
                                                                                                class="btn-close"
                                                                                                data-bs-dismiss="modal"
                                                                                                aria-label="Close"></button>
                                                                                        </div>
                                                                                        <div class="modal-body">
                                                                                            <div class="mb-1">
                                                                                                <label for="nis"
                                                                                                    class="col-form-label">NIS:</label>
                                                                                                <input type="text"
                                                                                                    class="form-control"
                                                                                                    id="nis"
                                                                                                    name="nis"
                                                                                                    value="{{ $x->nis }}">
                                                                                            </div>
                                                                                            <div class="mb-1">
                                                                                                <label for="nama_siswa"
                                                                                                    class="col-form-label">Nama
                                                                                                    Siswa:</label>
                                                                                                <input type="text"
                                                                                                    class="form-control"
                                                                                                    id="nama_siswa"
                                                                                                    name="nama_siswa"
                                                                                                    value="{{ $x->nama_siswa }}">
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
                                                                            action="{{ route('siswa.destroy', ['id' => $x->nis]) }}"
                                                                            method="POST" class="delete-form"
                                                                            id="deleteForm{{ $x->nis }}">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="button"
                                                                                class="btn btn-danger btn-sm deleteButton"
                                                                                data-id="{{ $x->nis }}">Hapus</button>
                                                                        </form>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>

                                                        {{-- <tbody>
                                                            @foreach ($kelas_XI as $x)
                                                                <tr>
                                                                    <td>{{ $loop->iteration }}</td>
                                                                    <td>{{ $x->nis }}</td>
                                                                    <td>{{ $x->nama_siswa }}</td>
                                                                    <td>{{ $x->jns_kelamin }}</td>
                                                                    <td>{{ $x->kelas->kelas_tingkat }}</td>
                                                                    <td>{{ $x->jurusan_id }}</td>
                                                                    <td>{{ $x->kelas->rombel }}</td>

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
                                                                                            <h1 class="modal-title fs-5"
                                                                                                id="editsiswaLabel{{ $x->nis }}">
                                                                                                Edit Siswa</h1>
                                                                                            <button type="button"
                                                                                                class="btn-close"
                                                                                                data-bs-dismiss="modal"
                                                                                                aria-label="Close"></button>
                                                                                        </div>
                                                                                        <div class="modal-body">
                                                                                            <div class="mb-1">
                                                                                                <label for="nis"
                                                                                                    class="col-form-label">NIS:</label>
                                                                                                <input type="text"
                                                                                                    class="form-control"
                                                                                                    id="nis"
                                                                                                    name="nis"
                                                                                                    value="{{ $x->nis }}">
                                                                                            </div>
                                                                                            <div class="mb-1">
                                                                                                <label for="nama_siswa"
                                                                                                    class="col-form-label">Nama
                                                                                                    Siswa:</label>
                                                                                                <input type="text"
                                                                                                    class="form-control"
                                                                                                    id="nama_siswa"
                                                                                                    name="nama_siswa"
                                                                                                    value="{{ $x->nama_siswa }}">
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
                                                                            action="{{ route('siswa.destroy', $x->nis) }}"
                                                                            method="POST" class="delete-form"
                                                                            id="deleteForm{{ $x->nis }}">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="button"
                                                                                class="btn btn-danger btn-sm deleteButton"
                                                                                data-id="{{ $x->nis }}">Hapus</button>
                                                                        </form>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody> --}}
                                                    </table>
                                                </div>
                                            </div>

                                            {{-- <div class="tab-content" id="myTabContent">
                                            <div class="tab-pane fade show active" id="kelasx" role="tabpanel"
                                                aria-labelledby="kelasx" tabindex="0">
                                                
                                            </div> --}}

                                            {{-- </div> --}}

                                            {{-- <div class="tab-pane fade" id="kelasxi" role="tabpanel"
                                                aria-labelledby="kelasxi" tabindex="0">
                                                <div class="card-body px-0 pt-0 pb-2">
                                                    <div class="table-responsive p-0">
                                                        <table class="table align-items-center mb-0" id>
                                                            <thead>
                                                                <tr>
                                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3"
                                                                        style="width: 8%;">NO</th>
                                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3"
                                                                        style="width: 20%;">NIS</th>
                                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3"
                                                                        style="width: 20%;">Nama Siswa</th>
                                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3"
                                                                        style="width: 20%;">Jenis Kelamin</th>
                                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3"
                                                                        style="width: 20%;">Kelas Tingkat</th>
                                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3"
                                                                        style="width: 20%;">Jurusan</th>
                                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3"
                                                                        style="width: 20%;">Rombel</th>
                                                                    <th class="text-secondary opacity-7"
                                                                        style="width: 20%;">
                                                                    </th>
                                                                </tr>
                                                            </thead>
                                                            @foreach ($siswa as $x)
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
                                                                        <td>
                                                                            <div class="d-flex px-2 py-1">
                                                                                <div
                                                                                    class="d-flex flex-column justify-content-center">
                                                                                    <h6 class="mb-0 text-sm">
                                                                                        {{ $x->jns_kelamin }}</h6>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="d-flex px-2 py-1">
                                                                                <div
                                                                                    class="d-flex flex-column justify-content-center">
                                                                                    <h6 class="mb-0 text-sm">
                                                                                        @foreach ($kelas_X as $k)
                                                                                            @if ($k->id_kelas == $x->kelas_id)
                                                                                                {{ $k->kelas_tingkat }}
                                                                                            @endif
                                                                                        @endforeach
                                                                                    </h6>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="d-flex px-2 py-1">
                                                                                <div
                                                                                    class="d-flex flex-column justify-content-center">
                                                                                    <h6 class="mb-0 text-sm">
                                                                                        @foreach ($jurusan as $j)
                                                                                            @if ($j->id_jurusan == $x->jurusan_id)
                                                                                                {{ $j->nama_jurusan }}
                                                                                            @endif
                                                                                        @endforeach
                                                                                    </h6>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="d-flex px-2 py-1">
                                                                                <div
                                                                                    class="d-flex flex-column justify-content-center">
                                                                                    <h6 class="mb-0 text-sm">
                                                                                        @foreach ($kelas_X as $k)
                                                                                            @if ($k->id_kelas == $x->kelas_id)
                                                                                                {{ $k->rombel }}
                                                                                            @endif
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
                                                                                                <h1
                                                                                                    class="modal-title fs-5">
                                                                                                    Edit Siswa</h1>
                                                                                                <button type="button"
                                                                                                    class="btn-close"
                                                                                                    data-bs-dismiss="modal"
                                                                                                    aria-label="Close"></button>
                                                                                            </div>
                                                                                            <div class="modal-body">
                                                                                                <div class="mb-1">
                                                                                                    <label for="nis"
                                                                                                        class="col-form-label">NIS:</label>
                                                                                                    <input type="text"
                                                                                                        class="form-control"
                                                                                                        id="nis"
                                                                                                        name="nis"
                                                                                                        value="{{ $x->nis }}">
                                                                                                </div>
                                                                                                <div class="mb-1">
                                                                                                    <label for="nama_siswa"
                                                                                                        class="col-form-label">Nama
                                                                                                        Siswa:</label>
                                                                                                    <input type="text"
                                                                                                        class="form-control"
                                                                                                        id="nama_siswa"
                                                                                                        name="nama_siswa"
                                                                                                        value="{{ $x->nama_siswa }}">
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
                                                                                action="{{ route('siswa.destroy', $x->nis) }}"
                                                                                method="POST" class="delete-form"
                                                                                id="deleteForm{{ $x->nis }}">
                                                                                @csrf
                                                                                @method('DELETE')
                                                                                <button type="button"
                                                                                    class="btn btn-danger btn-sm deleteButton"
                                                                                    data-id="{{ $x->nis }}">Hapus</button>
                                                                            </form>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            @endforeach
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab-pane fade" id="kelasxii" role="tabpanel"
                                                aria-labelledby="kelasxii" tabindex="0">
                                                <div class="card-body px-0 pt-0 pb-2">
                                                    <div class="table-responsive p-0">
                                                        <table class="table align-items-center mb-0">
                                                            <thead>
                                                                <tr>
                                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3"
                                                                        style="width: 8%;">NO</th>
                                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3"
                                                                        style="width: 20%;">NIS</th>
                                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3"
                                                                        style="width: 20%;">Nama Siswa</th>
                                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3"
                                                                        style="width: 20%;">Jenis Kelamin</th>
                                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3"
                                                                        style="width: 20%;">Kelas Tingkat</th>
                                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3"
                                                                        style="width: 20%;">Jurusan</th>
                                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3"
                                                                        style="width: 20%;">Rombel</th>
                                                                    <th class="text-secondary opacity-7"
                                                                        style="width: 20%;">
                                                                    </th>
                                                                </tr>
                                                            </thead>
                                                            @foreach ($siswa as $x)
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
                                                                        <td>
                                                                            <div class="d-flex px-2 py-1">
                                                                                <div
                                                                                    class="d-flex flex-column justify-content-center">
                                                                                    <h6 class="mb-0 text-sm">
                                                                                        {{ $x->jns_kelamin }}</h6>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="d-flex px-2 py-1">
                                                                                <div
                                                                                    class="d-flex flex-column justify-content-center">
                                                                                    <h6 class="mb-0 text-sm">
                                                                                        @foreach ($kelas_X as $k)
                                                                                            @if ($k->id_kelas == $x->kelas_id)
                                                                                                {{ $k->kelas_tingkat }}
                                                                                            @endif
                                                                                        @endforeach
                                                                                    </h6>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="d-flex px-2 py-1">
                                                                                <div
                                                                                    class="d-flex flex-column justify-content-center">
                                                                                    <h6 class="mb-0 text-sm">
                                                                                        @foreach ($jurusan as $j)
                                                                                            @if ($j->id_jurusan == $x->jurusan_id)
                                                                                                {{ $j->nama_jurusan }}
                                                                                            @endif
                                                                                        @endforeach
                                                                                    </h6>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="d-flex px-2 py-1">
                                                                                <div
                                                                                    class="d-flex flex-column justify-content-center">
                                                                                    <h6 class="mb-0 text-sm">
                                                                                        @foreach ($kelas_X as $k)
                                                                                            @if ($k->id_kelas == $x->kelas_id)
                                                                                                {{ $k->rombel }}
                                                                                            @endif
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
                                                                                                <h1
                                                                                                    class="modal-title fs-5">
                                                                                                    Edit Siswa</h1>
                                                                                                <button type="button"
                                                                                                    class="btn-close"
                                                                                                    data-bs-dismiss="modal"
                                                                                                    aria-label="Close"></button>
                                                                                            </div>
                                                                                            <div class="modal-body">
                                                                                                <div class="mb-1">
                                                                                                    <label for="nis"
                                                                                                        class="col-form-label">NIS:</label>
                                                                                                    <input type="text"
                                                                                                        class="form-control"
                                                                                                        id="nis"
                                                                                                        name="nis"
                                                                                                        value="{{ $x->nis }}">
                                                                                                </div>
                                                                                                <div class="mb-1">
                                                                                                    <label for="nama_siswa"
                                                                                                        class="col-form-label">Nama
                                                                                                        Siswa:</label>
                                                                                                    <input type="text"
                                                                                                        class="form-control"
                                                                                                        id="nama_siswa"
                                                                                                        name="nama_siswa"
                                                                                                        value="{{ $x->nama_siswa }}">
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
                                                                                action="{{ route('siswa.destroy', $x->nis) }}"
                                                                                method="POST" class="delete-form"
                                                                                id="deleteForm{{ $x->nis }}">
                                                                                @csrf
                                                                                @method('DELETE')
                                                                                <button type="button"
                                                                                    class="btn btn-danger btn-sm deleteButton"
                                                                                    data-id="{{ $x->nis }}">Hapus</button>
                                                                            </form>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            @endforeach
                                                        </table>
                                                    </div>
                                                </div>
                                            </div> --}}
                                        </div>

                                    </div>
                                </div>
                            </div>
                            @if (session('suksestambah'))
                                <div class="alert alert-success mt-3">
                                    {{ session('suksestambah') }}
                                </div>
                            @endif
                            @if (session('suksesedit'))
                                <div class="alert alert-success mt-3">
                                    {{ session('suksesedit') }}
                                </div>
                            @endif
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



@endsection
