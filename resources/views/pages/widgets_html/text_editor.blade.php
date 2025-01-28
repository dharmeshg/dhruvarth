<div class="tab-pane fade active show" id="widget-content" role="tabpanel" aria-labelledby="widget-content-tab">
    <div class="form-group">
        <label>Editor</label>
        <textarea class="form-control" id="text_content" name="text_content" style="height: 300px;">
        </textarea>
    </div>
    <div>
        <label>Text Alignment</label>
        <div class="btn-group" data-toggle="buttons">
            <label class="btn btn-primary sm active editor_alignment">
                <input type="radio" class="d-none" name="t_alignment" id="t_left" value="left">
                Left
            </label>
            <label class="btn btn-primary sm editor_alignment">
                <input type="radio" class="d-none" name="t_alignment" id="t_center" value="center">
                Center
            </label>
            <label class="btn btn-primary sm editor_alignment">
                <input type="radio" class="d-none" name="t_alignment" id="t_bottom" value="right">
                Right
            </label>
            <label class="btn btn-primary sm editor_alignment">
                <input type="radio" class="d-none" name="t_alignment" id="t_bottom" value="right">
                Justify
            </label>
        </div>
    </div>
</div>

<div class="tab-pane fade" id="widget-background" role="tabpanel">
    <div class="form-group">
        <label>Background Color</label>
    </div>
    <div class="d-flex background-color-sec">
        <input type="text" class="form-control" placeholder="#000000" id="back-text-color-id" name="text_bg_color">
        <div class="">
            <input type="color" class="form-control" id="back-text-color-picker-id">
        </div>
    </div>
    <div class="form-group">
        <label>Background Image</label>
    </div>
    <div class="row form-sec">
        <div
            class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 label-sec">
            <div class="upload-img-sec">
                <input type="hidden" name="text_bg_img" id="we_edi_back_img_id_we_edi_back_id"
                    value="{{ isset($article->image) ? $article->image : '' }}">
                <div class="image_preview_div">
                    <img src="{{ asset('assets/images/user/img-demo_1041.jpg') }}"
                        alt="" id="we_edi_back_profile_avtar_we_edi_back_id"
                        class="profile-img" style="width:130px;">
                    <a id="remove_edi_img" class="remove_image_media"
                        style="display: none;" data-val="we_edi_back" data-id="we_edi_back_id"> <i class="fa fa-times"
                            aria-hidden="true"></i></a>
                </div>
                <label for="" style="cursor: pointer;"
                    class="choose_file" data-val="we_edi_back" data-id="we_edi_back_id">Choose image</label>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label>Background Size</label>
        <select class="form-control" name="text_bg_size">
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
        <select class="form-control" name="text_bg_position">
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
        <select class="form-control" name="text_bg_repeate">
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
