@extends('admin.layout.main')
@section('title', 'Daftar Kelas')
@section('content')

    <div class="container-fluid py-0 mt-4">

    <!-- Button trigger modal -->
    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#tambahkelasModal">
        <i class="bi bi-plus-square"></i> Kelas
    </button>

    <!-- Modal Tambah Kelas -->
    <form method="POST" action="{{ route('admin.kelas.store') }}">
        @csrf
        <div class="modal fade" id="tambahkelasModal" tabindex="-1" aria-labelledby="tambahkelasLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahkelasLabel">Tambah Kelas
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="jurusan_id"
                                class="form-label">Jurusan:</label>
                            <select class="form-control" id="jurusan_id" name="jurusan_id" required>
                                <option value="">--Pilih Jurusan--</option>
                                @foreach ($jurusan as $j)
                                    <option value="{{ $j->id }}">
                                        {{ $j->kode_jurusan }} - {{ $j->nama_jurusan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="kelas_tingkat" class="form-label">Kelas Tingkat:</label>
                            <select class="form-control" id="kelas_tingkat" name="kelas_tingkat" required>
                                <option value="">--Pilih Kelas Tingkat--</option>
                                <option value="X">X</option>
                                <option value="XI">XI</option>
                                <option value="XII">XII</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="rombel" class="form-label">Rombongan Belajar ke:</label>
                            <input type="number" class="form-control" id="rombel" name="rombel" placeholder="Contoh: 1, 2, 3" min="1" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">Close</button>
                        <button type="submit"
                            class="btn btn-success">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div class="row mt-3">
        <div class="container-fluid py-4">

            <div class="card shadow-lg">
                <div class="card-body">
                    <h5 class="font-weight-bolder">DAFTAR KELAS</h5>
                    <div class="table-responsive mt-3">
                        <table class="table table-striped table-bordered" id="daftarkelas">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Nama Kelas</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kelas->whereIn('kelas_tingkat', ['X', 'XI', 'XII']) as $x)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}
                                        </td>
                                        <td>{{ $x->kelas_tingkat }} -
                                            {{ $x->jurusan->kode_jurusan }} -
                                            {{ $x->rombel }} ({{ $x->jurusan->nama_jurusan }} )</td>
                                        <td class="align-middle-center" style="display: flex; align-items: center; justify-content: center;">
                                            <a href="{{ route('admin.siswaperkelas.index', ['id' => $x->id]) }}" class="btn btn-info btn-sm me-2" title="Detail"><i class="bi bi-eye"></i></a>

                                            <button type="button" class="btn btn-primary btn-sm me-2" title="Edit" data-bs-toggle="modal" data-bs-target="#editkelas{{ $x->id }}"><i class="bi bi-pencil"></i></button>

                                            <!-- Modal Edit Kelas -->
                                                @foreach ($kelas as $x)
                                                    <form method="POST" action="{{ route('admin.kelas.update', $x->id) }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal fade" id="editkelas{{ $x->id }}" tabindex="-1" aria-labelledby="editkelasLabel{{ $x->id }}" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="editkelasLabel{{ $x->id }}">Edit Kelas </h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="mb-3">
                                                                            <label for="edit_jurusan_id" class="form-label">Jurusan:</label>
                                                                            <select class="form-control" id="edit_jurusan_id" name="jurusan_id" required>
                                                                                <option value="">--Pilih Jurusan--</option>
                                                                                @foreach ($jurusan as $j)
                                                                                <option value="{{ $j->id }}" {{ $j->id == $x->jurusan_id ? 'selected' : '' }}>
                                                                                    {{ $j->nama_jurusan }}
                                                                                </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="edit_kelas_tingkat{{ $x->id }}" class="form-label">Kelas Tingkat:</label>
                                                                            <select class="form-control" id="edit_kelas_tingkat{{ $x->id }}" name="kelas_tingkat" required>
                                                                                <option value="">--Pilih Kelas Tingkat--</option>
                                                                                <option value="X"
                                                                                    @if ($x->kelas_tingkat == 'X') selected @endif> X</option>
                                                                                <option value="XI"
                                                                                    @if ($x->kelas_tingkat == 'XI') selected @endif> XI</option>
                                                                                <option value="XII"
                                                                                    @if ($x->kelas_tingkat == 'XII') selected @endif> XII</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="edit_rombel{{ $x->id }}" class="form-label">Rombongan Belajar ke:</label>
                                                                            <input type="number" class="form-control" id="edit_rombel{{ $x->id }}" name="rombel" value="{{ $x->rombel }}" min="1" required>
                                                                        </div>
                                                                        <div class="mb-3 form-check">
                                                                            <input type="checkbox" class="form-check-input" id="checkEditConfirmation{{ $x->id }}" required>
                                                                            <label class="form-check-label" for="checkEditConfirmation{{ $x->id }}">Saya telah memeriksa dan mengonfirmasi perubahan ini.</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-bs-dismiss="modal">Close</button>
                                                                        <button type="submit"
                                                                            class="btn btn-success">Simpan</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                @endforeach

                                            <form action="{{ route('admin.kelas.destroy', $x->id) }}" method="POST" class="delete-form" id="deleteForm{{ $x->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger btn-sm deleteButton" data-id="{{ $x->id }}" data-kelas_tingkat="{{ $x->kelas_tingkat }}" data-jurusan_id="{{ $x->jurusan_id }}" data-rombel="{{ $x->rombel }}" title="Hapus">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
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
            document.querySelectorAll('.deleteButton').forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Data Kelas ini akan dihapus!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById('deleteForm' + id).submit();
                        }
                    });
                });
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const thajaranSelects = document.querySelectorAll('.thajaran-select');

            thajaranSelects.forEach(select => {
                select.addEventListener('change', function() {
                    const thajaranId = this.value;
                    const modalId = this.id.replace('thajaran', '');
                    const jurusanSelect = document.querySelector(`#jurusan_id${modalId}`);
                    // const wakelSelect = document.querySelector(`#wakel_id${modalId}`);

                    if (thajaranId) {
                        // Fetch Jurusan data
                        fetch(`/admin/datamaster/kelas/jurusan/${thajaranId}`)
                            .then(response => response.json())
                            .then(data => {
                                let options = '<option value="">--Pilih Jurusan--</option>';
                                data.jurusan.forEach(jurusan => {
                                    options +=
                                        `<option value="${jurusan.id}" ${jurusan.id == jurusanSelect.dataset.selected ? 'selected' : ''}>${jurusan.kode_jurusan} - ${jurusan.nama_jurusan}</option>`;
                                });
                                jurusanSelect.innerHTML = options;
                            })
                            .catch(error => console.error('Error fetching jurusan data:', error));

                        // Fetch Wakel data
                        fetch(`/admin/datamaster/kelas/wakel/${thajaranId}`)
                            .then(response => response.json())
                            .then(data => {
                                let options = '<option value="">--Pilih Wali Kelas--</option>';
                                data.wakel.forEach(wakel => {
                                    options +=
                                        `<option value="${wakel.id}" ${wakel.id == wakelSelect.dataset.selected ? 'selected' : ''}>${wakel.nama_wakel}</option>`;
                                });
                                wakelSelect.innerHTML = options;
                            })
                            .catch(error => console.error('Error fetching wakel data:', error));
                    } else {
                        // Clear Jurusan and Wakel if no thajaran_id selected
                        jurusanSelect.innerHTML = '<option value="">--Pilih Jurusan--</option>';
                        wakelSelect.innerHTML = '<option value="">--Pilih Wali Kelas--</option>';
                    }
                });

                // Trigger change event on page load to set initial values
                const initialThajaranId = select.value;
                if (initialThajaranId) {
                    select.dispatchEvent(new Event('change'));
                }
            });
        });
    </script>
@endsection
@push('scripts')
<script>
    $(document).ready(function() {
        $('#daftarkelas').DataTable();
    });
</script>
@endpush