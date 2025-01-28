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
                    <form id="gallery_add" action="" method="POST" data-parsley-validate=""
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div
                                class="col-xxl-8 col-xl-8 col-lg-8 col-md-8 cpl-sm-12 col-xs-12 add-article form-main-sec ">
                                <div class="card Recent-Users">
                                    @if (isset($gallery) && $gallery != '')
                                    <h5>Edit Gallery</h5>
                                    @else
                                    <h5>Add Gallery</h5>
                                    @endif
                                    <div class="card-block px-0 py-3">

                                        <div class="row form-sec">
                                            <input type="hidden" id="gallery_id" name="gallery_id"
                                                value=" {{ isset($gallery->id) ? $gallery->id : '' }} ">
                                            <div
                                                class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12 label-sec">
                                                <label for="">Title <span style="color: red;margin: 0;">*</span></label>
                                            </div>
                                            <div class="col-xxl-10 col-xl-10 col-lg-10 col-md-10 col-sm-12 col-xs-12">
                                                <input type="text" class="form-control" id="title" name="title" required
                                                    data-parsley-required-message="Please Enter Title"
                                                    placeholder="Title"
                                                    value="{{ isset($gallery->title) ? $gallery->title : '' }}">
                                                <span id="error_name" style="color:red;display:none;">This Title is
                                                    Already
                                                    Taken</span>
                                            </div>
                                        </div>

                                        <div class="row form-sec">
                                            <div
                                                class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12 label-sec">
                                                <label for="">Slug <span style="color: red;margin: 0;">*</span></label>
                                            </div>
                                            <div class="col-xxl-10 col-xl-10 col-lg-10 col-md-10 col-sm-12 col-xs-12">
                                                <input type="text" class="form-control" name="slug" id="slug"
                                                    placeholder="Slug" required
                                                    data-parsley-required-message="Please Enter Slug"
                                                    value="{{ isset($gallery->slug) ? $gallery->slug : '' }}">
                                            </div>
                                        </div>
                                        <div class="row form-sec">
                                            <div
                                                class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12 label-sec">
                                                <label for="">Description <span
                                                        style="color: red;margin: 0;">*</span></label>
                                            </div>
                                            <div class="col-xxl-10 col-xl-10 col-lg-10 col-md-10 col-sm-12 col-xs-12">
                                                <textarea class="form-control" name="description" id="description"
                                                    style="height: 300px;" data-parsley-required="true"
                                                    data-parsley-required-message="Please enter Description"
                                                    data-parsley-errors-container="#content_required"> {{ isset($gallery->description) ? $gallery->description : '' }} </textarea>
                                                <span class="error_field" id="content_required"></span>
                                            </div>
                                        </div>
                                        <div class="row form-sec">
                                            <div
                                                class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12 label-sec">
                                                <label for="">Multi Image</label>
                                            </div>
                                            <div class="col-xxl-10 col-xl-10 col-lg-10 col-md-10 col-sm-12 col-xs-12">
                                                <div class="mb-3">
                                                    <div class="dropzone needsclick form-control" id="dropzone_demo"
                                                        name="dropzone_demo"
                                                        style="text-align: center; display: flex; justify-content: center;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @if(isset($multiImage) && $multiImage != "")
                                        <div class="row form-sec">

                                            <div
                                                class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12 label-sec">
                                            </div>
                                            <div class="col-xxl-10 col-xl-10 col-lg-10 col-md-10 col-sm-12 col-xs-12">
                                                <div class="row" id="my_image" style="display: flex;">
                                                    @foreach ($multiImage as $key => $value)
                                                            <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12 remove_images" dataid="{{$value->id}}" style="position:relative; margin: 15px; width: auto;"><a id="delete_img" class="delete_img" dataid="{{$value->id}}"><i class="fa fa-times"
                                                            aria-hidden="true"></i></a><img id="edit_img" src="{{asset('uploads/gallery_multi_img').'/'.$value->name}}" width="130" height="130"></div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        @else
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div
                                class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 cpl-sm-12 col-xs-12 add-article form-main-sec right-sec">
                                <div class="card Recent-Users">
                                    <h5>Thumbnail</h5>
                                    <div class="card-block px-0 py-3">
                                        <div class="row form-sec">
                                            <div
                                                class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 label-sec">
                                                <input type="hidden" required data-parsley-errors-container="#logo_required"data-parsley-trigger="change" data-parsley-required-message="Please choose an image."
                                                    value="{{ isset($gallery->featured_img) ? $gallery->featured_img : '' }}"
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
                                    <h5>Image</h5>
                                    <div class="card-block px-0 py-3">
                                        <div class="row form-sec">
                                            <div
                                                class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 label-sec">
                                                <input type="hidden" required data-parsley-errors-container="#banner_img_required"data-parsley-trigger="change" data-parsley-required-message="Please choose an image."
                                                    value="{{ isset($gallery->banner_image) ? $gallery->banner_image : '' }}"
                                                    name="banner_img_id_gallery" id="banner_img_id_gallery">
                                                <div class="upload-img-sec text-center image_preview_div">
                                                    @if (isset($banner_image_name->name) && $banner_image_name->name != '')
                                                    <img src="{{ asset('uploads/' . $banner_image_name->name) }}" alt=""
                                                        class="img-fluid profile_avtar" id="banner_profile_avtar_gallery"
                                                        style="width:125px;height:125px;">
                                                    <a id="banner_remove_image_gallery" data-val="banner" data-id="gallery" class="remove_image_media"><i class="fa fa-times"
                                                            aria-hidden="true"></i></a>
                                                    @else
                                                    <img src="{{ asset('assets/images/user/img-demo_1041.jpg') }}" alt=""
                                                        id="banner_profile_avtar_gallery" class="profile-img">
                                                    <a id="banner_remove_image_gallery" class="remove_image_media" data-val="banner" data-id="gallery" style="display: none;"> <i class="fa fa-times"
                                                            aria-hidden="true"></i></a>
                                                    @endif
                                                    <label for="file" style="cursor: pointer;" data-val="banner" data-id="gallery"
                                                        class="form-label upload_image choose_file">Choose image</label>
                                                </div>
                                                <span class="error_field" id="banner_img_required"></span>
                                            </div>

                                        </div>
                                    </div>
                                </div>


                                <div class="card Recent-Users next-box">
                                    <h5>Status</h5>
                                    <div class="card-block px-0 py-3">
                                        <div class="row form-sec">
                                            <div
                                                class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 label-sec">
                                                <span style="margin-right: 50px;">Publish Status</span>
                                                <input type="checkbox" data-toggle="toggle" checked name="is_publish"
                                                    @if(isset($gallery->is_publish) && $gallery->is_publish == '1')
                                                checked @endif>
                                            </div>
                                        </div>
                                        <div class="row form-sec">
                                            <div
                                                class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 label-sec">
                                                <button type="submit" id="submit_form" class="btn btn-primary">Save</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card Recent-Users next-box">
                                <h5>Categories</h5>
                                <p style="font-size: 12px;">Only Active Categories</p>
                                <div class="card-block px-0 py-3 common-select">
                                        <div class="row form-sec">
                                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 label-sec">
                                            
                                                <select name="gallery_categories[]" id="categorySelect" class="select2"  multiple required
                                                data-parsley-required-message="Please Enter Category"
                                                data-parsley-errors-container="#category_required">
                                                    <option value="Select a Category" disabled>Select a Category</option>
                                                    @if (isset($gallery))
                                                    @php
                                                        $selectedcategories = explode(',', $gallery->category_id);
                                                    @endphp
                                                @endif
                                                    @if (isset($galleryCategories))
                                                        @foreach ($galleryCategories as $category)
                                             
                                                        <?php $dash=''; ?>
                                                            <option value="{{ $category->id }}"
                                                                {{ isset($selectedcategories) && in_array($category->id, $selectedcategories) ? 'selected' : '' }}>
                                                                {{ $category->category }}
                                                            </option>
                                                            @if(count($category->subcategory))
                                                            <?php $dash.='-- '; ?>
                                                            @foreach($category->subcategory as $subcategory)
                                                            <option value="{{$subcategory->id}}" {{ isset($selectedcategories) && in_array($subcategory->id, $selectedcategories) ? 'selected' : '' }}>{{$dash}}{{$subcategory->category}}</option>
                                                            @endforeach
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </select>
                                                <span class="error_field" id="category_required"></span>
                                                    <div class="row form-sec" id="new_cat_add_div" style="display:none;">
                                                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 label-sec">
                                                        <label for="">New Category
                                                        </label>
                                                        <input type="text" name="gallery_category" id="gallery_category" placeholder="Category">
                                                        <input type="text" name="gallery_slug" id="gallery_slug" placeholder="Slug">
                                                        <span id="new_cat_required" class="error_field" style="display:none;color:red;">Please Enter Category Name</span>
                                                        <select class="form-select" id="parent_category" name="parent_category"
                                                            aria-label="Default select example" style="margin-bottom: 15px;">
                                                            <option value="0">--- Select Category ---</option>

                                                            @if(isset($galleryCategories))
                                                            @foreach($galleryCategories as $category)
                                                            <?php $dash=''; ?>
                                                            <option value="{{$category->id}}">{{$category->category}}</option>
                                                            @if(count($category->subcategory))
                                                            @include('subcategoryList-option',['subcategories' => $category->subcategory])
                                                            @endif
                                                            @endforeach
                                                            @endif
                                                        </select>
                                                        <a class="add_new_cat_class" id="submit_new_cat">Add</a>
                                                    </div>
                                                </div>
                                                <a class="btn add_categories" id="add_new_cat_btn">Add New Categories</a>
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
</script>
<script>
$(document).ready(function() {
    $('#description').summernote({
        height: 200
    });
});
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
myDropzone = new Dropzone("#dropzone_demo", {
    url: '{{ route('media.upload') }}',
    previewTemplate: previewTemplate,
    parallelUploads: 1,
    maxFilesize: 5,
    addRemoveLinks: true,
    dictDefaultMessage: '<p>Click Or Drop Files Here To Upload</p><i class="fa fa-upload" aria-hidden="true"></i>',
});

