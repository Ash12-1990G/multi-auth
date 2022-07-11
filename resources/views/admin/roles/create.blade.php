@extends('admin.layouts.backend')
@push('styles')
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
<style>
    #checkmain{
        background-color: #fff;
        background-position: 50%;
        background-repeat: no-repeat;
        background-size: contain;
        border: 1px solid #d8d6de;
        color-adjust: exact;
        height: 1.285rem;
        margin-top: 0.0825rem;
        vertical-align: top;
        width: 1.285rem;
    }
    .icheck-primary label{
        color:#898484;
    }
</style>
@endpush
@section('content')
@php
 $permissionlist['role'] = ['title'=>'Role Management'];  
 $permissionlist['permission'] = ['title'=>'Permission Management'];
 $permissionlist['course'] = ['title'=>'Course Management'];
 $permissionlist['customer'] = ['title'=>'Customer Management'];
 $permissionlist['ebook'] = ['title'=>'Ebook Management'];
 $permissionlist['franchise'] = ['title'=>'Franchise Management'];
 $permissionlist['customer-franchise'] = ['title'=>'Customer Franchise Management'];
 $permissionlist['customer-payment'] = ['title'=>'Customer Payment Management'];                                          
 $permissionlist['student'] = ['title'=>'Student Management'];
 $permissionlist['student-course'] = ['title'=>'Student Course Management'];
 $permissionlist['notification'] = ['title'=>'Notification Management'];
 $permissionlist['syllabus'] = ['title'=>'Syllabus Management'];
 $permissionlist['review'] = ['title'=>'Review Management'];
 $permissionlist['user'] = ['title'=>'User Management'];
