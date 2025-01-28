<div class="accordion-body">
   <div class="row"> 
    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="row form-sec">
            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 label-sec">
                <label for="">Title</label>
            </div>
            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <input type="text" name="story_title" id="story_title" placeholder="Title"  value="{{ isset($story->story_title) ? $story->story_title : '' }}" data-parsley-required-message="Please Enter Title">
            </div>
        </div>
        <div class="row form-sec">
            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 label-sec">
                <label for="">Sub Title </label>
            </div>
            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <input type="text" name="story_sub_title" id="story_sub_title" placeholder="Sub Title"  value="{{ isset($story->story_sub_title) ? $story->story_sub_title : '' }}" data-parsley-required-message="Please Enter Sub Title">
            </div>
        </div>
        <div class="row form-sec">
            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 label-sec">
                <label for="">Button Name</label>
            </div>
            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
               <input type="text" name="story_button_name" id="story_button_name" placeholder="Button Name"  value="{{ isset($story->story_button_name) ? $story->story_button_name : '' }}" data-parsley-required-message="Please Enter Button Name">
               <span id="content_required"></span>
           </div>
       </div>
       <div class="row form-sec">
        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 label-sec">
            <label for="">Button Url</label>
        </div>
        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
           <input type="text" name="story_button_url" id="story_button_url" placeholder="Button Url"  value="{{ isset($story->story_button_url) ? $story->story_button_url : '' }}" data-parsley-required-message="Please Enter Button Url">
           
       </div>
   </div>
   <div class="row">
    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
   <div class="row form-sec">
    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 label-sec">
        <label for="">Image 1</label>
        <div class="upload-img-sec">
            <input type="hidden" name="img_1" id="img_id" value="{{ isset($story->story_img_1) ? $story->story_img_1 : '' }}">
            @if(isset($story->story_img_1) && $story->story_img_1 != '' && $story->story_img_1 != null)
            @php
            $img = App\Models\MediaImage::select('name')->where('id', $story->story_img_1)->first();
            @endphp
            <div class="image_preview_div">
                <img src="{{ asset('uploads/'.$img->name) }}" alt="" id="profile_avtar" class="profile-img" > 
                <a id="remove_image"> <i class="fa fa-times" aria-hidden="true"></i></a>
            </div>
            @else
            <div class="image_preview_div">
                <img src="{{ asset('assets/images/user/img-demo_1041.jpg') }}" alt="" id="profile_avtar" class="profile-img"> 
                <a id="remove_image" style="display: none;"> <i class="fa fa-times" aria-hidden="true"></i></a>
            </div>
             @endif

            <label for="" style="cursor: pointer;" class="choose_file">Choose image</label>
            @if(isset($story->story_img_1) && $story->story_img_1 != '' && $story->story_img_1 != null)
            
            @else
            <span id="img_alert" class="parsley-required" style="font-weight: 500 !important;color: red !important;">Please Add Image </span>
            @endif
        </div>
    </div>
    
</div>
</div>
<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
   <div class="row form-sec">
    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 label-sec">
        <label for="">Image 2</label>
        <div class="upload-img-sec">
            <input type="hidden" name="img_2" id="story_img_id" value="{{ isset($story->story_img_2) ? $story->story_img_2 : '' }}">
            @if(isset($story->story_img_2) && $story->story_img_2 != '' && $story->story_img_2 != null)
            @php
            $img = App\Models\MediaImage::select('name')->where('id', $story->story_img_2)->first();
            @endphp
            <div class="image_preview_div">
                <img src="{{ asset('uploads/'.$img->name) }}" alt="" id="profile_avtar_story" class="profile-img" > 
                <a id="story_remove_image"> <i class="fa fa-times" aria-hidden="true"></i></a>
            </div>
            @else
            <div class="image_preview_div">
                <img src="{{ asset('assets/images/user/img-demo_1041.jpg') }}" alt="" id="profile_avtar_story" class="profile-img"> 
                <a id="story_remove_image" style="display: none;"> <i class="fa fa-times" aria-hidden="true"></i></a>
            </div>
             @endif

            <label for="" style="cursor: pointer;" class="choose_file" data-val="story_img">Choose image</label>
            @if(isset($story->story_img_1) && $story->story_img_1 != '' && $story->story_img_1 != null)
            @else
            <span id="img_alert1" class="parsley-required" style="font-weight: 500 !important;color: red !important;">Please Add Image </span>
            @endif
        </div>
    </div>
    
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
           <textarea class="form-control" id="code_preview2" name="story_content" style="height: 300px;" data-parsley-errors-container="#content_required1" data-parsley-required-message="Please Enter Content">{{ isset($story->story_content) ? $story->story_content : '' }}</textarea>
           <span id="content1_required" class="parsley-required" style="font-weight: 500 !important;"></span>
       </div>
   </div>
   <div class="row form-sec">
        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 label-sec">
            <label for="">Story Tagline</label>
        </div>
        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
           <input type="text" name="story_tagline" id="story_tagline" placeholder="Button Url"  value="{{ isset($story->story_tagline) ? $story->story_tagline : '' }}" data-parsley-required-message="Please Enter Button Url">
           
       </div>
   </div>
   <div class="row form-sec">
        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 label-sec">
            <label for="">Date</label>
        </div>
        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
           <input type="text" name="story_date" id="story_date" placeholder="Button Url"  value="{{ isset($story->story_date) ? $story->story_date : '' }}" data-parsley-required-message="Please Enter Button Url">
           
       </div>
   </div>

</div>
</div>
</div>