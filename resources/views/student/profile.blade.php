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
                        <div class="widget-user-header bg-info">
                            <div class="widget-user-image">
                            <img class="img-circle elevation-2" src="../dist/img/user7-128x128.jpg" alt="User Avatar">
                            </div>
                            <!-- /.widget-user-image -->
                            <h3 class="widget-user-username">{{ $data->users->name }}</h3>
                            <h5 class="widget-user-desc">{{ $data->users->email }}</h5>
                            
                        </div>
                        <div class="card-body">
                            <h5><b>My Details</b></h5>
                            <p class="mb-1">Personal Information</p>
                            <hr class="m-1">
                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item border-0 p-1">
                                    <b>Gender</b> <a class="float-right text-capitalize">{{ $data->gender}}</a>
                                </li>
                                <li class="list-group-item border-0 p-1">
                                    <b>DOB</b> <a class="float-right">{{ $data->birth->format('F j, Y')}}</a>
                                </li>
                                <li class="list-group-item border-0 p-1">
                                    <b>Contact</b> <a class="float-right">{{ $data->phone}} @if($data->alt_phone!==NULL)<br> {{ $data->alt_phone}} @endif</a>
                                </li>
                                <li class="list-group-item border-0 p-1">
                                    <b>Admission</b> <a class="float-right">{{ Carbon\Carbon::parse($data->admission)->format('F j, Y')}}</a>
                                </li>
                                <li class="list-group-item border-0 p-1">
                                    <b>Father</b> <a class="float-right">{{ $data->father_name}}</a>
                                </li>
                                <li class="list-group-item border-0 p-1">
                                    <b>Mother</b> <a class="float-right">{{ $data->mother_name}}</a>
                                </li>
                            </ul>
                            
                        </div>
                    </div>
                    <!-- <div class="info-box mb-3 bg-secondary">
                        <span class="info-box-icon"><i class="fas fa-graduation-cap"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Education</span>
                            <span class="info-box-number">{{$data->education}}</span>
                        </div>
                    </div> -->
                </div>
                <div class="col-md-7">
                                
                    
                    <div class="card card-primary card-outline">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills" id="small-nav">
                                <li class="nav-item"><a class="nav-link active" href="#residence" data-toggle="tab">Residence</a></li>
                                <li class="nav-item"><a class="nav-link" href="#changepassword" data-toggle="tab">Change Password</a></li>
                                
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="residence">
                                    <!-- Post -->
                                    <div class="post">
                                    <strong><i class="fas fa-graduation-cap mr-1"></i> Education Qualification</strong>
                                        <p>
                                        {{ $data->education}}
                                        </p>
                                        <strong><i class="fas fa-map-marker-alt mr-1"></i> Present Address</strong>
                                        <p>
                                        {{ $data->address1}}
                                {{ $data->city1}}
                                {{ $data->state1}}
                                {{ $data->pincode1}}
                                        </p>
                                        @if($data->address2!==NULL)
                                        <strong><i class="fas fa-map-marker-alt mr-1"></i> Permanent Address</strong>
                                        <p>
                                        {{ $data->address2}}
                                {{ $data->city2}}
                                {{ $data->state2}}
                                {{ $data->pincode2}}
                                        </p>
                                        @endif

                                    </div>
                                </div>
                                <div class="tab-pane" id="changepassword">
                                    
                                    <form id="resetform" class="form-horizontal" method="POST" action="{{ route('student.passwordchange',$data->user_id) }}">
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
{{$msg}}
<script type="text/javascript">
  
  $(function() {
    toastr.success("{{$msg}}");
});
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