foreach($permission as $value){
    if($value->name=='role-list' || $value->name=='role-create' ||$value->name=='role-edit' || $value->name=='role-delete' || $value->name=='role-show'){
        if($value->name=='role-list'){
            $permissionlist['role']['list']  = $value->id;
        }
        else if($value->name=='role-create'){
            $permissionlist['role']['create']  = $value->id;
        }
        else if($value->name=='role-edit'){
            $permissionlist['role']['edit']  = $value->id;
        } 
        else if($value->name=='role-delete'){
            $permissionlist['role']['delete']  = $value->id;
        }
        else if($value->name=='role-show'){
            $permissionlist['role']['show']  = $value->id;
        }  
      
        
        
    }
    if($value->name=='permission-list' || $value->name=='permission-create' ||$value->name=='permission-edit' || $value->name=='permission-delete' || $value->name=='permission-show'){
        
        if($value->name=='permission-list'){
            $permissionlist['permission']['list']  = $value->id;
        }
        else if($value->name=='permission-create'){
            $permissionlist['permission']['create']  = $value->id;
        }
        else if($value->name=='permission-edit'){
            $permissionlist['permission']['edit']  = $value->id;
        } 
        else if($value->name=='permission-delete'){
            $permissionlist['permission']['delete']  = $value->id;
        }
        else if($value->name=='permission-show'){
            $permissionlist['permission']['show']  = $value->id;
        }  
    }
    if($value->name=='student-list' || $value->name=='student-add' ||$value->name=='student-edit' || $value->name=='student-delete' || $value->name=='student-show'){
        if($value->name=='student-list'){
            $permissionlist['student']['list']  = $value->id;
        }
        else if($value->name=='student-add'){
            $permissionlist['student']['create']  = $value->id;
        }
        else if($value->name=='student-edit'){
            $permissionlist['student']['edit']  = $value->id;
        } 
        else if($value->name=='student-delete'){
            $permissionlist['student']['delete']  = $value->id;
        }
        else if($value->name=='student-show'){
            $permissionlist['student']['show']  = $value->id;
        }
    }
    if($value->name=='customer-list' || $value->name=='customer-add' ||$value->name=='customer-edit' || $value->name=='customer-delete' || $value->name=='customer-show'){
        
        if($value->name=='customer-list'){
            $permissionlist['customer']['list']  = $value->id;
        }
        else if($value->name=='customer-add'){
            $permissionlist['customer']['create']  = $value->id;
        }
        else if($value->name=='customer-edit'){
            $permissionlist['customer']['edit']  = $value->id;
        } 
        else if($value->name=='customer-delete'){
            $permissionlist['customer']['delete']  = $value->id;
        }
        else if($value->name=='customer-show'){
            $permissionlist['customer']['show']  = $value->id;
        }
    }
    if($value->name=='course-list' || $value->name=='course-add' ||$value->name=='course-edit' || $value->name=='course-delete' || $value->name=='course-show'){
        if($value->name=='course-list'){
            $permissionlist['course']['list']  = $value->id;
        }
        else if($value->name=='course-add'){
            $permissionlist['course']['create']  = $value->id;
        }
        else if($value->name=='course-edit'){
            $permissionlist['course']['edit']  = $value->id;
        } 
        else if($value->name=='course-delete'){
            $permissionlist['course']['delete']  = $value->id;
        }
        else if($value->name=='course-show'){
            $permissionlist['course']['show']  = $value->id;
        }
    }
    if($value->name=='ebook-list' || $value->name=='ebook-add' ||$value->name=='ebook-edit' || $value->name=='ebook-delete' || $value->name=='ebook-show'){
        if($value->name=='ebook-list'){
            $permissionlist['ebook']['list']  = $value->id;
        }
        else if($value->name=='ebook-add'){
            $permissionlist['ebook']['create']  = $value->id;
        }
        else if($value->name=='ebook-edit'){
            $permissionlist['ebook']['edit']  = $value->id;
        } 
        else if($value->name=='ebook-delete'){
            $permissionlist['ebook']['delete']  = $value->id;
        }
        else if($value->name=='ebook-show'){
            $permissionlist['ebook']['show']  = $value->id;
        }
    }
    if($value->name=='customer-payment-list' || $value->name=='customer-payment-add' ||$value->name=='customer-payment-edit' || $value->name=='customer-payment-delete' || $value->name=='customer-payment-show'){
       
        if($value->name=='customer-payment-list'){
            $permissionlist['customer-payment']['list']  = $value->id;
        }
        else if($value->name=='customer-payment-add'){
            $permissionlist['customer-payment']['create']  = $value->id;
        }
        else if($value->name=='customer-payment-edit'){
            $permissionlist['customer-payment']['edit']  = $value->id;
        } 
        else if($value->name=='customer-payment-delete'){
            $permissionlist['customer-payment']['delete']  = $value->id;
        }
        else if($value->name=='customer-payment-show'){
            $permissionlist['customer-payment']['show']  = $value->id;
        }
    }
    if($value->name=='customer-franchise-list' || $value->name=='customer-franchise-add' ||$value->name=='customer-franchise-edit' || $value->name=='customer-franchise-delete' || $value->name=='customer-franchise-show'){
        
        if($value->name=='customer-franchise-list'){
            $permissionlist['customer-franchise']['list']  = $value->id;
        }
        else if($value->name=='customer-franchise-add'){
            $permissionlist['customer-franchise']['create']  = $value->id;
        }
        else if($value->name=='customer-franchise-edit'){
            $permissionlist['customer-franchise']['edit']  = $value->id;
        } 
        else if($value->name=='customer-franchise-delete'){
            $permissionlist['customer-franchise']['delete']  = $value->id;
        }
        else if($value->name=='customer-franchise-show'){
            $permissionlist['customer-franchise']['show']  = $value->id;
        }
    }
    if($value->name=='franchise-list' || $value->name=='franchise-add' ||$value->name=='franchise-edit' || $value->name=='franchise-delete' || $value->name=='franchise-show'){
        
        if($value->name=='franchise-list'){
            $permissionlist['franchise']['list']  = $value->id;
        }
        else if($value->name=='franchise-add'){
            $permissionlist['franchise']['create']  = $value->id;
        }
        else if($value->name=='franchise-edit'){
            $permissionlist['franchise']['edit']  = $value->id;
        } 
        else if($value->name=='franchise-delete'){
            $permissionlist['franchise']['delete']  = $value->id;
        }
        else if($value->name=='franchise-show'){
            $permissionlist['franchise']['show']  = $value->id;
        }
    }
    
    
    if($value->name=='notification-list' || $value->name=='notification-add' ||$value->name=='notification-edit' || $value->name=='notification-delete' || $value->name=='notification-show'){
        if($value->name=='notification-list'){
            $permissionlist['notification']['list']  = $value->id;
        }
        else if($value->name=='notification-add'){
            $permissionlist['notification']['create']  = $value->id;
        }
        else if($value->name=='notification-edit'){
            $permissionlist['notification']['edit']  = $value->id;
        } 
        else if($value->name=='notification-delete'){
            $permissionlist['notification']['delete']  = $value->id;
        }
        else if($value->name=='notification-show'){
            $permissionlist['notification']['show']  = $value->id;
        }
    }
    if($value->name=='review-show'){
        $permissionlist['review']['show']  = $value->id;
    }
    
    if($value->name=='user-list' || $value->name=='user-create' ||$value->name=='user-edit' || $value->name=='user-delete' || $value->name=='user-show'){
      
        if($value->name=='user-list'){
            $permissionlist['user']['list']  = $value->id;
        }
        else if($value->name=='user-add'){
            $permissionlist['user']['create']  = $value->id;
        }
        else if($value->name=='user-edit'){
            $permissionlist['user']['edit']  = $value->id;
        } 
        else if($value->name=='user-delete'){
            $permissionlist['user']['delete']  = $value->id;
        }
        else if($value->name=='user-show'){
            $permissionlist['user']['show']  = $value->id;
        }
    }
    
    if($value->name=='syllabus-list' || $value->name=='syllabus-add' ||$value->name=='syllabus-edit' || $value->name=='syllabus-delete' || $value->name=='syllabus-show'){
        
        if($value->name=='syllabus-list'){
            $permissionlist['syllabus']['list']  = $value->id;
        }
        else if($value->name=='syllabus-add'){
            $permissionlist['syllabus']['create']  = $value->id;
        }
        else if($value->name=='syllabus-edit'){
            $permissionlist['syllabus']['edit']  = $value->id;
        } 
        else if($value->name=='syllabus-delete'){
            $permissionlist['syllabus']['delete']  = $value->id;
        }
        else if($value->name=='syllabus-show'){
            $permissionlist['syllabus']['show']  = $value->id;
        }
    }
    
    if($value->name=='student-course-list' || $value->name=='student-course-add' ||$value->name=='student-course-edit' || $value->name=='student-course-delete' || $value->name=='student-course-show'){
       
        if($value->name=='student-course-list'){
            $permissionlist['student-course']['list']  = $value->id;
        }
        else if($value->name=='student-course-add'){
            $permissionlist['student-course']['create']  = $value->id;
        }
        else if($value->name=='student-course-edit'){
            $permissionlist['student-course']['edit']  = $value->id;
        } 
        else if($value->name=='student-course-delete'){
            $permissionlist['student-course']['delete']  = $value->id;
        }
        else if($value->name=='student-course-show'){
            $permissionlist['student-course']['show']  = $value->id;
        }
    }
}


