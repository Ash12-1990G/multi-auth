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
    <form class="g-3" action={{route('courses.store')}} method="post" enctype="multipart/form-data">
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
                            <label>Description</label>
                                <textarea name="description" class="form-control {{ $errors->has('description') ? ' is-invalid' : '' }}">{{ old('description')}}</textarea>
                                @if ($errors->has('description'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('description') }}.</strong>
                                </span>
                                @endif
                        </div>
                        <div class="form-group">
                            <label>Meta-Title</label>
                                <textarea  class="form-control {{ $errors->has('meta_title') ? ' is-invalid' : '' }}" name="meta_title">{{old('meta_title')}}</textarea>
                            
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
            url: '/autosearch',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                
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
</script>
@endsection

