@extends('frontend.layouts.auth')
@section('title')
  ACTI Admin Login
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 pt-5">
            <div class="card">
                <div class="card-header">{{ __('Verify Your Email Address') }}</div>

                <div class="card-body">
                    
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif
                    @if ($msg = session('message'))
                        <div class="alert alert-success" role="alert">
                            {{ $msg }}
                        </div>
                    @endif

                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }},
                    @php
                    if(request()->user()->hasRole('Student-Admin')){
                        $route = 'student.verification.send';
                    }
                    else if(request()->user()->hasRole('Franchise-Admin')){
                    $route = 'customer.verification.send';
                   }
                    
                    @endphp
                    <form class="d-inline" method="POST" action="{{ route($route) }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
