@extends('layouts.backend.index')
@section('main_content')
<style>
.static-value{
    position: absolute;
  left: 27px;
  top: 39px;
}
.each-icon-details .preview_image img {
    width: 100px;
    height: 100px;
}
.tax-sec{padding: 15px;background: #eee;border-radius: 5px;margin-bottom: 20px;}
</style>
<link rel="stylesheet" href="https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.css">
<div class="pcoded-wrapper">
    <div class="pcoded-content">
        <div class="pcoded-inner-content">
            <!-- [ breadcrumb ] start -->
            <div class="custom_breadcum">
                <ul>
                    <li class="breadcum-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                    <li class="breadcum-item"><a href="{{route('product_all.index')}}">Inventory</a></li>
                    <li class="breadcum-item"><a href="{{route('product.index')}}"> Product </a></li>
                    <li class="breadcum-item active"><a href="javascript:;"> {{ isset($product) ? 'Edit ' : 'Add '  }} Product</a></li>
                </ul>
            </div>
            <!-- [ breadcrumb ] end -->
            <div class="main-body">
                <div class="page-wrapper add-product-step-form-sec">
                    <!-- [ Main Content ] start -->
                    <form action="{{ route('product.save') }}" method="POST" enctype="multipart/form-data" data-parsley-validate="" id="product_add_form">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ isset($product->id) ? $product->id : ''}}">
                    <input type="hidden" name="product_type" value="{{ $slug }}">
                     <div class="form-step" id="step1">
                    
                        <div class="page_header">
                            <h5>{{ isset($product) ? 'Edit ' : 'Add '  }}Product (Step 1 of 5)</h5>
                            <a href="{{route('product.index')}}" class="add-common-btn">Back to Products</a>
                        </div>

                                <div class="row">
                                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-sec">
                                        <label for="">Product Category <span style="color: red;">* <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select product category"><i class="fa fa-info-circle" aria-hidden="true" style="color: black;"></i></span></span></label>
                                                <select name="p_category" class="form-control" id="all_cats" required data-parsley-errors-container="#cat_error" data-parsley-required-message="Please Select Product Category">
                                                    <option disabled selected>Select Category</option>
                                                    @if(isset($categories) && count($categories) > 0)
                                                    @foreach($categories as $cat)
                                                    <option value="{{ $cat->id }}" {{ isset($product->p_category) && $product->p_category == $cat->id ? 'selected' : '' }}>{{ isset($cat->category) ? $cat->category : '' }}</option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                                <span id="cat_error"></span>
                                        </div>
                                    </div>                                 
                                </div>

                                <div class="row">
                                    <div class="col-xxl-7 col-xl-7 col-lg-8 col-md-8 col-sm-12 col-xs-12 input_group">
                                        <label for="">Add Product Image - Upload Multiple Preview Images (Max upload to 4 images) <span style="color: red;margin: 0;">* <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please upload a product image"><i class="fa fa-info-circle" aria-hidden="true" style="color: black;"></i> </span></label>
                                        <span class="red-note">*Recommended size - 500px*500px and size upto 5MB.</span>
                                        <div class="row">
                                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12 d-flex align-items-center">
                                                <div class="me-3">
                                                    <label class="img_upload" for="large_file"><i class="fa fa-plus mx-1" aria-hidden="true"></i> Upload</label>
                                                    <input type="file" style="display: none;" name="p_image[]" id="large_file" class="large-item-img"  data-parsley-required-message="Product Image is Required" multiple data-parsley-errors-container="#large_cont" @if(isset($product_imgs) && count($product_imgs) > 0) @else required @endif>
                                                </div>
                                                @if(isset($product_imgs) && count($product_imgs) > 0)
                                                <input type="hidden" id="existing_image_count" value="{{ count($product_imgs) }}">
                                                @foreach($product_imgs as $index => $p_imgs_e)
                                                @if(isset($product->db_status) && $product->db_status != '' && $product->db_status != null && $product->db_status == 'manually')
                                                 <input type="hidden" id="existing_image_{{ $index }}" value="{{ asset('product_media/product_images/'.$p_imgs_e->name) }}">
                                                @else
                                                    <input type="hidden" id="existing_image_{{ $index }}" value="{{ asset('uploads/'.$p_imgs_e->name) }}">
                                                @endif
                                                    <input type="hidden" id="existing_id_{{ $index }}" value="{{ $p_imgs_e->id }}">
                                                @endforeach
                                                @endif
                                                <div id="image-preview-container" class="d-flex" >
                                                @if(isset($product_imgs) && count($product_imgs) > 0)
                                                @foreach($product_imgs as $p_imgs)
                                                <div class="p_img_parent" style="position: relative;" data-id="{{ $p_imgs->id }}">
                                                    @if(isset($product->db_status) && $product->db_status != '' && $product->db_status != null && $product->db_status == 'manually')
                                                     <img src="{{asset('product_media/product_images/'.$p_imgs->name)}}" class="img-fluid preview_image" id="large-item-img-output" style="margin-right:10px;">
                                                    @else
                                                        @if(file_exists(public_path('product_media/product_images/'.$p_imgs->name)))
                                                        <img src="{{asset('product_media/product_images/'.$p_imgs->name)}}" class="img-fluid preview_image" id="large-item-img-output" style="margin-right:10px;">
                                                        @else
                                                         <img src="{{asset('uploads/'.$p_imgs->name)}}" class="img-fluid preview_image" id="large-item-img-output" style="margin-right:10px;">
                                                        @endif
                                                    @endif
                                                     <a><span class="remove_icons del_p_image" data-id="{{ $p_imgs->id }}"><i class="fa fa-times-circle"></i></span></a>
                                                 </div>
                                                @endforeach
                                                @else
                                                <img src="{{asset('assets/images/user/img-demo_1041.jpg')}}" class="img-fluid preview_image" id="large-item-img-output">
                                                @endif
                                                 </div>
                                            </div>
                                        </div>
                                        <span id="large_cont"></span>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 input_group">
                                        <label for="">Pick Video <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please upload a product video"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                        <span class="red-note">*Recommended size: Square Video Upto 5MB.</span>
                                        <div class="row">
                                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12 d-flex align-items-center">
                                                <div class="me-3">
                                                    <label class="img_upload" for="video_file"><i class="fa fa-plus mx-1" aria-hidden="true"></i> Upload</label>
                                                    <input type="file" style="display: none;" name="p_video" id="video_file" class="large-item-img">
                                                </div>
                                                <div style="position: relative;">
                                                @if(isset($product->p_video) && $product->p_video != '' && $product->p_video != null)
                                                <img src="{{asset('images/videoicon.jpg')}}" class="img-fluid preview_image show_video" id="video-output" style="cursor: pointer;">
                                                <a><span><span class="remove_icons del_video" data-id="{{ $product->id }}"><i class="fa fa-times-circle"></i></span></span></a>
                                                @else
                                                <img src="{{asset('assets/images/user/img-demo_1041.jpg')}}" class="img-fluid preview_image" id="video-output">
                                                @endif
                                                 </div>
                                                 <input type="hidden" name="old_p_video" value="{{ isset($product->p_video) ? $product->p_video : '' }}" id="old_p_video">
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="row">

                                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-sec">
                                                <label for="">Product Family <span style="color: red;">* <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select product family"><i class="fa fa-info-circle" aria-hidden="true" style="color: black;"></i></span></label>
                                                <select name="p_family" class="form-control" id="all_families" required data-parsley-errors-container="#fami_error" data-parsley-error-message="Product Family is required">
                                                    <option>Select Family</option>
                                                </select>
                                                <span id="fami_error"></span>
                                        </div>
                                    </div>
                                    
                                </div>

                                <div class="row">

                                    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-sec">
                                                <label for="">Product Tags (Comma separated value) <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter Product Tags"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                                <input type="text" class="form-control" name="p_tags" id="inputTag" placeholder="Enter Product Tags" data-role="tagsinput" value="{{ isset($product->p_tags) ? $product->p_tags : ''}}">
                                        </div>
                                    </div>
                                    
                                </div>

                                <div class="row">

                                    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <label for="">Product Status <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select product status"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                        <div class="radio-options">

                                            <label class="radio-inline">
                                                <input type="radio" name="p_status"  class="p_status" value="by_order" @if(isset($product->p_status) && $product->p_status == 'by_order') checked @endif>By Order
                                              </label>
                                              <label class="radio-inline">
                                                <input type="radio" name="p_status" class="p_status" value="ready_stock" @if(isset($product->p_status) && $product->p_status == 'ready_stock') checked @endif>Ready Stock
                                              </label>

                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12" id="avil_stock_qty" @if(isset($product->p_status) && $product->p_status == 'ready_stock') @else style="display:none;" @endif>
                                        <div class="form-sec">
                                                 <label for="">Available Stock Quantity <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter available stock quantity"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                                    <input type="number" class="form-control" name="p_avail_stock_qty"  placeholder="Enter Available Stock Quantity" value="{{ isset($product->p_avail_stock_qty) ? $product->p_avail_stock_qty : '' }}">
                                        </div>
                                    </div>
                                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12" id="ltd_stock_qty" @if(isset($product->p_status) && $product->p_status == 'ready_stock') @else style="display:none;" @endif>
                                        <div class="form-sec">
                                            <label for="">Indicate Limited Stock Quantity <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter indicate limited stock quantity"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                                    <input type="number" class="form-control" name="p_ltd_stock_qty"  placeholder="Enter Indicate Limited Stock Quantity" value="{{ isset($product->p_ltd_stock_qty) ? $product->p_ltd_stock_qty : '' }}">
                                        </div>
                                    </div>
                                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-sec">
                                                <label for="">Minimum Order Quantity <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter minimum order quantity"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                                <input type="number" class="form-control" name="p_min_order_qty" id="" placeholder="Enter Minimum Order Quantity" value="{{ isset($product->p_min_order_qty) ? $product->p_min_order_qty : '' }}">
                                        </div>
                                    </div>

                                    
                                    
                                </div>

                    </div>

                    <div class="form-step" id="step2">
                    
                        <div class="page_header">
                            <h5>{{ isset($product) ? 'Edit ' : 'Add '  }}Product (Step 2 of 5)</h5>
                            <!-- <a type="button" class="add-common-btn previous-button step-form-button">Go To Previous Page</a> -->
                        </div>

                        <div class="row">

                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 sub-heading">
                                <h3>Product Details</h3>
                            </div>

                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-sec">
                                    <label for="">Product Title <span style="color: red;margin: 0;">* <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter product title"><i class="fa fa-info-circle" aria-hidden="true" style="color: black;"></i></span></label>
                                    <input type="text" class="form-control" name="p_title" id="p_title" placeholder="Enter Product Title" required data-parsley-error-message="Please Enter Product Title" value="{{ isset($product->p_title) ? $product->p_title : '' }}">
                                </div>
                            </div>

                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-sec">
                                    <label for="">Product SKU <span style="color: red;margin: 0;">* <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter product SKU"><i class="fa fa-info-circle" aria-hidden="true" style="color: black;"></i></span></label>
                                    <input type="text" class="form-control" name="p_sku" id="p_sku" placeholder="Enter Product SKU" required data-parsley-error-message="Please Enter Product SKU" value="{{ isset($product->p_sku) ? $product->p_sku : '' }}">
                                    <span id="sku_error" style="color: red;"></span>
                                    <a href="" id="exist_sku" target="_blank"></a>
                                </div>
                            </div>
                            
                        </div>


                        <div class="row">

                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-sec">
                                    <label for="">Product Description <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter product description"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                    <textarea class="form-control" name="p_description" id="p_description" placeholder="Enter Product Description">{{ isset($product->p_description) ? $product->p_description : '' }}</textarea>
                                    <span id="p_des_error"></span>
                                </div>
                            </div>
                            
                        </div>

                        <div class="row">
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-sec">
                                        <label for="">Gender <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select gender for product "><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                        <select name="p_gender" class="form-control">
                                            <option selected="" disabled>Select</option>
                                            @if(isset($genders) && count($genders) > 0)
                                            @foreach($genders as $gender)
                                            <option value="{{ $gender->title }}" {{ isset($product->p_gender) && $product->p_gender == $gender->title ? 'selected' : ''}}>{{ isset($gender->title) ? $gender->title : '' }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                        <span id="p_gen_error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-sec">
                                        <label for="">Size <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter size for product "><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                        <input type="text" name="p_size" class="form-control" placeholder="Enter Size" value="{{ isset($product->p_size) ? $product->p_size : '' }}">
                                </div>
                            </div>

                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-sec">
                                        <label for="">Unit <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select Size Unit For Product"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                        <select name="p_unit" class="form-control">
                                            <option selected="" disabled>Select
                                            </option>
                                            @if(isset($genders) && count($genders) > 0)
                                            @foreach($units as $unit)
                                            <option value="{{ $unit->title }}" {{ isset($product->p_unit) && $product->p_unit == $unit->title ? 'selected' : ''}}>{{ isset($unit->title) ? $unit->title : '' }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                </div>
                            </div>

                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-sec">
                                        <label for="">Occasion <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select occasion for product "><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                        <select name="p_occasion" class="form-control">
                                            <option selected="" disabled>Select</option>
                                            @if(isset($occasions) && count($occasions) > 0)
                                            @foreach($occasions as $ocassion)
                                            <option value="{{ $ocassion->id }}" {{ isset($product->p_occasion) && $product->p_occasion == $ocassion->id ? 'selected' : ''}} >{{ isset($ocassion->title) ? $ocassion->title : '' }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                </div>
                            </div>
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-sec">
                                        <label for="">Trend <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select trend for product "><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                        <select name="p_trend" class="form-control">
                                            <option selected="" disabled>Select</option>
                                            @if(isset($trends) && count($trends) > 0)
                                            @foreach($trends as $trend)
                                            <option value="{{ $trend->id }}" {{ isset($product->p_trend) && $product->p_trend == $trend->id ? 'selected' : ''}}>{{ isset($trend->title) ? $trend->title : '' }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                </div>
                            </div>
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-sec">
                                        <label for="">Design <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select design for product "><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                        <select name="p_design" class="form-control">
                                            <option selected="" disabled>Select</option>
                                            @if(isset($designes) && count($designes) > 0)
                                            @foreach($designes as $design)
                                            <option value="{{ $design->id }}" {{ isset($product->p_design) && $product->p_design == $design->id ? 'selected' : ''}} >{{ isset($design->title) ? $design->title : '' }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                </div>
                            </div>
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-sec">
                                        <label for="">Style <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select style for product "><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                        <select name="p_style" class="form-control">
                                            <option selected="" disabled>Select</option>
                                            @if(isset($styles) && count($styles) > 0)
                                            @foreach($styles as $style)
                                            <option value="{{ $style->id }}" {{ isset($product->p_style) && $product->p_style == $style->id ? 'selected' : ''}} >{{ isset($style->title) ? $style->title : '' }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                </div>
                            </div> 
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-sec">
                                        <label for="">Brand <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select Brand"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                        <select name="p_brand" class="form-control">
                                            <option selected="" disabled>Select</option>
                                            @if(isset($brands) && count($brands) > 0)
                                            @foreach($brands as $brand)
                                            <option value="{{ $brand->title }}" {{ isset($product->p_brand) && $product->p_brand == $brand->title ? 'selected' : '' }}>{{ isset($brand->title) ? $brand->title : '' }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                </div>
                            </div>
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-sec">
                                        <label for="">Theme <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select Theme"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                        <select name="p_theme" class="form-control">
                                            <option selected="" disabled>Select</option>
                                            @if(isset($themes) && count($themes) > 0)
                                            @foreach($themes as $theme)
                                            <option value="{{ $theme->title }}" {{ isset($product->p_theme) && $product->p_theme == $theme->title ? 'selected' : '' }}>{{ isset($theme->title) ? $theme->title : '' }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-sec">
                                    <label for="">Measurements (W*L*H) <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter measurements for product "><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                    <input type="text" class="form-control" name="p_measurement" id="" placeholder="Enter Measurements" value="{{ isset($product->p_measurement) ? $product->p_measurement : ''}}">
                                </div>
                            </div>

                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-sec">
                                        <label for="">Measurements Unit <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select measurements unit for product "><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                        <select name="p_measurement_unit" class="form-control">
                                            <option selected="" disabled>Select</option>
                                            @if(isset($munits) && count($munits) > 0)
                                            @foreach($munits as $munit)
                                            <option value="{{ $munit->title }}" {{ isset($product->p_measurement_unit) && $product->p_measurement_unit == $munit->title ? 'selected' : '' }}>{{ isset($munit->title) ? $munit->title : '' }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                </div>
                            </div>

                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-sec">
                                    <label for="">Quantity <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter quantity for product "><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                    <input type="number" class="form-control" name="p_qty" id="" placeholder="Enter Quantity" value="{{ isset($product->p_measurement) ? $product->p_qty : ''}}">
                                </div>
                            </div>

                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-sec">
                                        <label for="">Quantity Unit <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select quantity unit for product "><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                        <select name="p_qty_unit" class="form-control">
                                            <option selected="" disabled>Select</option>
                                            @if(isset($qunits) && count($qunits) > 0)
                                            @foreach($qunits as $qunit)
                                            <option value="{{ $qunit->title }}" {{ isset($product->p_qty_unit) && $product->p_qty_unit == $qunit->title ? 'selected' : '' }}>{{ isset($qunit->title) ? $qunit->title : '' }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                </div>
                            </div>

                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-sec">
                                    <label for="">Gross Weight <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter gross weight for product "><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                    <input type="number" step="0.0001" class="form-control" name="p_gross_weight" id="p_gross_weight" placeholder="Enter Gross Weight" value="{{ isset($product->p_gross_weight) ? $product->p_gross_weight : ''}}">
                                </div>
                            </div>

                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-sec">
                                        <label for="">G Weight Unit <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select G Weight Unit for product"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                        <select name="p_gross_weight_unit" class="form-control">
                                            <option selected="" disabled>Select</option>
                                            @if(isset($gunits) && count($gunits) > 0)
                                            @foreach($gunits as $gunit)
                                            <option value="{{ $gunit->title }}" {{ isset($product->p_gross_weight_unit) && $product->p_gross_weight_unit == $gunit->title ? 'selected' : '' }}>{{ isset($gunit->title) ? $gunit->title : '' }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                </div>
                            </div>

                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-sec">
                                    <label for="">Net Weight <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter Net Weight for product"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                    <input type="number" class="form-control" name="p_net_weight" id="" placeholder="Enter Net Weight" value="{{ isset($product->p_net_weight) ? $product->p_net_weight : ''}}" step="0.0001">
                                </div>
                            </div>

                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-sec">
                                        <label for="">N Weight Unit <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select N Weight Unit for product"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                        <select name="p_n_weight_unit" class="form-control">
                                            <option selected="" disabled>Select</option>
                                            @if(isset($nunits) && count($nunits) > 0)
                                            @foreach($nunits as $nunit)
                                            <option value="{{ $nunit->title }}" {{ isset($product->p_n_weight_unit) && $product->p_n_weight_unit == $nunit->title ? 'selected' : '' }}>{{ isset($nunit->title) ? $nunit->title : '' }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                </div>
                            </div>

                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-sec">
                                        <label for="">Made In <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select Made In for product"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                        <select name="p_made_in" class="form-control">
                                            <option selected="" disabled>Select</option>
                                            @if(isset($countries) && count($countries) > 0)
                                            @foreach($countries as $country)
                                            <option value="{{ $country->id }}" {{ isset($product->p_made_in) && $product->p_made_in == $country->id ? 'selected' : ''}}>{{ isset($country->name) ? $country->name : '' }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                </div>
                            </div>

                           

                            
                        </div>

                        

                    </div>

                    <div class="form-step" id="step3">
                    
                        <div class="page_header">
                            <h5>{{ isset($product) ? 'Edit ' : 'Add '  }}Product (Step 3 of 5)</h5>
                            <!-- <a type="button" class="add-common-btn previous-button step-form-button">Go To Previous Page</a> -->
                        </div>

                        
                            <!-- metal div start -->
                            @php
                            if(isset($product->p_category) && $product->p_category != '9')
                            {
                                $other = 'all';
                            }else{
                                $other = 'loose_gemstone';
                            }
                            @endphp
                            <div id="metal_sec_div" @if(isset($other) && $other == 'all') style="display: block;" @else style="display: none;" @endif>
                                <div class="row">
                                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 sub-heading">
                                    <h3>Metal</h3>
                                </div>

                                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-sec">
                                            <label for="">Metal Purity <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select metal purity"><i class="fa fa-info-circle" aria-hidden="true" style="color: black;"></i></span></label>
                                            <select name="p_metal_purity" class="form-control" id="p_metal_purity" @if(isset($other) && $other == 'all') @endif >
                                                <option selected="" disabled>Select</option>

                                                @if(isset($metal_paurities) && count($metal_paurities) > 0)
                                                @foreach($metal_paurities as $purity)
                                                <option data-purity="{{$purity->rate}}" value="{{ $purity->id }}" {{ isset($product->p_metal_purity) && $product->p_metal_purity == $purity->id ? 'selected' : ''}}>{{ isset($purity->title) ? $purity->title : '' }}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                            <span id=""></span>
                                            <input type="hidden" name="p_metal_rate" id="metal_rate" value="{{ isset($product->p_metal_rate) ? $product->p_metal_rate : '' }}">
                                    </div>
                                </div>
                                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-sec">
                                            <label for="">Metal Color <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select metal color"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                            <select name="p_metal_color" class="form-control">
                                                <option selected="" disabled>Select</option>
                                                @if(isset($metals) && count($metals) > 0)
                                                @foreach($metals as $val)
                                                <option value="{{ $val->id }}" {{ isset($product->p_metal_color) && $product->p_metal_color == $val->id ? 'selected' : ''}}>{{ isset($val->title) ? $val->title : '' }}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                    </div>
                                </div>
                               <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-sec">
                                        <label for="">Enter Metal Weight <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter metal weight"><i class="fa fa-info-circle" aria-hidden="true" style="color: black;"></i></span></label>
                                        <input type="number" step="0.0001" class="form-control" name="p_metal_weigth" id="p_metal_weigth" placeholder="Enter Metal Weight" value="{{ isset($product->p_metal_weigth) ? $product->p_metal_weigth : '' }}">
                                    </div>
                                </div>


                                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-sec">
                                            <label for="">Weight Unit <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select weight unit for metal"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                            <select name="p_metal_weight_unit" class="form-control" id="p_metal_weight_unit">
                                                <option selected="" disabled>Select</option>
                                                @if(isset($mwunits) && count($mwunits) > 0)
                                                @foreach($mwunits as $mwunit)
                                                <option value="{{ $mwunit->title }}" {{ isset($product->p_metal_weight_unit) && $product->p_metal_weight_unit == $mwunit->title ? 'selected' : ''}}>{{ $mwunit->title }}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                    </div>
                                </div>       
                            </div>
                        </div>
                        
                            <!-- metal div end -->
                            <!-- gemstone div start -->
                            <div id="gemstone_div" @if(isset($other) && $other == 'loose_gemstone') style="display: block;" @else style="display: none;" @endif>
                               @include('products.loose_gemstone')
                        </div>
                            <!-- gemstone div end -->


                        <div class="row">

                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 sub-heading">
                                <h3>Certificate Details</h3>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 left-side">
                                <div class="form-sec">
                                        <label for="">Laboratory <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select laboratory"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                        <select name="p_laboraty" class="form-control">
                                            <option selected="" disabled>Select</option>
                                            @if(isset($labs) && count($labs) > 0)
                                            @foreach($labs as $lab)
                                            <option value="{{ $lab->title }}" {{ isset($product->p_laboraty) && $product->p_laboraty == $lab->title ? 'selected' : ''}}>{{ $lab->title }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                </div>
                                <div class="form-sec">
                                    <label for="">Certificate No. <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter certificate number"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                    <input type="text" class="form-control" name="p_certificate_no" id="p_certificate_no" placeholder="Enter Certificate No." value="{{ isset($product->p_certificate_no) ? $product->p_certificate_no : ''}}">
                                </div>
                                <div class="form-sec">
                                    <label for="">Certificate Link <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter certificate link"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                    <input type="text" class="form-control" name="p_certificate_link" id="p_certificate_link" placeholder="Enter Certificate Link" value="{{ isset($product->p_certificate_link) ? $product->p_certificate_link : ''}}">
                                </div>
                            </div>

                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 right-side">

                                <div class="form-sec">
                                    <label for="">Add Certificate (Image/PDF) <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please Upload Certificate"><i class="fa fa-info-circle" aria-hidden="true"></i></span><span style="color: red;margin: 0;"> *Recommended Size: 600x400 pixel upto 500KB.</span></label>
                                    <div class="file-upload-box">
                                    <div class="input_group d-flex">
                                        <label class="certificate-file-box" for="certificate_file" style="cursor: pointer;"><i class="fa fa-plus" aria-hidden="true"></i> <span id="uploadText">Upload</span></label>
                                        <div id="certificatePreviewContainer">
                                            @if(isset($product->p_certificate_file) && $product->p_certificate_file != '' && $product->p_certificate_file != null)
                                            @php
                                                $fileExtension = pathinfo($product->p_certificate_file, PATHINFO_EXTENSION);
                                            @endphp
                                            @if($fileExtension == 'pdf')
                                            <a href="{{asset('uploads/'.$product->p_certificate_file)}}" target="_blank" style="margin-left:10px;">View PDF</a>
                                            <a href="javascript:;" id="remove_certificate">Remove PDF</a>
                                            @else
                                            @if(isset($product->db_status) && $product->db_status != '' && $product->db_status != null && $product->db_status == 'manually')
                                            <img src="{{asset('product_media/product_certificates/'.$product->p_certificate_file)}}" class="img-flud">
                                            @else
                                            <img src="{{asset('uploads/'.$product->p_certificate_file)}}" class="img-flud">
                                            @endif
                                            <a><span class="remove_certificate" id="remove_certificate"><i class="fa fa-times-circle" aria-hidden="true"></i></span></a>
                                            @endif
                                            @endif
                                        </div>
                                        <input type="file" name="p_certificate_file" style="display: none;" id="certificate_file" class="" data-parsley-required-message="">
                                    </div>
                                    <input type="hidden" name="p_certi_old" value="{{ isset($product->p_certificate_file) ? $product->p_certificate_file : '' }}" id="old_certi_file">
                                
                            </div>
                                
                            </div>

                            </div>

                        </div>

                        <hr>

                        <!-- diamond details section start -->
                        <div id="details_sec">
                        @if(isset($product->p_pricetype) && $product->p_pricetype != 'Fixed')
                        @if(isset($product->diamond_details) && $product->diamond_details != '' && $product->diamond_details != null)
                        @php
                            $diamond_data = json_decode($product->diamond_details);
                        @endphp
                        @endif
                        @if(isset($diamond_data))
                        @foreach($diamond_data as $key => $diamond)
                            @include('products.editdiamond')
                        @endforeach
                        @endif
                        @if(isset($product->gemstone_details) && $product->gemstone_details != '' && $product->gemstone_details != null)
                        @php
                            $gemstone_data = json_decode($product->gemstone_details);
                        @endphp
                        @endif
                        @if(isset($gemstone_data) && count($gemstone_data) > 0)
                        @foreach($gemstone_data as $key => $gemstone)
                            @include('products.editgemstone')
                        @endforeach
                        @endif
                        @if(isset($product->pearl_details) && $product->pearl_details != '' && $product->pearl_details != null)
                        @php
                            $pearl_data = json_decode($product->pearl_details);
                        @endphp
                        @endif
                        @if(isset($pearl_data) && count($pearl_data) > 0)
                        @foreach($pearl_data as $key => $pearl)
                            @include('products.editpearls')
                        @endforeach
                        @endif
                        @endif
                        </div>
                        <!-- diamond details section end  -->
                        <div class="row add-more-row-sec mb-3">
                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <hr>
                                <a type="button" class="add-more-btn" data-bs-toggle="modal" data-bs-target="#type_modal"><i class="fa fa-plus" aria-hidden="true"></i> Add Diamond, Gemstone or Pearl</a>
                            </div>
                        </div>
                    </div>

                    <div class="form-step" id="step4">
                    
                        <div class="page_header">
                            <h5>{{ isset($product) ? 'Edit ' : 'Add '  }}Product (Step 4 of 5)</h5>
                            <!-- <a type="button" class="add-common-btn previous-button step-form-button">Go To Previous Page</a> -->
                        </div>
                        

                        <div class="row">

                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 sub-heading">
                                <h3>Price</h3>
                            </div>

                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label for="">Price Type <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select price type"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                <div class="radio-options">
                                    <label class="radio-inline">
                                        <input type="radio" name="p_pricetype" value="no_price" checked {{ isset($product->no_price) && $product->no_price == 'no_price' ? 'checked' : ''}}>No Price</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="p_pricetype" value="fix_price" {{ isset($product->p_pricetype) && $product->p_pricetype == 'fix_price' ? 'checked' : ''}}>Fix Price</label>
                                      <label class="radio-inline">
                                        <input type="radio" name="p_pricetype" value="dynamic" {{ isset($product->p_pricetype) && $product->p_pricetype == 'dynamic' ? 'checked' : ''}}>Dynamic
                                    </label>

                                </div>
                            </div>

                            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 Fixed_price_data" {{ isset($product) && $product->p_pricetype == 'fix_price' ? '' : 'style=display:none'}}>
                                <div class="form-sec">
                                    <label for="">Fix Price <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter fix price"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                    <input type="text" class="form-control" name="p_fix_price" id="p_fix_price" placeholder="Enter Fix Price" value="{{ isset($product->p_fix_price) ? $product->p_fix_price : '' }}" @if(isset($product->p_pricetype) && $product->p_pricetype != 'fix_price') readonly @endif>
                                </div>
                            </div>
                            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 Fixed_price_data" {{ isset($product) && $product->p_pricetype == 'fix_price' ? '' : 'style=display:none'}}>
                                <div class="form-sec">
                                    <label for="">Discount Type <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select discount type"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                    <div class="radio-options">
                                    <label class="radio-inline-m-percent">
                                        <input type="radio" name="fix_dis" value ="percentage" class="fix_dis" {{ isset($product->fix_dis) && $product->fix_dis == 'percentage' ? 'checked' : ''}}>Percentage</label>
                                      <label class="radio-inline-m-price">
                                        <input type="radio" name="fix_dis" value ="price" class="fix_dis" {{ isset($product->fix_dis) && $product->fix_dis == 'price' ? 'checked' : ''}}>Price</label>
                                </div>
                                </div>
                            </div>
                            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 Fixed_price_data" {{ isset($product) && $product->p_pricetype == 'fix_price' ? '' : 'style=display:none'}}>
                                <div class="form-sec">
                                    <label for="">Discount <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter discount"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                    <input type="text" class="form-control" name="p_discount" id="fix_p_discount" placeholder="Enter Discount" value="{{ isset($product->p_discount) ? $product->p_discount : '' }}" @if(isset($product->p_pricetype) && $product->p_pricetype != 'fix_price') readonly @endif>
                                </div>
                            </div>
                            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 Fixed_price_data" {{ isset($product) && $product->p_pricetype == 'fix_price' ? '' : 'style=display:none'}}>
                                <div class="form-sec">
                                    <label for="">Price After Discount <span data-bs-toggle="tooltip" data-bs-placement="right" title="Total Price After Discount"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                    @if(isset($product))
                                    
                                    @php
                                        $discount = 0;
                                        $price_after_dis = 0;
                                        $p_price = isset($product->p_fix_price) ? $product->p_fix_price : 0;
                                     
                                        if($p_price){
                                            $p_disc = isset($product->p_discount) ? $product->p_discount : 0;
                                            if(isset($product->fix_dis)){
                                                if($product->fix_dis == 'percentage')
                                                {
                                                    $discount = ($p_price * $p_disc) / 100;
                                                    $price_after_dis = $p_price - $discount;
                                                }else{
                                                    $price_after_dis = $p_price - $p_disc;
                                                }
                                            }
                                        }else{
                                            $discount = 0;
                                            $price_after_dis = 0;
                                        }
                                        
                                    @endphp
                                    @endif
                                    <input type="text" class="form-control" name="p_after_discount" placeholder="Price" id="p_after_discount" value="{{ isset($price_after_dis) ? $price_after_dis : '' }}" readonly>
                                </div>
                            </div>

                            
                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 sub-heading">
                                <h3>Price Breakdown</h3>
                            </div>

                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label for="">Price Breakdown <span data-bs-toggle="tooltip" data-bs-placement="right" title="Select Yes to show price breakdown on website"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                <div class="radio-options">

                                    <label class="radio-inline">
                                        <input type="radio" name="p_pricebreakdown" value="yes" {{ isset($product->p_pricebreakdown) && $product->p_pricebreakdown == 'yes' ? 'checked' : ''}}>Yes</label>
                                      <label class="radio-inline">
                                        <input type="radio" name="p_pricebreakdown" value="no" {{ isset($product->p_pricebreakdown) && $product->p_pricebreakdown == 'no' ? 'checked' : ''}}>No
                                    </label>

                                </div>
                            </div>
                        </div>

                        <div class="row Dynamic_price_data" {{ isset($product) && $product->p_pricetype == 'dynamic' ? '' : 'style=display:none'}}>

                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-sec">
                                    <label for="">Total Metal Price <span data-bs-toggle="tooltip" data-bs-placement="right" title="Calculated Metal price as per Metal Rate"><i class="fa fa-info-circle" aria-hidden="true"></i></span>  </label>
                                    <input type="text" class="form-control" id="total_metal_price" placeholder="" @if(isset($product->p_pricetype) && $product->p_pricetype !== 'fix_price') value="{{ isset($product->total_metal_price) ? $product->total_metal_price : '' }}" @endif>
                                    <input type="hidden" name="total_metal_price" value="{{ isset($product->total_metal_price) ? $product->total_metal_price : '' }}" id="exis_total_price">
                                    <span id="metal_text_string" style="color: #000;"></span>
                                </div>
                            </div>

                            
                        </div>

                        <div class="row Dynamic_price_data" {{ isset($product) && $product->p_pricetype == 'dynamic' ? '' : 'style=display:none'}}>
                            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <label for="">Making Charge Calculation <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please Select how you want to add making charges"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                <div class="radio-options">

                                    <label class="radio-inline-m-percent">
                                        <input type="radio" name="make_type" value ="price" class="make_type" {{ isset($product->make_type) && $product->make_type == 'price' ? 'checked' : ''}}>Fixed</label>
                                      <label class="radio-inline-m-price">
                                        <input type="radio" name="make_type" value ="percentage" class="make_type" {{ isset($product->make_type) && $product->make_type == 'percentage' ? 'checked' : ''}}>Dynamic</label>

                                </div>
                            </div>
                            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 left-side-charges">
                                <div class="form-sec">
                                    <label for="">Making Charge Percentage <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter Making Charges In Percentage"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                    <input type="text" class="form-control" name="only_making_charges" id="only_making_charges" placeholder="Enter Making Charges Percentage" @if(isset($product->make_type) && $product->make_type == 'price') readonly @else value="{{ isset($product->only_making_charges) ? $product->only_making_charges : '' }}" @endif>

                                </div>
                            </div>
                            
                            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 middle-discount-type">
                            </div>
                            

                            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 left-side-charges">
                                <div class="form-sec">
                                    <label for="">Total Making Charges <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter total making charges"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                    <input type="text" class="form-control" name="total_making_charges" id="total_making_price" placeholder="" value="{{ isset($product->total_making_charges) ? $product->total_making_charges : '' }}">
                                </div>
                            </div>
                            
                            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 middle-discount-type">
                                <label for="">Discount Type <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select discount type"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                <div class="radio-options">

                                    <label class="radio-inline-m-percent">
                                        <input type="radio" name="make_dis" value ="percentage" class="make_dis" {{ isset($product->make_dis) && $product->make_dis == 'percentage' ? 'checked' : ''}}>Percentage</label>
                                      <label class="radio-inline-m-price">
                                        <input type="radio" name="make_dis" value ="price" class="make_dis" {{ isset($product->make_dis) && $product->make_dis == 'price' ? 'checked' : ''}}>Price</label>

                                </div>
                            </div>
                            @php
                            if(isset($product->make_dis) && $product->make_dis == 'percentage' && $product->make_dis != null)
                            {
                                $discountAmount = ($product->dis_making_price / 100) * $product->total_making_charges;
                                $discountedmakingTotal = $product->total_making_charges - $discountAmount;
                                $m_string = '('.$product->total_making_charges.' - '.$product->dis_making_price.'% ='.$discountedmakingTotal.')';
                            }else if(isset($product->make_dis) && $product->make_dis == 'price' && $product->make_dis != null){
                                $discountedmakingTotal = $product->total_making_charges - $product->dis_making_price;
                                $m_string = '('.$product->total_making_charges.' - '.$product->dis_making_price.' ='.$discountedmakingTotal.')';
                            }else{
                                $m_string ='';
                            }
                            @endphp
                            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 right-side-discount">
                                <label for="">Making Charges Discount <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter making charges discount"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                    <input type="text" class="form-control" name="dis_making_price" id="dis_making_price" placeholder="Enter Making Charges Discount" value="{{ isset($product->dis_making_price) ? $product->dis_making_price : '' }}">
                                    <span id="making_dis_string" style="color: #000;">{{$m_string}}</span>
                            </div>

                        </div>
                        <div class="row Dynamic_price_data" {{ isset($product) && $product->p_pricetype == 'dynamic' ? '' : 'style=display:none'}}>
                            @if(isset($product) && $product->p_pricetype == 'dynamic')
                            @php
                                $discounted_diamond_amount = $product->discount_metal($product->id, $product->diamond_rate($product->id));
                            @endphp
                            @endif
                            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 left-side-charges">
                                <div class="form-sec">
                                    <label for="">Total Diamond Charges <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter total diamond charges"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                    <input type="text" class="form-control" name="p_total_diamond_charge" id="total_diamond_charge" placeholder="Enter Total Diamond Charges" value="{{ isset($discounted_diamond_amount) ? $discounted_diamond_amount : '' }}" >
                                </div>
                            </div>

                            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 middle-discount-type">
                                <label for="">Discount Type <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select discount type"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                <div class="radio-options">

                                    <label class="radio-inline-d-percent">
                                        <input type="radio" name="diamond_dis" value ="percentage" class="diamond_dis" {{ isset($product->diamond_dis) && $product->diamond_dis == 'percentage' ? 'checked' : ''}}>Percentage</label>
                                      <label class="radio-inline-d-price">
                                        <input type="radio" name="diamond_dis" value ="price" class="diamond_dis" {{ isset($product->diamond_dis) && $product->diamond_dis == 'price' ? 'checked' : ''}}>Price</label>

                                </div>
                            </div>
                            @php
                            if(isset($product->diamond_dis) && $product->diamond_dis == 'percentage' && $product->diamond_dis != null)
                            {
                                $diamonddiscountAmount = ($product->dis_diamond_price / 100) * $product->p_total_diamond_charge;
                                $diamonddiscountedmakingTotal = $product->p_total_diamond_charge - $diamonddiscountAmount;
                                $d_string = '('.$product->p_total_diamond_charge.' - '.$product->dis_diamond_price.'% ='.$diamonddiscountedmakingTotal.')';
                            }else if(isset($product->diamond_dis) && $product->diamond_dis == 'price'){
                                $diamonddiscountedmakingTotal = $product->p_total_diamond_charge - $product->dis_diamond_price;
                                $d_string = '('.$product->p_total_diamond_charge.' - '.$product->dis_diamond_price.' ='.$diamonddiscountedmakingTotal.')';
                            }else{
                                $d_string = '';
                            }
                            @endphp
                            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 right-side-discount">
                                <label for="">Diamond Charges Discount <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter diamond Discount"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                    <input type="text" class="form-control" name="dis_diamond_price" id="dis_diamond_price" placeholder="Enter Diamond Charges Discount" value="{{ isset($product->dis_diamond_price) ? $product->dis_diamond_price : '' }}">
                                    <span id="diamond_dis_string" style="color: #000;">{{$d_string}}</span>
                            </div>

                        </div>

                        <div class="row Dynamic_price_data" {{ isset($product) && $product->p_pricetype == 'dynamic' ? '' : 'style=display:none'}}>

                            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 left-side-charges">
                                <div class="form-sec">
                                    <label for="">Total Pearl Charges <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter total pearl charges"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                    <input type="text" class="form-control" name="p_total_pearl_charge" id="total_pearl_charge" placeholder="Enter Total Pearl Charges" value="{{ isset($product->p_total_pearl_charge) ? $product->p_total_pearl_charge : '' }}">
                                </div>
                            </div>

                            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 middle-discount-type">
                                <label for="">Discount Type <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select discount type"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                <div class="radio-options">

                                    <label class="radio-inline-p-percent">
                                        <input type="radio" name="pearl_dis" value ="percentage" class="pearl_dis" {{ isset($product->pearl_dis) && $product->pearl_dis == 'percentage' ? 'checked' : ''}}>Percentage</label>
                                      <label class="radio-inline-p-price">
                                        <input type="radio" name="pearl_dis" value ="price" class="pearl_dis" {{ isset($product->pearl_dis) && $product->pearl_dis == 'price' ? 'checked' : ''}}>Price</label>

                                </div>
                            </div>
                            @php
                            if(isset($product->pearl_dis) && $product->pearl_dis == 'percentage' && $product->pearl_dis != null)
                            {
                                $pearldiscountAmount = ($product->p_dis_pearl_price / 100) * $product->p_total_pearl_charge;
                                $pearldiscountedmakingTotal = $product->p_total_pearl_charge - $pearldiscountAmount;
                                $p_string = '('.$product->p_total_pearl_charge.' - '.$product->p_dis_pearl_price.'% ='.$pearldiscountedmakingTotal.')';
                            }else if(isset($product->pearl_dis) && $product->pearl_dis == 'price'){
                                $pearldiscountedmakingTotal = $product->p_total_pearl_charge - $product->p_dis_pearl_price;
                                $p_string = '('.$product->p_total_pearl_charge.' - '.$product->p_dis_pearl_price.' ='.$pearldiscountedmakingTotal.')';
                            }else{
                                $p_string = '';
                            }
                            @endphp
                            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 right-side-discount">
                                <label for="">Pearl Charges Discount <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter Pearl Discount"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                    <input type="text" class="form-control" name="p_dis_pearl_price" id="dis_pearl_price" placeholder="Enter Pearl Charges Discount" value="{{ isset($product->p_dis_pearl_price) ? $product->p_dis_pearl_price : '' }}">
                                    <span id="pearl_dis_string" style="color: #000;">{{$p_string}}</span>
                            </div>

                        </div>

                        <div class="row Dynamic_price_data" {{ isset($product) && $product->p_pricetype == 'dynamic' ? '' : 'style=display:none'}}>

                            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 left-side-charges">
                                <div class="form-sec">
                                    <label for="">Total Gemstone Charges <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter total gemstone charges"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                    <input type="text" class="form-control" name="p_total_gemstone_charge" id="total_gemstone_charge" placeholder="Enter Total Gemstone Charges"  value="{{ isset($product->p_total_gemstone_charge) ? $product->p_total_gemstone_charge : '' }}">
                                </div>
                            </div>

                            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 middle-discount-type">
                                <label for="">Discount Type <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select discount type"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                <div class="radio-options">

                                    <label class="radio-inline-g-percentage">
                                        <input type="radio" name="gemstone_dis" value ="percentage" class="gemstone_dis" {{ isset($product->gemstone_dis) && $product->gemstone_dis == 'percentage' ? 'checked' : ''}}>Percentage</label>
                                      <label class="radio-inline-g-price">
                                        <input type="radio" name="gemstone_dis" value ="price" class="gemstone_dis" {{ isset($product->gemstone_dis) && $product->gemstone_dis == 'price' ? 'checked' : ''}}>Price</label>

                                </div>
                            </div>
                            @php
                            if(isset($product->gemstone_dis) && $product->gemstone_dis == 'percentage' && $product->gemstone_dis != null)
                            {
                                $gemsdiscountAmount = ($product->p_dis_gemstone_price / 100) * $product->p_total_gemstone_charge;
                                $gemdiscountedmakingTotal = $product->p_total_gemstone_charge - $gemsdiscountAmount;
                                $p_string = '('.$product->p_total_gemstone_charge.' - '.$product->p_dis_gemstone_price.'% ='.$gemdiscountedmakingTotal.')';
                            }else if(isset($product->gemstone_dis) && $product->gemstone_dis == 'price'){
                                $gemdiscountedmakingTotal = $product->p_total_gemstone_charge - $product->p_dis_gemstone_price;
                                $p_string = '('.$product->p_total_gemstone_charge.' - '.$product->p_dis_gemstone_price.' ='.$gemdiscountedmakingTotal.')';
                            }else{
                                $p_string = '';
                            }
                            @endphp
                            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 right-side-discount">
                                <label for="">Gemstone Charges Discount <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter Gemstone Discount"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                    <input type="text" class="form-control" name="p_dis_gemstone_price" id="dis_gemstone_price" placeholder="Enter Gemstone Charges Discount" value="{{ isset($product->p_dis_gemstone_price) ? $product->p_dis_gemstone_price : '' }}">
                                    <span id="gemstone_dis_string" style="color: #000;">{{$p_string}}</span>
                            </div>

                        </div>

                        <div class="row Dynamic_price_data" {{ isset($product) && $product->p_pricetype == 'dynamic' ? '' : 'style=display:none'}}>

                            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 left-side-charges">
                                <div class="form-sec">
                                    <label for="">Other Charges <span data-bs-toggle="tooltip" data-bs-placement="right" title="You can add Cost of Rhodium, Plating, Stone Setting , hallmarking etc"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                    <input type="text" class="form-control" name="p_total_other_charge" id="total_other_charge" placeholder="Enter Other Charges" value="{{ isset($product->p_total_other_charge) ? $product->p_total_other_charge : '' }}">
                                </div>
                            </div>

                            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 middle-discount-type">
                                <label for="">Discount Type <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select discount type"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                <div class="radio-options">

                                    <label class="radio-inline-o-percentage">
                                        <input type="radio" name="other_dis" value ="percentage" class="other_dis" {{ isset($product->other_dis) && $product->other_dis == 'percentage' ? 'checked' : ''}}>Percentage</label>
                                      <label class="radio-inline-o-price">
                                        <input type="radio" name="other_dis" value ="price"  class="other_dis" {{ isset($product->other_dis) && $product->other_dis == 'price' ? 'checked' : ''}}>Price</label>

                                </div>
                            </div>
                            @php
                            if(isset($product->other_dis) && $product->other_dis == 'percentage' && $product->other_dis != null)
                            {
                                $otherdiscountAmount = ($product->p_dis_other_price / 100) * $product->p_total_other_charge;
                                $otherdiscountedmakingTotal = $product->p_total_other_charge - $otherdiscountAmount;
                                $o_string = '('.$product->p_total_other_charge.' - '.$product->p_dis_other_price.'% ='.$otherdiscountedmakingTotal.')';
                            }else if(isset($product->other_dis) && $product->other_dis == 'price' && $product->other_dis != null){
                                $otherdiscountedmakingTotal = $product->p_total_other_charge - $product->p_dis_other_price;
                                $o_string = '('.$product->p_total_other_charge.' - '.$product->p_dis_other_price.' ='.$otherdiscountedmakingTotal.')';
                            }else{
                                $o_string = '';
                            }
                            @endphp
                            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 right-side-discount">
                                <label for="">Making Charges Discount <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter other charges discount"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                    <input type="text" class="form-control" name="p_dis_other_price" id="dis_other_price" placeholder="Enter Other Charges Discount" value="{{ isset($product->p_dis_other_price) ? $product->p_dis_other_price : '' }}">
                                    <span id="other_dis_string" style="color: #000;">{{$o_string}}</span>
                            </div>

                        </div>
                        <div class="tax-sec">
                        <div class="row">
                            
                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 sub-heading">
                                <h3>Tax</h3>
                            </div>

                            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <div class="form-sec">
                                    <label for="">National Tax (%) <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter national tax"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                    <input type="text" class="form-control" name="p_national_tax" id="p_national_tax" placeholder="Enter National Tax (%)" value="{{ isset($product->p_national_tax) ? $product->p_national_tax : ''}}">
                                </div>
                            </div>

                            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <div class="form-sec">
                                    <label for="">Minimum Amount <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter minimum amount"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                    <input type="text" class="form-control" name="p_above_amount" id="p_above_amount" placeholder="Enter Minimum Amount" value="{{ isset($product->p_above_amount) ? $product->p_above_amount : '0'}}">
                                </div>
                            </div>

                            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 price-calculate-sec">
                                <div class="form-sec">
                                    @if(isset($product))
                                    @php
                                    $with_out_tax = 0;
                                    $gs = App\Models\Setting::first();
                                    if(isset($product->p_national_tax) && $product->p_national_tax != null)
                                    {
                                        $with_out_tax = $product->p_national_tax;
                                    }else{
                                        $with_out_tax = isset($gs->national_tax) ? $gs->national_tax : 0;
                                    }
                                    $without_tax = $product->total_price($product->id) - str_replace(',', '', $product->tax_rate($product->id));
                                    @endphp
                                    @endif
                                    <label for="">Tax Charges <span data-bs-toggle="tooltip" data-bs-placement="right" title="Tax charges"><i class="fa fa-info-circle" aria-hidden="true"></i></span>  </label>
                                    <input type="text" class="form-control" name="p_total_tax_charge" id="total_tax_charge" placeholder="" readonly value="{{ isset($product) ? $product->tax_rate($product->id) : 0 }}" >
                                    <span id="tax_span_text" style="color: #000;"> ({{ isset($with_out_tax) ? $with_out_tax : ''}}% of on {{ isset($without_tax) ? $without_tax : 0 }} ) </span>
                                </div>
                            </div>

                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-sec" style="margin-bottom: 0 !important;">
                                    <label for="">International Tax (%) <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter international tax details"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                    

                                    <div class="table-responsive international-tax-table">
                                        <table class="table table-bordered table-fixed">
                                            <thead>
                                                <tr>
                                                  <th>Country</th>
                                                  <th>Tax (%)</th>
                                                  <th>Above Amount</th>
                                                </tr>
                                              </thead>
                                              <tbody>
                                                @if(isset($product->p_inter_taxes) && $product->p_inter_taxes != '' && $product->p_inter_taxes != null)
                                                @php
                                                    $contry_json = json_decode($product->p_inter_taxes);
                                                    $p_tax_contry_values = is_array($contry_json) ? array_column($contry_json, 'p_tax_contry') : [];
                                                    $p_tax_contry_tax_values = is_array($contry_json) ? array_column($contry_json, 'p_int_tax') : [];
                                                    $p_tax_contry_above_values = is_array($contry_json) ? array_column($contry_json, 'p_int_above') : [];
                                                @endphp
                                                @endif
                                                @if(isset($countries) && count($countries) > 0)
                                                <tr>
                                                  <td> <label class="checkbox-inline">
                                                    <input type="checkbox" value="all" name="p_tax_contry[]" class="contry_check" @if(isset($p_tax_contry_values) && in_array("all",$p_tax_contry_values)) checked @endif >All
                                                  </label></td>
                                                  <td><input type="text" class="form-control int_tax" id="" placeholder="" @if(isset($p_tax_contry_values) && in_array("all",$p_tax_contry_values)) value="{{ $p_tax_contry_tax_values[array_search('all', $p_tax_contry_values)] }}" name="p_int_tax[]" @endif></td>
                                                  <td><input type="text" class="form-control int_above"  id="" placeholder="" @if(isset($p_tax_contry_values) && in_array("all",$p_tax_contry_values)) value="{{ $p_tax_contry_above_values[array_search('all', $p_tax_contry_values)] }}" name="p_int_above[]" @endif></td>
                                                </tr>  
                                                @foreach($countries as $country)
                                                <tr>
                                                  <td> <label class="checkbox-inline">
                                                    <input type="checkbox" value="{{ isset($country->id) ? $country->id : ''}}" name="p_tax_contry[]" class="contry_check" @if(isset($p_tax_contry_values) && in_array($country->id,$p_tax_contry_values)) checked @endif >{{ isset($country->name) ? $country->name : '' }}
                                                  </label></td>
                                                  <td><input type="text" class="form-control int_tax" id="" placeholder="" @if(isset($p_tax_contry_values) && in_array($country->id,$p_tax_contry_values)) value="{{ $p_tax_contry_tax_values[array_search($country->id, $p_tax_contry_values)] }}" name="p_int_tax[]" @endif></td>
                                                  <td><input type="text" class="form-control int_above"  id="" placeholder="" @if(isset($p_tax_contry_values) && in_array($country->id,$p_tax_contry_values)) value="{{ $p_tax_contry_above_values[array_search($country->id, $p_tax_contry_values)] }}" name="p_int_above[]" @endif></td>
                                                </tr>  
                                                @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>

                                </div>

                            </div>
                            </div>

                        </div>
                        
                        <div class="price-calculate-sec" {{ isset($product->p_pricetype) && ($product->p_pricetype == 'fix_price' || $product->p_pricetype == 'dynamic') ? 'style=display:block' : 'style=display:none'}}>
                            <a class="calculate-btn">Calculate</a>
                        </div>
                        <div class="row " id="cal_button_div" {{ isset($product->p_pricetype) && ($product->p_pricetype == 'fix_price' || $product->p_pricetype == 'dynamic') ? '' : 'style=display:none'}}>
                            <!-- <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 price-calculate-sec">
                                <div class="form-sec">
                                    <label for="">Tax Charges <span data-bs-toggle="tooltip" data-bs-placement="right" title="Dummy information text"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                    <input type="text" class="form-control" name="p_total_tax_charge" id="total_tax_charge" placeholder="" readonly value="{{ isset($product->p_total_tax_charge) ? $product->p_total_tax_charge : '' }}" >
                                </div>
                            </div> -->
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 ">
                                <div class="form-sec">
                                    <label for="">Final Price Calculate <span data-bs-toggle="tooltip" data-bs-placement="right" title="Final price"><i class="fa fa-info-circle" aria-hidden="true"></i></span>
                                     </label>
                                    <input type="text" class="form-control" name="p_grand_price_total" id="grand_price_total" placeholder="Final Price" readonly value="{{ isset($product) ? $product->total_price($product->id) : '' }}" data-parsley-required-message="Please click on Calculate button">
                                    <input type="hidden" value="{{ isset($product->p_final_metal_price) ? $product->p_final_metal_price : '' }}" name="p_final_metal_price" id="p_final_metal_price">
                                    <input type="hidden" value="{{ isset($product->p_final_makin_price) ? $product->p_final_makin_price : '' }}" name="p_final_makin_price" id="p_final_makin_price">
                                    <input type="hidden" value="{{ isset($product->p_final_diamond_price) ? $product->p_final_diamond_price : '' }}" name="p_final_diamond_price" id="p_final_diamond_price">
                                    <input type="hidden" value="{{ isset($product->p_final_pearl_price) ? $product->p_final_pearl_price : '' }}" name="p_final_pearl_price" id="p_final_pearl_price">
                                    <input type="hidden" value="{{ isset($product->p_final_gemstone_price) ? $product->p_final_gemstone_price : '' }}" name="p_final_gemstone_price" id="p_final_gemstone_price">
                                    <input type="hidden" value="{{ isset($product->p_final_other_price) ? $product->p_final_other_price : '' }}" name="p_final_other_price" id="p_final_other_price">
                                    <input type="hidden" value="{{ isset($product->p_final_fix_price) ? $product->p_final_fix_price : '' }}" name="p_final_fix_price" id="p_final_fix_price">
                                    <input type="hidden" id="global_national_tax" value="{{ isset($setting->national_tax) ? $setting->national_tax : '' }}">
                                </div>
                            </div>
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 ">
                                <div class="form-sec">
                                    <label for=""> 
                                     </label>
                                     <span id="total_price_display">
                                        @if(isset($product))
                                        @if(isset($product) && $product->p_pricetype == 'dynamic')
                                        @php
                                        $global = '';
                                        $p_metal_rate = str_replace(',', '', $product->metal_rate($product->id));
                                        if(isset($product->p_total_tax_charge) && $product->p_total_tax_charge != '0.0000' && $product->p_total_tax_charge != null)
                                        {
                                            $tax_charges = $product->p_total_tax_charge;
                                        }else{
                                            $gs = App\Models\Setting::first();
                                            $total_wi_tax = $p_metal_rate + $product->p_final_makin_price + $product->p_final_diamond_price + $product->p_final_pearl_price + $product->p_final_gemstone_price + $product->p_final_other_price;
                                            if($total_wi_tax > $gs->nation_above_amount)
                                            {
                                                $tax_charges = $total_wi_tax * $gs->national_tax / 100;
                                            }
                                            $global = 'Global';
                                        }

                                        @endphp
                                            @if($product->metal_rate($product->id) > 0)
                                                Metal Price ({{$product->metal_rate($product->id)}})
                                            @endif

                                            @if($product->making_rate($product->id) > 0)
                                                + Making charges ({{$product->making_rate($product->id)}})
                                            @endif

                                            @if($product->diamond_rate($product->id) > 0)
                                                + Diamond Charges ({{$product->diamond_rate($product->id)}})
                                            @endif

                                            @if($product->pearl_rate($product->id) > 0)
                                                + Pearl Charges ({{$product->pearl_rate($product->id)}})
                                            @endif

                                            @if($product->gemstone_rate($product->id) > 0)
                                                + Gemstone Charges ({{$product->gemstone_rate($product->id)}})
                                            @endif

                                            @if($product->other_rate($product->id) > 0)
                                                + Other Charges ({{$product->other_rate($product->id)}})
                                            @endif

                                            @if($product->tax_rate($product->id) > 0)
                                                + {{$global}} Tax Charges ({{$product->tax_rate($product->id)}})
                                            @endif
                                        @endif
                                        @if(isset($product) && $product->p_pricetype == 'fix_price')
                                        @php
                                        if($product->fix_dis == 'percentage')
                                            {
                                                $dicounted_price = ($product->p_discount / 100) * $product->p_fix_price;
                                            }else{
                                                $dicounted_price = $product->p_discount - $product->p_fix_price;
                                            }
                                        @endphp
                                            Fix Price ({{$product->p_fix_price}}) - Discount({{isset($dicounted_price) ? $dicounted_price : 0}}) + Tax Charges({{isset($product->p_total_tax_charge) ? $product->p_total_tax_charge : 0 }})
                                        @endif
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="form-step" id="step5">
                    
                        <div class="page_header">
                            <h5>{{ isset($product) ? 'Edit ' : 'Add '  }}Product (Step 5 of 5)</h5>
                            <!-- <a type="button" class="add-common-btn previous-button step-form-button">Go To Previous Page</a> -->
                        </div>

                        <div class="row">
                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 sub-heading">
                                <h3>Payment Method</h3>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-4 col-sm-12 col-xs-12">
                                <label for="">Payment Gateway <span data-bs-toggle="tooltip" data-bs-placement="right" title="Select yes to enable Payment Gateway payment"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                <div class="radio-options">

                                    <label class="radio-inline">
                                        <input type="radio" name="p_payment_g" value="yes" {{ isset($product->p_payment_g) && $product->p_payment_g == 'yes' ? 'checked' : ''}}>Yes</label>
                                      <label class="radio-inline">
                                        <input type="radio" name="p_payment_g" value="no" {{ isset($product->p_payment_g) && $product->p_payment_g == 'no' ? 'checked' : ''}}>No
                                    </label>

                                </div>
                            </div>
                            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-4 col-sm-12 col-xs-12">
                                <label for="">COD <span data-bs-toggle="tooltip" data-bs-placement="right" title="Select yes to enable COD"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                <div class="radio-options">

                                    <label class="radio-inline">
                                        <input type="radio" name="p_cod" value="yes" {{ isset($product->p_cod) && $product->p_cod == 'yes' ? 'checked' : ''}}>Yes</label>
                                      <label class="radio-inline">
                                        <input type="radio" name="p_cod" value="no" {{ isset($product->p_cod) && $product->p_cod == 'no' ? 'checked' : ''}}>No
                                    </label>

                                </div>
                            </div>

                            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-4 col-sm-12 col-xs-12">
                                <label for="">CCOD <span data-bs-toggle="tooltip" data-bs-placement="right" title="Select yes to enable CCOD"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                <div class="radio-options">

                                    <label class="radio-inline">
                                        <input type="radio" name="p_ccod" value="yes" {{ isset($product->p_ccod) && $product->p_ccod == 'yes' ? 'checked' : ''}}>Yes</label>
                                      <label class="radio-inline">
                                        <input type="radio" name="p_ccod" value="no" {{ isset($product->p_ccod) && $product->p_ccod == 'no' ? 'checked' : ''}}>No
                                    </label>

                                </div>
                            </div>
                            <!-- <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-4 col-sm-12 col-xs-12">
                                <label for="">Credit Card <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select for credit card - Yes/No"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                <div class="radio-options">

                                    <label class="radio-inline">
                                        <input type="radio" name="p_creditcard" value="yes" {{ isset($product->p_creditcard) && $product->p_creditcard == 'yes' ? 'checked' : ''}}>Yes</label>
                                      <label class="radio-inline">
                                        <input type="radio" name="p_creditcard" value="no" {{ isset($product->p_creditcard) && $product->p_creditcard == 'no' ? 'checked' : ''}}>No
                                    </label>

                                </div>
                            </div> -->

                            <!-- <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-4 col-sm-12 col-xs-12">
                                <label for="">Bank Transfer <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select for bank transfer - Yes/No"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                <div class="radio-options">

                                    <label class="radio-inline">
                                        <input type="radio" name="p_banktransfer" value="yes" {{ isset($product->p_banktransfer) && $product->p_banktransfer == 'yes' ? 'checked' : ''}}>Yes</label>
                                      <label class="radio-inline">
                                        <input type="radio" name="p_banktransfer" value="no" {{ isset($product->p_banktransfer) && $product->p_banktransfer == 'no' ? 'checked' : ''}}>No
                                    </label>

                                </div>
                            </div> -->

                           <!--  <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-4 col-sm-12 col-xs-12">
                                <label for="">UPI <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select for UPI - Yes/No"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                <div class="radio-options">

                                    <label class="radio-inline">
                                        <input type="radio" name="p_upi" value="yes" {{ isset($product->p_upi) && $product->p_upi == 'yes' ? 'checked' : ''}}>Yes</label>
                                      <label class="radio-inline">
                                        <input type="radio" name="p_upi" value="no" {{ isset($product->p_upi) && $product->p_upi == 'no' ? 'checked' : ''}}>No
                                    </label>

                                </div>
                            </div> -->
                            
                        </div>

                        <div class="row">

                            
                            
                        </div>
                        <hr>

                        <div class="row">

                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 sub-heading">
                                <h3>Delivery</h3>
                                <!-- <div class="delivery-post-code-checkbox">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" value="">Exclude Delivery Post Code <span data-bs-toggle="tooltip" data-bs-placement="right" title="Dummy information text"><i class="fa fa-info-circle" aria-hidden="true"></i></span>
                                      </label>
                                </div> -->

                            </div>
                        </div>
                        <div id="delivery_all_div">
                            @if(isset($product->delivery_details) && $product->delivery_details != null && $product->delivery_details != '')
                            @php
                                $d_json = json_decode($product->delivery_details);
                            @endphp
                            <input type="hidden" name="del_counter" id="del_counter" value="{{ isset($d_json) ? count($d_json) : ''}}">
                            @if(isset($d_json) && $d_json != '' && $d_json != null)
                            @foreach($d_json as $key => $delivery)
                                @include('products.delivery_sec')
                            @endforeach
                            @endif
                            @else
                            <input type="hidden" name="del_counter" id="del_counter" value="1">
                        <div class="delivery-field-sec">
                            <div class="row delivery-field-sec-row">
                                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-sec">
                                            <label for="">Country <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select Country"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                            <select name="p_deliver_contry[1][]" class="form-control delivery_country select2">
                                                <option selected="" disabled>Select Country
                                                </option>
                                                @if(isset($countries) && count($countries) > 0)
                                                @foreach($countries as $country)
                                                <option value="{{ $country->id }}" {{ isset($product->p_made_in) && $product->p_made_in == $country->id ? 'selected' : ''}}>{{ isset($country->name) ? $country->name : '' }}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                    </div>
                                </div>
    
                                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-sec state_sec">
                                            <label for="">State (Multiple) <span data-bs-toggle="tooltip" data-bs-placement="right" title="You can select multiple States"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                            <select name="p_deliver_state[1][]" class="form-control delivery_state select2" multiple>
                                                
                                            </select>
                                    </div>
                                </div>
    
                                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-sec zip_sec">
                                            <label for="">Post Code / Zip Code (Multiple) <span data-bs-toggle="tooltip" data-bs-placement="right" title="You can select multiple Zipcodes"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                            <select name="p_deliver_code[1][]" class="form-control select2 delivery_zip" multiple>
                                                
                                            </select>
                                    </div>
                                </div>
    
                                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-sec">
                                            <label for="">Duration / Days <span data-bs-toggle="tooltip" data-bs-placement="right" title="Mention Total no of days for Shipping estimation"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                            <input type="text" class="form-control" name="p_deliver_duration[1][]" id="" placeholder="Enter Duration" value="">
                                    </div>
                                </div>
    
    
                            </div>
                        </div>
                        @endif
                    </div>
                        <div class="row add-more-row-sec">
                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <hr>
                                <a type="button" class="add-more-btn delivery-field-add-more-btn"><i class="fa fa-plus" aria-hidden="true"></i> Add More</a>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 sub-heading">
                                <h3>Buy With Confidence</h3>
                            </div>
                        </div>
                        @if(isset($product->buy_with_confidence_sec) && $product->buy_with_confidence_sec != '' && $product->buy_with_confidence_sec != null)
                                    @php
                                        $buy_json = json_decode($product->buy_with_confidence_sec);
                                    @endphp
                                    @endif
                                    @if(isset($buy_json) && count($buy_json) > 0)
                                    <input type="hidden" value="{{count($buy_json)}}" id="buy_count">
                                    @foreach($buy_json as $key => $json)
                                    <div class="each-icon-details mt-3">
                                    <div class="row">
                                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="form-sec">
                                                    <label for="">Name <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please insert name" ><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                                    <input type="text" name="buy_title[]"  placeholder="Enter Name" id="buy_icon_name" class="form-control" value="{{ isset($json->title) ? $json->title : '' }}">
                                            </div> 
                                        </div>
                                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                            <div class="form-sec">
                                                    <label for="">Icon <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please upload the icon" ><i class="fa fa-info-circle" aria-hidden="true"></i></span><span style="color: red;margin: 0;"> *1:1 square PNG only, max 512 px.</span></label>
                                                    <div class="d-flex align-items-center">
                                                    <div class="input_group me-3">
                                                        <label class="img_upload" for="buy_icon_{{$key}}"><i class="fa fa-plus mx-1"></i> Upload</label>
                                                        <input type="file" name="buy_icon[]" style="display: none;" id="buy_icon_{{$key}}" class="buy_icon" >
                                                    </div>
                                                <div class="preview_image">
                                                    @if(isset($json->icon) && $json->icon != '' && $json->icon != null)
                                                    <img src="{{asset('product_media/product_icons/'.$json->icon)}}" class="img-fluid preview_image icon_img" >
                                                    @else
                                                    <img src="{{asset('assets/images/user/img-demo_1041.jpg')}}" class="img-fluid preview_image icon_img" >
                                                    @endif
                                                </div>
                                            </div>
                                                <input type="hidden" name="old_buy_icon[]" value="{{ isset($json->icon) ? $json->icon : '' }}"> 
                                            </div>
                                        </div>
                                        <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12" style="text-align: end;margin-top: 18px;">
                                        @if(isset($key) && $key == 0)
                                        <a class="back-btn" href="javascript:;" id="add_icon">+ Add Icon</a>
                                        @else
                                        <a class="remove remove_icon" href=javascript:;><i class="fa-times-circle fas"></i></a>
                                        @endif
                                        </div>
                                    </div>
                                    </div>
                                    @endforeach
                                    @else
                                    <div class="each-icon-details mt-3">
                                    <div class="row">
                                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="form-sec">
                                                    <label for="">Name <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please insert name" ><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                                    <input type="text" name="buy_title[]" id="buy_icon_name" class="form-control">
                                            </div> 
                                        </div>
                                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                            <div class="form-sec">
                                                    <label for="">Icon <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please upload the icon" ><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                                    <div class="d-flex align-items-center">
                                                    <div class="input_group me-3">
                                                        <label class="img_upload" for="buy_icon_0"><i class="fa fa-plus mx-1"></i> Upload</label>
                                                        <input type="file" name="buy_icon[]" style="display: none;" id="buy_icon_0" class="buy_icon" >
                                                    </div>
                                                <div class="preview_image">
                                                    <img src="{{asset('assets/images/user/img-demo_1041.jpg')}}" class="img-fluid preview_image icon_img" >
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                        <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12" style="text-align: end;margin-top: 18px;">
                                        <a class="back-btn" href="javascript:;" id="add_icon">+ Add Icon</a>
                                        </div>
                                    </div>
                                    </div>
                                    @endif
                                    <div id="append_icons">

                                    </div>
                        <!-- <div class="row">

                            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-4 col-sm-12 col-xs-12">
                                <label for="">Hallmarked <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select for hallmarked - Yes/No"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                <div class="radio-options">

                                    <label class="radio-inline">
                                        <input type="radio" name="p_hallmarked" value="yes" {{ isset($product->p_hallmarked) && $product->p_hallmarked == 'yes' ? 'checked' : ''}}>Yes</label>
                                      <label class="radio-inline">
                                        <input type="radio" name="p_hallmarked" value="no" {{ isset($product->p_hallmarked) && $product->p_hallmarked == 'no' ? 'checked' : ''}}>No
                                    </label>

                                </div>
                            </div>

                            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-4 col-sm-12 col-xs-12">
                                <label for="">Certified <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select for certified - Yes/No"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                <div class="radio-options">

                                    <label class="radio-inline">
                                        <input type="radio" name="p_certified" value="yes" {{ isset($product->p_certified) && $product->p_certified == 'yes' ? 'checked' : ''}}>Yes</label>
                                      <label class="radio-inline">
                                        <input type="radio" name="p_certified" value="no" {{ isset($product->p_certified) && $product->p_certified == 'no' ? 'checked' : ''}}>No
                                    </label>

                                </div>
                            </div>
                            
                        </div> -->

                        <div class="row">
                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 sub-heading">
                                <h3>SEO</h3>
                            </div>

                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-sec">
                                    <label for="">Meta Title <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter title for SEO"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                    <input type="text" class="form-control" name="meta_title" id="" placeholder="Enter Meta Title" value="{{ isset($product->meta_title) ? $product->meta_title : ''}}">
                                </div>
                            </div>

                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-sec">
                                    <label for="">Meta Description <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter description for SEO"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                    <textarea class="form-control" name="meta_description" id="" placeholder="Enter Meta Description">{{ isset($product->meta_description) ? $product->meta_description : ''}}</textarea>
                                </div>
                            </div>
                     <!--        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-sec">
                                    <label for="">URL <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter slug for SEO"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                    <input type="text" class="form-control" name="p_slug" id="p_slug" style="padding-left: 240px !important;"  value="{{ isset($product->p_slug) ? $product->p_slug : ''}}">

                                    <label for="p_slug" class="static-value">https://jewelxy.workdemo.in.net/</label>
                                </div>
                            </div> -->
                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label for="">URL <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter slug for SEO"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                <div class="form-sec input-group mb-3">
                                    
                                    <span class="input-group-text" id="basic-addon3">{{ url('/') }}/</span>
                                    <input type="text" class="form-control" name="p_slug" id="p_slug" aria-describedby="basic-addon3" value="{{ isset($product->p_slug) ? $product->p_slug : ''}}">

                                </div>
                            </div>

                        </div>

                        

                    </div>
                     <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 step-form-button-sec" style="padding-left: 0;">
                                <a type="button" class="previous-button step-form-button">Previous</a>
                                <a type="button" class="step-form-button next-step">Next</a>
                                <button type="submit" class="step-form-button" name="publish" value="yes">Publish and Save</button>
                                <button type="submit" class="step-form-button" name="draft" value="yes">Draft</button>
                            </div>

                       <!--        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 step-form-button-sec" style="padding-left: 0;">
                                <a type="button" class="previous-button step-form-button">Previous</a>
                                <button type="submit" class="step-form-button next-step" name="next_draft" value="yes">Next</button>
                                <button type="submit" class="step-form-button next-step" name="publish" value="yes">Publish and Save</button>
                                <button type="submit" class="step-form-button next-step" name="draft" value="yes">Draft</button>
                            </div> -->
                </form>
                <!-- [ Main Content ] end -->
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
<div class="modal" tabindex="-1" id="video_modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Preview Video</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <video controls style="width: 100%;" id="videoPlayer" @if(isset($product->p_video) && $product->p_video != '' && $product->p_video != null) src="{{asset('product_media/product_videos/'.$product->p_video)}}" @endif>
        Your browser does not support the video tag.
    </video>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<div class="modal" tabindex="-1" id="type_modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Select Option</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="radio-options">
            <div class="row">
                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <label class="radio-inline">
                        <input type="radio" name="type" value="diamond_fix" checked="">Diamond (Fix Price)
                    </label>
                </div>
                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <label class="radio-inline">
                        <input type="radio" name="type" value="diamond_dynamic">Diamond (Dynamic)
                    </label>
                </div>
                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <label class="radio-inline">
                        <input type="radio" name="type" value="gemstone">Gemstone
                    </label>
                </div>
                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <label class="radio-inline">
                        <input type="radio" name="type" value="pearl">Pearl
                    </label>
                </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="select_type">Add</button>
      </div>
    </div>
  </div>
</div>
@endsection
@section('script')
<script src="https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
<script src="{{asset('assets/js/product.js')}}"></script>
<script src="{{asset('assets/js/variant.js')}}"></script>
<script>
   
    @if(isset($product->p_category) && $product->p_category)
    var cat = '{{$product->p_category}}';
        $("#all_families").html('');
        $.ajax({
            url: admin_url +"all-data",
            type: "POST",
            data: {
                cat: cat,
                 _token: $('meta[name="csrf-token"]').attr('content'),
            },
            dataType: 'json',
            success: function(result) {
                var family = '{{$product->p_family}}';
                $('#all_families').html('<option value="">Select Family</option>');
                $.each(result.families, function(key, value) {
                    if (family == value.id) {
                        var isselected = 'selected';
                      }
                    $("#all_families").append('<option value="' + value.id + '" '+ isselected +'>' + value.family + '</option>');
                });
                }
            }); 
    @endif
    @if(isset($d_json) && $d_json != null)
    @foreach($d_json as $key => $delivery)
    var country = '{{$delivery->p_deliver_contry}}';
          $("#del_state_{{$key+1}}").html('');
          $.ajax({
            url: "{{route('business.get_state')}}",
            type: "POST",
            data: {
              country: country,
              _token: '{{csrf_token()}}'
            },
            dataType: 'json',
            success: function(result) {
              $('#del_state_{{$key+1}}').html('<option value="">Select State</option>');
              var state_ids = '{{$delivery->p_deliver_state}}'.split(',');
              $.each(result.state, function(key, value) {
                var selected = state_ids.includes(value.id.toString()) ? 'selected' : '';
                $("#del_state_{{$key+1}}").append('<option value="' + value.id + '" ' + selected + '>' + value.name + '</option>');
              });
            }
    });
    @endforeach
    @endif
    @if(isset($d_json) && $d_json != null)
    @foreach($d_json as $key => $delivery)
    var state = '{{$delivery->p_deliver_state}}'.split(',');
          $("#del_code_{{$key+1}}").html('');
          $.ajax({
            url: admin_url +"get-deliver-zip",
            type: "POST",
            data: {
              state: state,
              _token: '{{csrf_token()}}'
            },
            dataType: 'json',
            success: function(result) {
              $('#del_code_{{$key+1}}').html('<option value="">Select Code</option>');
              var code_ids = '{{$delivery->p_deliver_code}}'.split(',');
              $.each(result.zip, function(key, value) {
                var selected = code_ids.includes(value.id.toString()) ? 'selected' : '';
                $("#del_code_{{$key+1}}").append('<option value="' + value.id + '" ' + selected + '>' + value.code + '</option>');
              });
            }
    });
    @endforeach
    @endif

     @if(isset($product))
       var val = $("#p_metal_purity").val();
       if(val && val != null)
       {
        $.ajax({
            url: admin_url +"get-metal-rate",
            type: "POST",
            data: {
              val: val,
              _token: $('meta[name="csrf-token"]').attr('content'),
            },
            dataType: 'json',
            success: function(result) {
                $('#metal_rate').val(result.rate);
                var weight = parseFloat($("#p_metal_weigth").val());
                var rate = parseFloat($('#metal_rate').val());
                var weight_unit = $('#p_metal_weight_unit').val();
                if (weight_unit === 'grams') {
                    result = weight * rate;
                } else if (weight_unit === 'Kilogram') {
                    result = weight * 1000 * rate;
                }else{
                    var result = weight * rate;
                }
                
                $("#exis_total_price").val(result.toFixed(2));
                $("#total_metal_price").val(result.toFixed(2));
                
                var metal_string = '('+rate + ' * ' + weight + ' ' + weight_unit + ' = ' + result.toFixed(2) + ')';
                $('#metal_text_string').text(metal_string);
            }
        });
       }
    @endif


</script>
<script>
  
 
</script>
<script>
var existing_counter = $('#buy_count').val()
if(existing_counter && existing_counter != '')
{
    var counter = parseInt(existing_counter) + 1;
}else{
    var counter = 1;
}
$('#add_icon').click(function() {
    var html = '<div class="each-icon-details mt-3"><div class=row><div class="col-sm-12 col-xs-12 col-lg-6 col-md-6 col-xl-6 col-xxl-6"><div class=form-sec><label for="">Name <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please insert name" ><i class="fa fa-info-circle" aria-hidden="true"></i></span></label> <input id=buy_icon_name name=buy_title[] class=form-control></div></div><div class="col-sm-12 col-xs-12 col-lg-4 col-md-4 col-xl-4 col-xxl-4"><div class=form-sec><label for="">Icon <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please upload the icon" > <i class="fa fa-info-circle" aria-hidden="true"></i></span><span style="color: red;margin: 0;"> *1:1 square PNG only, max 512 px.</span></label><div class="align-items-center d-flex"><div class="input_group me-3"><label for=buy_icon_'+ counter +' class=img_upload><i class="fa fa-plus mx-1"></i> Upload</label> <input id=buy_icon_'+ counter +' name=buy_icon[] class="buy_icon" style=display:none type=file></div><div class=preview_image> <img class="preview_image icon_img img-fluid"  src="{{asset('assets/images/user/img-demo_1041.jpg')}}"></div></div></div></div><div class="col-sm-12 col-xs-12 col-lg-2 col-md-2 col-xl-2 col-xxl-2"style=text-align:end;margin-top:18px><a class="remove remove_icon" href=javascript:;><i class="fa-times-circle fas"></i></a></div></div></div>';
    $('#append_icons').append(html);
    counter++;
});
$(document).on("click",".remove_icon",function() {
    $(this).closest('.each-icon-details').remove();
});
$(document).on("change", ".buy_icon", function (e) {
    var input = e.target;
    var file = input.files[0]; // Assuming only one file is selected

    // Check if the file is an image
    if (/^image\//.test(file.type)) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $(input).closest('.each-icon-details').find('.icon_img').attr('src', e.target.result);
        };

        reader.readAsDataURL(file);
    } else {
        toastr.error('Please select a valid image file.');
        $(input).val(''); // Clear the input field
        // You may want to set a default image here as well
        $(input).next().attr('src', '{{ asset('assets/images/user/img-demo_1041.jpg') }}');
    }
});
</script>
@endsection
