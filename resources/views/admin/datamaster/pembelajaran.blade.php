@extends('admin.layout.main')
@section('title', 'Daftar Pembelajaran')
@section('content')

<div class="container-fluid py-0 mt-4">

    <!-- Button trigger modal -->
    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#tambahpembelajaran">
        Tambah Pembelajaran
    </button>

<!-- Modal Tambah Pembelajaran -->
<form method="POST" action="{{ route('admin.pembelajaran.store') }}">
    @csrf
    <div class="modal fade" id="tambahpembelajaran" tabindex="-1" aria-labelledby="tambahpembelajaranLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahpembelajaranLabel">Tambah Pembelajaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="id_guru">Guru</label>
                        <input type="hidden" class="form-control" name="id_guru" id="id_guru">
                        <select name="id_guru" id="id_guru" class="form-control">
                            <option value="">--Pilih Guru--</option>
                            @foreach ($guru as $g)
                                <option value="{{ $g->id }}">{{ $g->username }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="kelas_id" class="form-label">Nama Kelas:</label>
                        <select class="form-select" id="kelas_id" name="kelas_id" required>
                            <option value="">--Pilih Kelas--</option>
                            @foreach ($kelas as $k)
                                <option value="{{ $k->id }}">{{ $k->kelas_tingkat }} - {{ $k->jurusan->kode_jurusan }} - {{ $k->rombel }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="mapel_id" class="form-label">Nama Mapel:</label>
                        <select class="form-select" id="mapel_id" name="mapel_id" required>
                            <option value="">--Pilih Nama Mapel--</option>
                            @foreach ($mapel as $m)
                            <option value="{{ $m->id }}">{{ $m->nama_mapel }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="thajaran_id" class="form-label">Tahun Ajaran:</label>
                        <select class="form-control" id="thajaran_id" name="thajaran_id" readonly>
                            <option value="{{ $thajaran->id }}">{{ $thajaran->thajaran }} - {{ $thajaran->semesterLabel }}</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle change event for Tahun Ajaran
        document.getElementById('thajaran_id').addEventListener('change', function() {
            var thajaran_id = this.value;
            var kelasSelect = document.getElementById('kelas_id');
            var mapelSelect = document.getElementById('mapel_id');
            var wakelDisplay = document.getElementById('wakel_display');
            var wakelInput = document.getElementById('wakel_id');
            var jurusanInput = document.getElementById('jurusan_id');

            kelasSelect.innerHTML = '<option value="">---Pilih Kelas---</option>';
            kelasSelect.disabled = true;
            mapelSelect.innerHTML = '<option value="">---Pilih Nama Mapel---</option>';
            mapelSelect.disabled = true;
            wakelDisplay.value = '';
            wakelInput.value = '';
            jurusanInput.value = '';

            if (thajaran_id) {
                // Fetch data for Kelas
                fetch(`/admin/datamaster/siswa/getKelasByThajaran/${thajaran_id}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.kelas) {
                            data.kelas.forEach(kelas => {
                                let option = document.createElement('option');
                                option.value = kelas.id;
                                option.text = `${kelas.kelas_tingkat} - ${kelas.jurusan.kode_jurusan} - ${kelas.rombel}`;
                                kelasSelect.appendChild(option);
                            });
                            kelasSelect.disabled = false;
                        } else {
                            console.error('Data kelas tidak ditemukan.');
                        }
                    })
                    .catch(error => console.error('Error fetching kelas:', error));

                // Fetch data for Mapel
                fetch(`/admin/datamaster/pembelajaran/mapel/${thajaran_id}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data) {
                            data.forEach(mapel => {
                                let option = document.createElement('option');
                                option.value = mapel.id;
                                option.text = mapel.nama_mapel;
                                mapelSelect.appendChild(option);
                            });
                            mapelSelect.disabled = false;
                        } else {
                            console.error('Data mapel tidak ditemukan.');
                        }
                    })
                    .catch(error => console.error('Error fetching mapel:', error));
            }
        });

        // Handle change event for Kelas
        document.getElementById('kelas_id').addEventListener('change', function() {
            var kelas_id = this.value;
            var wakelDisplay = document.getElementById('wakel_display');
            var wakelInput = document.getElementById('wakel_id');
            var jurusanInput = document.getElementById('jurusan_id');

            wakelDisplay.value = '';
            wakelInput.value = '';
            jurusanInput.value = '';

            if (kelas_id) {
                fetch(`/admin/datamaster/siswa/getWakel/${kelas_id}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.wakel) {
                            wakelDisplay.value = data.wakel.nama_wakel; // Menampilkan nama wali kelas
                            wakelInput.value = data.wakel.id; // Menyimpan ID wali kelas
                            jurusanInput.value = data.jurusan_id;
                        } else {
                            console.error('Data wakel tidak ditemukan.');
                        }
                    })
                    .catch(error => console.error('Error fetching wakel:', error));
            }
        });
    });
</script> -->


    <div class="row mt-3">
        <div class="container-fluid py-4">
            <div class="card shadow-lg">
                <div class="card-body">
                    <h5 class="font-weight-bold">DAFTAR PEMBELAJARAN</h5>
                    <div class="table-responsive mt-3">
                        <table id="daftarpembelajaran" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Mapel</th>
                                    <th>Nama Kelas</th>
                                    <th>Guru Pengampu</th>
                                    <th>Tahun Ajaran</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pembelajaran as $x)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $x->mapel ? $x->mapel->kode_mapel . ' - ' . $x->mapel->nama_mapel : 'Data Tidak Ada' }}</td>
                                        <td>
                                            {{ $x->kelas ? $x->kelas->kelas_tingkat : 'Data Tidak Ada' }} -
                                            {{ $x->kelas->jurusan ? $x->kelas->jurusan->kode_jurusan : 'Data Tidak Ada' }} -
                                            {{ $x->kelas ? $x->kelas->rombel : 'Data Tidak Ada' }}
                                        </td>
                                        <td>{{ $x->guru ? $x->guru->username : 'Data Tidak Ada' }}</td>
                                        <td>
                                            {{ $x->thajaran ? $x->thajaran->thajaran . ' - ' . $x->thajaran->semesterLabel : 'Data Tidak Ada' }}
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <!-- Button Edit -->
                                                <button type="button" class="btn btn-primary btn-sm me-2" data-bs-toggle="modal" data-bs-target="#editpembelajaran{{ $x->id }}">
                                                    <i class="bi bi-pencil-square"></i>
                                                </button>

                                                <!-- Modal Edit -->
                                                <div class="modal fade" id="editpembelajaran{{ $x->id }}" tabindex="-1" aria-labelledby="editpembelajaranLabel{{ $x->id }}" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <form method="POST" action="{{ route('admin.pembelajaran.update', $x->id) }}">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="editpembelajaranLabel{{ $x->id }}">Edit Pembelajaran</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="mb-3">
                                                                        <label for="kelas_id{{ $x->id }}" class="form-label">Nama Kelas:</label>
                                                                        <select class="form-select" id="kelas_id{{ $x->id }}" name="kelas_id" required>
                                                                            <option value="">--Pilih Kelas--</option>
                                                                            @foreach($kelas as $k)
                                                                            <option value="{{ $k->id }}" {{ $x->kelas_id == $k->id ? 'selected' : '' }}
                                                                                data-wakel="{{ $k->wakel ? $k->wakel->id : '' }}"
                                                                                data-nama-wakel="{{ $k->wakel ? $k->wakel->nama_wakel : '' }}"
                                                                                data-jurusan="{{ $k->jurusan_id }}">
                                                                                {{ $k->kelas_tingkat }} - {{ $k->jurusan->kode_jurusan }} - {{ $k->jurusan->nama_jurusan }} - {{ $k->rombel }}
                                                                            </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="mapel_id{{ $x->id }}" class="form-label">Nama Mapel:</label>
                                                                        <select class="form-select" id="mapel_id{{ $x->id }}" name="mapel_id" required>
                                                                            <option value="">--Pilih Mapel--</option>
                                                                            @foreach($mapel as $m)
                                                                            <option value="{{ $m->id }}" {{ $x->mapel_id == $m->id ? 'selected' : '' }}>
                                                                                {{ $m->kode_mapel }} - {{ $m->nama_mapel }}
                                                                            </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="id_guru{{ $x->id }}" class="form-label">Tahun Ajaran:</label>
                                                                        <select class="form-select" id="id_guru{{ $x->id }}" name="id_guru" required>
                                                                            @foreach ($guru as $g)
                                                                                <option value="{{ $g->id }}" {{ $x->id_guru == $g->id ? 'selected' : '' }}>>{{ $g->username }}</option>
                                                                            @endforeach
                                                                            </option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                                    <button type="submit" class="btn btn-primary">Update</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>


                                                <!-- Button Delete -->
                                                <form action="{{ route('admin.pembelajaran.destroy', $x->id) }}" method="POST" class="delete-form" id="deleteForm{{ $x->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-danger btn-sm tombolHapus" data-id="{{ $x->id }}" title="Delete Pembelajaran">
                                                        <i class="bi bi-trash"></i>
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


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.tombolHapus').forEach(function(button) {
            button.addEventListener('click', function(event) {
                event.preventDefault();

                var form = button.closest('.delete-form');
                var wakelId = form.getAttribute('data-id');

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: 'Anda tidak akan dapat mengembalikan data ini!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(form.action, {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({ _method: 'DELETE' })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire(
                                    'Dihapus!',
                                    data.message,
                                    'success'
                                ).then(() => {
                                    window.location.reload();
                                });
                            } else {
                                Swal.fire(
                                    'Gagal!',
                                    data.error,
                                    'error'
                                );
                            }
                        })
                        .catch(() => {
                            Swal.fire(
                                'Gagal!',
                                'Terjadi kesalahan saat menghubungi server.',
                                'error'
                            );
                        });
                    }
                });
            });
        });
    });
</script>
@endsection




@push('scripts')
<script>
    $(document).ready(function() {
        $('#daftarpembelajaran').DataTable();
    });
</script>
@endpush