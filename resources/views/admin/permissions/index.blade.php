@extends('admin.layouts.backend')
@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Permissions</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Configuration</a></li>
                    <li class="breadcrumb-item active">Permissions</li>
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
                <h3 class="card-title">list of Permissions</h3>
                <div class="card-tools">
                <!-- <a class="btn btn-primary btn-sm"  href="{{ route('permissions.create') }}">New Permission</a> -->
                </div>

              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <form class="form-inline ml-3 float-right" method="get" action="{{url('search')}}">
                  <div class="input-group input-group-sm p-2">
                    <input class="form-control" name="search" type="search" placeholder="Search" aria-label="Search">
                   
                  </div>
                </form>
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Name</th>
                      <th style="width: 280px"></th>
                    </tr>
                  </thead>
                  <tbody>
                    
                    @foreach ($data as $key => $permission)
                            <tr>
                            <td>{{ ++$i }}</td>
                                <td>{{ $permission->name }}</td>
                                <td>
                                   
                                </td>
                            </tr>
                        @endforeach
                    
                  </tbody>
                </table>
                <!-- <div class="d-flex float-right p-2"> -->
                {{ $data->links() }}
                <!-- </div> -->
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