@extends('admin.layouts.backend')
@push('styles')
<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
<style>
    .select2-container{
        width:100% !important;
        }
</style>
@endpush
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">New Notification</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('notifications.index') }}">Notifications</a></li>
                    <li class="breadcrumb-item active">New Notification</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
            <form class="form-normal" action={{route('notifications.store')}} method="post">
            @csrf
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">New Notice</h3>
                </div>
              <!-- /.card-header -->
                <div class="card-body">
                <!-- @if (\Session::has('errors'))
                <div class="alert alert-success">
                    <p>{{ \Session::get('errors') }}</p>
                </div>
                @endif -->
                    <div class="row">
                        <div class="form-group col-md-8">
                        
                        <select class="select2 form-control {{ $errors->has('customers') ? ' is-invalid' : '' }}" placeholder="To:" name="customers[]" multiple="multiple">
                               
                            <option value="1">Select All Customers</option>
                           
                        </select>
                       
                        
                        @if ($errors->has('customers'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('customers') }}.</strong>
                                </span>
                               
                                @endif
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input {{ $errors->has('students') ? ' is-invalid' : '' }}" type="checkbox" id="customCheckbox9" name="students" {{ old('students')=='true' ? 'checked' : '' }}>
                                    <label for="customCheckbox9" class="custom-control-label">All Students</label>
                                    @if ($errors->has('students'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('students') }}.</strong>
                                </span>
                                @endif
                                </div>
                            
                            </div>
                            
                        </div>
                        <div class="form-group col-md-12">
                        <input class="form-control {{ $errors->has('subject') ? ' is-invalid' : '' }}" placeholder="Subject:" name="subject" value="{{ old('subject') }}">
                        @if ($errors->has('subject'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('subject') }}.</strong>
                                </span>
                                @endif
                        </div>
                        <div class="form-group col-md-12">
                        <textarea class="form-control {{ $errors->has('message') ? ' is-invalid' : '' }}" placeholder="write here" name="message">{{ old('subject') }}</textarea>
                        @if ($errors->has('message'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('message') }}.</strong>
                                </span>
                                @endif
                        </div>
                    </div>
                
               
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <div class="float-right">
                  <button type="submit" class="btn btn-primary"><i class="far fa-envelope"></i> Send</button>
                </div>
                
              </div>
              <!-- /.card-footer -->
            </div>
              
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')


<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>

@if($msg = session('success'))
<script type="text/javascript">
  tosterMessage('success',"{{$msg}}")
 
</script>
@endif
@if($msg = session('warning'))
<script type="text/javascript">
  tosterMessage('error',"{{$msg}}")
 
</script>
@endif
<script type="text/javascript">
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
var customers = [];
</script>
@if (is_array(old('customers')))
<script type="text/javascript">
customers = @json(old('customers'));
if(customers.length>0){
    if(customers.includes(1)){
        var newOption = new Option('Select all the customer', 1, false, true);
                        $('.select2').append(newOption).trigger('change');
    }
    else{
        $.ajax({
            type:'GET',
            url: '{!! route('notifications.searchbycustomer') !!}',
            dataType:'json',
            data:{itemselect: customers},
        }).then(function (data) {
            console.log(data);
        var res = $.map(data, function (item) {
                cname=item.customers['cust_name']+' ('+item.name+'-'+item.customers['center_code']+')';
                
                return {
                    text: cname,
                    id: item.id,
                    selected: true,
                };
            });
            
            studentSelect.select2({
        placeholder: 'Select Customers',
    multiple: true,
        ajax: {
            url: '{!! route('notifications.searchbycustomer') !!}',
            dataType: 'json',
            delay: 250,
            
            processResults: function (data) {
                var cname = '';
                console.log(data);
                    var i=0;
                    var vals=[];
               res = $.map(data, function (item) {
                    //console.log(item.customers['center_code']);
                            cname=item.customers['cust_name']+' ('+item.name+'-'+item.customers['center_code']+')';
                        if(i===0){
                            i++;
                        return vals=  [{
                                text: 'Select all the customer',
                                id: 1,
                                selected: false,
                            },
                            {
                                text: cname,
                                id: item.id,
                                selected: false,
                            }];
                            
                        }
                        
                        if(i>0){
                            i++;
                                return {
                                text: cname,
                                id: item.id,
                                selected: false,
                            }
                        }
                        
                    });
                    console.log(res); 
                return {
                    
                    results: res
                    

                };
            },
            cache: true
        },
        data:res,
    }).trigger('change');
           
        });
        
    }
}

</script>

@endif

<script type="text/javascript">
    var studentSelect = $('.select2');
    studentSelect.select2({
        placeholder: 'Select Customers',
    multiple: true,
        ajax: {
            url: '{!! route('notifications.searchbycustomer') !!}',
            dataType: 'json',
            delay: 250,
            
            processResults: function (data) {
                var cname = '';
                console.log(data);
                    var i=0;
                    var vals=[];
               res = $.map(data, function (item) {
                    //console.log(item.customers['center_code']);
                            cname=item.customers['cust_name']+' ('+item.name+'-'+item.customers['center_code']+')';
                        if(i===0){
                            i++;
                        return vals=  [{
                                text: 'Select all the customer',
                                id: 1,
                                selected: false,
                            },
                            {
                                text: cname,
                                id: item.id,
                                selected: false,
                            }];
                            
                        }
                        
                        if(i>0){
                            i++;
                                return {
                                text: cname,
                                id: item.id,
                                selected: false,
                            }
                        }
                        
                    });
                    console.log(res); 
                return {
                    
                    results: res
                    

                };
            },
            cache: true
        }
    }).on("select2:select", function (e) { 
           var data = e.params.data.id;
           if(data===1){
              
            $('.select2 > option[value!="1"]').prop("selected",false);
            $(".select2").trigger("change");
           }
           else{
            $('.select2 > option[value="1"]').prop("selected",false);
            $(".select2").trigger("change");
           }
      });
</script>

@endsection