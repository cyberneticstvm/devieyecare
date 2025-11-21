<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign In - Devi Eye Care</title>
    <meta name="description" content="App">
    <meta name="keywords" content="App">
    <meta name="author" content="ThemeMakker - Expert Admin Dashboard & UI Kit Developers">
    <link rel="icon" href="{{ asset('/assets/images/favicon.png') }}" type="image/x-icon">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('/assets/css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/css/responsive.css') }}">

</head>

<body data-thunderal="theme-indigo" class="">

    <div class="container-fluid login-container" style="min-height: 100vh;">
        <div class="row">
            <!-- Left Side: Form -->
            <div class="col-lg-6 d-flex align-items-center justify-content-center">
                <div class="w-100 px-lg-5 px-4 py-4" style="max-width: 420px;">
                    <h3 class="mb-3 fw-bold">Devi Eye Hospitals</h3>
                    <p class="text-muted mb-4">Login to your account to continue</p>
                    <!-- Login Form -->
                    {{ html()->form('POST')->route('user.login')->class('')->open() }}
                    <div class="mb-3 control-group">
                        <label class="form-label">Email address</label>
                        {{ html()->email('email', old('email'))->class('form-control')->placeholder('hello@example.com')->autofocus() }}
                        @error('email')
                        <small class="text-danger">{{ $errors->first('email') }}</small>
                        @enderror
                    </div>
                    <div class="mb-3 control-group">
                        {{ html()->password('password', null)->class('form-control')->placeholder('••••••••') }}
                        @error('password')
                        <small class="text-danger">{{ $errors->first('password') }}</small>
                        @enderror
                    </div>
                    <div class="d-grid mt-4">
                        {{ html()->submit('Login')->class('btn btn-submit btn-primary') }}
                    </div>
                    {{ html()->form()->close() }}
                </div>
            </div>
            <!-- Right Side: Image Slider -->
            <div class="col-lg-6 d-none d-lg-block p-0 overflow-hidden">
                <div class="d-flex justify-content-start">
                    <img style="object-fit: cover; height: 100vh;" src="{{ asset('/assets/images/login-page-bg.png') }}" alt="">
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <!--  -->
    <!-- <script src="assets/js/common.js"></script> -->
    @include("admin.message")
</body>

</html>