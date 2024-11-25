@extends('guru.layout.main')
@section('title', 'Hasil Nilai Kelas ' . $pembelajaran->kelas->kelas_tingkat . ' - ' . $pembelajaran->kelas->jurusan->kode_jurusan . ' - ' . $pembelajaran->kelas->rombel)
@section('content')

<div class="container-fluid py-0 mt-4">

    @if ($guru->isNotEmpty())
        @php
            $firstGuru = $guru->first();
            $mapelPertama = $firstGuru->mapel->nama_mapel;  // Mengambil nama mapel pertama yang diajar guru
        @endphp
        <p class="text-white">
            Selamat Datang {{ $firstGuru->guru->username }} sebagai guru Mata Pelajaran {{ $mapelPertama }}.
        </p>
    @else
        <p class="text-white">Anda tidak terdaftar sebagai guru dalam sistem.</p>
    @endif

    <a href="{{ route('guru.nilai.kelola', ['id_pembelajaran' => $pembelajaran->id]) }}" class="btn btn-secondary">Kembali</a>
    
    <div class="row">
        <div class="container-fluid py-4">
            <div class="card shadow-lg">
                <div class="card-body">
                    <h5 class="font-weight-bolder">
                        {{ $pembelajaran->kelas->kelas_tingkat ?? 'Kelas' }} -
                        {{ $pembelajaran->kelas->jurusan->kode_jurusan ?? 'Jurusan' }} -
                        {{ $pembelajaran->kelas->rombel ?? 'Rombel' }} / 
                        {{ $pembelajaran->mapel->nama_mapel }}
                    </h5>
                    <div class="table-responsive mt-3">
                        <table id="daftarnilai" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Siswa</th>
                                    <th>Mata Pelajaran</th>
                                    <th>UH 1</th>
                                    <th>UH 2</th>
                                    <th>UH 3</th>
                                    <th>UTS</th>
                                    <th>UAS</th>
                                    <th>Rata-Rata</th>
                                    <th>Predikat</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($kelolanilai as $mapel => $nilaiGroup)
                                    @foreach ($nilaiGroup as $n)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $n->siswa->nama_siswa ?? 'Nama Tidak Ditemukan' }}</td>
                                            <td>{{ $n->mapel->nama_mapel }}</td>
                                            <td class="text-center">{{ $n->uh1 }}</td>
                                            <td class="text-center">{{ $n->uh2 }}</td>
                                            <td class="text-center">{{ $n->uh3 }}</td>
                                            <td class="text-center">{{ $n->uts }}</td>
                                            <td class="text-center">{{ $n->uas }}</td>
                                            <td class="text-center">{{ $average = ($n->uh1 + $n->uh2 + $n->uh3 + $n->uts + $n->uas) / 5 }}</td>
                                            <td class="text-center">
                                                @if ($average >= 90)
                                                    A
                                                @elseif ($average >= 80)
                                                    B
                                                @elseif ($average >= 70)
                                                    C
                                                @else
                                                    D
                                                @endif
                                            </td>
                                            <td>
                                                <!-- Edit Button with Icon -->
                                                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal" data-id="{{ $n->id }}" data-nis="{{ $n->siswa->nis }}" data-nama_siswa="{{ $n->siswa->nama_siswa }}" data-uh1="{{ $n->uh1 }}" data-uh2="{{ $n->uh2 }}" data-uh3="{{ $n->uh3 }}" data-uts="{{ $n->uts }}" data-uas="{{ $n->uas }}" data-mapel_kode="{{ $n->mapel_kode }}" data-pembelajaran_id="{{ $n->pembelajaran_id }}" data-kelas_id="{{ $n->kelas_id }}" data-jurusan_id="{{ $n->jurusan_id }}" data-thajaran_id="{{ $n->thajaran_id }}" data-wakel_id="{{ $n->wakel_id }}">
                                                    <i class="bi bi-pencil"></i>
                                                </button>

                                                <!-- Delete Form with Icon -->
                                                <form action="{{ route('wakel.nilai.destroy', $n->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?');">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Nilai</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editForm" method="POST" action="{{ route('wakel.nilai.update', 0) }}">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" id="editId" name="id">
                    <input type="hidden" id="mapel_kode" name="mapel_kode">
                    <input type="hidden" id="pembelajaran_id" name="pembelajaran_id">
                    <input type="hidden" id="kelas_id" name="kelas_id">
                    <input type="hidden" id="jurusan_id" name="jurusan_id">
                    <input type="hidden" id="thajaran_id" name="thajaran_id">
                    <input type="hidden" id="wakel_id" name="wakel_id">
                    <div class="mb-3">
                        <label for="nis" class="form-label">NIS</label>
                        <input type="text" class="form-control" id="nis" name="nis" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="nama_siswa" class="form-label">Nama Siswa</label>
                        <input type="text" class="form-control" id="nama_siswa" name="nama_siswa" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="editUh1" class="form-label">UH 1:</label>
                        <input type="number" class="form-control" id="editUh1" name="uh1" min="0" max="100">
                    </div>
                    <div class="mb-3">
                        <label for="editUh2" class="form-label">UH 2:</label>
                        <input type="number" class="form-control" id="editUh2" name="uh2" min="0" max="100">
                    </div>
                    <div class="mb-3">
                        <label for="editUh3" class="form-label">UH 3:</label>
                        <input type="number" class="form-control" id="editUh3" name="uh3" min="0" max="100">
                    </div>
                    <div class="mb-3">
                        <label for="editUts" class="form-label">UTS:</label>
                        <input type="number" class="form-control" id="editUts" name="uts" min="0" max="100">
                    </div>
                    <div class="mb-3">
                        <label for="editUas" class="form-label">UAS:</label>
                        <input type="number" class="form-control" id="editUas" name="uas" min="0" max="100">
                    </div>
                    <div class="mb-3">
                        <label for="editRataRata" class="form-label">Rata-Rata:</label>
                        <input type="text" class="form-control" id="editRataRata" name="rata_rata" readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
    $('#daftarnilai').DataTable();

    $('#editModal').on('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var id = button.getAttribute('data-id');
        var nis = button.getAttribute('data-nis');
        var nama_siswa = button.getAttribute('data-nama_siswa');
        var uh1 = parseFloat(button.getAttribute('data-uh1')) || 0;
        var uh2 = parseFloat(button.getAttribute('data-uh2')) || 0;
        var uh3 = parseFloat(button.getAttribute('data-uh3')) || 0;
        var uts = parseFloat(button.getAttribute('data-uts')) || 0;
        var uas = parseFloat(button.getAttribute('data-uas')) || 0;
        var mapel_kode = button.getAttribute('data-mapel_kode');
        var pembelajaran_id = button.getAttribute('data-pembelajaran_id');
        var kelas_id = button.getAttribute('data-kelas_id');
        var jurusan_id = button.getAttribute('data-jurusan_id');
        var thajaran_id = button.getAttribute('data-thajaran_id');
        var wakel_id = button.getAttribute('data-wakel_id');

        document.getElementById('editId').value = id;
        document.getElementById('mapel_kode').value = mapel_kode;
        document.getElementById('pembelajaran_id').value = pembelajaran_id;
        document.getElementById('kelas_id').value = kelas_id;
        document.getElementById('jurusan_id').value = jurusan_id;
        document.getElementById('thajaran_id').value = thajaran_id;
        document.getElementById('wakel_id').value = wakel_id;
        document.getElementById('nis').value = nis;
        document.getElementById('nama_siswa').value = nama_siswa;
        document.getElementById('editUh1').value = uh1;
        document.getElementById('editUh2').value = uh2;
        document.getElementById('editUh3').value = uh3;
        document.getElementById('editUts').value = uts;
        document.getElementById('editUas').value = uas;

        var average = (uh1 + uh2 + uh3 + uts + uas) / 5;
        document.getElementById('editRataRata').value = average.toFixed(2);

        var formAction = "{{ route('wakel.nilai.update', '') }}/" + id;
        document.getElementById('editForm').action = formAction;
    });

    document.querySelectorAll('#editUh1, #editUh2, #editUh3, #editUts, #editUas').forEach(function(element) {
        element.addEventListener('input', function() {
            var uh1 = parseFloat(document.getElementById('editUh1').value) || 0;
            var uh2 = parseFloat(document.getElementById('editUh2').value) || 0;
            var uh3 = parseFloat(document.getElementById('editUh3').value) || 0;
            var uts = parseFloat(document.getElementById('editUts').value) || 0;
            var uas = parseFloat(document.getElementById('editUas').value) || 0;

            var average = (uh1 + uh2 + uh3 + uts + uas) / 5;
            document.getElementById('editRataRata').value = average.toFixed(2);
        });
    });
});

</script>
@endpush
@endsection
