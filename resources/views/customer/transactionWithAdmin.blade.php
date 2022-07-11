@extends('admin.layouts.backend')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Transaction with Admin</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="{{ route('customer.franchises') }}">Franchises</a></li>
                  <li class="breadcrumb-item active">Transaction with Admin</li>
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
              <div class="card-body">
              
                <table class="table table-striped" id="user-datatable">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Franchise</th>
                      <th>Paid</th>
                      <th>Paid Date</th>
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
            ajax:'{!! route('customer.transactionwithadmin') !!}',

            
            columns: [
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'franchise',
                    name: 'franchise'
                },
                {
                    data: 'paid',
                    name: 'paid'
                },
                {
                    data: 'paid date',
                    name: 'paid date'
                },
               
         
            ]
        });
  });
</script>

@endsection