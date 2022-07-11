@extends('admin.layouts.backend')
@push('styles')
<style>
    .left-img-icon{
        float: left;
        height: auto;
        width: 65px;box-shadow: 0 3px 6px rgba(0,0,0,.16),0 3px 6px rgba(0,0,0,.23)!important;border-radius:50%;    text-align: center;
        font-size: 2.8rem;
        background: #fff;
        color: #254970;
    }
</style>
@endpush
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Student Informations</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="@if(auth()->user()->hasRole('Franchise-Admin')){{ route('customer.students.index') }} @else {{ route('students.index') }} @endif">Students</a></li>
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
                            <li class="list-group-item p-1">
                                <b>Gender</b> <a class="float-right text-capitalize">{{ $student->gender}}</a>
                            </li>
                            <li class="list-group-item p-1">
                                <b>DOB</b> <a class="float-right">{{ $student->birth->format('F j, Y')}}</a>
                            </li>
                            <li class="list-group-item p-1">
                                <b>Contact</b> <a class="float-right">{{ $student->phone}} @if($student->alt_phone!==NULL)<br> {{ $student->alt_phone}} @endif</a>
                            </li>
                            <li class="list-group-item p-1">
                                <b>Admission</b> <a class="float-right">{{ Carbon\Carbon::parse($student->admission)->format('F j, Y')}}</a>
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
                        <strong><i class="fas fa-book mr-1"></i> Education Qualification</strong>
                        <p class="text-muted mb-1">{{ $student->education }}</p>
                        <hr class="m-1">
                        <strong><i class="fas fa-user mr-1"></i> Father's Name</strong>
                        <p class="text-muted mb-1">{{ $student->father_name}}</p>
                        <hr class="m-1">
                        @if($student->mother_name!=null)
                        <strong><i class="fas fa-user mr-1"></i> Mother's Name</strong>
                        <p class="text-muted mb-1">{{ $student->mother_name}}</p>
                        @endif
                        <hr class="m-1">
                        <strong><i class="fas fa-map-marker-alt mr-1"></i> Present Address</strong>
                                                      
                        <p class="text-muted mb-1">{{ $student->address1}}
                            {{ $student->city1}}
                            {{ $student->state1}}
                            {{ $student->pincode1}}</p>
                        <hr class="m-1">
                        @if($student->address2!==NULL)
                        <strong><i class="fas fa-map-marker-alt mr-1"></i> permanent Address</strong>
                                                      
                        <p class="text-muted mb-1">{{ $student->address2}}
                            {{ $student->city2}}
                            {{ $student->state2}}
                            {{ $student->pincode2}}</p>
                        @endif
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            <div class="col-md-8">
                <div class="card card-widget widget-user-2">
                    <div class="widget-user-header bg-warning">
                        <div class="widget-user-image">
                            <span class="left-img-icon"><i class="fas fa-university fa-circle"></i></span>
                        </div>
                        <h3 class="widget-user-username">Center Name: <b>{{$student->customers->users->name}}</b></h3>
                        <h5 class="widget-user-desc">Center Code: {{$student->customers->center_code}}</h5>
                    </div>
                </div>
                @if($student->courses()->count()>0)
                <div class="card">
                    <div class="card-header"><h5>Joined Courses</h5></div>
                    <div class="card-body">
                        <div class="row d-flex align-items-stretch">
                            @foreach($student->courses as $item)
                            <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch">
                                <div class="card pt-2 h-100">
                                    <div class="card-header border-bottom-0">
                                        <span class="text-white bg-danger text-sm fw-bold p-1">{{ $item->course_code }}</span>
                                    </div>
                                    <div class="card-body pt-0">
                            
                                        <h5 class="fw-bolder text-dark">{{ $item->name }}</h5>
                                        <p class="text-dark mb-2"><i class="fas fa-rupee-sign"></i><b>{{ $item->pivot->price }}</b></p>
                                        <p class="text-sm text-dark">{!! Str::words($item->description, 10, ' ...') !!} </p>
                                        <div class="btn-group">
                                            @can('ebook-list')
                                            <a class="btn btn-sm btn-outline-secondary text-dark mr-1" href="{{ route('ebooks.index',['course'=>$item->id]) }}"><i class="far fa-fw fa-file-pdf"></i> Ebooks</a>
                                            @endcan
                                            @can('syllabus-show')
                                            <a class="btn btn-sm btn-outline-secondary text-dark mr-1" href="{{ route('courses.show',$item->id) }}"><i class="far fa-list-alt"></i> Syllabus</a>
                                            @endcan
                                        
                                        
                                        </div>
                                    
                                        @can('course-show')
                                        <div class="text-right pt-3">
                                        
                                            <a href="{{ route('courses.show',$item->id) }}" class="btn btn-block btn-sm btn-primary">
                                            View
                                            </a>
                                        </div>
                                        @endcan
                                    </div>
                    
                                </div>
                            </div>
                
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection