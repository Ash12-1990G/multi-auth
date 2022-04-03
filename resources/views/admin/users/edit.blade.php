@extends('admin.layouts.backend')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">New User</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Users</a></li>
                    <li class="breadcrumb-item active">New User</li>
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
                        <h3 class="card-title">Add new user</h3>
                    </div>
                    
                    
                      
                    <form class="g-3" action={{route('users.update',$user->id)}} method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label text-right">Name</label>
                                <div class="col-sm-8">
                                    <div class="input-group mb-3">
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name',$user->name) }}"  placeholder="{{ __('Name') }}" required autocomplete="name" autofocus>
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                            <span class="fas fa-user"></span>
                                            </div>
                                        </div>
                                        @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                    </div>
                                </div> 
                            </div>
                            
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label text-right">Email</label>
                                <div class="col-sm-8">
                                    <div class="input-group mb-3">
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email',$user->email) }}" placeholder="{{ __('Email Address') }}" required autocomplete="email">
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                            <span class="fas fa-envelope"></span>
                                            </div>
                                        </div>
                                        @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label text-right">Role</label>
                                <div class="col-sm-4">
                                    
                                    <select class="select2" multiple="multiple" data-placeholder="Select Role" name="roles[]" style="width:100%">
                                    @if(!empty($roles))
                                        @foreach($roles as $role)
                                        <option value="{{ $role->id }}" {{ in_array($role->id, old('roles', $userRole)) ? 'selected' : '' }}>{{ $role->name }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                   
                                    
                                    
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-center">
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
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
<script type="text/javascript">
  $('.select2').select2();
</script>
@endsection