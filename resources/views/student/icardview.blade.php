@extends('admin.layouts.backend')
@push('styles')
<link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
<style>
        /* .page-break {
            page-break-after: always;
        } */
        .main {
            width: 346px;
            height: 214px;
            margin: auto;
            margin-bottom: 30px;
            position: relative;
        }
        #id-main{
        background-image:url("/assets/img/icard/icard.jpg");
        background-size: cover;
        background-position: top;
        background-repeat: no-repeat;
        height:70px;
       }
       #icard-footer{
        background-image:url("/assets/img/icard/icard-footer.jpg");
        background-size: cover;
        background-position: top;
        background-repeat: no-repeat;
        height:60px;
       }
       .icard-list{
       display: -ms-flexbox;display: flex;-ms-flex-direction: column;flex-direction: column;padding-left: 0;
  margin-bottom: 0;
        list-style: none;
       }
       .icard-list-item{
        margin-left:6rem;margin-right:0;margin-bottom: 0.25rem;margin-top: 0;font-size:14px;
       }
       .icard{
        position: relative;display: -ms-flexbox;display: flex;
    -ms-flex-direction: column;flex-direction: column;min-width: 0;word-wrap:break-word;background-color: #fff;background-clip: border-box;border: 0 solid rgba(0,0,0,.125);border-radius: 0.25rem;box-shadow: 0 0 1px rgb(0 0 0 / 13%), 0 1px 3px rgb(0 0 0 / 20%);margin-bottom: 1rem;
       }
       .icard-user-img{
        text-align:center;margin-top:20px;
       }
       .icard-img{
        border: 2px solid #adb7ac;margin: 0 auto;padding: 3px;width: 100px;max-width: 100%;height: auto;vertical-align: middle;
       }
       .icard-name{
        color: #57b948;font-weight: 600;font-size: 18px;line-height:18px;margin-top: 5px;text-align:center;margin-bottom: 0!important;
       }
       .icard-title{color: #6c757d!important;font-weight: 700!important;text-align: center!important;font-size:14px;margin-bottom:0!important;}
    </style>
@endpush
@section('content')
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Icard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            @if(auth()->user()->hasRole('Franchise-Admin'))
            <li class="breadcrumb-item"><a href="{{route('customer.students.index')}}">Students</a></li>
            <li class="breadcrumb-item active">Icard</li>
            @elseif(auth()->user()->hasRole('Student-Admin'))
            <li class="breadcrumb-item active">Icard</li>
            @else
            <li class="breadcrumb-item"><a href="{{route('customer.students.index')}}">Students</a></li>
            <li class="breadcrumb-item active">Icard</li>
            @endif
              
              
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <div class="content">
      <div class="container-fluid">
      @if($data->image!=NULL)
        <a class="btn btn-sm btn-primary" href="@if(auth()->user()->hasRole('Franchise-Admin')){{route('customer.student.icarddownload',['student'=>$data->id])}} @else {{route('student.icarddownload',['student'=>$data->id])}} @endif">Download PDF</a>
        @endif
        <div class="main" style="margin-bottom:50px;height:100%;">
          <div class="icard" >
        
            <div style="flex: 1 1 auto;padding:0;">
              <div id="id-main"></div>
              @if($data->image!=NULL)
              <div class="icard-user-img">
                <img src="{{ asset('storage/students/'.$data->image) }}" alt="User profile picture" class="icard-img">
              </div>
              @endif
              <h3 class="icard-name">{{ $data->users->name }}</h3>

              <p class="icard-title">STUDENT</p>

              <ul class="icard-list">
                <li class="icard-list-item">
                  <b>DOB: </b> <a>{{ $data->birth->format('F j, Y') }}</a>
                </li>
                <li class="icard-list-item">
                  <b>Contact: </b> <a>{{ $data->phone }}</a>
                </li>
                <li class="icard-list-item">
                  <b>Gender: </b> <a>{{ ucfirst($data->gender) }}</a>
                </li>
              </ul>
              <p style="padding-left: 0;margin-bottom: 0;margin-top: 0;text-align:center;font-size:14px;font-weight:600;">Expires on {{ Carbon\Carbon::parse($data->admission)->addYear()->format('F j, Y')}}</p>
              <div id="icard-footer"></div>
            </div>
          </div>  
        </div>
      </div>
    </div>
   
@endsection
@section('scripts')
<script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>

@if($msg = session('warning'))


<script type="text/javascript">
  tosterMessage('error',"{{$msg}}")
 
</script>
@endif
@endsection
