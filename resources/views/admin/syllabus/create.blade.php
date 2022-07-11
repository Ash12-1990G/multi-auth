@extends('admin.layouts.backend')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Syllabus</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('courses.index') }}"></a>Courses</li>
                    <li class="breadcrumb-item active">Syllabus</li>
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
                        <h3 class="card-title">{{$course->name}}</h3>
                    </div>
                    <form class="form-normal g-3" action={{route('syllabus.store')}} method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" value="{{ $course->id }}" name="course_id">
                        <div class="card-body  ">
                        
                            <div class="form-group row">
                                <div class="col-12">
                                <label>Syllabus Content</label>
                                <textarea class="form-control {{ $errors->has('description') ? ' is-invalid' : '' }}" id="description" name="description">{{ old('description')}}</textarea>
                                @if ($errors->has('description'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('description') }}.</strong>
                                </span>
                                @endif
                                </div>
                            </div>
                            
                            
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                      
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#description').summernote();
    });
  </script>
@endsection

