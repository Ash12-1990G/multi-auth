@extends('admin.layouts.backend')
@push('styles')
<link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
@endpush
@section('content')
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Center Details</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">Center Details</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
            
                <div class="col-md-4">
                
                 
                  <div class="card card-outline card-success">
                    <div class="card-header bg-success">
                      <h3 class="card-title">{{$center->customers->users->name}}</h3>

                      <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                        </button>
                      </div>
                    </div>
                    <div class="card-body p-0">
                      <ul class="nav nav-pills flex-column">
                        <li class="nav-item px-3 py-2 active ">
                          
                            <i class="fas fa-university"></i> {{$center->customers->center_code}}
                          
                        </li>
                        <li class="nav-item px-3 py-2">
                            <i class="far fa-envelope"></i> {{$center->customers->users->email}}</span>
                        </li>
                        <li class="nav-item px-3 py-2">
                            <i class="fas fa-phone-alt"></i> {{$center->customers->phone}}</span>
                        </li>
                        <li class="nav-item px-3 py-2">
                            <i class="fas fa-map-marker-alt"></i> {{$center->customers->location}}</span>
                        </li>
                        
                        
                       
                      </ul>
                    </div>
                    <!-- /.card-body -->
                  </div>
                  
                 
                </div>
                <div class="col-md-8">
                  <form class="form-normal g-3" action="{{route('student.sendmail')}}" method="post">
                    @csrf
                    <div class="card card-primary card-outline">
                      <div class="card-header">
                        <h3 class="card-title">Compose New Message</h3>
                      </div>
                      <!-- /.card-header -->
                      <div class="card-body">
                        <div class="form-group">
                          <select class="form-control {{ $errors->has('to') ? ' is-invalid' : '' }}" placeholder="To:" name="to">
                          
                            <option value="{{$center->customers->users->email}}">{{$center->customers->users->email}}</option>
                          
                          </select>
                          @if ($errors->has('to'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $errors->first('to') }}.</strong>
                          </span>
                          @endif
                        </div>
                        <div class="form-group">
                          <input class="form-control {{ $errors->has('subject') ? ' is-invalid' : '' }}" placeholder="Subject:" name="subject">
                          @if ($errors->has('subject'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $errors->first('subject') }}.</strong>
                          </span>
                          @endif
                        </div>
                        <div class="form-group">
                            <textarea class="form-control {{ $errors->has('message') ? ' is-invalid' : '' }}" name="message" id="description"></textarea>
                            @if ($errors->has('message'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $errors->first('message') }}.</strong>
                          </span>
                          @endif
                        </div>
                        
                      </div>
                      <!-- /.card-body -->
                      <div class="card-footer">
                        <div class="float-right">
                          <button type="submit" class="btn btn-primary"><i class="far fa-envelope"></i> Send</button>
                        </div>
                      </div>
                    </div>
                  </form>        
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </div>
@endsection
@section('scripts')
<script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
<script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#description').summernote({
          toolbar: [
            // [groupName, [list of button]]
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']]
          ]
        });
    });
  </script>

@if($msg = session('success'))


<script type="text/javascript">
  tosterMessage('success',"{{$msg}}")
 
</script>
@endif

@endsection