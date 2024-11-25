@extends('admin.layout.main')

@section('title', 'DASHBOARD')

@push('scripts')
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

    <script>
        var ctx = document.getElementById('chart-bar').getContext('2d');
        var dataLakiLaki = [50, 60, 55, 70, 65, 80];
        var dataPerempuan = [40, 45, 50, 55, 60, 70];
        var tahun = ['2019', '2020', '2021', '2022', '2023', '2024'];

        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: tahun,
                datasets: [{
                    label: 'Laki-laki',
                    data: dataLakiLaki,
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }, {
                    label: 'Perempuan',
                    data: dataPerempuan,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

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
    <script src="/js/argon-dashboard.min.js?v=2.0.4"></script>
@endpush

@section('content')
    <div class="container-fluid py-0">
        @if (Auth::user()->role)
            <p class="text-white">Selamat Datang {{ Auth::user()->username }} sebagai {{ Auth::user()->role->level }}</p>
        @else
            <p class="text-white">Selamat Datang {{ Auth::user()->username }}</p>
        @endif

        <div class="row mt-3">
            <div class="col-lg-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Jumlah Pengguna</h5>
                        <p class="card-text">{{ $jumlahPengguna }} (tidak termasuk admin)</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Tahun Ajaran Aktif</h5>
                        <p class="card-text">{{ $tahunAjaranAktif ? $tahunAjaranAktif->thajaran . ' - ' . $tahunAjaranAktif->semester : 'Tidak ada tahun ajaran aktif' }}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Jumlah Jurusan</h5>
                        <p class="card-text">{{ $jumlahJurusan }}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Jumlah Mata Pelajaran</h5>
                        <p class="card-text">{{ $jumlahMapel }}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Jumlah Kelas</h5>
                        <p class="card-text">{{ $jumlahKelas }}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Jumlah Siswa</h5>
                        <p class="card-text">{{ $jumlahSiswa }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- <div class="row mt-3">
            <div class="col-lg-7 mb-lg-0 mb-4">
                <div class="card z-index-2 h-100" style="box-shadow: 0px 0px 10px 7px rgb(226, 16, 62);">
                    <div class="card-header pb-0 pt-3 bg-transparent">
                        <h6 class="text-capitalize">Statistik Siswa</h6>
                        <p class="mb-0">
                            Grafik Perbandingan Jumlah Siswa Laki-laki dan Perempuan dari Tahun 2019 hingga 2024.
                        </p>
                    </div>
                    <div class="card-body p-3">
                        <div class="chart">
                            <canvas id="chart-bar" class="chart-canvas" height="300"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="card h-100" style="box-shadow: 0px 0px 10px 7px rgb(226, 16, 62);">
                    <div class="card-header pb-0 pt-3 bg-transparent">
                        <h6 class="text-capitalize">Informasi Sekolah</h6>
                        <p class="mb-0">
                            Data singkat mengenai jumlah siswa, kelas, dan jurusan di sekolah.
                        </p>
                    </div>
                    <div class="card-body p-3">
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Total Siswa
                                <span class="badge bg-primary rounded-pill">{{ $jumlahSiswa }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Total Kelas
                                <span class="badge bg-primary rounded-pill">{{ $jumlahKelas }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Total Jurusan
                                <span class="badge bg-primary rounded-pill">{{ $jumlahJurusan }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Total Wali Kelas
                                <span class="badge bg-primary rounded-pill">{{ $jumlahPengguna }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Total Tahun Ajaran
                                <span class="badge bg-primary rounded-pill">{{ $tahunAjaranAktif }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Total Admin
                                <span class="badge bg-primary rounded-pill">2</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div> -->

    </div>
@endsection
