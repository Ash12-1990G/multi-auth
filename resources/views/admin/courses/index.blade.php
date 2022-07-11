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
              <div class="card-body">
              
                <table class="table table-striped" id="user-datatable">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Name</th>
                      <th>Franchise</th>
                      <th>Price</th>
                      <th style="width: 280px">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                 
                  </tbody>
                </table>
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
<script type="text/javascript" src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}" ></script>
<script type="text/javascript" src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>


<script type="text/javascript">
  $(document).ready(function() {
  $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
        var table = $('#user-datatable').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax:'{!! route('courses.index') !!}',
            
            columns: [
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'franchise',
                    name: 'franchise'
                },
                {
                    data: 'price',
                    name: 'price'
                },
              
                {
                    data: 'action',
                    name: 'action'
                },
            ]
        });
  });
</script>
@if($msg = session('success'))
<script type="text/javascript">
  swal("Great job!","{{$msg}}",'success');
</script>
@endif
@if($msg = session('warning'))
<script type="text/javascript">
  swal("Sorry!","{{$msg}}",'error');
</script>
@endif
@endsection