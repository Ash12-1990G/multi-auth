@extends('admin.layouts.backend')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">New Book</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('courses.index') }}">Courses</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ebooks.index',$course->id) }}">Books</a></li>
                    <li class="breadcrumb-item active">New Book</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
            @if ($errors->has('title'))
                {{$errors}}
            @endif
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{$course->name}}</h3>
                    </div>
                
                    <form class="form-normal g-3" action={{route('ebooks.store')}} method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" value="{{ $course->id }}" name="course_id">
                        <div class="card-body"> 
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Title</label>
                                <div class="col-sm-10">
                                    <input type="text" name="title" class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}" value="{{ old('title')}}">
                                    @if ($errors->has('title'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('title') }}.</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Author</label>
                                <div class="col-sm-10">
                                    <input type="text" name="author" class="form-control {{ $errors->has('author') ? ' is-invalid' : '' }}" placeholder="" value="{{ old('author')}}">
                                    @if ($errors->has('author'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('author') }}.</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Upload PDF</label>
                                <div class="col-sm-4">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input {{ $errors->has('bookpath') ? ' is-invalid' : '' }}" name="bookpath">
                                        <label class="custom-file-label" for="customFile">Choose file</label>
                                        @if ($errors->has('bookpath'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('bookpath') }}.</strong>
                                        </span>
                                        @endif
                                    </div>
                                    
                                    
                                </div>
                                <label class="col-sm-2 col-form-label">Upload Cover</label>
                                <div class="col-sm-4">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input {{ $errors->has('coverpath') ? ' is-invalid' : '' }}" name="coverpath">
                                        <label class="custom-file-label" for="customFile">Choose file</label>
                                        
                                        @if ($errors->has('coverpath'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('coverpath') }}.</strong>
                                        </span>
                                        @endif 
                                    </div>
                                    
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

<script type="text/javascript">
$(document).ready(function () {
  bsCustomFileInput.init();
});
</script>
@endsection

