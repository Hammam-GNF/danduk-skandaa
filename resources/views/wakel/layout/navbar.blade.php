<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur"
    data-scroll="false">
    <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="guru">@yield('title')</a>
                </li>
            </ol>
            <h6 class="font-weight-bolder text-white mb-0 mt-3">@yield('title')</h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                <div class="input-group">
                    <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
                    <input type="text" class="form-control" placeholder="Type here...">
                </div>
            </div>
            <ul class="navbar-nav justify-content-end">
                <li class="nav-item dropdown">
                    <a class="nav-link text-white font-weight-bold px-0 dropdown-toggle" href="#"
                        id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-user me-sm-1"></i>
                        <span class="d-sm-inline d-none">{{ Auth::user()->role->level }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
                        <li>
                            <a class="dropdown-item border-radius-md" href="javascript:;">
                                <div class="d-flex py-0">
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="text-sm font-weight-normal mb-2">
                                            <span class="font-weight-bold">Edit Profile</span>
                                        </h6>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <form id="logout-form" action="{{ route('actionLogout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item border-radius-md">
                                    <div class="d-flex py-0">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="text-sm font-weight-normal mb-2">
                                                <span class="font-weight-bold">Logout</span>
                                            </h6>
                                        </div>
                                    </div>
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>

                <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-white p-0" id="iconNavbarSidenav">
                        <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line bg-white"></i>
                            <i class="sidenav-toggler-line bg-white"></i>
                            <i class="sidenav-toggler-line bg-white"></i>
                        </div>
                    </a>
                </li>
                <li class="nav-item dropdown px-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-white p-0" data-bs-toggle="dropdown">
                        <i class="fa fa-cog fixed-plugin-button-nav cursor-pointer"></i>
                    </a>
                </li>
                <li class="nav-item dropdown pe-2 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-white p-0" id="dropdownMenuButton"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-bell cursor-pointer"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Ketika dokumen telah dimuat sepenuhnya
    document.addEventListener('DOMContentLoaded', function() {
        // Mengambil elemen form logout
        var logoutForm = document.getElementById('logout-form');

        // Menambahkan event listener untuk meng-handle submit formulir logout
        logoutForm.addEventListener('submit', function(event) {
            // Mencegah perilaku bawaan dari submit (pengiriman formulir)
            event.preventDefault();

            // Menampilkan Sweet Alert untuk konfirmasi logout
            Swal.fire({
                title: "Are you sure?",
                text: "You will be logged out.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Logout!"
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika pengguna mengkonfirmasi logout, kirim formulir
                    logoutForm.submit();
                }
            });
        });
    });
</script>
