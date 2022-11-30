@extends('layouts.simple')
@section('title', 'Login')

@section('content')
{{-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> --}}

<main id="main-container">
        <!-- Page Content -->
        <div class="bg-body-dark">
          <div class="row mx-0 justify-content-center">
            <div class="hero-static col-12">
              <div class="content content-full overflow-hidden">
                <!-- Header -->
                <div class="py-1 text-center">
                  <a class="link-fx fw-bold" href="#">
                    <i class="fa fa-file-invoice"></i>
                    <span class="fs-4 text-body-color">SMP N 1</span><span class="fs-4"> Demak</span>
                  </a>
                  <h1 class="h3 fw-bold mt-1 mb-3">Aplikasi Pencatatan Informasi Keuangan</h1>
                  {{-- <h2 class="h5 fw-medium text-muted mb-0">It’s a great day today!</h2> --}}
                </div>
                <!-- END Header -->

                <!-- Sign In Form -->
                <!-- jQuery Validation functionality is initialized with .js-validation-signin class in js/pages/op_auth_signin.min.js which was auto compiled from _js/pages/op_auth_signin.js -->
                <!-- For more examples you can check out https://github.com/jzaefferer/jquery-validation -->
                <div class="row mx-0 justify-content-center">
                    <div class="col-lg-8 col-xl-4">
                        <form class="js-validation-signin" method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="block block-themed block-rounded block-fx-shadow">
                                <div class="block-header bg-gd-sea">
                                <h3 class="block-title">Please Sign In</h3>
                                </div>
                                <div class="block-content">
                                <div class="form-floating mb-3">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="login-username" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Enter your username">
                                    <label class="form-label" for="login-username">Email</label>
                                    @error('email')
                                        <span class="invalid-feedback animated fadeIn" {{-- role="alert" --}}>
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="password" class="form-control  @error('password') is-invalid @enderror" id="login-password" name="password" placeholder="Enter your password" required autocomplete="current-password">
                                    <label class="form-label" for="login-password">Password</label>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="number" class="form-control  @error('ta') is-invalid @enderror" id="ta" name="ta" placeholder="Enter your TA" required value="2022">
                                    <label class="form-label" for="ta">TA</label>
                                    @error('ta')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-sm-6 d-sm-flex align-items-center push">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="remember">Remember Me</label>
                                    </div>
                                    </div>
                                    <div class="col-sm-6 text-sm-end push">
                                    <button type="submit" class="btn btn-lg btn-alt-primary fw-medium">
                                        Sign In
                                    </button>
                                    </div>
                                </div>
                                </div>
                                <div class="block-content block-content-full bg-body-light text-center d-flex justify-content-between">
                                {{-- <a class="fs-sm fw-medium link-fx text-muted me-2 mb-1 d-inline-block" href="op_auth_signup3.html">
                                    <i class="fa fa-plus opacity-50 me-1"></i> Create Account
                                </a> --}}
                                @if (Route::has('password.request'))
                                    <a class="fs-sm fw-medium link-fx text-muted me-2 mb-1 d-inline-block" href="{{ route('password.request') }}">
                                        {{ __('Forgot Password') }}
                                    </a>
                                @endif
                                
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- END Sign In Form -->
              </div>
            </div>
          </div>
        </div>
        <!-- END Page Content -->
      </main>
@endsection
