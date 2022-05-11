<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->

    <script src="{{ asset('js/app.js') }}" defer></script>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    
   <style>
      body {
    height: 100%;
    /* background: linear-gradient(90deg, #FFC0CB 50%, #00FFFF 50%); */
    background: linear-gradient(22deg, #abcef3 50%, #e2e4e7 50%);
}
   </style>
</head>
<body>
    <div id="app" class="mt-5">
        
            @yield('content')
            <div class="footer-bottom text-center">
                
                <p>Copyright ©2022 <a href="{{route('front.home')}}" class="fw-bold text-dark"><span class="text-primary">ACTI-</span>INDIA</a></p>
            </div>
    </div>
    <!-- jQuery -->

<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- custom file upload-->

<script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<!-- AdminLTE App -->
@yield('scripts')
<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>

</body>
</html>