@endphp
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">New Role</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Configuration</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Roles</a></li>
                    <li class="breadcrumb-item active">New Role</li>
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
                        <h3 class="card-title">Add new role</h3>
                    </div>
                    <div class="card-body">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <strong>Opps!</strong> Something went wrong, please check below errors.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    {!! Form::open(array('route' => 'roles.store','method'=>'POST','class' => 'form-normal')) !!}
                        <div class="card-body">
                            <div class="form-group">
                                <label>Name</label>
                                {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                                <!-- <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email"> -->
                            </div>
                            <div class="form-group">
                                <label>Assign Permissions <span class="float-right text-primary px-2">{{ Form::checkbox('all_permission', 'all', false, array('id' => 'checkmain','class' => '')) }} Select All</span></label>
                                <br>
                                <div class="row">
                                <div class="col-12">
                                        <div class="table-responsive">
                                            <table class="table table-flush-spacing">
                                                <tbody>
                                                    
                                                    
                                                @foreach($permissionlist as $permission)
                                                    @if(isset($permission['create']) || isset($permission['edit']) ||isset( $permission['delete']) || isset($permission['list']) || isset($permission['show']))
                                                    <tr>
                                                        <td class="text-nowrap fw-bolder">{{$permission['title']}}</td>
                                                        <td>
                                                        <div class="d-flex">
                                                        @if(isset($permission['create']))
                                                            <div class="icheck-primary my-0 mr-3">
                                                            {{ Form::checkbox('permission[]',$permission['create'],false,array('id'=>'check'.$permission['create'],'class' => 'name form-check-input permission')) }}
                                                                <label class="form-check-label" for="check{{$permission['create']}}">Add</label>
                                                            </div>
                                                        @endif
                                                        @if(isset($permission['edit']))
                                                            <div class="icheck-primary my-0 mr-3">
                                                            {{ Form::checkbox('permission[]', $permission['edit'],false, array('id'=>'check'.$permission['edit'],'class' => 'name form-check-input permission')) }}
                                                                <label class="form-check-label" for="check{{$permission['edit']}}">Edit</label>
                                                            </div>
                                                        @endif
                                                        @if(isset($permission['delete']))
                                                            <div class="icheck-primary my-0 mr-3">
                                                            {{ Form::checkbox('permission[]', $permission['delete'],false, array('id'=>'check'.$permission['delete'],'class' => 'name form-check-input permission')) }}
                                                                <label class="form-check-label" for="check{{$permission['delete']}}">Delete</label>
                                                            </div>
                                                        @endif
                                                        @if(isset($permission['list']))
                                                            <div class="icheck-primary mr-3">
                                                            {{ Form::checkbox('permission[]', $permission['list'],false,array('id'=>'check'.$permission['list'],'class' => 'name form-check-input permission')) }}
                                                                <label class="form-check-label" for="check{{$permission['list']}}">List</label>
                                                            </div>
                                                        @endif
                                                        @if(isset($permission['show']))
                                                            <div class="icheck-primary my-0 mr-3">
                                                            {{ Form::checkbox('permission[]', $permission['show'],false, array('id'=>'check'.$permission['show'],'class' => 'name form-check-input permission')) }}
                                                                
                                                                <label class="form-check-label" for="check{{$permission['show']}}">Show</label>
                                                            </div>
                                                        @endif 
                                                        </div>
                                                        </td>
                                                    </tr>
                                                    @endif
                                                @endforeach
                                  
                                                </tbody>
                                            </table>
                                        </div>
                                    
                                    </div>
                                </div>
                                <!-- <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password"> -->
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')
    <script type="text/javascript" src="{{ asset('js/custom.js')}}"></script>
@endsection