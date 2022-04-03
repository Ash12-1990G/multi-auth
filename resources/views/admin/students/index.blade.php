@extends('admin.layouts.backend')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Students</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Students</li>
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
                <h3 class="card-title">List of students</h3>
                <div class="card-tools">
                @can('student-add')
                <a class="btn btn-primary btn-sm"  href="{{ route('students.create') }}">New Student</a>
                @endcan
                </div>

              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
              <form class="form-inline ml-3 float-right" method="" action="{{route('students.index')}}">
              
                  <div class="input-group input-group-sm p-2">
                    <input class="form-control" name="search" type="search" placeholder="Search" aria-label="Search">
                   
                  </div>
                </form>
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Phone</th>
                      <th style="width: 280px">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    
                    @foreach ($data as $key => $user)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $user->users->name }}</td>
                                <td>{{ $user->users->email }}</td>
                                <td>{{ $user->phone }} {{ $user->alt_phone }}</td>
                                <td>
                                @can('student-show')
                                    <a class="btn btn-success btn-sm" href="{{ route('students.show',$user->id) }}">Show</a>
                                  @endcan
                                    @can('student-edit')
                                        <a class="btn btn-primary btn-sm" href="{{ route('students.edit',$user->id) }}">Edit</a>
                                    @endcan
                                    @can('student-delete')
                                        {!! Form::open(['method' => 'DELETE','route' => ['students.destroy', $user->id],'style'=>'display:inline']) !!}
                                        {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                                        {!! Form::close() !!}
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    @if($data->count()==0)
                    <tr><caption class="text-center">No results</caption></tr>
                    @endif
                  </tbody>
                </table>
                {{ $data->links() }}
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