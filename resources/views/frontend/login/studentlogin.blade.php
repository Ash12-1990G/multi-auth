@extends('frontend.layouts.signin')
@section('title')
  ACTI-INDIA Student Login
@endsection
@push('styles')
<style>
.input-group-text{
    color: #706d6d;
}
.invalid-feedback{
    display: block;
}
body {
    height: 100%;
    /* background: linear-gradient(90deg, #FFC0CB 50%, #00FFFF 50%); */
    background: linear-gradient(22deg, #abcef3 50%, #e2e4e7 50%);
}
</style>
@endpush
@section('content')
<div class="blog-page-area">
    <div class="container">
        <div class="row justify-content-center">
            
            <div class="col-md-8 mb-5">
                <div class="card shadow-sm mt-5" >
                    <!-- <div class="card-header bg-danger text-light fw-bold">{{ __('Login') }}</div> background-color: #1c3459;-->
                    <div class="row g-0">
                        <div class="col-md-5 text-light p-3" style="background: url({{asset('storage/about/login.jpg')}});background-size: cover;background-position: top;">
                            <h5 class="mt-3 text-light fw-normal">Welcome</h5>
                            <p class="text-light">To keep connected to us, Please login with your personal information.</p>
                            <!-- <img src="{{asset('storage/about/login.jpg')}}" class="img-fluid rounded-start" style="object-fit: cover"> -->
                        </div>
                        <div class="col-md-7">
                            <div class="card-body p-5">
                                <h5 class="mb-4 text-center">Login to your account</h5>
                            
                                <form method="POST" action="{{ route('student.login') }}" class="contact-form-wrap">
                                    @csrf
                                    
                                    <div class="form-group row">
                                        <label for="email" >{{ __('EMAIL') }}</label>

                                        <div class="col-md-12">
                                            <div class="single-input-wrap input-group mb-2">
                                                <input type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Enter your email" name="email" value="{{ old('email') }}" required>
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text"><i class="fa fa-envelope"></i></div>
                                                </div>
                                            </div>
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    
                                        

                                        <div class="col-md-12">
                                        <label for="password">{{ __('PASSWORD') }}</label>
                                            <div class="single-input-wrap input-group mb-2">
                                                <input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Enter your password" name="password" value="{{ old('password') }}" required >
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text"><i class="fa fa-lock"></i></div>
                                                </div>
                                            </div>

                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                                <label class="form-check-label" for="remember">
                                                    {{ __('Remember Me') }}
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                        @if (Route::has('password.request'))
                                                <a class="align-self-center mt-2 fw-normal text-secondary" href="{{ route('password.request') }}" style="font-size:12px;">
                                                    {{ __('Forgot Your Password?') }}
                                                </a>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row mb-0">
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary btn-lg btn-block">
                                                {{ __('Login') }}
                                            </button>
                                        </div>
                                        <a href="/" class="text-center text-primary mt-2 fw-normal">
                                            {{ __('Back to Home') }}
                                        </a>
                                    </div>
                                </form>
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-2">
                 <p class="text-dark">Copyright ©2022 <a href="{{route('front.home')}}" class="fw-bold"><span class="text-primary">ACTI-</span>INDIA</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection