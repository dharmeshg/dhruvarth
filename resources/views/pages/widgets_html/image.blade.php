<div class="tab-pane fade active show" id="widget-content" role="tabpanel" aria-labelledby="widget-content-tab">
    <div class="form-group">
        <label>Image</label>
    </div>
    <div class="row form-sec">
        <div
            class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 label-sec">
            <div class="upload-img-sec">
                <input type="hidden" name="sec_bg_img" id="we_img_back_img_id_we_img_back_id"
                    value="">
                <div class="image_preview_div">
                    <img src="{{ asset('assets/images/user/img-demo_1041.jpg') }}"
                        alt="" id="we_img_back_profile_avtar_we_img_back_id"
                        class="profile-img" style="width:130px;">
                    <a id="remove_sec_image" class="remove_image_media"
                        style="display: none;" data-val="we_img_back" data-id="we_img_back_id"> <i class="fa fa-times"
                            aria-hidden="true" ></i></a>
                </div>
                <label for="" style="cursor: pointer;"
                    class="choose_file" data-val="we_img_back" data-id="we_img_back_id">Choose image</label>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label>Alt Name</label>
        <input type="text" class="form-control" placeholder="Alt Name" name="img_alt_name">
    </div>
    <div class="form-group">
        <label>Link</label>
        <select class="form-control" name="img_link" id="img_link">
            <option>None</option>
            <option value="media_file">Media File</option>
            <option value="custom_url">Custom Url</option>
        </select>
    </div>
    <div class="form-group" id="hide_url" style="display: none;">
        <input type="text" class="form-control" placeholder="Your Link" name="img_custom_link">
    </div>
    <div class="form-group d-flex">
        <input type="checkbox" class="" style="margin-right: 10px;" name="target_blank">Open in new window
    </div>
    <div>
        <label>Image Alignment</label>
        <div class="btn-group" data-toggle="buttons">
            <label class="btn btn-primary sm active image_alignment">
                <input type="radio" class="d-none" name="i_alignment" id="t_left" value="left">
                Left
            </label>
            <label class="btn btn-primary sm image_alignment">
                <input type="radio" class="d-none" name="i_alignment" id="t_center" value="center">
                Center
            </label>
            <label class="btn btn-primary sm image_alignment">
                <input type="radio" class="d-none" name="i_alignment" id="t_bottom" value="right">
                Right
            </label>
        </div>
    </div>
</div>
<div class="tab-pane fade" id="widget-style" role="tabpanel" aria-labelledby="widget-style-tab">
    <label>Width</label>
    <div class="col-12">
        <div class="row align-items-center">
            <input type="range" class="col-sm-8 range-selector" id="range_width" style="height: 30%;" min="1" max="1000" value="">
            <div class="col-sm-4 input-group addon">
                <input type="text" class="form-control bottom-padding-input" name="img_width" min="1" max="1000" id="height_c_" value="">
                <div class="input-group-append">
                    <span class="input-group-text style--three black bold bottom-padding-span">px</span>
                </div>
            </div>
        </div>
    </div>
    <label>Max Width</label>
    <div class="col-12">
        <div class="row align-items-center">
            <input type="range" class="col-sm-8 range-selector" id="range_width" style="height: 30%;" min="1" max="1000" value="">
            <div class="col-sm-4 input-group addon">
                <input type="text" class="form-control bottom-padding-input" name="img_max_width" min="1" max="1000" id="height_c_" value="">
                <div class="input-group-append">
                    <span class="input-group-text style--three black bold bottom-padding-span">px</span>
                </div>
            </div>
        </div>
    </div>
    <label>Height</label>
    <div class="col-12">
        <div class="row align-items-center">
            <input type="range" class="col-sm-8 range-selector" id="range_width" style="height: 30%;" min="1" max="1000" value="">
            <div class="col-sm-4 input-group addon">
                <input type="text" class="form-control bottom-padding-input" name="img_height" min="1" max="1000" id="height_c_" value="">
                <div class="input-group-append">
                    <span class="input-group-text style--three black bold bottom-padding-span">px</span>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="tab-pane fade" id="widget-background" role="tabpanel">
    <div class="form-group">
        <label>Background Color</label>
    </div>
    <div class="d-flex background-color-sec">
        <input type="text" class="form-control" placeholder="#000000" id="back-text-color-id" name="img_bg_color">
        <div class="">
            <input type="color" class="form-control" id="back-text-color-picker-id">
        </div>
    </div>
</div>
<div class="tab-pane fade" id="widget-advance" role="tabpanel" aria-labelledby="widget-advance-tab">
    <div class="form-group">
        <label>Add Class name</label>
        <input type="text" class="form-control" name="widget_class">
    </div>
    <div class="form-group">
        <label>Add ID name</label>
        <input type="text" class="form-control" name="widget_id">
    </div>
</div>
