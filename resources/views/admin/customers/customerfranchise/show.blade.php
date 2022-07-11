@extends('admin.layouts.backend')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Show</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('customers.index')}}">Customers</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('customer_franchise.index',['customer'=>$data->customer_id]) }}"> Franchise</a></li>
                    <li class="breadcrumb-item active">Show</li>
                </ol>
                 
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                @if (\Session::has('success'))
                <div class="alert alert-success">
                    <p>{{ \Session::get('success') }}</p>
                </div>
                @endif
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{$customer_name}} (<span class="text-danger">{{ $customer_code}}</span>)</h3>
                    </div>
                    <div class="card-body">
                        <dl class="row">
                            <dt class="col-sm-4">Franchise Name</dt>
                            <dd class="col-sm-8">{{ $data->franchises->name }}</dd>
                            <dt class="col-sm-4">Franchise Code</dt>
                            <dd class="col-sm-8">{{ $data->franchises->franchise_code }}</dd>
                            <dt class="col-sm-4">Franchise Cost</dt>
                            <dd class="col-sm-8">{{ $data->amount }}</dd>
                            <dt class="col-sm-4">Payment Option</dt>
                            <dd class="col-sm-8">
                            {{ $data->payment_option }}
                            </dd>
                            <dt class="col-sm-4">Service Duration</dt>
                            <dd class="col-sm-8">
                            {{ Carbon\Carbon::parse($data->service_taken)->format('F j, Y')}} - {{ Carbon\Carbon::parse($data->service_ends)->format('F j, Y')}} 
                            </dd>
                           
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection