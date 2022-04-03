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
                        <dl class="row">
                            <dt class="col-sm-4">Name</dt>
                            <dd class="col-sm-8">{{ $course->name }}</dd>
                            <dt class="col-sm-4">Code</dt>
                            <dd class="col-sm-8">
                            {{ $course->code }}
                            </dd>
                            <dt class="col-sm-4">Slug</dt>
                            <dd class="col-sm-8">
                            {{ $course->slug }}
                            </dd>
                            <dt class="col-sm-4">Price</dt>
                            <dd class="col-sm-8">
                            Rs {{ $course->price }}
                            </dd>
                            <dt class="col-sm-4">Description</dt>
                            <dd class="col-sm-8">
                            {{ $course->description }}
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection