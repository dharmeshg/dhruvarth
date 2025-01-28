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
                            <li class="breadcum-item active"><a href="javascript:;">Bulk Upload</a></li>
                        </ul>
                    </div>

                    <!-- [ breadcrumb ] end -->
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page_header mb-3">
                                <h5>Bulk Upload</h5>
                            </div>
                            <!-- [ Main Content ] start -->
                            <div class="row">

                                <!--[ Recent Users ] start-->
                                <div class="col-md-12 col-xl-3 dashboard_new_upper">
                                    <a href="{{route('bulk.product.upload')}}">
                                        <div class="card card-social first_box">
                                            <div class="card-block">
                                                <div class="row">
                                                    <div class="col text-center mb-3">
                                                        <img src="{{ asset('assets/images/productupload.svg') }}">
                                                    </div>
                                                    <h5 class="mb-3 dashboard_heading text-center"><span class="heading_class">Product Upload</span></h5>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-12 col-xl-3 dashboard_new_upper">
                                    <a href="{{route('bulk.variant.upload')}}">
                                        <div class="card card-social second_box">
                                            <div class="card-block">
                                                <div class="row">
                                                    <div class="col text-center mb-3">
                                                        <img src="{{ asset('assets/images/variantupload.svg') }}">
                                                    </div>
                                                    <h5 class="mb-3 dashboard_heading text-center"><span class="heading_class">Variant Upload</span></h5>
                                                </div>
                                            </div>

                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-12 col-xl-3 dashboard_new_upper">
                                    <a href="{{route('bulk.product.image.upload')}}">
                                        <div class="card card-social third_box">
                                            <div class="card-block">
                                                <div class="row">
                                                    <div class="col text-center mb-3">
                                                        <img src="{{ asset('assets/images/imageupload.svg') }}">
                                                    </div>
                                                    <h5 class="mb-3 dashboard_heading text-center"><span class="heading_class">Product Image Upload</span></h5>
                                                </div>
                                            </div>

                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-12 col-xl-3 dashboard_new_upper">
                                    <a href="{{route('bulk.video.upload')}}">
                                        <div class="card card-social fourth_box">
                                            <div class="card-block">
                                                <div class="row">
                                                    <div class="col text-center mb-3">
                                                        <img src="{{ asset('assets/images/videoupload.svg') }}">
                                                    </div>
                                                    <h5 class="mb-3 dashboard_heading text-center"><span class="heading_class">Product Video Upload</span></h5>
                                                </div>
                                            </div>

                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-12 col-xl-3 dashboard_new_upper">
                                    <a href="{{route('bulk.certificate.upload')}}">
                                        <div class="card card-social fourth_box">
                                            <div class="card-block">
                                                <div class="row">
                                                    <div class="col text-center mb-3">
                                                        <img src="{{ asset('assets/images/certificateupload.svg') }}">
                                                    </div>
                                                    <h5 class="mb-3 dashboard_heading text-center"><span class="heading_class">Product Certificate Upload</span></h5>
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
