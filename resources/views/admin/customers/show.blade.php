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
                    <li class="breadcrumb-item"><a href="{{ route('customers.index') }}">Customers</a></li>
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
                        <h3 class="card-title">Customer Informations</h3>
                    </div>
                    <div class="card-body">
                        <dl class="row">
                            <dt class="col-sm-4">Name</dt>
                            <dd class="col-sm-8">{{ $customer->users->name }}</dd>
                            <dt class="col-sm-4">Email</dt>
                            <dd class="col-sm-8">
                            {{ $customer->users->email }}
                            </dd>
                            <dt class="col-sm-4">Phone</dt>
                            <dd class="col-sm-8">
                            {{ $customer->phone }} @if($customer->alt_phone!='') / {{ $customer->alt_phone }} @endif
                            </dd>
                            <dt class="col-sm-4">Customer's Address</dt>
                            <dd class="col-sm-8">
                            {{ $customer->address }}, {{ $customer->city }}, {{ $customer->state }}, {{ $customer->pincode }}
                            </dd>
                            <dt class="col-sm-4">Start-up Location</dt>
                            <dd class="col-sm-8">
                            {{ $customer->location }}
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection