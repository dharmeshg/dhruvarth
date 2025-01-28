<!doctype html>
<html lang="en">

<head>
    <!--booster Required meta tags -->
    <meta charset="utf-8">
    <!--!, shrink-to-fit=no-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    
    @include('front.partials.seo-content')

    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('uploads/'.$bs->business_favicon) }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('uploads/'.$bs->business_favicon) }}">
    <link rel="apple-touch-icon" href="{{ asset('uploads/'.$bs->business_favicon) }}">
    <link rel="apple-touch-icon" sizes="{{ asset('uploads/'.$bs->business_favicon) }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('uploads/'.$bs->business_favicon) }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('uploads/'.$bs->business_favicon) }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('uploads/'.$bs->business_favicon) }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('uploads/'.$bs->business_favicon) }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('uploads/'.$bs->business_favicon) }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('uploads/'.$bs->business_favicon) }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('uploads/'.$bs->business_favicon) }}">
    <link rel="preload" as="style" href="{{ asset('front/theme2/css/bootstrap.css') }}" onload="this.onload=null;this.rel='stylesheet'"/>
    <link rel="preload" as="style" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    

<style>
:root {
--theme-black : #000000;
--theme-white : #ffffff;
--theme-zircon-grey: #F0F1F1;
--theme-alabaster-grey: #F7F7F7;
--theme-ship-grey: #414042;
--theme-oslo-grey: #929497;
--theme-iron-grey : #E5E6E7;
--theme-iron-two-grey: #D0D2D3;
--theme-nero-grey: #231F20;
--theme-dove-grey: #707070;
--theme-nevada-grey: #6D6E71;
--theme-silver-sand-grey: #BCBEC0;
--theeme-shark-black: #1B1B22;
--theme-orange-red: <?php echo $bs->theme_color; ?>;
--theme-light-color: <?php echo $bs->theme_color.'2f'; ?>;
--theme-dark-color: <?php echo $bs->theme_color.'3f'; ?>;
--theme-robin-red: #d2a564;
/*--theme-antique-brass-red: #d2a564;*/
--theme-antique-brass-red: <?php echo $bs->theme_color; ?>;


}

