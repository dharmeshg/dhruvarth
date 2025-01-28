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
                            <li class="breadcum-item active"><a href="javascript:;">Inventory</a></li>
                        </ul>
                    </div>

                    <!-- [ breadcrumb ] end -->
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page_header mb-3">
                                <h5>Products</h5>
                            </div>
                            <!-- [ Main Content ] start -->
                            <div class="row">

                                <!--[ Recent Users ] start-->
                                <div class="col-md-12 col-xl-3 dashboard_new_upper">
                                    <a href="{{route('product.index')}}">
                                        <div class="card card-social first_box">
                                            <div class="card-block">
                                                <div class="row">
                                                    <div class="col text-center mb-3">
                                                        <img src="{{ asset('assets/images/product_listing.png') }}">
                                                    </div>
                                                    <h5 class="mb-3 dashboard_heading text-center"><span class="heading_class">Product</span></h5>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-12 col-xl-3 dashboard_new_upper">
                                    <a href="{{route('variant.index')}}">
                                        <div class="card card-social second_box">
                                            <div class="card-block">
                                                <div class="row">
                                                    <div class="col text-center mb-3">
                                                        <img src="{{ asset('assets/images/variant.png') }}">
                                                    </div>
                                                    <h5 class="mb-3 dashboard_heading text-center"><span class="heading_class">Variants</span></h5>
                                                </div>
                                            </div>

                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-12 col-xl-3 dashboard_new_upper">
                                    <a href="{{route('catalogue.index')}}">
                                        <div class="card card-social third_box">
                                            <div class="card-block">
                                                <div class="row">
                                                    <div class="col text-center mb-3">
                                                        <img src="{{ asset('assets/images/catalogue.png') }}">
                                                    </div>
                                                    <h5 class="mb-3 dashboard_heading text-center"><span class="heading_class">Catalogue</span></h5>
                                                </div>
                                            </div>

                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-12 col-xl-3 dashboard_new_upper">
                                    <a href="{{route('collection.index')}}">
                                        <div class="card card-social fourth_box">
                                            <div class="card-block">
                                                <div class="row">
                                                    <div class="col text-center mb-3">
                                                        <img src="{{ asset('assets/images/collection.png') }}">
                                                    </div>
                                                    <h5 class="mb-3 dashboard_heading text-center"><span class="heading_class">Collection</span></h5>
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
