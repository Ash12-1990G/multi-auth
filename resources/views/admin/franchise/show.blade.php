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
                    <li class="breadcrumb-item"><a href="{{ route('franchises.index') }}">Franchises</a></li>
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
                        <h4 class="text-primary">{{ $franchise->name }} <br>
                        </h4>
                    </div>
                    <div class="card-body">
                    <div class="post">
                      <div class="user-block">
                        <span class="mailbox-attachment-icon has-img">
                            <img class="w-25 img-fluid" src="{{asset('storage/franchise/'.$franchise->image)}}">
                        </span>
                        <div class="username mb-2" style="margin-left:26%;">
                            <p class="text-primary mb-0" style="font-size:30px; line-height:30px;">{{ $franchise->name }}</p>
                            <span class="text-muted" style="font-size:20px;">{{ $franchise->subname }}</span>
                            
                        </div>
                        <div class="description text-success text-md mr-2 mb-2" style="margin-left:26%;"> 
                            <h5 class="mb-0"><i class="fas fa-rupee-sign"></i> {{ $franchise->cost }} @if($franchise->discount!==0)
                            <span class="badge badge-pill badge-danger">{{ $franchise->discount }} % discount</span></h5>
                        
                            <span class="text-muted"><strong>Prolongation: </strong> {{ $franchise->service_period }} {{ $franchise->service_interval }}</span>
                        @endif</div>
                      </div>
                      <!-- /.user-block -->
                      
                    </div>
                        
                        {!! $franchise->details !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection