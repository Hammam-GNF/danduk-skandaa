@extends('admin.layout.main')
@section('title', 'Edit Siswa')
@section('content')

<div class="container">
    <div class="card">
        <div class="card-header">
            <h5 class="font-weight-bold">EDIT SISWA KELAS {{ $kelas->kelas_tingkat }} - {{ $kelas->jurusan->kode_jurusan }} - {{ $kelas->rombel }}</h5>
        </div>
        <div class="card-body">
            <form method="post" action="{{ route('admin.siswaperkelas.update', ['nis' => $siswa->nis]) }}">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="kelas_tingkat" class="mb-1">Nama Kelas</label>
                            <input type="text" class="form-control" id="kelas_tingkat" name="kelas_tingkat" value="{{ $kelas->kelas_tingkat }} - {{ $kelas->jurusan->kode_jurusan }} - {{ $kelas->rombel }}" readonly>
                            <input type="hidden" name="kelas_id" value="{{ $siswa->kelas_id }}">
                            <input type="hidden" name="jurusan_id" value="{{ $kelas->jurusan_id }}">
                            <input type="hidden" name="rombel" value="{{ $kelas->rombel }}">
                            <input type="hidden" name="wakel_id" value="{{ $kelas->wakel_id }}">
                        </div>
                        <div class="form-group">
                            <label for="nis" class="mb-1">NIS</label>
                            <input type="text" class="form-control" id="nis" name="nis" value="{{ old('nis', $siswa->nis) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="nama_siswa" class="mb-1">Nama Siswa</label>
                            <input type="text" class="form-control" id="nama_siswa" name="nama_siswa" value="{{ old('nama_siswa', $siswa->nama_siswa) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="jns_kelamin" class="mb-1">Jenis Kelamin</label>
                            <select class="form-control" id="jns_kelamin" name="jns_kelamin" required>
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="Laki-laki" {{ old('jns_kelamin', $siswa->jns_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ old('jns_kelamin', $siswa->jns_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="status" class="mb-1">Status Siswa:</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="status_aktif" name="status" value="Aktif" {{ old('status', $siswa->status) == 'Aktif' ? 'checked' : '' }} required>
                                <label class="form-check-label" for="status_aktif">Aktif</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="status_nonaktif" name="status" value="Nonaktif" {{ old('status', $siswa->status) == 'Nonaktif' ? 'checked' : '' }} required>
                                <label class="form-check-label" for="status_nonaktif">Nonaktif</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nama_ortu" class="mb-1">Nama Orang Tua</label>
                            <input type="text" class="form-control" id="nama_ortu" name="nama_ortu" value="{{ old('nama_ortu', $siswa->nama_ortu) }}" placeholder="(tidak wajib diisi)">
                        </div>
                        <div class="form-group">
                            <label for="nohp_ortu" class="mb-1">No HP Orang Tua</label>
                            <input type="number" class="form-control" id="nohp_ortu" name="nohp_ortu" value="{{ old('nohp_ortu', $siswa->nohp_ortu) }}" placeholder="(tidak wajib diisi)">
                        </div>
                        <div class="form-group">
                            <label for="alamat" class="mb-1">Alamat</label>
                            <textarea class="form-control" id="alamat" name="alamat" placeholder="(tidak wajib diisi)" rows="3">{{ old('alamat', $siswa->alamat) }}</textarea>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
            <a href="{{ route('admin.siswaperkelas.index', ['id' => $kelas->id]) }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>

@endsection
