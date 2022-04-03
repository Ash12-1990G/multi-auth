@extends('admin.layouts.backend')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Franchises</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active">Franchises</li>
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
                <h3 class="card-title">List of franchise</h3>
                <div class="card-tools">
                @can('franchise-add')
                <a class="btn btn-primary btn-sm"  href="{{ route('franchises.create') }}">New Franchise</a>
                @endcan
                </div>

              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
              <form class="form-inline ml-3 float-right" method="" action="{{route('franchises.index')}}">
              
                  <div class="input-group input-group-sm p-2">
                    <input class="form-control" name="search" type="search" placeholder="Search" aria-label="Search">
                   
                  </div>
                </form>
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Franchise</th>
                      <th>Duration</th>
                      <th>Cost</th>
                      <th>Discount(in %)</th>
                      <th style="width: 280px">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  @if($data->count()>0) 
                    @foreach ($data as $key => $item)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td><span class="text-primary">{{ $item->name }}</span><br>
                                <span class="text-muted">{{ $item->subname }}</span></td>
                                <td>
                                <span class="text-danger font-weight-bold">{{ $item->service_period }} {{ $item->service_interval }}</span>
                                </td>
                                <td><span class="text-success font-weight-bold"><i class="fas fa-rupee-sign"></i> {{ $item->cost }}</span></td>
                                <td><span class="text-danger font-weight-bold">@if($item->discount!=0){{ $item->discount }}
                                  @endif </span>
                                </td>
                                <td>
                              
                                  
                               
                                @can('franchise-show')
                                    <a class="btn btn-success btn-sm" href="{{ route('franchises.show',$item->id) }}">Show</a>
                                    @endcan
                                    @can('franchise-edit')
                                        <a class="btn btn-primary btn-sm" href="{{ route('franchises.edit',$item->id) }}">Edit</a>
                                    @endcan
                                    @can('franchise-delete')
                                        {!! Form::open(['method' => 'DELETE','route' => ['franchises.destroy', $item->id],'style'=>'display:inline']) !!}
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