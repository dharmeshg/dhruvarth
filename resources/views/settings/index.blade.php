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
                                <form action="{{ route('setting.add') }}" method="POST" data-parsley-validate=""
                                    enctype="multipart/form-data">
                        @csrf
                    <div class="row">
                        <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-8 cpl-sm-12 col-xs-12 add-article form-main-sec ">
                            <div class="card Recent-Users">
                                <h5>General Settings</h5>
                                <div class="card-block px-0 py-3">
                                        <div class="row form-sec">
                                            <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12 label-sec">
                                                <input type="hidden" name="setting_id"
                                                    value="{{ isset($setting->id) ? $setting->id : '' }}">
                                                <label for="">Site Title <span style="color: red;margin: 0;">*</span></label>
                                            </div>
                                            <div class="col-xxl-10 col-xl-10 col-lg-10 col-md-10 col-sm-12 col-xs-12">
                                                <input type="text" name="title" id="title" placeholder="Site Title" required
                                                data-parsley-required-message="Please Enter Name" value="{{ isset($setting->site_title) ? $setting->site_title : '' }}">
                                            </div>
                                        </div>
                                        <div class="row form-sec">
                                            <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12 label-sec">
                                                <label for="">Site
                                                    Tagline <span style="color: red;margin: 0;">*</span></label>
                                            </div>
                                            <div class="col-xxl-10 col-xl-10 col-lg-10 col-md-10 col-sm-12 col-xs-12">
                                                <input type="text" name="tagline" id="tagline" placeholder="Site Tagline" required
                                                data-parsley-required-message="Please Enter Site Tagline" value="{{ isset($setting->site_tagline) ? $setting->site_tagline : '' }}">
                                            </div>
                                        </div>
                                      <!--   <div class="row form-sec">
                                            <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12 label-sec">
                                                <label for="">Site URL <span style="color: red;margin: 0;">*</span></label>
                                            </div>
                                            <div class="col-xxl-10 col-xl-10 col-lg-10 col-md-10 col-sm-12 col-xs-12">
                                                <input type="text" name="url" id="url" required
                                                data-parsley-required-message="Please Enter Site URL" value="{{ isset($setting->site_url) ? $setting->site_url : '' }}" placeholder="Site URL">
                                            </div>
                                        </div> -->
                                        <div class="row form-sec">
                                            <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12 label-sec">
                                                <label for="">E-Mail 1<span style="color: red;margin: 0;">*</span></label>
                                            </div>
                                            <div class="col-xxl-10 col-xl-10 col-lg-10 col-md-10 col-sm-12 col-xs-12">
                                                <input type="text" name="email1" id="email1" class="" placeholder="E-Mail" required
                                                data-parsley-required-message="Please Enter E-Mail" value="{{ isset($setting->email) ? $setting->email : '' }}" >
                                            </div>
                                        </div>
                                        <div class="row form-sec">
                                            <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12 label-sec">
                                                <label for="">E-Mail 2</label>
                                            </div>
                                            <div class="col-xxl-10 col-xl-10 col-lg-10 col-md-10 col-sm-12 col-xs-12">
                                                <input type="text" name="email2" id="email2" class="" placeholder="E-Mail" 
                                                 value="{{ isset($setting->email2) ? $setting->email2 : '' }}" >
                                            </div>
                                        </div>
                                        <div class="row form-sec">
                                            <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12 label-sec">
                                                <label for="">Contact No <span style="color: red;margin: 0;">*</span></label>
                                            </div>
                                            <div class="col-xxl-10 col-xl-10 col-lg-10 col-md-10 col-sm-12 col-xs-12">
                                                <input type="text" name="contact_no" id="contact_no" class="imput-mask" placeholder="Contact No" required
                                                data-parsley-required-message="Please Enter Contact No" value="{{ isset($setting->contact_no) ? $setting->contact_no : '' }}" >
                                            </div>
                                        </div>
                                        <div class="row form-sec">
                                            <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12 label-sec">
                                                <label for="">Address <span style="color: red;margin: 0;">*</span></label>
                                            </div>
                                            <div class="col-xxl-10 col-xl-10 col-lg-10 col-md-10 col-sm-12 col-xs-12">
                                               <!--  <input type="text" name="location" id="location" class="" placeholder="Location" required
                                                data-parsley-required-message="Please Enter Location" value="{{ isset($setting->location) ? $setting->location : '' }}" > -->
                                                <textarea class="form-control" id="location" name="location" style="height: 150px;" data-parsley-required="true" data-parsley-required-message="Please enter Address" data-parsley-errors-container="#address_required">{{ isset($setting->location) ? $setting->location : '' }}</textarea>
                                                <span id="address_required"></span>
                                            </div>
                                        </div>
                                        <div class="row form-sec">
                                            <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12 label-sec">
                                                <label for="">Content <span style="color: red;margin: 0;">*</span></label>
                                            </div>
                                            <div class="col-xxl-10 col-xl-10 col-lg-10 col-md-10 col-sm-12 col-xs-12">
                                                <textarea class="form-control" id="code_preview0" name="content" style="height: 300px;" data-parsley-required="true" data-parsley-required-message="Please enter Content" data-parsley-errors-container="#content_required">{{ isset($setting->content) ? $setting->content : '' }}</textarea>
                                                <span id="content_required"></span>
                                            </div>
                                        </div>
                                        <div class="row form-sec">
                                            <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12 label-sec">
                                                <label for="">Footer Text </label>
                                            </div>
                                            <div class="col-xxl-10 col-xl-10 col-lg-10 col-md-10 col-sm-12 col-xs-12">
                                                <textarea class="form-control" id="" name="footer_text" style="height: 100px;" >{{ isset($setting->footer_text) ? $setting->footer_text : '' }}</textarea>
                                            </div>
                                        </div>
                                        <div class="row form-sec">
                                            <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12 label-sec">
                                                <label for="">Map </label>
                                            </div>
                                            <div class="col-xxl-10 col-xl-10 col-lg-10 col-md-10 col-sm-12 col-xs-12">
                                                <textarea class="form-control" id="map" name="map" style="height: 200px;"  >{{ isset($setting->map) ? $setting->map : '' }}</textarea>
                                            </div>
                                        </div>
                                        <div class="row form-sec">
                                            <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12 label-sec">
                                                <label for="">Copyright Text </label>
                                            </div>
                                            <div class="col-xxl-10 col-xl-10 col-lg-10 col-md-10 col-sm-12 col-xs-12">
                                                <textarea class="form-control" id="copyright" name="copyright" style="height: 200px;"  >{{ isset($setting->copyright) ? $setting->copyright : '' }}</textarea>
                                            </div>
                                        </div>
                                        <div class="row form-sec">
                                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 label-sec">
                                                <button type="submit" id="submit_form" class="btn btn-primary">Save</button>
                                            </div>
                                        </div>
                                </div>  
                            </div>
                        </div>

                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 cpl-sm-12 col-xs-12 add-article form-main-sec right-sec">
                            <div class="card Recent-Users next-box" style="margin-top: 0 !important;">
                                <h5>Site Logo</h5>
                                <div class="card-block px-0 py-3">
                                        <div class="row form-sec">
                                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 label-sec">
                                                <div class="upload-img-sec text-center">
                                                    <input type="hidden" name="site_logo" id="img_id" value="{{ isset($setting->site_logo) ? $setting->site_logo : '' }}" required data-parsley-errors-container="#site_img_required"data-parsley-trigger="change" data-parsley-required-message="Please choose an image.">
                                                    @if(isset($setting->site_logo) && $setting->site_logo != '' && $setting->site_logo != null)
                                                    @php
                                                        $img = App\Models\MediaImage::select('name')->where('id', $setting->site_logo)->first();
                                                    @endphp
                                                    @if(isset($img->name) && $img->name != '')
                                                    <div class="image_preview_div">
                                                    <img src="{{ asset('uploads/'.$img->name) }}" alt="" id="profile_avtar" class="profile-img" id="profile_avtar"> 
                                                    <a id="remove_image"> <i class="fa fa-times" aria-hidden="true"></i></a>
                                                    </div>
                                                    @else
                                                    <div class="image_preview_div">
                                                    <img src="{{ asset('assets/images/user/img-demo_1041.jpg') }}" alt="" id="profile_avtar" class="profile-img"> 
                                                    <a id="remove_image" style="display: none;"> <i class="fa fa-times" aria-hidden="true"></i></a>
                                                    </div>
                                                    @endif
                                                    @endif
                                                    
                                                    <label for="" style="cursor: pointer;" class="choose_file">Choose image</label>
                                                </div>
                                                <span class="error_field" id="site_img_required"></span>
                                            </div>
                                            
                                        </div>
                                        

                                </div>
                            </div>

                            <div class="card Recent-Users next-box" style="margin-top: 0 !important;">
                                <h5>Footer Logo</h5>
                                <div class="card-block px-0 py-3">
                                        <div class="row form-sec">
                                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 label-sec">
                                                <div class="upload-img-sec text-center">
                                                    <input type="hidden" name="footer_logo" id="footer_img_id" value="{{ isset($setting->footer_logo) ? $setting->footer_logo : '' }}" required data-parsley-errors-container="#footer_img_required"data-parsley-trigger="change" data-parsley-required-message="Please choose an image.">
                                                    @if(isset($setting->footer_logo) && $setting->footer_logo != '' && $setting->footer_logo != null)
                                                    @php
                                                        $img = App\Models\MediaImage::select('name')->where('id', $setting->footer_logo)->first();
                                                    @endphp
                                                    @if(isset($img->name) && $img->name != '')
                                                    <div class="image_preview_div">
                                                    <img src="{{ asset('uploads/'.$img->name) }}" alt="" id="footer_profile_avtar" class="profile-img"> 
                                                    <a id="footer_remove_image"> <i class="fa fa-times" aria-hidden="true"></i></a>
                                                    </div>
                                                    @else
                                                    <div class="image_preview_div">
                                                    <img src="{{ asset('assets/images/user/img-demo_1041.jpg') }}" alt="" 
                                                    id="footer_profile_avtar" class="profile-img"> 
                                                    <a id="footer_remove_image" style="display: none;"> <i class="fa fa-times" aria-hidden="true"></i></a>
                                                    </div>
                                                    @endif
                                                    @else
                                                     <div class="image_preview_div">
                                                    <img src="{{ asset('assets/images/user/img-demo_1041.jpg') }}" alt="" 
                                                    id="footer_profile_avtar" class="profile-img"> 
                                                    <a id="footer_remove_image" style="display: none;"> <i class="fa fa-times" aria-hidden="true"></i></a>
                                                    </div>
                                                    @endif
                                                    
                                                    <label for="" style="cursor: pointer;" data-val="footer_profile_avtar" class="choose_file">Choose image</label>
                                                </div>
                                                <span class="error_field" id="footer_img_required"></span>
                                            </div>
                                            
                                        </div>
                                        

                                </div>
                            </div>


                            <div class="card Recent-Users next-box" style="margin-top: 0 !important;">
                                <h5>Site Favicon</h5>
                                <div class="card-block px-0 py-3">
                                        <div class="row form-sec">
                                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 label-sec">
                                                <div class="upload-img-sec text-center">
                                                    <input type="hidden" name="site_favicon" id="favicon_id" value="{{ isset($setting->site_favicon) ? $setting->site_favicon : '' }}" required data-parsley-errors-container="#site_favicon_img_required"data-parsley-trigger="change" data-parsley-required-message="Please choose an image.">
                                                    @if(isset($setting->site_favicon) && $setting->site_favicon != '' && $setting->site_favicon != null)
                                                    @php
                                                        $img = App\Models\MediaImage::select('name')->where('id', $setting->site_favicon)->first();
                                                    @endphp
                                                    <div class="image_preview_div">
                                                    <img src="{{ asset('uploads/'.$img->name) }}" alt="" id="favicon_avtar" class="profile-img" > 
                                                    <a id="remove_favi_image"> <i class="fa fa-times" aria-hidden="true"></i></a>
                                                    </div>
                                                    @else
                                                    <div class="image_preview_div">
                                                    <img src="{{ asset('assets/images/user/img-demo_1041.jpg') }}" alt="" id="favicon_avtar" class="profile-img"> 
                                                    <a id="remove_favi_image" style="display: none;"> <i class="fa fa-times" aria-hidden="true"></i></a>
                                                    </div>
                                                    @endif
                                                    
                                                    <label for="" style="cursor: pointer;" class="choose_file" data-val="faviconimg">Choose image</label>
                                                </div>
                                                <span class="error_field" id="site_favicon_img_required"></span>
                                            </div>
                                            
                                        </div>
                                        

                                </div>
                            </div>
                            <div class="card Recent-Users next-box" style="margin-top: 0 !important;">
                                <h5>Social Links</h5>
                                <div class="card-block px-0 py-3">
                                        <div class="row form-sec">
                                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 label-sec">
                                                <label for="">Facebook</span></label>
                                                <input type="text" name="facebook_url" id="facebook_url" class="" placeholder="Type here"  value="{{ isset($setting->facebook_url) ? $setting->facebook_url : '' }}" >
                                            </div>
                                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 label-sec">
                                                <label for="">Instagram</span></label>
                                                <input type="text" name="insta_url" id="insta_url" class="" placeholder="Type here"  value="{{ isset($setting->insta_url) ? $setting->insta_url : '' }}" >
                                            </div>
                                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 label-sec">
                                                <label for="">Twitter</span></label>
                                                <input type="text" name="twitter_url" id="twitter_url" class="" placeholder="Type here"  value="{{ isset($setting->twitter_url) ? $setting->twitter_url : '' }}" >
                                            </div>
                                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 label-sec">
                                                <label for="">Linked In</span></label>
                                                <input type="text" name="linked_url" id="linked_url" class="" placeholder="Type here"  value="{{ isset($setting->linked_url) ? $setting->linked_url : '' }}" >
                                            </div>
                                        </div>
                                        

                                </div>
                            </div>

                            <div class="card Recent-Users next-box" style="margin-top: 0 !important;">
                                <h5>CTA Section Setting</h5>
                                <div class="card-block px-0 py-3">
                                        <div class="row form-sec">
                                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 label-sec">
                                                <label for="">Background Image</span></label>
                                                 <div class="upload-img-sec text-center">
                                                    <input type="hidden" name="bg_img_id_cta" id="bg_img_id_cta" value="{{ isset($setting->cta_image) ? $setting->cta_image : '' }}" required data-parsley-errors-container="#cta_img_required"data-parsley-trigger="change" data-parsley-required-message="Please choose an image.">
                                                    @if(isset($setting->cta_image) && $setting->cta_image != '' && $setting->cta_image != null)
                                                    @php
                                                        $cta_img = App\Models\MediaImage::select('name')->where('id', $setting->cta_image)->first();
                                                    @endphp
                                                    <div class="image_preview_div">
                                                    <img src="{{ asset('uploads/'.$cta_img->name) }}" alt="" id="bg_profile_avtar_cta" class="profile-img" > 
                                                    <a id="bg_remove_image_cta" class="remove_image_media" data-val="bg" data-id="cta"> <i class="fa fa-times" aria-hidden="true"></i></a>
                                                    </div>
                                                    @else
                                                    <div class="image_preview_div">
                                                    <img src="{{ asset('assets/images/user/img-demo_1041.jpg') }}" alt="" id="bg_profile_avtar_cta" class="profile-img"> 
                                                    <a id="bg_remove_image_cta" class="remove_image_media" data-val="bg" data-id="cta" style="display: none;"> <i class="fa fa-times" aria-hidden="true"></i></a>
                                                    </div>
                                                    @endif
                                                    
                                                    <label for="" style="cursor: pointer;" data-val="bg" data-id="cta" class="choose_file" data-val="faviconimg">Choose image</label>
                                                </div>
                                                <span class="error_field" id="cta_img_required"></span>
                                            </div>
                                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 label-sec">
                                                <label for="">Title</span></label>
                                                <input type="text" name="cta_title" id="cta_title" class="" required ata-parsley-required-message="Please Enter Title" placeholder="Title"  value="{{ isset($setting->cta_title) ? $setting->cta_title : '' }}" >
                                            </div>
                                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 label-sec">
                                                <label for="">Button URL</span></label>
                                                <input type="text" name="cta_btn_url" id="cta_btn_url" class="" required ata-parsley-required-message="Please Enter Button URL" data-parsley-type="url" placeholder="Button URL"  value="{{ isset($setting->cta_btn_url) ? $setting->cta_btn_url : '' }}" >
                                            </div>
                                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 label-sec">
                                                <label for="">Button Name</span></label>
                                                <input type="text" name="cta_btn_name" id="cta_btn_name" required ata-parsley-required-message="Please Enter Button Name" class="" placeholder="Button Name"  value="{{ isset($setting->cta_btn_name) ? $setting->cta_btn_name : '' }}" >
                                            </div>
                                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 label-sec">
                                                <label for="">Description</span></label>
                                                <textarea class="form-control" id="cta_description" required="" ata-parsley-required-message="Please Enter Description" data-parsley-errors-container="#cta_description_req" name="cta_description" style="height: 100px;" >{{ isset($setting->cta_description) ? $setting->cta_description : '' }}</textarea>
                                                <span class="error_field" id="cta_description_req"></span>
                                            </div>

                                        </div>
                                        

                                </div>
                            </div>
                           
                        
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
     $('#code_preview0').summernote({height: 300});
     $('#map').summernote({height: 200});
     $('#copyright').summernote({height: 200});
     });
</script>
<script> 
    const assetPath = "{{ asset('assets/images/user/img-demo_1041.jpg') }}";
            $('#remove_image').click(function(event) {
                event.stopPropagation(); 
                $('#img_id').val(null);
                $('#profile_avtar').attr('src', assetPath);
                $('#remove_image').css('display', 'none');
                $('#profile_avtar').css('opacity', '1.0');
            });
            $('#remove_favi_image').click(function(event) {
                event.stopPropagation(); 
                $('#favicon_id').val(null);
                $('#favicon_avtar').attr('src', assetPath);
                $('#remove_favi_image').css('display', 'none');
                $('#favicon_avtar').css('opacity', '1.0');
            });
             $('#footer_remove_image').click(function(event) {
                event.stopPropagation(); 
                $('#footer_img_id').val(null);
                $('#footer_profile_avtar').attr('src', assetPath);
                $('#footer_remove_image').css('display', 'none');
                $('#footer_profile_avtar').css('opacity', '1.0');
            });
    </script>

    <script>
        $(document).ready(function(){
            $('form').parsley({
                excluded: 'input[type=hidden]:not(.visible)'
            });
            $('#submit_form').on('click', function (e) {
                 
                 $('#img_id').addClass('visible');
                 $('#footer_img_id').addClass('visible');
                 $('#site_favicon_img_required').addClass('visible');
                 $('#bg_img_id_cta').addClass('visible');

                // Validate the form
                if (!$('form').parsley().validate()) {
                    e.preventDefault();
                }

                // Hide the hidden input again
               
                $('#img_id').removeClass('visible');
                $('#footer_img_id').removeClass('visible');
                $('#site_favicon_img_required').removeClass('visible');
                $('#bg_img_id_cta').removeClass('visible');

            });
        })
    </script>
@endsection
