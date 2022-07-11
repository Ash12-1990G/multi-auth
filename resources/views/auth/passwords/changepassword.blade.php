@extends('admin.layouts.backend')
@push('styles')
<link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
@endpush

@section('content')
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Change Password</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">Change Password</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
            
                <div class="col-md-7">
                                
                    
                    <div class="card card-primary card-outline">
                        
                        <div class="card-body">
                                    
                                    <form id="resetform" class="form-normal form-horizontal" method="POST" action="{{ route('admin.confirmchangepassword') }}">
                                         @csrf
                                    <div class="form-group row">
                                        <label for="password" class="col-sm-4 col-form-label">{{ __('New Password') }}</label>
                                        <div class="col-sm-8">
                                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('password') }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="password-confirm" class="col-sm-4 col-form-label">{{ __('Confirm Password') }}</label>
                                        <div class="col-sm-8">
                                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                        </div>
                                    </div>
                                  
                                    <div class="form-group row">
                                        <div class="offset-sm-4 col-sm-8">
                                        <button type="submit" class="btn btn-danger reset-btn">{{ __('Change Password') }}</button>
                                        </div>
                                    </div>
                                    </form>
                                
                       </div>
                   </div>
                    
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </div>
@endsection
@section('scripts')
<script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>

@if($msg = session('success'))
{{$msg}}
<script type="text/javascript">
  
  $(function() {
    toastr.success("{{$msg}}");
});
</script>
@endif

@endsection