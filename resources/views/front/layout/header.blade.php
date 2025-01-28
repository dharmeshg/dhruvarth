@php
    if(Auth::user() && Auth::user()->role == 'customer')
    {
        $cart_count = App\Models\Cart::where('user_id',Auth::user()->id)->sum('qty');
        $wishlist_count = App\Models\WishList::where('user_id',Auth::user()->id)->get()->count();
    }else{
        $cart = session()->get('cart',[]);
        $cart_count = array_sum(array_column($cart, 'qty'));
        $wishlst = session()->get('wishlist',[]);
        $wishlist_count = count($wishlst);
    }
   
    $notification = App\Models\Notification::where('status',1)->first();

@endphp

<section class="main-header-sec" id="myHeader">
            <!-- Welcome Top Header  -->
    @if(isset($notification) && $notification != null)
        @if($display_pg == 1)
            <div class="header-top-section d-none">
                <div class="container-md">
                    <div class="row">
                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 content-col">
                            <p>
                                <a class="header-sec" @if(isset($notification->link) && $notification->link != null) href="{{ $notification->link }}" @endif>{{ $notification->content }}</a>
                            </p>

                            <a href="javascript:void(0);" aria-label="Welcome Text" class="close-welcome-text">
                                <img src="{{asset('front/src/images/close-welcome-icon.svg') }}" alt="Search" height="18" width="18" class="img-fluid">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endif

            <!-- Header Section  -->

            <header>
                <div class="first-header-part">
                    <div class="container-md">
                        <div class="row align-items-center">
                            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 left-side">
                                <article>

                                    @if(isset($mr) && count($mr) > 0)
                                        @foreach($mr as $key => $mr_value)
                                            @php
                                                $purities = App\Models\MetalPurity::where('id',$mr_value->purity)->first();
                                            @endphp
                                            <div class="header-two-block @if($key == 1) second-block @endif">
                                                <div>
                                                    <p>{{isset($purities->title) ? $purities->title : ''}} Rate</p>
                                                    <p class="price-text"><span class="number-text">₹ {{isset($mr_value->rate) ? number_format($mr_value->rate, 2, '.', ',') : ''}}</span>(per 1gm)</p>
                                                </div>
                                                <div>
                                                    <a id="book_a_rate" onclick="book_a_gold_rate('{{isset($purities->title) ? $purities->title : ''}}','{{isset($mr_value->rate) ? number_format($mr_value->rate, 2, '.', ',') : ''}}');" aria-level="header Book Rate">
                                                        <img src="{{asset('front/src/images/header-wahtsapp-icon.svg') }}" alt="Search" height="20"
                                                            width="20" class="img-fluid" >
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </article>
                            </div>
                            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 center-logo">
                                <button class="navbar-toggler" type="button"> 
                                    <img src="{{asset('front/src/images/header-toggle-menu.svg') }}" width="30" height="30" style="display: inline;" class="img-fluid open-icon" > 
                                    <img src="{{asset('front/src/images/header-close.svg') }}" style="display: none;" class="img-fluid close-icon"> 
                                </button>

                                <a href="{{ route('home') }}" aria-level="Jewel Jagat Logo">
                                    <img src="{{ asset('uploads/images/'.$bs->business_logo) }}" class="header-logo img-fluid" width="198"
                                        height="42" alt="{{$bs->business_name}}">
                                </a>

                                <ul class="mobile-header-right-menu">

                                    <li class="dropdown">
                                        <a class="dropdown-user" data-bs-toggle="dropdown" aria-label="Header User">
                                            <img src="{{asset('front/src/images/header-user.svg') }}" class="header-user img-fluid" width="19"
                                                height="21" alt="User"></a>
                                            <ul class="dropdown-menu" id="user_dropdown_menu">

                                                @if(Auth::user() && Auth::user()->role == 'customer')
                                                    <form id="user-logout-form" action="{{ route('user.logout') }}" method="POST" style="display: none;">
                                                            @csrf
                                                    </form>
                                                    <li class=""><a href="{{route('user.account.details')}}">My account</a></li>
                                                    <li class=""><a href="{{route('user.logout')}}" class="header_logout_access" onclick="event.preventDefault(); document.getElementById('user-logout-form').submit();">Logout</a>
                                                    </li>
                                                @else
                                                    <li><a data-bs-toggle="modal" data-bs-target="#login-popup">Sign In / Sign up</a></li>
                                                @endif
                                            </ul>
                                    </li>
                                    @if(isset($public_promocodes) && count($public_promocodes) > 0)
                                    <li class="header-whishlist">
                                        <a data-bs-toggle="modal" data-bs-target="#all-promocodes-popup" class="whishlist" aria-label="Header whishlist">
                                            <img src="{{asset('front/src/images/promo-code.svg') }}" class="header-user img-fluid"
                                                width="25" height="21" alt="Whishlist">
                                        </a>
                                    </li>
                                    @endif
                                    <li class="header-whishlist">
                                        <a href="{{ route('front.wishlist.view') }}" class="whishlist" aria-label="Header whishlist">
                                            <img src="{{asset('front/src/images/header-whishlist.svg') }}" class="header-user img-fluid"
                                                width="25" height="21" alt="Whishlist">
                                            <span class="whishlist-value number-text" id="whishlist_count_mob">({{$wishlist_count}})</span>
                                        </a>
                                    </li>

                                    <li class="header-cart">
                                        <a href="{{route('front.cart.view')}}" class="cart" aria-label="Header cart">
                                            <img src="{{asset('front/src/images/header-cart.svg') }}" class="header-user img-fluid" width="22"
                                                height="22" alt="Cart">
                                            <span class="cart-value number-text" id="cart_count_mob">({{$cart_count}})</span>
                                        </a>
                                    </li>
                                </ul>

                            </div>
                            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 right-side">
                                <article class="desktop-right-section">
                                    <ul>
                                        <li>
                                            <div class="header-search desktop-header-search">
                                                <form action="{{route('front.all.search_products')}}" method="post">
                                                    @csrf
                                                    <input type="text" placeholder="Search here" name="searchproduct"
                                                        id="autocomplete" value="">
                                                        <a href="javascript:;" id="desktop_search_cross" style="position: absolute;right: 60px;top: 14px;display:none;">
                                    <img src="{{asset('front/src/images/close-icon.svg') }}" class="img-fluid"></a>
                                                    <button type="submit"><img src="{{asset('front/src/images/mobile-header-search.svg') }}"
                                                            alt="Search" height="22" width="22" class="img-fluid"></button>
                                                </form>
                                                <div id="results" style="position: relative;">

                                                </div>
                                            </div>
                                        </li>

                                        <li class="dropdown">
                                            <a class="dropdown-user" data-bs-toggle="dropdown" aria-label="Header User">
                                                <img src="{{asset('front/src/images/header-user.svg') }}" class="header-user img-fluid" width="19"
                                                    height="21" alt="User"></a>
                                            <ul class="dropdown-menu" id="user_dropdown_menu">
                                                @if(Auth::user() && Auth::user()->role == 'customer')
                                                    <form id="user-logout-form" action="{{ route('user.logout') }}" method="POST" style="display: none;">
                                                            @csrf
                                                    </form>
                                                    <li class=""><a href="{{route('user.account.details')}}">My account</a></li>
                                                    <li class=""><a href="{{route('user.logout')}}" onclick="event.preventDefault(); document.getElementById('user-logout-form').submit();">Logout</a>
                                                    </li>
                                                @else
                                                    <li><a data-bs-toggle="modal" data-bs-target="#login-popup">Sign In / Sign up</a></li>
                                                @endif
                                            </ul>
                                        </li>
                                        @if(isset($public_promocodes) && count($public_promocodes) > 0)
                                        <li class="header-whishlist promocode">
                                            <a data-bs-toggle="modal" data-bs-target="#all-promocodes-popup" id="header-promocodes-btn" class="whishlist" aria-label="Header whishlist">
                                                <img src="{{asset('front/src/images/promo-code.svg') }}" class="header-user img-fluid"
                                                    width="25" height="21" alt="Whishlist">
                                            </a>
                                        </li>
                                        @endif
                                        <li class="header-whishlist">
                                            <a href="{{ route('front.wishlist.view') }}" class="whishlist" aria-label="Header whishlist">
                                                <img src="{{asset('front/src/images/header-whishlist.svg') }}" class="header-user img-fluid"
                                                    width="25" height="21" alt="Whishlist">
                                                <span class="whishlist-value number-text" id="whishlist_count">({{$wishlist_count}})</span>
                                            </a>
                                        </li>

                                        <li class="header-cart">
                                            <a href="{{route('front.cart.view')}}" class="cart" aria-label="Header cart">
                                                <img src="{{asset('front/src/images/header-cart.svg') }}" class="header-user img-fluid" width="22"
                                                    height="22" alt="Cart" >
                                                <span class="cart-value number-text" id="cart_count">({{$cart_count}})</span>
                                            </a>
                                        </li>
                                    </ul>
                                </article>

                                <article class="mobile-right-section">
                                    <div class="header-search mobile-header-search">
                                        <form action="{{route('front.all.search_products')}}" method="post">
                                            @csrf
                                            <input type="text" placeholder="Search here" name="searchproduct"
                                                id="autocomplete_mobile" value="">
                                            <button type="submit"><img src="{{asset('front/src/images/mobile-header-search.svg') }}"
                                                    alt="Search" height="22" width="22" class="img-fluid"></button>
                                        </form>
                                        <div id="results_mobile" style="position: relative;">

                                        </div>
                                    </div>
                                </article>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="header-menu-part">
                    <div class="container-md">
                        <div class="row">
                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <nav class="mobile-header-menu">
                                    <ul>
                                        <li><a href="{{route('home')}}">Home</a></li>
                                        <li class="all-jewellery-tab desktop-menu"><a href="{{route('front.all.products')}}">All Jewellery</a>
                                            <div class="row desktop-all-product-sec">
                                                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12 left-side">
                                                    <ul class="nav-tabs" id="specialize-tab" role="tablist">
                                                        @php
                                                            $selectedFamilies = App\Models\Category::withCount('products')->orderByDesc('products_count')->get();
                                                        @endphp

                                                        @if(isset($selectedFamilies) && count($selectedFamilies) > 0)
                                                        @php
                                                            $all_cat_counts = 0;
                                                        @endphp
                                                        @foreach($selectedFamilies as $key => $pc_value)
                                                            @php
                                                                $product_check = $pc_value->products()->count();
                                                            @endphp
                                                            
                                                            @if($product_check > 0)
                                                            @php $all_cat_counts++ @endphp
                                                                <input type="hidden" id="category_{{ $key }}" class="category_id_first" name="category_id_first" value="{{isset($pc_value->id) ? $pc_value->id : 1}}" name="">
                                                                <li class="nav-item each-specialize @if($key >= 5) d-none extra-item @endif @if($key==0) active_li @endif" role="presentation">
                                                                    <a class="nav-link @if($key==0) active @endif" id="goldjewelry-tab" data-bs-toggle="tab" data-bs-target="#goldjewelry" role="tab" aria-controls="goldjewelry" aria-selected="false" tabindex="-1" onclick="product_details({{$pc_value->id}})">
                                                                        <h4>{{$pc_value->category}}</h4>
                                                                    </a>
                                                                </li>
                                                            @endif
                                                        @endforeach
                                                        @if(isset($all_cat_counts) && $all_cat_counts > 5)
                                                        <li class="nav-item view-more-header">
                                                            <a class="nav-link" style="text-decoration: underline;"><h4>View More</h4></a>
                                                        </li>
                                                        @endif
                                                        @endif
                                                    </ul>
                                                </div>
                                                <div class="col-xxl-7 col-xl-7 col-lg-7 col-md-7 col-sm-12 col-12 right-side">
                                                    <div class="tab-content specialize-issues-details">
                                                        <div class="tab-pane show active" id="goldjewelry" role="tabpanel" aria-labelledby="goldjewelry-tab">
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </li>

                                        <li class="mobile-menu all_jewel_menu"><a href="{{route('front.all.products')}}">All Jewellery</a></li>
                                         @if(isset($selectedFamilies) && count($selectedFamilies) > 0)

                                            @foreach($selectedFamilies as $key => $pc_value)
                                                @php
                                                    $product_check = $pc_value->products()->count();
                                                    $product_idss = $pc_value->id;
                                                    $product_details = App\Models\Family::whereRaw('FIND_IN_SET(?, category_id)', $pc_value->id)
                                                        ->withCount('products')
                                                        ->orderByDesc('products_count')
                                                        ->whereHas('products', function ($query) use ($product_idss) {
                                                            $query->where('visiblity', 1)
                                                                ->where(function ($query) use ($product_idss) {
                                                                    $query->where('p_category', $product_idss)
                                                                        ->orWhereRaw('FIND_IN_SET(?, p_sec_category)', [$product_idss]);
                                                                });
                                                        })
                                                        ->get();
                                                    $product_details_array = $product_details->toArray();
                                                    $category_mob = App\Models\Category::where('id', $pc_value->id)->first();
                                               
                                                @endphp
                                                      
                                                @if($product_check > 0)
                                                    <li class="mobile-menu">
                                                        <a class="" type="button" id="droup{{$pc_value->id}}" data-bs-toggle="dropdown" aria-expanded="false">{{$pc_value->category}}</a>
                                                        <ul class="dropdown-menu" aria-labelledby="droup{{$pc_value->id}}">
                                                            @foreach($product_details_array as $index => $product_details_val)
                                                            @php
                                                                $product_count = $product_details_val['products_count'];
                                                                $check_count = App\Models\Product::where('p_category',$product_idss)->where('p_family',$product_details_val['id'])->where('visiblity',1)->count();
                                                            @endphp
                                                            @if(isset($product_count) && $product_count > 0)
                                                                <li>
                                                                    <a href="{{route('front.cat.fam.products',['cat' => $category_mob->slug,'fam' => $product_details_val['slug']])}}" class="dropdown-item">{{$product_details_val['family']}}<small class="menu-p-count">@if(isset($check_count) && $check_count > 0) ({{$check_count}}) @else (0) @endif</small></a>
                                                                </li>
                                                            @endif
                                                            @endforeach
                                                        </ul>
                                                    </li>
                                                @endif
                                            @endforeach
                                        @endif
                                        
                                        <li><a href="{{route('front.catalogue')}}">Catalogues</a></li>
                                        <li><a href="{{route('front.collection')}}">Collections</a></li>
                                        <li><a href="{{route('front.about')}}">About</a></li>
                                        <li class="mobile-menu all_jewel_menu"><a href="{{route('front.faq')}}">FAQ's</a></li>
                                        <li class="mobile-menu all_jewel_menu"><a href="{{route('home.contact_us')}}">Contact Us</a></li>
                                        <li class="mobile-menu"><a type="button" id="droup_term" data-bs-toggle="dropdown" aria-expanded="false">Terms</a>
                                            <ul class="dropdown-menu" aria-labelledby="droup_term">
                                                <li>
                                                    <a href="{{ route('front.privacy_policy') }}">Privacy Policy</a>
                                                    <a href="{{ route('front.refund_policy') }}">Refund Policy</a>
                                                    <a href="{{ route('front.shipping_policy') }}">Shipping Policy</a>
                                                    <a href="{{ route('front.disclaimer') }}">Disclaimer</a>
                                                    <a href="{{ route('front.terms_and_condition') }}">Terms And Condition</a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="mobile-menu all_jewel_menu close-icon-btn" data-bs-toggle="modal"
                                                data-bs-target="#login-popup"><a>Sign In/Sign Up</a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
        </section>