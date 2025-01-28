<!DOCTYPE html>
<html lang="en">

<head>
     @php
        $setting = App\Models\BusinessSetting::first();
    @endphp
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="{{ $setting->business_name }}">
    <meta name="author" content="{{ $setting->business_name }}">
    <meta name="keyword" content="{{ $setting->business_name }}">
    <title>{{ $setting->business_name }}</title>
    <link rel="manifest" href="{{ asset('assets/favicon/manifest.json') }}">
    @if(isset($setting) && $setting != '')
    <link rel="icon" type="image/x-icon" href="{{ asset('uploads/images/'.$setting->business_favicon) }}">
    @endif
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ asset('assets/favicon/ms-icon-144x144.png') }}">
    <meta name="theme-color" content="#ffffff">
    <!-- Vendors styles-->
    <link rel="stylesheet" href="{{ asset('vendors/simplebar/css/simplebar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/vendors/simplebar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <!-- Main styles for this application-->
    {{-- <link href="{{ asset('css/style.css') }}" rel="stylesheet"> --}}
    <!-- We use those styles to show code examples, you should remove them in your application.-->
    <link href="{{ asset('css/examples.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome/css/fontawesome-all.min.css') }}">
    <style>
        .parsley-errors-list {
            color: red; 
            list-style-type: none;
            padding: 10px 0 0 !important;
        }
    </style>
    <style>

    :root {
        --theme-orange-red: <?php echo $setting->theme_color; ?>;
        --theme-light-color: <?php echo $setting->theme_color.'3f'; ?>;
        --theme-dark-color: <?php echo $setting->theme_color.'7f'; ?>;
    }
    </style>
</head>

<body>
            @yield('content')
           
    <!-- CoreUI and necessary plugins-->
    {{-- <script src="{{ asset('vendors/@coreui/coreui/js/coreui.bundle.min.js') }}"></script> --}}
    <script src="{{ asset('js/jquery-3.6.0.min.js')}}"></script>
    <script src="{{ asset('vendors/simplebar/js/simplebar.min.js') }}"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
   
    <script>
        $(document).ready(function() {
            toastr.options.timeOut = 10000;
            @if(Session::has('error'))
            toastr.error('{{ Session::get("error") }}');
            @elseif(Session::has('success'))
            toastr.success('{{ Session::get("success") }}');
            @endif
        });
        </script>
        <script>
            $('#show_password').click(function(){
                var attr = $('#password').attr('type');
                if(attr == 'password')
                {
                    $('#password').prop('type','text');
                    $('.fa-eye').hide();
                    $('.fa-eye-slash').show();
                }else{
                    $('#password').prop('type','password');
                    $('.fa-eye').show();
                    $('.fa-eye-slash').hide();
                }
            });
        </script>
<script src="{{ asset('js/parsley/parsley.min.js')}}"></script>
@yield('script')
</body>

</html>