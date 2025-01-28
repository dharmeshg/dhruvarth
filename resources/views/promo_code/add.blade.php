@extends('layouts.backend.index')
@section('main_content')
<style>
    .mobile_code{padding-left: 100px !important;}
    .iti--allow-dropdown{width: 100%;}
    .note_error{color: red;}
    .suggested_tags {
        position: absolute;
        z-index: 1;
        background-color: #fff;
        width: 92%;
        min-height: 0px;
        max-height: 250px;
        overflow-y: auto;
        list-style: none;
        color: #000;
    }
    .suggested_tags .suggested_li{
        cursor: pointer;
        padding: 4px 6px;
        font-size: 15px;
    }
    .suggested_tags.active{border: 1px solid #aaa;}
    .suggested_tags .suggested_li:hover{background-color: var(--theme-orange-red);}
    h6{font-size: 16px; font-weight: 700;}
    .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active{color: #000;background-color: var(--theme-orange-red);}
</style>
<div class="pcoded-wrapper">
    <div class="pcoded-content">
        <div class="pcoded-inner-content">
            <!-- [ breadcrumb ] start -->
            <div class="custom_breadcum">
                <ul>
                    <li class="breadcum-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                     <li class="breadcum-item"><a href="{{route('promo_code.index')}}">Promotion</a></li>
                    <li class="breadcum-item active"><a href="javascript:;"> {{ isset($promocode) ? 'Edit' : 'Add'}} Promo Code </a></li>
                </ul>
            </div>
            <!-- [ breadcrumb ] end -->
            <div class="main-body">
                <div class="page-wrapper">
                    <!-- [ Main Content ] start -->
                    <form id="promocode_form" action="{{ route('promo_code.save') }}" method="POST" data-parsley-validate="" enctype="multipart/form-data">
                        @csrf
                    <div class="row">
                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 cpl-sm-12 col-xs-12 ">
                            <div class="Recent-Users add-article">
                                <h3 class="add_heading">{{ isset($promocode) ? 'Edit' : 'Add'}} Promo Code</h3>
                                <div class="input_group mt-3 px-0 py-3">
                                    <div class="row">
                                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 mb-3">
                                            <div class="form-sec">
                                                    <input type="hidden" name="promocode_id"
                                                        value="{{ isset($promocode->id) ? $promocode->id : '' }}" class="form-control">
                                                    <label for="">Title <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please insert Title"><i class="fa fa-info-circle" aria-hidden="true"></i></span><span style="color: red;margin: 0;">*</label>
                                                    <input type="text" name="title" id="title" placeholder="Enter Title" required
                                                    data-parsley-required-message="Please Enter Title" class="form-control" value="{{ isset($promocode->title) ? $promocode->title : '' }}">
                                            </div>
                                        </div>
                                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 mb-3">
                                            <div class="form-sec">
                                                    <label for="">Code <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Enter a 8 digit Promo Code in Capital Letters only"><i class="fa fa-info-circle" aria-hidden="true"></i></span><span style="color: red;margin: 0;">*</label>
                                                        <input type="text" name="code" id="code" placeholder="Enter Code" required
                                                        data-parsley-required-message="Please Enter Code" 
                                                        data-parsley-pattern="^[A-Z0-9]{8}$"
                                                        data-parsley-minlength="8" 
                                                        data-parsley-maxlength="8" 
                                                        data-parsley-pattern-message="Code must be exactly 8 characters and alphanumeric only capital"
                                                        class="form-control" 
                                                        value="{{ isset($promocode->code) ? $promocode->code : '' }}">
                                                     <span id="code_error" style="color: red;"></span>   
                                            </div>
                                        </div>
                                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-3">
                                            <div class="form-sec">
                                                    <label for="">Description <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please insert Description"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                                    <textarea class="form-control" name="description"  placeholder="Enter Description" rows="3" cols="3" data-parsley-required-message="Description is required" data-parsley-maxlength="160" data-parsley-maxlength-message="Description cannot exceed 160 characters." maxlength="160" style="height:auto !important;" >{{ isset($promocode->description) ? $promocode->description : '' }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12 mb-3">
                                            <div class="form-sec">
                                                <label for="">Start Date <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please Select Start Date"><i class="fa fa-info-circle" aria-hidden="true"></i></span><span style="color: red;margin: 0;">*</label>
                                                <input type="text" name="start_date" class="form-control me-2" placeholder="From Date" readonly id="from_date" required data-parsley-required-message="Please Select Start Date" value="{{ isset($promocode->startDate) ? $promocode->startDate : '' }}">
                                                <span class=""></span>
                                            </div>
                                        </div>
                                        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12 mb-3">
                                            <div class="form-sec">
                                                <label for="">End Date <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please Select End Date"><i class="fa fa-info-circle" aria-hidden="true"></i></span><span style="color: red;margin: 0;">*</label>
                                                <input type="text" name="end_date" placeholder="To Date" class="form-control" id="to_date" readonly required data-parsley-required-message="Please Select End Date" value="{{ isset($promocode->endDate) ? $promocode->endDate : '' }}">
                                            </div>
                                        </div>
                                        <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-12 col-sm-12 col-xs-12 mb-3">
                                            <label for="">Type <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please Select Type"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                            <div class="radio-options">
                                                <label class="radio-inline">
                                                    <input type="radio" name="type" value="amount" checked="" {{ isset($promocode->discount_type) && $promocode->discount_type == 'amount' ? 'checked' : '' }}>Amount</label>
                                                  <label class="radio-inline">
                                                    <input type="radio" name="type" value="percentage" {{ isset($promocode->discount_type) && $promocode->discount_type == 'percentage' ? 'checked' : '' }}>Percentage
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12 mb-3">
                                            <label for="">Discount <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please insert Discount"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                            <input type="number" name="discount" class="form-control me-2" placeholder="Enter Discount" required data-parsley-required-message="Please Enter Discount" value="{{ isset($promocode->discount) ? $promocode->discount : '' }}">
                                        </div>
                                        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-12 col-sm-12 col-xs-12 mb-3" id="max_discount_amount" @if(isset($promocode->discount_type) && $promocode->discount_type == 'percentage') @else style="display: none;" @endif>
                                            <label for="">Maximum Discount Amount <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please insert Maximum Discount Amount"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                            <input type="number" name="max_discount_amount" class="form-control me-2" placeholder="Enter Maximum Discount Amount" value="{{ isset($promocode->max_discount_amount) ? $promocode->max_discount_amount : '' }}">
                                        </div>
                                        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-12 col-sm-12 col-xs-12 mb-3">
                                            <label for="">Minimum Cart Amount <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please insert Minimum Cart Amount"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                            <input type="number" name="min_cart_amount" class="form-control me-2" placeholder="Enter Minimum Cart Amount" required value="{{ isset($promocode->minimum_cart_amount) ? $promocode->minimum_cart_amount : '' }}">
                                        </div>
                                        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-12 col-sm-12 col-xs-12 mb-3">
                                            <label for="">Discount on Discounted Product <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please Select Discount on Discounted Product"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                            <div class="radio-options">
                                                <label class="radio-inline">
                                                    <input type="radio" name="discount_on_dis_product" value="yes" checked="" {{ isset($promocode->discounted_product) && $promocode->discounted_product == 'yes' ? 'checked' : '' }}>Yes</label>
                                                  <label class="radio-inline">
                                                    <input type="radio" name="discount_on_dis_product" value="no" {{ isset($promocode->discounted_product) && $promocode->discounted_product == 'no' ? 'checked' : '' }}>No
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-12 col-sm-12 col-xs-12 mb-3">
                                            <label for="">One Time Use <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please Select One Time Use"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                            <div class="radio-options">
                                                <label class="radio-inline">
                                                    <input type="radio" name="one_time_use" value="yes" checked="" {{ isset($promocode->one_time_use) && $promocode->one_time_use == 'yes' ? 'checked' : '' }}>Yes</label>
                                                  <label class="radio-inline">
                                                    <input type="radio" name="one_time_use" value="no" {{ isset($promocode->one_time_use) && $promocode->one_time_use == 'no' ? 'checked' : '' }}>No
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-12 col-sm-12 col-xs-12 mb-3">
                                            <label for="">Single Time Use Per User <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please Select Single Time User Per Code"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                            <div class="radio-options">
                                                <label class="radio-inline">
                                                    <input type="radio" name="single_time_use" value="yes" checked="" {{ isset($promocode->single_time_use) && $promocode->single_time_use == 'yes' ? 'checked' : '' }}>Yes</label>
                                                  <label class="radio-inline">
                                                    <input type="radio" name="single_time_use" value="no" {{ isset($promocode->single_time_use) && $promocode->single_time_use == 'no' ? 'checked' : '' }}>No
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-12 col-sm-12 col-xs-12 mb-3">
                                            <label for="">Status <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please Select Single Time User Per Code"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                            <div class="radio-options">
                                                <label class="radio-inline">
                                                    <input type="radio" name="status" value="active" checked="" {{ isset($promocode->status) && $promocode->status == 'active' ? 'checked' : '' }}>Active</label>
                                                  <label class="radio-inline">
                                                    <input type="radio" name="status" value="inactive" {{ isset($promocode->status) && $promocode->status == 'inactive' ? 'checked' : '' }}>InActive
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-12 col-sm-12 col-xs-12 mb-3">
                                            <label for="">Public <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please Select Single Time User Per Code"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                            <div class="radio-options">
                                                <label class="radio-inline">
                                                    <input type="radio" name="public" value="yes" checked="" {{ isset($promocode->publish_status) && $promocode->publish_status == 'yes' ? 'checked' : '' }}>Yes</label>
                                                  <label class="radio-inline">
                                                    <input type="radio" name="public" value="no" {{ isset($promocode->publish_status) && $promocode->publish_status == 'no' ? 'checked' : '' }}>No
                                                </label>
                                            </div>
                                        </div>
                                        <h5 class="mt-3 mx-1">Inclusions/Exclusion</h5>
                                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-3">
                                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link text-uppercase active show" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Include</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link text-uppercase" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Exclude</a>
                                                </li>
                                            </ul>
                                            <div class="tab-content" id="myTabContent">
                                                {{-- include Section start --}}
                                                <div class="tab-pane fade active show" id="home" role="tabpanel" aria-labelledby="home-tab">
                                                    <input type="hidden" name="all_included_products" id="all_included_products" value="{{ isset($promocode->included_products) ? $promocode->included_products : '' }}">
                                                    <div class="row">
                                                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-3">
                                                            <label for="">Category <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please Select Category to include."><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                                            <div class="category-check-div">
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" id="include_cat_0" name="include_category[]" value="all" @if(isset($exploded_i_cats) && count($exploded_i_cats) > 0 && in_array('all',$exploded_i_cats)) checked @endif>
                                                                    <label class="custom-control-label" for="include_cat_0" style="cursor: pointer;">All</label>
                                                                </div>
                                                                @if(isset($categories) && count($categories) > 0)
                                                                @foreach($categories as $key => $category)
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" id="include_cat_{{ $key+1 }}" name="include_category[]" value="{{ $category->id }}" @if(isset($exploded_i_cats) && count($exploded_i_cats) > 0 && (in_array($category->id,$exploded_i_cats) || in_array('all',$exploded_i_cats))) checked @endif>
                                                                    <label class="custom-control-label" for="include_cat_{{ $key+1 }}" style="cursor: pointer;">{{ $category->category }}</label>
                                                                </div>
                                                                @endforeach
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12 mb-3">
                                                            <label for="">Search Product <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please Select Product to include."><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                                            <input type="text" name="include_product" class="form-control" placeholder="Search by Product Title Or SKU" id="include_product">
                                                            <div id="suggested_include_product" class="suggested_tags"></div>
                                                        </div>
                                                        <div class="col-xxl-9 col-xl-9 col-lg-9 col-md-9 col-sm-12 col-xs-12 mb-3">
                                                            <label for="">Products <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please Select Product to include."><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                                            <div class="included_products_div product_append_div">
                                                                @if(isset($exploded_i_products) && count($exploded_i_products) > 0)
                                                                @foreach($exploded_i_products as $i_pro)
                                                                    @if(isset($i_pro) && $i_pro != '')
                                                                        <span class="each-sku"><p>{{ $i_pro }}</p><a class="remove_included_product remove_icon" data-sku="{{ $i_pro }}"><i class="fa fa-times-circle" aria-hidden="true"></i></a></span>
                                                                    @endif
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- include section end --}}
                                                {{-- exclude section start --}}
                                                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                                    <input type="hidden" name="all_excluded_products" id="all_excluded_products" value="{{ isset($promocode->excluded_products) ? $promocode->excluded_products : '' }}">
                                                    <div class="row">
                                                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-3">
                                                            <label for="">Category <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please Select Category to Exclude."><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                                            <div class="category-check-div">
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" id="exclude_cat_0" name="exclude_category[]" value="all" @if(isset($exploded_e_cats) && count($exploded_e_cats) > 0 && in_array('all',$exploded_e_cats)) checked @endif>
                                                                    <label class="custom-control-label" for="exclude_cat_0" style="cursor: pointer;">All</label>
                                                                </div>
                                                                @if(isset($categories) && count($categories) > 0)
                                                                @foreach($categories as $key => $category)
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" id="exclude_cat_{{ $key+1 }}" name="exclude_category[]" value="{{ $category->id }}" @if(isset($exploded_e_cats) && count($exploded_e_cats) > 0 && (in_array($category->id,$exploded_e_cats) || in_array('all',$exploded_e_cats))) checked @endif>
                                                                    <label class="custom-control-label" for="exclude_cat_{{ $key+1 }}" style="cursor: pointer;">{{ $category->category }}</label>
                                                                </div>
                                                                @endforeach
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12 mb-3">
                                                            <label for="">Search Product <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please Select Product to exclude."><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                                            <input type="text" name="exclude_product" class="form-control" placeholder="Search by Product Title Or SKU" id="exclude_product">
                                                            <div id="suggested_exclude_product" class="suggested_tags"></div>
                                                        </div>
                                                        <div class="col-xxl-9 col-xl-9 col-lg-9 col-md-9 col-sm-12 col-xs-12 mb-3">
                                                            <label for="">Products <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please Select Product to exclude."><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                                            <div class="excluded_products_div product_append_div">
                                                                @if(isset($exploded_e_products) && count($exploded_e_products) > 0)
                                                                @foreach($exploded_e_products as $e_pro)
                                                                    @if(isset($e_pro) && $e_pro != '')
                                                                        <span class="each-sku"><p>{{ $e_pro }}</p><a class="remove_exclude_product remove_icon" data-sku="{{ $e_pro }}"><i class="fa fa-times-circle" aria-hidden="true"></i></a></span>
                                                                    @endif
                                                                @endforeach
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- exclude section end --}}
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
@endsection
@section('script')
<script>
$(document).ready(function() {
    $("#from_date").datepicker({ 
    autoclose: true, 
    todayHighlight: true
    }).on('changeDate', function(selected) {
    var startDate = new Date(selected.date.valueOf());
    $('#to_date').datepicker('setStartDate', startDate);
    });

    $("#to_date").datepicker({ 
    autoclose: true, 
    todayHighlight: true
    });
});
$(document).on('change', '#code', function() {
    var token = $("meta[name='csrf-token']").attr("content");
    var code = $(this).val();
    $.ajax({
        url: admin_url + "check/existing-promo-code",
        type: "post",
        data: {
            _token: token,
            code: code,
        },
        success: function(response) {
        if(response.status == 1)
        {
            $('#code_error').text(response.message);
            $('#submit_form').prop('disabled',true);
        }else{
            $('#code_error').text('');
            $('#submit_form').prop('disabled',false);
        }
        }
    });
});
// include part js start here
$(document).on('keyup', '#include_product', function() {
    var sku = $(this).val(); 
    var token = $("meta[name='csrf-token']").attr("content");
    $.ajax({
        url: admin_url + "promo-code/search-product",
        type: "post",
        data: {
            _token: token,
            sku: sku,
        },
        success: function(response) {
            if(response.status == 1)
            {
                $('#suggested_include_product').addClass('active').empty();
                response.data.forEach(function(product) {
                    $('#suggested_include_product').append('<li class="search_include_product suggested_li" data-sku="'+ product.p_sku +'" data-product-id="'+ product.id +'">' + product.p_sku + ' - ' + product.p_title + '</li>');
                });
            }else if(response.status == 2){
                $('#suggested_include_product').addClass('active').empty();
                $('#suggested_include_product').append('<li class="search_include_product suggested_li">No Products Found</li>');
            }else{
                $('#suggested_include_product').removeClass('active').empty();
            }
        }
    });
});
$(document).on('click', '.search_include_product', function() {
    var sku = $(this).data('sku');
    var product_id = $(this).data('product-id');
    var $includedProductsDiv = $('.included_products_div');
    var iexistingSku = $includedProductsDiv.find('.each-sku p:contains(' + sku + ')');

    var html = '<span class="each-sku"><p>'+ sku +'</p><a class="remove_included_product remove_icon" data-sku="'+ sku +'"><i class="fa fa-times-circle" aria-hidden="true"></i></a></span>';
    if (iexistingSku.length === 0) {
        $('.included_products_div').append(html);
        var currentValue = $('#all_included_products').val();

        if (currentValue === '') {
            $('#all_included_products').val(sku);
        } else {
            $('#all_included_products').val(currentValue + ',' + sku);
        }
    }
});
$(document).on('click', '.remove_included_product', function() {
    var sku = $(this).data('sku');
    var currentValue = $('#all_included_products').val();
    var skuArray = currentValue.split(',');
    var index = skuArray.indexOf(sku);
    if (index > -1) {
        skuArray.splice(index, 1);
    }
    $('#all_included_products').val(skuArray.join(','));
    $(this).closest('.each-sku').remove();
});
// include part js end here

