@extends('frontend.layouts.signin')
@section('title')
  ACTI-INDIA Customer Login
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
.gradient-custom-2 {
/* fallback for old browsers */
background: #fccb90;

/* Chrome 10-25, Safari 5.1-6 */
background: -webkit-linear-gradient(to right, #ef6557, #edbe13);

/* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
background: linear-gradient(to right, #ef6557, #edbe13);
}

@media (min-width: 768px) {
.gradient-form {
height: 100vh !important;
}
}
@media (min-width: 769px) {
.gradient-custom-2 {
border-top-right-radius: .3rem;
border-bottom-right-radius: .3rem;
}
}
</style>
@endpush
@section('content')
<section class="h-100 gradient-form" >
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-xl-10">
        <div class="card rounded-3 text-black">
          <div class="row g-0">
            <div class="col-lg-6">
              <div class="card-body p-md-5 mx-md-4">

                <div class="text-center">
                  <img src="{{ asset('storage/logo/logo.png') }}"
                    style="width: 185px;" alt="logo">
                  <h5 class="mt-1 mb-5 pb-1">Please login to your account</h5>
                </div>

                <form method="POST" action="{{route('customer.login')}}">
                @csrf

                  <div class="form-outline mb-4">
                    <label class="form-label" for="form2Example11">{{ __('EMAIL') }}</label>
                    <input type="email" id="form2Example11" class="form-control @error('email') is-invalid @enderror" placeholder="Email address" name="email" value="{{ old('email') }}" required/>
                      @error('email')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                  </div>

                  <div class="form-outline mb-4">
                    <label class="form-label" for="form2Example22">{{ __('PASSWORD') }}</label>
                    <input type="password" id="form2Example22" class="form-control @error('password') is-invalid @enderror" placeholder="Enter your password" name="password" value="{{ old('password') }}" required  />
                    @error('password')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                  </div>
                  <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                        <label class="form-check-label" for="remember">
                            {{ __('Remember Me') }}
                        </label>
                    </div>
                    @if (Route::has('password.request'))
                  <div class="text-center pt-1 mb-5 pb-1">
                    <button type="submit" class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3" type="button">Log
                      in</button>
                    <a class="text-muted" href="{{ route('password.request') }}">Forgot password?</a>
                  </div>
                  @endif

                  

                </form>

              </div>
            </div>
            <div class="col-lg-6 d-flex align-items-center gradient-custom-2">
              <div class="text-white px-3 py-4 p-md-5 mx-md-4">
                <h4 class="mb-4 text-white">We are IT professionals</h4>
                <p class="small mb-0 text-white">ACTI-INDIA has been educating computer professionals for long time  and has launched numerous successful careers in the field of information technology.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection