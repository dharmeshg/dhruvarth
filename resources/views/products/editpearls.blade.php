<div class="diamond-deatils-sec @if(isset($key) && $key != 0) mt-4 @endif">
    <div class="row each-diamond-details">
        
        <a><span class="remove_details" data-type="pearl"><i class="fa fa-times-circle"></i></span></a>
        
        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 sub-heading">
            <h3>Pearl Details</h3>
        </div>
         <input type="hidden" name="attr_pearl_hidden[]" value="true">
        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="form-sec">
                <label for="">Type <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select type for pearl"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                <select name="attr_pearl_type[]" class="form-control">
                    <option selected="" disabled>Select</option>
                    @if(isset($pearl_natures) && count($pearl_natures) > 0)
                    @foreach($pearl_natures as $pearl_nature)
                    <option value="{{ $pearl_nature->title }}" {{ isset($pearl->attr_pearl_type) && $pearl->attr_pearl_type == $pearl_nature->title ? 'selected' : ''}}>{{ isset($pearl_nature->title) ? $pearl_nature->title : '' }}</option>
                    @endforeach
                    @endif
                </select>
            </div>
        </div>

        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="form-sec">
                <label for="">Colour <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select colour for pearl"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                <select name="attr_pearl_color[]" class="form-control">
                    <option selected="" disabled>Select</option>
                    @if(isset($pearl_colors) && count($pearl_colors) > 0)
                    @foreach($pearl_colors as $pearl_color)
                    <option value="{{ $pearl_color->title }}" {{ isset($pearl->attr_pearl_color) && $pearl->attr_pearl_color == $pearl_color->title ? 'selected' : ''}}>{{ isset($pearl_color->title) ? $pearl_color->title : '' }}</option>
                    @endforeach
                    @endif
                </select>
            </div>
        </div>

        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 pearl_caret_sec">
            <div class="form-sec">
                <label for="">Carat Per Pearl <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter carat for individual  pearl"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                <input type="number" step="0.0001" class="form-control attr_pearl_carat" name="attr_pearl_caret[]" id="" placeholder="Enter Carat Per Pearl" value="{{ isset($pearl->attr_pearl_caret) ? $pearl->attr_pearl_caret : '' }}">
            </div>
        </div>

        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="form-sec">
                <label for="">Pearl <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select type of pearl"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                <select name="attr_pearl_gem[]" class="form-control">
                    <option selected="" disabled>Select</option>
                    @if(isset($pearl_pearls) && count($pearl_pearls) > 0)
                    @foreach($pearl_pearls as $pearl_pearl)
                    <option value="{{ $pearl_pearl->title }}" {{ isset($pearl->attr_pearl_gem) && $pearl->attr_pearl_gem == $pearl_pearl->title ? 'selected' : ''}}>{{ isset($pearl_pearl->title) ? $pearl_pearl->title : '' }}</option>
                    @endforeach
                    @endif
                </select>
            </div>
        </div>

        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="form-sec">
                <label for="">Shape <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select shape for pearl"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                <select name="attr_pearl_shape[]" class="form-control">
                    <option selected="" disabled>Select</option>
                    @if(isset($pearl_shapes) && count($pearl_shapes) > 0)
                    @foreach($pearl_shapes as $pearl_shape)
                    <option value="{{ $pearl_shape->title }}" {{ isset($pearl->attr_pearl_shape) && $pearl->attr_pearl_shape == $pearl_shape->title ? 'selected' : ''}}>{{ isset($pearl_shape->title) ? $pearl_shape->title : '' }}</option>
                    @endforeach
                    @endif
                </select>
            </div>
        </div>

        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="form-sec">
                <label for="">Grade <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select grade for pearl"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                <select name="attr_pearl_grade[]" class="form-control">
                    <option selected="" disabled>Select</option>
                    @if(isset($pearl_grades) && count($pearl_grades) > 0)
                    @foreach($pearl_grades as $pearl_grade)
                    <option value="{{ $pearl_grade->title }}" {{ isset($pearl->attr_pearl_grade) && $pearl->attr_pearl_grade == $pearl_grade->title ? 'selected' : ''}}>{{ isset($pearl_grade->title) ? $pearl_grade->title : '' }}</option>
                    @endforeach
                    @endif
                </select>
            </div>
        </div>

        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="form-sec">
                <label for="">Setting <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select setting for pearl"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                <select name="attr_pearl_setting[]" class="form-control">
                    <option selected="" disabled>Select</option>
                    @if(isset($pearl_settings) && count($pearl_settings) > 0)
                    @foreach($pearl_settings as $pearl_setting)
                    <option value="{{ $pearl_setting->title }}" {{ isset($pearl->attr_pearl_setting) && $pearl->attr_pearl_setting == $pearl_setting->title ? 'selected' : ''}}>{{ isset($pearl_setting->title) ? $pearl_setting->title : '' }}</option>
                    @endforeach
                    @endif
                </select>
            </div>
        </div>

        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="form-sec total-pear-count-sec">
                <label for="">Total Pearl Count <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter total number of pearls"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                <input type="text" class="form-control attr_total_pearl" name="attr_pearl_total_gem_count[]" id="" placeholder="Enter Total Pearl Count" value="{{ isset($pearl->attr_pearl_total_gem_count) ? $pearl->attr_pearl_total_gem_count : ''}}">
            </div>
        </div>

        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 total_pearl_wight_sec">
            <div class="form-sec">
                <label for="">Carat <span data-bs-toggle="tooltip" data-bs-placement="right" title="Calculated from Count and Carat"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                <input type="text" class="form-control total_pearl_weight" name="attr_pearl_total_wight[]" id="" placeholder="Enter Carat" value="{{ isset($pearl->attr_pearl_total_wight) ? $pearl->attr_pearl_total_wight : ''}}">
            </div>
        </div>

        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="form-sec pearl_caret_sec">
                <label for="">Pearl Price Per Carat <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter price per carat for pearl"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                <input type="text" class="form-control pearl_price_caret" name="pearl_price_carat[]" id="" placeholder="Enter Pearl Price Per Carat" value="{{ isset($pearl->pearl_price_carat) ? $pearl->pearl_price_carat : ''}}">
            </div>
        </div>

        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 pearl_total_final_sec">
            <div class="form-sec pearl_total_sec">
                <label for="">Final Pearl Price <span data-bs-toggle="tooltip" data-bs-placement="right" title="Calculated from Count, Carat and Price per carat"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                <input type="text" class="form-control pearl_final_total" name="pearl_final_total[]" id="" placeholder="Enter Final Pearl Price" value="{{ isset($pearl->pearl_final_total) ? $pearl->pearl_final_total : ''}}">
                <span class="dyn_summry_pearl">
              
                    @if(isset($product))
                    ({{ isset($pearl->attr_pearl_caret) ? $pearl->attr_pearl_caret : 0 }} carat * {{ isset($pearl->pearl_price_carat) ? $pearl->pearl_price_carat : 0 }} = {{ isset($pearl->pearl_final_total) ? $pearl->pearl_final_total : 0 }})
                    @endif
                </span>
            </div>
        </div>

    </div>
    <div class="row add-more-row-sec mb-3">
    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <hr>
         <a type="button" class="add-more-btn all_pearl_calculate"><i class="fa fa-calculator" aria-hidden="true"></i> Calculate Pearl Prices</a>
    </div>

</div>
</div>
<div id="all_pearl_div"></div>

 

<!-- Diamond Details start  -->