// Exclude part js start here
$(document).on('keyup', '#exclude_product', function() {
    var sku = $(this).val(); 
    var token = $("meta[name='csrf-token']").attr("content");
    $.ajax({
        url: admin_url + "promo-code/search-product",
        type: "post",
        data: {
            _token: token,
            sku: sku,
        },
        success: function(response) {
            if(response.status == 1)
            {
                $('#suggested_exclude_product').addClass('active').empty();
                response.data.forEach(function(product) {
                    $('#suggested_exclude_product').append('<li class="search_exclude_product suggested_li" data-sku="'+ product.p_sku +'" data-product-id="'+ product.id +'">' + product.p_sku + ' - '+ product.p_title +'</li>');
                });
            }else if(response.status == 2){
                $('#suggested_exclude_product').addClass('active').empty();
                $('#suggested_exclude_product').append('<li class="search_exclude_product suggested_li">No Products Found</li>');
            }else{
                $('#suggested_exclude_product').removeClass('active').empty();
            }
        }
    });
});
$(document).on('click', '.search_exclude_product', function() {
    var sku = $(this).data('sku');
    var product_id = $(this).data('product-id');
    var $excludedProductsDiv = $('.excluded_products_div');
    var existingSku = $excludedProductsDiv.find('.each-sku p:contains(' + sku + ')');

    var html = '<span class="each-sku"><p>'+ sku +'</p><a class="remove_exclude_product remove_icon" data-sku="'+ sku +'"><i class="fa fa-times-circle" aria-hidden="true"></i></a></span>';
    if (existingSku.length === 0) {
        $('.excluded_products_div').append(html);
        var currentValue = $('#all_excluded_products').val();

        if (currentValue === '') {
            $('#all_excluded_products').val(sku);
        } else {
            $('#all_excluded_products').val(currentValue + ',' + sku);
        }
    }
});
$(document).on('click', '.remove_exclude_product', function() {
    var sku = $(this).data('sku');
    var currentValue = $('#all_excluded_products').val();
    var skuArray = currentValue.split(',');
    var index = skuArray.indexOf(sku);
    if (index > -1) {
        skuArray.splice(index, 1);
    }
    $('#all_excluded_products').val(skuArray.join(','));
    $(this).closest('.each-sku').remove();
});
// exclude part end here

