@extends('admin.layouts.backend')
@push('styles')
<link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">

<style>

/* rating */
.rating-css{
    line-height: 12px;
}
.rating-css .star-icon {
  color: #ffe400;
  font-size: 10px;
  font-family: sans-serif;
  font-weight: 800;
  text-transform: uppercase;
  
  /* padding: 20px 0; */
}
.rating-css input {
  display: none;
}
.rating-css input + label {
  font-size: 60px;
  text-shadow: 1px 1px 0 #8f8420;
  cursor: pointer;
}
.rating-css input:checked + label ~ label {
  color: #b4afaf;
}
.rating-css label:active {
  transform: scale(0.8);
  transition: 0.3s ease;
}
.card-comments .card-comment img,.img-xl{
    width: 2.5rem;
    height: 2.5rem;
}
/* End of Star Rating */
</style>
@endpush
@section('content')
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">View</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('customer.franchises') }}">Franchises</a></li>
              <li class="breadcrumb-item active">View</li>
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
          <div class="card-header"><h4 class="m-0 text-primary">{{ $data->name }}</h4></div>
          <div class="card-body pt-3">
            
            <div class="row">
              <div class="col-7 col-sm-9">
                <div class="tab-content" id="vert-tabs-right-tabContent">
                  <div class="tab-pane fade {{ $tab == 'description' ? 'active show' : '' }}" id="vert-tabs-right-description" role="tabpanel" aria-labelledby="vert-tabs-right-description-tab">
                    <h6 class="text-grey font-weight-bold">Description</h6>
                    <p>{{ $data->description }}</p>
                  </div>
                  <div class="tab-pane fade {{ $tab == 'syllabus' ? 'active show' : '' }}" id="vert-tabs-right-syllabus" role="tabpanel" aria-labelledby="vert-tabs-right-syllabus-tab">
                    <h6 class="text-grey font-weight-bold">Syllabus</h6>
                    @if(!empty($data->syllabus->description))
                
                      {!! $data->syllabus->description !!}
                    @endif
                  </div>
                  <div class="tab-pane fade {{ $tab == 'ebook' ? 'active show' : '' }}" id="vert-tabs-right-ebook" role="tabpanel" aria-labelledby="vert-tabs-right-ebook-tab">
                    <h6 class="text-grey font-weight-bold">Ebooks</h6>
                    <div class="overlay-div" id="loader">
                        <div class="overlay__inner">
                            <div class="overlay__content"><span class="spinner"></span></div>
                        </div>
                    </div>
                    
                    <div class="row d-flex align-items-stretch" id="ebookDiv">
                      
                    
                    </div>
                    <div class="row">
                            <div class="col-12" id="paginate">
                            </div>  
                        </div>
                    <div class="text-center mt-4 d-none hidden-msg">
                        <h5 class="text-error"><i class="fas fa-exclamation-triangle text-danger"></i> Oops! Results Not found</h5>
                    </div>
                  </div>
                  <div class="tab-pane fade {{ $tab == 'review' ? 'active show' : '' }}" id="vert-tabs-right-review" role="tabpanel" aria-labelledby="vert-tabs-right-review-tab">
                    @if($review->count()>0)
                    
                    <div class="card-comments p-3">
                        @foreach($review as $item)
                        <div class="card-comment">
                   
                            @if($item->students->image!=null)
                            <img class="img-circle img-xl" src="{{ asset('storage/students/' . $item->students->image) }}" alt="User profile picture" style="width: 2.5rem;height: 2.5rem;">
                            @endif
                            <div class="comment-text">
                                <div class="username">
                                {{$item->name}}
                                <div class="rating-css">
                                    <span class="star-icon">
                                        @if($item->pivot->rating==1)
                                        <label class="fa fa-star"></label>
                                        <label class="fa fa-star text-secondary"></label>
                                        <label class="fa fa-star text-secondary"></label>
                                        <label class="fa fa-star text-secondary"></label>
                                        <label class="fa fa-star text-secondary"></label>
                                        @elseif($item->pivot->rating==2)
                                        <label class="fa fa-star"></label>
                                        <label class="fa fa-star"></label>
                                        <label class="fa fa-star text-secondary"></label>
                                        <label class="fa fa-star text-secondary"></label>
                                        <label class="fa fa-star text-secondary"></label>
                                        @elseif($item->pivot->rating==3)
                                        <label class="fa fa-star"></label>
                                        <label class="fa fa-star"></label>
                                        <label class="fa fa-star"></label>
                                        <label class="fa fa-star text-secondary"></label>
                                        <label class="fa fa-star text-secondary"></label>
                                        @elseif($review->pivot->rating==4)
                                        <label class="fa fa-star"></label>
                                        <label class="fa fa-star"></label>
                                        <label class="fa fa-star"></label>
                                        <label class="fa fa-star"></label>
                                        <label class="fa fa-star text-secondary"></label>
                                        @else
                                        <label class="fa fa-star"></label>
                                        <label class="fa fa-star"></label>
                                        <label class="fa fa-star"></label>
                                        <label class="fa fa-star"></label>
                                        <label class="fa fa-star"></label> 
                                        @endif
                                    </span>
                                    
                                
                                </div>
                                <span class="text-muted float-right">{{Carbon\Carbon::parse($item->pivot->created_at)->diffForHumans()}}</span>
                            </div><!-- /.username -->
                                {{$item->pivot->comment}}
                            </div>
                        </div>
                        @endforeach
                    </div>
                    {{ $review->links() }}
                    @endif
                  </div>
                </div>
              </div>
              <div class="col-5 col-sm-3">
                <div class="nav flex-column nav-tabs nav-tabs-right h-100" id="vert-tabs-right-tab" role="tablist" aria-orientation="vertical">
                  <a class="nav-link {{ $tab == 'description' ? 'active show' : '' }}" id="vert-tabs-right-description-tab" data-toggle="pill" href="#vert-tabs-right-description" role="tab" aria-controls="vert-tabs-right-description" aria-selected="false">Description</a>
                  <a class="nav-link {{ $tab == 'syllabus' ? 'active show' : '' }}" id="vert-tabs-right-syllabus-tab" data-toggle="pill" href="#vert-tabs-right-syllabus" role="tab" aria-controls="vert-tabs-right-syllabus" aria-selected="false">Syllabus</a>
                  <a class="nav-link {{ $tab == 'ebook' ? 'active show' : '' }}" id="vert-tabs-right-ebook-tab" data-toggle="pill" href="#vert-tabs-right-ebook" role="tab" aria-controls="vert-tabs-right-ebook" aria-selected="false">Ebooks</a>
                  <a class="nav-link {{ $tab == 'review' ? 'active show' : '' }}" id="vert-tabs-right-review-tab" data-toggle="pill" href="#vert-tabs-right-review" role="tab" aria-controls="vert-tabs-right-review" aria-selected="false">Review</a>
                </div>
              </div>
            </div>
          </div>
        </div> 
      </div>
    </div>
  </div><!-- /.container-fluid -->
