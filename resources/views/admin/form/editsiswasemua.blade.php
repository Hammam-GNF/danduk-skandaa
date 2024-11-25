@extends('admin.layout.main')
@section('title', 'Edit Siswa')
@section('content')

<div class="container">
    <div class="card">
        <div class="card-header">
            <h5 class="font-weight-bold mb-0">EDIT SISWA</h5>
        </div>
        <div class="card-body">
            <form method="post" action="{{ route('admin.siswa.update', $siswa->nis) }}">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="kelas_id" class="form-label">Nama Kelas:</label>
                            <select class="form-control" id="kelas_id" name="kelas_id" required>
                                <option value="">---Pilih Kelas---</option>
                                @foreach ($kelas as $k)
                                    <option value="{{ $k->id }}" {{ $siswa->kelas_id == $k->id ? 'selected' : '' }}>
                                        {{ $k->kelas_tingkat }} - {{ $k->jurusan->kode_jurusan }} - {{ $k->rombel }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="wakel_display" class="form-label">Wali Kelas:</label>
                            <input type="text" class="form-control" id="wakel_display" name="wakel_display" readonly value="{{ $siswa->wakel->user->username ?? '' }}">
                            <input type="hidden" id="wakel_id" name="wakel_id" value="{{ $siswa->wakel_id }}">
                        </div>
                        <div class="form-group">
                            <label for="nis" class="form-label">NIS:</label>
                            <input type="text" class="form-control" id="nis" name="nis" value="{{ $siswa->nis }}">
                        </div>
                        <div class="form-group">
                            <label for="nama_siswa" class="form-label">Nama Siswa:</label>
                            <input type="text" class="form-control" id="nama_siswa" name="nama_siswa" value="{{ $siswa->nama_siswa }}" required>
                        </div>
                        <div class="form-group">
                            <label for="jns_kelamin" class="form-label">Jenis Kelamin:</label>
                            <select class="form-control" id="jns_kelamin" name="jns_kelamin" required>
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="L" {{ $siswa->jns_kelamin == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ $siswa->jns_kelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Status Siswa:</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="status_aktif" name="status" value="Aktif" {{ $siswa->status == 'Aktif' ? 'checked' : '' }} required>
                                <label class="form-check-label" for="status_aktif">Aktif</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="status_nonaktif" name="status" value="Nonaktif" {{ $siswa->status == 'Nonaktif' ? 'checked' : '' }} required>
                                <label class="form-check-label" for="status_nonaktif">Nonaktif</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nama_ortu" class="form-label">Nama Orang Tua:</label>
                            <input type="text" class="form-control" id="nama_ortu" name="nama_ortu" value="{{ $siswa->nama_ortu }}" placeholder="(tidak wajib diisi)">
                        </div>
                        <div class="form-group">
                            <label for="nohp_ortu" class="form-label">No HP Orang Tua:</label>
                            <input type="number" class="form-control" id="nohp_ortu" name="nohp_ortu" value="{{ $siswa->nohp_ortu }}" placeholder="(tidak wajib diisi)">
                        </div>
                        <div class="form-group">
                            <label for="alamat" class="form-label">Alamat:</label>
                            <textarea class="form-control" id="alamat" name="alamat" placeholder="(tidak wajib diisi)" rows="3">{{ $siswa->alamat }}</textarea>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
            <a href="{{ route('admin.siswa.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var kelasSelect = document.getElementById('kelas_id');
        var wakelDisplay = document.getElementById('wakel_display');
        var wakelInput = document.getElementById('wakel_id');

        // Set up event listener for Kelas change
        kelasSelect.addEventListener('change', function() {
            var kelas_id = this.value;
            wakelDisplay.value = '';
            wakelInput.value = '';

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
                            wakelDisplay.value = data.wakel.user.username;
                            wakelInput.value = data.wakel.id;
                        } else {
                            console.error('Data wali kelas tidak ditemukan.');
                        }
                    })
                    .catch(error => console.error('Error fetching wali kelas:', error));
            }
        });
    });
</script>

@endsection
