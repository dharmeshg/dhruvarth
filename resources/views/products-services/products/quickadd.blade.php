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
                    <li class="breadcum-item active"><a href="javascript:;"> {{ isset($product) ? 'Quick Edit ' : 'Quick Add '  }}Product</a></li>
                </ul>
            </div>
            <!-- [ breadcrumb ] end -->
            <div class="main-body">
                <div class="page-wrapper add-product-step-form-sec">
                    <!-- [ Main Content ] start -->
                    <form action="{{ route('product.save') }}" method="POST" enctype="multipart/form-data" data-parsley-validate="" id="product_add_form">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ isset($product->id) ? $product->id : ''}}">
                        <div class="" id="">

                            <div class="page_header">
                                <h5>{{ isset($product) ? 'Quick Edit Product' : 'Quick Add Product '  }}</h5>
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
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-sec">
                                    <label for="">Product Title <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter product title"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                    <input type="text" class="form-control" name="p_title" id="p_title" placeholder="Enter Product Title" required data-parsley-error-message="Please Enter Product Title" value="{{ isset($product->p_title) ? $product->p_title : '' }}">
                                </div>
                            </div>   
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-sec">
                                    <label for="">Minimum Order Quantity <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter minimum order quantity"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                    <input type="number" class="form-control" name="p_min_order_qty" id="" placeholder="Enter Minimum Order Quantity" value="{{ isset($product->p_min_order_qty) ? $product->p_min_order_qty : '' }}">
                                </div>
                            </div> 
                        </div>

                        <div class="row">
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-sec">
                                    <label for="">Unit <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select Unit for product"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
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
                                    <label for="">Product SKU <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter product SKU"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                    <input type="text" class="form-control" name="p_sku" id="p_sku" placeholder="Enter Product SKU" required data-parsley-error-message="Please Enter Product SKU" value="{{ isset($product->p_sku) ? $product->p_sku : '' }}">
                                    <span id="sku_error" style="color: red;"></span>
                                    <a href="" id="exist_sku" target="_blank"></a>
                                </div>
                            </div> 
                        </div>
                        
                        <div class="row">
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 Fixed_price_data" >
                                <div class="form-sec">
                                    <input type="hidden" class="form-control" name="p_pricetype" id="p_pricetype" placeholder="Enter Price" value="fix_price" >
                                    <label for="">Price <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter price of product"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                    <input type="text" class="form-control" name="p_fix_price" id="p_fix_price" placeholder="Enter Price" value="{{ isset($product->p_fix_price) ? $product->p_fix_price : '' }}" @if(isset($product->p_pricetype) && $product->p_pricetype != 'fix_price') readonly @endif>
                                </div>
                            </div>
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-sec">
                                    <label for="">Size <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter size for product "><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                    <input type="text" name="p_size" class="form-control" placeholder="Enter Size" value="{{ isset($product->p_size) ? $product->p_size : '' }}">
                                </div>
                            </div>    
                        </div>

                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 step-form-button-sec" style="padding-left: 0;">

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
        <video controls id="videoPlayer" @if(isset($product->p_video) && $product->p_video != '' && $product->p_video != null) src="{{asset('uploads/'.$product->p_video)}}" @endif>
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
    
</script>
@endsection
