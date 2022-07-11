@extends('admin.layouts.backend')
@section('content')
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Franchises</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">Franchises</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <div class="content">
      <div class="container-fluid">
      @if(!empty($data))
      <div class="row d-flex align-items-stretch">
    
        @foreach($data as $item)
        <div class="col-lg-4">
            <div class="card card-widget widget-user">
                <div class="widget-user-header bg-secondary" style="height:100%;">
                    <h3 class="widget-user-username">{{$item->name}}</h3>
                    <h5 class="widget-user-desc">{{$item->subname}}</h5>
                </div>
                
                <div class="card-footer pt-0 pb-0">
                    <div class="row">
                        <div class="col-sm-4 border-right">
                        <div class="description-block">
                            <h5 class="description-header"><i class="fa fa-rupee-sign"></i> {{$item->pivot->amount}}</h5>
                            <span class="description-text">Cost</span>
                        </div>
                        <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4 border-right">
                        <div class="description-block">
                            <h5 class="description-header">@if($item->pivot->due!=0)<i class="fa fa-rupee-sign"></i>@endif {{$item->pivot->due}}</h5>
                            <span class="description-text">Due</span>
                        </div>
                        <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4">
                        <div class="description-block">
                            <h5 class="description-header">{{$item->courses()->count()}}</h5>
                            <span class="description-text">Courses</span>
                        </div>
                        <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <div class="row">
                        <div class="col-12 ">
                            <h6 class="text-center">{{ Carbon\Carbon::parse($item->pivot->service_taken)->format('M j, Y') }} - {{Carbon\Carbon::parse($item->pivot->service_ends)->format('F j, Y') }}</h6>
                            

                        </div>
                        <a href="{{route('customer.course',$item->id)}}" class="btn btn-block btn-sm btn-danger">View Course</a>
                        <a href="{{route('customer.transactionwithadmin')}}" class="btn btn-block btn-sm btn-success mb-2">Transactions</a>
                    </div>
                </div>
            </div>
        </div>  
        @endforeach
        </div>
        
{{ $data->links() }}
       @endif
      </div><!-- /.container-fluid -->
    </div>
    
@endsection