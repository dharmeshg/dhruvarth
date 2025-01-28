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
    <meta name="description" content="Jewelxy">
    <meta name="author" content="Jewelxy">
    <meta name="keyword" content="Jewelxy">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="keyword" content="Bootstrap,Admin,Template,Open,Source,jQuery,CSS,HTML,RWD,Dashboard">
    <title>{{ $setting->business_name }}</title>
    
    <link rel="manifest" href="{{ asset('assets/favicon/manifest.json') }}">
    
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('uploads/images/'.$bs->business_favicon) }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ asset('assets/favicon/ms-icon-144x144.png') }}">
    <meta name="theme-color" content="#ffffff">
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome/css/fontawesome-all.min.css') }}">
    <!-- animation css -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/animation/css/animate.min.css') }}">
    <!-- vendor css -->
    
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">

    <!-- Vendors styles-->
    <link rel="stylesheet" href="{{ asset('vendors/simplebar/css/simplebar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/vendors/simplebar.css') }}">
    <!-- Main styles for this application-->
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('css/toastr.min.css') }}" type="text/css" rel="stylesheet">


    <link href="{{ asset('vendors/@coreui/chartjs/css/coreui-chartjs.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/jquery.dataTablesresponsive.min.css') }}">
    
    
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/dropzone/dropzone.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/plugins/chart-morris/css/morris.css') }}">
    <link href="{{ asset('css/datapicker.min.css') }}" rel="stylesheet" type="text/css" />
    


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs4.min.css">
    <!-- <link href="{{ asset('css/summernote.css') }}" rel="stylesheet"> -->


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/css/intlTelInput.css">


    <script type="text/javascript">
    var admin_url = "{{ url('/') }}/admin/";
    </script>

    <script>
    var BASE_URL = '{{ url('/') }}';
    </script>
    <style>
        .parsley-errors-list {
            color: red; 
            list-style-type: none;
            padding: 10px 0 0 !important;
        }
    </style>
    <style>
    :root {
        --theme-orange-red: <?php echo $bs->theme_color ?>;
        --theme-light-color: <?php echo $bs->theme_color.'3f'; ?>;
        --theme-dark-color: <?php echo $bs->theme_color.'7f'; ?>;
    }
    </style>
</head>

   

@php
        $bssetting = App\Models\BusinessSetting::first();
@endphp


<body>
    @include('layouts.backend.sidebar')

    {{-- <div class="wrapper d-flex flex-column min-vh-100 bg-light"> --}}


        @include('layouts.backend.navbar')
        <div class="pcoded-main-container">
                @yield('main_content')
        
        </div>   

        @include('layouts.backend.footer')
        <div class="modal" tabindex="-1" id="help_modal" style="top: 30%;">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Help</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <p id="help-text"></p>
              </div>
            </div>
          </div>
        </div>

    {{-- </div> --}}
    <!-- CoreUI and necessary plugins-->
   
    <script src="{{ asset('js/jquery-3.6.0.min.js')}}"></script>



    {{-- <!-- <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script> --> --}}
    {{-- <script src="{{ asset('js/jquery.dataTables.min.js')}}"></script> --}}
    

    <!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script> -->
    <script src="{{ asset('js/sweetalert/sweetalert2.all.min.js')}}"></script>
    <script src="{{ asset('vendors/@coreui/coreui/js/coreui.bundle.min.js') }}"></script>
    <!-- Plugins and scripts required by this view-->
    <!-- <script src="{{ asset('vendors/chart.js/js/chart.min.js') }}"></script> -->
    <script src="{{ asset('vendors/@coreui/chartjs/js/coreui-chartjs.js') }}"></script>
    <script src="{{ asset('vendors/@coreui/utils/js/coreui-utils.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('js/toastr/toastr.min.js')}}"></script>
    <script src="{{ asset('js/inputmask/inputmask.js')}}"></script>
    <script src="{{ asset('js/select2.min.js')}}"></script>
	<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <script src="{{ asset('assets/js/pcoded.min.js') }}"></script>
    <script src="{{ asset('assets/dropzone/dropzone.js') }}"></script>
    <!-- <script src="{{ asset('assets/inputMask/bootstrap_input_mask.min.js') }}"></script> -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"></script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote.min.js"></script>
    <script src="{{ asset('js/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('js/jquery.dataTablesresponsive.min.js')}}"></script>



    <script src="https://use.fontawesome.com/7ad89d9866.js"></script>

    
    {{-- charts --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/intlTelInput-jquery.min.js"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.14.1/moment.min.js"></script>
    <script src="{{ asset('assets/datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/js/excelexportjs.js')}}"></script>

    
<script>
    $(document).ready(function() {
        // Function to handle screen size changes
        function handleScreenSizeChange() {
            var windowWidth = $(window).width();
            var element = $('.pcoded-navbar');
            if (windowWidth <= 992) {
                element.removeClass('navbar-collapsed');
            } else {
                element.removeClass('navbar-collapsed');
            }
        }

        // Call handler initially
        handleScreenSizeChange();

        // Attach handler to resize event
        $(window).resize(handleScreenSizeChange);
    });
</script>
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
    window.assetPath = "{{ asset('assets/images/user/img-demo_1041.jpg') }}";
    </script>
    <script>
    $(document).ready(function () {
        // Apply input masking to the phone input field
        $('.imput-mask').inputmask('(999) 999-9999');
        $('.input-money').maskMoney();
        $('.input-money-price').inputmask("currency",{prefix: '$ ',alias: 'numeric',rightAlign: false,autoUnmask: true});
        $('.phone-imput-mask').inputmask('9999999999');

    });
    $(document).ready(function () {
        // Apply input masking to the phone input field
        $('.select2').select2({
            placeholder: "Select Category"
        });
        $('#artical_tags').select2({
            placeholder: "Select Tag"
        });
        $('.select2').select2({
            placeholder: "Select"
        });
    });
</script>
<script>
       $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
</script>


    <script src="{{ asset('js/parsley/parsley.min.js')}}"></script>
    <script src="{{ asset('js/passwordcdn/cdnjs.cloudflare.com_ajax_libs_zxcvbn_4.4.2_zxcvbn.js')}}"></script>
    <script src="{{ asset('assets/plugins/chart-morris/js/raphael.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/chart-morris/js/morris.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery-ui/js/jquery-ui.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/pages/chart-morris-custom.js') }}"></script> --}}

<script src="{{ asset('assets/datepicker/bootstrap-datepicker.min.js') }}"></script>
    
    @yield('script')
</body>

</html>