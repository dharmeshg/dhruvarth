@extends('layouts.backend.index')
@section('main_content')
<style>

</style>
    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <!-- [ breadcrumb ] start -->

                <!-- [ breadcrumb ] end -->
                <div class="main-body">
                    <div class="page-wrapper">
                        <!-- [ Main Content ] start -->
                        <form action="{{ route('page.save') }}" method="POST" data-parsley-validate=""
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div
                                    class="col-xxl-8 col-xl-8 col-lg-8 col-md-8 cpl-sm-12 col-xs-12 add-article form-main-sec ">
                                    <div class="card Recent-Users">
                                        @if (isset($page) && $page != '')
                                            <h5>Edit Page</h5>
                                        @else
                                            <h5>Add Page</h5>
                                        @endif
                                        <div class="card-block px-0 py-3">
                                            <div class="row form-sec">
                                                <div
                                                    class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12 label-sec">
                                                    <input type="hidden" name="page_id"
                                                        value="{{ isset($page->id) ? $page->id : '' }}">
                                                    <label for="">Page Title <span
                                                            style="color: red;margin: 0;">*</span></label>
                                                </div>
                                                <div class="col-xxl-10 col-xl-10 col-lg-10 col-md-10 col-sm-12 col-xs-12">
                                                    <input type="text" name="page_title" id="page_title"
                                                        placeholder="Page Title" required
                                                        data-parsley-required-message="Please Enter Page Title"
                                                        value="{{ isset($page->title) ? $page->title : '' }}">
                                                    <span id="error_name" style="color:red;display:none;">This Title is
                                                        Already
                                                        Taken</span>
                                                </div>
                                            </div>
                                            <div class="row form-sec">
                                                <div
                                                    class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12 label-sec">
                                                    <label for="">Slug <span
                                                            style="color: red;margin: 0;">*</span></label>
                                                </div>
                                                <div class="col-xxl-10 col-xl-10 col-lg-10 col-md-10 col-sm-12 col-xs-12">
                                                    <input type="text" name="page_slug" id="page_slug" placeholder="Slug"
                                                        required data-parsley-required-message="Please Enter Slug"
                                                        value="{{ isset($page->slug) ? $page->slug : '' }}">
                                                </div>
                                            </div>

                                            <div class="row form-sec" id="page_content_div" @if(isset($page->make_with_builder) && $page->make_with_builder == '1') style="display:none;" @endif>
                                                <div
                                                    class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12 label-sec">
                                                    <label for="">Content <span
                                                            style="color: red;margin: 0;">*</span></label>
                                                </div>
                                                <div class="col-xxl-10 col-xl-10 col-lg-10 col-md-10 col-sm-12 col-xs-12">

                                                    <textarea class="form-control" id="code_preview0" name="page_content" style="height: 300px;" @if(isset($page->make_with_builder) && $page->make_with_builder == '1') 
                                                        data-parsley-required="false" @else  data-parsley-required="true" @endif data-parsley-required-message="Please enter Content"
                                                        data-parsley-errors-container="#content_required">{{ isset($page->content) ? $page->content : '' }}</textarea>
                                                    <span id="content_required"></span>
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
                                                        value="{{ isset($page->meta_title) ? $page->meta_title : '' }}">
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
                                                        value="{{ isset($page->meta_keyword) ? $page->meta_keyword : '' }}">
                                                </div>
                                            </div>

                                            <div class="row form-sec">
                                                <div
                                                    class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12 label-sec">
                                                    <label for="">Meta description</label>
                                                </div>
                                                <div class="col-xxl-10 col-xl-10 col-lg-10 col-md-10 col-sm-12 col-xs-12">
                                                    <textarea name="meta_description" id="" rows="5" cols="10">{{ isset($page->meta_description) ? $page->meta_description : '' }}</textarea>
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
                                                        <input type="checkbox" id="sliderindexbutton" name="page_index" @if(isset($page->page_index) && $page->page_index == '0') @else checked @endif>
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
                                                        value="{{ isset($page->canonical_url) ? $page->canonical_url : '' }}">
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>

                                <div
                                    class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 cpl-sm-12 col-xs-12 add-article form-main-sec right-sec">
                                    <div class="card Recent-Users">
                                        <h5>Publish</h5>
                                        <div class="card-block px-0 py-3">
                                            <div class="row form-sec ">
                                                <div
                                                    class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 label-sec d-flex justify-content-between">
                                                    <div class="d-flex">
                                                        <input type="radio" id="a25" name="publish_status"
                                                            class="public_status_radio" value="Draft"
                                                            @if (isset($page->publish_status) && $page->publish_status == 'Draft') checked @endif />
                                                        <label class="btn btn-secondary public_status_lable"
                                                            for="a25">Draft</label>
                                                        <input type="radio" id="a26" name="publish_status"
                                                            class="public_status_radio" value="Published"
                                                            @if (isset($page->publish_status) && $page->publish_status == 'Published') checked @endif />
                                                        <label class="btn btn-secondary public_status_lable"
                                                            for="a26">Published</label>
                                                    </div>
                                                    {{-- <a href="#" class="btn btn-dark sm mr-2">Preview</a> --}}
                                                </div>
                                            </div>

                                            <div class="row form-sec" id="page_visibility" @if(isset($page->make_with_builder) && $page->make_with_builder == '1') style="display:none;" @endif>
                                                <div
                                                    class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 label-sec">
                                                    <div class="edit-sec">
                                                        <i class="icofont-eye icofont-1x"></i>
                                                        <span class="font-14 black ml-1">Visibility :</span>
                                                        <span class="font-14 bold black ml-2"
                                                            id="current_visibility">{{ isset($page->visibility) ? $page->visibility : 'Public' }}</span>
                                                        <a class="btn custom-btn ml-2" id="edit_visibility">Edit</a>
                                                        <div class="visibility_hide_div" style="display: none;">
                                                            <div class="visiblity_inner_div">
                                                                <input type="radio" checked="" name="visibility"
                                                                    id="visibility-radio-public" value="Public"
                                                                    class="visiblity_toggle"
                                                                    @if (isset($page->visibility) && $page->visibility == 'Public') checked @endif>
                                                                <label for="visibility-radio-public"
                                                                    class="selectit">Public</label>
                                                            </div>
                                                            <div class="visiblity_inner_div">
                                                                <input type="radio" name="visibility"
                                                                    id="visibility-radio-password" value="Password"
                                                                    class="visiblity_toggle"
                                                                    @if (isset($page->visibility) && $page->visibility == 'Password') checked @endif>
                                                                <label for="visibility-radio-password"
                                                                    class="selectit">Password Protected</label>
                                                            </div>
                                                            <span class="visiblity_password" style="display:none;">
                                                                <input type="text" name="post_pass"
                                                                    value="{{ isset($page->password) ? $page->password : '' }}"><br>
                                                                <span class="visibility_error" style="color:red">If
                                                                    Password Field is remain Empty then visibility will be
                                                                    saved as Public.</span>
                                                            </span>

                                                            <div class="visiblity_inner_div">
                                                                <input type="radio" name="visibility"
                                                                    id="visibility-radio-private" value="Private"
                                                                    class="visiblity_toggle"
                                                                    @if (isset($page->visibility) && $page->visibility == 'Private') checked @endif>
                                                                <label for="visibility-radio-private"
                                                                    class="selectit">Private</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row form-sec">
                                                <div
                                                    class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 label-sec">
                                                    <div class="Publish-sec">
                                                        <span class="font-14 black ml-1">Publish :</span>
                                                        <input type="date" name="page_published_at" id=""
                                                            value="{{ isset($page->published_at) ? $page->published_at : '' }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row form-sec">
                                                <div
                                                    class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 label-sec">
                                                    <div class="Publish-sec d-flex align-items-center justify-content-between">
                                                        <span class="font-14 black ml-1" style="width: auto !important;">Make With Builder :</span>
                                                        <label class="switch">
                                                            <input type="checkbox" id="slidersecbutton" name="make_with_builder" @if(isset($page->make_with_builder) && $page->make_with_builder == '1') checked @endif>
                                                            <div class="slider round">
                                                                <span class="on">Enable</span>
                                                                <span class="off">Disable</span>
                                                            </div>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row form-sec">
                                                <div
                                                    class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 label-sec">
                                                    <button type="submit" class="btn btn-primary">Save</button>
                                                </div>
                                            </div>



                                        </div>
                                    </div>
                                    <div class="card Recent-Users next-box" style="margin-top: 0 !important;" id="page_templet_div">
                                        <h5>Select Page Template</h5>
                                        <div class="card-block px-0 py-3">
                                            <select name="page_template" id="page_template">
                                                <option value="0" {{ isset($page->page_template) && $page->page_template == '0'  ? 'selected' : ''}}>Default</option>
                                                <option value="1" {{ isset($page->page_template) && $page->page_template == '1' ? 'selected' : ''}}>Gallery Page</option>
                                                <option value="2" {{ isset($page->page_template)&&  $page->page_template == '2' ? 'selected' : ''}}>Testimonial Page</option>
                                                <option value="3" {{ isset($page->page_template) && $page->page_template == '3' ? 'selected' : ''}}>Blogs Page</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="card Recent-Users next-box" style="margin-top: 0 !important;">
                                        <h5>Page Attributes</h5>
                                        <div class="card-block px-0 py-3">
                                            <label for="">Parents</span></label>
                                            <select name="page_parent" id="page_parent">
                                                <option value="Select a Parent" selected disabled>Select a Tage</option>
                                                <option value="0">None</option>
                                                @if (isset($parent))
                                                    @foreach ($parent as $val)
                                                    <option value="{{ $val->id }}" {{ isset($page->page_attribute) && $page->page_attribute == $val->id ? 'selected' : ''}}>{{ $val->title }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="card Recent-Users next-box" id="sidebar_div">
                                        <h5>Display Sidebar</h5>
                                        <div class="card-block px-0 py-3">
                                            <div class="row form-sec">
                                                <div
                                                    class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 label-sec">
                                                    <div class="Publish-sec d-flex align-items-center justify-content-between">
                                                        <span class="font-14 black ml-1" style="width: auto !important;">Enable/Disable:</span>
                                                        <label class="switch">
                                                            <input type="checkbox" id="" name="page_slider" @if(isset($page->page_slider) && $page->page_slider == '1') checked @endif>
                                                            <div class="slider round">
                                                                <span class="on">Enable</span>
                                                                <span class="off">Disable</span>
                                                            </div>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card Recent-Users next-box">
                                        <h5>Display Header Banner</h5>
                                        <div class="card-block px-0 py-3">
                                            <div class="row form-sec">
                                                <div
                                                    class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 label-sec">
                                                    <div class="Publish-sec d-flex align-items-center justify-content-between">
                                                        <span class="font-14 black ml-1" style="width: auto !important;">Enable/Disable:</span>
                                                        <label class="switch">
                                                            <input type="checkbox" id="bannersecbutton" name="header_banner" @if(isset($page->header_banner) && $page->header_banner == '1') checked @endif>
                                                            <div class="slider round">
                                                                <span class="on">Enable</span>
                                                                <span class="off">Disable</span>
                                                            </div>
                                                        </label>
                                                    </div>
                                                    <div id="header_banner_div" class="mt-3" @if(isset($page->header_banner) && $page->header_banner == '1') style="display: block;" @else style="display: none;" @endif>
                                                        <div class="upload-img-sec text-center">
                                                        <input type="hidden" name="header_banner_img" id="p_banner_sec_img_id_p_banner_id"
                                                            value="{{ isset($page->header_banner_img) ? $page->header_banner_img : '' }}">
                                                        @if (isset($page->header_banner_img) && $page->header_banner_img != '' && $page->header_banner_img != null)
                                                            @php
                                                                $img_2 = App\Models\MediaImage::select('name')
                                                                    ->where('id', $page->header_banner_img)
                                                                    ->first();
                                                            @endphp
                                                            <div class="image_preview_div">
                                                                <img src="{{ asset('uploads/' . $img_2->name) }}"
                                                                    alt="" id="p_banner_sec_profile_avtar_p_banner_id" class="profile-img"
                                                                    id="profile_avtar">
                                                                <a id="p_banner_sec_remove_image_p_banner_id" class="remove_image_media" data-val="p_banner_sec" data-id="p_banner_id"> <i class="fa fa-times"
                                                                        aria-hidden="true"></i></a>
                                                            </div>
                                                        @else
                                                            <div class="image_preview_div">
                                                                <img src="{{ asset('assets/images/user/img-demo_1041.jpg') }}"
                                                                    alt="" id="p_banner_sec_profile_avtar_p_banner_id"
                                                                    class="profile-img">
                                                                <a id="p_banner_sec_remove_image_p_banner_id" style="display: none;" class="remove_image_media" data-val="p_banner_sec" data-id="p_banner_id"> <i
                                                                        class="fa fa-times" aria-hidden="true"></i></a>
                                                            </div>
                                                        @endif

                                                        <label for="" style="cursor: pointer;"
                                                            class="choose_file" data-val="p_banner_sec" data-id="p_banner_id">Choose image</label>
                                                    </div>
                                                    <div class="row form-sec">
                                                    <div
                                                        class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 label-sec">
                                                        <label for="">Banner Title</label>
                                                    </div>
                                                    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <input type="text" name="header_banner_title" id="header_banner_title"
                                                            placeholder="Banner Title"
                                                            value="{{ isset($page->header_banner_title) ? $page->header_banner_title : '' }}">
                                                    </div>
                                                </div>
                                                <div class="row form-sec">
                                                    <div
                                                        class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 label-sec">
                                                        <label for="">Banner Sub-Title</label>
                                                    </div>
                                                    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <input type="text" name="header_banner_subtitle" id="header_banner_subtitle"
                                                            placeholder="Banner Sub-Title"
                                                            value="{{ isset($page->header_banner_subtitle) ? $page->header_banner_subtitle : '' }}">
                                                    </div>
                                                </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                        <!-- <div class="card Recent-Users next-box"  id="page_featured_image" @if(isset($page->make_with_builder) && $page->make_with_builder == '1') style="display:none;" @else style="margin-top: 0 !important;" @endif>
                                            <h5>Featured Image</h5>
                                            <div class="card-block px-0 py-3">
                                                <div class="row form-sec">
                                                    <div
                                                        class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 label-sec">
                                                        <div class="upload-img-sec text-center">
                                                            <input type="hidden" name="page_img_id" id="img_id"
                                                                value="{{ isset($page->image) ? $page->image : '' }}">
                                                            @if (isset($page->image) && $page->image != '' && $page->image != null)
                                                                @php
                                                                    $img = App\Models\MediaImage::select('name')
                                                                        ->where('id', $page->image)
                                                                        ->first();
                                                                @endphp
                                                                <div class="image_preview_div">
                                                                    <img src="{{ asset('uploads/' . $img->name) }}"
                                                                        alt="" id="profile_avtar" class="profile-img"
                                                                        id="profile_avtar">
                                                                    <a id="remove_image"> <i class="fa fa-times"
                                                                            aria-hidden="true"></i></a>
                                                                </div>
                                                            @else
                                                                <div class="image_preview_div">
                                                                    <img src="{{ asset('assets/images/user/img-demo_1041.jpg') }}"
                                                                        alt="" id="profile_avtar"
                                                                        class="profile-img">
                                                                    <a id="remove_image" style="display: none;"> <i
                                                                            class="fa fa-times" aria-hidden="true"></i></a>
                                                                </div>
                                                            @endif

                                                            <label for="" style="cursor: pointer;"
                                                                class="choose_file">Choose image</label>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>
                                        </div> -->

                                </div>
                                <!--[ Recent Users ] end-->

                            </div>
                        </form>
                        <!-- [ Main Content ] end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('#code_preview0').summernote({
                height: 300
            });
        });
    </script>
    <script>
        // const assetPath = "{{ asset('assets/images/user/img-demo_1041.jpg') }}";

        $('#remove_image').click(function(event) {
            event.stopPropagation();
            $('#img_id').val(null);

            $('#profile_avtar').attr('src', assetPath);
            $('#remove_image').css('display', 'none');
            $('#profile_avtar').css('opacity', '1.0');
        });
    </script>
    <script>
        $(document).on('change', '#page_title', function(e) {
            const $nameInput = $("#page_title");
            const $slugInput = $("#page_slug");
            var token = $("meta[name='csrf-token']").attr("content");
            var val = $(this).val();
            $.ajax({
                url: "{{ route('page.check_slug') }}",
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
    <script>
        $(document).on('click', '#edit_visibility', function() {
            $('.visibility_hide_div').toggle();
        });
        $(document).on('change', '.visiblity_toggle', function() {
            var val = $(this).val();
            if (val === "Password") {
                $('.visiblity_password').show();
            } else {
                $('.visiblity_password').hide();
            }
        });
    </script>
    <script>
        $('#slidersecbutton').click(function(){
        var val = $(this).prop('checked');
        if(val === true)
        {
            $('#page_visibility').hide();
            $('#page_featured_image').hide();
            $('#page_content_div').hide();
            $('#page_templet_div').hide();
            $('#code_preview0').attr('data-parsley-required', false);
            $('#page_template').attr('data-parsley-required', false);
        }else{
            $('#page_visibility').show();
            $('#page_featured_image').show();
            $('#page_content_div').show();
            $('#page_templet_div').show();
            $('#code_preview0').attr('data-parsley-required', true);
            $('#page_template').attr('data-parsley-required', true);
        }
    });

        $('#bannersecbutton').click(function(){
        var val = $(this).prop('checked');
        if(val === true)
        {
            $('#header_banner_div').show();
        }else{
            $('#header_banner_div').hide();
        }
    });
    </script>
@endsection
