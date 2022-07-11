@extends('admin.layouts.backend')

@section('content')
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Reviews</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('courses.index')}}">courses</a></li>
              <li class="breadcrumb-item active">Reviews</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <div class="content">
      <div class="container-fluid">
        <div class="card">
            <div class="card-header text-primary">
                {{$data->name}}
            </div>
            <div class="card-body card-comments">
                @if(!empty($reviews))
                @foreach($reviews as $review)
                
                <div class="card-comment">
                   
                    @if($review->students->image!=null)
                    <img class="img-circle img-sm" src="{{ asset('storage/students/' . $review->students->image) }}" alt="User profile picture">
                    @endif
                    

                    <div class="comment-text">
                        <span class="username">
                        {{$review->name}}
                        <span class="text-muted float-right">{{Carbon\Carbon::parse($review->pivot->created_at)->diffForHumans()}}</span>
                        </span><!-- /.username -->
                        {{$review->pivot->comment}}
                    </div>
                  <!-- /.comment-text -->
                </div>
                @endforeach
                @endif
            </div>
        </div>
    </div><!-- /.container-fluid -->
</div>
    
@endsection