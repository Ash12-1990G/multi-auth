@extends('admin.layouts.backend')

@section('content')
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <div class="content">
      <div class="container-fluid">
        
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>{{ $totalFranchise }}</h3>
                <p>Franchises</p>
              </div>
              <div class="icon">
                <i class="fas fa-shopping-bag"></i>
              </div>
              <a href="{{route('customer.franchises')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>{{ $totalStudent }}</h3>
                <p>Students</p>
              </div>
              <div class="icon">
                <i class="fas fa-user-graduate"></i>
              </div>
              <a href="{{route('customer.students.index')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box bg-success">
              <span class="info-box-icon"><i class="fas fa-rupee-sign"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Students Payment</span>
                <span class="info-box-number py-2">Total <i class="fas fa-rupee-sign"></i> {{$studentTotal}}</span>

                <div class="progress">
                  <div class="progress-bar" style="width: 70%"></div>
                </div>
                <span class="progress-description py-2">
                  Total Due <i class="fas fa-rupee-sign"></i> {{$studentDue}}
                </span>
              </div>
              
            </div>
          </div>
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box bg-danger">
              <span class="info-box-icon"><i class="fas fa-rupee-sign"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Customer Payment</span>
                <span class="info-box-number py-2">Total <i class="fas fa-rupee-sign"></i> {{$customerTotal->total}}</span>

                <div class="progress">
                  <div class="progress-bar" style="width: 70%"></div>
                </div>
                <span class="progress-description py-2">
                  Total Due @if($customerDue->totaldue>0)<i class="fas fa-rupee-sign"></i> {{$customerDue->totaldue}}
                  @else
                  {{$customerDue->totaldue}}
                  @endif
                </span>
              </div>
              
            </div>
          </div>
        </div>
      </div>
    </div>
@endsection
@section('scripts')
<script src="{{ asset('dist/js/pages/dashboard.js') }}"></script>
@endsection