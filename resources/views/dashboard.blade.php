<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cumque excepturi a, quos cupiditate quisquam tenetur expedita nulla fugit quasi ipsam ipsum, nemo architecto maxime eius provident consectetur reprehenderit quas maiores.</p>
    

@if(auth()->check())
<button onclick="confirmLogout()">Logout</button>
<form id="logoutForm" action="{{ route('actionLogout') }}" method="post" style="display: none;">
    @csrf
</form>
@endif

<script>
function confirmLogout() {
    Swal.fire({
        title: "Are you sure?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Logout"
    }).then((result) => {
        if (result.isConfirmed) {
            // Submit formulir logout setelah konfirmasi
            document.getElementById('logoutForm').submit();
        }
    });
}
</script>

@if(auth()->check())
<script>
    // Tambahkan kode untuk menampilkan pesan toast saat login berhasil
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 5000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });

    Toast.fire({
        icon: 'success',
        title: 'Login Berhasil!'
    });
</script>
@endif

</body>
</html>