@extends('admin.layouts.backend')
@push('styles')
<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">

@endpush
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">{{$customer_name}} (<span class="text-danger">{{ $customer_code}}</span>)</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('customers.index')}}">Customers</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('customer_franchise.index',['customer'=>$data->customer_id]) }}"> Franchise</a></li>
                    <li class="breadcrumb-item active">Edit Franchise</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<div class="content">
    <div class="container-fluid">
        <div class="overlay-div" id="loader">
            <div class="overlay__inner">
                <div class="overlay__content"><span class="spinner"></span></div>
            </div>
        </div>
    <form class="form-normal g-3" action="{{route('customer_franchise.update',['id'=>$data->id])}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
        <div class="row">
            <div class="col-lg-6">
             
                <div class="card card-primary">
                    <div class="card-header card-header-custom">
                        <h3 class="card-title">Select Franchise</h3>
                    </div>
                    
                        <div class="card-body row ">
                            <div class="form-group col-12">
                                <label>Select Franchise</label>
                                <select class="custom-select form-control {{ $errors->has('franchise_id') ? ' is-invalid' : '' }}" name="franchise_id" required>
                                    <option value="">Choose Franchise</option>
                                    @if(!empty($data->franchises))
                                    <option value="{{$data->franchises->id}}" selected>{{$data->franchises->name}} ({{$data->franchises->franchise_code}})</option>
                                    @endif
                                </select>
                                @if ($errors->has('franchise_id'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('franchise_id') }}.</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group col-12">
                            
                                <label  class="form-label">Amount</label>
                                
                                <input type="number" name="amount" id="price" class="form-control {{ $errors->has('amount') ? ' is-invalid' : '' }}"  value="{{old('amount',$data->amount)}}" min="1">
                                @if ($errors->has('amount'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('amount') }}.</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group col-12">
                                <label  class="form-label">Payment Option</label>
                                <select class="payment-select form-control {{ $errors->has('payment_option') ? ' is-invalid' : '' }}" name="payment_option" required>
                                    <option value="">Choose option</option>
                                    <option value="installment" {{ (old('payment_option')=="installment" || $data->payment_option=="installment" ) ? 'selected':'' }}>Installment</option>
                                    <option value="full" {{ (old('payment_option')=="full" || $data->payment_option=="full") ? 'selected':'' }}>Full</option>
                                </select>
                                @if ($errors->has('payment_option'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('payment_option') }}.</strong>
                                </span>
                                @endif
                            </div>
                            
                        </div>
                        
                </div>
                
            </div>
            <div class="col-lg-6">
                <div class="card card-danger">
                    <div class="card-header card-header-custom">
                        <h3 class="card-title">Services</h3>
                    </div>
                    <div class="card-body row">
                        <div class="form-group col-6">
                            
                            <label  class="form-label">Service Taken</label>
                                <input type="text" name="service_taken" id="datepicker" class="form-control {{ $errors->has('service_taken') ? ' is-invalid' : '' }}"  value="{{old('service_taken',$data->service_taken)}}">
                                @if ($errors->has('service_taken'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('service_taken') }}.</strong>
                                </span>
                                @endif
                            
                        </div>
                        <div class="form-group col-6">
                            
                            <label  class="form-label">Service Ends</label>
                                <input type="text" name="service_ends" id="datepicker2" class="form-control {{ $errors->has('service_ends') ? ' is-invalid' : '' }}"  value="{{old('service_ends',$data->service_ends)}}">
                                @if ($errors->has('service_ends'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('service_ends') }}.</strong>
                                </span>
                                @endif
                            
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center">
        <button type="submit" class="btn btn-primary btn-lg mb-2">Submit</button>
        </div>
        
    </form>
    </div>
</div>

@endsection
@section('scripts')
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
<script type="text/javascript">
    var franchise_id = @json($data->franchise_id);
  $(function() {
    $( "#datepicker" ).daterangepicker({
        autoUpdateInput: false,
        showDropdowns: true,
        minYear: 1901,
        locale: {
         format: 'YYYY-MM-DD',
         cancelLabel: 'Clear'
        }
    });
    
    $('#datepicker').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('YYYY-MM-DD'));
      $('#datepicker2').val(picker.endDate.format('YYYY-MM-DD'));
  });

  $('#datepicker').on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('');
      $('#datepicker2').val('');
  });
    
  });
$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        }
});
$('.custom-select').on('select2:select', function (e) { 
    var data = e.params.data;
    var ele = document.getElementById('price');
    ele.value = '';
    $.ajax({
        type: 'GET',
        url: '{!! route('customer_franchise.selected',['customer'=>$data->customer_id]) !!}',
        
        dataType: 'json',
        beforeSend: function(){
            // things to do before
            $("#loader").show();
        },
        success: function (data) {
            //console.log(data);
            if(data.cost){
                
                ele.value = data.cost;
            }
        },
        complete:function(data){
            // Hide image container
            $("#loader").hide();
        },
        error: function (data) {
            //console.log(data);
        }
    });

});
$('.payment-select').select2({
        placeholder: 'Choose option',
        allowClear: true,
});
  $('.custom-select').select2({
    placeholder: 'Select Franchise',
    allowClear: true,
    maximumInputLength: 20,
    ajax: {
            url: '{!! route('customer_franchise.searchfranchise',['customer'=>$data->customer_id]) !!}',
            dataType: 'json',
           
            delay: 250,
            processResults: function (data) {
                //console.log(data);
                var name = '';
                var res = $.map(data, function (item) {
                    name = item.name+'('+item.franchise_code+')';
                        return {
                            text: name,
                            id: item.id,
                            selected: true,
                        }
                    })
                return {
                    
                    results: res
                    

                };
            },
            cache: true
        }
  });
  </script>
  <script type="text/javascript">
    $(document).ready(function () {
    bsCustomFileInput.init();
    });
</script>
@endsection