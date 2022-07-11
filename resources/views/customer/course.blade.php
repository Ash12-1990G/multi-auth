@extends('admin.layouts.backend')
@section('content')
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Courses</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('customer.franchises') }}">Franchises</a></li>
                <li class="breadcrumb-item active">Courses</li>
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
        <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch">
              <div class="card pt-2 h-100">
                <div class="card-header border-bottom-0">
                <span class="text-white bg-danger text-sm fw-bold p-1">{{ $item->course_code }}</span>
                </div>
                <div class="card-body pt-0">
                  
                      <h5 class="fw-bolder text-dark">{{ $item->name }}</h5>
                      <p class="text-dark mb-2"><i class="fas fa-rupee-sign"></i><b>{{ $item->price }}</b></p>
                      <p class="text-sm text-dark">{!! Str::words($item->description, 15, ' ...') !!} <a href="{{ route('customer.courseview',['course'=>$item->id,'tab'=>'description']) }}">more</a></p>
                      <div class="btn-group">
                        <a class="btn btn-sm btn-outline-secondary text-dark mr-1" href="{{ route('customer.courseview',['course'=>$item->id,'tab'=>'ebook']) }}"><i class="far fa-fw fa-file-pdf"></i> Ebooks</a>
                        <a class="btn btn-sm btn-outline-secondary text-dark mr-1" href="{{ route('customer.courseview',['course'=>$item->id,'tab'=>'syllabus']) }}"><i class="far fa-list-alt"></i> Syllabus</a>
                        
                        <a class="btn btn-sm btn-outline-secondary bg-warning text-dark" href="{{ route('customer.courseview',['course'=>$item->id,'tab'=>'review']) }}"><i class="far fa-star "></i>Review</a>
                      </div>
                      
                     
                    <div class="text-right pt-3">
                    
                    <a href="{{ route('customer.courseview',['course'=>$item->id,'tab'=>'review']) }}" class="btn btn-block btn-sm btn-primary">
                      View
                    </a>
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