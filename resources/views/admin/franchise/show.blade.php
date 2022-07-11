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
            <div class="col-md-8">
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
                                @if($franchise->image!=NULL)
                                <span class="mailbox-attachment-icon has-img">
                                    <img class="w-25 img-fluid" src="{{asset('storage/franchise/'.$franchise->image)}}">
                                </span>
                                @endif
                                <div class="username mb-2" @if($franchise->image!=NULL) style="margin-left:26%;" @else style="margin-left:0;" @endif>
                                    <p class="text-primary mb-0" style="font-size:30px; line-height:30px;">{{ $franchise->name }}</p>
                                    <span class="text-muted" style="font-size:20px;">{{ $franchise->subname }}</span>
                                    
                                </div>
                                <div class="description text-success text-md mr-2 mb-2" @if($franchise->image!=NULL) style="margin-left:26%;" @else style="margin-left:0;" @endif> 
                                    <h5 class="mb-0"> 
                                    <span class="badge badge-pill badge-danger"><i class="fas fa-rupee-sign"></i> {{ $franchise->cost }}</span></h5>
                                
                                    <!-- <span class="text-muted"><strong>Prolongation: </strong> {{ $franchise->service_period }} {{ $franchise->service_interval }}</span> -->
                                </div>
                            </div>
                        </div>
                        
                        
                        {!! $franchise->details !!}
                        
                    </div>
                    
                </div>
            </div>
            @if($course->count()>0)
            <div class="col-md-4">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Available Courses</h3>

                        <!-- <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                        </div> -->
                    </div>
                <!-- /.card-header -->
                    <div class="card-body p-0">
                        <ul class="products-list product-list-in-card pl-2 pr-2">
                        @foreach($course as $item)
                            <li class="item">
                                <div class="product-img">
                                    <!-- <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50"> -->
                                </div>
                                <div class="product-info m-0 pl-2 pr-2">
                                    <a href="{{ route('courses.index') }}" class="product-title">{{ $item->name }}
                                        <span class="badge badge-warning float-right"><i class="fas fa-rupee-sign"></i> {{ $item->price }}</span>
                                    </a>
                                    <span class="product-description text-truncate">
                                    {{ $item->description }}
                                    </span>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                        
                    </div>
                <!-- /.card-body -->
                    <div class="card-footer text-center">
                    <a href="{{ route('courses.index') }}" class="uppercase">View All</a>
                    </div>
                <!-- /.card-footer -->
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection