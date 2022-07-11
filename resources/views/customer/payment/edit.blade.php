@extends('admin.layouts.backend')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">{{$payment->courseStudents->students->users->name}}</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('customer.students.index')}}">Students</a></li>
                <li class="breadcrumb-item"><a href="{{ route('customer.studentcourses.index',['student_id'=>$payment->courseStudents->student_id]) }}"> Course</a></li>
                <li class="breadcrumb-item"><a href="{{ route('student.payment.index',['courseid'=>$payment->course_student_id]) }}"> Payment</a></li>
                    <li class="breadcrumb-item active">Edit Payment</li>
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
        <h4><b>Franchise: </b><span class="text-danger">{{$payment->courseStudents->courses->name}} ({{$payment->courseStudents->courses->course_code}})</span></h4>
    <form class="form-normal g-3" action="{{route('student.payment.update',['paymentid'=>$payment->id])}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
        <div class="row ">
            <div class="col-lg-12">
             
                <div class="card card-primary">
                    <div class="card-header card-header-custom">
                        <h3 class="card-title">Edit Payment</h3>
                    </div>
                    
                        <div class="card-body row ">
                            <div class="form-group col-lg-6 col-sm-12">
                                
                                <label>Enter Amount</label>
                                <input class="form-control {{ $errors->has('paid') ? ' is-invalid' : '' }}" name="paid" value="{{old('paid',$payment->paid)}}" disabled required>
                                    
                                @if ($errors->has('paid'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('paid') }}.</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group col-lg-6 col-sm-12">
                            
                                <label  class="form-label">Payment Date</label>
                                
                                <input type="text" name="p_date" id="datepicker" class="form-control {{ $errors->has('p_date') ? ' is-invalid' : '' }}"  value="{{old('p_date',$payment->p_date)}}">
                                @if ($errors->has('p_date'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('p_date') }}.</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group col-12">
                                <label  class="form-label">Payment Remarks</label>
                                <textarea class="form-control {{ $errors->has('remarks') ? ' is-invalid' : '' }}" name="remarks">{{old('remarks',$payment->remarks)}}</textarea>
                                @if ($errors->has('remarks'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('remarks') }}.</strong>
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

<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>

<script type="text/javascript">
  $(function() {
    $( "#datepicker" ).daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        minYear: 1901,
        maxYear: parseInt(moment().format('YYYY'),10),
        maxDate:new Date(),
        locale: {
        format: 'YYYY-MM-DD'
        }
    });    
  });
  </script>
  <script type="text/javascript">
    $(document).ready(function () {
    bsCustomFileInput.init();
    });
</script>
@endsection