@extends('layouts.backend.index')
@section('main_content')
<style>
    input[type="checkbox"] {
        position: relative;
        appearance: none;
        width: 35px;
        height: 20px;
        background: #ccc;
        border-radius: 50px;
        box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.2);
        cursor: pointer;
        transition: 0.4s;
    }

    input:checked[type="checkbox"] {
        background: #321fdb;
    }

    input[type="checkbox"]::after {
        position: absolute;
        content: "";
        width: 20px;
        height: 20px;
        top: 0;
        left: 0;
        background: #fff;
        border-radius: 50%;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
        transform: scale(1.1);
        transition: 0.4s;
    }

    input:checked[type="checkbox"]::after {
        left: 50%;
    }

    .site_logo {
        display: flex;
        align-items: center;
    }

    .site_logo .upload_image {
        border: 1px solid #321fdb;
        color: #321fdb !important;
        font-size: 16px !important;
        font-weight: 500 !important;
        line-height: 26px !important;
        letter-spacing: 0.16px;
        padding: 14px 30px;
        margin: 0 0 0 30px !important;
        width: unset !important;
        cursor: pointer;
    }

    .remove_image {
        display: none;
        position: absolute;
        top: 44%;
        left: 41%;
        cursor: pointer;
    }

    .remove_image1 {
        display: none;
        position: absolute;
        top: 44%;
        left: 41%;
        cursor: pointer;
    }

    .main_figure:hover .remove_image {
        display: block;
    }

    .main_figure:hover .profile_avtar {
        opacity: 0.5;
    }

    .main_figure:hover .remove_image1 {
        display: block !important;
    }

    .main_figure:hover .profile_avtar1 {
        opacity: 0.5;
    }
