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
                    <li class="breadcrumb-item"><a href="{{ route('courses.index') }}">Courses</a></li>
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
                <h3 class="card-title">{{ $courses->name }} </h3>
                <div class="card-tools">
                    @if(empty($syllabus))
                    @can('syllabus-add')
                    <a class="btn btn-primary btn-sm"  href="{{ route('syllabus.create',$courses->id) }}">New Syllabus</a>
                    @endcan
                    @else
                    @can('syllabus-edit')
                    <a class="btn btn-primary btn-sm"  href="{{ route('syllabus.edit',$syllabus->id) }}">Edit Syllabus</a>
                    @endcan
                    @endif
                </div>

              </div>
              <!-- /.card-header -->
              <div class="card-body p-5">
              @if(!empty($syllabus))
                {!! $syllabus->description !!}
                @endif
              </div>
              <!-- /.card-body -->
            </div>

            
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
</div>

@endsection
@section('scripts')
<script type="text/javascript" src="{{ asset('js/sweetalert.js') }}"></script>
@if($msg = session('success'))
<script type="text/javascript">
  swal("Great job!","{{$msg}}",'success');
</script>
@endif
@endsection