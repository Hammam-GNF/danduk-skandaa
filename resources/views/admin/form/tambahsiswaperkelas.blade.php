@extends('admin.layout.main')
@section('title', 'Tambah Siswa')
@section('content')

<div class="container">
    <div class="card">
        <div class="card-header">
            <h5 class="font-weight-bold mb-0">TAMBAH SISWA KELAS {{ $kelas->kelas_tingkat }} - {{ $kelas->jurusan->kode_jurusan }} - {{ $kelas->rombel }}</h5>
        </div>
        <div class="card-body">
            <form method="post" action="{{ route('admin.siswaperkelas.store') }}">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="kelas_tingkat" class="mb-1">Nama Kelas</label>
                            <input type="text" class="form-control" id="kelas_tingkat" name="kelas_tingkat" value="{{ $kelas->kelas_tingkat }} - {{ $kelas->jurusan->kode_jurusan }} - {{ $kelas->rombel }}" readonly>
                            <input type="hidden" name="kelas_id" value="{{ $kelas->id }}">
                            <input type="hidden" name="thajaran_id" value="{{ $kelas->thajaran_id }}">
                            <input type="hidden" name="rombel" value="{{ $kelas->rombel }}">
                            <input type="hidden" name="wakel_id" value="{{ $kelas->wakel_id }}">
                        </div>
                        <div class="form-group">
                            <label for="nis" class="mb-1">NIS</label>
                            <input type="number" class="form-control" id="nis" name="nis" min="0" required>
                        </div>
                        <div class="form-group">
                            <label for="nama_siswa" class="mb-1">Nama Siswa</label>
                            <input type="text" class="form-control" id="nama_siswa" name="nama_siswa" required>
                        </div>
                        <div class="form-group">
                            <label for="jns_kelamin" class="mb-1">Jenis Kelamin</label>
                            <select class="form-control" id="jns_kelamin" name="jns_kelamin" required>
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="status" class="mb-1">Status Siswa:</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="status_aktif" name="status" value="Aktif" required>
                                <label class="form-check-label" for="status_aktif">Aktif</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="status_nonaktif" name="status" value="NonAktif" required>
                                <label class="form-check-label" for="status_nonaktif">Nonaktif</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nama_ortu" class="mb-1">Nama Orang Tua</label>
                            <input type="text" class="form-control" id="nama_ortu" name="nama_ortu" placeholder="(tidak wajib diisi)">
                        </div>
                        <div class="form-group">
                            <label for="nohp_ortu" class="mb-1">No HP Orang Tua</label>
                            <input type="number" class="form-control" id="nohp_ortu" name="nohp_ortu" placeholder="(tidak wajib diisi)">
                        </div>
                        <div class="form-group">
                            <label for="alamat" class="mb-1">Alamat</label>
                            <textarea class="form-control" id="alamat" name="alamat" placeholder="(tidak wajib diisi)" rows="3"></textarea>
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
