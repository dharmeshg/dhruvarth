@extends('layouts.backend.index')
@section('main_content')
    <div class="pcoded-wrapper">
        <div class="pcoded-wrapper">
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <!-- [ breadcrumb ] start -->
                    <div class="custom_breadcum">
                        <ul>
                            <li class="breadcum-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                           
                            <li class="breadcum-item active"><a href="javascript:;"> Settings </a></li>
                        </ul>
                    </div>

                    <!-- [ breadcrumb ] end -->
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page_header mb-3">
                                <h5>Settings</h5>
                            </div>
                            <!-- [ Main Content ] start -->
                            <div class="row">

                                <!--[ Recent Users ] start-->
                              <!--   <div class="col-md-12 col-xl-3 dashboard_new_upper">
                                    <a href="{{route('setting.homepage.index')}}">
                                        <div class="card card-social first_box">
                                            <div class="card-block">
                                                <div class="row">
                                                    <div class="col text-center mb-3">
                                                        <img src="{{ asset('assets/images/homepage.png') }}">
                                                    </div>
                                                    <h5 class="mb-3 dashboard_heading text-center"><span class="heading_class">Homepage Sections</span></h5>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-12 col-xl-3 dashboard_new_upper">
                                    <a href="{{route('delivery_zip.index')}}">
                                        <div class="card card-social second_box">
                                            <div class="card-block">
                                                <div class="row">
                                                    <div class="col text-center mb-3">
                                                        <img src="{{ asset('assets/images/zip-code.png') }}">
                                                    </div>
                                                    <h5 class="mb-3 dashboard_heading text-center"><span class="heading_class">Delivery Zip Code</span></h5>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-12 col-xl-3 dashboard_new_upper">
                                    <a href="{{route('testimonials.index')}}">
                                        <div class="card card-social third_box">
                                            <div class="card-block">
                                                <div class="row">
                                                    <div class="col text-center mb-3">
                                                        <img src="{{ asset('assets/images/testimonial.png') }}">
                                                    </div>
                                                    <h5 class="mb-3 dashboard_heading text-center"><span class="heading_class">Testimonial</span></h5>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div> -->
                          <!--       <div class="col-md-12 col-xl-3 dashboard_new_upper">
                                    <a href="{{route('delivery_option.index')}}">
                                        <div class="card card-social fourth_box">
                                            <div class="card-block">
                                                <div class="row">
                                                    <div class="col text-center mb-3">
                                                        <img src="{{ asset('assets/images/Delivery Option.png') }}">
                                                    </div>
                                                    <h5 class="mb-3 dashboard_heading text-center"><span class="heading_class">Delivery Option</span></h5>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                 <div class="col-md-12 col-xl-3 dashboard_new_upper">
                                    <a href="{{route('settings.buy-with-confidence')}}">
                                        <div class="card card-social fourth_box">
                                            <div class="card-block">
                                                <div class="row">
                                                    <div class="col text-center mb-3">
                                                        <img src="{{ asset('assets/images/Buy With Confidence.png') }}">
                                                    </div>
                                                    <h5 class="mb-3 dashboard_heading text-center"><span class="heading_class">Buy With Confidence</span></h5>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div> -->
                             <!--     <div class="col-md-12 col-xl-3 dashboard_new_upper">
                                    <a href="{{route('setting.taxes')}}">
                                        <div class="card card-social third_box">
                                            <div class="card-block">
                                                <div class="row">
                                                    <div class="col text-center mb-3">
                                                        <img src="{{ asset('assets/images/Taxes.png') }}">
                                                    </div>
                                                    <h5 class="mb-3 dashboard_heading text-center"><span class="heading_class">Taxes</span></h5>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div> -->

                                <!-- sidebar new -->

                                <div class="col-md-12 col-xl-3 dashboard_new_upper">
                                    <a href="{{route('business.setting.index')}}">
                                        <div class="card card-social first_box">
                                            <div class="card-block">
                                                <div class="row">
                                                    <div class="col text-center mb-3">
                                                        <img src="{{ asset('assets/images/business_setting.png') }}">
                                                    </div>
                                                    <h5 class="mb-3 dashboard_heading text-center"><span class="heading_class">Business Settings</span></h5>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>   
                                 <div class="col-md-12 col-xl-3 dashboard_new_upper">
                                    <a href="{{route('global_settings.index')}}">
                                        <div class="card card-social second_box">
                                            <div class="card-block">
                                                <div class="row">
                                                    <div class="col text-center mb-3">
                                                        <img src="{{ asset('assets/images/global_settings.png') }}">
                                                    </div>
                                                    <h5 class="mb-3 dashboard_heading text-center"><span class="heading_class">Global Settings</span></h5>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div> 
                                <div class="col-md-12 col-xl-3 dashboard_new_upper">
                                    <a href="{{route('pagesetting.index')}}">
                                        <div class="card card-social third_box">
                                            <div class="card-block">
                                                <div class="row">
                                                    <div class="col text-center mb-3">
                                                        <img src="{{ asset('assets/images/page_settings.png') }}">
                                                    </div>
                                                    <h5 class="mb-3 dashboard_heading text-center"><span class="heading_class">Page Settings</span></h5>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                           
                            <!-- [ Main Content ] end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')

@endsection
