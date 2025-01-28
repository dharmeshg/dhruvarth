<div class="diamond-deatils-sec @if(isset($key) && $key != 0) mt-4 @endif">
    <div class="row each-diamond-details">
        
        <a><span class="remove_details" data-type="gemstone"><i class="fa fa-times-circle"></i></span></a>
        
        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 sub-heading">
            <h3>Gemstone Details</h3>
        </div>
        <input type="hidden" name="attr_gemstone_hidden[]" value="true">
        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="form-sec">
                <label for="">Gemstone <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select gemstone"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                <select name="attr_gemstone_gem[]" class="form-control">
                    <option selected="" disabled>Select</option>
                    @if(isset($gem_gemstones) && count($gem_gemstones) > 0)
                    @foreach($gem_gemstones as $gem_gemstone)
                    <option value="{{ $gem_gemstone->title }}" {{ isset($gemstone->attr_gemstone_gem) && $gemstone->attr_gemstone_gem == $gem_gemstone->title ? 'selected' : ''}}>{{ isset($gem_gemstone->title) ? $gem_gemstone->title : '' }}</option>
                    @endforeach
                    @endif
                </select>
            </div>
        </div>
        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="form-sec">
                <label for="">Type <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select type of gemstone"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                <select name="attr_gemstone_type[]" class="form-control">
                    <option selected="" disabled>Select</option>
                    @if(isset($gem_natures) && count($gem_natures) > 0)
                    @foreach($gem_natures as $gem_nature)
                    <option value="{{ $gem_nature->title }}" {{ isset($gemstone->attr_gemstone_type) && $gemstone->attr_gemstone_type == $gem_nature->title ? 'selected' : ''}}>{{ isset($gem_nature->title) ? $gem_nature->title : '' }}</option>
                    @endforeach
                    @endif
                </select>
            </div>
        </div>
        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="form-sec">
                <label for="">Colour <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select color for gemstone"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                <select name="attr_gemstone_color[]" class="form-control">
                    <option selected="" disabled>Select</option>
                    @if(isset($gem_colors) && count($gem_colors) > 0)
                    @foreach($gem_colors as $gem_color)
                    <option value="{{ $gem_color->title }}" {{ isset($gemstone->attr_gemstone_color) && $gemstone->attr_gemstone_color == $gem_color->title ? 'selected' : ''}}>{{ isset($gem_color->title) ? $gem_color->title : '' }}</option>
                    @endforeach
                    @endif
                </select>
            </div>
        </div>

        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 gemstone_caret_sec">
            <div class="form-sec">
                <label for="">Carat Per Stone <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter carat for individual gemstone"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                <input type="number" step="0.0001" class="form-control attr_gemstone_carat" name="attr_gemstone_caret[]" id="" placeholder="Enter Carat Per Stone" value="{{ isset($gemstone->attr_gemstone_caret) ? $gemstone->attr_gemstone_caret : ''}}">
            </div>
        </div>

        

        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="form-sec">
                <label for="">Shape <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select shape for gemstone"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                <select name="attr_gemstone_shape[]" class="form-control">
                    <option selected="" disabled>Select</option>
                    @if(isset($gem_shapes) && count($gem_shapes) > 0)
                    @foreach($gem_shapes as $gem_shape)
                    <option value="{{ $gem_shape->title }}" {{ isset($gemstone->attr_gemstone_shape) && $gemstone->attr_gemstone_shape == $gem_shape->title ? 'selected' : ''}}>{{ isset($gem_shape->title) ? $gem_shape->title : '' }}</option>
                    @endforeach
                    @endif
                </select>
            </div>
        </div>

        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="form-sec">
                <label for="">Clarity <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select clarity for gemstone"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                <select name="attr_gemstone_clarity[]" class="form-control">
                    <option selected="" disabled>Select</option>
                    @if(isset($gem_claritys) && count($gem_claritys) > 0)
                    @foreach($gem_claritys as $gem_clarity)
                    <option value="{{ $gem_clarity->title }}" {{ isset($gemstone->attr_gemstone_clarity) && $gemstone->attr_gemstone_clarity == $gem_clarity->title ? 'selected' : ''}}>{{ isset($gem_clarity->title) ? $gem_clarity->title : '' }}</option>
                    @endforeach
                    @endif
                </select>
            </div>
        </div>

        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="form-sec">
                <label for="">Cut <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select cut for gemstone"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                <select name="attr_gemstone_cut[]" class="form-control">
                    <option selected="" disabled>Select</option>
                    @if(isset($gem_cuts) && count($gem_cuts) > 0)
                    @foreach($gem_cuts as $gem_cut)
                    <option value="{{ $gem_cut->title }}" {{ isset($gemstone->attr_gemstone_cut) && $gemstone->attr_gemstone_cut == $gem_cut->title ? 'selected' : ''}}>{{ isset($gem_cut->title) ? $gem_cut->title : '' }}</option>
                    @endforeach
                    @endif
                </select>
            </div>
        </div>

        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="form-sec">
                <label for="">Setting <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select setting for gemstone"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                <select name="attr_gemstone_setting[]" class="form-control">
                    <option selected="" disabled>Select</option>
                    @if(isset($gem_settings) && count($gem_settings) > 0)
                    @foreach($gem_settings as $gem_setting)
                    <option value="{{ $gem_setting->title }}" {{ isset($gemstone->attr_gemstone_setting) && $gemstone->attr_gemstone_setting == $gem_setting->title ? 'selected' : ''}}>{{ isset($gem_setting->title) ? $gem_setting->title : '' }}</option>
                    @endforeach
                    @endif
                </select>
            </div>
        </div>

        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="form-sec total-gem-count-sec">
                <label for="">Total Gemstone Count <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter total number of Gemstone"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                <input type="text" class="form-control attr_total_gemstone" name="attr_gemstone_total_gem_count[]" id="" placeholder="Enter Total Gemstone Count" value="{{ isset($gemstone->attr_gemstone_total_gem_count) ? $gemstone->attr_gemstone_total_gem_count : '' }}">
            </div>
        </div>

        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 total_gemstone_wight_sec">
            <div class="form-sec">
                <label for="">Carat <span data-bs-toggle="tooltip" data-bs-placement="right" title="Calculated from Count and Carat"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                <input type="text" class="form-control total_gemstone_weight" name="attr_gemstone_total_wight[]" id="" placeholder="Enter Carat" value="{{ isset($gemstone->attr_gemstone_total_wight) ? $gemstone->attr_gemstone_total_wight : '' }}">
            </div>
        </div>

        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="form-sec gemstone_caret_sec">
                <label for="">Gemstone Price Per Carat <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter gemstone price per carat"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                <input type="text" class="form-control gemstone_price_caret" name="gemstone_price_carat[]" id="" placeholder="Enter Gemstone Price Per Carat" value="{{ isset($gemstone->gemstone_price_carat) ? $gemstone->gemstone_price_carat : '' }}">
            </div>
        </div>

        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 gemstone_total_final_sec">
            <div class="form-sec gemstone_total_sec">
                <label for="">Final Gemstone Price <span data-bs-toggle="tooltip" data-bs-placement="right" title="Calculated from Count, Carat and Price per carat"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                <input type="text" class="form-control gemstone_final_total" name="gemstone_final_total[]" id="" placeholder="Enter Final Gemstone Price" value="{{ isset($gemstone->gemstone_final_total) ? $gemstone->gemstone_final_total : '' }}">
                <span class="dyn_summry_gemstone"> 
                   
                    @if(isset($gemstone->attr_gemstone_caret))
                    ({{ isset($gemstone->attr_gemstone_caret) ? $gemstone->attr_gemstone_caret : 0 }} carat * {{ $gemstone->gemstone_price_carat ? $gemstone->gemstone_price_carat : 0 }} = {{ isset($gemstone->gemstone_final_total) ? $gemstone->gemstone_final_total : 0 }})
                    @endif
                </span>
            </div>
        </div>

    </div>
<div class="row add-more-row-sec mb-3">
    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <hr>
        <a type="button" class="add-more-btn all_gemstone_calculate"><i class="fa fa-calculator" aria-hidden="true"></i> Calculate Gemstone Prices</a>
    </div>

</div>
</div>
<div id="all_gemstone_div"></div>

