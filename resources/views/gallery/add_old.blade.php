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
                <strong id="modalCenterTitle">Edit Gallery</strong>
                @else
                <strong id="modalCenterTitle">Add Gallery</strong>
                @endif
            </div>
            <div class="card-body">
                <div class="example">

                    <form id="gallery_add" action="" method="POST" data-parsley-validate="" enctype="multipart/form-data">
                        @csrf
                        <div class="tab-content rounded-bottom">
                            <div class="tab-pane p-3 active preview" role="tabpanel" id="preview-1000">
                                <div class="row">
                                    <div class="col-12">
                                        <label class="form-label" for="">Featured Image</label>
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
                                            <input class="form-control" id="file" name="gallery_img" type="file"
                                                placeholder="Category Name" style="display:none"
                                                onchange="loadFile(event)">
                                            <input type="hidden" name="old_img" id="old_img"
                                                value="{{ isset($gallery->featured_img) ? $gallery->featured_img : '' }}">
                                        </div>
                                        <span id="logo_required"></span>
                                    </div>
                                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                        <div class="mb-3">
                                            <input type="hidden" name="gallery_id"
                                                value="{{ isset($gallery->id) ? $gallery->id : '' }}">
                                            <label for="inputtitle" class="form-label">Title</label>
                                            <input type="text" class="form-control" id="title" name="title" required
                                                data-parsley-required-message="Please Enter Title" placeholder="Title"
                                                value="{{ isset($gallery->title) ? $gallery->title : '' }}">
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="exampleFormControlTextarea1">Slug</label>
                                            <input type="text" class="form-control" id="slug" name="slug" required
                                                data-parsley-required-message="Please Enter Slug"
                                                value="{{ isset($gallery->slug) ? $gallery->slug : '' }}"
                                                placeholder="Slug">
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="exampleFormControlInput1">Status</label>
                                            <div class="form-group row my-2">
                                                <label for="is_publish" class="col-sm-6 font-14 bold black">Publish
                                                    Status
                                                </label>
                                                <div class="col-sm-6">
                                                    <label class="switch glow primary medium">
                                                        <input type="checkbox" name="is_publish" @if (isset($gallery) &&
                                                            $gallery->is_publish == '1') checked @endif>
                                                    </label>
                                                </div>
                                            </div>
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
                                            <div class="dropzone needsclick form-control" id="dropzone_demo"
                                                name="dropzone_demo"
                                                style="text-align: center; display: flex; justify-content: center;">
                                            </div>
                                        </div>
                                    </div>

                                    @if(isset($multiImage) && $multiImage != "")
                                    <div class="row" id="my_image" style="display: flex;">

                                        @foreach ($multiImage as $key => $value)
                                        <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12"
                                            style="position:relative; margin: 15px; width: auto;"><button
                                                id="delete_img" dataid="{{$value->id}}" type="button"
                                                class="close delete_img"><span>&times;</span></button><img id="edit_img"
                                                src="{{asset('uploads/gallery_multi_img').'/'.$value->name}}"
                                                width="130" height="130"></div>
                                        @endforeach
                                    </div>
                                    @else
                                    @endif
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
    const previewTemplate = `<div class="dz-preview dz-file-preview">
    <div class="dz-details">
      <div class="dz-thumbnail">
        <img data-dz-thumbnail>
        <span class="dz-nopreview">No preview</span>
        <div class="dz-success-mark"></div>
        <div class="dz-error-mark"></div>
        <div class="dz-error-message"><span data-dz-errormessage></span></div>
        <div class="progress">
          <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuemin="0" aria-valuemax="100" data-dz-uploadprogress></div>
        </div>
      </div>
      <div class="dz-filename" data-dz-name></div>
      <div class="dz-size" data-dz-size></div>
    </div>
    </div>`;

    myDropzone = new Dropzone("div#dropzone_demo", {
        url: "/upload/post",
        previewTemplate: previewTemplate,
        parallelUploads: 1,
        maxFilesize: 5,
        addRemoveLinks: true,
    });
    $(document).ready(function () {
        $("#gallery_add").submit(function (e) {
            e.preventDefault();
            var token = $("meta[name='csrf-token']").attr("content");
            var form = $(this);
            var data = new FormData(form[0]);
            data.append("multi_image", JSON.stringify(myDropzone.files));
            $.ajax({
                url: admin_url + "gallery-store",
                type: "POST",
                data: data,
                contentType: false,
                processData: false,
                success: function (response) {
                    var data = JSON.parse(response);
                    if ((data.status = 1)) {
                        window.location.href = admin_url + "gallery";
                        toastr.success(data.message);
                    }
                },
            });
        })
    })


    // $(document).on('click', '#delete_img', function () {
    //     var img_id = $(this).attr('dataid');
    //     var token = $("meta[name='csrf-token']").attr("content");
    //     $.ajax({
    //         url: admin_url + "admin/gallery/image/delete",
    //         type: 'post',
    //         data: {
    //             _token: token,
    //             img_id: img_id,
    //         },
    //         success: function (data) {

    //             var data = JSON.parse(data);

    //             if (data.status == 1) {
    //             }

    //         },

    //     })

    // })
</script>

@endsection