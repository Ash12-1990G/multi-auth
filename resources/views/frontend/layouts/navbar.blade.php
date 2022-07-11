<div class="navbar-area">
        <!-- topbar end-->
        <div class="topbar-area">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6 col-md-7 align-self-center">
                        <div class="topbar-menu text-md-left">
                            <ul class="align-self-center">
                                <li><a href="mailto:souravroy4243@gmail.com"><i class="fa fa-envelope"></i> souravroy4243@gmail.com</a></li>
                                <li><a href=""><i class="fa fa-phone"></i> +91 7063656983</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-5 mt-2 mt-md-0 text-md-right">
                        <div class="topbar-social">
                            <div class="topbar-date d-none d-lg-inline-block">
                                <a href="{{route('customer.signin')}}">Customer Login</a>
                            </div>
                            <ul class="social-area social-area-2">
                                <li><a class="facebook-icon" href="#"><i class="fa fa-facebook"></i></a></li>
                                <li><a class="twitter-icon" href="#"><i class="fa fa-twitter"></i></a></li>
                                <li><a class="youtube-icon" href="#"><i class="fa fa-youtube-play"></i></a></li>
                                <li><a class="instagram-icon" href="#"><i class="fa fa-instagram"></i></a></li>
                                <li><a class="google-icon" href="#"><i class="fa fa-google-plus"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- topbar end-->

        <!-- adbar end-->
        <div class="d-none d-lg-block" style="background-color:#ebebeb">
            <div class="container">
                <div class="row">
                    <div class="col-xl-6 col-lg-5 align-self-center">
                        <div class="logo text-md-left">
                            <a class="main-logo" href="{{route('front.home')}}"><img src="{{ asset('storage/logo/logo.png') }}" alt="img"> </a>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-7 text-md-right p-2">
                        <a href="#" class="adbar-right">
                            <img class="img-responsive" src="{{ asset('storage/sliders/offer.jpg') }}" alt="img">
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- adbar end-->

        <!-- navbar start -->
        <nav class="navbar navbar-expand-lg">
            <div class="container nav-container">
                <div class="responsive-mobile-menu">
                    <div class="logo d-lg-none d-block">
                        <a class="main-logo" href="{{route('front.home')}}"><img src="{{ asset('storage/logo/logo.png') }}" alt="img"></a>
                    </div>
                    <button class="menu toggle-btn d-block d-lg-none" data-target="#nextpage_main_menu" 
                    aria-expanded="false" aria-label="Toggle navigation">
                        <span class="icon-left"></span>
                        <span class="icon-right"></span>
                    </button>
                </div>
                <!-- <div class="nav-right-part nav-right-part-mobile">
                    <a class="search header-search" href="#"><i class="fa fa-search"></i></a>
                </div> -->
                <div class="collapse navbar-collapse" id="nextpage_main_menu">
                    <ul class="navbar-nav menu-open">
                        <li class="current-menu-item">
                            <a href="{{ route('front.home') }}">Home</a>
                        </li>                        
                        <li class="current-menu-item">
                            <a href="{{ route('front.aboutus') }}">About</a>
                        </li>                        
                                               
                        <li class="current-menu-item">
                            <a href="#">Courses</a>
                        </li> 
                        <li class="current-menu-item">
                            <a href="#">Centers</a>
                        </li> 
                        <li class="current-menu-item">
                            <a href="#">Affiliations</a>
                        </li>  
                        <li class="menu-item-has-children current-menu-item">
                            <a href="#">Student Corner</a>
                            <ul class="sub-menu">
                                <li><a href="{{route('student.signin')}}">Login</a></li>
                               
                            </ul>
                        </li> 
                        <li class="current-menu-item">
                            <a href="#">Gallery</a>
                        </li> 
                        <li class="current-menu-item">
                            <a href="{{ route('front.contact') }}">Contact</a>
                        </li>                       
                        
                    </ul>
                </div>
                <div class="nav-right-part nav-right-part-desktop">
                
                    
                </div>
            </div>
        </nav>
    </div>