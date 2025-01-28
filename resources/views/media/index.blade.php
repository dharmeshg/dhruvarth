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
                            <li class="breadcum-item active"><a href="javascript:;"> Media </a></li>
                        </ul>
                    </div>

                    <!-- [ breadcrumb ] end -->
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page_header mb-3">
                                <h5>Media</h5>
                            </div>
                            <!-- [ Main Content ] start -->
                            <div class="row">

                                <!--[ Recent Users ] start-->
                              <!--   <div class="col-md-12 col-xl-3 dashboard_new_upper">
                                    <a href="{{ route('media.section',['sec' => 'ads-poster']) }}">
                                        <div class="card card-social first_box">
                                            <div class="card-block">
                                                <div class="row">
                                                    <div class="col text-center mb-3">
                                                        <img src="{{ asset('assets/images/Ads-Poster.png') }}">
                                                    </div>
                                                    <h5 class="mb-3 dashboard_heading text-center"><span class="heading_class">Ads Poster</span></h5>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-12 col-xl-3 dashboard_new_upper">
                                    <a href="{{ route('media.section',['sec' => 'logo-slider']) }}">
                                        <div class="card card-social second_box">
                                            <div class="card-block">
                                                <div class="row">
                                                    <div class="col text-center mb-3">
                                                        <img src="{{ asset('assets/images/Total-Gemstone.png') }}">
                                                    </div>
                                                    <h5 class="mb-3 dashboard_heading text-center"><span class="heading_class">Logo Slider</span></h5>
                                                </div>
                                            </div>

                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-12 col-xl-3 dashboard_new_upper">
                                    <a href="{{ route('media.section',['sec' => 'pdf-list']) }}">
                                        <div class="card card-social third_box">
                                            <div class="card-block">
                                                <div class="row">
                                                    <div class="col text-center mb-3">
                                                        <img src="{{ asset('assets/images/Total-Catalog.png') }}">
                                                    </div>
                                                    <h5 class="mb-3 dashboard_heading text-center"><span class="heading_class">PDF List</span></h5>
                                                </div>
                                            </div>

                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-12 col-xl-3 dashboard_new_upper">
                                    <a href="{{ route('pagebanner.index') }}">
                                        <div class="card card-social fourth_box">
                                            <div class="card-block">
                                                <div class="row">
                                                    <div class="col text-center mb-3">
                                                        <img src="{{ asset('assets/images/Total-Collection.png') }}">
                                                    </div>
                                                    <h5 class="mb-3 dashboard_heading text-center"><span class="heading_class">Page Banner</span></h5>
                                                </div>
                                            </div>

                                        </div>
                                    </a>
                                </div> -->

                                <!-- new sidebar -->

                                <div class="col-md-12 col-xl-3 dashboard_new_upper">
                                    <a href="{{route('sliderbanner.index')}}">
                                        <div class="card card-social first_box">
                                            <div class="card-block">
                                                <div class="row">
                                                    <div class="col text-center mb-3">
                                                        <img src="{{ asset('assets/images/slider_banner.png') }}">
                                                    </div>
                                                    <h5 class="mb-3 dashboard_heading text-center"><span class="heading_class">Slider Banner</span></h5>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-12 col-xl-3 dashboard_new_upper">
                                    <a href="{{ route('media.section',['sec' => 'ads-poster']) }}">
                                        <div class="card card-social second_box">
                                            <div class="card-block">
                                                <div class="row">
                                                    <div class="col text-center mb-3">
                                                        <img src="{{ asset('assets/images/poster.png') }}">
                                                    </div>
                                                    <h5 class="mb-3 dashboard_heading text-center"><span class="heading_class">Posters</span></h5>
                                                </div>
                                            </div>

                                        </div>
                                    </a>
                                </div>
                                 <div class="col-md-12 col-xl-3 dashboard_new_upper">
                                    <a href="{{ route('media.section',['sec' => 'logo-slider']) }}">
                                        <div class="card card-social third_box">
                                            <div class="card-block">
                                                <div class="row">
                                                    <div class="col text-center mb-3">
                                                        <img src="{{ asset('assets/images/logo_slider.png') }}">
                                                    </div>
                                                    <h5 class="mb-3 dashboard_heading text-center"><span class="heading_class">Logo Slider</span></h5>
                                                </div>
                                            </div>

                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-12 col-xl-3 dashboard_new_upper">
                                    <a href="{{ route('media.section',['sec' => 'pdf-list']) }}">
                                        <div class="card card-social fourth_box">
                                            <div class="card-block">
                                                <div class="row">
                                                    <div class="col text-center mb-3">
                                                        <img src="{{ asset('assets/images/pdf.png') }}">
                                                    </div>
                                                    <h5 class="mb-3 dashboard_heading text-center"><span class="heading_class">PDF</span></h5>
                                                </div>
                                            </div>

                                        </div>
                                    </a>
                                </div>
                                  <div class="col-md-12 col-xl-3 dashboard_new_upper">
                                    <a href="{{ route('pagebanner.index') }}">
                                        <div class="card card-social fourth_box">
                                            <div class="card-block">
                                                <div class="row">
                                                    <div class="col text-center mb-3">
                                                        <img src="{{ asset('assets/images/page_banner.png') }}">
                                                    </div>
                                                    <h5 class="mb-3 dashboard_heading text-center"><span class="heading_class">Page Banner</span></h5>
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
