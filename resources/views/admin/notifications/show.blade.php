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
                    <li class="breadcrumb-item"><a href="{{ route('notifications.index') }}">Notifications</a></li>
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
              
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Read Notifation 
                            <div class="card-tools">
                           
                        </h3>
                    </div>
           
                    <div class="card-body p-2">
                        <div class="mailbox-read-info">
                            <h5>@if($notice->type == 'App\Notifications\FailedJobsNotice')
                                Registration Mail Failure
                                @endif
                            </h5>
                            <h6>To: {{ $notice->data['email'] }}
                            <span class="mailbox-read-time float-right">{{ $notice->created_at->format('j F, Y, g:i a')}}</span></h6>
                        </div>
                    <!-- /.mailbox-read-info -->
                    
                    <!-- /.mailbox-controls -->
                    <div class="mailbox-read-message">

                        <p>{{ $notice->data['message'] }}</p>
                    </div>
                    <!-- /.mailbox-read-message -->
                    </div>
           
         
          </div>
            </div>
        </div>
    </div>
</div>
@endsection