$(document).ready(function() {
    $("#gallery_add").submit(function(e) {
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
            success: function(response) {
                var data = JSON.parse(response);
                if ((data.status = 1)) {
                    window.location.href = admin_url + "gallery";
                    toastr.success(data.message);
                }
            },
        });
    })
});

$(document).on('change', '#title', function(e) {
    const $nameInput = $("#title");
    const $slugInput = $("#slug");
    var token = $("meta[name='csrf-token']").attr("content");
    var val = $(this).val();
    $.ajax({
        url: "{{ route('gallery.check_slug') }}",
        method: "POST",
        data: {
            _token: token,
            name: val
        },
        success: function(response) {
            if (response.status == 1) {
                $('#error_name').show();
            } else {
                $('#error_name').hide();
                const nameValue = $nameInput.val();
                const slugValue = nameValue.replace(/\s+/g, "-").toLowerCase();
                $slugInput.val(slugValue);
            }
        },
        error: function(xhr, status, error) {
            toastr.error('Something Went Wrong!');
        }
    });
});

$('.delete_img').click(function(event) {
    var img_id = $(this).attr("dataid");

    var gallery_id = $("#gallery_id").val();

    var token = $("meta[name='csrf-token']").attr("content");
    $.ajax({
        url: "{{ route('gallery.image_remove') }}",
        method: "POST",
        data: {
            _token: token,
            img_id: img_id,
            gallery_id:gallery_id
        },
        success: function(response) {
            if (response.status == 1) {
                var image_id = response.gallery_list;
                $(".remove_images[dataid='" + image_id + "']").remove();
            } else {
       
            }
        },
     
    });
    
});

