@extends('admin.layouts.backend')
@push('styles')
<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
@endpush
@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">New Course</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('courses.index') }}">Courses</a></li>
                    <li class="breadcrumb-item active">New Course</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<div class="content">
    <div class="container-fluid">
    <form class="form-normal g-3" action="{{route('courses.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
        <div class="row">
            <div class="col-lg-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">General Information</h3>
                    </div>
                    
                        <div class="card-body">
                            <div class="form-group">
                                <label>Name</label>
                                
                                    <input type="text" name="name" class="first-upper form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name')}}">
                                    @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}.</strong>
                                    </span>
                                    @endif
                            </div>
                            
                            <div class="form-group">
                                <label>Slug</label>
                                    <input type="text" name="slug" class="form-control {{ $errors->has('slug') ? ' is-invalid' : '' }}" placeholder="" value="{{ old('slug')}}">
                                    @if ($errors->has('slug'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('slug') }}.</strong>
                                    </span>
                                    @endif
                            </div>
                            <div class="form-group">
                                <label>Franchise</label>
                                    <select name="franchise_id" class="select2 form-control {{ $errors->has('franchise_id') ? ' is-invalid' : '' }}" value="{{ old('franchise_id')}}">
                                    </select>
                                    @if ($errors->has('franchise_id'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('franchise_id') }}.</strong>
                                    </span>
                                    @endif
                                
                            </div>
                            
                            <div class="form-group">
                                <label>Price</label>
                                    <input type="text" name="price" class="form-control {{ $errors->has('price') ? ' is-invalid' : '' }}" placeholder="" value="{{ old('price')}}">
                                    @if ($errors->has('price'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('price') }}.</strong>
                                    </span>
                                    @endif
                            </div>
                            
                    </div>
                </div>
                
            </div>
            <div class="col-lg-6">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Website Information</h3>
                    </div>
                    
                    <div class="card-body">
                        <div class="form-group">
                            <label  class="form-label">Upload Photo</label>
                            <div class="custom-file">
                                <input type="file" class="image custom-file-input {{ $errors->has('image') ? ' is-invalid' : '' }}" name="image">
                                <label class="custom-file-label" for="customFile">Choose file</label>
                                @if ($errors->has('image'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('image') }}.</strong>
                                </span>
                                @endif
                            </div>
                            
                            
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                                <textarea name="description" rows="1" class="form-control {{ $errors->has('description') ? ' is-invalid' : '' }}">{{ old('description')}}</textarea>
                                @if ($errors->has('description'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('description') }}.</strong>
                                </span>
                                @endif
                        </div>
                        <div class="form-group">
                            <label>Meta-Title</label>
                                <textarea  rows="1" class="form-control {{ $errors->has('meta_title') ? ' is-invalid' : '' }}" name="meta_title">{{old('meta_title')}}</textarea>
                            
                            @if ($errors->has('meta_title'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('meta_title') }}.</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Meta-Description</label>
                                <textarea  class="form-control {{ $errors->has('meta-description') ? ' is-invalid' : '' }}" name="meta_description">{{old('meta_description')}}</textarea>
                            
                            @if ($errors->has('meta_description'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('meta_description') }}.</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="">
        <button type="submit" class="btn btn-primary float-right mb-2">Submit</button>
        </div>
        
        </form>
    </div>
</div>
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-dark" id="modalLabel">Preview </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="img-container">
            <div class="row">
                <div class="col-md-12">
                    <img id="image" class="img-fluid" src="">
                </div>
                
            </div>
        </div>
      </div>
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="crop">Crop</button>
      </div> -->
    </div>
  </div>
</div>
@endsection
@section('scripts')

<script src="{{ asset('js/eachWordUpper.js') }}"></script>
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
<script type="text/javascript">
   
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    $('.select2').select2({
        placeholder: 'Select franchise',
        ajax: {
            url: '{!! route('autosearch') !!}',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                console.log(data);
                var res = $.map(data, function (item) {
                        return {
                            text: item.display_name,
                            id: item.id,
                            selected: true,
                        }
                    })
                return {
                    
                    results: res
                    

                };
            },
            cache: true
        }
    });
    var $modal = $('#modal');
    var image = document.getElementById('image');
    // var cropper;
    $("body").on("change", ".image", function(e){
        var files = e.target.files;
        var done = function (url) {
            image.src = url;
            $modal.modal('show');
        };
        var reader;
        var file;
        var url;
        if (files && files.length > 0) {
            file = files[0];

            if (URL) {
                done(URL.createObjectURL(file));
            } else if (FileReader) {
                reader = new FileReader();
                reader.onload = function (e) {
                    done(reader.result);
                };
                reader.readAsDataURL(file);
            }
        }
    });
</script>
<script type="text/javascript">
$(document).ready(function () {
  bsCustomFileInput.init();
});
</script>
@endsection


