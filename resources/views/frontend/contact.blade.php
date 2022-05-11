@extends('frontend.layouts.frontend')
@section('title')
  ACTI-INDIA About
@endsection
@section('content')
<div class="blog-page-area  pd-top-70 pd-bottom-50">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="social-area-list widget-author mb-4 p-4">
                    <h5 class="pb-2">Contact Details</h5>
                    <ul>
                        <li><a class="facebook" href="#"> <i class="fa fa-envelope bg-danger social-icon me-1"></i>   souravroy4243@gmai.com</a></li>
                        <li><a class="twitter" href="#"> <i class="fa fa-phone bg-success social-icon me-1"></i>  +91 7063656983
                                </a></li>
                        <li><a class="youtube" href="#"><i class="fa fa-map-marker bg-warning social-icon"></i><span>1st Floor, Kameshwari Roard Bylen, Near Bank of India, West Khagra bari, Cooch Behar, Pin 706101, West Bengal, India.
                                </span></a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="comment">
                    <div class="section-title mb-0">
                        <h4 class="mb-0">For any help contact us.</h4>
                    </div>
                    <form class="contact-form-wrap">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="single-input-wrap input-group">
                                    <input type="text" class="form-control" placeholder="Your Full Name">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-user"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="single-input-wrap input-group">
                                    <input type="text" class="form-control" placeholder="Your Email">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-envelope"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="single-input-wrap message input-group">
                                    <textarea class="form-control" rows="4" name="note" placeholder="Write Message"></textarea>
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-pencil"></i></div>
                                    </div>
                                </div>
                                <div class="submit-area">
                                    <button type="submit" class="btn btn-base">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection