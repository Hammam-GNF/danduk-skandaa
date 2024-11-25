@extends('wakel.layout.main')

@section('title', 'DASHBOARD')

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (session('message'))
        <script>
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 1000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });
            Toast.fire({
                icon: "success",
                title: "{{ session('message') }}"
            });
        </script>
    @endif

    <div class="container-fluid py-0">
        @if ($wakels->isNotEmpty())
            @foreach ($wakels as $wakel)
                @if ($wakel->kelas && $wakel->kelas->siswa->isNotEmpty())
                    <p class="text-white">
                        Selamat Datang {{ $wakel->user->username }} sebagai {{ $wakel->user->role->level }} di 
                        {{ $wakel->kelas->kelas_tingkat }} - {{ $wakel->kelas->jurusan->kode_jurusan }} - {{ $wakel->kelas->rombel }}.
                    </p>
                @else
                    <p class="text-white">
                        Selamat Datang {{ $wakel->user->username }} sebagai {{ $wakel->user->role->level }}, anda belum memiliki kelas atau kelas ini tidak memiliki siswa.
                    </p>
                @endif
            @endforeach
        @else
            <p class="text-white">Anda tidak memiliki Wali Kelas yang terdaftar.</p>
        @endif

        @if ($jumlahSiswa > 0)
    <div class="row mt-3">
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Jumlah Total Siswa yang diampu</h5>
                    <p class="card-text">{{ $jumlahSiswa }}</p>
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Kelas yang Diajar</h5>
                    <ul class="card-text">
                        @foreach ($wakels as $user)
                            @if ($user->kelas)
                                <li>{{ $user->kelas->kelas_tingkat }} - {{ $user->kelas->jurusan->kode_jurusan }} - {{ $user->kelas->rombel }}</li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endif


@endsection