$(document).on('click', function(event) {
    // Check if the click happened outside the #include_product input and #suggested_include_product div
    if (!$(event.target).closest('#include_product, #suggested_include_product,#exclude_product, #suggested_exclude_product').length) {
        $('#include_product').val(''); // Clear the input field
        $('#suggested_include_product').removeClass('active').empty(); // Clear the suggestions div
        $('#exclude_product').val(''); // Clear the input field
        $('#suggested_exclude_product').removeClass('active').empty();
    }
});
$(document).on('change', 'input[name="type"]', function() {
    var selectedValue = $('input[name="type"]:checked').val();
    if(selectedValue == 'percentage')
    {
        $('#max_discount_amount').show();
    }else{
        $('#max_discount_amount').hide();
    }
});
$('#include_cat_0').change(function() {
    if ($(this).is(':checked')) {
        $('input[name="include_category[]"]').prop('checked', true);
    } else {
        $('input[name="include_category[]"]').prop('checked', false);
    }
});

$('input[name="include_category[]"]').not('#include_cat_0').change(function() {
    if (!$(this).is(':checked')) {
        $('#include_cat_0').prop('checked', false);
    } else {
        if ($('input[name="include_category[]"]').not('#include_cat_0').length == $('input[name="include_category[]"]:checked').not('#include_cat_0').length) {
            $('#include_cat_0').prop('checked', true);
        }
    }
});

$('#exclude_cat_0').change(function() {
    if ($(this).is(':checked')) {
        $('input[name="exclude_category[]"]').prop('checked', true);
    } else {
        $('input[name="exclude_category[]"]').prop('checked', false);
    }
});

$('input[name="exclude_category[]"]').not('#exclude_cat_0').change(function() {
    if (!$(this).is(':checked')) {
        $('#exclude_cat_0').prop('checked', false);
    } else {
        if ($('input[name="exclude_category[]"]').not('#exclude_cat_0').length == $('input[name="exclude_category[]"]:checked').not('#exclude_cat_0').length) {
            $('#exclude_cat_0').prop('checked', true);
        }
    }
});
</script>
@endsection
