<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4" id="sidenav-main">
    <div class="sidenav-header" style="position: relative; background-color: #fff; border-bottom: 1px solid #dee2e6;">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="{{ route('wakel.dashboard') }}" style="display: flex; align-items: center; text-decoration: none;">
            <img src="/img/logoskanda.webp" class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-1 font-weight-bold">DATA INDUK SKANDA</span>
        </a>
    </div>

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

                <li class="nav-item" style="margin-bottom: 0.5rem;">
                    <a class="nav-link d-flex align-items-center" href="{{ route('wakel.mengajar', ['roleId' => auth()->user()->role_id]) }}" style="display: flex; align-items: center; text-decoration: none; color: #000;">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2" style="border-radius: 0.375rem; width: 2rem; height: 2rem; background-color: #e9ecef;">
                            <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text">Daftar Mengajar</span>
                    </a>
                </li>

                <li class="nav-item has-submenu">
                    <a class="nav-link d-flex align-items-center" href="#">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2">
                            <i class="ni ni-paper-diploma text-warning text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text">Data Kelas</span>
                    </a>
                    <ul class="submenu collapse ms-3">
                        <li><a class="nav-link" href="{{ route('wakel.pengelolaanpresensi', ['roleId' => auth()->user()->role_id]) }}">Data Presensi</a></li>
                        <li><a class="nav-link" href="{{ route('wakel.pengelolaannilai', ['roleId' => auth()->user()->role_id]) }}">Data Nilai</a></li>
                    </ul>
                </li>

            </ul>
        </nav>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll('.sidebar .nav-link').forEach(function(element) {
                element.addEventListener('click', function(e) {
                    let nextEl = element.nextElementSibling;
                    let parentEl = element.parentElement;

                    if (nextEl && nextEl.classList.contains('submenu')) {
                        e.preventDefault();
                        let mycollapse = new bootstrap.Collapse(nextEl, {
                            toggle: true
                        });

                        if (nextEl.classList.contains('show')) {
                            mycollapse.hide();
                        } else {
                            mycollapse.show();
                            // Tutup submenu lain yang terbuka
                            var opened_submenu = parentEl.parentElement.querySelector('.submenu.show');
                            if (opened_submenu && opened_submenu !== nextEl) {
                                new bootstrap.Collapse(opened_submenu).hide();
                            }
                        }
                    }
                });
            });
        });
    </script>

</aside>
