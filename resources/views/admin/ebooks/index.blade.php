@extends('admin.layouts.backend')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Books</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('courses.index') }}">Courses</a></li>
                    <li class="breadcrumb-item active">Books</li>
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
                <h3 class="card-title">{{$course->name}}</h3>
                <div class="card-tools">
                @can('ebooks-add')
                <a class="btn btn-primary btn-sm"  href="{{ route('ebooks.create',$course->id) }}">New Book</a>
                @endcan
                </div>

              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
              <!-- <form class="form-inline ml-3 float-right" method="" action="{{route('ebooks.index',$course->id)}}">
              
                  <div class="input-group input-group-sm p-2">
                    <input class="form-control" name="search" type="search" placeholder="Search" aria-label="Search">
                   
                  </div>
                </form> -->
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Title</th>
                      <th>Author</th>
                      <th>Book Cover</th>
                      <th style="width: 280px">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                   @if($ebook->count()>0)
                    @foreach ($ebook as $key => $item)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $item->title }}</td>
                                <td>{{ $item->author }}</td>
                                <td><img class="img-fluid" width="80" height="50" src="{{asset('storage/ebooks/'.$item->coverpath)}}"></td>
                                <td>
                              
                                  
                               
                                
                                    @can('ebook-edit')
                                        <a class="btn btn-primary btn-sm" href="{{ route('ebooks.edit',$item->id) }}">Edit</a>
                                    @endcan
                                    @can('ebook-delete')
                                        {!! Form::open(['method' => 'DELETE','route' => ['ebooks.destroy', $item->id],'style'=>'display:inline']) !!}
                                        {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
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
                {{ $ebook->links() }}
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