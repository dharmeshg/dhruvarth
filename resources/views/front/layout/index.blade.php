<!doctype html>
<html lang="en">

<head>
    <!--booster Required meta tags -->
    <meta charset="utf-8">
    <!--!, shrink-to-fit=no-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    @include('front.partials.seo-content')

    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('uploads/images/'.$bs->business_favicon) }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('uploads/images/'.$bs->business_favicon) }}">
    <link rel="apple-touch-icon" href="{{ asset('uploads/images/'.$bs->business_favicon) }}">
    <link rel="apple-touch-icon" sizes="{{ asset('uploads/images/'.$bs->business_favicon) }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('uploads/images/'.$bs->business_favicon) }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('uploads/images/'.$bs->business_favicon) }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('uploads/images/'.$bs->business_favicon) }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('uploads/images/'.$bs->business_favicon) }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('uploads/images/'.$bs->business_favicon) }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('uploads/images/'.$bs->business_favicon) }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('uploads/images/'.$bs->business_favicon) }}">

    <link rel="preload" as="style" href="{{asset('front/src/css/bootstrap.min.css')}}">
    <link rel="preload" as="style" href="{{asset('front/src/css/main.css')}}">
    <link rel="preload" as="style" href="{{asset('front/src/css/owl.carousel.min.css')}}">
    <link rel="preload" as="style" href="{{asset('front/src/css/owl.theme.default.min.css')}}">
    <link rel="preload" as="style" href="{{asset('front/src/css/lite-yt-embed.css')}}">
    <link rel="preload" as="style" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.11.0/sweetalert2.min.css">
    <link rel="preload" as="style" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.15/css/intlTelInput.css">
     

    <link rel="preload" as="script" href="{{asset('front/src/js/vendor/jquery.min.js') }}">
    <link rel="preload" as="script" href="{{asset('front/src/js/vendor/bootstrap.bundle.min.js') }}">
    <link rel="preload" as="script" href="{{asset('front/src/js/vendor/owl.carousel.min.js') }}">
    <link rel="preload" as="script" href="{{asset('front/src/js/script.js') }}">
    <link rel="preload" as="script" href="{{asset('front/src/js/vendor/lite-yt-embed.js') }}">

    
    @if(isset($slider_banner) && count($slider_banner) > 0)
        @foreach($slider_banner as $slider_banner_value)
            <link rel="preload" as="image" href="{{ asset('uploads/slider_banner/'.$slider_banner_value->large_img) }}">
            <link rel="preload" as="image" href="{{ asset('uploads/slider_banner/'.$slider_banner_value->small_img) }}">
        @endforeach
    @endif
    <link href="{{asset('front/src/css/bootstrap.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('front/src/css/main.css')}}" defer>
    <link href="{{asset('front/src/css/owl.carousel.min.css')}}" rel="stylesheet" defer>
    <link href="{{asset('front/src/css/owl.theme.default.min.css')}}" rel="stylesheet" defer>
    <link rel="stylesheet" href="{{asset('front/src/css/lite-yt-embed.css')}}" defer>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.11.0/sweetalert2.min.css" defer>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.15/css/intlTelInput.css" defer>

    <script type="text/javascript">
    var BASE_URL = "{{ url('/') }}/";
    // var ADMIN = "admin";
    </script>

    <script>
    var admin_url = '{{ URL::to(' / ') }}';
    </script>
    @yield('seoSchemaContent')
    <style>
        :root {
          --theme-light-color: #9ec6b92f;
          --white: #fff;
          --black: #000;
          --theme-color: <?php echo $bs->theme_color; ?>;
          --border-gray: #acacac;
          --gray: #929497;
          --theme-light-color: <?php echo $bs->theme_color.'78'; ?>;
          --theme-dark-color: #404041;
          --theme-20op-color: #a4e5d1; }
    </style>

</head>

<body>
    
    @include('front.layout.header')
    @yield('main_content')
    @include('front.include.share_model')
    @php
        $daily_status = App\Models\DailyStatus::where('status',1)->first();
        $rs['business_name'] = App\Models\RegistrationFormSetting::where('title','Business Name')->first();
        $rs['full_name'] = App\Models\RegistrationFormSetting::where('title','Full Name')->first();
        $rs['email'] = App\Models\RegistrationFormSetting::where('title','Email')->first();
        $rs['mobile'] = App\Models\RegistrationFormSetting::where('title','Mobile Number + country code')->first();
        $rs['password'] = App\Models\RegistrationFormSetting::where('title','Password + Confirm Password')->first();
        $rs['address_1'] = App\Models\RegistrationFormSetting::where('title','Address Line 1')->first();
        $rs['address_2'] = App\Models\RegistrationFormSetting::where('title','Address Line 2')->first();
        $rs['country_state_city'] = App\Models\RegistrationFormSetting::where('title','Country + State + City')->first();
        $rs['country'] = App\Models\RegistrationFormSetting::where('title','Country')->first();
        $rs['business_card'] = App\Models\RegistrationFormSetting::where('title','Business Card Image')->first();
        $rs['gat_number'] = App\Models\RegistrationFormSetting::where('title','GST Number')->first();
        $rs['website'] = App\Models\RegistrationFormSetting::where('title','Website')->first();
        $rs['social_1'] = App\Models\RegistrationFormSetting::where('title','Social 1')->first();
        $rs['social_2'] = App\Models\RegistrationFormSetting::where('title','Social 2')->first();
        $all_countries = App\Models\Country::all();
        $general_setting = App\Models\Setting::first();
    @endphp
    @include('front.layout.login')
    @if(isset($daily_status))
        <div id="myPopupModelOverlay" class="overlay" style="display: none;">
            <span class="overlay-close closebtn" onclick="closePopupModel()" title="Close Overlay" >×</span>
            <div class="overlay-content col-12 col-sm-6 col-lg-4 col-xl-3 mt-5 pt-5" style="top: 15%;">
                <input type="hidden" id="daily_status_display" value="{{isset($daily_status->display) ? $daily_status->display : ''}}" name="">
                <a  @if(isset($daily_status->destination_link) && $daily_status->destination_link != '') href="{{ $daily_status->destination_link }}" @endif target="_blank" style="display: flex;align-items: center;justify-content: center;"><img src="{{ asset('uploads/daily_updates/'.$daily_status->image) }}" alt="web_banner" class="img-fluid d-lg-block align-self-center"></a>
            </div>
        </div>
    @endif
    @include('front.layout.footer')

    <script>
        var login_user_id = "{{ Auth::check() ? Auth::user()->id : 'null' }}";
        var access_check_route = "{{ route('front.check_user_access') }}";
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
        var subscribeemail = "{{route('scribe_email')}}";
        var get_state_route = "{{route('business.get_state')}}";
        var get_city_route = "{{route('business.get_city')}}";
        var send_token = "{{csrf_token()}}";
        var getpopups = "{{route('get_popups')}}";
        var front_cart = "{{route('front.cart.view')}}";
        var display_pg= "{{$display_pg}}";
        var fullname_required = '{{ $rs['full_name']->mandatory }}';
        var fullname_display = '{{ $rs['full_name']->display }}';
        var email_required = '{{ $rs['email']->mandatory }}';
        var email_display = '{{ $rs['email']->display }}';
        var phone_required = '{{ $rs['mobile']->mandatory }}';
        var phone_display = '{{ $rs['mobile']->display }}';
        var password_required = '{{ $rs['password']->mandatory }}';
        var password_display = '{{ $rs['password']->display }}';
        var business_required = '{{ $rs['business_name']->mandatory }}';
        var business_display = '{{ $rs['business_name']->display }}';
        var gst_no_required = '{{ $rs['gat_number']->mandatory }}';
        var gst_no_display = '{{ $rs['gat_number']->display }}';
        var country_required = '{{ $rs['country_state_city']->mandatory }}';
        var country_display = '{{ $rs['country_state_city']->display }}';
        var city_required = '{{ $rs['country_state_city']->mandatory }}';
        var city_display = '{{ $rs['country_state_city']->display }}';
        var state_required = '{{ $rs['country_state_city']->mandatory }}';
        var state_display = '{{ $rs['country_state_city']->display }}';
        var address_1_required = '{{ $rs['address_1']->mandatory }}';
        var address_1_display = '{{ $rs['address_1']->display }}';
        var address_2_required = '{{ $rs['address_2']->mandatory }}';
        var address_2_display = '{{ $rs['address_2']->display }}';
        var website_required = '{{ $rs['website']->mandatory }}';
        var website_display = '{{ $rs['website']->display }}';
        var business_card_required = '{{ $rs['business_card']->mandatory }}';
        var business_card_display = '{{ $rs['business_card']->display }}';
        var social_1_required = '{{ $rs['social_1']->mandatory }}';
        var social_1_display = '{{ $rs['social_1']->display }}';
        var social_2_required = '{{ $rs['social_2']->mandatory }}';
        var social_2_display = '{{ $rs['social_2']->display }}';
        var getpromocodedata = "{{route('front.promocode.data')}}";
        var gs_limited_access = "{{ $general_setting->access_limited_access }}";
    </script>
    
    <script src="{{asset('front/src/js/vendor/jquery.min.js') }}" ></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.15/css/intlTelInput.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.15/js/intlTelInput.js"></script>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script>
    $(document).ready(function() {
        var input = document.querySelector("#reg_mobile");
        window.addEventListener("load", function () {
          
        var iti = window.intlTelInput(input, {
                initialCountry: "in",
                separateDialCode: true,
                autoPlaceholder: false,
                // utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.15/js/utils.js",
            });
        });

        var input2 = document.querySelector("#login_mobile");
        window.addEventListener("load", function () {
          
        var iti2 = window.intlTelInput(input2, {
                initialCountry: "in",
                separateDialCode: true,
                autoPlaceholder: false,
                // utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.15/js/utils.js",
            });
        });
    })
    </script>
    <script defer>
       $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

       $('.navbar-toggler, .close-icon-btn').on('click', function() {
            if ($('.mobile-header-menu').hasClass("show")) {
                $('.mobile-header-menu').removeClass('show');
                $('.open-icon').show();
                $('.close-icon').hide();
            } else {
                $('.mobile-header-menu').addClass('show');
                $('.open-icon').hide();
                $('.close-icon').show();
            }

        });
    </script>
    <script src="{{asset('front/src/js/vendor/owl.carousel.min.js') }}"></script>
    <script src="{{asset('front/src/js/vendor/bootstrap.bundle.min.js') }}"></script>
    <script src="{{asset('front/src/js/script.js') }}" defer></script>
     
    <!--<script src="{{asset('front/src/js/vendor/lite-yt-embed.js') }}" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer" defer></script>-->

    <!--<script src="{{ asset('front/theme2/js/custom.js') }}" defer></script>-->
    @if(Request::is('order-checkout'))
        <script defer>
              function preventBack(){window.history.forward();}
              setTimeout("preventBack()", 0);
              window.onunload=function(){null};

        </script>
    
    @endif
    @if(session('showLoginPopup'))
        <script>
            $(document).ready(function() {
                setTimeout(function() {
                    $('#login-popup').modal('show');
                    $('#login-modal-close-btn').hide();
                    $('#skip_login_text').hide();
                    reCaptchaOnFocus2();
                }, 1000);
            });
        </script>
    @else
        <script>
            $('#login-modal-close-btn').show();
            $('#skip_login_text').show();
        </script>
    @endif
    @if(session('showexpiredalert'))
        <script>
            $(document).ready(function() {
                setTimeout(function() {
                    Swal.fire({
                        title: 'Access Expired',
                        text: 'Your access time has expired.',
                        icon: 'warning',
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        customClass: {
                            popup: 'swal2-center'
                        }
                    });
                    setTimeout(function() {
                        document.getElementById('user-logout-form').submit();
                    }, 2000);
                }, 1500);
            });
        </script>
    @endif


    <script defer>

        // Helper function
        // let domReady = (cb) => {
        // document.readyState === 'interactive' || document.readyState === 'complete'
        //   ? cb()
        //   : document.addEventListener('DOMContentLoaded', cb);
        // };

        // domReady(() => {
        // // Display body when DOM is loaded
        // document.body.style.visibility = 'visible';
        // });

        function book_a_gold_rate(purity,rate){
            window.open('https://api.whatsapp.com/send?phone={{$bs->country_code_number.''.$bs->whatsapp_number}}&text=Hi, I Would Like To BookMyGoldPrice As Displayed on {{route("home")}} ('+ purity + ' 1gm rate ₹ '+ rate + ' {{date("d-m-Y")}}). Please Confirm, Thank you.');
        }

        $(window).on("load", function () {
            setTimeout(function () {
                reCaptchaOnFocus(); 
            }, 1000);
        });
        
        // $(window).on("load", function () {
        //     setTimeout(function () {
        //         reCaptchaOnFocus3(); 
        //     }, 5000);
        // });
        
        // $(window).on("load", function () {
        //     setTimeout(function () {
        //         reCaptchaOnFocus4(); 
        //     }, 3000);
        // });

        function reCaptchaOnFocus() {

          var head = document.getElementsByTagName('head')[0]

          var script3 = document.createElement('script')
          script3.type = 'text/javascript';
          script3.src = "https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.11.0/sweetalert2.min.js"
          head.appendChild(script3);
          
          var script4 = document.createElement('script')
          script4.type = 'text/javascript';
          script4.src = "{{asset('front/src/js/custom.js') }}";
          head.appendChild(script4);

        }
        
        @include('front.partials.analytics.TrackEvents.google.add_to_cart')
        @include('front.partials.analytics.TrackEvents.facebook.add_to_cart')
        @include('front.partials.analytics.TrackEvents.facebook.add_to_wishlist')
        @include('front.partials.analytics.TrackEvents.google.add_to_wishlist')
        
        $(window).one('scroll',function() {
            reCaptchaOnFocus2();
        });
        $(".dropdown-user").click(function () {
          reCaptchaOnFocus2();
        });
        
        function reCaptchaOnFocus2() {
          var head = document.getElementsByTagName('head')[0]
          var script = document.createElement('script')
          script.type = 'text/javascript';
          script.src = 'https://www.google.com/recaptcha/api.js'
          head.appendChild(script);

          var head = document.getElementsByTagName('head')[0]
          var script2 = document.createElement('script')
          script2.type = 'text/javascript';
          script2.src = "{{ asset('front/src/js/vendor/lite-yt-embed.js') }}"
          head.appendChild(script2);

        };
        
        
        (function(global){
	global.$_Tawk_AccountKey='66a4c6b132dca6db2cb67b4d';
	global.$_Tawk_WidgetId='1i3pqg9rn';
	global.$_Tawk_Unstable=false;
	global.$_Tawk = global.$_Tawk || {};
	(function (w){
	function l() {
		if (window.$_Tawk.init !== undefined) {
			return;
		}

		window.$_Tawk.init = true;

		var files = [
			'https://embed.tawk.to/_s/v4/app/66d916256f5/js/twk-main.js',
			'https://embed.tawk.to/_s/v4/app/66d916256f5/js/twk-vendor.js',
			'https://embed.tawk.to/_s/v4/app/66d916256f5/js/twk-chunk-vendors.js',
			'https://embed.tawk.to/_s/v4/app/66d916256f5/js/twk-chunk-common.js',
			'https://embed.tawk.to/_s/v4/app/66d916256f5/js/twk-runtime.js',
			'https://embed.tawk.to/_s/v4/app/66d916256f5/js/twk-app.js'
		];

		if (typeof Promise === 'undefined') {
			files.unshift('https://embed.tawk.to/_s/v4/app/66d916256f5/js/twk-promise-polyfill.js');
		}

		if (typeof Symbol === 'undefined' || typeof Symbol.iterator === 'undefined') {
			files.unshift('https://embed.tawk.to/_s/v4/app/66d916256f5/js/twk-iterator-polyfill.js');
		}

		if (typeof Object.entries === 'undefined') {
			files.unshift('https://embed.tawk.to/_s/v4/app/66d916256f5/js/twk-entries-polyfill.js');
		}

		if (!window.crypto) {
			window.crypto = window.msCrypto;
		}

		if (typeof Event !== 'function') {
			files.unshift('https://embed.tawk.to/_s/v4/app/66d916256f5/js/twk-event-polyfill.js');
		}

		if (!Object.values) {
			files.unshift('https://embed.tawk.to/_s/v4/app/66d916256f5/js/twk-object-values-polyfill.js');
		}

		if (typeof Array.prototype.find === 'undefined') {
			files.unshift('https://embed.tawk.to/_s/v4/app/66d916256f5/js/twk-arr-find-polyfill.js');
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
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-QFXT1LVP67"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-QFXT1LVP67');

    </script>
    <script>
        // alert(login_user_id);
        if(login_user_id !== null && login_user_id !== 'null' && login_user_id !== undefined)
        {
            // Pusher.logToConsole = true;
            var pusher = new Pusher('c74d7c7ce0a19accbbe7', {
                cluster: 'ap2',
            });
            var channel = pusher.subscribe('access-channel'); 
            channel.bind('AccessChanged', function(data) {
                console.log('yes');
                if(data.user.id == login_user_id)
                {
                    if((data.user.site_access == 1) && (gs_limited_access != null && gs_limited_access == 1))
                    {
                        var currentDate = new Date();
                        var endDateTime = new Date(data.user.site_access_end_date + ' ' + data.user.site_access_end_time);
                        if (endDateTime < currentDate) {
                            Swal.fire({
                                title: 'Access Expired',
                                text: 'Your access time has expired.',
                                icon: 'warning',
                                allowEscapeKey: false,
                                showConfirmButton: false,
                                customClass: {
                                    popup: 'swal2-center'
                                }
                            });
                            setTimeout(function() {
                                $.ajax({
                                    url: '{{ route('user.logout') }}', 
                                    method: 'POST',
                                    data: {
                                        _token: '{{ csrf_token() }}',
                                    },
                                    success: function(response) {
                                        if(response.status == 1)
                                        {
                                            location.reload();
                                        }
                                    },
                                });
                            }, 2000);
                        }
                    }
                }
            });
            var pchannel = pusher.subscribe('product-access-channel'); 
            pchannel.bind('ProductAccessChanged', function(data) {
                console.log('yessss');
                if(data.user.id == login_user_id)
                {
                    
                    if(data.user.product_access == 1)
                    {
                        var pcurrentDate = new Date();
                        var pendDateTime = new Date(data.user.end_date + ' ' + data.user.end_time);
                        if (pendDateTime < pcurrentDate) {
                            $('#new-design-slider .new-design-each[data-product-type="private"]').each(function() {
                                $(this).closest('.owl-item').hide();
                            });
                            $('#most-popular-slider .most-popular-each[data-product-type="private"]').each(function() {
                                $(this).closest('.owl-item').hide();
                            });
                            $('#product_list .all-product-each[data-product-type="private"]').hide();
                            $('.all-cat-products .each-catalog-product[data-product-type="private"]').hide();
                            $('#similar-products-slider .similar-each-product[data-product-type="private"]').each(function() {
                                $(this).closest('.owl-item').hide();
                            });
                            var currentPath = window.location.pathname;
                            if (currentPath.startsWith('/products')) {
                                var is_private = $('#product-detail-type').val();
                                if(is_private == 'private')  
                                {
                                    window.location.href = '/';
                                }         
                            }
                        }
                    }
                }
            });

            function check_access_data(login_user_id)
            {
                 $.ajax({
                    url: access_check_route, 
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        user_id: login_user_id,
                    },
                    success: function(response) {
                    
                    },
                });
            }
            check_access_data(login_user_id);
            setInterval(function() {
                check_access_data(login_user_id);
            }, 30000);
        }
    </script>
    @yield('script')

</body>

</html>