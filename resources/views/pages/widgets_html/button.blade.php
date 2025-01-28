<div class="tab-pane fade active show" id="widget-content" role="tabpanel" aria-labelledby="widget-content-tab">
    <div class="form-group">
        <label>Text</label>
        <input type="text" class="form-control" placeholder="Button Text" name="button_text">
    </div>
    <div class="form-group">
        <label>Link</label>
        <input type="text" class="form-control" placeholder="Button Url" name="button_link">
    </div>
    <div class="form-group d-flex">
        <input type="checkbox" class="" name="target_blank" style="margin-right: 10px;">Open in new window
    </div>
    <div>
        <label>Button Alignment</label>
        <div class="btn-group" data-toggle="buttons">
            <label class="btn btn-primary sm active button_alignment">
                <input type="radio" class="d-none" name="b_alignment" id="v_left" value="left">
                Left
            </label>
            <label class="btn btn-primary sm button_alignment">
                <input type="radio" class="d-none" name="b_alignment" id="v_center" value="center">
                Center
            </label>
            <label class="btn btn-primary sm button_alignment">
                <input type="radio" class="d-none" name="b_alignment" id="v_bottom" value="right">
                Right
            </label>
            <label class="btn btn-primary sm button_alignment">
                <input type="radio" class="d-none" name="b_alignment" id="v_justigy" value="justify">
                Justify
            </label>
        </div>
    </div>
</div>
<div class="tab-pane fade" id="widget-style" role="tabpanel" aria-labelledby="widget-style-tab">
    <ul class="nav nav-tabs mb-3 p-0" id="style-tab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active show" id="widget-content-tab" data-toggle="tab" href="#widget-style-normal"
                role="tab" aria-controls="widget-style-normal" aria-selected="true">Normal</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="widget-style-tab" data-toggle="tab" href="#widget-style-hover" role="tab"
                aria-controls="widget-style-hover" aria-selected="false">Hover</a>
        </li>
    </ul>
    <div class="tab-content" id="style-tabs">
        <div class="tab-pane fade active show" id="widget-style-normal" role="tabpanel"
            aria-labelledby="widget-style-normal">
            <div class="form-group">
                <label>Text Color</label>
            </div>
            <div class="d-flex background-color-sec">
                <input type="text" class="form-control" placeholder="#000000" id="normal-text-color-id"
                    name="normal_text_color">
                <div class="">
                    <input type="color" class="form-control" id="normal-text-color-picker-id">
                </div>
            </div>
            <div class="form-group">
                <label>Background Color</label>
            </div>
            <div class="d-flex background-color-sec">
                <input type="text" class="form-control" placeholder="#000000" id="normal-background-color-id"
                    name="normal_bg_color">
                <div class="">
                    <input type="color" class="form-control" id="normal-color-picker-id">
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="widget-style-hover" role="tabpanel" aria-labelledby="widget-style-hover">
            <div class="form-group">
                <label>Text Color</label>
            </div>
            <div class="d-flex background-color-sec">
                <input type="text" class="form-control" placeholder="#000000" id="hover-text-color-id"
                    name="hover_text_color">
                <div class="">
                    <input type="color" class="form-control" id="hover-text-color-picker-id">
                </div>
            </div>
            <div class="form-group">
                <label>Background Color</label>
            </div>
            <div class="d-flex background-color-sec">
                <input type="text" class="form-control" placeholder="#000000" id="hover-background-color-id"
                    name="hover_bg_color">
                <div class="">
                    <input type="color" class="form-control" id="hover-color-picker-id">
                </div>
            </div>
        </div>
    </div>
    <div class="form-row mb-20">
        <label class="col-3 font-14 bold black my-auto">Font Size </label>
        <div class="col-5 offset-3">
            <div class="input-group addon">
                <input type="text" class="form-control radius-0" name="font_size_c_" placeholder="00"
                    value="">
                <div class="input-group-append">
                    <span class="input-group-text style--three black bold">px</span>
                </div>
            </div>
        </div>
    </div>
    <div class="form-row mb-4">
        <div class="col-sm-12">
            <label class="font-14 bold black">Button Padding </label>
        </div>
        <div class="col-sm-3">
            <div class="input-group addon">
                <input type="text" class="form-control radius-0 bottom-padding-input" name="button_padding_top_c_"
                    placeholder="00" value="">
                <div class="input-group-append">
                    <span class="input-group-text style--three black bold bottom-padding-span">px</span>
                </div>
            </div>
            <small>Top</small>
        </div>
        <div class="col-sm-3">
            <div class="input-group addon">
                <input type="text" class="form-control radius-0 bottom-padding-input"
                    name="button_padding_right_c_" placeholder="00" value="">
                <div class="input-group-append">
                    <span class="input-group-text style--three black bold bottom-padding-span">px</span>
                </div>
            </div>
            <small>Right</small>
        </div>
        <div class="col-sm-3">
            <div class="input-group addon">
                <input type="text" class="form-control radius-0 bottom-padding-input"
                    name="button_padding_bottom_c_" placeholder="00" value="">
                <div class="input-group-append">
                    <span class="input-group-text style--three black bold bottom-padding-span">px</span>
                </div>
            </div>
            <small>Bottom</small>
        </div>
        <div class="col-sm-3">
            <div class="input-group addon">
                <input type="text" class="form-control radius-0 bottom-padding-input"
                    name="button_padding_left_c_" placeholder="00" value="">
                <div class="input-group-append">
                    <span class="input-group-text style--three black bold bottom-padding-span">px</span>
                </div>
            </div>
            <small>Left</small>
        </div>
    </div>
    <div class="form-row mb-20">
        <label class="col-3 font-14 bold black my-auto">Radius </label>
        <div class="col-5 offset-3">
            <div class="input-group addon">
                <input type="text" class="form-control radius-0" name="radius" placeholder="00" value="">
                <div class="input-group-append">
                    <span class="input-group-text style--three black bold">px</span>
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
        <input type="text" class="form-control" placeholder="#000000" id="back-text-color-id" name="bg_color">
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
