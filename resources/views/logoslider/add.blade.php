@extends('layouts.backend.index')
@section('main_content')

<div class="pcoded-wrapper">
    <div class="pcoded-content">
        <div class="pcoded-inner-content">
            <!-- [ breadcrumb ] start -->
            <div class="custom_breadcum">
                <ul>
                    <li class="breadcum-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                    <li class="breadcum-item"><a href="{{route('media.index')}}"> Media </a></li>
                    <li class="breadcum-item"><a href="{{route('logoslider.index',['slug'=> isset($data->type) ? $data->type : $sec])}}"> Logo Sliders</a></li>
                    <li class="breadcum-item active"><a href="javascript:;"> {{isset($data) ? 'Edit' : 'Add'}} Logo Slider</a></li>
                </ul>
            </div>
            <!-- [ breadcrumb ] end -->
            <div class="main-body">
                <div class="page-wrapper">
                    <h3 class="">{{ isset($data) ? 'Edit Logo Slider' : 'Add Logo Slider' }}</h3>
                    <!-- [ Main Content ] start -->
                    <form id="addcategory" action="{{ route('logoslider.save') }}" method="POST"
                                            data-parsley-validate="" enctype='multipart/form-data'>
                        @csrf
                        <input type="hidden" id="logo_id" name="logo_id" value="{{ isset($data->id) ? $data->id : '' }}">
                        <input type="hidden" name="type" value="{{ isset($data->type) ? $data->type : $sec }}">
                        <div class="input_group mt-3">
                            <div class="mb-3">
                                <label>Cover Image <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please upload cover image for the logo slider"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                <p><span style="color: red;margin: 0;">*Recommended Size: 100x100 pixel upto 500KB.</span></p>
                                <div class="row">
                                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12 d-flex align-items-center">
                                        <div class="me-3">
                                            <label class="img_upload daily_status_image" for="large_file"><i class="fa fa-plus mx-1"></i> Upload</label>
                                            <input type="file"  style="display: none;" id="large_file" name="cover_image" class="cover-item-img"  @if(isset($data->cover_image) && $data->cover_image != null && $data->cover_image != '') @else required @endif data-parsley-required-message="Cover Image is Required" data-parsley-errors-container="#large_cont">
                                        </div>
                                        <div>
                                            @if(isset($data->cover_image) && $data->cover_image != '' && $data->cover_image != null)
                                            <img src="{{asset('uploads/media/'.$data->cover_image)}}" class="img-fluid preview_image" id="cover-item-img-output">
                                            @else
                                            <img src="{{asset('assets/images/user/img-demo_1041.jpg')}}" class="img-fluid preview_image" id="cover-item-img-output">
                                            @endif
                                        </div>
                                        <input type="hidden" name="cover_old_img" value="{{ isset($data->cover_image) ? $data->cover_image : ''}}" id="old_img">
                                    </div>
                                </div>
                                <span id="large_cont"></span>
                                <span id="error-message" style="display: none; color: red;" class="parsley-errors-list"></span>
                            </div>
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                        <label class="form-label" for="exampleFormControlInput1">Title <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter Title For The Logo Slider"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                        <input class="form-control" id="title" name="title" type="text" required data-parsley-required-message="Please Enter Title" placeholder="Enter Title" value="{{ isset($data->title) ? $data->title : '' }}">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                                <div class="row">
                                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                        <label class="form-label" for="exampleFormControlInput1">Insert Link <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter Link For The Logo Slider"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                        <input class="form-control" id="link" name="link" type="url" placeholder="Enter Link"  value="{{ isset($data->link) ? $data->link : '' }}">
                                </div>
                            </div>
                        </div>
                    <div class="mb-3">
                        <button type="submit" class="common-sub-btn">Submit</button> 
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
    $('.cover-item-img').on('change', function () { 
        var input = this;

        if (input.files && input.files[0]) {
            if (!input.files[0].type.startsWith('image/')) {
                $('#error-message').text('Please select a valid image file.');
                $('#error-message').show();
                $('.common-sub-btn').prop('disabled', true);
                $('.cover-item-img').val('');
                return;
            }
            var reader = new FileReader();

            reader.onload = function (e) {
                var img = new Image();
                img.src = e.target.result;

                img.onload = function () {
                    // if (img.width === 250 && img.height === 250 && input.files[0].size <= 500 * 1024) {
                        // Image is valid
                        $('#cover-item-img-output').attr('src', e.target.result);
                        $('#error-message').hide();
                        $('.common-sub-btn').prop('disabled', false);
                        $('#old_img').val();
                    // } else {
                    //     // Invalid image, reset input
                    //     $('#error-message').text('Please select a valid image with dimensions 250x250 and size up to 500kb.');
                    //     $('#error-message').show();
                    //     $('.common-sub-btn').prop('disabled', true);
                    //     $('.cover-item-img').val('');
                    // }
                };
            };

            reader.readAsDataURL(input.files[0]);
        }
    });
    
</script>
@endsection