</div>
@endsection
@section('scripts')
<script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
@if($msg = session('success'))
<script type="text/javascript">
  tosterMessage('success',"{{$msg}}")
 
</script>

@endif
@if($errors->any())
    <script  type="text/javascript">
alert();
        if(!$('#vert-tabs-right-review-tab').hasClass('active show')){
            $('#vert-tabs-right-tab').children('.nav-item').find('.nav-link').removeClass('active show');
            $('#vert-tabs-right-tabContent').children('.tab-pane').find('.active').removeClass('active show');
            $('#vert-tabs-right-review-tab').addClass('active show');
            $('#vert-tabs-right-review').addClass('active show');
            
        }
        
        
    </script>
@endif
<script>
  function notFoundMsg($check){
    if($check==='hide'){
        if($('.hidden-msg').hasClass('d-block')){
            $('.hidden-msg').addClass('d-none');
            $('.hidden-msg').removeClass('d-block');
        }
        
    }
    else if($check==='show'){
         if($('.hidden-msg').hasClass('d-none')){
            $('.hidden-msg').addClass('d-block');
            $('.hidden-msg').removeClass('d-none');
        }
    }
    
}
var course_id = "{{ $data->id }}";
$(function() {
  ajaxfunction(course_id,1);
});
function ajaxfunction(){

  
  $.ajax({
    type: 'GET',
    headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
    url: '{!! route('customer.ebooks') !!}',
    data: {course_id:course_id},
    dataType: 'json',
    beforeSend: function(){
      $('#ebookDiv').empty();
      $('#paginate').empty();
      notFoundMsg('hide');
      $("#loader").show();
    },
    success: function (data) {
      if(data.data.length>0){
        var div = '';
        var url_edit = '';
        var download_link = '';
        $.each(data.data, function(i, item) {
          //console.log(item);
          
          
          url_edit = '{{ asset("storage/ebooks/:path") }}';
          url_edit = url_edit.replace(':path', item.coverpath);
          download_link = '{{ route("customer.ebookdownload",["file"=>":filename"]) }}';
          download_link = download_link.replace(':filename', item.bookpath);
          div +='<div class="col-12 col-sm-6 col-md-3 d-flex align-items-stretch"><div class="card h-100 bg-danger book-post">';
          
          div +='<span class="mailbox-attachment-icon has-img"><img src="'+url_edit+'" class="card-img-top" alt=image"></span>';
          div +='<div class="card-body book-body p-2"><h5 class="m-0 text-dark">'+item.title+'</h5>';
          
          div +='<p class="card-text"><span class="mailbox-attachment-size clearfix mt-1"><span class="text-dark">Download Link</span><a href="'+download_link+'" class="btn btn-danger text-light btn-sm float-right"><i class="fas fa-download"></i></a></span></p>';
          div +='</div></div></div>';
           
        });
        $('#ebookDiv').append(div);

        //pagination starts
        pagination ='<ul class="pagination pagination-rounded justify-content-end mb-1">';
                    current_page = data.current_page;
                    if(data.last_page===data.current_page){
                        next_page = 0;
                    }
                    else{
                        next_page = parseInt(data.current_page + 1);
                    }
                    
                    if(data.current_page>0){
                        prev_page = parseInt(data.current_page- 1);
                    }
                    else{
                        prev_page = 0;
                    }
                 
                    
                    if(data.prev_page_url==null){
                        pagination +='<li class="page-item disabled"><a class="page-link" href="javascript: void(0);" aria-label="Previous"><span aria-hidden="true">«</span><span class="visually-hidden">Previous</span></a></li>';
                    }
                    else{
                        pagination +='<li class="page-item"><a class="page-link" onclick="ajaxfunction('+`\'${course_id}\'`+','+prev_page+')" href="#" aria-label="Previous"><span aria-hidden="true">«</span><span class="visually-hidden">Previous</span></a></li>';
                    }
                    
                    
                        $.each(data.links, function(i, item){
                            //console.log(item);
                            if(item.url!==null && item.label!=='&laquo; Previous' && item.label!=='Next &raquo;'){
                                if(item.active){
                                    pagination +='<li class="page-item active"><a class="page-link" onclick="ajaxfunction('+`\'${course_id}\'`+','+item.label+')" href="javascript:void(0);">'+item.label+'</a></li>';
                                }
                                else{
                                    pagination +='<li class="page-item"><a class="page-link" onclick="ajaxfunction('+`\'${course_id}\'`+','+item.label+')" href="javascript:void(0);">'+item.label+'</a></li>';
                                }
                                
                                
                            }
                            else{
                                if(item.label=='...' ){
                                    pagination +='<li class="page-item"><a class="page-link" href="javascript:void(0);">'+item.label+'</a></li>';
                                }
                                

                            }
                            
                        });
                        if(data.next_page_url==null){
                            pagination +='<li class="page-item disabled"><a class="page-link" href="javascript: void(0);" aria-label="Next"><span aria-hidden="true">»</span><span class="visually-hidden">Next</span></a></li>';
                        }
                        else{
                            
                            pagination +='<li class="page-item"><a class="page-link" onclick="ajaxfunction('+`\'${course_id}\'`+','+next_page+')" href="javascript: void(0);" aria-label="Next"><span aria-hidden="true">»</span><span class="visually-hidden">Next</span></a></li>';
                        } 
                        pagination +='</ul>';
                        $('#paginate').append(pagination);          
                                    
                 //pagination ends here

      }
      else{
                                   
            notFoundMsg('show');
        }
    },
    complete:function(data){
        $("#loader").hide();
    },

    error: function (data) {
        console.log(data);
    }

  });
}
</Script>

@endsection