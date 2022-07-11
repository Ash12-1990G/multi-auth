@extends('admin.layouts.backend')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Franchise</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('customers.index')}}">Customers</a></li>
                    <li class="breadcrumb-item active">Franchise</li>
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
                <h3 class="card-title">{{ $customer_data->users->name}} (<span class="text-danger">{{ $customer_data->center_code}}</span>)</h3>
                <div class="card-tools">
                @can('customer-franchise-add')
                <a class="btn btn-primary btn-sm"  href="{{ route('customer_franchise.create',['customer'=>$customer_id]) }}">Add Franchise</a>
                
                @endcan
                </div>

              </div>
              <!-- /.card-header -->
              <div class="card-body">
              
                <table class="table table-striped" id="user-datatable">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Franchise</th>
                      <th>Total Amount</th>
                      <th>Due</th>
                      <th>Payment Option</th>
                      <th>Payment status</th>
                      <th>Service Starts </th>
                      <th>Service Ends</th>
                      <th>Action</th>
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
      <div class="modal" id="EditConcessionModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Product Edit</h4>
                    <button type="button" class="close modelClose" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="alert alert-success alert-dismissible fade show" role="alert" style="display: none;">
                        <strong>Success!</strong>Product was added successfully.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div id="EditConcessionModalBody">
                        
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="SubmitEditProductForm">Update</button>
                    <button type="button" class="btn btn-danger modelClose" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
      </div>
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
            ajax:'{!! route('customer_franchise.index',['customer'=>$customer_id]) !!}',
            
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
                    data: 'total amount',
                    name: 'total amount'
                },
                {
                    data: 'due',
                    name: 'due'
                },
                {
                    data: 'payment option',
                    name: 'payment option'
                },
                {
                    data: 'payment status',
                    name: 'payment status'
                },
                {
                    data: 'service starts',
                    name: 'service starts'
                },
                {
                    data: 'service ends',
                    name: 'service ends'
                },
                {
                    data: 'action',
                    name: 'action'
                },
            ],
            "drawCallback": function(settings) {
                initAfterDraw();
            }
        });
  });
  $('.modelClose').on('click', function(){
            $('#EditConcessionModal').modal('hide');
        });
        var id;
        function callModal(e,data){
            e.preventDefault();
            $('.alert-danger').html('');
            $('.alert-danger').hide();
        //console.log(data);
            id = data;
    
        
            $.ajax({
                url: "/admin/customer/taken_franchise/"+id+"/concession",
                method: 'GET',
                // data: {
                //     id: id,
                // },
                beforeSend: function(){
                    // things to do before
                    $("#loader").show();
                },
                success: function(result) {
                    console.log(result);
                    $('#EditConcessionModalBody').html(result.html);
                    $('#EditConcessionModal').modal("show");
                },
                complete:function(data){
                    // Hide image container
                    $("#loader").hide();
                }
            });
        }
        function initAfterDraw() {
                // Update product Ajax request.
            $('#SubmitEditProductForm').click(function(e) {
                e.preventDefault();
                $(':submit').attr('disabled', 'disabled');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "/admin/customer/taken_franchise/"+id+"/concession",
                    method: 'PUT',
                    data: {
                        concession: $('#editConcession').val(),
                    },
                    beforeSend: function(){
                            // things to do before
                            $("#loader").show();
                    },
                    success: function(result) {
                        if(result.errors) {
                            $('.alert-danger').html('');
                            console.log(result.errors);
                            $.each(result.errors, function(key, value) {
                                $('.alert-danger').show();
                                $('.alert-danger').append('<strong><li>'+value+'</li></strong>');
                            });

                        } else {
                            $('.alert-danger').hide();
                            $('.alert-success').show();
                            $('#user-datatable').DataTable().ajax.reload();
                            setInterval(function(){ 
                                $('.alert-success').hide();
                                $('#EditConcessionModal').hide();
                                $(':submit').attr('enabled', 'enabled');
                                location.reload();
                            }, 2000);
                        }
                    },
                    complete:function(data){
                            // Hide image container
                            $("#loader").hide();
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            });
        }
</script>
@if($msg = session('success'))
<script type="text/javascript">
  swal("Great job!","{{$msg}}",'success');
</script>
@endif
@if($msg = session('warning'))
<script type="text/javascript">
  swal("Attention!","{{$msg}}",'warning');
</script>
@endif
@endsection