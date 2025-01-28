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
                    <form action="{{ route('married.store') }}" method="POST" data-parsley-validate="" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div
                                class="col-xxl-8 col-xl-8 col-lg-8 col-md-8 cpl-sm-12 col-xs-12 add-article form-main-sec ">
                                <div class="card Recent-Users">
                                    @if (isset($gallery) && $gallery != '')
                                    <h5>Edit How to get Married</h5>
                                    @else
                                    <h5>Add How to get Married</h5>
                                    @endif
                                    <div class="card-block px-0 py-3">

                                        <div class="row form-sec">
                                            <input type="hidden" id="married_id" name="married_id"
                                                value=" {{ isset($married->id) ? $married->id : '' }} ">
                                            <div
                                                class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12 label-sec">
                                                <label for="">Title <span style="color: red;margin: 0;">*</span></label>
                                            </div>
                                            <div class="col-xxl-10 col-xl-10 col-lg-10 col-md-10 col-sm-12 col-xs-12">
                                                <input type="text" class="form-control" id="title" name="title" required
                                                    data-parsley-required-message="Please Enter Title"
                                                    placeholder="Title"
                                                    value="{{ isset($married->title) ? $married->title : '' }}">
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
                                                    value="{{ isset($married->slug) ? $married->slug : '' }}">
                                            </div>
                                        </div>
                                        <div class="row form-sec">
                                            <div
                                                class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12 label-sec">
                                                <label for="">Url <span style="color: red;margin: 0;"></span></label>
                                            </div>
                                            <div class="col-xxl-10 col-xl-10 col-lg-10 col-md-10 col-sm-12 col-xs-12">
                                                <input type="url" class="form-control" name="married_url"
                                                    id="married_url" placeholder="Url" data-parsley-trigger="change"                                                   
                                                    value="{{ isset($married->url) ? $married->url : '' }}">
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
                                                    value="{{ isset($married->button_name) ? $married->button_name : '' }}">
                                            </div>
                                        </div>
                                        <div class="row form-sec">
                                            <div
                                                class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12 label-sec">
                                                <label for="">Short Description <span
                                                        style="color: red;margin: 0;">*</span></label>
                                            </div>
                                            <div class="col-xxl-10 col-xl-10 col-lg-10 col-md-10 col-sm-12 col-xs-12">
                                                <textarea class="form-control" name="description" id="description"
                                                    style="height: 300px;" data-parsley-required="true"
                                                    data-parsley-required-message="Please enter Description"
                                                    data-parsley-errors-container="#content_required"> {{ isset($married->description) ? $married->description : '' }} </textarea>
                                                <span id="content_required"></span>
                                            </div>
                                        </div>
                                        <div class="row form-sec">
                                            <div
                                                class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12 label-sec">
                                                <label for="">Content <span
                                                        style="color: red;margin: 0;">*</span></label>
                                            </div>
                                            <div class="col-xxl-10 col-xl-10 col-lg-10 col-md-10 col-sm-12 col-xs-12">
                                                <textarea class="form-control" name="content" id="content"
                                                    style="height: 300px;" data-parsley-required="true"
                                                    data-parsley-required-message="Please enter Content"
                                                    data-parsley-errors-container="#content2_required"> {{ isset($married->content) ? $married->content : '' }} </textarea>
                                                <span id="content2_required"></span>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="card Recent-Users next-box">
                                        <h5>Seo Meta Tags</h5>
                                        <div class="card-block px-0 py-3">
                                            <div class="row form-sec">
                                                <div
                                                    class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12 label-sec">
                                                    <label for="">Meta title</label>
                                                </div>
                                                <div class="col-xxl-10 col-xl-10 col-lg-10 col-md-10 col-sm-12 col-xs-12">
                                                    <input type="text" name="meta_title" id=""
                                                        placeholder="Type here"
                                                        value="{{ isset($married->meta_title) ? $married->meta_title : '' }}">
                                                </div>
                                            </div>
                                            <div class="row form-sec">
                                                <div
                                                    class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12 label-sec">
                                                    <label for="">Meta Keyword</label>
                                                </div>
                                                <div class="col-xxl-10 col-xl-10 col-lg-10 col-md-10 col-sm-12 col-xs-12">
                                                    <input type="text" name="meta_keyword" id=""
                                                        placeholder="Type here"
                                                        value="{{ isset($married->meta_keyword) ? $married->meta_keyword : '' }}">
                                                </div>
                                            </div>

                                            <div class="row form-sec">
                                                <div
                                                    class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12 label-sec">
                                                    <label for="">Meta description</label>
                                                </div>
                                                <div class="col-xxl-10 col-xl-10 col-lg-10 col-md-10 col-sm-12 col-xs-12">
                                                    <textarea name="meta_description" id="" rows="5" cols="10">{{ isset($married->meta_description) ? $married->meta_description : '' }}</textarea>
                                                </div>
                                            </div>

                                            <div class="row form-sec">
                                                
                                                <div
                                                    class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12 label-sec">
                                                    <label for="">Page Index</label>
                                                </div>
                                                <div
                                                class="col-xxl-10 col-xl-10 col-lg-10 col-md-10 col-sm-12 col-xs-12">
                                                    <label class="switch">
                                                        <input type="checkbox" id="sliderindexbutton" name="page_index" @if(isset($married->page_index) && $married->page_index == '0') @else checked @endif>
                                                        <div class="slider round">
                                                            <span class="on">Yes</span>
                                                            <span class="off">No</span>
                                                        </div>
                                                    </label>
                                                </div>
                                                
                                            </div>
                                            
                                            <div class="row form-sec">
                                                <div
                                                    class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12 label-sec">
                                                    <label for="">Canonical Url</label>
                                                </div>
                                                <div class="col-xxl-10 col-xl-10 col-lg-10 col-md-10 col-sm-12 col-xs-12">
                                                    <input type="text" name="canonical_url" id=""
                                                        placeholder="Canonical Url"
                                                        value="{{ isset($married->canonical_url) ? $married->canonical_url : '' }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                            <div
                                class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 cpl-sm-12 col-xs-12 add-article form-main-sec right-sec">
                                <div class="card Recent-Users">
                                    <h5>Image</h5>
                                    <div class="card-block px-0 py-3">
                                        <div class="row form-sec">
                                            <div
                                                class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 label-sec">
                                                <input type="hidden"
                                                    value="{{ isset($married->image) ? $married->image : '' }}"
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
                                                <span id="logo_required"></span>
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
                                                <span style="margin-right: 50px;">Status</span>
                                                <input type="checkbox" data-toggle="toggle" checked name="status" id="status"
                                                    @if(isset($married->status) && $married->status == '1')
                                                checked @endif>
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
    $('#content').summernote({
        height: 200
    });
});

$(document).on('change', '#title', function(e) {
    const $nameInput = $("#title");
    const $slugInput = $("#slug");
    var token = $("meta[name='csrf-token']").attr("content");
    var val = $(this).val();
    $.ajax({
        url: "{{ route('married.check_slug') }}",
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

</script>

@endsection