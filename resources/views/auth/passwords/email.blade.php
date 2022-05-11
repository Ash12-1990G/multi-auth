@extends('frontend.layouts.auth')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4 pt-5">
            <div class="card p-2">
                

                <div class="card-body">
                    
                    <div class="text-center mb-2">
                        <!-- <img class="w-50" src="{{ asset('storage/logo/logo.png') }}"> -->
                        <i class="fas fa-lock text-info" style="font-size:45px;"></i>
                    </div>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                        <h5 class="mt-2 mb-2 text-center mb-4 mt-3">Reset your password</h5>
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="row mb-4">

                            <div class="col-md-12">
                                
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Enter your email address" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0 text-center">
                            <div class="col-md-12 mb-2">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Send Password Reset Link') }}
                                    </button>
                                    
                                
                            </div>
                            <a href="/" class="text-info fw-normal">
                                {{ __('Back to Home') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
