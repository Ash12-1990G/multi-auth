@extends('admin.layouts.backend')
@push('styles')
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css" integrity="sha256-jKV9n9bkk/CTP8zbtEtnKaKf+ehRovOYeKoyfthwbC8=" crossorigin="anonymous" /> -->
<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <style>
        .preview {
  overflow: hidden;
  width: 160px; 
  height: 160px;
  margin: 10px;
  border: 1px solid red;
}
img {
  max-width: 100%; /* This rule is very important, please do not ignore this! */
}
</style>
<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
@endpush
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Edit Student</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="@if(auth()->user()->hasRole('Franchise-Admin')){{ route('customer.students.index') }} @else {{ route('students.index') }} @endif">Student</a></li>
                    <li class="breadcrumb-item active">Edit Student</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<div class="content">
    <div class="container-fluid">
        <form class="form-normal g-3" action="@if(auth()->user()->hasRole('Franchise-Admin')){{ route('customer.students.update',$user->id) }} @else {{ route('students.update',$user->id) }} @endif" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
            <div class="row">
                <div class="col-lg-6">
                    
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">General</h3>
                        </div>
                        
                            <div class="card-body row ">
                                <div class="form-group col-6">
                                    <label>Name</label>
                                    <input type="text" class="first-upper form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name',$user->users->name)}}" placeholder="Required">
                                    @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}.</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group col-6">
                                    <label  class="form-label">Admission Date</label>
                                    <input type="text" name="admission" id="admission_datepicker" class="form-control {{ $errors->has('admission') ? ' is-invalid' : '' }}"  value="{{old('admission',$user->admission)}}" placeholder="Required">
                                    @if ($errors->has('admission'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('admission') }}.</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group col-6">
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
                                <div class="form-group col-6">
                                    <label for="inputPhone4" class="form-label">Date of Birth</label>
                                    <input type="text" name="birth" id="datepicker" class="form-control {{ $errors->has('birth') ? ' is-invalid' : '' }}"  value="{{old('birth',$user->birth)}}" placeholder="Required">
                                    @if ($errors->has('birth'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('birth') }}.</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group col-6">
                                    
                                    <label  class="form-label">Father's name</label>
                                    
                                    <input type="text" name="father_name"  class="first-upper form-control {{ $errors->has('father_name') ? ' is-invalid' : '' }}"  value="{{old('father_name',$user->father_name)}}" placeholder="Required">
                                    @if ($errors->has('father_name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('father_name') }}.</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group col-6">
                                
                                    <label  class="form-label">Mother's name</label>
                                    
                                    <input type="text" name="mother_name"  class="first-upper form-control {{ $errors->has('mother_name') ? ' is-invalid' : '' }}"  value="{{old('mother_name',$user->mother_name)}}">
                                    @if ($errors->has('mother_name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('mother_name') }}.</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group col-6">
                                    <label for="inputPhone4" class="form-label">Education Qualification</label>
                                    <input type="text" name="education" class="form-control {{ $errors->has('education',) ? ' is-invalid' : '' }}"  value="{{old('education',$user->education)}}" placeholder="Required">
                                    @if ($errors->has('education'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('education') }}.</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group col-6">
                                    <label  class="form-label">Upload Photo</label>
                                    <div class="custom-file">
                                        <input type="file" class="image custom-file-input {{ $errors->has('image') ? ' is-invalid' : '' }}" name="image" id="customFile">
                                        <label class="custom-file-label" for="customFile">Choose file</label>
                                    
                                        @if ($errors->has('image'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('image') }}.</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                
                            </div>
                            
                        
                        
                    </div>
                    <div class="card card-success">
                        <div class="card-header card-header-custom">
                            <h3 class="card-title">Contact Details</h3>
                        </div>
                        <div class="card-body row">
                        <div class="form-group col-6">
                                    <label for="inputEmail4" class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" id="inputEmail4" value="{{old('email',$user->users->email)}}" placeholder="Required">
                                    @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}.</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group col-6">
                                    <label for="inputPhone4" class="form-label">Phone</label>
                                    <input type="text" name="phone" class="form-control {{ $errors->has('phone') ? ' is-invalid' : '' }}"  value="{{old('phone',$user->phone)}}" placeholder="Required">
                                    @if ($errors->has('phone'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('phone') }}.</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group col-6">
                                    <label for="inputPhone4" class="form-label">Alt Phone</label>
                                    <input type="text" name="alt_phone" class="form-control {{ $errors->has('alt_phone') ? ' is-invalid' : '' }}"  value="{{old('alt_phone',$user->alt_phone)}}">
                                    @if ($errors->has('alt_phone'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('alt_phone') }}.</strong>
                                    </span>
                                    @endif
                                </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card card-danger">
                        <div class="card-header card-header-custom">
                            <h3 class="card-title">Identity Proof</h3>
                        </div>
                        <div class="card-body row">
                            <div class="form-group col-6">
                                
                                <label  class="form-label">Id Type</label>
                                
                                <select type="text" name="id_type"  class="first-upper form-control {{ $errors->has('id_type') ? ' is-invalid' : '' }}"  value="{{old('id_type')}}">
                                <option value="">Choose any one</option>
                                    <option value="aadhar" {{ old('id_type') == "aadhar" ? 'selected':''}}>Aadhar Card</option>
                                    <option value="voter" {{ old('id_type') == "voter" ? 'selected':''}}>Voter Card</option>
                                    <option value="pan" {{ old('id_type') == "pan" ? 'selected':''}}>Pan Card</option>
                                    <option value="drive" {{ old('id_type') == "drive" ? 'selected':''}}>Driving License</option>
                                    <option value="passport" {{ old('id_type') == "passport" ? 'selected':''}}>Passport</option>
                                </select>
                                @if ($errors->has('id_type'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('id_type') }}.</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group col-6">
                                
                                <label  class="form-label">Id Number</label>
                                
                                <input type="text" name="id_number" class="first-upper form-control {{ $errors->has('id_number') ? ' is-invalid' : '' }}"  value="{{old('id_number')}}">
                                @if ($errors->has('id_number'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('id_number') }}.</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title">Select Center</h3>
                    </div>
                    
                    <div class="card-body row ">
                        <select class="form-control select2{{ $errors->has('customer_id') ? ' is-invalid' : '' }}" name="customer_id">
                            @if(isset($user->customers->users))
                            <option value="{{$user->customers->id}}" selected>{{$user->customers->users->name}}</option>
                            @endif
                        </select>
                        @if ($errors->has('customer_id'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('customer_id') }}.</strong>
                        </span>
                        @endif
                    </div>
                </div>
                    <div class="card card-info">
                        <div class="card-header card-header-custom">
                            <h3 class="card-title">Postal Address</h3>
                        </div>
                        <div class="card-body row">
                        <div class="form-group col-12">
                                    <p class="fw-bold form-sub-heading border-bottom">Current Address</p>
                                    <label  class="form-label">Address</label>
                                    
                                    <textarea name="address1"  class="form-control {{ $errors->has('address1') ? ' is-invalid' : '' }}" placeholder="Required">{{old('address1',$user->address1)}}</textarea>
                                    @if ($errors->has('address1'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('address1') }}.</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group col-6">
                                    
                                    <label  class="form-label">City</label>
                                    
                                    <input type="text" name="city1"  class="first-upper form-control {{ $errors->has('city1') ? ' is-invalid' : '' }}"  value="{{old('city1',$user->city1)}}" placeholder="Required">
                                    @if ($errors->has('city1'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('city1') }}.</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group col-3">
                                    
                                    <label  class="form-label">State</label>
                                    
                                    <input type="text" name="state1"  class="first-upper form-control {{ $errors->has('state1') ? ' is-invalid' : '' }}"  value="{{old('state1',$user->state1)}}" placeholder="Required">
                                    @if ($errors->has('state1'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('state1') }}.</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group col-3">
                                    
                                    <label  class="form-label">Pincode</label>
                                    
                                    <input type="text" name="pincode1"  class="form-control {{ $errors->has('pincode1') ? ' is-invalid' : '' }}"  value="{{old('pincode1',$user->pincode1)}}" placeholder="Required">
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
                    </div>
                </div>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary btn-lg mb-2">Submit</button>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-dark" id="modalLabel">Preview </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="img-container">
            <div class="row">
                <div class="col-md-12">
                    <img id="image" class="img-fluid" src="">
                </div>
                
            </div>
        </div>
      </div>
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="crop">Crop</button>
      </div> -->
    </div>
  </div>
</div>
@endsection
@section('scripts')
<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
                
@if(auth()->user()->hasRole('Franchise-Admin'))
<script type="text/javascript">
    $('.select2').select2({
        placeholder: 'Select Center',
        
    });
</script>

@else

<script type="text/javascript">
    $('.select2').select2({
        placeholder: 'Select Center',
        allowClear: true,
        ajax: {
            url: '{!! route('student.customersearch') !!}',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                console.log(data);
                var fullname='';
                var res = $.map(data, function (item) {
                    fullname = item.users.name+" ("+item.center_code+")";
                        return {
                            text: fullname,
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
  @endif
  <script>

    var $modal = $('#modal');
    var image = document.getElementById('image');
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
    // var cropper;
    $("body").on("change", ".image", function(e){
        var files = e.target.files;
        var done = function (url) {
            image.src = url;
            $modal.modal('show');
        };
        var reader;
        var file;
        var url;
        if (files && files.length > 0) {
            file = files[0];

            if (URL) {
                done(URL.createObjectURL(file));
            } else if (FileReader) {
                reader = new FileReader();
                reader.onload = function (e) {
                    done(reader.result);
                };
                reader.readAsDataURL(file);
            }
        }
    });

//     $modal.on('shown.bs.modal', function () {
//         cropper = new Cropper(image, {
//             aspectRatio: 1,
//             viewMode: 3,
//             cropBoxResizable:false,
//             toggleDragModeOnDblclick: false,
//             preview: '.preview'
//         });
//     }).on('hidden.bs.modal', function () {
//         cropper.destroy();
//         cropper = null;
//     });

//     $("#crop").click(function(){
//         canvas = cropper.getCroppedCanvas({
// 	        width: 160,
// 	        height: 160,
//         });

//         canvas.toBlob(function(blob) {
//             url = URL.createObjectURL(blob);
//             var reader = new FileReader();
//             reader.readAsDataURL(blob); 
//             reader.onloadend = function() {
//             var base64data = reader.result;	
//             console.log(base64data);
//             // $.ajax({
//             //     type: "POST",
//             //     dataType: "json",
//             //     url: "image-cropper/upload",
//             //     data: {'_token': $('meta[name="_token"]').attr('content'), 'image': base64data},
//             //     success: function(data){
//             //         $modal.modal('hide');
//             //         alert("success upload image");
//             //     }
//             // });
//          }
//     });
// })
 </script>
  <script type="text/javascript">
    $(document).ready(function () {
    bsCustomFileInput.init();
    });
</script>
@endsection