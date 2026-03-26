<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - {{ config('app.name') }}</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('stisla-assets/modules/bootstrap/css/bootstrap.min.css') }}">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="{{ asset('stisla-assets/modules/fontawesome/css/all.min.css') }}">
    <!-- Stisla CSS -->
    <link rel="stylesheet" href="{{ asset('stisla-assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('stisla-assets/css/components.css') }}">
</head>
<body>
    <div id="app">
        <section class="section">
            <div class="container mt-5">
                <div class="row">
                    <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">

                        <div class="login-brand">
                            <img src="{{ asset('stisla-assets/img/stisla-fill.svg') }}"
                                alt="{{ config('app.name') }}"
                                width="100"
                                class="shadow-light rounded-circle">
                        </div>

                        <div class="card card-primary">
                            <div class="card-header">
                                <h4>{{ config('app.name') }}</h4>
                            </div>
                            <div class="card-body">
                                <p class="text-muted">Masuk ke akun Anda untuk melanjutkan.</p>

                                <form method="POST" action="{{ route('login') }}">
                                    @csrf

                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input id="email"
                                            type="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            name="email"
                                            value="{{ old('email') }}"
                                            autofocus
                                            placeholder="Masukkan email Anda">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input id="password"
                                            type="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            name="password"
                                            placeholder="Masukkan password Anda">
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox"
                                                name="remember"
                                                class="custom-control-input"
                                                id="remember-me">
                                            <label class="custom-control-label" for="remember-me">Ingat Saya</label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-lg btn-block">
                                            <i class="fas fa-sign-in-alt mr-1"></i> Masuk
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="simple-footer">
                            Copyright &copy; {{ config('app.name') }} {{ date('Y') }}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- jQuery -->
    <script src="{{ asset('stisla-assets/modules/jquery.min.js') }}"></script>
    <script src="{{ asset('stisla-assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('stisla-assets/js/scripts.js') }}"></script>
</body>
</html>
