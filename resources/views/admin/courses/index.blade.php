@extends('admin.layouts.backend')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Courses</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active">Courses</li>
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
                <h3 class="card-title">List of Course</h3>
                <div class="card-tools">
                @can('course-add')
                <a class="btn btn-primary btn-sm"  href="{{ route('courses.create') }}">New course</a>
                @endcan
                </div>

              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
              <form class="form-inline ml-3 float-right" method="" action="{{route('courses.index')}}">
              
                  <div class="input-group input-group-sm p-2">
                    <input class="form-control" name="search" type="search" placeholder="Search" aria-label="Search">
                   
                  </div>
                </form>
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Name</th>
                      <th>Code</th>
                      <th>Price</th>
                      <th style="width: 280px">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  @if($data->count()>0) 
                    @foreach ($data as $key => $item)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->code }}</td>
                                <td>{{ $item->price }}</td>
                                <td>
                              
                                  @can('syllabus-show')
                                  <a class="btn btn-secondary btn-sm mb-1" href="{{ route('syllabus.show',$item->id) }}">Syllabus</a>
                                  @endcan
                                  @can('ebook-list')
                                  <a class="btn btn-secondary btn-sm mb-1" href="{{ route('ebooks.index',$item->id) }}">Books</a>
                                  @endcan
                               
                                @can('course-show')
                                    <a class="btn btn-success btn-sm mb-1" href="{{ route('courses.show',$item->id) }}">Show</a>
                                    @endcan
                                    @can('course-edit')
                                        <a class="btn btn-primary btn-sm mb-1" href="{{ route('courses.edit',$item->id) }}">Edit</a>
                                    @endcan
                                    @can('course-delete')
                                        {!! Form::open(['method' => 'DELETE','route' => ['courses.destroy', $item->id],'style'=>'display:inline']) !!}
                                        {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm mb-1']) !!}
                                        {!! Form::close() !!}
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                      @else
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