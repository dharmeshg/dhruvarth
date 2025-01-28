<div class="accordion-body">
 <div class="row"> 
    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="row form-sec">
            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 label-sec">
                <label for="">Title</label>
            </div>
            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <input type="text" name="about_title" id="about_title" placeholder="Title" data-parsley-required-message="Please Enter Title" value="{{ isset($about->about_title) ? $about->about_title : '' }}">
            </div>
        </div>
        <div class="row form-sec">
            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 label-sec">
                <label for="">Sub Title </label>
            </div>
            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <input type="text" name="about_sub_title" id="about_sub_title" placeholder="Sub Title"  data-parsley-required-message="Please Enter Sub Title" value="{{ isset($about->about_sub_title) ? $about->about_sub_title : '' }}">
            </div>
        </div>
        <div class="row form-sec">
            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 label-sec">
                <label for="">Button Name</label>
            </div>
            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
             <input type="text" name="about_button_name" id="about_button_name" placeholder="Button Name"  value="{{ isset($about->about_button_name) ? $about->about_button_name : '' }}" data-parsley-required-message="Please Enter Button Name">
         </div>
     </div>
     <div class="row form-sec">
        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 label-sec">
            <label for="">Button Url</label>
        </div>
        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
         <input type="text" name="about_button_url" id="about_button_url" placeholder="Button Url"  value="{{ isset($about->about_button_url) ? $about->about_button_url : '' }}" data-parsley-required-message="Please Enter Button Url">
     </div>
 </div>
 <div class="row form-sec">
    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 label-sec">
        <div class="upload-img-sec">
            <input type="hidden" name="site_favicon" id="favicon_id" value="{{ isset($about->about_background_img) ? $about->about_background_img : '' }}">
            @if(isset($about->about_background_img) && $about->about_background_img != '' && $about->about_background_img != null)
            @php
            $img = App\Models\MediaImage::select('name')->where('id', $about->about_background_img)->first();
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
            @if(isset($about->about_background_img) && $about->about_background_img != '' && $about->about_background_img != null)
            
            @else
            <span id="favicon_alert" class="parsley-required" style="font-weight: 500 !important;color: red !important;">Please Add Image </span>
            @endif
        </div>
    </div>

</div>
</div>
<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
    <div class="row form-sec">
        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 label-sec">
            <label for="">Description</label>
        </div>
        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
         <textarea class="form-control" id="code_preview0" name="about_content" style="height: 300px;"  data-parsley-errors-container="#content_required" data-parsley-required-message="Please Enter Description">{{ isset($about->about_content) ? $about->about_content : '' }}</textarea>
         <span id="content_required" class="parsley-required" style="font-weight: 500 !important;"></span>
     </div>
 </div>


</div>
</div>
</div>