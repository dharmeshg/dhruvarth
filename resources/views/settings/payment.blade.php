@extends('layouts.backend.index')
@section('main_content')
<div class="pcoded-wrapper">
    <div class="pcoded-content">
        <div class="pcoded-inner-content">
            <!-- [ breadcrumb ] start -->
            <div class="custom_breadcum">
                <ul>
                    <li class="breadcum-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                    <li class="breadcum-item"><a href="{{route('setting_all.index')}}"> Settings </a></li>
                    <li class="breadcum-item active"><a href="javascript:;"> Payment Option</a></li>
                </ul>
            </div>
            <!-- [ breadcrumb ] end -->
            <div class="main-body">
                <div class="page-wrapper">
                    <!-- [ Main Content ] start -->
                    <form action="{{ route('settings.payment-option.save') }}" method="POST" data-parsley-validate=""
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 cpl-sm-12 col-xs-12 add-product-step-form-sec">
                            <div class="Recent-Users">
                                <div class="card-block px-0 py-3">
                                    <div class="row">
                                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 sub-heading">
                                            <h3>Payment Method</h3>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-4 col-sm-12 col-xs-12">
                                            <label for="">Payment Gateway <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select for credit card - Yes/No"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                            <div class="radio-options">

                                                <label class="radio-inline">
                                                    <input type="radio" name="payment_g" value="yes" {{ isset($setting->payment_g) && $setting->payment_g == 'yes' ? 'checked' : ''}}>Yes</label>
                                                    <label class="radio-inline">
                                                        <input type="radio" name="payment_g" value="no" {{ isset($setting->payment_g) && $setting->payment_g == 'no' ? 'checked' : ''}}>No
                                                    </label>

                                                </div>
                                            </div>
                                            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-4 col-sm-12 col-xs-12">
                                                <label for="">COD <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select for COD - Yes/No"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                                <div class="radio-options">

                                                    <label class="radio-inline">
                                                        <input type="radio" name="cod" value="yes" {{ isset($setting->cod) && $setting->cod == 'yes' ? 'checked' : ''}}>Yes</label>
                                                        <label class="radio-inline">
                                                            <input type="radio" name="cod" value="no" {{ isset($setting->cod) && $setting->cod == 'no' ? 'checked' : ''}}>No
                                                        </label>

                                                    </div>
                                                </div>

                                                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-4 col-sm-12 col-xs-12">
                                                    <label for="">CCOD <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select for CCOD - Yes/No"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                                    <div class="radio-options">

                                                        <label class="radio-inline">
                                                            <input type="radio" name="ccod" value="yes" {{ isset($setting->ccod) && $setting->ccod == 'yes' ? 'checked' : ''}}>Yes</label>
                                                            <label class="radio-inline">
                                                                <input type="radio" name="ccod" value="no" {{ isset($setting->ccod) && $setting->ccod == 'no' ? 'checked' : ''}}>No
                                                            </label>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row form-sec mt-4">
                                                    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 label-sec">
                                                        <button type="submit" id="submit_form" class="common-sub-btn">Save</button>
                                                    </div>
                                                </div>
                                            </div>  
                                        </div>
                                    </div>
                                </form>
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
