@extends('admin.layouts.backend')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Edit Customer</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('customers.index') }}">Customers</a></li>
                    <li class="breadcrumb-item active">Edit Customer</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<div class="content">
    <div class="container-fluid">
    <form class="g-3" id="customerForm">
                    @csrf
                    @method('PATCH')
        <div class="row">
            <div class="col-lg-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Edit customer</h3>
                    </div>
                    
                        <div class="card-body row ">
                            
                            <div class="form-group col-12">
                                <label class="form-label">Owner/Customer Name</label>
                                <input type="input" name="cust_name" class="form-control {{ $errors->has('cust_name') ? ' is-invalid' : '' }}"  value="{{old('cust_name',$customer->cust_name)}}" placeholder="Required">
                                @if ($errors->has('cust_name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('cust_name') }}.</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group col-12">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}"  value="{{old('email',$customer->users->email)}}" placeholder="Required">
                                @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}.</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group col-6">
                                <label for="inputPhone4" class="form-label">Phone</label>
                                <input type="text" name="phone" class="form-control {{ $errors->has('phone') ? ' is-invalid' : '' }}"  value="{{old('phone',$customer->phone)}}" placeholder="Required">
                                @if ($errors->has('phone'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('phone') }}.</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group col-6">
                                <label for="inputPhone4" class="form-label">Alt Phone</label>
                                <input type="text" name="alt_phone" class="form-control {{ $errors->has('alt_phone') ? ' is-invalid' : '' }}"  value="{{old('alt_phone',$customer->alt_phone)}}">
                                @if ($errors->has('alt_phone'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('alt_phone') }}.</strong>
                                </span>
                                @endif
                            </div>
                            
                            
                        </div>
                </div>
                <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Location/Postal Address</h3>
                        </div>
                    
                        <div class="card-body row ">
                        
                            <div class="form-group col-12">
                                
                                <label  class="form-label">Address</label>
                                
                                <textarea name="address"  class="form-control {{ $errors->has('address') ? ' is-invalid' : '' }}" placeholder="Required">{{old('address',$customer->address)}}</textarea>
                                @if ($errors->has('address'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('address') }}.</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group col-6">
                                
                                <label  class="form-label">City</label>
                                
                                <input type="text" name="city"  class="first-upper form-control {{ $errors->has('city') ? ' is-invalid' : '' }}"  value="{{old('city',$customer->city)}}" placeholder="Required">
                                @if ($errors->has('city'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('city') }}.</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group col-3">
                                    
                                <label  class="form-label">State</label>
                                
                                <input type="text" name="state"  class="first-upper form-control {{ $errors->has('state') ? ' is-invalid' : '' }}"  value="{{old('state',$customer->state)}}" placeholder="Required">
                                @if ($errors->has('state'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('state') }}.</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group col-3">
                                
                                <label  class="form-label">Pincode </label>
                                
                                <input type="text" name="pincode"  class="form-control {{ $errors->has('pincode') ? ' is-invalid' : '' }}"  value="{{old('pincode',$customer->pincode)}}" placeholder="Required">
                                @if ($errors->has('pincode'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('pincode') }}.</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
            </div>
            <div class="col-lg-6">
            <div class="card card-danger">
                    <div class="card-header">
                        <h3 class="card-title">Instistute/Center Information</h3>
                    </div>
                    
                    <div class="card-body row ">
                        <div class="form-group col-12">
                            <label>Institute Name</label>
                            <input type="text" class="first-upper form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name',$customer->users->name)}}">
                            @if ($errors->has('name'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('name') }}.</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group col-12">
                                <label  class="form-label">Start-up Location
                                <button type="button"class="btn btn-outline-primary btn-sm" onclick="getCordinates(event);">Check the distance </button></label>
                                <input type="hidden" name="latitude" id="latitude" value="{{$customer->latitude}}">
                                <input type="hidden" name="longitude" id="longitude" value="{{$customer->longitude}}">
                                <textarea name="location" id="location" rows="5" class="form-control {{ $errors->has('location') ? ' is-invalid' : '' }}" placeholder="Required">{{old('location',$customer->location)}}</textarea>
                                
                                @if ($errors->has('location'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('location') }}.</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                </div>

        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-primary mb-2">Submit</button>
        </div>
    </form>
    </div>
</div>
@endsection
@section('scripts')
<script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
<script src="{{ asset('js/eachWordUpper.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/sweetalert.js') }}"></script>
<script type="text/javascript">
    const GEO_API_KEY = @json(config('services.geocodeapify.key'));
    
    async function doAjax(lat,lon) {
        let result;

        try {
            result = await $.ajax({
                url: '{!! route('customers.locationcheck') !!}',
                type: 'GET',
                dataType:'json',
                data: {latitude:lat,longitude:lon},
            });
            return result;
        } catch (error) {
           
        }
    }
    async function getCordinates(e){
        e.preventDefault();
        $('#app').append('<div class="overlay"><div class="overlay__inner"><div class="overlay__content"><span class="spinner"></span></div></div></div>');
        var requestOptions = {
            method: 'GET',
            headers: {
                'Content-Type': 
                    'application/json;charset=utf-8'
            },
        };
        document.getElementById('latitude').value=lat;
        document.getElementById('longitude').value=lon;
        var location = document.getElementById('location').value;
        if(location!==''){
            try{
                const response = await fetch("https://api.geoapify.com/v1/geocode/search?text="+location+"&limit=1&format=json&apiKey="+GEO_API_KEY, requestOptions);
             
                if (response.ok) {
                    var data = await response.json();
                    var lat = data['results'][0]['lat'];
                    var lon = data['results'][0]['lon'];
                    document.getElementById('latitude').value=lat;
                    document.getElementById('longitude').value=lon;
                    var result = await doAjax(lat,lon);
                    if(result['status']=='success'){
                        tosterMessage('success',result['message']);
                    }
                    else{
                        tosterMessage('error',result['message']);
                    }

                }
                else{
                    
                    tosterMessage('error',"HTTP-Error: " + response.status);
                }
            } catch (error) {
            }
            
        }
        else{
            tosterMessage('error',"Please, type some text in the location field");
        }
        $(".overlay").remove();
    }
    async function checkCoordinates(){
        $('#app').append('<div class="overlay"><div class="overlay__inner"><div class="overlay__content"><span class="spinner"></span></div></div></div>');
        let lat = '';
        let lon = '';
        var location = document.getElementById('location').value;
        if(location!==''){
            try{
                var requestOptions = {
                    method: 'GET',
                    headers: {
                        'Content-Type': 
                            'application/json;charset=utf-8'
                    },
                };
                const response = await fetch("https://api.geoapify.com/v1/geocode/search?text="+location+"&limit=1&format=json&apiKey="+GEO_API_KEY, requestOptions);
                if (response.ok) {
                    var data = await response.json();
                    lat = data['results'][0]['lat'];
                     lon = data['results'][0]['lon'];
                     document.getElementById('latitude').value=lat;
                    document.getElementById('longitude').value=lon;
                }
                
            } catch (error) {
                //console.error(error);
            }  
        }
        $(".overlay").remove();
        return [lat,lon];
    }
</script>
<script type="text/javascript">

    $('#customerForm').on('submit',async function(event){
    event.preventDefault();
    const [lat,lon] = await checkCoordinates();
    
    const boxes = Array.from(document.getElementsByClassName('is-invalid'));

    boxes.forEach(box => {
    // ✅ Remove class from each element
    box.classList.remove('is-invalid');

    // ✅ Add class to each element
    // box.classList.add('small');
    });

    $.ajaxSetup({
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });
    var data = Array.from(document.querySelectorAll("#customerForm input, #customerForm textarea, #customerForm select")).reduce((acc,input)=>({...acc,[input.name]:input.value}),{});
    if(lat!='' && lon!=''){
        data['latitude']=lat;
        data['longitude']=lon;
    }
    
    $.ajax({
        url: '{!! route('customers.update',$customer->id) !!}',
        type:"PATCH",
        data:data,
        beforeSend: function(){
        $('#app').append('<div class="overlay"><div class="overlay__inner"><div class="overlay__content"><span class="spinner"></span></div></div></div>');
        },
        success:function(response){
        var ele ;
        $.each(response.errors, function(key, value){
            
            
            ele = document.getElementsByName(key);   
            $(ele).addClass('is-invalid');
            $(ele).after('<span class="invalid-feedback" role="alert"><strong>'+value[0]+'</strong></span>');
        });
        if(response.success){
            swal("Great job!",response.success,'success').then((value)=>{
                window.location.href = "{{ route('customers.index')}}";
            });
        }
        
        $(".overlay").remove();
        },
        error: function(response) {
        swal("Oops!","Error has occur",'warning');
        }
        });
    });
</script>
@if($msg = session('warning'))
<script type="text/javascript">
  swal("","{!! $msg !!}",'warning');
</script>
@endif
@endsection

