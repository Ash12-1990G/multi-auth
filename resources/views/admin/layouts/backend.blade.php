<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->

    <!-- <script src="{{ asset('js/app.js') }}" defer></script> -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    @stack('styles')
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <!-- Google Font: Source Sans Pro -->
    
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link href="{{ asset('plugins/summernote/summernote-bs4.css') }}" rel="stylesheet">
    
    <style>
        .dataTables_wrapper .dataTables_processing {
        background: #f4f6f9;
        color:#007bff;
        font-weight:600;
        border: 1px solid #f4f6f9;
        border-radius: 3px;
        }   
        /* .card-header-custom{
            background-color:#7d818333 !important;
        } */
    </style>
    
  
    <!-- Fonts -->
    <!-- <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet"> -->

    <!-- Styles -->
    <!-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> -->
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div id="app">
        @include('admin.layouts.navbar')
        @include('admin.layouts.sidebar')
        <div class="content-wrapper">
            @yield('content')
        </div>
    </div>
    <!-- jQuery -->

<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- custom file upload-->

<script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>

<!-- AdminLTE App -->
<script type="text/javascript">
    function tosterMessage(status,msg){
            switch(status){
                case 'success': toastr.success(msg);break;
                case 'error': toastr.error(msg);break;
                default: toastr.success(msg);break;
            }
        }
</script>


@yield('scripts')
<script type="text/javascript">
    
    
    $(function () {
        $('.form-normal').submit(function () {
            // if (typeof checkCoordinates === 'function') {
                
            //     const [lat,lon]= await checkCoordinates();
            //     console.log(lat);
            // }
                $(':submit').attr('disabled', 'disabled');
                $('#app').append('<div class="overlay"><div class="overlay__inner"><div class="overlay__content"><span class="spinner"></span></div></div></div>');
           
        });
        
    });
    
</script>

<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>

</body>
</html>
