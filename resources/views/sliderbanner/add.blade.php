    @extends('layouts.backend.index')

@section('main_content')

<div class="pcoded-wrapper">
    <div class="pcoded-content">
        <div class="pcoded-inner-content">
            <div class="custom_breadcum">
                <ul>
                    <li class="breadcum-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                    <li class="breadcum-item"><a href="{{route('media.index')}}"> Media </a></li>
                    <li class="breadcum-item"><a href="{{route('sliderbanner.index')}}"> Slider Banner </a></li>
                    <li class="breadcum-item active"><a href="javascript:;"> {{isset($banner) ? 'Edit' : 'Add'}} Slider Banner </a></li>
                </ul>
            </div>
            <div class="main-body">
                <div class="page-wrapper">
                    <div class="d-flex align-items-center justify-content-between">
                        <h3 class="add_heading">@if(isset($banner)) Edit @else Add @endif Slider Banner</h3>
                        <a href="{{ route('sliderbanner.index') }}" class="back-btn">Back to Slider Banner</a>
                    </div>
                    <form id="slide_banner_add" action="{{ route('sliderbanner.save') }}" method="POST" enctype='multipart/form-data' data-parsley-validate>
                        @csrf
                        <input type="hidden" name="banner_id" value="{{ isset($banner->id) ? $banner->id : '' }}">
                        <div class="input_group mt-3">
                            <div class="mb-3">
                                <label>Large (1920x600) <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please upload a large image for slider banner"><i class="fa fa-info-circle" aria-hidden="true"></i></span><span style="color: red;margin: 0;"></label>
                                <p><span style="color: red;margin: 0;">*Recommended Image Size 1920 x 600</span></p>
                                <div class="row">
                                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12 d-flex align-items-center">
                                        <div class="me-3">
                                            <label class="img_upload" for="large_file"><i class="fa fa-plus mx-1"></i> Upload</label>
                                            <input type="file"  style="display: none;" name="large_image" id="large_file" class="large-item-img" @if(isset($banner->large_img) && $banner->large_img != null && $banner->large_img != '')  @else required @endif data-parsley-required-message="Large Image is Required" data-parsley-errors-container="#large_cont">
                                        </div>
                                        <div class="image-sec">
                                            @if(isset($banner->large_img) && $banner->large_img != '' && $banner->large_img != null)
                                            <img src="{{asset('uploads/slider_banner/'.$banner->large_img)}}" class="img-fluid preview_image" id="large-item-img-output">
                                             <a class="large_show_close_icon" ><span class="remove_icons" style="left: 230px !important;font-size: 20px !important;"><i class="fa fa-times-circle" aria-hidden="true"></i></span></a>
                                            @else
                                            <img src="{{asset('assets/images/user/img-demo_1041.jpg')}}" class="img-fluid preview_image" id="large-item-img-output">
                                             <a class="large_show_close_icon" style="display: none;"><span class="remove_icons" style="left: 230px !important;font-size: 20px !important;"><i class="fa fa-times-circle" aria-hidden="true"></i></span></a>
                                            @endif
                                            <input type="hidden" name="large_old_img" value="{{ isset($banner->large_img) ? $banner->large_img : ''}}" id="large_old_img">
                                        </div>
                                        
                                    </div>
                                </div>
                                <span id="error-message" style="display: none; color: red;" class="parsley-errors-list"></span>
                                <span id="large_cont"></span>
                            </div>
                            <div class="mb-3">
                                <label>Medium (992x525) <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please upload a medium image for slider banner"><i class="fa fa-info-circle" aria-hidden="true"></i></span><span style="color: red;margin: 0;"></label>
                                <p><span style="color: red;margin: 0;">*Recommended Image Size 992 x 525</span></p>
                                <div class="row">
                                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12 d-flex align-items-center">
                                        <div class="me-3">
                                            <label class="img_upload" for="medium_image_file"><i class="fa fa-plus mx-1"></i> Upload</label>
                                            <input type="file"  style="display: none;" name="medium_image" id="medium_image_file" class="medium-item-img" @if(isset($banner->medium_img) && $banner->medium_img != null && $banner->medium_img != '')  @else required @endif data-parsley-required-message="Medium Image is Required" data-parsley-errors-container="#medium_cont">
                                        </div>
                                        <div class="image-sec">
                                            @if(isset($banner->medium_img) && $banner->medium_img != '' && $banner->medium_img != null)
                                            <img src="{{asset('uploads/slider_banner/'.$banner->medium_img)}}" class="img-fluid preview_image" id="medium-item-img-output">
                                             <a class="medium_show_close_icon" ><span class="remove_icons" style="left: 230px !important;font-size: 20px !important;"><i class="fa fa-times-circle" aria-hidden="true"></i></span></a>
                                            @else
                                            <img src="{{asset('assets/images/user/img-demo_1041.jpg')}}" class="img-fluid preview_image" id="medium-item-img-output">
                                             <a class="medium_show_close_icon" style="display: none;"><span class="remove_icons" style="left: 230px !important;font-size: 20px !important;"><i class="fa fa-times-circle" aria-hidden="true"></i></span></a>
                                            @endif
                                            <input type="hidden" name="medium_old_img" value="{{ isset($banner->medium_img) ? $banner->medium_img : ''}}" id="old_img">
                                        </div>
                                        
                                    </div>
                                </div>
                                <span id="error-message-med-image" style="display: none; color: red;" class="parsley-errors-list"></span>
                                <span id="medium_cont"></span>
                            </div>
                            <div class="mb-3">
                                <label>Small (768x450) <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please upload a small image for slider banner"><i class="fa fa-info-circle" aria-hidden="true"></i></span><span style="color: red;margin: 0;"></label>
                                <p><span style="color: red;margin: 0;">*Recommended Image Size 768 x 450</span></p>
                                <div class="row">
                                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12 d-flex align-items-center">
                                        <div class="me-3">
                                            <label class="img_upload" for="small_image_file"><i class="fa fa-plus mx-1"></i> Upload</label>
                                            <input type="file"  style="display: none;" name="small_image" id="small_image_file" class="small-item-img" @if(isset($banner->small_img) && $banner->small_img != null && $banner->small_img != '')  @else required @endif data-parsley-required-message="Small Image is Required" data-parsley-errors-container="#small_cont">
                                        </div>
                                        <div class="image-sec">
                                            @if(isset($banner->small_img) && $banner->small_img != '' && $banner->small_img != null)
                                            <img src="{{asset('uploads/slider_banner/'.$banner->small_img)}}" class="img-fluid preview_image" id="small-item-img-output">
                                             <a class="small_show_close_icon" ><span class="remove_icons" style="left: 230px !important;font-size: 20px !important;"><i class="fa fa-times-circle" aria-hidden="true"></i></span></a>
                                            @else
                                            <img src="{{asset('assets/images/user/img-demo_1041.jpg')}}" class="img-fluid preview_image" id="small-item-img-output">
                                             <a class="small_show_close_icon" style="display: none;"><span class="remove_icons" style="left: 230px !important;font-size: 20px !important;"><i class="fa fa-times-circle" aria-hidden="true"></i></span></a>
                                            @endif
                                            <input type="hidden" name="small_old_img" value="{{ isset($banner->small_img) ? $banner->small_img : ''}}" id="small_old_img">
                                        </div>
                                        
                                    </div>
                                </div>
                                <span id="error-message-small-image" style="display: none; color: red;" class="parsley-errors-list"></span>
                                <span id="small_cont"></span>
                            </div>
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                        <label>Destination Link <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please insert a destination link for slider banner"><i class="fa fa-info-circle" aria-hidden="true"></i></span><span style="color: red;margin: 0;"></label>
                                        <input type="url" name="destination_link" placeholder="Enter Destination Link" class="form-control"  value="{{ isset($banner->destination_link) ? $banner->destination_link : '' }}">
                                    </div>
                                </div>
                            </div>  
                            <div class="mb-3">
                                <button type="submit" class="common-submit-btn">Submit</button> 
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
@section('script')



