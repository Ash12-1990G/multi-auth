@extends('admin.layouts.backend')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Notifications</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Notifications</a></li>
                    <li class="breadcrumb-item active">Notifications</li>
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
                <h3 class="card-title">List of Notifications</h3>
                <div class="card-tools">
                  @can('notification-add')
                  <a class="btn btn-primary btn-sm"  href="{{ route('notifications.create') }}">New Notification</a>
                  @endcan
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <div class="mailbox-controls">
                
                <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="far fa-square"></i>
                </button>
                <div class="btn-group">
                  @can('notification-read')
                  <button type="button" class="btn btn-default btn-sm delete-notification" for="Delete"><i class="far fa-trash-alt"></i></button>
                  @endcan
                  @can('notification-delete')
                  <button type="button" class="btn btn-default btn-sm read-notification" for="Read"><i class="fas fa-book"></i></button>
                  @endcan
                </div>
              </div>
                <div class="table-responsive mailbox-messages">
                  <table class="table table-hover table-striped" id="user-datatable">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Subject</th>
                        <th>Message</th>
                        <th>Read</th>
                        <th>Arrive At</th>
                        <th>
                          Action
                      </th>
                      </tr>
                    </thead>
                    <tbody>
                      
                     
                      
                    </tbody>
                  </table>
                </div>
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
<script type="text/javascript" src="{{ asset('js/custom.js') }}"></script>
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
            ajax:'{!! route('notifications.index') !!}',
            
            columns: [
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'subject',
                    name: 'subject'
                },
                {
                    data: 'message',
                    name: 'message'
                },
                {
                    data: 'read',
                    name: 'read'
                },
                {
                    data: 'arrive at',
                    name: 'arrive at'
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
@elseif($msg = session('warning'))
<script type="text/javascript">
  swal("","{{ $msg }}",'warning');
</script>
@endif
@endsection