.disableClick{
    pointer-events: none;
    background: #e3e3e3 !important;
    border: 1px solid #e3e3e3 !important;
}
</style>

    <link rel="preload" as="style" href="{{ asset('front/theme2/css/megamenu.css') }}" />
    <link rel="preload" as="style" href="{{ asset('front/theme2/css/owl.carousel.css') }}">
    <link rel="preload" as="style" href="{{ asset('front/theme2/css/custom-theme.css') }}">
    <link rel="preload" as="style" href="{{ asset('front/theme2/css/form-control.css') }}">
    <link rel="preload" as="style" href="{{ asset('front/theme2/css/style.css') }}">
    <link rel="preload" as="style" href="{{ asset('front/theme2/css/responsive.css') }}">
    <link rel="preload" as="style" href="{{ asset('front/theme2/css/bootstrap-datepicker.css') }}">
    <link rel="preload" as="style" href="{{ asset('front/theme2/css/slick.css') }}">
    <link rel="preload" as="style" href="{{ asset('front/theme2/css/sweet-alert.css') }}">
    <link rel="preload" as="style" href="{{ asset('front/theme2/css/toastr.css') }}">
    <link rel="preload" as="style" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/css/intlTelInput.css">
    
    <link rel="preload" as="script" href="{{ asset('front/theme2/js/jquery.min.js') }}">
    <!--<link rel="preconnect" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" integrity="sha512-+NqPlbbtM1QqiK8ZAo4Yrj2c4lNQoGv8P79DPtKzj++l5jnN39rHA/xsqn8zE9l0uSoxaCdrOgFs6yjyfbBxSg==" crossorigin="anonymous" referrerpolicy="no-referrer">-->
    <link rel="preload" as="script" href="{{ asset('front/theme2/js/popper.min.js') }}">
    <!--<link rel="preload" as="script" href="{{ asset('front/theme2/js/jquery-ui.js') }}">-->
    <link rel="preload" as="script" href="{{ asset('front/theme2/js/bootstrap.min.js') }}">
    <link rel="preload" as="script" href="{{ asset('front/theme2/js/owl.carousel.js') }}">
    <link rel="preload" as="script" href="{{ asset('front/theme2/js/bootstrap-datepicker.js') }}">
    <link rel="preload" as="script" href="{{ asset('front/theme2/js/slick.min.js') }}">
    <!--<link rel="preload" as="script" href="{{ asset('front/theme2/js/liteyoutube.js') }}">-->
    <link rel="preload" as="script" href="{{ asset('front/theme2/js/global.js') }}">
    <link rel="preload" as="script" href="{{ asset('front/theme2/js/custom.js') }}">
    <link rel="preload" as="script" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/intlTelInput-jquery.min.js">
    <!--<link rel="preconnect" href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap" as="font" type="font/format" crossorigin>-->

    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'"/>
    
    @if(isset($slider_banner))
        @foreach($slider_banner as $key=>$vl)
            <link rel="preload" as="image" href="{{ asset('uploads/daily_updates/'.$vl->large_img) }}">
            <link rel="preload" as="image" href="{{ asset('uploads/daily_updates/'.$vl->medium_img) }}">
            <link rel="preload" as="image" href="{{ asset('uploads/daily_updates/'.$vl->small_img) }}">
        @endforeach
    @endif

    <noscript>
        <link href='https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap' rel='stylesheet' type="text/css">
        <link rel="stylesheet" href="{{ asset('front/theme2/css/bootstrap.css') }}" type="text/css">
    </noscript>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" async>
    <link rel="stylesheet" href="{{ asset('front/theme2/css/megamenu.css') }}" async>
    <link rel="stylesheet" href="{{ asset('front/theme2/css/style.css') }}" defer>
    <link rel="stylesheet" href="{{ asset('front/theme2/css/responsive.css') }}" async>
    <link rel="stylesheet" href="{{ asset('front/theme2/css/owl.carousel.css') }}" async>
    <link rel="stylesheet" href="{{ asset('front/theme2/css/custom-theme.css') }}" async>
    <link rel="stylesheet" href="{{ asset('front/theme2/css/form-control.css') }}" async>
    <link rel="stylesheet" href="{{ asset('front/theme2/css/bootstrap-datepicker.css') }}" async>
    <link rel="stylesheet" href="{{ asset('front/theme2/css/slick.css') }}" async>
    <link rel="stylesheet" href="{{ asset('front/theme2/css/toastr.css') }}" async>
    <link rel='stylesheet' href="{{ asset('front/theme2/css/sweet-alert.css') }}" async>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/css/intlTelInput.css" async>
    
    <!--<script src="https://www.google.com/recaptcha/api.js" async defer></script>-->
     
    <link rel="stylesheet" href="{{ asset('front/theme2/css/liteyoutube.css') }}" async>
        <script type="text/javascript">
    var BASE_URL = "{{ url('/') }}/";
    // var ADMIN = "admin";
    </script>

    <script>
    var admin_url = '{{ URL::to(' / ') }}';
    </script>
    @yield('seoSchemaContent')

</head>

