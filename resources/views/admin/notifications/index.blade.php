@extends('admin.layouts.backend')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Notifications</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Notifications</a></li>
                    <li class="breadcrumb-item active">Notifications</li>
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
                <h3 class="card-title">List of Notifications</h3>

              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
              <div class="mailbox-controls">
                <!-- Check all button -->
                <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="far fa-square"></i>
                </button>
                <div class="btn-group">
                  @can('notification-read')
                  <button type="button" class="btn btn-default btn-sm delete-notification" for="Delete"><i class="far fa-trash-alt"></i></button>
                  @endcan
                  @can('notification-delete')
                  <button type="button" class="btn btn-default btn-sm read-notification" for="Read"><i class="fas fa-book"></i></button>
                  @endcan
                </div>
              </div>
                <div class="table-responsive mailbox-messages">
                  <table class="table table-hover table-striped">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Subject</th>
                        <th>Message</th>
                        <th>Read</th>
                        <th>Arrive Time</th>
                        <th>
                          Action
                      </th>
                      </tr>
                    </thead>
                    <tbody>
                      
                      @foreach ($data as $key => $items)
                              <tr>
                                  <td>
                                    <div class="icheck-primary">
                                      <input type="checkbox" name="read[]" value="{{ $items->id }}" id="check{{ ++$i }}">
                                      <label for="check{{ ++$i }}"></label>
                                    </div>
                                  </td>
                                  @if($items['type']=='App\Notifications\FailedJobsNotice')
                                  <td class="mailbox-name">Registration Mail Failure</td>
                                  @else
                                  <td class="mailbox-name"></td>
                                  @endif
                                  <td class="mailbox-subject"><span class="d-inline-block text-truncate" style="max-width: 450px;">
                                  {{ $items['data']['message'] }} sjsfsk sfkfjklj sfsfsf sfsfsfsf sfsfsfsfs sfsf
                                  </span></td>
                                  <td>@if($items['read_at']!=NULL)
                                      <i class="fa fa-book-reader text-primary"></i> 
                                      @else
                                      <i class="fa fa-book text-danger"></i>
                                      @endif   
                                  </td>
                                  <td class="mailbox-date">{{ $items->created_at->diffForHumans()}}</td>
                                  <td class="mailbox-name">
                                      <div class="btn-group">
                                      
                                     
                                      @can('notification-view')
                                      <a class="btn btn-success btn-sm" href="{{ route('notifications.view',$items->id) }}">Show</a>
                                      @endcan
                                      <!-- @can('notification-read')
                                      {!! Form::open(['method' => 'PATCH','route' => ['notifications.read', $items->id],'style'=>'display:inline']) !!}
                                          {!! Form::submit('Mark as Read', ['class' => 'btn btn-primary btn-sm mr-2']) !!}
                                          {!! Form::close() !!}
                                      @endcan
                                      
                                      @can('notification-delete')
                                          {!! Form::open(['method' => 'DELETE','route' => ['notifications.destroy', $items->id],'style'=>'display:inline']) !!}
                                          {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                                          {!! Form::close() !!}
                                      @endcan -->
                                      </div>
                                  </td>
                              </tr>
                          @endforeach
                      
                    </tbody>
                  </table>
                {{ $data->links() }}
                </div>
              </div>
              <!-- /.card-body -->
            </div>

            
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
</div>

@endsection
@section('scripts')
<script type="text/javascript" src="{{ asset('js/sweetalert.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/custom.js') }}"></script>
@if($msg = session('success'))
<script type="text/javascript">
  swal("Great job!","{{$msg}}",'success');
</script>
@elseif($msg = session('warning'))
<script type="text/javascript">
  swal("","{{ $msg }}",'warning');
</script>
@endif
@endsection