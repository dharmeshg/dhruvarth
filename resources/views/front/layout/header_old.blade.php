@php
  $pc = App\Models\Category::get();
  $notification = App\Models\Notification::where('status',1)->first();
  $category_first = App\Models\Category::orderBy('category', 'asc')->first();
@endphp
<!--<link rel="stylesheet" src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">-->

<style>
    .notification-sec{
        background: var(--theme-orange-red);
        color: #fff;
        padding: 15px;
    }
    .notification-sec .main-sec{color: #fff;}
    .notification-sec .header-sec{text-align: center;}
    .notification-sec .main-sec a{color: #fff;}
    #results_mobile .ui-widget-content{position: absolute;
    /* top: 40px; */
    box-shadow: 0 0 5px 2px rgba(0, 0, 0, 0.05);
    border-radius: 5px;
    background: #fff;
    /* overflow: hidden; */
    padding: 16px;
    z-index: 99;
    left: 9px;}
    #results_mobile .ui-widget-content li{
            margin: 6px 0;
    display: inline-block;
    width: 100%;
    }
</style>
 <header>
    @if(isset($notification) && $notification != null)
    
        <div class="notification-sec" id="header_notificaation_sec" style="display: block;">
            <input type="hidden" id="notifivation_display" value="{{isset($notification->display) ? $notification->display : ''}}" name="">
            <div class="container">
                 <div class="main-sec">
                    <div class="content-sec" style="text-align: center;">
                        <a class="header-sec" @if(isset($notification->link) && $notification->link != null) href="{{ $notification->link }}" @endif>
                            <span>{{ $notification->content }}</span>
                        </a>
                    </div>
                    <div class="button-sec" style="text-align: end;">
                        <a onclick="closeNotification()">
                            <i class="fa fa-close" style="font-size: 22px;"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    
    @endif
        <div class="top-header">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="top-header-list">
                            <ul>
                                <!-- <li>Helpline: <a href="tel:+919726222208">+ 919726222208</a></li> -->
                                <li>Helpline: <a href="tel:+ {{$bs->country_code_number.''.$bs->whatsapp_number}}">+ {{$bs->country_code_number.''.$bs->whatsapp_number}}</a></li>
                                <span class="line-in-header">|</span>
                                <!-- <li><a target="_blank" href="https://api.whatsapp.com/send?phone=919726222208&text=Hi, Need more information, let's discuss. https://madhuvangold.in">Chat</a> -->
                                <li><a target="_blank" href="https://api.whatsapp.com/send?phone=+{{$bs->country_code_number.''.$bs->whatsapp_number}}&text=Hi, Need more information, let's discuss. {{url()->current()}}">Chat</a>

                                </li>
                                <span class="line-in-header">|</span>
                                <li><a href="{{route('home.contact_us')}}">Contact Us</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6 text-right">
                        <div class="top-header-list">
                            <ul>
                                @if(Auth::user() && Auth::user()->role == 'customer')
                                <form id="user-logout-form" action="{{ route('user.logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                <li class=""><a href="{{route('user.account.details')}}">My account</a></li> <span class="line-in-header">|</span>
                                <li class=""><a href="{{route('user.logout')}}" onclick="event.preventDefault(); document.getElementById('user-logout-form').submit();">Logout</a> <span class="line-in-header">|</span>
                                </li>
                                @else
                                <li><a data-toggle="modal" data-target="#login-popup">Sign In / Sign up</a></li> <span class="line-in-header">|</span>
                                @endif
                                <li class=""><a href="{{ route('front.wishlist.view') }}">Wishlist</a></li> 
                                @if(isset($bs->android_link) && $bs->android_link != null && $bs->android_link != '')
                                <span class="line-in-header">|</span>
                                <li>
                                    <a href="{{isset($bs->android_link) ? $bs->android_link : 'javascript:;'}}"
                                        target="_blank">Download App</a>
                                </li>
                                @endif
                                
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end -->




        <div class="middle-header">
            <div class="container">
                <div class="middle-header-main">
                    <div class="middle-header-left">
                        @if(isset($mr) && count($mr) > 0)

                     
                        @foreach($mr as $key => $mr_value)
                        @php
                        $purities = App\Models\MetalPurity::where('id',$mr_value->purity)->first();
                        @endphp
                        <div class="rate-box rate-box-gold">
                            <label xmlns="http://www.w3.org/1999/html" class="<?php echo (request()->is('/')) ? 'first-label' : ''; ?>">{{isset($purities->title) ? $purities->title : ''}} Rate</label>
                            <div>

                                <span class="product-price <?php echo (request()->is('/')) ? 'home' : ''; ?>">
                                    ₹ {{isset($mr_value->rate) ? number_format($mr_value->rate, 2, '.', ',') : ''}} 
                                    <small class="product-weight">
                                        (per 1gm)
                                    </small>
                                </span>
                                <label><a id="book_a_rate" onclick="book_a_gold_rate('{{$purities->title}}','{{isset($mr_value->rate) ? number_format($mr_value->rate, 2, '.', ',') : ''}}');">Book My {{isset($purities->title) ? $purities->title : ''}}</a></label>
                            </div>
                          
                        </div>
                        @endforeach
                        @endif
                        <div class="navigation-bar responsive-menu">
                            <nav class="navigation">
                                <div class="nav-header">
                                    <div class="nav-toggle"></div>
                                </div>
                                <!-- Main Menus Wrapper -->

                                <div class="nav-menus-wrapper d-none">
                                    <ul class="nav-menu">
                                        <li class="{{ (\Request::route()->getName() == 'home') ? 'active' : '' }}"><a href="{{route('home')}}">Home</a></li>
                                        <li class=""><a href="{{ route('front.wishlist.view') }}">My Wishlist</a></li>
                                        <li class=""><a href="{{route('front.cart.view')}}">My Cart</a></li>

                                         @php
                                            $selectedFamilies = App\Models\Category::withCount('products')->orderByDesc('products_count')->get();
                                        @endphp



                                           @if(isset($selectedFamilies) && count($selectedFamilies) > 0)
                                                @foreach($selectedFamilies as $pc_value)
                                                @php
                                                $product_details = App\Models\Family::whereRaw('FIND_IN_SET(?, category_id)', $pc_value->id)->orderBy('family', 'asc')->get();
                                                $product_check = $pc_value->products()->count();
                                                @endphp
                                                @if(isset($product_check) && $product_check > 0)
                                                <li><a class="submenu-text" href="">{{$pc_value->category}}</a><a class="submenu-icon" href="javascript:void(0)"></a>
                                                @if(isset($product_details) && count($product_details) > 0)

                                             
                                                    
                                                     <div class="megamenu-panel">
                                                        <div class="megamenu-lists">
                                                            <ul class="megamenu-list">
                                                                @foreach($product_details as $product_details_value)
                                                                    @php
                                                                        $product_count = App\Models\Product::where('p_category' , $pc_value->id)->where('p_family',$product_details_value->id)->count();
                                                                    @endphp
                                                                    @if(isset($product_count) && $product_count > 0)
                                                                        <li>
                                                                            <a href="{{route('front.cat.fam.products',['cat' => $pc_value->slug,'fam' => $product_details_value->slug])}}">{{$product_details_value->family}}</a>
                                                                        </li>
                                                                    @endif
                                                                @endforeach
                                                               
                                                            </ul>
                                                        </div>
                                                    </div>
                                                @endif
                                                </li>
                                                @endif
                                                @endforeach    
                                            @endif


                                        <li class=""><a href="{{route('front.catalogue')}}">Catalogues</a></li>
                                        <li class=""><a href="{{route('front.collection')}}">Collections</a></li>
                                        <li class=""><a href="{{route('front.about')}}">About</a></li>
                                        <li class=""><a href="{{route('front.faq')}}">FAQ's</a></li>
                                        <li class=""><a href="{{route('home.contact_us')}}">Contact Us</a></li>
                                        <li>
                                            <a class="submenu-text" href="javascript:void(0)">Terms</a>
                                            <a class="submenu-icon" href="javascript:void(0)"></a>
                                            <div class="megamenu-panel">
                                                <div class="megamenu-lists">
                                                    <ul class="megamenu-list">
                                                        <li class="menu-terms">
                                                            <a href="{{ route('front.privacy_policy') }}">Privacy Policy</a>
                                                            <a href="{{ route('front.refund_policy') }}">Refund Policy</a>
                                                            <a href="{{ route('front.shipping_policy') }}">Shipping Policy</a>
                                                            <a href="{{ route('front.disclaimer') }}">Disclaimer</a>
                                                            <a href="{{ route('front.terms_and_condition') }}">Terms And Condition</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </li>
                                        @if($bs->ios_link != '' || $bs->android_link != '')
                                        <li>
                                            <a class="submenu-text" href="javascript:void(0)">Download App</a>
                                            <a class="submenu-icon" href="javascript:void(0)"></a>
                                            <div class="megamenu-panel">
                                                <div class="megamenu-lists">
                                                    <ul class="megamenu-list">
                                                        <li class="menu-terms">     
                                                         @if($bs->android_link != '')                                                     
                                                            <a href="{{$bs->android_link}}"
                                                                target="_blank">Download Android App</a>
                                                        @endif
                                                        @if($bs->ios_link != '')
                                                            <a href="{{$bs->ios_link}}"
                                                                target="_blank">Download IOS App</a>
                                                        @endif
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </li>
                                        @endif
                                         @if(Auth::user() && Auth::user()->role == 'customer')
                                                <form id="user-logout-form1" action="{{ route('user.logout') }}" method="POST" style="display: none;">
                                                @csrf
                                                </form>
                                                <li><a href="{{route('user.account.details')}}">My account</a></li>
                                                <li onclick="event.preventDefault(); document.getElementById('user-logout-form1').submit();"><span>LOGOUT</span></li>
                                        @else
                                                <li class="mobile-view" onclick="closeMenu()"><span data-toggle="modal"
                                                data-target="#login-popup"><b>Sign In /
                                                    Sign up</b></span></li>
                                        @endif
                                    </ul>
                                    
                                </div>
                            </nav>
                        </div>


                    </div>
                    <!-- end -->
        
                    <div class="middle-header-center">
                        <div class="logo">
                            <h1>
                                <a href="{{route('home')}}">
                                    <img src="{{ asset('uploads/'.$bs->business_logo) }}" alt="{{$bs->business_name}}">
                                    <span class="color-gold"
                                        style="display:block;font-size:14px;position:absolute;text-indent: -9999px;">{{$bs->business_name}}</span>
                                </a>
                            </h1>
                        </div>
                    </div>
                    <!-- end -->
                    <div class="middle-header-right">
                        <div class="header-search desktop-header-search" style="position: relative;">
                             <form action="{{route('front.all.search_products')}}" method="post">
                                @csrf
                                <input type="text" placeholder="Search here" name="searchproduct" id="autocomplete"
                                    value="">
                                    <a href="javascript:;" id="desktop_search_cross" style="position: absolute;right: 55px;display: none;">
                                    <img src="{{asset('front/theme2/images/close-icon.svg')}}" class="img-fluid"></a>
                                <button type="submit"><img src="{{ asset('front/theme2/images/search-icon.svg') }}" alt="Search" height="23" width="23"></button>
                            </form>
                            <div id="results">

                            </div>
                        </div>
                        <div class="header-cart">
                            <a href="{{route('front.cart.view')}}">
                                <img src="{{ asset('front/theme2/images/cart-icon.svg') }}" alt="Cart" height="23" width="23">
                                @php
                                if(Auth::user() && Auth::user()->role == 'customer')
                                {
                                    $cart_count = App\Models\Cart::where('user_id',Auth::user()->id)->sum('qty');
                                }else{
                                    $cart = session()->get('cart',[]);
                                    $cart_count = array_sum(array_column($cart, 'qty'));

                                }
                                @endphp
                                <span class="cart-value " id="cart_count"> {{ isset($cart_count) ? $cart_count : 0 }} </span>
                            </a>
                        </div>
                    </div>
                    <!-- end -->
                </div>
            </div>
        </div>
        <!-- end -->


        <div class="bottom-header">
            <div class="header-search responsive-header-search" style="position: relative;">
                <form action="{{route('front.all.search_products')}}" method="post">
                    @csrf
                    <input type="text" placeholder="Search here" name="searchproduct" id="autocomplete_mobile" value="">
                    <a href="javascript:;" id="mobile_search_cross" style="position: absolute;right: 47px;display: none;margin-top: 3px;">
                                    <img src="{{asset('front/theme2/images/close-icon.svg')}}" class="img-fluid"></a>
                    <button type="submit"><img src="{{ asset('front/theme2/images/search-icon.svg') }}" alt="Search" height="23" width="23">
                    </button>
                </form>
                <div id="results_mobile" style="position: relative;">

                </div>
            </div>

            
            <div class="navigation-bar desktop-menu">
                <nav class="navigation">
                    <!-- Main Menus Wrapper -->
                    <div class="nav-menus-wrapper">
                        <ul class="nav-menu">
                            <li class="{{ (\Request::route()->getName() == 'home') ? 'active' : '' }}"><a href="{{route('home')}}">Home</a></li>
                            <li class="{{ (\Request::route()->getName() == 'front.all.products') ? 'active' : '' }} all_product_li">
                                <a href="{{route('front.all.products')}}">All Jewellery</a>

                                @php
                                
                                @endphp

                                <div class="megamenu-main">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="megamenutabbar">

                                                    <ul class="nav nav-tabs" id="megamenu-tab dynamic-header-list" role="tablist">
                                                        @php
                                                        $selectedFamilies = App\Models\Category::withCount('products')->orderByDesc('products_count')->get();

                                                        @endphp

                                                        @if(isset($selectedFamilies) && count($selectedFamilies) > 0)
                                                        @foreach($selectedFamilies as $key => $pc_value)
                                                        @php
                                                        $product_check = $pc_value->products()->count();
                                                  
                                                        @endphp
                                                       
                                                            @if($product_check > 0)
                                                          <input type="hidden" id="category_{{ $key }}" class="category_id_first" name="category_id_first" value="{{isset($pc_value->id) ? $pc_value->id : 1}}" name="">
                                                        
                                                            <li class="nav-item">
                                                                <a class="nav-link @if($key == 0) active @endif" data-id="{{$pc_value->id}}" id="0-tab" data-toggle="tab" role="tab" aria-controls="Pro0"
                                                                    aria-selected="true" onclick="product_details({{$pc_value->id}})">{{$pc_value->category}}</a>
                                                            </li>
                                                            @endif
                                                        @endforeach    
                                                        @endif
                                                         <!-- <li class="nav-item view-more-header">
                                                            <a class="nav-link" style="text-decoration: underline;">View More</a>
                                                        </li>
                                                        <li class="nav-item show-less d-none">
                                                            <a class="nav-link" style="text-decoration: underline;">Show Less</a>
                                                        </li> -->
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="tab-content" id="myTabContent">
                                                    <div class="tab-pane fade show active products_list" id="Pro0" role="tabpanel"
                                                        aria-labelledby="0-tab">
                                                      

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="{{ (\Request::route()->getName() == 'front.catalogue') ? 'active' : '' }}"><a href="{{route('front.catalogue')}}">Catalogues</a></li>
                            <li class="{{ (\Request::route()->getName() == 'front.collection') ? 'active' : '' }}"><a href="{{route('front.collection')}}">Collections</a></li>
                            <li class="{{ (\Request::route()->getName() == 'front.about') ? 'active' : '' }}"><a href="{{route('front.about')}}">About</a></li>
                        </ul>
                    </div>
                </nav>
            </div>
            <!-- end -->
        </div>
    </header>

