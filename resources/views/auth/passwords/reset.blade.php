@extends('layouts-verticalmenu-light.master2')
@section('css')
@endsection
@section('content')

<!-- Page -->
<div class="page main-signin-wrapper">

    <!-- Row -->
    <div class="row signpages text-center">
        <div class="col-md-12">
            <div class="card">
                <div class="row row-sm">
                    <div class="col-lg-6 col-xl-5 d-none d-lg-block text-center bg-primary details">
                        <div class="mt-5 pt-4 p-2 pos-absolute">
                            <img src="{{URL::asset('assets/img/brand/logo-light.png')}}" class="header-brand-img mb-4" alt="logo">
                            <div class="clearfix"></div>
                            <img src="{{URL::asset('assets/img/svgs/user.svg')}}" class="ht-100 mb-0" alt="user">
                            <h5 class="mt-4 text-white">Create Your New Password</h5>
                            <span class="tx-white-6 tx-13 mb-5 mt-xl-0">Create your new password.</span>
                        </div>
                    </div>
                    <div class="col-lg-6 col-xl-7 col-xs-12 col-sm-12 login_form ">
                        <div class="container-fluid">
                            <div class="row row-sm">
                                <div class="card-body mt-2 mb-2">
                                    <img src="{{URL::asset('assets/img/brand/logo.png')}}" class=" d-lg-none header-brand-img text-left float-left mb-4" alt="logo">
                                    <div class="clearfix"></div>
                                    <form method="POST" action="{{ route('password.update') }}">
                                        @csrf
                                        <input type="hidden" name="token" value="{{ $token }}">
                                        <h5 class="text-left mb-2">Create Your New Password</h5>
                                        <p class="mb-4 text-muted tx-13 ml-0 text-left">Create Your New Password</p>
                                        <div class="form-group text-left">
                                            <label>Email</label>
                                            <input class="form-control" placeholder="Type Here" type="text" name="email" value="{{ old('email') }}" required autofocus>
                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group text-left">
                                            <label>Password</label>
                                            <input class="form-control" placeholder="Type Here" type="password" name="password" required>
                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group text-left">
                                            <label>Password</label>
                                            <input class="form-control" placeholder="Type Here" type="password" id="password-confirm" name="password_confirmation" required>
                                        </div>
                                        <button class="btn ripple btn-main-primary btn-block">Reset Password</button>
                                    </form>
                                    <div class="text-left mt-5 ml-0">
                                        <div class="mb-1"><a href="{{ route('login') }}">Login?</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Row -->

</div>
<!-- End Page -->

@endsection
@section('script')
@endsection