<!doctype html>
<html lang="en">

<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
    <!-- Meta-Link -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="description" content="">
    <meta name="mlapplication-tap-highlight" content="no">

    <!-- Title -->
    <title>@yield('title')</title>
    <!-- FaveIcon-Link -->
    <link rel="shortcut icon" href="{{ $app_setting['favicon'] }}" type="image/x-icon">
    <!-- Bootstrap-Min-Css-Link -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <!-- Font-Awesome--Min-Css-Link -->
    <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.min.css') }}">
    <!--Bootstrap-Icon-Css-Link -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-icons.css') }}">
    <!--Style--Css-Link -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <!--Responsive--Css-Link -->
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">

    <style>
        .version-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: #b54dff;
            color: #fff;
            font-size: 14px;
            font-weight: bold;
            padding: 5px 20px;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .powerBy {
            position: absolute;
            bottom: 10px;
            left: 10px;
            color: #b54dff;
            font-size: 14px;
            font-weight: bold;
            padding: 5px 20px;
            border-radius: 4px;
        }

        .auth-wrapper {
            background: linear-gradient(135deg, #f9f5ff, #ffffff);
        }

        .main-card {
            position: relative;
            border: none;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
            border-radius: 20px;
            background: #fff;
        }

        /* Register Options */
        .option-card {
            display: block;
            text-align: center;
            padding: 12px;
            border-radius: 10px;
            font-weight: 600;
            color: #333;
            background: #fff;
            border: 1px solid #e0d4f7;
            transition: all 0.3s ease;
        }

        .option-card:hover {
            background: #b54dff;
            color: #fff;
            border-color: #b54dff;
            box-shadow: 0 4px 12px rgba(181, 77, 255, 0.4);
        }

        /* Inputs */
        .modern-input {
            border-radius: 10px;
            border: 1px solid #ddd;
            transition: all 0.2s ease;
        }

        .modern-input:focus {
            border-color: #b54dff;
            box-shadow: 0 0 0 0.2rem rgba(181, 77, 255, 0.25);
        }

        /* Password toggle */
        .toggle-password {
            position: absolute;
            top: 50%;
            right: 12px;
            transform: translateY(-50%);
            cursor: pointer;
            color: #aaa;
        }

        .toggle-password:hover {
            color: #b54dff;
        }

        /* Demo accounts */
        .demo-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(181, 77, 255, 0.2);
            border-radius: 14px;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .demo-card:hover {
            transform: translateY(-5px);
            border-color: #b54dff;
            box-shadow: 0 6px 20px rgba(181, 77, 255, 0.25);
            background: rgba(181, 77, 255, 0.08);
        }

        .demo-info {
            font-size: 0.9rem;
            color: #333;
        }

        .demo-icon {
            font-size: 1.4rem;
            color: #b54dff;
            transition: transform 0.3s ease, color 0.3s ease;
        }

        .demo-card:hover .demo-icon {
            transform: scale(1.2);
            color: #9a3be6;
        }
    </style>
</head>

<body>
    <div class="d-flex vh-100 auth-wrapper">

        <div class="container mx-auto my-auto">
            <div class="main-card card h-100 d-flex flex-column overflow-hidden shadow-lg rounded-4 border-0">
                @if (config('app.env') == 'local')
                    <div class="powerBy">Powered by RazinSoft ©{{ now()->format('Y') }}</div>
                    <div class="version-badge">v{{ config('app.version') }}</div>
                @endif
                <div class="row g-0">
                    <!-- Left Section -->
                    <div class="col-lg-7 my-auto p-4">
                        <div class="card-body">

                            <!-- Logo -->
                            <div class="text-center mb-4">
                                @if ($app_setting['logo'])
                                    <img src="{{ $app_setting['logo'] }}" alt="Logo" class="img-fluid"
                                        width="180">
                                @else
                                    <img src="{{ asset('assets/images/auth/logo.png') }}" alt="Logo"
                                        class="img-fluid" width="180">
                                @endif
                            </div>

                            <!-- Register Options -->
                            <div class="register-box p-3 mb-4 rounded-3">
                                <p class="fw-bold fs-5 mb-1 text-dark">{{ __('Choose Your Path to Join Us') }}!</p>
                                <p class="text-muted fs-6">
                                    {{ __('Are you a Student, Instructor or an Organization?') }}</p>

                                <div class="row g-2 mt-3">
                                    <div class="col-12 col-md-4">
                                        <a href="/register" target="_blank" class="option-card">
                                            {{ __('Student') }}
                                        </a>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <a href="{{ route('instructor.register') }}" target="_blank"
                                            class="option-card">
                                            {{ __('Instructor') }}
                                        </a>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <a href="{{ route('org.register') }}" target="_blank" class="option-card">
                                            {{ __('Organization') }}
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Login Form -->
                            <form action="{{ route('admin.authenticate') }}" method="POST" class="mt-3">
                                @csrf

                                <!-- Email -->
                                <div class="mb-3">
                                    <label class="fw-semibold">{{ __('Email address') }}</label>
                                    <input type="email" name="email" id="email"
                                        class="form-control modern-input" placeholder="example@domain.com"
                                        value="{{ old('email') }}">
                                    @error('email')
                                        <p class="text-danger mt-1 small">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Password -->
                                <div class="mb-3">
                                    <label class="fw-semibold">{{ __('Password') }}</label>
                                    <div class="position-relative">
                                        <input type="password" name="password" id="passwordInput"
                                            class="form-control modern-input"
                                            placeholder="{{ __('Enter your password') }}">
                                        <i class="fa-solid fa-eye-slash toggle-password" id="togglePassword"
                                            onclick="myPasswordView()"></i>
                                    </div>
                                    @error('password')
                                        <p class="text-danger mt-1 small">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Submit -->
                                <button type="submit" id="loginBtn" onclick="loadder()"
                                    class="btn btn-primary w-100 py-3 fw-bold shadow-sm">
                                    {{ __('Login') }}
                                    <div id="is-loading" class="d-none d-inline-flex align-items-center gap-1">
                                        <div class="spinner-grow text-white" style="width:6px; height:6px;"></div>
                                        <div class="spinner-grow text-white" style="width:6px; height:6px;"></div>
                                        <div class="spinner-grow text-white" style="width:6px; height:6px;"></div>
                                    </div>
                                </button>
                            </form>

                            <!-- Local Demo Accounts -->
                            @if (config('app.env') == 'local')
                                <div class="row mt-2 g-3 pb-3">
                                    <div class="col-12 col-md-6">
                                        <div class="demo-card"
                                            onclick="email.value='admin@readylms.com'; passwordInput.value='secret@123'">
                                            <div class="demo-info">
                                                <strong>Email:</strong> admin@readylms.com <br>
                                                <strong>Password:</strong> secret@123
                                            </div>
                                            <div class="demo-icon">
                                                <i class="bi bi-clipboard-check-fill"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <div class="demo-card"
                                            onclick="email.value='instructor@readylms.com'; passwordInput.value='secret'">
                                            <div class="demo-info">
                                                <strong>Email:</strong> instructor@readylms.com <br>
                                                <strong>Password:</strong> secret
                                            </div>
                                            <div class="demo-icon">
                                                <i class="bi bi-clipboard-check-fill"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <div class="demo-card"
                                            onclick="email.value='org@readylms.com'; passwordInput.value='secret@org'">
                                            <div class="demo-info">
                                                <strong>Email:</strong> org@readylms.com <br>
                                                <strong>Password:</strong> secret@org
                                            </div>
                                            <div class="demo-icon">
                                                <i class="bi bi-clipboard-check-fill"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Right Section -->
                    <div class="col-lg-5 d-none d-lg-block">
                        <img src="{{ asset('assets/images/auth/login.png') }}" alt="auth-login"
                            class="h-100 w-100 object-fit-cover rounded-end-4">
                    </div>
                </div>
            </div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function myPasswordView() {
            var icon = document.getElementById("togglePassword");
            var x = document.getElementById("passwordInput");
            if (x.type === "password") {
                x.type = "text";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            } else {
                x.type = "password";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            }
        }

        const loadder = () => {
            document.getElementById('is-loading').classList.remove('d-none');
            setTimeout(() => {
                document.getElementById('is-loading').classList.add('d-none');
            }, 5000);
        }
    </script>

    @if (session('verification-error'))
        <script>
            Swal.fire({
                icon: "error",
                title: "{{ session('verification-error') }}",
                showConfirmButton: false,
                timer: 3500
            });
        </script>
    @endif

    @if (session('account-created'))
        <script>
            Swal.fire({
                icon: "success",
                title: "{{ session('account-created') }}",
                showConfirmButton: false,
                timer: 3500,
                customClass: {
                    title: "swal-title",
                },
            });
        </script>
    @endif

    @if (session('account-suspended'))
        <script>
            Swal.fire({
                icon: "error",
                title: "Account Has Been Suspended",
                html: "{!! session('account-suspended') !!} ",
                footer: '<a href="{{ url('/contact-us') }}">contact with support team?</a>',
            });
        </script>
    @endif

</body>

</html>
