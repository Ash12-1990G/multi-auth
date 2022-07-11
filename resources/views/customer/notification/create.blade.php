@extends('admin.layouts.backend')
@push('styles')

<link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">

@endpush
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">New Notification</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('notifications.index') }}">Notifications</a></li>
                    <li class="breadcrumb-item active">New Notification</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
            <form class="form-normal" action={{route('customer.notifications.store')}} method="post">
            @csrf
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">New Notice</h3>
                </div>
                <div class="card-body">
                    <p class="text-muted">Send notification to students</p>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <input class="form-control {{ $errors->has('subject') ? ' is-invalid' : '' }}" placeholder="Subject:" name="subject" value="{{ old('subject') }}">
                        @if ($errors->has('subject'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('subject') }}.</strong>
                                </span>
                                @endif
                        </div>
                        <div class="form-group col-md-12">
                            <textarea class="form-control {{ $errors->has('message') ? ' is-invalid' : '' }}" placeholder="write here" name="message">{{ old('subject') }}</textarea>
                        @if ($errors->has('message'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('message') }}.</strong>
                                </span>
                                @endif
                        </div>
                    </div>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <div class="float-right">
                  <button type="submit" class="btn btn-primary"><i class="far fa-envelope"></i> Send</button>
                </div>
                
              </div>
              <!-- /.card-footer -->
            </div>
              
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')

<script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>

@if($msg = session('success'))
<script type="text/javascript">
  tosterMessage('success',"{{$msg}}")
 
</script>
@endif
@if($msg = session('warning'))
<script type="text/javascript">
  tosterMessage('error',"{{$msg}}")
 
</script>
@endif
<script type="text/javascript">
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

</script>

@endsection