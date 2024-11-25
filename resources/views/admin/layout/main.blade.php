<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="apple-touch-icon" sizes="76x76" href="/img/apple-icon.png">
    <link rel="icon" type="image/png" href="/img/logoskanda.webp">
    <title>DANDUK SKANDA</title>
    <!-- Fonts and icons -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ni-icons@1.0.0/css/ni-icons.min.css">
    <!-- Nucleo Icons -->
    <link href="{{ asset('/') }}css/nucleo-icons.css" rel="stylesheet" />
    <link href="{{ asset('/') }}css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    {{-- <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>  --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- CSS Files -->
    <link id="pagestyle" href="{{ asset('/') }}css/argon-dashboard.css?v=2.0.4" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.4.1/font/bootstrap-icons.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap4.min.css">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables JS -->
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
</head>

<body class="g-sidenav-show bg-gray-100">
    <div class="min-height-300 bg-primary position-absolute w-100"></div>

    @include('admin.layout.sidebar')

    <main class="main-content position-relative border-radius-lg">
        @include('admin.layout.navbar')

        @yield('content')

        @stack('scripts')

    </main>

    @include('sweetalert::alert')

    <!-- Core JS Files -->
    <script src="{{ asset('/') }}js/core/popper.min.js"></script>
    <script src="{{ asset('/') }}js/core/bootstrap.min.js"></script>
    <script src="{{ asset('/') }}js/plugins/perfect-scrollbar.min.js"></script>
    <script src="{{ asset('/') }}js/plugins/smooth-scrollbar.min.js"></script>

    <!-- Initialize DataTables -->
    <script>
        $(document).ready(function() {
            $('#daftarwakel, #daftarjurusan, #daftarthajaran, #daftarsiswa, #kelasx, #kelasxi, #kelasxii, #daftarmapel, #presensi, #daftarpembelajaran', '#daftarpresensi', '#daftarnilai').DataTable();
        });
    </script>

    <!-- SweetAlert Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <!-- Show Success Messages -->
    @if(session('suksestambah'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'Berhasil!',
                text: '{{ session("suksestambah") }}',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        });
    </script>
    @endif

    @if(session('suksesedit'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'Berhasil!',
                text: '{{ session("suksesedit") }}',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        });
    </script>
    @endif

    @if(session('sukseshapus'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'Berhasil!',
                text: '{{ session("sukseshapus") }}',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        });
    </script>
    @endif

    <!-- Show Error Messages -->
    @if($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'Gagal!',
                text: '{{ $errors->first() }}',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        });
    </script>
    @endif

</body>

</html>