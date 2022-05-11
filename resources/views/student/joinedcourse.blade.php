@extends('admin.layouts.backend')
@section('content')
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Joined Courses</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">Joined Courses</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <div class="content">
      <div class="container-fluid">
      <div class="row d-flex align-items-stretch">
        @foreach($course as $item)
            <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch">
              <div class="card pt-2 h-100">
                <div class="card-header border-bottom-0">
                <span class="text-white bg-danger text-sm fw-bold p-1">{{ $item->courses->course_code }}</span>
                </div>
                <div class="card-body pt-0">
                  
                      <h5 class="fw-bolder text-dark">{{ $item->courses->name }}</h5>
                      <p class="text-dark mb-2"><i class="fas fa-rupee-sign"></i><b>{{ $item->price }}</b></p>
                      <p class="text-sm text-dark">{!! Str::words($item->courses->description, 15, ' ...') !!} <a href="{{ route('student.courseview',['course'=>$item->course_id,'tab'=>'description']) }}">more</a></p>
                      <div class="btn-group">
                        <a class="btn btn-sm btn-outline-secondary text-dark mr-1" href="{{ route('student.courseview',['course'=>$item->course_id,'tab'=>'ebook']) }}"><i class="far fa-fw fa-file-pdf"></i> Ebooks</a>
                        <a class="btn btn-sm btn-outline-secondary text-dark" href="{{ route('student.courseview',['course'=>$item->course_id,'tab'=>'syllabus']) }}"><i class="far fa-list-alt"></i> Syllabus</a>
                      </div>
                      
                     
                    <div class="text-right pt-3">
                    
                    <a href="{{ route('student.courseview',['course'=>$item->course_id,'tab'=>'description']) }}" class="btn btn-block btn-sm btn-primary">
                      View
                    </a>
                  </div>
                </div>
              
              </div>
            </div>
        @endforeach
        </div>
        
{{ $course->links() }}
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
@endsection