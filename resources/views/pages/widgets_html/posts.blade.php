<div class="tab-pane fade active show" id="widget-content" role="tabpanel" aria-labelledby="widget-content-tab">
    <div class="form-group">
        <label>Post Type</label>
        <select class="form-control" name="post_type" id="posts_type">
            <option>None</option>
            <option value="0">Recent Posts</option>
            <option value="1">Featured Posts</option>
            <option value="2">Category Wise</option>
        </select>
    </div>
    <div class="form-group" id="post_cat_div" style="display: none;">
        <label>Select Category</label>
        <select class="form-control" name="post_cat_div">
            <option>None</option>
            @if(isset($categories) && count($categories))
            @foreach($categories as $val)
            <option value="{{ $val->id }}">{{ $val->category }}</option>
            @endforeach
            @endif
        </select>
    </div>
    <div class="form-group">
        <label>Post Style</label>
        <select class="form-control" name="post_style">
            <option>None</option>
            <option value="0">Slider</option>
            <option value="1">Grid</option>
        </select>
    </div>
    <div>
        <label>Post Column</label>
        <div class="btn-group" data-toggle="buttons">
            <label class="btn btn-primary sm active post_column_lable">
                <input type="radio" class="d-none" name="P_column"  value="col-12">
                <img src="{{ asset('assets/images/1column.png') }}" class="img-fluid">
            </label>
            <label class="btn btn-primary sm post_column_lable">
                <input type="radio" class="d-none" name="P_column"  value="col-6">
                <img src="{{ asset('assets/images/2column.png') }}" class="img-fluid">
            </label>
            <label class="btn btn-primary sm post_column_lable">
                <input type="radio" class="d-none" name="P_column"  value="col-4">
                <img src="{{ asset('assets/images/3column.png') }}" class="img-fluid">
            </label>
        </div>
    </div>
    <div class="form-group">
        <label>Post Count</label>
        <input type="text" class="form-control" placeholder="Post Count" name="post_count">
    </div>
    
</div>
<div class="tab-pane fade" id="widget-style" role="tabpanel" aria-labelledby="widget-style-tab">
    <div class="form-group">
        <label>Title Color</label>
    </div>
    <div class="d-flex background-color-sec">
        <input type="text" class="form-control" placeholder="#000000" id="post-title-color-id" name="post_t_color">
        <div class="">
            <input type="color" class="form-control" id="post-title-color-picker-id">
        </div>
    </div>
    <div class="form-group">
        <label>Title Hover Color</label>
    </div>
    <div class="d-flex background-color-sec">
        <input type="text" class="form-control" placeholder="#000000" id="post-titlehover-color-id" name="post_th_color">
        <div class="">
            <input type="color" class="form-control" id="post-titlehover-color-picker-id">
        </div>
    </div>
    <div class="form-group">
        <label>Subtitle Color</label>
    </div>
    <div class="d-flex background-color-sec">
        <input type="text" class="form-control" placeholder="#000000" id="post-subtitle-color-id" name="post_st_color">
        <div class="">
            <input type="color" class="form-control" id="post-subtitle-color-picker-id">
        </div>
    </div>
    <div class="form-group">
        <label>Subtitle hover Color</label>
    </div>
    <div class="d-flex background-color-sec">
        <input type="text" class="form-control" placeholder="#000000" id="post-subtitlehover-color-id" name="post_sth_color">
        <div class="">
            <input type="color" class="form-control" id="post-subtitlehover-color-picker-id">
        </div>
    </div>
</div>
<div class="tab-pane fade" id="widget-background" role="tabpanel">
    <div class="form-group">
        <label>Background Color</label>
    </div>
    <div class="d-flex background-color-sec">
        <input type="text" class="form-control" placeholder="#000000" id="post-background-color-id" name="post_bg_color">
        <div class="">
            <input type="color" class="form-control" id="post-background-color-picker-id">
        </div>
    </div>
    <div class="form-group">
        <label>Background Image</label>
    </div>
    <div class="row form-sec">
        <div
            class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 label-sec">
            <div class="upload-img-sec">
                <input type="hidden" name="post_bg_img" id="we_po_back_img_id_we_po_back_id"
                    value="{{ isset($article->image) ? $article->image : '' }}">
                <div class="image_preview_div">
                    <img src="{{ asset('assets/images/user/img-demo_1041.jpg') }}"
                        alt="" id="we_po_back_profile_avtar_we_po_back_id"
                        class="profile-img" style="width:130px;">
                    <a id="we_po_back_remove_image_we_po_back_id" class="remove_image_media"
                        style="display: none;" data-val="we_po_back" data-id="we_po_back_id"> <i class="fa fa-times"
                            aria-hidden="true"></i></a>
                </div>
                <label for="" style="cursor: pointer;"
                    class="choose_file" data-val="we_po_back" data-id="we_po_back_id">Choose image</label>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label>Background Size</label>
        <select class="form-control" name="post_bg_size">
            <option>Select</option>
            <option value="cover">cover</option>
            <option value="auto">auto</option>
            <option value="contain">contain</option>
            <option value="initial">initial</option>
            <option value="inherit">inherit</option>
            <option value="unset">unset</option>
        </select>
    </div>
    <div class="form-group">
        <label>Background Position</label>
        <select class="form-control" name="post_bg_position">
            <option>Select</option>
            <option value="bottom">bottom</option>
            <option value="center">center</option>
            <option value="inherit">inherit</option>
            <option value="initial">initial</option>
            <option value="left">left</option>
            <option value="right">right</option>
            <option value="top">top</option>
            <option value="top">unset</option>
        </select>
    </div>
    <div class="form-group">
        <label>Background Repeat</label>
        <select class="form-control" name="post_bg_repeate">
            <option>Select</option>
            <option value="no-repeat">no-repeat</option>
            <option value="repeat">repeat</option>
        </select>
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