</style>
<div class="row ">
    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card mb-4">
            <div class="card-header article_heading">
                @if (isset($gallery) && $gallery != '')
                <strong id="modalCenterTitle">Edit Products-Services</strong>
                @else
                <strong id="modalCenterTitle">Add Products-Services</strong>
                @endif
            </div>
            <div class="card-body">
                <div class="example">

                    <form  action="{{ route('products-services.store') }}" method="POST" data-parsley-validate=""
                        enctype="multipart/form-data">
                        @csrf
                        <div class="tab-content rounded-bottom">
                            <div class="tab-pane p-3 active preview" role="tabpanel" id="preview-1000">
                                <div class="row">
                                    <div class="col-12">
                                        <label class="form-label" for="">Image</label>
                                        <div class="mb-3 site_logo">
                                            <figure id="image-figure" class="main_figure" style=" position: relative; ">
                                                @if (isset($gallery->featured_img) && $gallery->featured_img != '')
                                                <img src="{{ asset('uploads/gallery/' . $gallery->featured_img) }}"
                                                    alt="" class="img-fluid profile_avtar" id="profile_avtar"
                                                    style="width:125px;height:125px;border-radius: 50%;">

                                                <img src="{{ asset('assets/img/register-delete.svg') }}" alt=""
                                                    class="img-fluid remove_image" id="remove_image">
                                                @else
                                                <img src="{{ asset('assets/img/new-profile.svg') }}" alt=""
                                                    class="img-fluid profile_avtar1" id="profile_avtar"
                                                    style="width:125px;height:125px;border-radius: 50%;">
                                                <img src="{{ asset('assets/img/register-delete.svg') }}" alt=""
                                                    class="img-fluid remove_image1" id="remove_image"
                                                    style="display:none;">
                                                @endif
                                            </figure>
                                            <label class="form-label upload_image" for="file">Upload Picture</label>
                                            <input class="form-control" id="file" name="pro_services_img" type="file"
                                                placeholder="Category Name" style="display:none"
                                                onchange="loadFile(event)">
                                            <input type="hidden" name="old_img" id="old_img"
                                                value="{{ isset($gallery->featured_img) ? $gallery->featured_img : '' }}">
                                        </div>
                                        <span id="logo_required"></span>
                                    </div>
                                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                        <div class="mb-3">
                                            <input type="hidden" name="pro_services_id"
                                                value="{{ isset($gallery->id) ? $gallery->id : '' }}">
                                            <label for="inputtitle" class="form-label">Sub Title</label>
                                            <input type="text" class="form-control" id="sub_title" name="sub_title" required
                                                data-parsley-required-message="Please Enter Sub Title" placeholder="Sub Title"
                                                value="{{ isset($gallery->title) ? $gallery->title : '' }}">
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                        <div class="mb-3">
                                            <label for="inputtitle" class="form-label">Title</label>
                                            <input type="text" class="form-control" id="title" name="title" required
                                                data-parsley-required-message="Please Enter Title" placeholder="Title"
                                                value="{{ isset($gallery->title) ? $gallery->title : '' }}">
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                        <div class="mb-3">
                                            <label for="inputtitle" class="form-label">Price</label>
                                            <input type="text" class="form-control input-money" id="price" name="price" required
                                                data-parsley-required-message="Please Enter Price" placeholder="Price"
                                                value="{{ isset($gallery->title) ? $gallery->title : '' }}">
                                        </div>
                                    </div>

                                    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="mb-3">
                                            <label class="form-label"
                                                for="exampleFormControlTextarea1">Short Description</label>
                                            <textarea name="short_description" data-parsley-required="true"
                                                class="form-control" id="short_description"
                                                data-parsley-required-message="Please enter Content"
                                                data-parsley-errors-container="#content_required"> {{ isset($gallery->description) ? $gallery->description : '' }} </textarea>
                                            <span id="content_required"></span>
                                        </div>
                                    </div>
                                   
                                    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="mb-3">
                                            <label class="form-label"
                                                for="exampleFormControlTextarea1">Description</label>
                                            <textarea name="description" data-parsley-required="true"
                                                class="form-control" id="editor1" rows="10" cols="80"
                                                data-parsley-required-message="Please enter Content"
                                                data-parsley-errors-container="#content_required"> {{ isset($gallery->description) ? $gallery->description : '' }} </textarea>
                                            <span id="content_required"></span>
                                        </div>
                                    </div>

                                    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="mb-3">
                                            <label class="form-label"
                                                for="exampleFormControlTextarea1">Address</label>
                                                <input type="text" class="form-control" id="address" name="address" required
                                                data-parsley-required-message="Please Enter Address" placeholder="Address"
                                                value="">
                                        </div>
                                    </div>
                                   
                                </div>
                                <div class="mb-3">
                                    <button type="submit" id="submit_form" class="btn btn-lg btn-primary">Save</button>
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
<script src="http://cdn.ckeditor.com/4.6.2/standard-all/ckeditor.js"></script>
<script>
    CKEDITOR.replace('editor1');
    autoUpdateElement: true,

        CKEDITOR.on('instanceReady', function () {
            $.each(CKEDITOR.instances, function (instance) {
                CKEDITOR.instances[instance].on("change", function (e) {
                    for (instance in CKEDITOR.instances)
                        CKEDITOR.instances[instance].updateElement();
                });
            });
        });
</script>
<script>
    const assetPath = "{{ asset('assets/img/new-profile.svg') }}";
    var loadFile = function (event) {
        var reader = new FileReader();
        reader.onload = function () {

            $('#profile_avtar').attr('src', reader.result);
        };

        if (event.target.files[0]) {
            reader.readAsDataURL(event.target.files[0]);
        } else { }
    };
    $('#remove_image').click(function (event) {
        event.stopPropagation(); // Prevent click event propagation to the parent label
        $('#artical_img').val(null);
        $('#old_img').val(null);

        $('#profile_avtar').attr('src', assetPath);
        $('#remove_image').css('display', 'none');
        $('#profile_avtar').css('opacity', '1.0');
    });
</script>
<script>
    
</script>



@endsection