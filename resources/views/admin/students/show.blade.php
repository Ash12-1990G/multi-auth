@extends('admin.layouts.backend')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Student Informations</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('students.index') }}">Students</a></li>
                    <li class="breadcrumb-item active">Show</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            @if($student->image!=null)
                            <img class="profile-user-img img-fluid img-circle" src="{{ asset('storage/students/' . $student->image) }}" alt="User profile picture">
                            @endif
                        </div>

                        <h3 class="profile-username text-center">{{ $student->users->name }}</h3>

                        <p class="text-muted text-center">{{ $student->users->email }}</p>

                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>DOB</b> <a class="float-right">{{ $student->birth->format('F j, Y')}}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Contact</b> <a class="float-right">{{ $student->phone}} @if($student->phone!==NULL)<br> {{ $student->phone}} @endif</a>
                            </li>
                            
                        </ul>
                        
                        <!-- <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a> -->
                    </div>
                    
                    
                </div>
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">About</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <strong><i class="fas fa-user mr-1"></i> Father's Name</strong>
                        <p class="text-muted">{{ $student->father_name}}</p>
                        <hr>
                        <strong><i class="fas fa-map-marker-alt mr-1"></i> Present Address</strong>
                                                      
                        <p class="text-muted">{{ $student->address1}}
                            {{ $student->city1}}
                            {{ $student->state1}}
                            {{ $student->pincode1}}</p>
                            <hr>
                        @if($student->address2!==NULL)
                        <strong><i class="fas fa-map-marker-alt mr-1"></i> permanent Address</strong>
                                                      
                        <p class="text-muted">{{ $student->address2}}
                            {{ $student->city2}}
                            {{ $student->state2}}
                            {{ $student->pincode2}}</p>
                        @endif
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection