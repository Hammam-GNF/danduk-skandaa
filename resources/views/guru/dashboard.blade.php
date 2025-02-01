@extends('guru.layout.main')

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

    <script src="{{ asset('/') }}js/plugins/chartjs.min.js"></script>

    <div class="container-fluid py-0">
        @if ($guru->isNotEmpty())
            @php
                $firstGuru = $guru->first();
                $mapelPertama = $firstGuru->mapel->nama_mapel;
            @endphp
            <p class="text-white">
                Selamat Datang {{ $firstGuru->guru->username }} sebagai guru Mata Pelajaran {{ $mapelPertama }}.
            </p>

            @if ($guru->pluck('kelas')->isNotEmpty())
                <div class="row mt-3">
                    <div class="col-lg-12 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Kelas yang Diajar</h5>
                                <ul class="card-text">
                                    @foreach ($guru as $user)
                                        @if ($user->kelas)
                                            <li>{{ $user->kelas->kelas_tingkat }} - {{ $user->kelas->jurusan->kode_jurusan }} - {{ $user->kelas->rombel }}</li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <p class="text-white">
                    Anda belum memiliki kelas atau kelas ini tidak memiliki siswa.
                </p>
            @endif
        @else
            <p class="text-white">Anda tidak terdaftar sebagai guru dalam sistem.</p>
        @endif
    </div>



    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>
    <script async defer src="https://buttons.github.io/buttons.js"></script>
@endsection
