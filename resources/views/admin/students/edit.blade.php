@extends('admin.layouts.backend')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Edit Student</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('students.index') }}">Student</a></li>
                    <li class="breadcrumb-item active">Edit Student</li>
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
                        <h3 class="card-title">Edit student</h3>
                    </div>
                    
                    
                      
                    <form class="g-3" action={{ route('students.update',$user->id) }} method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                        <div class="card-body row ">
                            <div class="form-group col-6">
                                <label>Name</label>
                                <input type="text" class="first-upper form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name',$user->users->name)}}">
                                @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}.</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group col-6">
                                <label for="inputEmail4" class="form-label">Email</label>
                                <input type="email" name="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" id="inputEmail4" value="{{old('email',$user->users->email)}}">
                                @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}.</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group col-3">
                                <label for="inputPhone4" class="form-label">Phone</label>
                                <input type="text" name="phone" class="form-control {{ $errors->has('phone') ? ' is-invalid' : '' }}"  value="{{old('phone',$user->phone)}}">
                                @if ($errors->has('phone'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('phone') }}.</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group col-3">
                                <label for="inputPhone4" class="form-label">Alt Phone</label>
                                <input type="text" name="alt_phone" class="form-control {{ $errors->has('alt_phone') ? ' is-invalid' : '' }}"  value="{{old('alt_phone',$user->alt_phone)}}">
                                @if ($errors->has('alt_phone'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('alt_phone') }}.</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group col-3">
                                <label for="inputPhone4" class="form-label">Gender</label>
                                <select class="custom-select form-control {{ $errors->has('alt_phone') ? ' is-invalid' : '' }}" name="gender" required>
                                    <option value="female" {{ old('gender',$user->gender)=='female' ? 'selected' : '' }}>Female</option>
                                    <option value="male" {{ old('gender',$user->gender)=='male' ?  'selected' : '' }}>Male</option>
                                    <option value="others" {{ old('gender',$user->gender)=='others' ? 'selected' : '' }}>Others</option>
                                </select>
                                @if ($errors->has('gender'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('gender') }}.</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group col-3">
                                <label for="inputPhone4" class="form-label">Date of Birth</label>
                                <input type="text" name="birth" id="datepicker" class="form-control {{ $errors->has('birth') ? ' is-invalid' : '' }}"  value="{{old('birth',$user->birth)}}">
                                @if ($errors->has('birth'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('birth') }}.</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group col-6">
                                
                                <label  class="form-label">Father's name</label>
                                
                                <input type="text" name="father_name"  class="first-upper form-control {{ $errors->has('father_name') ? ' is-invalid' : '' }}"  value="{{old('father_name',$user->father_name)}}">
                                @if ($errors->has('father_name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('father_name') }}.</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group col-3">
                                <label  class="form-label">Admission Date</label>
                                <input type="text" name="admission" id="admission_datepicker" class="form-control {{ $errors->has('admission') ? ' is-invalid' : '' }}"  value="{{old('admission')}}">
                                @if ($errors->has('admission'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('admission') }}.</strong>
                                </span>
                                @endif
                            </div>
                          
                            <div class="form-group col-3">
                                <label  class="form-label">Upload Photo</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="image" id="customFile">
                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                </div>
                                @if ($errors->has('image'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('image') }}.</strong>
                                </span>
                                @endif
                            </div>
                            
                            <div class="form-group col-12">
                                <p class="fw-bold form-sub-heading border-bottom">Current Address</p>
                                <label  class="form-label">Address</label>
                                
                                <textarea name="address1"  class="form-control {{ $errors->has('address1') ? ' is-invalid' : '' }}">{{old('address1',$user->address1)}}</textarea>
                                @if ($errors->has('address1'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('address1') }}.</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group col-6">
                                
                                <label  class="form-label">City</label>
                                
                                <input type="text" name="city1"  class="first-upper form-control {{ $errors->has('city1') ? ' is-invalid' : '' }}"  value="{{old('city1',$user->city1)}}">
                                @if ($errors->has('city1'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('city1') }}.</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group col-3">
                                
                                <label  class="form-label">State</label>
                                
                                <input type="text" name="state1"  class="first-upper form-control {{ $errors->has('state1') ? ' is-invalid' : '' }}"  value="{{old('state1',$user->state1)}}">
                                @if ($errors->has('state1'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('state1') }}.</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group col-3">
                                
                                <label  class="form-label">Pincode</label>
                                
                                <input type="text" name="pincode1"  class="form-control {{ $errors->has('pincode1') ? ' is-invalid' : '' }}"  value="{{old('pincode1',$user->pincode1)}}">
                                @if ($errors->has('pincode1'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('pincode1') }}.</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group col-12">
                                <p class="fw-bold form-sub-heading border-bottom">Permanent Address</p>
                                <label  class="form-label">Address</label>
                                
                                <textarea name="address2"  class="form-control {{ $errors->has('address2') ? ' is-invalid' : '' }}">{{old('address2',$user->address2)}}</textarea>
                                @if ($errors->has('address2'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('address2') }}.</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group col-6">
                                
                                <label  class="form-label">City</label>
                                
                                <input type="text" name="city2"  class="first-upper form-control {{ $errors->has('city2') ? ' is-invalid' : '' }}"  value="{{old('city2',$user->city2)}}">
                                @if ($errors->has('city2'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('city2') }}.</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group col-3">
                                
                                <label  class="form-label">State</label>
                                
                                <input type="text" name="state2"  class="first-upper form-control {{ $errors->has('state2') ? ' is-invalid' : '' }}"  value="{{old('state2',$user->state2)}}">
                                @if ($errors->has('state2'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('state2') }}.</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group col-3">
                                
                                <label  class="form-label">Pincode</label>
                                
                                <input type="text" name="pincode2"  class="form-control {{ $errors->has('pincode2') ? ' is-invalid' : '' }}"  value="{{old('pincode2',$user->pincode2)}}">
                                @if ($errors->has('pincode2'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('pincode2') }}.</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                      
                </div>
            </div>
        </div>
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
        locale: {
        format: 'YYYY-MM-DD'
        }
    });
    $( "#admission_datepicker" ).daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        minYear: 1901,
        maxYear: parseInt(moment().format('YYYY'),10),
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