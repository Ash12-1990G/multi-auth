@extends('admin.layouts.backend')
@push('styles')
<link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
@endpush

@section('content')
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Profile</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">Profile</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
            
                <div class="col-md-5">

                    <div class="card card-widget widget-user-2">
                        <div class="widget-user-header bg-secondary">
                          
                            
                            <h3 class="widget-user-username text-center ml-0">{{ $data->name }}</h3>
                            <h5 class="widget-user-desc text-center ml-0">{{ $data->email }}</h5>
                            
                        </div>
                        <div class="card-body">
                            <h5><b>My Details</b></h5>
                            <hr class="m-1">
                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item border-0 p-1">
                                    <b>Owner Name</b> <a class="float-right text-capitalize">{{ $data->customers->cust_name}}</a>
                                </li>
                                <li class="list-group-item border-0 p-1">
                                    <b>Center</b> <a class="float-right">{{ $data->customers->center_code}}</a>
                                </li>
                                <li class="list-group-item border-0 p-1">
                                    <b>Contact</b> <a class="float-right">{{ $data->customers->phone}} </a>
                                </li>
                                
                            </ul>
                            
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                                
                    
                    <div class="card card-primary card-outline">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills" id="small-nav">
                                <li class="nav-item"><a class="nav-link active" href="#residence" data-toggle="tab">Other Information</a></li>
                                <li class="nav-item"><a class="nav-link" href="#changepassword" data-toggle="tab">Change Password</a></li>
                                
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="residence">
                                    <!-- Post -->
                                    <div class="post">
                                    
                                        <strong><i class="fas fa-map-marker-alt mr-1"></i> Owner Address</strong>
                                        <p>
                                        {{ $data->customers->address}}
                                {{ $data->customers->city}}
                                {{ $data->customers->state}}
                                {{ $data->customers->pincode}}
                                        </p>
                                        
                                        <strong><i class="fas fa-map-marker-alt mr-1"></i> Center Address</strong>
                                        <p>
                                        {{ $data->customers->location}}}
                                        </p>
                                        

                                    </div>
                                </div>
                                <div class="tab-pane" id="changepassword">
                                    
                                    <form id="resetform" class="form-horizontal" method="POST" action="{{ route('customer.changepassword') }}">
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
                                <!-- /.tab-pane -->
                                </div>
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


<script type="text/javascript">
  tosterMessage('success',"{{$msg}}")
 
</script>
@endif
@if($errors->any())
    <script>

        if(!$('#changepassword').hasClass('active')){
            $('#changepassword').addClass('active');
            $('#residence').removeClass('active');
            $('.nav-link').removeClass('active');
            $('#small-nav').children('.nav-item:nth-child(2)').find('.nav-link').addClass('active');
        }
        
        
    </script>
@endif
@endsection