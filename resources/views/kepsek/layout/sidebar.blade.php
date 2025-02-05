<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4"
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="{{ route('kepsek.dashboard') }}">
            <img src="/img/logoskanda.webp" class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-1 font-weight-bold">DATA INDUK SKANDA</span>
        </a>
    </div>

    <hr class="horizontal dark mt-1 mb-1">

    <div class="ps ps--active-y" id="sidenav-main">
        <nav class="sidebar card py-2 mb-4">
            <ul class="nav flex-column" id="nav_accordion">
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center" href="{{ route('kepsek.dashboard') }}">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2">
                            <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text">Dashboard</span>
                    </a>
                </li>

                <hr class="horizontal dark mt-1 mb-1">

                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center" href="{{ route('kepsek.pengguna.index') }}">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2">
                            <i class="ni ni-circle-08 text-primary text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text">Daftar Pengguna</span>
                    </a>
                </li>

                <hr class="horizontal dark mt-1 mb-1">

                <li class="nav-item has-submenu">
                    <a class="nav-link d-flex align-items-center" href="#">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2">
                            <i class="ni ni-world text-danger text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text">Administrasi</span>
                    </a>
                    <ul class="submenu collapse ms-3">
                        <li><a class="nav-link" href="{{ route('kepsek.thajaran.index') }}">Data Tahun Ajaran</a></li>
                        <li><a class="nav-link" href="{{ route('kepsek.jurusan.index') }}">Data Jurusan</a></li>
                        <li><a class="nav-link" href="{{ route('kepsek.mapel.index') }}">Data Mapel</a></li>
                    </ul>
                </li>

                <hr class="horizontal dark mt-1 mb-1">

                <li class="nav-item has-submenu">
                    <a class="nav-link d-flex align-items-center" href="#">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2">
                            <i class="ni ni-paper-diploma text-warning text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text">Data Master</span>
                    </a>
                    <ul class="submenu collapse ms-3">
                        <li><a class="nav-link" href="{{ route('kepsek.kelas.index') }}">Data Kelas</a></li>
                        <li><a class="nav-link" href="{{ route('kepsek.wakel.index') }}">Data Wali Kelas</a></li>
                        <li><a class="nav-link" href="{{ route('kepsek.siswa.index') }}">Data Siswa</a></li>
                        <li><a class="nav-link" href="{{ route('kepsek.pembelajaran.index') }}">Data Pembelajaran</a></li>
                    </ul>
                </li>

                <hr class="horizontal dark mt-1 mb-1">

                <li class="nav-item has-submenu">
                    <a class="nav-link d-flex align-items-center" href="{{ route('kepsek.result.index') }}">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2">
                            <i class="ni ni-paper-diploma text-warning text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text">Result</span>
                    </a>
                </li>


                <hr class="horizontal dark mt-1 mb-1">

            </ul>
        </nav>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var currentPage = window.location.pathname.split("/")
        .pop(); // Mendapatkan bagian terakhir dari URL sebagai nama halaman

            // Loop melalui semua item navigasi
            var navItems = document.querySelectorAll(".navbar-nav .nav-item");
            navItems.forEach(function(item) {
                var navLink = item.querySelector(".nav-link");
                var linkHref = navLink.getAttribute("href").split("/")
            .pop(); // Mendapatkan bagian terakhir dari URL href

                // Periksa apakah nama halaman sama dengan bagian terakhir dari URL href
                if (currentPage === linkHref) {
                    navLink.classList.add("active"); // Tambahkan kelas active ke item navigasi
                }
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll('.sidebar .nav-link').forEach(function(element) {
                element.addEventListener('click', function(e) {
                    let nextEl = element.nextElementSibling;
                    let parentEl = element.parentElement;

                    if (nextEl) {
                        e.preventDefault();
                        let mycollapse = new bootstrap.Collapse(nextEl);

                        if (nextEl.classList.contains('show')) {
                            mycollapse.hide();
                        } else {
                            mycollapse.show();
                            // find other submenus with class=show
                            var opened_submenu = parentEl.parentElement.querySelector(
                                '.submenu.show');
                            // if it exists, then close all of them
                            if (opened_submenu) {
                                new bootstrap.Collapse(opened_submenu);
                            }
                        }
                    }
                }); // addEventListener
            }) // forEach
        });
    </script>
</aside>
