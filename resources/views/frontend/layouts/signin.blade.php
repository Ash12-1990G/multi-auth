<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @yield('title')
    </title>
  
    

<link rel="stylesheet" href="{{ asset('assets/css/vendor.css') }}">
<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">

<script src="{{ asset('js/app.js') }}" defer></script>
<style>
    .carousel-control-prev,.carousel-control-next {
    border: none;
    }
    .carousel-control-prev,.carousel-control-next{
        background: 0 0;
    }
    .carousel-item {
      -webkit-transform: translateZ(0); -moz-transform: translateZ(0); 
    }
    
    .social-area-list ul li span {
      float: right;
      margin-left: 50px;
      margin-top: -30px;
      position: relative;
    }
    .social-area-list>ul{
      display: inline-block;
    }
 </style>   
  @stack('styles')  
    
</head>
<body>
  
  <div id="app">
  <div class="preloader" id="preloader">
        <div class="preloader-inner">
            <div class="spinner">
                <div class="dot1"></div>
                <div class="dot2"></div>
            </div>
        </div>
    </div>

 
    <div class="body-overlay" id="body-overlay"></div>

  @yield('content')
  
  </div>
  <!-- <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script> -->
  <script src="{{asset('plugin/js/bootstrap.min.js')}}" type="application/javascript" ></script>
  <script src="{{ asset('assets/js/vendor.js') }}"></script>
    <!-- main js  -->
    <script src="{{ asset('assets/js/main.js') }}"></script>
  @yield('scripts')
  
  
</body>
</html>