<body class="theme-light">
   
    @include('front.layout.header')
    @yield('main_content')
    @include('front.layout.footer')
    @include('front.include.share_model')

    <input type="hidden" id="closePath" value="{{asset('front/theme2/images/close-icon.svg')}}">
    <input type="hidden" id="left_arrow" value="{{asset('front/theme2/images/left-arrow.svg')}}">
    <input type="hidden" id="right_arrow" value="{{asset('front/theme2/images/right-arrow.svg')}}">


   @include('front.layout.login')

   @include('front.layout.forgot_password')

   @include('front.layout.update_password')

    <div class="modal fade promo-code-popup width-700" id="initial_promo_code_list" data-backdrop="static"
        data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close-modal" data-dismiss="modal">
                        <img src="{{ asset('front/theme2/images/close-icon.svg') }}" alt="close">
                    </button>
                    <div class="my-account-detail">
                        <h4 class="text-center mb-2">Limited-Time Offers</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @php
        $daily_status = App\Models\DailyStatus::where('status',1)->first();
    @endphp
    @if(isset($daily_status))
        <div id="myPopupModelOverlay" class="overlay" style="display: none;">
            <span class="overlay-close closebtn" onclick="closePopupModel()" title="Close Overlay" >×</span>
            <div class="overlay-content col-12 col-sm-6 col-lg-4 col-xl-3 mt-5 pt-5" style="top: 15%;">
                <input type="hidden" id="daily_status_display" value="{{isset($daily_status->display) ? $daily_status->display : ''}}" name="">
                <a  @if(isset($daily_status->destination_link) && $daily_status->destination_link != '') href="{{ $daily_status->destination_link }}" @endif target="_blank" style="display: flex;align-items: center;justify-content: center;"><img src="{{ asset('uploads/daily_updates/'.$daily_status->image) }}" alt="web_banner" class="img-fluid d-lg-block align-self-center"></a>
            </div>
        </div>
    @endif

    <script src="{{ asset('front/theme2/js/jquery.min.js') }}"></script>
    <script src="{{ asset('front/theme2/js/owl.carousel.js') }}" defer></script>
    <script src="{{ asset('front/theme2/js/popper.min.js') }}" defer></script>
    <script src="{{ asset('front/theme2/js/bootstrap.min.js') }}" defer></script>
    <script src="{{ asset('front/theme2/js/bootstrap-datepicker.js') }}" defer></script>
    <script src="{{ asset('front/theme2/js/slick.min.js') }}" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/intlTelInput-jquery.min.js" defer></script>

    <script src="{{ asset('front/theme2/js/form-validation.init.js') }}" defer></script>
    <script src="{{ asset('front/theme2/js/parsleyjs.min.js') }}" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" defer></script>
    <script src="{{ asset('js/sweetalert/sweetalert2.all.min.js')}}" defer></script>
    
    <script src="{{ asset('front/theme2/js/global.js') }}" defer></script>

    <script>
        var loginRoute = "{{route('user.login')}}";
        var updatepass = "{{route('user.updatePassword')}}";
        var forgotpass = "{{route('user.forgetPassword')}}";
        var registeruser = "{{route('user.register')}}";
        var sendregcd = "{{route('user.sendregverificationCode')}}";
        var addtocrt = "{{ route('front.add.cart.products') }}";
        var addwishlst = "{{route('front.add.wishlist.products')}}";
        var homecatdet = "{{ route('home.category.details') }}";
        var sharemodel = "{{ route('home.share.model') }}";
        var serchprdct = "{{ route('search.product.detail') }}";
    </script>
    <script src="{{ asset('front/theme2/js/custom.js') }}" defer></script>
    @if(Request::is('order-checkout'))
        
        <script defer>
              function preventBack(){window.history.forward();}
              setTimeout("preventBack()", 0);
              window.onunload=function(){null};
        </script>
    
    @endif

    @if(!Request::is('home'))
        
        <script src="{{ asset('front/theme2/js/product.js') }}" defer></script>
    
    @endif

    <script defer>
        $(document).ready(function() {
            toastr.options.timeOut = 10000;
            @if(Session::has('error'))
            toastr.error('{{ Session::get("error") }}');
            @elseif(Session::has('success'))
            toastr.success('{{ Session::get("success") }}');
            @endif
        });

        function reCaptchaOnFocus() {
          // var head = document.getElementsByTagName('head')[0]
          // var script = document.createElement('script')
          // script.type = 'text/javascript';
          // script.src = 'https://www.google.com/recaptcha/api.js'
          // head.appendChild(script);

          // var head = document.getElementsByTagName('head')[0]
          // var script2 = document.createElement('script')
          // script2.type = 'text/javascript';
          // script2.src = "{{ asset('front/theme2/js/liteyoutube.js') }}"
          // head.appendChild(script2);

        };

       
        
        @include('front.partials.analytics.TrackEvents.google.add_to_cart')
        @include('front.partials.analytics.TrackEvents.facebook.add_to_cart')
        @include('front.partials.analytics.TrackEvents.facebook.add_to_wishlist')
        @include('front.partials.analytics.TrackEvents.google.add_to_wishlist')
        

        $(window).scroll(function () {
          reCaptchaOnFocus();
        });
        $(".top-header-list ul > li a").click(function () {
          reCaptchaOnFocus();
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

    </script>
    
    
    

    <input type="hidden" id="fire_base_apiKey" value="">
    <input type="hidden" id="fire_base_authDomain" value="">
    <input type="hidden" id="fire_base_projectId" value="">
    <input type="hidden" id="user_id" value="" name="user_id">

    <!--<script defer>
        @include('front.partials.analytics.TrackEvents.google.add_to_cart')
        @include('front.partials.analytics.TrackEvents.facebook.add_to_cart')
        @include('front.partials.analytics.TrackEvents.facebook.add_to_wishlist')
        @include('front.partials.analytics.TrackEvents.google.add_to_wishlist')
    </script>-->

    @yield('script')

     <script defer>
        function book_a_gold_rate(purity,rate){
            window.open('https://api.whatsapp.com/send?phone=+{{$bs->country_code_number.''.$bs->whatsapp_number}}&text=Hi, I Would Like To BookMyGoldPrice As Displayed on {{route("home")}} ('+ purity + ' 1gm rate ₹ '+ rate + ' {{date("d-m-Y")}}). Please Confirm, Thank you.');
        }
        (function(global){
            global.$_Tawk_AccountKey='65606b9ada19b36217906144';
            global.$_Tawk_WidgetId='1hg0a8ltk';
            global.$_Tawk_Unstable=false;
            global.$_Tawk = global.$_Tawk || {};
            (function (w){
            function l() {
                if (window.$_Tawk.init !== undefined) {
                    return;
                }

                window.$_Tawk.init = true;

                var files = [
                    'https://embed.tawk.to/_s/v4/app/6625f366c87/js/twk-main.js',
                    'https://embed.tawk.to/_s/v4/app/6625f366c87/js/twk-vendor.js',
                    'https://embed.tawk.to/_s/v4/app/6625f366c87/js/twk-chunk-vendors.js',
                    'https://embed.tawk.to/_s/v4/app/6625f366c87/js/twk-chunk-common.js',
                    'https://embed.tawk.to/_s/v4/app/6625f366c87/js/twk-runtime.js',
                    'https://embed.tawk.to/_s/v4/app/6625f366c87/js/twk-app.js'
                ];

                if (typeof Promise === 'undefined') {
                    files.unshift('https://embed.tawk.to/_s/v4/app/6625f366c87/js/twk-promise-polyfill.js');
                }

                if (typeof Symbol === 'undefined' || typeof Symbol.iterator === 'undefined') {
                    files.unshift('https://embed.tawk.to/_s/v4/app/6625f366c87/js/twk-iterator-polyfill.js');
                }

                if (typeof Object.entries === 'undefined') {
                    files.unshift('https://embed.tawk.to/_s/v4/app/6625f366c87/js/twk-entries-polyfill.js');
                }

                if (!window.crypto) {
                    window.crypto = window.msCrypto;
                }

                if (typeof Event !== 'function') {
                    files.unshift('https://embed.tawk.to/_s/v4/app/6625f366c87/js/twk-event-polyfill.js');
                }

                if (!Object.values) {
                    files.unshift('https://embed.tawk.to/_s/v4/app/6625f366c87/js/twk-object-values-polyfill.js');
                }

                if (typeof Array.prototype.find === 'undefined') {
                    files.unshift('https://embed.tawk.to/_s/v4/app/6625f366c87/js/twk-arr-find-polyfill.js');
                }

                var s0=document.getElementsByTagName('script')[0];

                for (var i = 0; i < files.length; i++) {
                    var s1 = document.createElement('script');
                    s1.src= files[i];
                    s1.charset='UTF-8';
                    s1.setAttribute('crossorigin','*');
                    s0.parentNode.insertBefore(s1,s0);
                }
            }
            if (document.readyState === 'complete') {
                l();
            } else if (w.attachEvent) {
                w.attachEvent('onload', l);
            } else {
                w.addEventListener('load', l, false);
            }
        })(window);

        })(window);
   
    </script>
</body>

</html>