@extends('admin.layouts.backend')
@push('styles')
<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">

@endpush
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Add Course</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    @if(auth()->user()->hasRole('Franchise-Admin'))
                    <li class="breadcrumb-item"><a href="{{route('customer.students.index')}}">Students</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('customer.studentcourses.index',['student_id'=>$data->id]) }}">Student Courses</a></li>
                    @else
                    <li class="breadcrumb-item"><a href="{{route('students.index')}}">Students</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('studentcourses.index',['student_id'=>$data->id]) }}">Student Courses</a></li>
                    @endif
                    
                    <li class="breadcrumb-item active">Add Course</li>
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
    <form class="form-normal g-3" action="@if(auth()->user()->hasRole('Franchise-Admin')){{route('customer.studentcourses.store')}} @else {{route('studentcourse.store')}} @endif" method="post" enctype="multipart/form-data">
                    @csrf
        <div class="row">
            <div class="col-lg-6">
             
                <div class="card card-primary">
                    <div class="card-header card-header-custom">
                        <h3 class="card-title">Center & Course</h3>
                    </div>
                    
                        <div class="card-body row ">
                            <div class="form-group col-12">
                                <input type="hidden" name="student_id" value="{{ $data->id }}">
                                <label>Select Center</label>
                                <select class="center-select form-control {{ $errors->has('customer_id') ? ' is-invalid' : '' }}" name="customer_id" required>
                                    <option value="">Choose Center</option>
                                </select>
                                @if ($errors->has('customer_id'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('customer_id') }}.</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group col-12">
                                
                                <label>Select Course</label>
                                <select class="custom-select form-control {{ $errors->has('course_id') ? ' is-invalid' : '' }}" name="course_id" required>
                                    <option value="">Choose courses</option>
                                </select>
                                @if ($errors->has('course_id'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('course_id') }}.</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        
                </div>
                
            </div>
            <div class="col-lg-6">
                <div class="card card-danger">
                    <div class="card-header card-header-custom">
                        <h3 class="card-title">Other Details</h3>
                    </div>
                    <div class="card-body row">
                        <div class="form-group col-6">
                            
                            <label  class="form-label">Starting From</label>
                                <input type="text" name="start_date" id="datepicker" class="form-control {{ $errors->has('start_date') ? ' is-invalid' : '' }}"  value="{{old('start_date')}}">
                                @if ($errors->has('start_date'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('start_date') }}.</strong>
                                </span>
                                @endif
                            
                        </div>
                        <div class="form-group col-6">
                            
                            <label  class="form-label">Price</label>
                            
                            <input type="number" name="price" id="price" class="form-control {{ $errors->has('price') ? ' is-invalid' : '' }}"  value="{{old('price')}}" min="1">
                            @if ($errors->has('price'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('price') }}.</strong>
                            </span>
                            @endif
                        </div>
                        
                        <div class="form-group col-12">
                            
                            <label  class="form-label">Payment option</label>
                            
                            <select name="payment_option" class="form-control {{ $errors->has('payment_option') ? ' is-invalid' : '' }}"  >
                                <option value="installment" {{old('payment_option')=='installment' ? 'selected':''}}>Installment</option>
                                <option value="full" {{old('payment_option')=='full' ? 'selected':''}}>Full</option>
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
@if(auth()->user()->hasRole('Franchise-Admin'))
<script type="text/javascript">
var dataUrl = '{!! route('customer.student_course.selected') !!}';
var courseUrl = '{!! route('customer.studentcourses.autosearch',$data->id) !!}';
var centerUrl = '{!! route('customer.studentcourses.customersearch') !!}';
</script>
@else
<script type="text/javascript">
var dataUrl = '{!! route('student_course.selected') !!}';
var courseUrl = '{!! route('studentcourses.autosearch',$data->id) !!}';
var centerUrl = '{!! route('studentcourses.customersearch') !!}';
</script>
@endif
<script type="text/javascript">
    var customer_id = "{{$data->customer_id}}";
  $(function() {
    $( "#datepicker" ).daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        minYear: 1901,
        maxYear: parseInt(moment().format('YYYY'),10),
        locale: {
        format: 'YYYY-MM-DD'
        }
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
        url: dataUrl,
        data: data,
        dataType: 'json',
        beforeSend: function(){
            // things to do before
            $("#loader").show();
        },
        success: function (data) {
            //console.log(data);
            if(data.price){
                
                ele.value = data.price;
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
$('.center-select').on('select2:select', function (e) { 
    var data = e.params.data;
   
    $('.custom-select').select2({
        placeholder: 'Select course',
        allowClear: true,
        maximumInputLength: 20,
        ajax: {
                url: courseUrl,
                dataType: 'json',
                data:data,
                delay: 250,
                processResults: function (data) {
                    //console.log(data);
                    var res = $.map(data, function (item) {
                            return {
                                text: item.fullcourse,
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
});
var cust = {
    "id": '{!! $data->customer_id !!}',
        "text": "{{ $data->customers->users->name }}",
        "selected": true,
    };
   
var newOption1 = new Option(cust.text, cust.id, true, true);
  $('.center-select').append(newOption1).trigger('change.select2');
  $('.center-select').trigger({
    type: 'select2:select',
    params: {
        data: cust
    }
});
  $('.center-select').select2({
    placeholder: 'Select Center',
    allowClear: true,
    maximumInputLength: 20,
    ajax: {
            url: centerUrl,
            dataType: 'json',
            data:{customer_id:customer_id},
            delay: 250,
            processResults: function (data) {
                console.log(data);
                var name = '';
                var res = $.map(data, function (item) {
                    name = item.users['name']+'('+item.center_code+')';
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