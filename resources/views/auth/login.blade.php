@extends('layouts.auth')

@section('login')
<main class="main-content main-content-bg mt-0">
    <div class="page-header min-vh-100"
        style="background-image: url('https://raw.githubusercontent.com/creativetimofficial/public-assets/master/argon-dashboard-pro/assets/img/signin-basic.jpg');">
        <span class="mask bg-gradient-dark opacity-6"></span>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-7">
                    <div class="card border-0 mb-0">

                        <div class="card-header mb-4 text-center">
                            <h3 class="font-weight-bolder">{{ app()->getLocale() }}</h3>
                            <h3 class="font-weight-bolder">Welcome back POS App</h3>
                            <p class="mb-0">Enter your email and password to sign in</p>
                        </div>
                        <div class="card-body px-lg-5 pt-0">
                            <form role="form" class="text-start" action="{{ route('login') }}" method="post">
                                @csrf
                                <div class="form-group @error('email') has-danger @enderror">
                                    <input type="email" name="email"
                                        class="form-control @error('email') is-invalid @enderror" placeholder="Email"
                                        required value="{{ old('email') }}" autofocus>
                                    <span class="glyphicon glyphicon-envelope form-control-is"></span>
                                    @error('email')
                                    <span class="help-block text-xs text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group has-feedback @error('password') has-danger @enderror">
                                    <input type="password" name="password" class="form-control" placeholder="Password"
                                        required>
                                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                                    @error('password')
                                    <span class="help-block">{{ $message }}</span>
                                    @else
                                    <span class="help-block with-errors"></span>
                                    @enderror
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="rememberMe">
                                    <label class="form-check-label" for="rememberMe">Remember me</label>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn bg-gradient-primary w-100 my-4 mb-2">Sign
                                        in</button>
                                </div>
                            </form>
                        </div>
                        <div class="row">

                            <a href="/lang/id" class="btn bg-gradient-primary w-100 my-4 mb-2">ID</a>
                            <a href="/lang/en" class="btn bg-gradient-primary w-100 my-4 mb-2">EN</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
{{-- <div class="login-box">

    <!-- /.login-logo -->
    <div class="login-box-body">
        <div class="login-logo">
            <a href="{{ url('/') }}">
                <img src="{{ url($setting->path_logo) }}" alt="logo.png" width="100">
            </a>
        </div>

        <form action="{{ route('login') }}" method="post" class="form-login">
            @csrf
            <div class="form-group has-feedback @error('email') has-error @enderror">
                <input type="email" name="email" class="form-control" placeholder="Email" required
                    value="{{ old('email') }}" autofocus>
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                @error('email')
                <span class="help-block">{{ $message }}</span>
                @else
                <span class="help-block with-errors"></span>
                @enderror
            </div>
            <div class="form-group has-feedback @error('password') has-error @enderror">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                @error('password')
                <span class="help-block">{{ $message }}</span>
                @else
                <span class="help-block with-errors"></span>
                @enderror
            </div>
            <div class="row">
                <div class="col-xs-8">
                    <div class="checkbox icheck">
                        <label>
                            <input type="checkbox"> Remember Me
                        </label>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
                </div>
                <!-- /.col -->
            </div>
        </form>
    </div>
    <!-- /.login-box-body -->
</div> --}}
<!-- /.login-box -->
@endsection