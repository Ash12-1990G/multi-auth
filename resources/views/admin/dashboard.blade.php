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
        @can('franchise-list')
          <div class="col-12 col-sm-6 col-md-3">
            <a href="{{route('franchises.index')}}" class="text-dark">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-shopping-bag"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Franchise</span>
                <span class="info-box-number">
                {{ $franchise }}
                  <small></small>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            </a>
            <!-- /.info-box -->
          </div>
          @endcan
          <!-- /.col -->
          @can('user-list')
          <div class="col-12 col-sm-6 col-md-3">
            <a href="{{route('users.index')}}" class="text-dark">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-users-cog"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">Users</span>
                  <span class="info-box-number">{{ $users }}</span>
                </div>
                <!-- /.info-box-content -->
              </div>
            </a>
            <!-- /.info-box -->
          </div>
          @endcan
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>
          @can('student-list')
          <div class="col-12 col-sm-6 col-md-3">
            <a href="{{route('students.index')}}" class="text-dark">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-user-graduate"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">Students</span>
                  <span class="info-box-number">{{ $students }}</span>
                  
                </div>
                <!-- /.info-box-content -->
                
              </div>
            </a>
            <!-- /.info-box -->
          </div>
          @endcan
          <!-- /.col -->
          @can('customer-list')
          <div class="col-12 col-sm-6 col-md-3">
            <a href="{{route('customers.index')}}" class="text-dark">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-university"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">Customers</span>
                  <span class="info-box-number">{{ $customers }}</span>
                </div>
                <!-- /.info-box-content -->
              </div>
            </a>
            <!-- /.info-box -->
          </div>
          @endcan
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
@endsection