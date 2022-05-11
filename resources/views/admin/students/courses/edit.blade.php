@extends('admin.layouts.backend')
@push('styles')
<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">

@endpush
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Edit Course</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('students.index')}}">Students</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('studentcourses.index',['student_id'=>$data->student_id]) }}">Student Courses</a></li>
                    <li class="breadcrumb-item active">Edit Course</li>
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
    <form class="g-3" action={{route('studentcourse.update',$data->id)}} method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
        <div class="row">
            <div class="col-lg-6">
             
                <div class="card card-primary">
                    <div class="card-header card-header-custom">
                        <h3 class="card-title">Select Course</h3>
                    </div>
                    
                        <div class="card-body row ">
                            <div class="form-group col-12">
                                <input type="hidden" name="student_id" value="{{ $data->student_id }}">
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
                                <input type="text" name="start_date" id="datepicker" class="form-control {{ $errors->has('start_date') ? ' is-invalid' : '' }}"  value="{{old('start_date',$data->start_date)}}">
                                @if ($errors->has('start_date'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('start_date') }}.</strong>
                                </span>
                                @endif
                            
                        </div>
                        <div class="form-group col-6">
                            
                            <label  class="form-label">Price</label>
                            
                            <input type="number" name="price" id="price" class="form-control {{ $errors->has('price') ? ' is-invalid' : '' }}"  value="{{old('price',$data->price)}}" min="1">
                            @if ($errors->has('price'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('price') }}.</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center">
        <button type="submit" class="btn btn-primary btn-sm mb-2">Submit</button>
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
//binding select event on option select so that price field populate
$('.custom-select').on('select2:select', function (e) { 
    var data = e.params.data;
    var ele = document.getElementById('price');
    ele.value = '';
    $.ajax({
        type: 'GET',
        url: '{!! route('student_course.selected') !!}',
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
            console.log(data);
        }
    });

});
//auto selection select2 via ajax
$('.custom-select').select2({
    placeholder: 'Select course',
    allowClear: true,
    maximumInputLength: 20,
    
    ajax: {
            url: '{!! route('studentcourses.autosearch',$data->student_id) !!}',
            dataType: 'json',
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
  //pre selected course value 
  var data = {
    "id": '{!! $data->courses->id !!}',
        "text": "{{ $data->courses->name }}",
        "selected": true,
    }
  
    var newOption = new Option(data.text, data.id, true, true);
  $('.custom-select').append(newOption).trigger('change');
  </script>
  <script type="text/javascript">
    $(document).ready(function () {
    bsCustomFileInput.init();
    });
</script>
@endsection