<script>
// large image
    $('.large-item-img').on('change', function () { 
    var input = this;

    if (input.files && input.files[0]) {
        // Check if the file type is an image
        if (!input.files[0].type.startsWith('image/')) {
            $('#error-message').text('Please select a valid image file.');
            $('#error-message').show();
            $('.common-submit-btn').prop('disabled', true);
            $('.large-item-img').val('');
            $('#large-item-img-output').attr('src', '{{asset('assets/images/user/img-demo_1041.jpg')}}');
            return;
        }

        var reader = new FileReader();

        reader.onload = function (e) {
            var img = new Image();
            img.src = e.target.result;

            img.onload = function () {
                // if (img.width === 1920 && img.height === 600) {
                    // Image is valid
                    $('#large-item-img-output').attr('src', e.target.result);
                    $('#error-message').hide();
                    $('.common-submit-btn').prop('disabled', false);
                    $('.large_show_close_icon').css('display', 'block');

                // } else {
                //     // Invalid image dimensions, reset input
                //     $('#error-message').text('Please select an image with dimensions 1920x600.');
                //     $('#error-message').show();
                //     $('.common-submit-btn').prop('disabled', true);
                //     $('.large-item-img').val('');
                //     $('#large-item-img-output').attr('src', '{{asset('assets/images/user/img-demo_1041.jpg')}}');
                // }
            };
        };

        reader.readAsDataURL(input.files[0]);
    }
    });
