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
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Edit customer</h3>
                    </div>
                    <form class="g-3" action={{route('customers.update',$customer->id)}} method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                        <div class="card-body row ">
                            <div class="form-group col-6">
                                <label>Name</label>
                                <input type="text" class="first-upper form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name',$customer->users->name)}}">
                                @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}.</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group col-6">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}"  value="{{old('email',$customer->users->email)}}">
                                @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}.</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group col-6">
                                <label for="inputPhone4" class="form-label">Phone</label>
                                <input type="text" name="phone" class="form-control {{ $errors->has('phone') ? ' is-invalid' : '' }}"  value="{{old('phone',$customer->phone)}}">
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
                            <div class="form-group col-12">
                                <p class="fw-bold form-sub-heading border-bottom  text-primary">Start-up Location</p>
                                <label  class="form-label">Location</label>
                                
                                <textarea name="location"  class="form-control {{ $errors->has('location') ? ' is-invalid' : '' }}">{{old('location')}}</textarea>
                                @if ($errors->has('location'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('location') }}.</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group col-12">
                                <p class="fw-bold form-sub-heading border-bottom  text-primary">Customer's Address</p>
                                <label  class="form-label">Address</label>
                                
                                <textarea name="address"  class="form-control {{ $errors->has('address') ? ' is-invalid' : '' }}">{{old('address',$customer->address)}}</textarea>
                                @if ($errors->has('address'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('address') }}.</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group col-6">
                                
                                <label  class="form-label">City</label>
                                
                                <input type="text" name="city"  class="first-upper form-control {{ $errors->has('city') ? ' is-invalid' : '' }}"  value="{{old('city',$customer->city)}}">
                                @if ($errors->has('city'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('city') }}.</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group col-3">
                                
                                <label  class="form-label">State</label>
                                
                                <input type="text" name="state"  class="first-upper form-control {{ $errors->has('state') ? ' is-invalid' : '' }}"  value="{{old('state',$customer->state)}}">
                                @if ($errors->has('state'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('state') }}.</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group col-3">
                                
                                <label  class="form-label">Pincode</label>
                                
                                <input type="text" name="pincode"  class="form-control {{ $errors->has('pincode') ? ' is-invalid' : '' }}"  value="{{old('pincode',$customer->pincode)}}">
                                @if ($errors->has('pincode'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('pincode') }}.</strong>
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
@section('scripts')
<script src="{{ asset('js/eachWordUpper.js') }}"></script>
@endsection
@endsection
