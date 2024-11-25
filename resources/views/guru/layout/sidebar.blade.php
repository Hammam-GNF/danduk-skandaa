<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4" id="sidenav-main">
    <div class="sidenav-header" style="position: relative; background-color: #fff; border-bottom: 1px solid #dee2e6;">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="{{ route('wakel.dashboard') }}" style="display: flex; align-items: center; text-decoration: none;">
            <img src="/img/logoskanda.webp" class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-1 font-weight-bold">DATA INDUK SKANDA</span>
        </a>
    </div>

    <hr class="horizontal dark mt-1 mb-1" style="border-color: #343a40;">

    <div class="ps ps--active-y" id="sidenav-main" style="overflow-y: auto;">
        <nav class="sidebar card py-2 mb-4" style="padding: 0.5rem;">
            <ul class="nav flex-column" id="nav_accordion" style="list-style: none; padding-left: 0;">
                <li class="nav-item" style="margin-bottom: 0.5rem;">
                    <a class="nav-link d-flex align-items-center" href="{{ route('wakel.dashboard') }}" style="display: flex; align-items: center; text-decoration: none; color: #000;">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2" style="border-radius: 0.375rem; width: 2rem; height: 2rem; background-color: #e9ecef;">
                            <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text">Dashboard</span>
                    </a>
                </li>

                <hr class="horizontal dark mt-1 mb-1" style="border-color: #343a40;">

                <li class="nav-item" style="margin-bottom: 0.5rem;">
                    <a class="nav-link d-flex align-items-center" href="{{ route('guru.mengajar', ['roleId' => auth()->user()->role_id]) }}" style="display: flex; align-items: center; text-decoration: none; color: #000;">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2" style="border-radius: 0.375rem; width: 2rem; height: 2rem; background-color: #e9ecef;">
                            <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text">Daftar Mengajar</span>
                    </a>
                </li>

                <hr class="horizontal dark mt-1 mb-1" style="border-color: #343a40;">
            </ul>
        </nav>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var currentPage = window.location.pathname.split("/").pop(); // Mendapatkan bagian terakhir dari URL sebagai nama halaman

            // Loop melalui semua item navigasi
            var navItems = document.querySelectorAll(".navbar-nav .nav-item");
            navItems.forEach(function(item) {
                var navLink = item.querySelector(".nav-link");
                var linkHref = navLink.getAttribute("href").split("/").pop(); // Mendapatkan bagian terakhir dari URL href

                // Periksa apakah nama halaman sama dengan bagian terakhir dari URL href
                if (currentPage === linkHref) {
                    navLink.classList.add("active"); // Tambahkan kelas active ke item navigasi
                }
            });
        });
    </script>
</aside>
