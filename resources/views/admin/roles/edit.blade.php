@extends('admin.layouts.backend')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Edit Role</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Configuration</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Roles</a></li>
                    <li class="breadcrumb-item active">Edit Role</li>
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
                        <h3 class="card-title">Add a new role</h3>
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
                    {!! Form::model($role, ['route' => ['roles.update', $role->id],'method' => 'PATCH']) !!}
                        <div class="card-body">
                            <div class="form-group">
                                <label>Name</label>
                                {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                                <!-- <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email"> -->
                            </div>
                            <div class="form-group">
                                <label>Assign Permissions <span class="float-right text-primary px-2">{{ Form::checkbox('all_permission', 'all', false, array('class' => '')) }} Select All</span></label>
                                <br>
                                <div class="row">
                                    @foreach($permission as $value)
                                
                                    <div class="col-4">
                                        <div class="form-check">
                                    
                                    {{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions) ? true : false, array('class' => 'name form-check-input permission')) }}
                                             <label class="form-check-label">{{ $value->name }}</label>
                                        </div>  
                                    </div>
                                @endforeach
                                </div>
                                <!-- <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password"> -->
                            </div>
                        </div>
                        <div class="card-footer">
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