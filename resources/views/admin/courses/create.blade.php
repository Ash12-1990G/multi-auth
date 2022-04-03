@extends('admin.layouts.backend')
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
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Add new course</h3>
                    </div>
                    <form class="g-3" action={{route('courses.store')}} method="post" enctype="multipart/form-data">
                    @csrf
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Name</label>
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
                                <label class="col-sm-2 col-form-label">Code</label>
                                <div class="col-sm-10">
                                    <input type="text" name="code" class="form-control {{ $errors->has('code') ? ' is-invalid' : '' }}" placeholder="" value="{{ old('code')}}">
                                    @if ($errors->has('code'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('code') }}.</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Slug</label>
                                <div class="col-sm-10">
                                    <input type="text" name="slug" class="form-control {{ $errors->has('slug') ? ' is-invalid' : '' }}" placeholder="" value="{{ old('slug')}}">
                                    @if ($errors->has('slug'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('slug') }}.</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Description</label>
                                <div class="col-sm-10">
                                    <textarea name="description" class="form-control {{ $errors->has('description') ? ' is-invalid' : '' }}">{{ old('description')}}</textarea>
                                    @if ($errors->has('description'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('description') }}.</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Price</label>
                                <div class="col-sm-10">
                                    <input type="text" name="price" class="form-control {{ $errors->has('price') ? ' is-invalid' : '' }}" placeholder="" value="{{ old('price')}}">
                                    @if ($errors->has('price'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('price') }}.</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Meta-Title</label>
                                <div class="col-sm-10">
                                    <textarea  class="form-control {{ $errors->has('meta_title') ? ' is-invalid' : '' }}" name="meta_title">{{old('meta_title')}}</textarea>
                                
                                @if ($errors->has('meta_title'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('meta_title') }}.</strong>
                                    </span>
                                @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Meta-Description</label>
                                <div class="col-sm-10">
                                    <textarea  class="form-control {{ $errors->has('meta-description') ? ' is-invalid' : '' }}" name="meta_description">{{old('meta_description')}}</textarea>
                                
                                @if ($errors->has('meta_description'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('meta_description') }}.</strong>
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
@endsection

