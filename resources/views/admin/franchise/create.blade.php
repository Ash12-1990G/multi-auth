@extends('admin.layouts.backend')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">New Franchise</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('franchises.index') }}">Franchises</a></li>
                    <li class="breadcrumb-item active">New Franchise</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Add new franchise</h3>
                    </div>
                    <form class="g-3" action={{route('franchises.store')}} method="post" enctype="multipart/form-data">
                    @csrf
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Franchise Name</label>
                                <div class="col-sm-10">
                                    <input type="text" name="name" class="first-upper form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name')}}">
                                    @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}.</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Sub Name</label>
                                <div class="col-sm-6">
                                    <input type="text" name="subname" class="first-upper form-control {{ $errors->has('subname') ? ' is-invalid' : '' }}" placeholder="" value="{{ old('subname')}}">
                                    @if ($errors->has('subname'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('subname') }}.</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-sm-4">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input {{ $errors->has('image') ? ' is-invalid' : '' }}" name="image">
                                        <label class="custom-file-label" for="customFile">Select image</label>
                                        @if ($errors->has('image'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('image') }}.</strong>
                                        </span>
                                        @endif 
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Cost</label>
                                <div class="col-sm-4">
                                    <input type="text" name="cost" class="form-control {{ $errors->has('cost') ? ' is-invalid' : '' }}"  value="{{ old('cost')}}">
                                    @if ($errors->has('cost'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('cost') }}.</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-sm-3">
                                    <input type="text" name="discount" class="form-control {{ $errors->has('discount') ? ' is-invalid' : '' }}" placeholder="" value="{{ old('discount')}}">
                                    @if ($errors->has('discount'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('discount') }}.</strong>
                                    </span>
                                    @endif
                                </div>
                            
                                <!-- <label class="col-sm-2 col-form-label">Cost/Fee</label> -->
                                                          
                                
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Details</label>
                                <div class="col-sm-10">
                                    <textarea name="details" id="detail" class="form-control {{ $errors->has('details') ? ' is-invalid' : '' }}">{{ old('details')}}</textarea>
                                    @if ($errors->has('details'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('details') }}.</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            
                            
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary float-right">Submit</button>
                        </div>
                    </form>
                      
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="{{ asset('js/eachWordUpper.js') }}"></script>
<script src="{{ asset('js/summernote.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#detail').summernote({
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['fontname', ['fontname']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['view', ['fullscreen', 'codeview']],
                ],
        });
    });
  </script>
  <script type="text/javascript">
$(document).ready(function () {
  bsCustomFileInput.init();
});
</script>
@endsection

