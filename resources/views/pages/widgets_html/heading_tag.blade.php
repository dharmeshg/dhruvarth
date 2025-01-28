<div class="tab-pane fade active show" id="widget-content" role="tabpanel" aria-labelledby="widget-content-tab">
    <div class="form-group">
        <label>Tag</label>
        <select class="form-control" name="heading_tag">
            <option>Select</option>
            <option value="h1">h1</option>
            <option value="h2">h2</option>
            <option value="h3">h3</option>
            <option value="h4">h4</option>
            <option value="h5">h5</option>
            <option value="h6">h6</option>
            <option value="div">div</option>
            <option value="span">span</option>
            <option value="p">p</option>
        </select>
    </div>
    <div class="form-group">
        <label>Text</label>
        <input type="text" class="form-control" placeholder="Heading Text" name="heading_text">
    </div>
    <div>
        <label>Text Alignment</label>
        <div class="btn-group" data-toggle="buttons">
            <label class="btn btn-primary sm active heading_tag_align">
                <input type="radio" class="d-none" name="t_alignment" id="t_left" value="left">
                Left
            </label>
            <label class="btn btn-primary sm heading_tag_align">
                <input type="radio" class="d-none" name="t_alignment" id="t_center" value="center">
                Center
            </label>
            <label class="btn btn-primary sm heading_tag_align">
                <input type="radio" class="d-none" name="t_alignment" id="t_bottom" value="right">
                Right
            </label>
        </div>
    </div>
</div>
<div class="tab-pane fade" id="widget-style" role="tabpanel" aria-labelledby="widget-style-tab">
    <div class="form-group">
        <label>Color</label>
    </div>
    <div class="d-flex background-color-sec">
        <input type="text" class="form-control" placeholder="#000000" id="back-text-color-id" name="text_color">
        <div class="">
            <input type="color" class="form-control" id="back-text-color-picker-id">
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
