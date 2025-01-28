@extends('layouts.backend.index')
@section('main_content')
<link rel="stylesheet" href="https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.css">
<div class="pcoded-wrapper">
    <div class="pcoded-content">
        <div class="pcoded-inner-content">
            <!-- [ breadcrumb ] start -->
            <div class="custom_breadcum">
            	<ul>
            		<li class="breadcum-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
            		<li class="breadcum-item"><a href="{{route('product.index')}}"> Products </a></li>
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
                     <div class="form-step" id="step1">
                    
                        <div class="page_header">
                            <h5>{{ isset($product) ? 'Edit ' : 'Add '  }}Product (Step 1 of 5)</h5>
                            <a href="{{route('product.index')}}" class="add-common-btn">Back to Products</a>
                        </div>

                                <div class="row">

                                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-sec">
                                                <label for="">Product Category <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select product category"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
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
                                        <label for="">Add Product Image - Upload Multiple Preview Images (Max upload to 4 images) <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please upload a product image"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
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
                                                    <input type="hidden" id="existing_image_{{ $index }}" value="{{ asset('uploads/'.$p_imgs_e->name) }}">
                                                    <input type="hidden" id="existing_id_{{ $index }}" value="{{ $p_imgs_e->id }}">
                                                @endforeach
                                                @endif
                                                <div id="image-preview-container" class="d-flex" >
                                                @if(isset($product_imgs) && count($product_imgs) > 0)
                                                @foreach($product_imgs as $p_imgs)
                                                <div class="p_img_parent" style="position: relative;" data-id="{{ $p_imgs->id }}">
                                                     <img src="{{asset('uploads/'.$p_imgs->name)}}" class="img-fluid preview_image" id="large-item-img-output" style="margin-right:10px;">
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
                                                <label for="">Product Family <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select product family"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
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
                                                <label for="">Product Tags (Comma separated value) <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select product tags"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
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
                                    <label for="">Product Title <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter product title"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                    <input type="text" class="form-control" name="p_title" id="p_title" placeholder="Enter Product Title" required data-parsley-error-message="Please Enter Product Title" value="{{ isset($product->p_title) ? $product->p_title : '' }}">
                                </div>
                            </div>

                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-sec">
                                    <label for="">Product SKU <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter product SKU"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
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
                                            <option value="Men" {{ isset($product->p_gender) && $product->p_gender == 'Men' ? 'selected' : ''}}>Men</option>
                                            <option value="Women" {{ isset($product->p_gender) && $product->p_gender == 'Women' ? 'selected' : ''}}>Women</option>
                                            <option value="Kids" {{ isset($product->p_gender) && $product->p_gender == 'Kids' ? 'selected' : ''}}>Kids</option>
                                            <option value="Unisex" {{ isset($product->p_gender) && $product->p_gender == 'Unisex' ? 'selected' : ''}}>Unisex</option>
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
                                        <label for="">Unit <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select unit for product "><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                        <select name="p_unit" class="form-control">
                                            <option selected="" disabled>Select
                                            </option>
                                            <option value="no" {{ isset($product->p_unit) && $product->p_unit == 'no' ? 'selected' : ''}}>no.</option>
                                            <option value="mm" {{ isset($product->p_unit) && $product->p_unit == 'mm' ? 'selected' : ''}}>mm</option>
                                            <option value="cm" {{ isset($product->p_unit) && $product->p_unit == 'cm' ? 'selected' : ''}}>cm</option>
                                            <option value="inch" {{ isset($product->p_unit) && $product->p_unit == 'inch' ? 'selected' : ''}}>inch</option>
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
                                        <label for="">Brand <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select design for product "><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                        <select name="p_brand" class="form-control">
                                            <option selected="" disabled>Select</option>
                                            <option value="Tiffany" {{ isset($product->p_brand) && $product->p_brand == 'Tiffany' ? 'selected' : '' }}>Tiffany</option>
                                        </select>
                                </div>
                            </div>
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-sec">
                                        <label for="">Theme <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select design for product "><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                        <select name="p_theme" class="form-control">
                                            <option selected="" disabled>Select</option>
                                            <option value="Animal" {{ isset($product->p_theme) && $product->p_theme == 'Animal' ? 'selected' : '' }}>Animal</option>
                                            <option value="Flower" {{ isset($product->p_theme) && $product->p_theme == 'Flower' ? 'selected' : '' }}>Flower</option>
                                            <option value="Letters" {{ isset($product->p_theme) && $product->p_theme == 'Letters' ? 'selected' : '' }}>Letters</option>
                                            <option value="Sports" {{ isset($product->p_theme) && $product->p_theme == 'Sports' ? 'selected' : '' }}>Sports</option>
                                        </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-sec">
                                    <label for="">Measurements (W*L*H) <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter measurements for product "><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                    <input type="number" class="form-control" name="p_measurement" id="" placeholder="Enter Measurements" value="{{ isset($product->p_measurement) ? $product->p_measurement : ''}}">
                                </div>
                            </div>

                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-sec">
                                        <label for="">Measurements Unit <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select measurements unit for product "><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                        <select name="p_measurement_unit" class="form-control">
                                            <option selected="" disabled>Select</option>
                                            <option value="mm" {{ isset($product->p_measurement_unit) && $product->p_measurement_unit == 'mm' ? 'selected' : ''}}>mm</option>
                                            <option value="cm" {{ isset($product->p_measurement_unit) && $product->p_measurement_unit == 'cm' ? 'selected' : ''}}>cm</option>
                                            <option value="inch" {{ isset($product->p_measurement_unit) && $product->p_measurement_unit == 'inch' ? 'selected' : ''}}>inch</option>
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
                                            <option value="Pieces" {{ isset($product->p_qty_unit) && $product->p_qty_unit == 'Pieces' ? 'selected' : ''}}>Pieces</option>
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
                                            <option value="Kilogram" {{ isset($product->p_gross_weight_unit) && $product->p_gross_weight_unit == 'Kilogram' ? 'selected' : ''}}>Kilogram</option>
                                            <option value="Grams" {{ isset($product->p_gross_weight_unit) && $product->p_gross_weight_unit == 'Grams' ? 'selected' : ''}}>Grams</option>
                                            <option value="Carat" {{ isset($product->p_gross_weight_unit) && $product->p_gross_weight_unit == 'Carat' ? 'selected' : ''}}>Carat</option>
                                            <option value="Milligram" {{ isset($product->p_gross_weight_unit) && $product->p_gross_weight_unit == 'Milligram' ? 'selected' : ''}}>Milligram</option>
                                            <option value="Pieces" {{ isset($product->p_gross_weight_unit) && $product->p_gross_weight_unit == 'Pieces' ? 'selected' : ''}}>Pieces</option>
                                            <option value="Ounce" {{ isset($product->p_gross_weight_unit) && $product->p_gross_weight_unit == 'Ounce' ? 'selected' : ''}}>Ounce</option>
                                        </select>
                                </div>
                            </div>

                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-sec">
                                    <label for="">Net Weight <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter Net Weight for product"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                    <input type="number" class="form-control" name="p_net_weight" id="" placeholder="Enter Net Weight" value="{{ isset($product->p_net_weight) ? $product->p_net_weight : ''}}">
                                </div>
                            </div>

                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-sec">
                                        <label for="">N Weight Unit <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select N Weight Unit for product"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                        <select name="p_n_weight_unit" class="form-control">
                                            <option selected="" disabled>Select
                                            </option>
                                            <option value="Kilogram" {{ isset($product->p_n_weight_unit) && $product->p_n_weight_unit == 'Kilogram' ? 'selected' : ''}}>Kilogram</option>
                                            <option value="Grams" {{ isset($product->p_n_weight_unit) && $product->p_n_weight_unit == 'Grams' ? 'selected' : ''}}>Grams</option>
                                            <option value="Carat" {{ isset($product->p_n_weight_unit) && $product->p_n_weight_unit == 'Carat' ? 'selected' : ''}}>Carat</option>
                                            <option value="Milligram" {{ isset($product->p_n_weight_unit) && $product->p_n_weight_unit == 'Milligram' ? 'selected' : ''}}>Milligram</option>
                                            <option value="Pieces" {{ isset($product->p_n_weight_unit) && $product->p_n_weight_unit == 'Pieces' ? 'selected' : ''}}>Pieces</option>
                                            <option value="Ounce" {{ isset($product->p_n_weight_unit) && $product->p_n_weight_unit == 'Ounce' ? 'selected' : ''}}>Ounce</option>
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
                                            <label for="">Metal Purity <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select metal purity"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                            <select name="p_metal_purity" class="form-control" id="p_metal_purity" @if(isset($other) && $other == 'all') required @endif  data-parsley-error-message="Please Select Metal Purity" data-parsley-errors-container="#p_puri_error">
                                                <option selected="" disabled>Select</option>

                                                @if(isset($metal_paurities) && count($metal_paurities) > 0)
                                                @foreach($metal_paurities as $purity)
                                                <option data-purity="{{$purity->rate}}" value="{{ $purity->id }}" {{ isset($product->p_metal_purity) && $product->p_metal_purity == $purity->id ? 'selected' : ''}}>{{ isset($purity->title) ? $purity->title : '' }}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                            <span id="p_puri_error"></span>
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
                                        <label for="">Enter Metal Weight <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter metal weight"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                        <input type="number" class="form-control" name="p_metal_weigth" id="p_metal_weigth" placeholder="Enter Metal Weight" @if(isset($other) && $other == 'all') required @endif data-parsley-error-message="Please Enter Metal Weight" value="{{ isset($product->p_metal_weigth) ? $product->p_metal_weigth : '' }}">
                                    </div>
                                </div>

                                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-sec">
                                            <label for="">Weight Unit <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select weight unit for metal"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                            <select name="p_metal_weight_unit" class="form-control" id="p_metal_weight_unit">
                                                <option selected="" disabled>Select</option>
                                                <option value="Kilogram" {{ isset($product->p_metal_weight_unit) && $product->p_metal_weight_unit == 'Kilogram' ? 'selected' : ''}}>Kilogram</option>
                                                <option value="grams" {{ isset($product->p_metal_weight_unit) && $product->p_metal_weight_unit == 'grams' ? 'selected' : ''}}>Grams</option>
                                                <option value="Carat" {{ isset($product->p_metal_weight_unit) && $product->p_metal_weight_unit == 'Carat' ? 'selected' : ''}}>Carat</option>
                                                <option value="Milligram" {{ isset($product->p_metal_weight_unit) && $product->p_metal_weight_unit == 'Milligram' ? 'selected' : ''}}>Milligram</option>
                                                <option value="Pieces" {{ isset($product->p_metal_weight_unit) && $product->p_metal_weight_unit == 'Pieces' ? 'selected' : ''}}>Pieces</option>
                                                <option value="Ounce" {{ isset($product->p_metal_weight_unit) && $product->p_metal_weight_unit == 'Ounce' ? 'selected' : ''}}>Ounce</option>
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
                                            <option value="GIA" {{ isset($product->p_laboraty) && $product->p_laboraty == 'GIA' ? 'selected' : ''}}>GIA</option>
                                            <option value="HRD" {{ isset($product->p_laboraty) && $product->p_laboraty == 'HRD' ? 'selected' : ''}}>HRD</option>
                                            <option value="IGI" {{ isset($product->p_laboraty) && $product->p_laboraty == 'IGI' ? 'selected' : ''}}>IGI</option>
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
                                    <label for="">Add Certificate (Image/PDF) <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please upload image of certificate"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
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
                                            <img src="{{asset('uploads/'.$product->p_certificate_file)}}" class="img-flud">
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
                        @if(isset($diamond_data) && count($diamond_data) > 0)
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
                                    <label for="">Price After Discount <span data-bs-toggle="tooltip" data-bs-placement="right" title="The price after discount"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                    <input type="text" class="form-control" name="p_after_discount" placeholder="Price" id="p_after_discount" readonly>
                                </div>
                            </div>

                            
                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 sub-heading">
                                <h3>Price Breakdown</h3>
                            </div>

                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label for="">Price Breakdown <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select price breakdown - Yes/No"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
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
                                    <label for="">Total Metal Price <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter total metal price"><i class="fa fa-info-circle" aria-hidden="true"></i></span>  </label>
                                    <input type="text" class="form-control" id="total_metal_price" placeholder="" @if(isset($product->p_pricetype) && $product->p_pricetype !== 'fix_price') value="{{ isset($product->total_metal_price) ? $product->total_metal_price : '' }}" @endif>
                                    <input type="hidden" name="total_metal_price" value="{{ isset($product->total_metal_price) ? $product->total_metal_price : '' }}" id="exis_total_price">
                                    <span id="metal_text_string" style="color: #000;"></span>
                                </div>
                            </div>

                            
                        </div>

                        <div class="row Dynamic_price_data" {{ isset($product) && $product->p_pricetype == 'dynamic' ? '' : 'style=display:none'}}>
                            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <label for="">Making Charges Price Type <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select price type"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                <div class="radio-options">

                                    <label class="radio-inline-m-percent">
                                        <input type="radio" name="make_type" value ="price" class="make_type" {{ isset($product->make_type) && $product->make_type == 'price' ? 'checked' : ''}}>Fixed</label>
                                      <label class="radio-inline-m-price">
                                        <input type="radio" name="make_type" value ="percentage" class="make_type" {{ isset($product->make_type) && $product->make_type == 'percentage' ? 'checked' : ''}}>Dynamic</label>

                                </div>
                            </div>
                            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 left-side-charges">
                                <div class="form-sec">
                                    <label for="">Making Charges Percentage <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter making charges percentage"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
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

                            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 left-side-charges">
                                <div class="form-sec">
                                    <label for="">Total Diamond Charges <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter total diamond charges"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                    <input type="text" class="form-control" name="p_total_diamond_charge" id="total_diamond_charge" placeholder="Enter Total Diamond Charges" value="{{ isset($product->p_total_diamond_charge) ? $product->p_total_diamond_charge : '' }}" >
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
                                <label for="">Making Diamond Charges Discount <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter making diamond charges discount"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                    <input type="text" class="form-control" name="dis_diamond_price" id="dis_diamond_price" placeholder="Enter Making Diamond Charges Discount" value="{{ isset($product->dis_diamond_price) ? $product->dis_diamond_price : '' }}">
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
                                <label for="">Making Pearl Charges Discount <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter making pearl charges discount"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                    <input type="text" class="form-control" name="p_dis_pearl_price" id="dis_pearl_price" placeholder="Enter Making Pearl Charges Discount" value="{{ isset($product->p_dis_pearl_price) ? $product->p_dis_pearl_price : '' }}">
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
                                <label for="">Making Gemstone Charges Discount <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter making gemstone charges discount"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                    <input type="text" class="form-control" name="p_dis_gemstone_price" id="dis_gemstone_price" placeholder="Enter Making Gemstone Charges Discount" value="{{ isset($product->p_dis_gemstone_price) ? $product->p_dis_gemstone_price : '' }}">
                                    <span id="gemstone_dis_string" style="color: #000;">{{$p_string}}</span>
                            </div>

                        </div>

                        <div class="row Dynamic_price_data" {{ isset($product) && $product->p_pricetype == 'dynamic' ? '' : 'style=display:none'}}>

                            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 left-side-charges">
                                <div class="form-sec">
                                    <label for="">Other Charges <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter other charges"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
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
                                <label for="">Making Other Charges Discount <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter making other charges discount"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                    <input type="text" class="form-control" name="p_dis_other_price" id="dis_other_price" placeholder="Enter Making Other Charges Discount" value="{{ isset($product->p_dis_other_price) ? $product->p_dis_other_price : '' }}">
                                    <span id="other_dis_string" style="color: #000;">{{$o_string}}</span>
                            </div>

                        </div>
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
                                        $total_amount = $product->p_grand_price_total - $product->p_total_tax_charge;
                                    @endphp
                                    @endif
                                    <label for="">Tax Charges <span data-bs-toggle="tooltip" data-bs-placement="right" title="Tax charges"><i class="fa fa-info-circle" aria-hidden="true"></i></span>  </label>
                                    <input type="text" class="form-control" name="p_total_tax_charge" id="total_tax_charge" placeholder="" readonly value="{{ isset($product->p_total_tax_charge) ? $product->p_total_tax_charge : 0 }}" >
                                    <span id="tax_span_text" style="color: #000;"> ( {{ isset($product->p_national_tax) ? $product->p_national_tax : 0 }}% of on {{isset($total_amount) ? $total_amount : 0 }}) </span>
                                </div>
                            </div>

                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-sec">
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
                        
                        <div class="price-calculate-sec">
                            <a class="calculate-btn">Calculate</a>
                        </div>
                        <div class="row ">
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
                                    <input type="text" class="form-control" name="p_grand_price_total" id="grand_price_total" placeholder="Final Price" readonly value="{{ isset($product->p_grand_price_total) ? $product->p_grand_price_total : '' }}" required data-parsley-required-message="Please click on Calculate button">
                                    <input type="hidden" value="{{ isset($product->p_final_metal_price) ? $product->p_final_metal_price : '' }}" name="p_final_metal_price" id="p_final_metal_price">
                                    <input type="hidden" value="{{ isset($product->p_final_makin_price) ? $product->p_final_makin_price : '' }}" name="p_final_makin_price" id="p_final_makin_price">
                                    <input type="hidden" value="{{ isset($product->p_final_diamond_price) ? $product->p_final_diamond_price : '' }}" name="p_final_diamond_price" id="p_final_diamond_price">
                                    <input type="hidden" value="{{ isset($product->p_final_pearl_price) ? $product->p_final_pearl_price : '' }}" name="p_final_pearl_price" id="p_final_pearl_price">
                                    <input type="hidden" value="{{ isset($product->p_final_gemstone_price) ? $product->p_final_gemstone_price : '' }}" name="p_final_gemstone_price" id="p_final_gemstone_price">
                                    <input type="hidden" value="{{ isset($product->p_final_other_price) ? $product->p_final_other_price : '' }}" name="p_final_other_price" id="p_final_other_price">
                                    <input type="hidden" value="{{ isset($product->p_final_fix_price) ? $product->p_final_fix_price : '' }}" name="p_final_fix_price" id="p_final_fix_price">
                                </div>
                            </div>
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 ">
                                <div class="form-sec">
                                    <label for=""> 
                                     </label>
                                     <span id="total_price_display">
                                        <!-- @if(isset($product))
                                        @if(isset($product) && $product->p_pricetype == 'dynamic')
                                             Total Metal Price({{$product->total_metal_price}}) + Total Making charges({{$product->total_making_charges}}) - Discount Making charges({{ isset($product->dis_making_met) ? $product->dis_making_price : 0 }}) + Total Diamond Charges({{isset($product->p_total_diamond_charge) ? $product->p_total_diamond_charge : 0 }}) - Discount Diamond Charge({{isset($product->dis_diamond_price) ? $product->dis_diamond_price : 0 }}) + Total Pearl Charges({{isset($product->p_total_pearl_charge) ? $product->p_total_pearl_charge : 0 }}) - Discount Pearl Charge({{isset($product->p_dis_price_pearl) ? $product->p_dis_price_pearl : 0 }}) + Total Gemstone Charges({{isset($product->p_total_gemstone_charge) ? $product->p_total_gemstone_charge : 0 }}) - Discount Pearl Charge({{isset($product->p_dis_gemstone_price) ? $product->p_dis_gemstone_price : 0 }}) + Other Charges({{isset($product->p_total_other_charge) ? $product->p_total_other_charge : 0 }}) - Discount Other Charge({{isset($product->p_dis_other_price) ? $product->p_dis_other_price : 0 }}) + Tax Charges({{isset($product->p_total_tax_charge) ? $product->p_total_tax_charge : 0 }})
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
                                        @endif -->
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
                                <label for="">Credit Card <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select for credit card - Yes/No"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                <div class="radio-options">

                                    <label class="radio-inline">
                                        <input type="radio" name="p_creditcard" value="yes" {{ isset($product->p_creditcard) && $product->p_creditcard == 'yes' ? 'checked' : ''}}>Yes</label>
                                      <label class="radio-inline">
                                        <input type="radio" name="p_creditcard" value="no" {{ isset($product->p_creditcard) && $product->p_creditcard == 'no' ? 'checked' : ''}}>No
                                    </label>

                                </div>
                            </div>

                            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-4 col-sm-12 col-xs-12">
                                <label for="">Bank Transfer <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select for bank transfer - Yes/No"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                <div class="radio-options">

                                    <label class="radio-inline">
                                        <input type="radio" name="p_banktransfer" value="yes" {{ isset($product->p_banktransfer) && $product->p_banktransfer == 'yes' ? 'checked' : ''}}>Yes</label>
                                      <label class="radio-inline">
                                        <input type="radio" name="p_banktransfer" value="no" {{ isset($product->p_banktransfer) && $product->p_banktransfer == 'no' ? 'checked' : ''}}>No
                                    </label>

                                </div>
                            </div>

                            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-4 col-sm-12 col-xs-12">
                                <label for="">UPI <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select for UPI - Yes/No"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                <div class="radio-options">

                                    <label class="radio-inline">
                                        <input type="radio" name="p_upi" value="yes" {{ isset($product->p_upi) && $product->p_upi == 'yes' ? 'checked' : ''}}>Yes</label>
                                      <label class="radio-inline">
                                        <input type="radio" name="p_upi" value="no" {{ isset($product->p_upi) && $product->p_upi == 'no' ? 'checked' : ''}}>No
                                    </label>

                                </div>
                            </div>
                            
                        </div>

                        <div class="row">

                            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-4 col-sm-12 col-xs-12">
                                <label for="">COD <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select for COD - Yes/No"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                <div class="radio-options">

                                    <label class="radio-inline">
                                        <input type="radio" name="p_cod" value="yes" {{ isset($product->p_cod) && $product->p_cod == 'yes' ? 'checked' : ''}}>Yes</label>
                                      <label class="radio-inline">
                                        <input type="radio" name="p_cod" value="no" {{ isset($product->p_cod) && $product->p_cod == 'no' ? 'checked' : ''}}>No
                                    </label>

                                </div>
                            </div>

                            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-4 col-sm-12 col-xs-12">
                                <label for="">CCOD <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select for CCOD - Yes/No"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                <div class="radio-options">

                                    <label class="radio-inline">
                                        <input type="radio" name="p_ccod" value="yes" {{ isset($product->p_ccod) && $product->p_ccod == 'yes' ? 'checked' : ''}}>Yes</label>
                                      <label class="radio-inline">
                                        <input type="radio" name="p_ccod" value="no" {{ isset($product->p_ccod) && $product->p_ccod == 'no' ? 'checked' : ''}}>No
                                    </label>

                                </div>
                            </div>
                            
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
                                            <label for="">Country <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select any country"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
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
                                            <label for="">State (Multiple) <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select any state"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                            <select name="p_deliver_state[1][]" class="form-control delivery_state select2" multiple>
                                                
                                            </select>
                                    </div>
                                </div>
    
                                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-sec zip_sec">
                                            <label for="">Post Code / Zip Code (Multiple) <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select zip"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                            <select name="p_deliver_code[1][]" class="form-control select2 delivery_zip" multiple>
                                                
                                            </select>
                                    </div>
                                </div>
    
                                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-sec">
                                            <label for="">Duration / Days <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter duration/day"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
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

                        <div class="row">

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
                            
                        </div>

                        <div class="row">
                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 sub-heading">
                                <h3>SEO</h3>
                            </div>

                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-sec">
                                    <label for="">Title <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter title for SEO"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                    <input type="text" class="form-control" name="meta_title" id="" placeholder="Enter Title" value="{{ isset($product->meta_title) ? $product->meta_title : ''}}">
                                </div>
                            </div>

                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-sec">
                                    <label for="">Description <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter description for SEO"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                    <textarea class="form-control" name="meta_description" id="" placeholder="Enter Description">{{ isset($product->meta_description) ? $product->meta_description : ''}}</textarea>
                                </div>
                            </div>
                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-sec">
                                    <label for="">Slug <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter slug for SEO"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                    <input type="text" class="form-control" name="p_slug" id="p_slug" placeholder="Enter Slug" value="{{ isset($product->p_slug) ? $product->p_slug : ''}}">
                                </div>
                            </div>

                        </div>

                        

                    </div>
                     <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 step-form-button-sec" style="padding-left: 0;">
                                <a type="button" class="previous-button step-form-button">Previous</a>
                                <a type="button" class="step-form-button next-step">Next</a>
                                <button type="submit" class="step-form-button next-step">Submit</button>
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
<div class="modal" tabindex="-1" id="video_modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Preview Video</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <video controls style="width: 100%;" id="videoPlayer" @if(isset($product->p_video) && $product->p_video != '' && $product->p_video != null) src="{{asset('uploads/'.$product->p_video)}}" @endif>
        Your browser does not support the video tag.
    </video>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
@endsection
@section('script')
<script src="https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
<script src="{{asset('assets/js/product.js')}}"></script>
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
    @endif
</script>
@endsection
