<nav class="pcoded-navbar">
        <div class="navbar-wrapper">
            <div class="navbar-brand header-logo">
                <a href="{{route('dashboard')}}" class="b-brand">
                    @if(isset($bs->business_logo) && $bs->business_logo != '')
                        <img src="{{ asset('uploads/images/'.$bs->business_logo) }}" alt="{{$bs->business_name}}">
                    @else
                        <img src="{{ asset('images/jewelxy-full-logo 1.svg') }}" class="img-fluid"> 
                    @endif
                </a>
                <!-- <a class="mobile-menu" id="mobile-collapse" href="javascript:"><span></span></a> -->
            </div>
            <div class="navbar-content scroll-div">
                <ul class="nav pcoded-inner-navbar" style="margin-bottom: 300px;">
                    <li data-username="dashboard Default Ecommerce CRM Analytics Crypto Project" class="nav-item {{ ((\Request::route()->getName() == 'dashboard')) ? 'active' : ''}}">
                        <a href="{{route('dashboard')}}" class="nav-link "><span class="pcoded-micon"><img src="{{ asset('images/Dashboard.svg') }}"></span><span class="pcoded-mtext">Dashboard</span></a>
                    </li>

                    <!-- Daily Updates Start -->
                    <li data-username="basic components Button Alert Badges breadcrumb Paggination progress Tooltip popovers Carousel Cards Collapse Tabs pills Modal Grid System Typography Extra Shadows Embeds" class="nav-item media-li pcoded-hasmenu {{ ((\Request::route()->getName() == 'metalrate.index') || (\Request::route()->getName() == 'daliystatus.index') || (\Request::route()->getName() == 'daliystatus.add') || (\Request::route()->getName() == 'daliystatus.edit') || (\Request::route()->getName() == 'notification.index')  || (\Request::route()->getName() == 'daily_update.index') || (\Request::route()->getName() == 'diamondrate.index'))   ? 'pcoded-trigger' : ''}}">
                        <a href="{{route('daily_update.index')}}" class="without-after"><span class="pcoded-micon"><img src="{{ asset('images/Daily Updates.svg') }}"></span><span class="pcoded-mtext">Daily Updates</span></a> <a href="javascript:;" class="nav-link"></a>
                    </li>
                        <ul class="pcoded-submenu media-ul" style="display:none;">
                            <li class=""><a href="{{route('metalrate.index')}}" style="{{ (\Request::route()->getName() == 'metalrate.index') ? 'color: var(--theme-orange-red) !important;' : '' }}" class="">Metal Rate</a></li>
                            <li class=""><a href="{{route('diamondrate.index')}}" style="{{ (\Request::route()->getName() == 'diamondrate.index') ? 'color: var(--theme-orange-red) !important;' : '' }}" class="">Diamond Rate</a></li>
                            <li class=""><a href="{{route('daliystatus.index')}}" style="{{ (\Request::route()->getName() == 'daliystatus.index') || (\Request::route()->getName() == 'daliystatus.add') || (\Request::route()->getName() == 'daliystatus.edit') ? 'color: var(--theme-orange-red) !important;' : '' }}" class="">Daily Status</a></li>
                            <li class=""><a href="{{route('notification.index')}}" style="{{ (\Request::route()->getName() == 'notification.index') ? 'color: var(--theme-orange-red) !important;' : '' }}" class="">Announcement</a></li>
                        </ul>

                        <!-- Daily updates end -->

                        <!-- Media Start -->
                       <li data-username="basic components Button Alert Badges breadcrumb Paggination progress Tooltip popovers Carousel Cards Collapse Tabs pills Modal Grid System Typography Extra Shadows Embeds" class="nav-item media-li pcoded-hasmenu {{ ((\Request::route()->getName() == 'logoslider.index') || (\Request::route()->getName() == 'pdflist.index') || (\Request::route()->getName() == 'adsposter.index') || (\Request::route()->getName() == 'pagebanner.index') || (\Request::route()->getName() == 'adsposter.add') || (\Request::route()->getName() == 'adsposter.edit') || (\Request::route()->getName() == 'logoslider.add') || (\Request::route()->getName() == 'logoslider.edit') || (\Request::route()->getName() == 'pagebanner.add') || (\Request::route()->getName() == 'pagebanner.edit') || (\Request::route()->getName() == 'media.section') || (\Request::route()->getName() == 'media.index') || (\Request::route()->getName() == 'sliderbanner.index') || (\Request::route()->getName() == 'sliderbanner.add') || (\Request::route()->getName() == 'sliderbanner.edit'))  ? 'pcoded-trigger' : ''}}">
                            <a href="{{route('media.index')}}" class="without-after"><span class="pcoded-micon"><img src="{{ asset('images/Media.svg') }}"></span><span class="pcoded-mtext">Media</a></span> <a href="javascript:;" class="nav-link "></a>
                            
                        </li>
                        <ul class="pcoded-submenu media-ul" style="display:none;">
                            <li class=""><a href="{{route('sliderbanner.index')}}" style="{{ (\Request::route()->getName() == 'sliderbanner.index') || (\Request::route()->getName() == 'sliderbanner.add') || (\Request::route()->getName() == 'sliderbanner.edit') ? 'color: var(--theme-orange-red) !important;' : '' }}" class="">Slider Banner</a></li>
                            <li class=""><a href="{{ route('media.section',['sec' => 'ads-poster']) }}" style="{{ (request()->is('admin/media-section/ads-poster') == 'true') ? 'color: var(--theme-orange-red) !important;' : '' }}" class="">Posters</a></li>
                            <li class=""><a href="{{ route('media.section',['sec' => 'logo-slider']) }}" style="{{ (request()->is('admin/media-section/logo-slider') == 'true') ? 'color: var(--theme-orange-red) !important;' : '' }}" class="">Logo Slider
                            </a></li>
                            <li class=""><a href="{{ route('media.section',['sec' => 'pdf-list']) }}" style="{{ (request()->is('admin/media-section/pdf-list') == 'true') ? 'color: var(--theme-orange-red) !important;' : '' }}" class="">PDF</a></li>
                            <li class=""><a href="{{ route('pagebanner.index') }}" style="{{ (\Request::route()->getName() == 'pagebanner.index') ? 'color: var(--theme-orange-red) !important;' : '' }}" class="">Page Banner</a></li>
                        </ul>
                        <!-- Media End -->

                        <!-- Inventory start -->

                        <li data-username="basic components Button Alert Badges breadcrumb Paggination progress Tooltip popovers Carousel Cards Collapse Tabs pills Modal Grid System Typography Extra Shadows Embeds" class="nav-item media-li pcoded-hasmenu {{ ((\Request::route()->getName() == 'product.index') || (\Request::route()->getName() == 'product.add') || (\Request::route()->getName() == 'product.edit') || (\Request::route()->getName() == 'catalogue.index') || (\Request::route()->getName() == 'catalogue.add') || (\Request::route()->getName() == 'catalogue.different.view') || (\Request::route()->getName() == 'catalogue.edit') || (\Request::route()->getName() == 'collection.index') || (\Request::route()->getName() == 'collection.add') || (\Request::route()->getName() == 'collection.different.view') || (\Request::route()->getName() == 'collection.edit') || (\Request::route()->getName() == 'product_all.index') || (\Request::route()->getName() == 'quickadd-product') || (\Request::route()->getName() == 'product.quickadd') || (\Request::route()->getName() == 'variant.index') ) ? 'pcoded-trigger' : ''}}">
                            <a href="{{route('product_all.index')}}" class="without-after" ><span class="pcoded-micon"><img src="{{ asset('images/Products.svg') }}"></span><span class="pcoded-mtext">Inventory</a></span> <a href="javascript:;" class="nav-link "></a>
                        </li>
                        <ul class="pcoded-submenu media-ul" style="display:none;">
                            <li class=""><a href="{{route('product.index')}}" class="" style="{{ (\Request::route()->getName() == 'product.index') || (\Request::route()->getName() == 'product.add') || (\Request::route()->getName() == 'product.edit') || (\Request::route()->getName() == 'quickadd-product') ? 'color: var(--theme-orange-red) !important;' : '' }}">Product</a></li>
                            <li class=""><a href="{{route('variant.index')}}" class="" style="{{ (\Request::route()->getName() == 'variant.index')  ? 'color: var(--theme-orange-red) !important;' : '' }}">Variants</a></li>
                            <li class=""><a href="{{route('catalogue.index')}}" class=""  style="{{ (\Request::route()->getName() == 'catalogue.index' || \Request::route()->getName() == 'catalogue.add' || \Request::route()->getName() == 'catalogue.different.view' || \Request::route()->getName() == 'catalogue.edit') ? 'color: var(--theme-orange-red) !important;' : '' }}">Catalogue</a></li>
                            <li class=""><a href="{{route('collection.index')}}" class="" style="{{ (\Request::route()->getName() == 'collection.index') || (\Request::route()->getName() == 'collection.add') || (\Request::route()->getName() == 'collection.different.view') || (\Request::route()->getName() == 'collection.edit') ? 'color: var(--theme-orange-red) !important;' : '' }}">Collection</a></li>
                        </ul>
                    <!-- Inventory End -->
                    <!-- Bullk upload start -->
                    <li data-username="basic components Button Alert Badges breadcrumb Paggination progress Tooltip popovers Carousel Cards Collapse Tabs pills Modal Grid System Typography Extra Shadows Embeds" class="nav-item media-li pcoded-hasmenu {{ ((\Request::route()->getName() == 'bulk.product.upload') || (\Request::route()->getName() == 'bulk.upload.dashboard') || (\Request::route()->getName() == 'bulk.product.image.upload') || (\Request::route()->getName() == 'bulk.variant.upload') || (\Request::route()->getName() == 'bulk.video.upload') || (\Request::route()->getName() == 'bulk.certificate.upload')) ? 'pcoded-trigger' : ''}}">
                        <a href="{{route('bulk.upload.dashboard')}}" class="without-after" ><span class="pcoded-micon"><img src="{{ asset('images/Bulk upload.svg') }}"></span><span class="pcoded-mtext">Bulk Upload</a></span> <a href="javascript:;" class="nav-link "></a>
                    </li>
                    <ul class="pcoded-submenu media-ul" style="display:none;">
                        <li class=""><a href="{{route('bulk.product.upload')}}" class="" style="{{ (\Request::route()->getName() == 'bulk.product.upload') ? 'color: var(--theme-orange-red) !important;' : '' }}">Product Upload</a></li>
                        <li class=""><a href="{{route('bulk.variant.upload')}}" class="" style="{{ (\Request::route()->getName() == 'bulk.variant.upload') ? 'color: var(--theme-orange-red) !important;' : '' }}">Variant Upload</a></li>
                        <li class=""><a href="{{route('bulk.product.image.upload')}}" class="" style="{{ (\Request::route()->getName() == 'bulk.product.image.upload') ? 'color: var(--theme-orange-red) !important;' : '' }}">Product Image Upload</a></li>
                        <li class=""><a href="{{route('bulk.video.upload')}}" class="" style="{{ (\Request::route()->getName() == 'bulk.video.upload') ? 'color: var(--theme-orange-red) !important;' : '' }}">Product Video Upload</a></li>
                        <li class=""><a href="{{route('bulk.certificate.upload')}}" class="" style="{{ (\Request::route()->getName() == 'bulk.certificate.upload') ? 'color: var(--theme-orange-red) !important;' : '' }}">Product Certificate Upload</a></li>
                    </ul>
                    <!-- Bullk upload End -->
                    <!-- Promotion start -->
                    <li data-username="basic components Button Alert Badges breadcrumb Paggination progress Tooltip popovers Carousel Cards Collapse Tabs pills Modal Grid System Typography Extra Shadows Embeds" class="nav-item media-li pcoded-hasmenu {{ ((\Request::route()->getName() == 'promo_code.index') || (\Request::route()->getName() == 'promo_code.add') || (\Request::route()->getName() == 'promo_code.edit') || (\Request::route()->getName() == 'promo_code.dashboard') || (\Request::route()->getName() == 'promo_code.used')) ? 'pcoded-trigger' : ''}}">
                        <a href="{{route('promo_code.dashboard')}}" class="without-after" ><span class="pcoded-micon"><img src="{{ asset('images/promotion.svg') }}"></span><span class="pcoded-mtext">Promotion</a></span> <a href="javascript:;" class="nav-link "></a>
                    </li>
                    <ul class="pcoded-submenu media-ul" style="display:none;">
                        <li class=""><a href="{{route('promo_code.index')}}" class="" style="{{ (\Request::route()->getName() == 'promo_code.index')  || (\Request::route()->getName() == 'promo_code.add') || (\Request::route()->getName() == 'promo_code.edit') || (\Request::route()->getName() == 'promo_code.used') ? 'color: var(--theme-orange-red) !important;' : '' }}">Promocode</a></li>
                    </ul>
                    <!-- Promotion End -->
                    <!-- Orders start -->
                        <li data-username="basic components Button Alert Badges breadcrumb Paggination progress Tooltip popovers Carousel Cards Collapse Tabs pills Modal Grid System Typography Extra Shadows Embeds" class="nav-item media-li pcoded-hasmenu {{ ((\Request::route()->getName() == 'customers.index') || (\Request::route()->getName() == 'customers.edit') || (\Request::route()->getName() == 'customers.product_list') || (\Request::route()->getName() == 'orders.index') || (\Request::route()->getName() == 'orders.dash_index') || (\Request::route()->getName() == 'orders.details') || (\Request::route()->getName() == 'customers.view') || (\Request::route()->getName() == 'customers.add') )  ? 'pcoded-trigger' : ''}}">
                            <a href="{{route('orders.dash_index')}}" class="without-after"><span class="pcoded-micon"><img src="{{ asset('images/ordear-01.svg') }}"></span><span class="pcoded-mtext">Orders</a></span> <a href="javascript:;" class="nav-link "></a>  
                        </li>
                        <ul class="pcoded-submenu media-ul" style="display:none;">
                            <li class=""><a href="{{route('customers.index')}}" style="{{ (\Request::route()->getName() == 'customers.index') || (\Request::route()->getName() == 'customers.edit') || (\Request::route()->getName() == 'customers.product_list') || (\Request::route()->getName() == 'customers.view') || (\Request::route()->getName() == 'customers.add') ? 'color: var(--theme-orange-red) !important;' : '' }}" class="">Customers</a></li>
                            <li class=""><a href="{{route('orders.index')}}" style="{{ (\Request::route()->getName() == 'orders.index') || (\Request::route()->getName() == 'orders.details') ? 'color: var(--theme-orange-red) !important;' : '' }}" class="">Orders</a></li>
                        </ul>
                        <!-- Orders End -->
                        <!-- Access Control start -->
                        <li data-username="basic components Button Alert Badges breadcrumb Paggination progress Tooltip popovers Carousel Cards Collapse Tabs pills Modal Grid System Typography Extra Shadows Embeds" class="nav-item media-li pcoded-hasmenu {{ ((\Request::route()->getName() == 'accesscontrole.index') || (\Request::route()->getName() == 'registration.setting.index') || (\Request::route()->getName() == 'accesscontrole.dash_index') )  ? 'pcoded-trigger' : ''}}">
                            <a href="{{route('accesscontrole.dash_index')}}" class="without-after"><span class="pcoded-micon"><img src="{{ asset('images/Acess Control.svg') }}"></span><span class="pcoded-mtext">Access Control</a></span> <a href="javascript:;" class="nav-link "></a>  
                        </li>
                        <ul class="pcoded-submenu media-ul" style="display:none;">
                            <li class=""><a href="{{route('accesscontrole.index')}}" style="{{ (\Request::route()->getName() == 'accesscontrole.index')  ? 'color: var(--theme-orange-red) !important;' : '' }}" class="">Access Control</a></li>
                            <li class=""><a href="{{route('registration.setting.index')}}" style="{{ (\Request::route()->getName() == 'registration.setting.index') ? 'color: var(--theme-orange-red) !important;' : '' }}" class="">Registration Form</a></li>
                        </ul>
                        <!-- Access Control End -->
                        <!-- Setting Start -->
                       <li data-username="basic components Button Alert Badges breadcrumb Paggination progress Tooltip popovers Carousel Cards Collapse Tabs pills Modal Grid System Typography Extra Shadows Embeds" class="nav-item media-li pcoded-hasmenu {{ ((\Request::route()->getName() == 'setting.homepage.index') || (\Request::route()->getName() == 'delivery_zip.index') || (\Request::route()->getName() == 'delivery_zip.add') || (\Request::route()->getName() == 'delivery_zip.edit') || (\Request::route()->getName() == 'delivery_zip.state') || (\Request::route()->getName() == 'testimonials.index') || (\Request::route()->getName() == 'testimonials.edit') ||  (\Request::route()->getName() == 'testimonials.add') || (\Request::route()->getName() == 'setting_all.index') || (\Request::route()->getName() == 'delivery_option.index') || (\Request::route()->getName() == 'setting.taxes') || (\Request::route()->getName() == 'settings.buy-with-confidence') || (\Request::route()->getName() == 'settings.payment-option') || (\Request::route()->getName() == 'pagesetting.about_index') || (\Request::route()->getName() == 'business.setting.index') || (\Request::route()->getName() == 'pagesetting.contact_index')|| (\Request::route()->getName() == 'global_settings.index') || (\Request::route()->getName() == 'pagesetting.index')) ? 'pcoded-trigger' : ''}}">
                            <a href="{{route('setting_all.index')}}" class="without-after"><span class="pcoded-micon"><img src="{{ asset('images/Settings.svg') }}"></span><span class="pcoded-mtext">Settings</a></span><a href="javascript:;" class="nav-link "></a></li>

                            <ul class="pcoded-submenu media-ul" style="display:none;">
                                <li class=""><a href="{{route('business.setting.index')}}" class="" style="{{ (\Request::route()->getName() == 'business.setting.index')  ? 'color: var(--theme-orange-red) !important;' : '' }}">Business Settings</a></li>
                                <li class="inner-menu {{ ((\Request::route()->getName() == 'setting.homepage.index') || (\Request::route()->getName() == 'delivery_zip.index') || (\Request::route()->getName() == 'delivery_zip.add') || (\Request::route()->getName() == 'delivery_zip.edit') || (\Request::route()->getName() == 'delivery_zip.state') || (\Request::route()->getName() == 'testimonials.index') || (\Request::route()->getName() == 'testimonials.edit') ||  (\Request::route()->getName() == 'testimonials.add') ||  (\Request::route()->getName() == 'delivery_option.index') || (\Request::route()->getName() == 'setting.taxes') || (\Request::route()->getName() == 'settings.buy-with-confidence') || (\Request::route()->getName() == 'settings.payment-option') || (\Request::route()->getName() == 'global_settings.index')) ? 'pcoded-trigger' : ''}}"><a href="{{route('global_settings.index')}}" class="">Global Settings</a></li>
                                <ul class="next-inner-menu" style="display:none;">
                                   <li class=""><a href="{{route('setting.homepage.index')}}" style="{{ (\Request::route()->getName() == 'setting.homepage.index')  ? 'color: var(--theme-orange-red) !important;' : '' }}" class="">Homepage</a></li>
                                    <li class=""><a href="{{route('testimonials.index')}}" style="{{ (\Request::route()->getName() == 'testimonials.index') || (\Request::route()->getName() == 'testimonials.add') || (\Request::route()->getName() == 'testimonials.edit') ? 'color: var(--theme-orange-red) !important;' : '' }}" class="">Testimonials</a></li>
                                    <li class=""><a href="{{route('delivery_option.index')}}" style="{{ (\Request::route()->getName() == 'delivery_option.index')  ? 'color: var(--theme-orange-red) !important;' : '' }}" class="">Shipping</a></li>
                                    <li class=""><a href="{{route('delivery_zip.index')}}" style="{{ (\Request::route()->getName() == 'delivery_zip.index') || (\Request::route()->getName() == 'delivery_zip.add') || (\Request::route()->getName() == 'delivery_zip.edit') || (\Request::route()->getName() == 'delivery_zip.state')  ? 'color: var(--theme-orange-red) !important;' : '' }}" class="">Delivery Zipcodes</a></li>

                                    
                                    <li class=""><a href="{{route('setting.taxes')}}" style="{{ (\Request::route()->getName() == 'setting.taxes') ? 'color: var(--theme-orange-red) !important;' : '' }}" class="">Taxation</a></li>
                                    <li class=""><a href="{{route('settings.buy-with-confidence')}}" style="{{ (\Request::route()->getName() == 'settings.buy-with-confidence') ? 'color: var(--theme-orange-red) !important;' : '' }}" class="">Buy With Confidence</a></li>
                                    
                                    <li class=""><a href="{{route('settings.payment-option')}}" style="{{ (\Request::route()->getName() == 'settings.payment-option') ? 'color: var(--theme-orange-red) !important;' : '' }}" class="">Payment Option</a></li>
                                </ul>
                                <li class="inner-menu {{ ((\Request::route()->getName() == 'pagesetting.about_index') || (\Request::route()->getName() == 'pagesetting.contact_index') || (\Request::route()->getName() == 'pagesetting.index')) ? 'pcoded-trigger' : ''}}"><a href="{{route('pagesetting.index')}}" class="">Page Settings</a></li>
                                <ul class="next-inner-menu" style="display:none;">
                                   <li class=""><a href="{{route('pagesetting.about_index')}}" style="{{ (\Request::route()->getName() == 'pagesetting.about_index')  ? 'color: var(--theme-orange-red) !important;' : '' }}" class="">About Us</a></li>
                                 <li class=""><a href="{{route('pagesetting.contact_index')}}" style="{{ (\Request::route()->getName() == 'pagesetting.contact_index')  ? 'color: var(--theme-orange-red) !important;' : '' }}" class="">Contact Us</a></li>
                                </ul>
                                {{-- <li class=""><a href="{{route('registration.setting.index')}}" class="" style="{{ (\Request::route()->getName() == 'registration.setting.index')  ? 'color: var(--theme-orange-red) !important;' : '' }}">Registration Settings</a></li> --}}
                            </ul>
                </ul>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>
    </nav>
        
