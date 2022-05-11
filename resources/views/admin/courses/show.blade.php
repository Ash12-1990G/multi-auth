@extends('admin.layouts.backend')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Show</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('courses.index') }}">Courses</a></li>
                    <li class="breadcrumb-item active">Show</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                @if (\Session::has('success'))
                <div class="alert alert-success">
                    <p>{{ \Session::get('success') }}</p>
                </div>
                @endif
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Course Informations</h3>
                    </div>
                    <div class="card-body">
                        <div class="post">
                            <div class="user-block">
                                <!-- <img class="img-circle img-bordered-sm" src="../../dist/img/user7-128x128.jpg" alt="User Image"> -->
                                <div class="username ml-0">
                                    <h4 class="text-primary">
                                        {{ $course->name }}
                                    </h4>
                                    <h6> Course Fee <span class="badge badge-pill badge-danger"><i class="fas fa-rupee-sign"></i> {{ $course->price }}</span></h6>
                                </div>
                                
                            </div>
                            <!-- /.user-block -->
                            <div class="description">
                                <h6 class="text-grey font-weight-bold">Description</h6>
                                <p>
                                {{ $course->description }}
                                </p>
                            </div>
                            <div class="syllabus">
                                <h6 class="text-grey font-weight-bold">Syllabus</h6>
                                <p>
                                {!! $course->syllabus->description !!}
                                </p>
                            </div>
                            
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection