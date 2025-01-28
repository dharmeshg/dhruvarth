<!-- Diamond Details start  -->
<div class="diamond-deatils-sec @if(isset($key) && $key != 0) mt-4 @endif">
    <div class="row each-diamond-details">
        
        <a><span class="remove_details" data-type="diamond"><i class="fa fa-times-circle"></i></span></a>
               
        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 sub-heading">
            <h3>Diamond Details @if(isset($d_dynamic) || (isset($diamond) && (isset($diamond->attr_type_dynamic) && $diamond->attr_type_dynamic != '' || isset($diamond->attr_type_quality) && $diamond->attr_type_quality != ''))) (Dynamic) @endif</h3>
        </div>
        <input type="hidden" name="attr_type_hidden[]" value="true">
        @if(isset($d_dynamic) || (isset($diamond) && (isset($diamond->attr_type_dynamic) && $diamond->attr_type_dynamic != '' || isset($diamond->attr_type_quality) && $diamond->attr_type_quality != '')))
            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="form-sec type-sec">
                    <label for="">Type <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please Select type of diamond"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                    <select name="attr_type_dynamic[]" class="form-control attr_type_dynamic_class">
                        <option selected="" disabled>Select</option>
                        @if(isset($diamond_types) && count($diamond_types) > 0)
                        @foreach($diamond_types as $type)
                        <option value="{{$type->id}}" {{ isset($diamond->attr_type_dynamic) && $diamond->attr_type_dynamic == $type->id ? 'selected' : '' }}> {{$type->name}}</option>
                        @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="form-sec quality-sec">
                    <label for="">Quality <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select Quality of diamond"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                    <select name="attr_type_quality[]" class="form-control attr_type_quality_class">
                        <option selected="" disabled>Select</option>
                        <option value="VVS EF" {{ isset($diamond->attr_type_quality) && $diamond->attr_type_quality == 'VVS EF' ? 'selected' : ''}}> VVS EF</option>
                        <option value="VVS / VS FG" {{ isset($diamond->attr_type_quality) && $diamond->attr_type_quality == 'VVS / VS FG' ? 'selected' : ''}}>VVS / VS FG</option>
                        <option value="VVS FG" {{ isset($diamond->attr_type_quality) && $diamond->attr_type_quality == 'VVS FG' ? 'selected' : ''}}>VVS FG</option>
                        <option value="VS/SI GH" {{ isset($diamond->attr_type_quality) && $diamond->attr_type_quality == 'VS/SI GH' ? 'selected' : ''}}>VS/SI GH</option>
                    </select>
                </div>
            </div>
        @endif
        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="form-sec">
                <label for="">Nature <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select nature of diamond"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                <select name="attr_type[]" class="form-control">
                    <option selected="" disabled>Select</option>
                    @if(isset($diamond_natures) && count($diamond_natures) > 0)
                    @foreach($diamond_natures as $diamond_nature)
                    <option value="{{ $diamond_nature->title }}" {{ isset($diamond->attr_type) && $diamond->attr_type == $diamond_nature->title ? 'selected' : ''}}>{{ isset($diamond_nature->title) ? $diamond_nature->title : '' }}</option>
                    @endforeach
                    @endif
                </select>
            </div>
        </div>

        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="form-sec">
                <label for="">Fancy Colour <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select fancy colour for diamond"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                <select name="attr_fancy_color[]" class="form-control">
                    <option selected="" disabled>Select</option>
                    @if(isset($diamond_fancy_colors) && count($diamond_fancy_colors) > 0)
                    @foreach($diamond_fancy_colors as $diamond_fancy_color)
                    <option value="{{ $diamond_fancy_color->title }}" {{ isset($diamond->attr_fancy_color) && $diamond->attr_fancy_color == $diamond_fancy_color->title ? 'selected' : ''}}>{{ isset($diamond_fancy_color->title) ? $diamond_fancy_color->title : '' }}</option>
                    @endforeach
                    @endif
                </select>
            </div>
        </div>
        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="form-sec">
                <label for="">Colour <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select colour for diamond"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                <select name="attr_color[]" class="form-control">
                    <option selected="" disabled>Select</option>
                    @if(isset($diamond_colors) && count($diamond_colors) > 0)
                    @foreach($diamond_colors as $diamond_color)
                    <option value="{{ $diamond_color->title }}" {{ isset($diamond->attr_color) && $diamond->attr_color == $diamond_color->title ? 'selected' : ''}}>{{ isset($diamond_color->title) ? $diamond_color->title : '' }}</option>
                    @endforeach
                    @endif
                </select>
            </div>
        </div>
        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 caret_sec">
            <div class="form-sec">
                @if(isset($d_dynamic) || (isset($diamond) && (isset($diamond->attr_type_dynamic) && $diamond->attr_type_dynamic != '' || isset($diamond->attr_type_quality) && $diamond->attr_type_quality != '')))
                    <label for="">Carat<span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter total carat for diamonds"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                    <input type="number" step="0.0001" class="form-control attr_carat" name="attr_diamond_caret[]" id="" placeholder="Enter Carat Per Diamond" value="{{ isset($diamond->attr_total_diamond_wight) ? $diamond->attr_total_diamond_wight : '' }}">
                @else
                <label for="">Carat Per Diamond <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter carat for individual diamond"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                <input type="number" step="0.0001" class="form-control attr_carat" name="attr_diamond_caret[]" id="" placeholder="Enter Carat Per Diamond" value="{{ isset($diamond->attr_diamond_caret) ? $diamond->attr_diamond_caret : '' }}">
                @endif
            </div>
        </div>

        <!-- <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="form-sec">
                <label for="">Gemstone <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select gemstone for diamond"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                <select name="attr_gemstone[]" class="form-control">
                    <option selected="" disabled>Select</option>
                    <option value="Diamond" {{ isset($diamond->attr_gemstone) && $diamond->attr_gemstone == 'Diamond' ? 'selected' : ''}}> Diamond</option>
                    <option value="Sapphire Yellow" {{ isset($diamond->attr_gemstone) && $diamond->attr_gemstone == 'Sapphire Yellow' ? 'selected' : ''}}>Sapphire Yellow</option>
                    <option value="Sapphire Blue" {{ isset($diamond->attr_gemstone) && $diamond->attr_gemstone == 'Sapphire Blue' ? 'selected' : ''}}>Sapphire Blue</option>
                    <option value="Sapphire Pink" {{ isset($diamond->attr_gemstone) && $diamond->attr_gemstone == 'Sapphire Pink' ? 'selected' : ''}}>Sapphire Pink</option>
                    <option value="Ruby" {{ isset($diamond->attr_gemstone) && $diamond->attr_gemstone == 'Ruby' ? 'selected' : ''}}>Ruby</option>
                    <option value="Emerald" {{ isset($diamond->attr_gemstone) && $diamond->attr_gemstone == 'Emerald' ? 'selected' : ''}}>Emerald</option>
                    <option value="Moissanite" {{ isset($diamond->attr_gemstone) && $diamond->attr_gemstone == 'Moissanite' ? 'selected' : ''}}>Moissanite</option>
                </select>
            </div>
        </div> -->

        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="form-sec">
                <label for="">Shape <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select shape for diamond"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                <select name="attr_shape[]" class="form-control">
                    <option selected="" disabled>Select</option>
                    @if(isset($diamond_shapes) && count($diamond_shapes) > 0)
                    @foreach($diamond_shapes as $diamond_shape)
                    <option value="{{ $diamond_shape->title }}" {{ isset($diamond->attr_shape) && $diamond->attr_shape == $diamond_shape->title ? 'selected' : ''}}>{{ isset($diamond_shape->title) ? $diamond_shape->title : '' }}</option>
                    @endforeach
                    @endif
                </select>
            </div>
        </div>

        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="form-sec">
                <label for="">Clarity <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select clarity for diamond"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                <select name="attr_clarity[]" class="form-control">
                    <option selected="" disabled>Select</option>
                    @if(isset($diamond_claritys) && count($diamond_claritys) > 0)
                    @foreach($diamond_claritys as $diamond_clarity)
                    <option value="{{ $diamond_clarity->title }}" {{ isset($diamond->attr_clarity) && $diamond->attr_clarity == $diamond_clarity->title ? 'selected' : ''}}>{{ isset($diamond_clarity->title) ? $diamond_clarity->title : '' }}</option>
                    @endforeach
                    @endif
                </select>
            </div>
        </div>

        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="form-sec">
                <label for="">Cut <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select cut for diamond"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                <select name="attr_cut[]" class="form-control">
                    <option selected="" disabled>Select</option>
                    @if(isset($diamond_cuts) && count($diamond_cuts) > 0)
                    @foreach($diamond_cuts as $diamond_cut)
                    <option value="{{ $diamond_cut->title }}" {{ isset($diamond->attr_cut) && $diamond->attr_cut == $diamond_cut->title ? 'selected' : ''}}>{{ isset($diamond_cut->title) ? $diamond_cut->title : '' }}</option>
                    @endforeach
                    @endif
                </select>
            </div>
        </div>

        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="form-sec">
                <label for="">Setting <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select setting for diamond"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                <select name="attr_setting[]" class="form-control">
                    <option selected="" disabled>Select</option>
                    @if(isset($diamond_settings) && count($diamond_settings) > 0)
                    @foreach($diamond_settings as $diamond_setting)
                    <option value="{{ $diamond_setting->title }}" {{ isset($diamond->attr_setting) && $diamond->attr_setting == $diamond_setting->title ? 'selected' : ''}}>{{ isset($diamond_setting->title) ? $diamond_setting->title : '' }}</option>
                    @endforeach
                    @endif
                </select>
            </div>
        </div>

        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="form-sec diamond_count_sec">
                <label for="">Total Diamond Count <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter total number of diamonds"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                <input type="text" class="form-control attr_total_dimond" name="attr_total_diamond_count[]" id="" placeholder="Enter Total Diamonds Count" value="{{ isset($diamond->attr_total_diamond_count) ? $diamond->attr_total_diamond_count : ''}}">
            </div>
        </div>
        @if(isset($d_dynamic) || (isset($diamond) && (isset($diamond->attr_type_dynamic) && $diamond->attr_type_dynamic != '' || isset($diamond->attr_type_quality) && $diamond->attr_type_quality != '')))
        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12" style="display: none;">
            <div class="form-sec caret_sec">
                <input type="hidden" class="form-control price_caret" name="attr_diamond_per_carat[]" id="" placeholder="Enter Diamond Price Per Carat" value="{{ isset($diamond->attr_diamond_per_carat) ? $diamond->attr_diamond_per_carat : ''}}">
            </div>
        </div>
        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 total_wight_sec" style="display: none;">
            <div class="form-sec">
                <label for="">Total Diamond Weight <span data-bs-toggle="tooltip" data-bs-placement="right" title="Calculated from Count and Carat"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                <input type="text" class="form-control total_weight" name="attr_total_diamond_wight[]" id="" placeholder="Enter Total Diamond Weight" value="{{ isset($diamond->attr_total_diamond_wight) ? $diamond->attr_total_diamond_wight : ''}}">
            </div>
        </div>

        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12" style="display: none;">
            <div class="form-sec caret_sec">
                <label for="">Diamond Price Per Carat <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter diamond price per carat"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                <input type="text" class="form-control price_caret" name="attr_diamond_per_carat[]" id="" placeholder="Enter Diamond Price Per Carat" value="{{ isset($diamond->attr_diamond_per_carat) ? $diamond->attr_diamond_per_carat : ''}}">
            </div>
        </div>
        @else

        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 total_wight_sec">
            <div class="form-sec">
                <label for="">Carat <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please Enter Carat"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                <input type="text" class="form-control total_weight" name="attr_total_diamond_wight[]" id="" placeholder="Enter Carat" value="{{ isset($diamond->attr_total_diamond_wight) ? $diamond->attr_total_diamond_wight : ''}}">
            </div>
        </div>

        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="form-sec caret_sec">
                <label for="">Diamond Price Per Carat <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter diamond price per carat"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                <input type="text" class="form-control price_caret" name="attr_diamond_per_carat[]" id="" placeholder="Enter Diamond Price Per Carat" value="{{ isset($diamond->attr_diamond_per_carat) ? $diamond->attr_diamond_per_carat : ''}}">
            </div>
        </div>
        @endif
   

        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 total_final_sec">
            <div class="form-sec diamonds_total_sec">
                <label for="">Final Diamond Price @if(isset($d_dynamic) || (isset($diamond) && (isset($diamond->attr_type_dynamic) && $diamond->attr_type_dynamic != '' || isset($diamond->attr_type_quality) && $diamond->attr_type_quality != ''))) (Dynamic) @else <span data-bs-toggle="tooltip" data-bs-placement="right" title="Calculated from Count, Carat and Price per carat"><i class="fa fa-info-circle" aria-hidden="true"></i></span> @endif </label>
                @if(isset($d_dynamic) || (isset($diamond) && (isset($diamond->attr_type_dynamic) && $diamond->attr_type_dynamic != '' || isset($diamond->attr_type_quality) && $diamond->attr_type_quality != '')))
                    @php
                    if(isset($diamond)) {
                        $diamond_rate = App\Models\DiamondRate::where('type', $diamond->attr_type_dynamic)->where('quality', $diamond->attr_type_quality)->first();
                        
                        $final_each_diamond = $diamond_rate->rate * (isset($diamond->attr_total_diamond_wight) ? floatval($diamond->attr_total_diamond_wight) : 0);
                    }
                    @endphp
                @else
                    @php
                    $final_each_diamond = isset($diamond->attr_final_diamond_price) ? $diamond->attr_final_diamond_price : '';
                    @endphp
                @endif
                <input type="text" class="form-control final_total" name="attr_final_diamond_price[]" id="" placeholder="Enter Final Diamond Price" value="{{ isset($final_each_diamond) ? $final_each_diamond : ''}}">

                 
                <span class="dyn_summry"> 
                    @if(isset($d_dynamic) || (isset($diamond) && (isset($diamond->attr_type_dynamic) && $diamond->attr_type_dynamic != '' || isset($diamond->attr_type_quality) && $diamond->attr_type_quality != '')))
                    ( {{ isset($diamond_rate->rate) ? $diamond_rate->rate : ''}} * {{ isset($diamond->attr_total_diamond_wight) ? $diamond->attr_total_diamond_wight : '' }} carat =  {{ isset($final_each_diamond) ? $final_each_diamond : ''}} ) 
                    @elseif(isset($diamond))
                   ({{ isset($diamond->attr_total_diamond_wight) ? floatval($diamond->attr_total_diamond_wight) : 0 }} carat * {{ isset($diamond->attr_diamond_per_carat) ? $diamond->attr_diamond_per_carat : 0 }} = {{ isset($diamond->attr_final_diamond_price) ? $diamond->attr_final_diamond_price : 0 }})
                    @endif
                </span>
            </div>
        </div>

    </div>
  
 <div class="row add-more-row-sec mb-3">
    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <hr>
        <a type="button" class="add-more-btn all_diamond_calculate"><i class="fa fa-calculator" aria-hidden="true"></i> Calculate Diamond Prices</a>
        <!-- <a type="button" class="add-more-btn all_dimond_add"><i class="fa fa-plus" aria-hidden="true"></i> Add More</a> -->
    </div>

</div>
</div>
<div id="all_diamond_div"></div>

<!-- Diamond Details End -->

 