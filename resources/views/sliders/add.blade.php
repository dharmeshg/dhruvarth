@extends('layouts.backend.index')
@section('main_content')

<div class="pcoded-wrapper">
    <div class="pcoded-content">
        <div class="pcoded-inner-content">
            <!-- [ breadcrumb ] start -->

            <!-- [ breadcrumb ] end -->
            <div class="main-body">
                <div class="page-wrapper">
                    <!-- [ Main Content ] start -->
                    <form action="{{ route('sliders.store') }}" method="POST" data-parsley-validate="" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div
                                class="col-xxl-8 col-xl-8 col-lg-8 col-md-8 cpl-sm-12 col-xs-12 add-article form-main-sec ">
                                <div class="card Recent-Users">
                                    @if (isset($gallery) && $gallery != '')
                                    <h5>Edit Sliders</h5>
                                    @else
                                    <h5>Add Sliders</h5>
                                    @endif
                                    <div class="card-block px-0 py-3">

                                        <div class="row form-sec">
                                            <input type="hidden" id="sliders_id" name="sliders_id"
                                                value=" {{ isset($sliders->id) ? $sliders->id : '' }} ">
                                            <div
                                                class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12 label-sec">
                                                <label for="">Title <span style="color: red;margin: 0;">*</span></label>
                                            </div>
                                            <div class="col-xxl-10 col-xl-10 col-lg-10 col-md-10 col-sm-12 col-xs-12">
                                                <input type="text" class="form-control" id="title" name="title" required
                                                    data-parsley-required-message="Please Enter Title"
                                                    placeholder="Title"
                                                    value="{{ isset($sliders->title) ? $sliders->title : '' }}">
                                            </div>
                                        </div>

                                        <div class="row form-sec">
                                            <div
                                                class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12 label-sec">
                                                <label for="">Sub Title <span style="color: red;margin: 0;">*</span></label>
                                            </div>
                                            <div class="col-xxl-10 col-xl-10 col-lg-10 col-md-10 col-sm-12 col-xs-12">
                                                <input type="text" class="form-control" name="sub_title" id="sub_title"
                                                    placeholder="Sub Title" required
                                                    data-parsley-required-message="Please Enter Sub Title"
                                                    value="{{ isset($sliders->sub_title) ? $sliders->sub_title : '' }}">
                                            </div>
                                        </div>
                                        <div class="row form-sec">
                                            <div
                                                class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12 label-sec">
                                                <label for="">Button Url <span style="color: red;margin: 0;"></span></label>
                                            </div>
                                            <div class="col-xxl-10 col-xl-10 col-lg-10 col-md-10 col-sm-12 col-xs-12">
                                                <input type="url" class="form-control" name="button_url"
                                                    id="button_url" placeholder="Url"                                                   
                                                    value="{{ isset($sliders->url) ? $sliders->url : '' }}">
                                            </div>
                                        </div>
                                        <div class="row form-sec">
                                            <div
                                                class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12 label-sec">
                                                <label for="">Button Name<span
                                                        style="color: red;margin: 0;">*</span></label>
                                            </div>
                                            <div class="col-xxl-10 col-xl-10 col-lg-10 col-md-10 col-sm-12 col-xs-12">
                                                <input type="text" class="form-control" name="button_name"
                                                    id="button_name" placeholder="Button Name" required
                                                    data-parsley-required-message="Please Enter Button Name"
                                                    value="{{ isset($sliders->btn_name) ? $sliders->btn_name : '' }}">
                                            </div>
                                        </div>
                                        <div class="row form-sec">
                                            <div
                                                class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12 label-sec">
                                                <label for="">Sort Description <span
                                                        style="color: red;margin: 0;">*</span></label>
                                            </div>
                                            <div class="col-xxl-10 col-xl-10 col-lg-10 col-md-10 col-sm-12 col-xs-12">
                                                <textarea class="form-control" name="description" id="description"
                                                    style="height: 300px;" data-parsley-required="true"
                                                    data-parsley-required-message="Please enter Description"
                                                    data-parsley-errors-container="#content_required"> {{ isset($sliders->description) ? $sliders->description : '' }} </textarea>
                                                <span class="error_field" id="content_required"></span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="mb-3" style="display: flex; justify-content: end;">
                                                <button type="submit" id="submit_form"
                                                    class="btn btn-lg btn-primary">Save</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 cpl-sm-12 col-xs-12 add-article form-main-sec right-sec">
                                <div class="card Recent-Users">
                                    <h5>Responsive Image</h5>
                                    <div class="card-block px-0 py-3">
                                        <div class="row form-sec">
                                            <div
                                                class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 label-sec">
                                                <input type="hidden" required data-parsley-errors-container="#logo_required" data-parsley-trigger="change" data-parsley-required-message="Please choose an image." 
                                                    value="{{ isset($sliders->image) ? $sliders->image : '' }}"
                                                    name="img_id" id="img_id">
                                                <div class="upload-img-sec text-center image_preview_div">
                                                    @if (isset($image_name->name) && $image_name->name != '')
                                                    <img src="{{ asset('uploads/' . $image_name->name) }}" alt=""
                                                        class="img-fluid profile_avtar" id="profile_avtar"
                                                        style="width:125px;height:125px;">
                                                    <a id="remove_image"><i class="fa fa-times"
                                                            aria-hidden="true"></i></a>
                                                    @else
                                                    <img src="{{ asset('assets/images/user/img-demo_1041.jpg') }}" alt=""
                                                        id="profile_avtar" class="profile-img">
                                                    <a id="remove_image" style="display: none;"> <i class="fa fa-times"
                                                            aria-hidden="true"></i></a>
                                                    @endif
                                                    <label for="file" style="cursor: pointer;"
                                                        class="form-label upload_image choose_file">Choose image</label>
                                                </div>
                                                <span class="error_field" id="logo_required"></span>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="card Recent-Users">
                                    <h5>Banner Image</h5>
                                    <div class="card-block px-0 py-3">
                                        <div class="row form-sec">
                                            <div
                                                class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 label-sec">
                                                <input type="hidden" required data-parsley-errors-container="#banner_img_required"data-parsley-trigger="change" data-parsley-required-message="Please choose an image."
                                                    value="{{ isset($sliders->banner_image) ? $sliders->banner_image : '' }}"
                                                    name="banner_img_id_slider" id="banner_img_id_slider">
                                                <div class="upload-img-sec text-center image_preview_div">
                                                    @if (isset($banner_image_name->name) && $banner_image_name->name != '')
                                                    <img src="{{ asset('uploads/' . $banner_image_name->name) }}" alt=""
                                                        class="img-fluid profile_avtar" id="banner_profile_avtar_slider"
                                                        style="width:125px;height:125px;">
                                                    <a id="banner_remove_image_slider" data-val="banner" data-id="slider" class="remove_image_media"><i class="fa fa-times"
                                                            aria-hidden="true"></i></a>
                                                    @else
                                                    <img src="{{ asset('assets/images/user/img-demo_1041.jpg') }}" alt=""
                                                        id="banner_profile_avtar_slider" class="profile-img">
                                                    <a id="banner_remove_image_slider" class="remove_image_media" data-val="banner" data-id="slider" style="display: none;"> <i class="fa fa-times"
                                                            aria-hidden="true"></i></a>
                                                    @endif
                                                    <label for="file" style="cursor: pointer;" data-val="banner" data-id="slider"
                                                        class="form-label upload_image choose_file">Choose image</label>
                                                </div>
                                                <span class="error_field" id="banner_img_required"></span>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="card Recent-Users next-box">
                                    <h5>On Homepage</h5>
                                    <div class="card-block px-0 py-3">
                                        <div class="row form-sec">
                                            <div
                                                class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 label-sec">
                                                <span style="margin-right: 50px;">Status</span>
                                                <input type="checkbox" data-toggle="toggle" checked name="status" id="status"
                                                    @if(isset($sliders->status) && $sliders->status == '1')
                                                checked @endif>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
const assetPath = "{{ asset('assets/images/user/img-demo_1041.jpg') }}";
$('#remove_image').click(function(event) {
    event.stopPropagation();
    $('#img_id').val(null);
    $('#profile_avtar').attr('src', assetPath);
    $('#remove_image').css('display', 'none');
    $('#profile_avtar').css('opacity', '1.0');
});


$(document).ready(function() {
    $('#description').summernote({
        height: 200
    });
});

</script>
<script>
$(document).ready(function () {
    $('form').parsley({
            excluded: 'input[type=hidden]:not(.visible)'
        });
        $('#submit_form').on('click', function (e) {
       

         $('#img_id').addClass('visible');
         $('#banner_img_id_slider').addClass('visible');


            // Validate the form
            if (!$('form').parsley().validate()) {
                e.preventDefault();
            }

            // Hide the hidden input again
            $('#img_id').removeClass('visible');
            $('#banner_img_id_slider').removeClass('visible');
            

        });
})    
</script>

@endsection