</script>
<script>
// medimum

  $('.medium-item-img').on('change', function () { 
var input = this;

    if (input.files && input.files[0]) {
        // Check if the file type is an image
        if (!input.files[0].type.startsWith('image/')) {
            $('#error-message-med-image').text('Please select a valid image file.');
            $('#error-message-med-image').show();
            $('.common-submit-btn').prop('disabled', true);
            $('.medium-item-img').val('');
            $('#medium-item-img-output').attr('src', '{{asset('assets/images/user/img-demo_1041.jpg')}}');
            return;
        }

        var reader = new FileReader();

        reader.onload = function (e) {
            var img = new Image();
            img.src = e.target.result;

            img.onload = function () {
                // if (img.width === 992 && img.height === 525) {
                    // Image is valid
                    $('#medium-item-img-output').attr('src', e.target.result);
                    $('#error-message-med-image').hide();
                    $('.common-submit-btn').prop('disabled', false);
                      $('.medium_show_close_icon').css('display', 'block');
                // } else {
                //     // Invalid image dimensions, reset input
                //     $('#error-message-med-image').text('Please select an image with dimensions 992x525.');
                //     $('#error-message-med-image').show();
                //     $('.common-submit-btn').prop('disabled', true);
                //     $('.medium-item-img').val('');
                //     $('#medium-item-img-output').attr('src', '{{asset('assets/images/user/img-demo_1041.jpg')}}');
                // }
            };
        };

        reader.readAsDataURL(input.files[0]);
    }
});

</script>
<script>
// small
    $('.small-item-img').on('change', function () {
        var input = this;

    if (input.files && input.files[0]) {
        // Check if the file type is an image
        if (!input.files[0].type.startsWith('image/')) {
            $('#error-message-small-image').text('Please select a valid image file.');
            $('#error-message-small-image').show();
            $('.common-submit-btn').prop('disabled', true);
            $('.small-item-img').val('');
            $('#small-item-img-output').attr('src', '{{asset('assets/images/user/img-demo_1041.jpg')}}');
            return;
        }

        var reader = new FileReader();

        reader.onload = function (e) {
            var img = new Image();
            img.src = e.target.result;

            img.onload = function () {
                // if (img.width === 768 && img.height === 450) {
                    // Image is valid
                    $('#small-item-img-output').attr('src', e.target.result);
                    $('#error-message-small-image').hide();
                    $('.common-submit-btn').prop('disabled', false);
                      $('.small_show_close_icon').css('display', 'block');
                // } else {
                //     // Invalid image dimensions, reset input
                //     $('#error-message-small-image').text('Please select an image with dimensions 768x450.');
                //     $('#error-message-small-image').show();
                //     $('.common-submit-btn').prop('disabled', true);
                //     $('.small-item-img').val('');
                //     $('#small-item-img-output').attr('src', '{{asset('assets/images/user/img-demo_1041.jpg')}}');
                // }
            };
        };

        reader.readAsDataURL(input.files[0]);
    }
    });

    $(document).on("click", ".large_show_close_icon", function() { 
        var $this = $(this);
        $this.closest('.image-sec').find('#large_old_img').val(''); 
        $this.closest('.image-sec').find('#large-item-img-output').attr('src', '{{asset('assets/images/user/img-demo_1041.jpg')}}'); 
        $('#large_file').val('');
         $('#large_file').prop('required', true);
        $this.hide();
    });
    $(document).on("click", ".medium_show_close_icon", function() { 
        var $this = $(this);
        $this.closest('.image-sec').find('#old_img').val(''); 
        $this.closest('.image-sec').find('#medium-item-img-output').attr('src', '{{asset('assets/images/user/img-demo_1041.jpg')}}'); 
        // $('#old_img').val('');
        $('#medium_image_file').val('');
         $('#medium_image_file').prop('required', true);
        $this.hide();
    });

    $(document).on("click", ".small_show_close_icon", function() { 
        var $this = $(this);
        $this.closest('.image-sec').find('#small_old_img').val(''); 
        $this.closest('.image-sec').find('#small-item-img-output').attr('src', '{{asset('assets/images/user/img-demo_1041.jpg')}}'); 
        // $('#old_img').val('');
        $('#small_image_file').val('');
        $('#small_image_file').prop('required', true);
        $this.hide();
    });     

</script>
    @endsection