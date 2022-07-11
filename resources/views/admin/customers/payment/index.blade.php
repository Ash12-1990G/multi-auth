@extends('admin.layouts.backend')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"></h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('customers.index')}}">Customers</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('customer_franchise.index',['customer'=>$details->customers->id]) }}"> Franchise</a></li>
                    <li class="breadcrumb-item active"> Payment</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-4">
           <div class="card card-primary card-outline">
              <div class="card-body box-profile">
               
              @php 
              $installment = number_format( (float)$details->amount/6,2);
              $due = $details->amount - $paid;
              @endphp
                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Total Amount</b> <a class="float-right"><i class="fas fa-rupee-sign"></i> {{$details->amount}}</a>
                  </li>
                  <li class="list-group-item">
                    <b>Total Due</b> <a class="float-right"><i class="fas fa-rupee-sign"></i> {{$due}}</a>
                  </li>
                  @if($details->payment_option=='installment')
                  <li class="list-group-item">
                    <b>Installment</b> <a class="float-right"><i class="fas fa-rupee-sign"></i> {{$installment}}/monthly</a>
                  </li>
                  @php
                  $installmnt_dates[1]=$details->service_taken;
                    for($i=2;$i<=5;$i++){
                      $installmnt_dates[$i]= Carbon\Carbon::parse($details->service_taken)->addMonths($i)->format('Y-m-d');
                    }
                    
                  @endphp
                  <li class="list-group-item">
                   
                    <b>Last Installment</b> <a class="float-right">{{Carbon\Carbon::parse($installmnt_dates[5])->format('F j, Y')}}</a>
                   
                  </li>
                  
                  <li class="list-group-item">
                    <b>Total installment </b> <a class="float-right">06</a>
                  </li>
                  @endif
                </ul>

              </div>
              <!-- /.card-body -->
            </div>
          </div>
          <div class="col-lg-8">
          
          <div class="card">
              <div class="card-header">
                <h5 class="card-title">{{$details->customers->users->name}} (<b>Franchise: </b><span class="text-danger">{{$details->franchises->name}} ({{$details->franchises->franchise_code}})</span>)</h5>
                
                <div class="card-tools">
                @can('customer-payment-add')
                <a class="btn btn-primary btn-sm"  href="{{ route('customer.payment.create',$details->id) }}">Add Payment</a>
                
                @endcan
                
                </div>
                
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              
                <table class="table table-striped" id="user-datatable">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Paid</th>
                      <th>Paid Date</th>
                      <th>remarks</th>
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
            ajax:'{!! route('customer.payment.index',$details->id) !!}',
            
            columns: [
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'paid',
                    name: 'paid'
                },
                {
                    data: 'paid date',
                    name: 'paid date'
                },
                {
                    data: 'remarks',
                    name: 'remarks'
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
  swal("Attention!","{{$msg}}",'warning');
</script>
@endif
@endsection