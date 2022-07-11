@extends('admin.layouts.backend')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Students Courses</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  @if(auth()->user()->hasRole('Franchise-Admin'))
                  <li class="breadcrumb-item"><a href="{{route('customer.students.index')}}">Students</a></li>
                  @else
                    <li class="breadcrumb-item"><a href="{{route('students.index')}}">Students</a></li>
                  @endif
                    <li class="breadcrumb-item active">Students Courses</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<div class="content">
      <div class="container-fluid">
        <div class="overlay-div" id="loader">
            <div class="overlay__inner">
                <div class="overlay__content"><span class="spinner"></span></div>
            </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
          
          <div class="card">
              <div class="card-header">
                <h3 class="card-title text-primary">{{ $data->users->name }}</h3>
                <div class="card-tools">
                @can('student-course-add')
                  @if(auth()->user()->hasRole('Franchise-Admin'))
                  <a class="btn btn-primary btn-sm"  href="{{ route('customer.studentcourses.create',['student_id'=>$data->id]) }}">Add Course</a>
                  @else
                  <a class="btn btn-primary btn-sm"  href="{{ route('studentcourses.create',['student_id'=>$data->id]) }}">Add Course</a>
                  @endif
                @endcan
                </div>

              </div>
              <!-- /.card-header -->
              <div class="card-body">
              
                <table class="table table-striped datatable" id="user-datatable">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Roll No</th>
                      <th>Course Name</th>
                      <th>Price</th>
                      <th>Due</th>
                      <th>Payment Option</th>
                      <th>Payment Status</th>
                      <th>Start Date</th>
                      <th style="width: 280px">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>

            
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
      <div class="modal" id="EditConcessionModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Product Edit</h4>
                    <button type="button" class="close modelClose" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="alert alert-success alert-dismissible fade show" role="alert" style="display: none;">
                        <strong>Success!</strong>Product was added successfully.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div id="EditConcessionModalBody">
                        
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="SubmitEditProductForm">Update</button>
                    <button type="button" class="btn btn-danger modelClose" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
      </div>
</div>


@endsection
@section('scripts')
<script type="text/javascript" src="{{ asset('js/sweetalert.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}" ></script>
<script type="text/javascript" src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>

@if(auth()->user()->hasRole('Franchise-Admin'))
<script type="text/javascript">
var dataUrl = '{!! route('customer.studentcourses.index',$data->id) !!}';
var userPrefix='customer';
</script>
@else
<script type="text/javascript">
var dataUrl = '{!! route('studentcourses.index',$data->id) !!}';
var userPrefix='admin';
</script>
@endif
<script type="text/javascript">
   
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var table = $('#user-datatable').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax:dataUrl,
            
            columns: [
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'roll no',
                    name: 'roll no'
                },
                {
                    data: 'course name',
                    name: 'course name'
                },
                {
                    data: 'price',
                    name: 'price'
                },
                {
                    data: 'due',
                    name: 'due'
                },
                {
                    data: 'payment option',
                    name: 'payment option'
                },
                {
                    data: 'payment status',
                    name: 'payment status'
                },
                {
                    data: 'start date',
                    name: 'start date'
                },
                {
                    data: 'action',
                    name: 'action'
                },
            ],
            "drawCallback": function(settings) {
                initAfterDraw();
            }
        });
    
 
        $('.modelClose').on('click', function(){
            $('#EditConcessionModal').modal('hide');
        });
        var id;
        function callModal(e,data){
            e.preventDefault();
            $('.alert-danger').html('');
            $('.alert-danger').hide();
        //console.log(data);
            id = data;
    
        
            $.ajax({
                url: "/"+userPrefix+"/student_courses/"+id+"/concession",
                method: 'GET',
                // data: {
                //     id: id,
                // },
                beforeSend: function(){
                    // things to do before
                    $("#loader").show();
                },
                success: function(result) {
                    console.log(result);
                    $('#EditConcessionModalBody').html(result.html);
                    $('#EditConcessionModal').modal("show");
                },
                complete:function(data){
                    // Hide image container
                    $("#loader").hide();
                }
            });
        }
        function initAfterDraw() {
                // Update product Ajax request.
            $('#SubmitEditProductForm').click(function(e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "/"+userPrefix+"/student_courses/"+id+"/concession",
                    method: 'PUT',
                    data: {
                        concession: $('#editConcession').val(),
                    },
                    beforeSend: function(){
                            // things to do before
                            $("#loader").show();
                    },
                    success: function(result) {
                        if(result.errors) {
                            $('.alert-danger').html('');
                            
                            $.each(result.errors, function(key, value) {
                                $('.alert-danger').show();
                                $('.alert-danger').append('<strong><li>'+value+'</li></strong>');
                            });

                        } else {
                            $('.alert-danger').hide();
                            $('.alert-success').show();
                            $('#user-datatable').DataTable().ajax.reload();
                            setInterval(function(){ 
                                $('.alert-success').hide();
                                $('#EditConcessionModal').hide();
                                $(':submit').attr('disabled', 'disabled');
                                location.reload();
                            }, 2000);
                        }
                    },
                    complete:function(data){
                            // Hide image container
                            $(':submit').attr('enabled', 'enabled');
                            $("#loader").hide();
                    },
                    error: function (data) {
                        
                    }
                });
            });
        }

</script>
@if($msg = session('success'))
<script type="text/javascript">
  swal("Great job!","{{$msg}}",'success');
</script>
@endif
@if($msg = session('warning'))
<script type="text/javascript">
  swal("Sorry!","{{$msg}}",'warning');
</script>
@endif
@endsection