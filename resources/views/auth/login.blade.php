<!DOCTYPE html>

<html lang="en" dir="ltr" class="dark-style layout-navbar-fixed layout-menu-fixed sf-js-enabled"
    data-theme="theme-default" data-assets-path="{{ asset('assets/dashboard/assets') }}/"
    data-template="vertical-menu-template">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Admin Login</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/dashboard/assets/img/favicon/favicon.ico') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('assets/dashboard/assets/vendor/fonts/fontawesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/dashboard/assets/vendor/fonts/tabler-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/dashboard/assets/vendor/fonts/flag-icons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('assets/dashboard/assets/vendor/css/rtl/core.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/dashboard/assets/vendor/css/rtl/theme-default.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/dashboard/assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet"
        href="{{ asset('assets/dashboard/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/dashboard/assets/vendor/libs/node-waves/node-waves.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/dashboard/assets/vendor/libs/typeahead-js/typeahead.css') }}" />
    <!-- Vendor -->
    <link rel="stylesheet"
        href="{{ asset('assets/dashboard/assets/vendor/libs/formvalidation/dist/css/formValidation.min.css') }}" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('assets/dashboard/assets/vendor/css/pages/page-auth.css') }}" />
    <!-- Helpers -->
    <script src="{{ asset('assets/dashboard/assets/vendor/js/helpers.js') }}"></script>

    <!--! Theme config file -->
    <script src="{{ asset('assets/dashboard/assets/js/config.js') }}"></script>
</head>

<body>
    <!-- Content -->

    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner py-4">
                <!-- Login -->
                <div class="card">
                    <div class="card-body">
                        <h4 class="mb-1 pt-2">Welcome! 👋</h4>

                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if (session('status'))
                            <div class="alert alert-success alert-dismissible" role="alert">
                                {{ session('status') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form id="formAuthentication" class="mb-3" action="{{ route('login') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Email or Username</label>
                                <input type="text" name="email" value="{{ old('email') }}"
                                    class="form-control @error('email') is-invalid @enderror"
                                    id="email" placeholder="Enter your email or username" autofocus />
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 form-password-toggle">
                                <div class="d-flex justify-content-between">
                                    <label class="form-label" for="password">Password</label>

                                </div>
                                <div class="input-group input-group-merge">
                                    <input type="password" name="password" value="{{ old('password') }}" id="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        aria-describedby="password" />
                                    <span class="input-group-text cursor-pointer" id="toggle-password"><i
                                            class="ti ti-eye-off"></i></span>
                                </div>
                                @error('password')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" name="remember" type="checkbox" id="remember-me"
                                        {{ old('remember') ? 'checked' : '' }} />
                                    <label class="form-check-label" for="remember-me"> Remember Me </label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /Register -->
            </div>
        </div>
    </div>

    <!-- / Content -->

    <!-- Core JS -->
    @include('dashboard.layouts.scripts')

    <!-- Password Toggle Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.getElementById('toggle-password');
            const passwordInput = document.getElementById('password');
            const eyeIcon = togglePassword.querySelector('i');

            togglePassword.addEventListener('click', function() {
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    eyeIcon.classList.remove('ti-eye-off');
                    eyeIcon.classList.add('ti-eye');
                } else {
                    passwordInput.type = 'password';
                    eyeIcon.classList.remove('ti-eye');
                    eyeIcon.classList.add('ti-eye-off');
                }
            });
        });
    </script>
</body>

</html>