$(document).on('click', '#add_new_cat_btn', function() {
    $('#new_cat_add_div').toggle();
});

$(document).on('change', '#gallery_category', function(e) {
    const $nameInput = $("#gallery_category");
    const $slugInput = $("#gallery_slug");
    var token = $("meta[name='csrf-token']").attr("content");
    var val = $(this).val();
    $.ajax({
        url: "{{ route('gallery_category.check_slug') }}",
        method: "POST",
        data: {
            _token: token,
            name: val
        },
        success: function(response) {
            if (response.status == 1) {
                $('#error_name').show();
            } else {
                $('#error_name').hide();
                const nameValue = $nameInput.val();
                const slugValue = nameValue.replace(/\s+/g, "-").toLowerCase();
                $slugInput.val(slugValue);
            }
        },
        error: function(xhr, status, error) {
            toastr.error('Something Went Wrong!');
        }
    });
});

$(document).on('click', '#submit_new_cat', function() {
            var gallery_category = $('#gallery_category').val();
            var gallery_slug = $('#gallery_slug').val();
            var parent_category = $('#parent_category').val();
            var token = $("meta[name='csrf-token']").attr("content");
            if(gallery_category == ''){
                $('#new_cat_required').show();
            }else{
                $('#new_cat_required').hide();
                $.ajax({
                url: "{{ route('gallery-category.create-category') }}",
                method: "POST",
                data: {
                    _token: token,
                    gallery_category: gallery_category,
                    gallery_slug: gallery_slug,
                    parent_category: parent_category
                },
                success: function(response) {
                    if (response.status == 1) {
                        toastr.error(response.message);
                        var new_cat = $('#gallery_category').val('');
                    }
                    else if(response.status == 0)
                    {
                        var newCategory = response.newCategory;
                        var categorySelect = $('#categorySelect');
                        categorySelect.append($('<option>', {
                        value: newCategory.id,
                        text: newCategory.category,
                        selected: true 
                    }));
                    categorySelect.trigger('change');
                    toastr.success(response.message);
                    $('#gallery_category').val('');
                    $('#gallery_slug').val('');

                    }
                },
                error: function(xhr, status, error) {
                    toastr.error('Something Went Wrong!');
                }
            });
            }
        });
</script>

<script>
    $(document).ready(function () {
    $('form').parsley({
            excluded: 'input[type=hidden]:not(.visible)'
        });
        $('#submit_form').on('click', function (e) {
       

         $('#img_id').addClass('visible');
         $('#banner_img_id_gallery').addClass('visible');


            // Validate the form
            if (!$('form').parsley().validate()) {
                e.preventDefault();
            }

            // Hide the hidden input again
            $('#img_id').removeClass('visible');
            $('#banner_img_id_gallery').removeClass('visible');
            

        });
}) 
</script>

@endsection