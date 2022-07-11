@extends('admin.layouts.backend')
@push('styles')
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
@endpush
@section('content')
@php
   if(auth()->user()->hasRole('super_admin')){
    $url = 'notifications.sent';
   }
   else if(auth()->user()->hasRole('Franchise-Admin')){
    $url = 'customer.notifications.sent';
   }
   else{
    $url = 'notifications.sent';
   }
    
   
@endphp

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Sent Notifications</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Notifications</a></li>
                    <li class="breadcrumb-item active">Sent Notifications</li>
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
                <h3 class="card-title">List of Sent Notifications</h3>
                <div class="card-tools">
                  @can('notification-add')
                  <a class="btn btn-primary btn-sm"  href="{{ route('notifications.create') }}">New Notification</a>
                  @endcan
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                
       
                <div class="table-responsive mailbox-messages">
                  <table class="table table-hover table-striped" id="user-datatable">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Subject</th>
                        <th>Message</th>
                        <th>Delivered At</th>
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
<!-- <script type="text/javascript" src="{{ asset('plugins/toastr/toastr.min.js') }}"></script> -->
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
    
    var url = '{!! route($url) !!}';
        var table = $('#user-datatable').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: url,
            
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
                    data: 'delivered at',
                    name: 'delivered at'
                },
                {
                    data: 'action',
                    name: 'action',
                    width: '10%'
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