@extends('admin.layout.main')
@section('title', 'Tambah Siswa')
@section('content')

<div class="container">
    <div class="card">
        <div class="card-header">
            <h5 class="font-weight-bold mb-0">TAMBAH SISWA</h5>
        </div>
        <div class="card-body">
            <form method="post" action="{{ route('admin.siswa.store') }}">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="kelas_id" class="form-label">Nama Kelas:</label>
                            <select class="form-control" id="kelas_id" name="kelas_id" required>
                                <option value="">---Pilih Kelas---</option>
                                @foreach($kelas as $k)
                                    <option value="{{ $k->id }}">{{ $k->kelas_tingkat }} - {{ $k->jurusan->kode_jurusan }} - {{ $k->rombel }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="wakel_display" class="form-label">Wali Kelas:</label>
                            <input type="text" class="form-control" id="wakel_display" name="wakel_display" readonly>
                            <input type="hidden" id="wakel_id" name="wakel_id">
                        </div>
                        <div class="form-group">
                            <label for="nis" class="form-label">NIS:</label>
                            <input type="number" class="form-control" id="nis" name="nis" min="0" required>
                        </div>
                        <div class="form-group">
                            <label for="nama_siswa" class="form-label">Nama Siswa:</label>
                            <input type="text" class="form-control" id="nama_siswa" name="nama_siswa" required>
                        </div>
                        <div class="form-group">
                            <label for="jns_kelamin" class="form-label">Jenis Kelamin:</label>
                            <select class="form-control" id="jns_kelamin" name="jns_kelamin" required>
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Status Siswa:</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="status_aktif" name="status" value="Aktif" required>
                                <label class="form-check-label" for="status_aktif">Aktif</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="status_nonaktif" name="status" value="Nonaktif" required>
                                <label class="form-check-label" for="status_nonaktif">Nonaktif</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <!-- Remove the following inputs if not used -->
                        <div class="form-group">
                            <label for="nama_ortu" class="form-label">Nama Orang Tua:</label>
                            <input type="text" class="form-control" id="nama_ortu" name="nama_ortu" placeholder="(tidak wajib diisi)">
                        </div>
                        <div class="form-group">
                            <label for="nohp_ortu" class="form-label">No HP Orang Tua:</label>
                            <input type="number" class="form-control" id="nohp_ortu" name="nohp_ortu" placeholder="(tidak wajib diisi)">
                        </div>
                        <div class="form-group">
                            <label for="alamat" class="form-label">Alamat:</label>
                            <textarea class="form-control" id="alamat" name="alamat" placeholder="(tidak wajib diisi)" rows="3"></textarea>
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
        document.getElementById('kelas_id').addEventListener('change', function() {
            var kelas_id = this.value;
            var wakelDisplay = document.getElementById('wakel_display');
            var wakelInput = document.getElementById('wakel_id');

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
                            console.error('Data wakel tidak ditemukan.');
                        }
                    })
                    .catch(error => console.error('Error fetching wakel:', error));
            }
        });
    });
</script>

@endsection
