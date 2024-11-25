<!DOCTYPE html>
<html lang="en">

<head>
    <title>DANDUK SKANDA</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="{{ asset('assets/images/logoskanda.webp') }}" />
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/animate/animate.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/css-hamburgers/hamburgers.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/select2/select2.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/util.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/main.css') }}">
    <!--===============================================================================================-->
</head>

<body>
    <main>
        <div class="limiter">
            <div class="container-login100">
                <div class="wrap-login100">
                    <div class="login100-pic js-tilt" data-tilt>
                        <img src="{{ asset('assets/images/logoskanda.webp') }}" alt="IMG">
                    </div>

                    <form action="{{ route('actionLogin') }}" method="POST" class="login100-form validate-form">
                        @csrf
                        <span class="login100-form-title">
                            Login
                        </span>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="wrap-input100 validate-input">
                            <input class="input100 @error('username') is-invalid @enderror" type="text"
                                name="username" placeholder="Username" id="username" autofocus required
                                value="{{ old('username') }}">
                            <span class="focus-input100"></span>
                            <span class="symbol-input100">
                                <i class="fa fa-user" aria-hidden="true"></i>
                            </span>
                        </div>

                        @error('username')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                        <div class="wrap-input100 validate-input">
                            <input class="input100 @error('password') is-invalid @enderror" type="password"
                                name="password" id="password" placeholder="Password" required>
                            <span class="focus-input100"></span>
                            <span class="symbol-input100">
                                <i class="fa fa-lock" aria-hidden="true"></i>
                            </span>
                        </div>

                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                        @error('role_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                        <input type="hidden" name="user_id" value="{{ old('user_id') }}">

                        <div class="container-login100-form-btn">
                            <button class="login100-form-btn">
                                Login
                            </button>
                        </div>

                        <div class="text-center p-t-136">
                            <a class="txt2" href="https://www.instagram.com/galerismkn2clp/">
                                <img src="{{ asset('assets/images/logo ig.jpg') }}" alt="Instagram" width="30"
                                    height="30" style="margin-right: 20px;">
                            </a>
                            <a class="txt2" href="https://smkn2-cilacap.sch.id/">
                                <img src="{{ asset('assets/images/logoweb.png') }}" alt="Website" width="30"
                                    height="30">
                            </a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </main>

    <!--===============================================================================================-->
    <script src="{{ asset('assets/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
    <!--===============================================================================================-->
    <script src="{{ asset('assets/vendor/bootstrap/js/popper.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <!--===============================================================================================-->
    <script src="{{ asset('assets/vendor/select2/select2.min.js') }}"></script>
    <!--===============================================================================================-->
    <script src="{{ asset('assets/vendor/tilt/tilt.jquery.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.js-tilt').tilt({
                scale: 1.1
            });
        });
    </script>
    <!--===============================================================================================-->
    <script src="{{ asset('assets/js/main.js') }}"></script>
    {{-- ============================================================================ --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>

</html>
