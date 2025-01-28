<!-- Diamond Details start  -->
<div class="diamond-deatils-sec @if(isset($key) && $key != 0) mt-4 @endif">
    <div class="row each-diamond-details">
        @if(isset($key) && $key != 0)
        <a><span class="remove_details"><i class="fa fa-times-circle"></i></span></a>
        @endif
        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 sub-heading">
            <h3>Diamonds Details</h3>
        </div>

        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="form-sec">
                <label for="">Type <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select type of diamond"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                <select name="attr_type[]" class="form-control">
                    <option selected="" disabled>Select</option>
                    <option value="Natural" {{ isset($diamond->attr_type) && $diamond->attr_type == 'Natural' ? 'selected' : ''}}> Natural</option>
                    <option value="Lab-Grown" {{ isset($diamond->attr_type) && $diamond->attr_type == 'Lab-Grown' ? 'selected' : ''}}>Lab-Grown</option>
                    <option value="Cultured" {{ isset($diamond->attr_type) && $diamond->attr_type == 'Cultured' ? 'selected' : ''}}>Cultured</option>
                    <option value="Saltwater" {{ isset($diamond->attr_type) && $diamond->attr_type == 'Saltwater' ? 'selected' : ''}}>Saltwater</option>
                    <option value="Imitation" {{ isset($diamond->attr_type) && $diamond->attr_type == 'Imitation' ? 'selected' : ''}}>Imitation</option>
                </select>
            </div>
        </div>

        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="form-sec">
                <label for="">Fancy Colour <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select fancy colour for diamond"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                <select name="attr_fancy_color[]" class="form-control">
                    <option selected="" disabled>Select</option>
                    <option value="White" {{ isset($diamond->attr_fancy_color) && $diamond->attr_fancy_color == 'White' ? 'selected' : ''}}>White</option>
                    <option value="Yellow" {{ isset($diamond->attr_fancy_color) && $diamond->attr_fancy_color == 'Yellow' ? 'selected' : ''}}>Yellow</option>
                    <option value="Pink" {{ isset($diamond->attr_fancy_color) && $diamond->attr_fancy_color == 'Pink' ? 'selected' : ''}}>Pink</option>
                    <option value="Purple" {{ isset($diamond->attr_fancy_color) && $diamond->attr_fancy_color == 'Purple' ? 'selected' : ''}}>Purple</option>
                    <option value="Blue" {{ isset($diamond->attr_fancy_color) && $diamond->attr_fancy_color == 'Blue' ? 'selected' : ''}}>Blue</option>
                    <option value="Green" {{ isset($diamond->attr_fancy_color) && $diamond->attr_fancy_color == 'Green' ? 'selected' : ''}}>Green</option>
                    <option value="Orange" {{ isset($diamond->attr_fancy_color) && $diamond->attr_fancy_color == 'Orange' ? 'selected' : ''}}>Orange</option>
                    <option value="Brown" {{ isset($diamond->attr_fancy_color) && $diamond->attr_fancy_color == 'Brown' ? 'selected' : ''}}>Brown</option>
                    <option value="Black" {{ isset($diamond->attr_fancy_color) && $diamond->attr_fancy_color == 'Black' ? 'selected' : ''}}>Black</option>
                </select>
            </div>
        </div>
        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="form-sec">
                <label for="">Colour <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select colour for diamond"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                <select name="attr_color[]" class="form-control">
                    <option selected="" disabled>Select</option>
                    <option value="D" {{ isset($diamond->attr_color) && $diamond->attr_color == 'D' ? 'selected' : ''}}>D</option>
                    <option value="E" {{ isset($diamond->attr_color) && $diamond->attr_color == 'E' ? 'selected' : ''}}>E</option>
                    <option value="F" {{ isset($diamond->attr_color) && $diamond->attr_color == 'F' ? 'selected' : ''}}>F</option>
                    <option value="G" {{ isset($diamond->attr_color) && $diamond->attr_color == 'G' ? 'selected' : ''}}>G</option>
                    <option value="H" {{ isset($diamond->attr_color) && $diamond->attr_color == 'H' ? 'selected' : ''}}>H</option>
                    <option value="I" {{ isset($diamond->attr_color) && $diamond->attr_color == 'I' ? 'selected' : ''}}>I</option>
                    <option value="J" {{ isset($diamond->attr_color) && $diamond->attr_color == 'J' ? 'selected' : ''}}>J</option>
                    <option value="K" {{ isset($diamond->attr_color) && $diamond->attr_color == 'K' ? 'selected' : ''}}>K</option>
                    <option value="L" {{ isset($diamond->attr_color) && $diamond->attr_color == 'L' ? 'selected' : ''}}>L</option>
                    <option value="M" {{ isset($diamond->attr_color) && $diamond->attr_color == 'M' ? 'selected' : ''}}>M</option>
                </select>
            </div>
        </div>

        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 caret_sec">
            <div class="form-sec">
                <label for="">Total Carat <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter carat for diamond"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                <input type="number" step="0.0001" class="form-control attr_carat" name="attr_diamond_caret[]" id="" placeholder="Enter Carat" value="{{ isset($diamond->attr_diamond_caret) ? $diamond->attr_diamond_caret : '' }}">
            </div>
        </div>

        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
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
        </div>

        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="form-sec">
                <label for="">Shape <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select shape for diamond"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                <select name="attr_shape[]" class="form-control">
                    <option selected="" disabled>Select</option>
                    <option value="Round" {{ isset($diamond->attr_shape) && $diamond->attr_shape == 'Round' ? 'selected' : ''}}> Round</option>
                    <option value="Princess" {{ isset($diamond->attr_shape) && $diamond->attr_shape == 'Princess' ? 'selected' : ''}}>Princess</option>
                    <option value="Emerald" {{ isset($diamond->attr_shape) && $diamond->attr_shape == 'Emerald' ? 'selected' : ''}}>Emerald</option>
                    <option value="Sq. Emerald" {{ isset($diamond->attr_shape) && $diamond->attr_shape == 'Sq. Emerald' ? 'selected' : ''}}>Sq. Emerald</option>
                    <option value="Asscher" {{ isset($diamond->attr_shape) && $diamond->attr_shape == 'Asscher' ? 'selected' : ''}}>Asscher</option>
                    <option value="Cushion" {{ isset($diamond->attr_shape) && $diamond->attr_shape == 'Cushion' ? 'selected' : ''}}>Cushion</option>
                    <option value="Oval" {{ isset($diamond->attr_shape) && $diamond->attr_shape == 'Oval' ? 'selected' : ''}}>Oval</option>
                    <option value="Radiant" {{ isset($diamond->attr_shape) && $diamond->attr_shape == 'Radiant' ? 'selected' : ''}}>Radiant</option>
                    <option value="Pear" {{ isset($diamond->attr_shape) && $diamond->attr_shape == 'Pear' ? 'selected' : ''}}>Pear</option>
                    <option value="Marquise" {{ isset($diamond->attr_shape) && $diamond->attr_shape == 'Marquise' ? 'selected' : ''}}>Marquise</option>
                    <option value="Heart" {{ isset($diamond->attr_shape) && $diamond->attr_shape == 'Heart' ? 'selected' : ''}}>Heart</option>
                    <option value="Triangle" {{ isset($diamond->attr_shape) && $diamond->attr_shape == 'Triangle' ? 'selected' : ''}}>Triangle</option>
                    <option value="Trilliant" {{ isset($diamond->attr_shape) && $diamond->attr_shape == 'Trilliant' ? 'selected' : ''}}>Trilliant</option>
                    <option value="Baguette" {{ isset($diamond->attr_shape) && $diamond->attr_shape == 'Baguette' ? 'selected' : ''}}>Baguette</option>
                    <option value="Trapezoid" {{ isset($diamond->attr_shape) && $diamond->attr_shape == 'Trapezoid' ? 'selected' : ''}}>Trapezoid</option>
                    <option value="Kite" {{ isset($diamond->attr_shape) && $diamond->attr_shape == 'Kite' ? 'selected' : ''}}>Kite</option>
                    <option value="Rose Cut" {{ isset($diamond->attr_shape) && $diamond->attr_shape == 'Rose Cut' ? 'selected' : ''}}>Rose Cut</option>
                    <option value="Briolette" {{ isset($diamond->attr_shape) && $diamond->attr_shape == 'Briolette' ? 'selected' : ''}}>Briolette</option>
                </select>
            </div>
        </div>

        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="form-sec">
                <label for="">Clarity <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select clarity for diamond"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                <select name="attr_clarity[]" class="form-control">
                    <option selected="" disabled>Select</option>
                    <option value="FL" {{ isset($diamond->attr_clarity) && $diamond->attr_clarity == 'FL' ? 'selected' : ''}}> FL</option>
                    <option value="IF" {{ isset($diamond->attr_clarity) && $diamond->attr_clarity == 'IF' ? 'selected' : ''}}>IF</option>
                    <option value="VVS1" {{ isset($diamond->attr_clarity) && $diamond->attr_clarity == 'VVS1' ? 'selected' : ''}}>VVS1</option>
                    <option value="VVS2" {{ isset($diamond->attr_clarity) && $diamond->attr_clarity == 'VVS2' ? 'selected' : ''}}>VVS2</option>
                    <option value="VS1" {{ isset($diamond->attr_clarity) && $diamond->attr_clarity == 'VS1' ? 'selected' : ''}}>VS1</option>
                    <option value="VS2" {{ isset($diamond->attr_clarity) && $diamond->attr_clarity == 'VS2' ? 'selected' : ''}}>VS2</option>
                    <option value="SI1" {{ isset($diamond->attr_clarity) && $diamond->attr_clarity == 'SI1' ? 'selected' : ''}}>SI1</option>
                    <option value="SI2" {{ isset($diamond->attr_clarity) && $diamond->attr_clarity == 'SI2' ? 'selected' : ''}}>SI2</option>
                    <option value="SI3" {{ isset($diamond->attr_clarity) && $diamond->attr_clarity == 'SI3' ? 'selected' : ''}}>SI3</option>
                    <option value="I1" {{ isset($diamond->attr_clarity) && $diamond->attr_clarity == 'I1' ? 'selected' : ''}}>I1</option>
                    <option value="I2" {{ isset($diamond->attr_clarity) && $diamond->attr_clarity == 'I2' ? 'selected' : ''}}>I2</option>
                    <option value="I3" {{ isset($diamond->attr_clarity) && $diamond->attr_clarity == 'I3' ? 'selected' : ''}}>I3</option>
                </select>
            </div>
        </div>

        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="form-sec">
                <label for="">Cut <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select cut for diamond"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                <select name="attr_cut[]" class="form-control">
                    <option selected="" disabled>Select</option>
                    <option value="Ideal" {{ isset($diamond->attr_cut) && $diamond->attr_cut == 'Ideal' ? 'selected' : ''}}> Ideal</option>
                    <option value="Excellent" {{ isset($diamond->attr_cut) && $diamond->attr_cut == 'Excellent' ? 'selected' : ''}}>Excellent</option>
                    <option value="Very Good" {{ isset($diamond->attr_cut) && $diamond->attr_cut == 'Very Good' ? 'selected' : ''}}>Very Good</option>
                    <option value="Good" {{ isset($diamond->attr_cut) && $diamond->attr_cut == 'Good' ? 'selected' : ''}}>Good</option>
                    <option value="Fair" {{ isset($diamond->attr_cut) && $diamond->attr_cut == 'Fair' ? 'selected' : ''}}>Fair</option>
                    <option value="Poor" {{ isset($diamond->attr_cut) && $diamond->attr_cut == 'Poor' ? 'selected' : ''}}>Poor</option>
                </select>
            </div>
        </div>

        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="form-sec">
                <label for="">Setting <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select setting for diamond"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                <select name="attr_setting[]" class="form-control">
                    <option selected="" disabled>Select</option>
                    <option value="Prong" {{ isset($diamond->attr_setting) && $diamond->attr_setting == 'Prong' ? 'selected' : ''}}> Prong</option>
                    <option value="Bezel" {{ isset($diamond->attr_setting) && $diamond->attr_setting == 'Bezel' ? 'selected' : ''}}>Bezel</option>
                    <option value="Channel" {{ isset($diamond->attr_setting) && $diamond->attr_setting == 'Channel' ? 'selected' : ''}}>Channel</option>
                    <option value="Pave" {{ isset($diamond->attr_setting) && $diamond->attr_setting == 'Pave' ? 'selected' : ''}}>Pave</option>
                    <option value="Bar" {{ isset($diamond->attr_setting) && $diamond->attr_setting == 'Bar' ? 'selected' : ''}}>Bar</option>
                    <option value="Cluster" {{ isset($diamond->attr_setting) && $diamond->attr_setting == 'Cluster' ? 'selected' : ''}}>Cluster</option>
                    <option value="Halo" {{ isset($diamond->attr_setting) && $diamond->attr_setting == 'Halo' ? 'selected' : ''}}>Halo</option>
                    <option value="Tension" {{ isset($diamond->attr_setting) && $diamond->attr_setting == 'Tension' ? 'selected' : ''}}>Tension</option>
                    <option value="Invisible" {{ isset($diamond->attr_setting) && $diamond->attr_setting == 'Invisible' ? 'selected' : ''}}>Invisible</option>
                    <option value="Bead" {{ isset($diamond->attr_setting) && $diamond->attr_setting == 'Bead' ? 'selected' : ''}}>Bead</option>
                    <option value="Flush" {{ isset($diamond->attr_setting) && $diamond->attr_setting == 'Flush' ? 'selected' : ''}}>Flush</option>
                    <option value="Cup" {{ isset($diamond->attr_setting) && $diamond->attr_setting == 'Cup' ? 'selected' : ''}}>Cup</option>
                    <option value="Wire" {{ isset($diamond->attr_setting) && $diamond->attr_setting == 'Wire' ? 'selected' : ''}}>Wire</option>
                    <option value="Button" {{ isset($diamond->attr_setting) && $diamond->attr_setting == 'Button' ? 'selected' : ''}}>Button</option>
                    <option value="Cage" {{ isset($diamond->attr_setting) && $diamond->attr_setting == 'Cage' ? 'selected' : ''}}>Cage</option>
                </select>
            </div>
        </div>

        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="form-sec">
                <label for="">Total Diamond Count <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter total diamond count"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                <input type="text" class="form-control attr_total_dimond" name="attr_total_diamond_count[]" id="" placeholder="Enter Total Diamonds Count" value="{{ isset($diamond->attr_total_diamond_count) ? $diamond->attr_total_diamond_count : ''}}">
            </div>
        </div>

        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 total_wight_sec">
            <div class="form-sec">
                <label for="">Total Diamond Weight <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter total diamond weight"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                <input type="text" class="form-control total_weight" name="attr_total_diamond_wight[]" id="" placeholder="Enter Total Diamond Weight" value="{{ isset($diamond->attr_total_diamond_wight) ? $diamond->attr_total_diamond_wight : ''}}">
            </div>
        </div>

        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="form-sec caret_sec">
                <label for="">Diamond Price Per Carat <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter diamond price per carat"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                <input type="text" class="form-control price_caret" name="attr_diamond_per_carat[]" id="" placeholder="Enter Diamond Price Per Carat" value="{{ isset($diamond->attr_diamond_per_carat) ? $diamond->attr_diamond_per_carat : ''}}">
            </div>
        </div>

        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 total_final_sec">
            <div class="form-sec diamonds_total_sec">
                <label for="">Final Diamond Price <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter final diamond price"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                <input type="text" class="form-control final_total" name="attr_final_diamond_price[]" id="" placeholder="Enter Final Diamond Price" value="{{ isset($diamond->attr_final_diamond_price) ? $diamond->attr_final_diamond_price : ''}}">
            </div>
        </div>

    </div>
</div>
<div id="all_diamond_div"></div>
@if((isset($loop) && $loop->last) || !isset($loop))
 <div class="row add-more-row-sec mb-3">
    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <hr>
        <a type="button" class="add-more-btn all_diamond_calculate" style="margin-left: 108px;"><i class="fa fa-calculator" aria-hidden="true"></i> Calculate Diamond Prices</a>
        <a type="button" class="add-more-btn all_dimond_add"><i class="fa fa-plus" aria-hidden="true"></i> Add More</a>
    </div>

</div>
@endif
<!-- Diamond Details End -->
<div class="diamond-deatils-sec @if(isset($key) && $key != 0) mt-4 @endif">
    <div class="row each-diamond-details">
        @if(isset($key) && $key != 0)
        <a><span class="remove_details"><i class="fa fa-times-circle"></i></span></a>
        @endif
        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 sub-heading">
            <h3>Gemstones Details</h3>
        </div>

        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="form-sec">
                <label for="">Type <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select type of gemstone"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                <select name="attr_gemstone_type[]" class="form-control">
                    <option selected="" disabled>Select</option>
                    <option value="Natural" {{ isset($gemstone->attr_gemstone_type) && $gemstone->attr_gemstone_type == 'Natural' ? 'selected' : ''}}> Natural</option>
                    <option value="Lab-Grown" {{ isset($gemstone->attr_gemstone_type) && $gemstone->attr_gemstone_type == 'Lab-Grown' ? 'selected' : ''}}>Lab-Grown</option>
                    <option value="Cultured" {{ isset($gemstone->attr_gemstone_type) && $gemstone->attr_gemstone_type == 'Cultured' ? 'selected' : ''}}>Cultured</option>
                    <option value="Saltwater" {{ isset($gemstone->attr_gemstone_type) && $gemstone->attr_gemstone_type == 'Saltwater' ? 'selected' : ''}}>Saltwater</option>
                    <option value="Imitation" {{ isset($gemstone->attr_gemstone_type) && $gemstone->attr_gemstone_type == 'Imitation' ? 'selected' : ''}}>Imitation</option>
                </select>
            </div>
        </div>
        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="form-sec">
                <label for="">Colour <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select color for gemstone"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                <select name="attr_gemstone_color[]" class="form-control">
                    <option selected="" disabled>Select</option>
                    <option value="Banded" {{ isset($gemstone->attr_gemstone_color) && $gemstone->attr_gemstone_color == 'Banded' ? 'selected' : ''}}>Banded</option>
                    <option value="Bi-color" {{ isset($gemstone->attr_gemstone_color) && $gemstone->attr_gemstone_color == 'Bi-color' ? 'selected' : ''}}>Bi-color</option>
                    <option value="Black" {{ isset($gemstone->attr_gemstone_color) && $gemstone->attr_gemstone_color == 'Black' ? 'selected' : ''}}>Black</option>
                    <option value="Blue" {{ isset($gemstone->attr_gemstone_color) && $gemstone->attr_gemstone_color == 'Blue' ? 'selected' : ''}}>Blue</option>
                    <option value="Brown" {{ isset($gemstone->attr_gemstone_color) && $gemstone->attr_gemstone_color == 'Brown' ? 'selected' : ''}}>Brown</option>
                    <option value="Color-Change" {{ isset($gemstone->attr_gemstone_color) && $gemstone->attr_gemstone_color == 'Color-Change' ? 'selected' : ''}}>Color-Change</option>
                    <option value="Colorless" {{ isset($gemstone->attr_gemstone_color) && $gemstone->attr_gemstone_color == 'Colorless' ? 'selected' : ''}}>Colorless</option>
                    <option value="Cream" {{ isset($gemstone->attr_gemstone_color) && $gemstone->attr_gemstone_color == 'Cream' ? 'selected' : ''}}>Cream</option>
                    <option value="Golden" {{ isset($gemstone->attr_gemstone_color) && $gemstone->attr_gemstone_color == 'Golden' ? 'selected' : ''}}>Golden</option>
                    <option value="Gray" {{ isset($gemstone->attr_gemstone_color) && $gemstone->attr_gemstone_color == 'Gray' ? 'selected' : ''}}>Gray</option>
                    <option value="Green" {{ isset($gemstone->attr_gemstone_color) && $gemstone->attr_gemstone_color == 'Green' ? 'selected' : ''}}>Green</option>
                    <option value="London Blue" {{ isset($gemstone->attr_gemstone_color) && $gemstone->attr_gemstone_color == 'London Blue' ? 'selected' : ''}}>London Blue</option>
                    <option value="Metallic" {{ isset($gemstone->attr_gemstone_color) && $gemstone->attr_gemstone_color == 'Metallic' ? 'selected' : ''}}>Metallic</option>
                    <option value="Multicolored" {{ isset($gemstone->attr_gemstone_color) && $gemstone->attr_gemstone_color == 'Multicolored' ? 'selected' : ''}}>Multicolored</option>
                    <option value="Orange" {{ isset($gemstone->attr_gemstone_color) && $gemstone->attr_gemstone_color == 'Orange' ? 'selected' : ''}}>Orange</option>
                    <option value="Paraiba" {{ isset($gemstone->attr_gemstone_color) && $gemstone->attr_gemstone_color == 'Paraiba' ? 'selected' : ''}}>Paraiba</option>
                    <option value="Pink" {{ isset($gemstone->attr_gemstone_color) && $gemstone->attr_gemstone_color == 'Pink' ? 'selected' : ''}}>Pink</option>
                    <option value="Purple" {{ isset($gemstone->attr_gemstone_color) && $gemstone->attr_gemstone_color == 'Purple' ? 'selected' : ''}}>Purple</option>
                    <option value="Red" {{ isset($gemstone->attr_gemstone_color) && $gemstone->attr_gemstone_color == 'Red' ? 'selected' : ''}}>Red</option>
                    <option value="Royal Blue" {{ isset($gemstone->attr_gemstone_color) && $gemstone->attr_gemstone_color == 'Royal Blue' ? 'selected' : ''}}>Royal Blue</option>
                    <option value="Silver" {{ isset($gemstone->attr_gemstone_color) && $gemstone->attr_gemstone_color == 'Silver' ? 'selected' : ''}}>Silver</option>
                    <option value="Sky" {{ isset($gemstone->attr_gemstone_color) && $gemstone->attr_gemstone_color == 'Sky' ? 'selected' : ''}}>Sky</option>
                    <option value="Sky Blue" {{ isset($gemstone->attr_gemstone_color) && $gemstone->attr_gemstone_color == 'Sky Blue' ? 'selected' : ''}}>Sky Blue</option>
                    <option value="Smoky" {{ isset($gemstone->attr_gemstone_color) && $gemstone->attr_gemstone_color == 'Smoky' ? 'selected' : ''}}>Smoky</option>
                    <option value="Swiss" {{ isset($gemstone->attr_gemstone_color) && $gemstone->attr_gemstone_color == 'Swiss' ? 'selected' : ''}}>Swiss</option>
                    <option value="Swiss Blue" {{ isset($gemstone->attr_gemstone_color) && $gemstone->attr_gemstone_color == 'Swiss Blue' ? 'selected' : ''}}>Swiss Blue</option>
                    <option value="Violet" {{ isset($gemstone->attr_gemstone_color) && $gemstone->attr_gemstone_color == 'Violet' ? 'selected' : ''}}>Violet</option>
                    <option value="White" {{ isset($gemstone->attr_gemstone_color) && $gemstone->attr_gemstone_color == 'White' ? 'selected' : ''}}>White</option>
                    <option value="Yellow" {{ isset($gemstone->attr_gemstone_color) && $gemstone->attr_gemstone_color == 'Yellow' ? 'selected' : ''}}>Yellow</option>
                </select>
            </div>
        </div>

        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 gemstone_caret_sec">
            <div class="form-sec">
                <label for="">Total Carat <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter carat for gemstone"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                <input type="number" step="0.0001" class="form-control attr_gemstone_carat" name="attr_gemstone_caret[]" id="" placeholder="Enter Carat" value="{{ isset($gemstone->attr_gemstone_caret) ? $gemstone->attr_gemstone_caret : ''}}">
            </div>
        </div>

        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="form-sec">
                <label for="">Gemstone <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select gemstone"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                <select name="attr_gemstone_gem[]" class="form-control">
                    <option selected="" disabled>Select</option>
                    <option value="Diamond" {{ isset($gemstone->attr_gemstone_gem) && $gemstone->attr_gemstone_gem == 'Diamond' ? 'selected' : ''}}> Diamond</option>
                    <option value="Sapphire Yellow" {{ isset($gemstone->attr_gemstone_gem) && $gemstone->attr_gemstone_gem == 'Sapphire Yellow' ? 'selected' : ''}}>Sapphire Yellow</option>
                    <option value="Sapphire Blue" {{ isset($gemstone->attr_gemstone_gem) && $gemstone->attr_gemstone_gem == 'Sapphire Blue' ? 'selected' : ''}}>Sapphire Blue</option>
                    <option value="Sapphire Pink" {{ isset($gemstone->attr_gemstone_gem) && $gemstone->attr_gemstone_gem == 'Sapphire Pink' ? 'selected' : ''}}>Sapphire Pink</option>
                    <option value="Ruby" {{ isset($gemstone->attr_gemstone_gem) && $gemstone->attr_gemstone_gem == 'Ruby' ? 'selected' : ''}}>Ruby</option>
                    <option value="Emerald" {{ isset($gemstone->attr_gemstone_gem) && $gemstone->attr_gemstone_gem == 'Emerald' ? 'selected' : ''}}>Emerald</option>
                    <option value="Moissanite" {{ isset($gemstone->attr_gemstone_gem) && $gemstone->attr_gemstone_gem == 'Moissanite' ? 'selected' : ''}}>Moissanite</option>
                </select>
            </div>
        </div>

        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="form-sec">
                <label for="">Shape <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select shape for gemstone"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                <select name="attr_gemstone_shape[]" class="form-control">
                    <option selected="" disabled>Select</option>
                    <option value="Round" {{ isset($gemstone->attr_gemstone_shape) && $gemstone->attr_gemstone_shape == 'Round' ? 'selected' : ''}}> Round</option>
                    <option value="Princess" {{ isset($gemstone->attr_gemstone_shape) && $gemstone->attr_gemstone_shape == 'Princess' ? 'selected' : ''}}>Princess</option>
                    <option value="Emerald" {{ isset($gemstone->attr_gemstone_shape) && $gemstone->attr_gemstone_shape == 'Emerald' ? 'selected' : ''}}>Emerald</option>
                    <option value="Sq. Emerald" {{ isset($gemstone->attr_gemstone_shape) && $gemstone->attr_gemstone_shape == 'Sq. Emerald' ? 'selected' : ''}}>Sq. Emerald</option>
                    <option value="Asscher" {{ isset($gemstone->attr_gemstone_shape) && $gemstone->attr_gemstone_shape == 'Asscher' ? 'selected' : ''}}>Asscher</option>
                    <option value="Cushion" {{ isset($gemstone->attr_gemstone_shape) && $gemstone->attr_gemstone_shape == 'Cushion' ? 'selected' : ''}}>Cushion</option>
                    <option value="Oval" {{ isset($gemstone->attr_gemstone_shape) && $gemstone->attr_gemstone_shape == 'Oval' ? 'selected' : ''}}>Oval</option>
                    <option value="Radiant" {{ isset($gemstone->attr_gemstone_shape) && $gemstone->attr_gemstone_shape == 'Radiant' ? 'selected' : ''}}>Radiant</option>
                    <option value="Pear" {{ isset($gemstone->attr_gemstone_shape) && $gemstone->attr_gemstone_shape == 'Pear' ? 'selected' : ''}}>Pear</option>
                    <option value="Marquise" {{ isset($gemstone->attr_gemstone_shape) && $gemstone->attr_gemstone_shape == 'Marquise' ? 'selected' : ''}}>Marquise</option>
                    <option value="Heart" {{ isset($gemstone->attr_gemstone_shape) && $gemstone->attr_gemstone_shape == 'Heart' ? 'selected' : ''}}>Heart</option>
                    <option value="Triangle" {{ isset($gemstone->attr_gemstone_shape) && $gemstone->attr_gemstone_shape == 'Triangle' ? 'selected' : ''}}>Triangle</option>
                    <option value="Trilliant" {{ isset($gemstone->attr_gemstone_shape) && $gemstone->attr_gemstone_shape == 'Trilliant' ? 'selected' : ''}}>Trilliant</option>
                    <option value="Baguette" {{ isset($gemstone->attr_gemstone_shape) && $gemstone->attr_gemstone_shape == 'Baguette' ? 'selected' : ''}}>Baguette</option>
                    <option value="Trapezoid" {{ isset($gemstone->attr_gemstone_shape) && $gemstone->attr_gemstone_shape == 'Trapezoid' ? 'selected' : ''}}>Trapezoid</option>
                    <option value="Kite" {{ isset($gemstone->attr_gemstone_shape) && $gemstone->attr_gemstone_shape == 'Kite' ? 'selected' : ''}}>Kite</option>
                    <option value="Rose Cut" {{ isset($gemstone->attr_gemstone_shape) && $gemstone->attr_gemstone_shape == 'Rose Cut' ? 'selected' : ''}}>Rose Cut</option>
                    <option value="Briolette" {{ isset($gemstone->attr_gemstone_shape) && $gemstone->attr_gemstone_shape == 'Briolette' ? 'selected' : ''}}>Briolette</option>
                </select>
            </div>
        </div>

        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="form-sec">
                <label for="">Clarity <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select clarity for gemstone"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                <select name="attr_gemstone_clarity[]" class="form-control">
                    <option selected="" disabled>Select</option>
                    <option value="Translucent" {{ isset($gemstone->attr_gemstone_clarity) && $gemstone->attr_gemstone_clarity == 'Translucent' ? 'selected' : ''}}> Translucent</option>
                    <option value="Opaque" {{ isset($gemstone->attr_gemstone_clarity) && $gemstone->attr_gemstone_clarity == 'Opaque' ? 'selected' : ''}}> Opaque</option>
                    <option value="FL" {{ isset($gemstone->attr_gemstone_clarity) && $gemstone->attr_gemstone_clarity == 'FL' ? 'selected' : ''}}> FL</option>
                    <option value="IF" {{ isset($gemstone->attr_gemstone_clarity) && $gemstone->attr_gemstone_clarity == 'IF' ? 'selected' : ''}}>IF</option>
                    <option value="VVS1" {{ isset($gemstone->attr_gemstone_clarity) && $gemstone->attr_gemstone_clarity == 'VVS1' ? 'selected' : ''}}>VVS1</option>
                    <option value="VVS2" {{ isset($gemstone->attr_gemstone_clarity) && $gemstone->attr_gemstone_clarity == 'VVS2' ? 'selected' : ''}}>VVS2</option>
                    <option value="VS1" {{ isset($gemstone->attr_gemstone_clarity) && $gemstone->attr_gemstone_clarity == 'VS1' ? 'selected' : ''}}>VS1</option>
                    <option value="VS2" {{ isset($gemstone->attr_gemstone_clarity) && $gemstone->attr_gemstone_clarity == 'VS2' ? 'selected' : ''}}>VS2</option>
                    <option value="SI1" {{ isset($gemstone->attr_gemstone_clarity) && $gemstone->attr_gemstone_clarity == 'SI1' ? 'selected' : ''}}>SI1</option>
                    <option value="SI2" {{ isset($gemstone->attr_gemstone_clarity) && $gemstone->attr_gemstone_clarity == 'SI2' ? 'selected' : ''}}>SI2</option>
                    <option value="SI3" {{ isset($gemstone->attr_gemstone_clarity) && $gemstone->attr_gemstone_clarity == 'SI3' ? 'selected' : ''}}>SI3</option>
                    <option value="I1" {{ isset($gemstone->attr_gemstone_clarity) && $gemstone->attr_gemstone_clarity == 'I1' ? 'selected' : ''}}>I1</option>
                    <option value="I2" {{ isset($gemstone->attr_gemstone_clarity) && $gemstone->attr_gemstone_clarity == 'I2' ? 'selected' : ''}}>I2</option>
                    <option value="I3" {{ isset($gemstone->attr_gemstone_clarity) && $gemstone->attr_gemstone_clarity == 'I3' ? 'selected' : ''}}>I3</option>
                </select>
            </div>
        </div>

        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="form-sec">
                <label for="">Cut <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select cut for gemstone"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                <select name="attr_gemstone_cut[]" class="form-control">
                    <option selected="" disabled>Select</option>
                    <option value="Brilliant" {{ isset($gemstone->attr_gemstone_cut) && $gemstone->attr_gemstone_cut == 'Brilliant' ? 'selected' : ''}}> Brilliant</option>
                    <!-- <option value="Ideal" {{ isset($gemstone->attr_gemstone_cut) && $gemstone->attr_gemstone_cut == 'Ideal' ? 'selected' : ''}}> Ideal</option>
                    <option value="Excellent" {{ isset($gemstone->attr_gemstone_cut) && $gemstone->attr_gemstone_cut == 'Excellent' ? 'selected' : ''}}>Excellent</option>
                    <option value="Very Good" {{ isset($gemstone->attr_gemstone_cut) && $gemstone->attr_gemstone_cut == 'Very Good' ? 'selected' : ''}}>Very Good</option>
                    <option value="Good" {{ isset($gemstone->attr_gemstone_cut) && $gemstone->attr_gemstone_cut == 'Good' ? 'selected' : ''}}>Good</option>
                    <option value="Fair" {{ isset($gemstone->attr_gemstone_cut) && $gemstone->attr_gemstone_cut == 'Fair' ? 'selected' : ''}}>Fair</option>
                    <option value="Poor" {{ isset($gemstone->attr_gemstone_cut) && $gemstone->attr_gemstone_cut == 'Poor' ? 'selected' : ''}}>Poor</option> -->
                </select>
            </div>
        </div>

        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="form-sec">
                <label for="">Setting <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select setting for gemstone"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                <select name="attr_gemstone_setting[]" class="form-control">
                    <option selected="" disabled>Select</option>
                    <option value="Prong" {{ isset($gemstone->attr_gemstone_setting) && $gemstone->attr_gemstone_setting == 'Prong' ? 'selected' : ''}}> Prong</option>
                    <option value="Bezel" {{ isset($gemstone->attr_gemstone_setting) && $gemstone->attr_gemstone_setting == 'Bezel' ? 'selected' : ''}}>Bezel</option>
                    <option value="Channel" {{ isset($gemstone->attr_gemstone_setting) && $gemstone->attr_gemstone_setting == 'Channel' ? 'selected' : ''}}>Channel</option>
                    <option value="Pave" {{ isset($gemstone->attr_gemstone_setting) && $gemstone->attr_gemstone_setting == 'Pave' ? 'selected' : ''}}>Pave</option>
                    <option value="Bar" {{ isset($gemstone->attr_gemstone_setting) && $gemstone->attr_gemstone_setting == 'Bar' ? 'selected' : ''}}>Bar</option>
                    <option value="Cluster" {{ isset($gemstone->attr_gemstone_setting) && $gemstone->attr_gemstone_setting == 'Cluster' ? 'selected' : ''}}>Cluster</option>
                    <option value="Halo" {{ isset($gemstone->attr_gemstone_setting) && $gemstone->attr_gemstone_setting == 'Halo' ? 'selected' : ''}}>Halo</option>
                    <option value="Tension" {{ isset($gemstone->attr_gemstone_setting) && $gemstone->attr_gemstone_setting == 'Tension' ? 'selected' : ''}}>Tension</option>
                    <option value="Invisible" {{ isset($gemstone->attr_gemstone_setting) && $gemstone->attr_gemstone_setting == 'Invisible' ? 'selected' : ''}}>Invisible</option>
                    <option value="Bead" {{ isset($gemstone->attr_gemstone_setting) && $gemstone->attr_gemstone_setting == 'Bead' ? 'selected' : ''}}>Bead</option>
                    <option value="Flush" {{ isset($gemstone->attr_gemstone_setting) && $gemstone->attr_gemstone_setting == 'Flush' ? 'selected' : ''}}>Flush</option>
                    <option value="Cup" {{ isset($gemstone->attr_gemstone_setting) && $gemstone->attr_gemstone_setting == 'Cup' ? 'selected' : ''}}>Cup</option>
                    <option value="Wire" {{ isset($gemstone->attr_gemstone_setting) && $gemstone->attr_gemstone_setting == 'Wire' ? 'selected' : ''}}>Wire</option>
                    <option value="Button" {{ isset($gemstone->attr_gemstone_setting) && $gemstone->attr_gemstone_setting == 'Button' ? 'selected' : ''}}>Button</option>
                    <option value="Cage" {{ isset($gemstone->attr_gemstone_setting) && $gemstone->attr_gemstone_setting == 'Cage' ? 'selected' : ''}}>Cage</option>
                </select>
            </div>
        </div>

        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="form-sec">
                <label for="">Total Gemstone Count <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter total gemstone count"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                <input type="text" class="form-control attr_total_gemstone" name="attr_gemstone_total_gem_count[]" id="" placeholder="Enter Total Gemstone Count" value="{{ isset($gemstone->attr_gemstone_total_gem_count) ? $gemstone->attr_gemstone_total_gem_count : '' }}">
            </div>
        </div>

        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 total_gemstone_wight_sec">
            <div class="form-sec">
                <label for="">Total Gemstone Weight  <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter total gemstone weight"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                <input type="text" class="form-control total_gemstone_weight" name="attr_gemstone_total_wight[]" id="" placeholder="Enter Total Gemstone Weight" value="{{ isset($gemstone->attr_gemstone_total_wight) ? $gemstone->attr_gemstone_total_wight : '' }}">
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
                <label for="">Final Gemstone Price <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter final gemstone price"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                <input type="text" class="form-control gemstone_final_total" name="gemstone_final_total[]" id="" placeholder="Enter Final Gemstone Price" value="{{ isset($gemstone->gemstone_final_total) ? $gemstone->gemstone_final_total : '' }}">
            </div>
        </div>

    </div>
</div>
<div id="all_gemstone_div"></div>
@if((isset($loop) && $loop->last) || !isset($loop))
<div class="row add-more-row-sec mb-3">
    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <hr>
        <a type="button" class="add-more-btn all_gemstone_calculate" style="margin-left: 108px;"><i class="fa fa-calculator" aria-hidden="true"></i> Calculate Gemstone Prices</a>
        <a type="button" class="add-more-btn all_gemstone_add"><i class="fa fa-plus" aria-hidden="true"></i> Add More</a>
    </div>

</div>
@endif
 <!-- Gemstone details End  -->

 <!-- Pearls details start -->

 <div class="diamond-deatils-sec @if(isset($key) && $key != 0) mt-4 @endif">
    <div class="row each-diamond-details">
        @if(isset($key) && $key != 0)
        <a><span class="remove_details"><i class="fa fa-times-circle"></i></span></a>
        @endif
        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 sub-heading">
            <h3>Pearls Details</h3>
        </div>

        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="form-sec">
                <label for="">Type <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select type for pearl"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                <select name="attr_pearl_type[]" class="form-control">
                    <option selected="" disabled>Select</option>
                    <option value="Natural" {{ isset($pearl->attr_pearl_type) && $pearl->attr_pearl_type == 'Natural' ? 'selected' : ''}}> Natural</option>
                    <option value="Lab-Grown" {{ isset($pearl->attr_pearl_type) && $pearl->attr_pearl_type == 'Lab-Grown' ? 'selected' : ''}}>Lab-Grown</option>
                    <option value="Cultured" {{ isset($pearl->attr_pearl_type) && $pearl->attr_pearl_type == 'Cultured' ? 'selected' : ''}}>Cultured</option>
                    <option value="Saltwater" {{ isset($pearl->attr_pearl_type) && $pearl->attr_pearl_type == 'Saltwater' ? 'selected' : ''}}>Saltwater</option>
                    <option value="Imitation" {{ isset($pearl->attr_pearl_type) && $pearl->attr_pearl_type == 'Imitation' ? 'selected' : ''}}>Imitation</option>
                </select>
            </div>
        </div>

        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="form-sec">
                <label for="">Colour <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select colour for pearl"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                <select name="attr_pearl_color[]" class="form-control">
                    <option selected="" disabled>Select</option>
                    <option value="Black" {{ isset($pearl->attr_pearl_color) && $pearl->attr_pearl_color == 'Black' ? 'selected' : ''}}>Black</option>
                    <option value="Blue" {{ isset($pearl->attr_pearl_color) && $pearl->attr_pearl_color == 'Blue' ? 'selected' : ''}}>Blue</option>
                    <option value="Brown" {{ isset($pearl->attr_pearl_color) && $pearl->attr_pearl_color == 'Brown' ? 'selected' : ''}}>Brown</option>
                    <option value="Chocolate" {{ isset($pearl->attr_pearl_color) && $pearl->attr_pearl_color == 'Chocolate' ? 'selected' : ''}}>Chocolate</option>
                    <option value="Cream" {{ isset($pearl->attr_pearl_color) && $pearl->attr_pearl_color == 'Cream' ? 'selected' : ''}}>Cream</option>
                    <option value="Golden" {{ isset($pearl->attr_pearl_color) && $pearl->attr_pearl_color == 'Golden' ? 'selected' : ''}}>Golden</option>
                    <option value="Grey" {{ isset($pearl->attr_pearl_color) && $pearl->attr_pearl_color == 'Grey' ? 'selected' : ''}}>Grey</option>
                    <option value="Ivory" {{ isset($pearl->attr_pearl_color) && $pearl->attr_pearl_color == 'Ivory' ? 'selected' : ''}}>Ivory</option>
                    <option value="Lavender" {{ isset($pearl->attr_pearl_color) && $pearl->attr_pearl_color == 'Lavender' ? 'selected' : ''}}>Lavender</option>
                    <option value="Multicolour" {{ isset($pearl->attr_pearl_color) && $pearl->attr_pearl_color == 'Multicolour' ? 'selected' : ''}}>Multicolour</option>
                    <option value="Orange" {{ isset($pearl->attr_pearl_color) && $pearl->attr_pearl_color == 'Orange' ? 'selected' : ''}}>Orange</option>
                    <option value="Peach" {{ isset($pearl->attr_pearl_color) && $pearl->attr_pearl_color == 'Peach' ? 'selected' : ''}}>Peach</option>
                    <option value="Pink" {{ isset($pearl->attr_pearl_color) && $pearl->attr_pearl_color == 'Pink' ? 'selected' : ''}}>Pink</option>
                    <option value="Purple" {{ isset($pearl->attr_pearl_color) && $pearl->attr_pearl_color == 'Purple' ? 'selected' : ''}}>Purple</option>
                    <option value="Silver" {{ isset($pearl->attr_pearl_color) && $pearl->attr_pearl_color == 'Silver' ? 'selected' : ''}}>Silver</option>
                    <option value="White" {{ isset($pearl->attr_pearl_color) && $pearl->attr_pearl_color == 'White' ? 'selected' : ''}}>White</option>
                    <option value="White Gold" {{ isset($pearl->attr_pearl_color) && $pearl->attr_pearl_color == 'White Gold' ? 'selected' : ''}}>White Gold</option>
                    <option value="White Pink" {{ isset($pearl->attr_pearl_color) && $pearl->attr_pearl_color == 'White Pink' ? 'selected' : ''}}>White Pink</option>
                    <option value="Yellow" {{ isset($pearl->attr_pearl_color) && $pearl->attr_pearl_color == 'Yellow' ? 'selected' : ''}}>Yellow</option>
                </select>
            </div>
        </div>

        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 pearl_caret_sec">
            <div class="form-sec">
                <label for="">Total Carat <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter carat for pearl"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                <input type="number" step="0.0001" class="form-control attr_pearl_carat" name="attr_pearl_caret[]" id="" placeholder="Enter Carat" value="{{ isset($pearl->attr_pearl_caret) ? $pearl->attr_pearl_caret : '' }}">
            </div>
        </div>

        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="form-sec">
                <label for="">Pearl <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select type of pearl"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                <select name="attr_pearl_gem[]" class="form-control">
                    <option selected="" disabled>Select</option>
                    <option value="Akoya" {{ isset($pearl->attr_pearl_gem) && $pearl->attr_pearl_gem == 'Akoya' ? 'selected' : ''}}> Akoya</option>
                    <option value="Freshwater" {{ isset($pearl->attr_pearl_gem) && $pearl->attr_pearl_gem == 'Freshwater' ? 'selected' : ''}}>Freshwater</option>
                    <option value="Tahitian" {{ isset($pearl->attr_pearl_gem) && $pearl->attr_pearl_gem == 'Tahitian' ? 'selected' : ''}}>Tahitian</option>
                    <option value="South Sea" {{ isset($pearl->attr_pearl_gem) && $pearl->attr_pearl_gem == 'South Sea' ? 'selected' : ''}}>South Sea</option>
                    <option value="Basara" {{ isset($pearl->attr_pearl_gem) && $pearl->attr_pearl_gem == 'Basara' ? 'selected' : ''}}>Basara</option>
                    <option value="Khakho" {{ isset($pearl->attr_pearl_gem) && $pearl->attr_pearl_gem == 'Khakho' ? 'selected' : ''}}>Khakho</option>
                    <option value="Keshi" {{ isset($pearl->attr_pearl_gem) && $pearl->attr_pearl_gem == 'Keshi' ? 'selected' : ''}}>Keshi</option>
                    <option value="Venezuela" {{ isset($pearl->attr_pearl_gem) && $pearl->attr_pearl_gem == 'Venezuela' ? 'selected' : ''}}>Venezuela</option>
                    <option value="Jeko" {{ isset($pearl->attr_pearl_gem) && $pearl->attr_pearl_gem == 'Jeko' ? 'selected' : ''}}>Jeko</option>
                </select>
            </div>
        </div>

        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="form-sec">
                <label for="">Shape <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select shape for pearl"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                <select name="attr_pearl_shape[]" class="form-control">
                    <option selected="" disabled>Select</option>
                    <option value="Round" {{ isset($pearl->attr_pearl_shape) && $pearl->attr_pearl_shape == 'Round' ? 'selected' : ''}}> Round</option>
                    <option value="Button" {{ isset($pearl->attr_pearl_shape) && $pearl->attr_pearl_shape == 'Button' ? 'selected' : ''}}>Button</option>
                    <option value="Drop" {{ isset($pearl->attr_pearl_shape) && $pearl->attr_pearl_shape == 'Drop' ? 'selected' : ''}}>Drop</option>
                    <option value="Pear" {{ isset($pearl->attr_pearl_shape) && $pearl->attr_pearl_shape == 'Pear' ? 'selected' : ''}}>Pear</option>
                    <option value="Oval" {{ isset($pearl->attr_pearl_shape) && $pearl->attr_pearl_shape == 'Oval' ? 'selected' : ''}}>Oval</option>
                    <option value="Baroque" {{ isset($pearl->attr_pearl_shape) && $pearl->attr_pearl_shape == 'Baroque' ? 'selected' : ''}}>Baroque</option>
                </select>
            </div>
        </div>

        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="form-sec">
                <label for="">Grade <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select grade for pearl"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                <select name="attr_pearl_grade[]" class="form-control">
                    <option selected="" disabled>Select</option>
                    <option value="A" {{ isset($pearl->attr_pearl_grade) && $pearl->attr_pearl_grade == 'A' ? 'selected' : ''}}> A</option>
                    <option value="AA" {{ isset($pearl->attr_pearl_grade) && $pearl->attr_pearl_grade == 'AA' ? 'selected' : ''}}>AA</option>
                    <option value="AAA" {{ isset($pearl->attr_pearl_grade) && $pearl->attr_pearl_grade == 'AAA' ? 'selected' : ''}}>AAA</option>
                    <option value="Hanadama" {{ isset($pearl->attr_pearl_grade) && $pearl->attr_pearl_grade == 'Hanadama' ? 'selected' : ''}}>Hanadama</option>
                </select>
            </div>
        </div>

        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="form-sec">
                <label for="">Setting <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select setting for pearl"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                <select name="attr_pearl_setting[]" class="form-control">
                    <option selected="" disabled>Select</option>
                    <option value="Prong" {{ isset($pearl->attr_pearl_setting) && $pearl->attr_pearl_setting == 'Prong' ? 'selected' : ''}}> Prong</option>
                    <option value="Bezel" {{ isset($pearl->attr_pearl_setting) && $pearl->attr_pearl_setting == 'Bezel' ? 'selected' : ''}}>Bezel</option>
                    <option value="Channel" {{ isset($pearl->attr_pearl_setting) && $pearl->attr_pearl_setting == 'Channel' ? 'selected' : ''}}>Channel</option>
                    <option value="Pave" {{ isset($pearl->attr_pearl_setting) && $pearl->attr_pearl_setting == 'Pave' ? 'selected' : ''}}>Pave</option>
                    <option value="Bar" {{ isset($pearl->attr_pearl_setting) && $pearl->attr_pearl_setting == 'Bar' ? 'selected' : ''}}>Bar</option>
                    <option value="Cluster" {{ isset($pearl->attr_pearl_setting) && $pearl->attr_pearl_setting == 'Cluster' ? 'selected' : ''}}>Cluster</option>
                    <option value="Halo" {{ isset($pearl->attr_pearl_setting) && $pearl->attr_pearl_setting == 'Halo' ? 'selected' : ''}}>Halo</option>
                    <option value="Tension" {{ isset($pearl->attr_pearl_setting) && $pearl->attr_pearl_setting == 'Tension' ? 'selected' : ''}}>Tension</option>
                    <option value="Invisible" {{ isset($pearl->attr_pearl_setting) && $pearl->attr_pearl_setting == 'Invisible' ? 'selected' : ''}}>Invisible</option>
                    <option value="Bead" {{ isset($pearl->attr_pearl_setting) && $pearl->attr_pearl_setting == 'Bead' ? 'selected' : ''}}>Bead</option>
                    <option value="Flush" {{ isset($pearl->attr_pearl_setting) && $pearl->attr_pearl_setting == 'Flush' ? 'selected' : ''}}>Flush</option>
                    <option value="Cup" {{ isset($pearl->attr_pearl_setting) && $pearl->attr_pearl_setting == 'Cup' ? 'selected' : ''}}>Cup</option>
                    <option value="Wire" {{ isset($pearl->attr_pearl_setting) && $pearl->attr_pearl_setting == 'Wire' ? 'selected' : ''}}>Wire</option>
                    <option value="Button" {{ isset($pearl->attr_pearl_setting) && $pearl->attr_pearl_setting == 'Button' ? 'selected' : ''}}>Button</option>
                    <option value="Cage" {{ isset($pearl->attr_pearl_setting) && $pearl->attr_pearl_setting == 'Cage' ? 'selected' : ''}}>Cage</option>
                </select>
            </div>
        </div>

        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="form-sec">
                <label for="">Total Pearl Count <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter total pearl count"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                <input type="text" class="form-control attr_total_pearl" name="attr_pearl_total_gem_count[]" id="" placeholder="Enter Total Pearl Count" value="{{ isset($pearl->attr_pearl_total_gem_count) ? $pearl->attr_pearl_total_gem_count : ''}}">
            </div>
        </div>

        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 total_pearl_wight_sec">
            <div class="form-sec">
                <label for="">Total Pearl Weight <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter total pearl weight"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                <input type="text" class="form-control total_pearl_weight" name="attr_pearl_total_wight[]" id="" placeholder="Enter Total Pearl Weight" value="{{ isset($pearl->attr_pearl_total_wight) ? $pearl->attr_pearl_total_wight : ''}}">
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
                <label for="">Final Pearl Price <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter final pearl price"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                <input type="text" class="form-control pearl_final_total" name="pearl_final_total[]" id="" placeholder="Enter Final Pearl Price" value="{{ isset($pearl->pearl_final_total) ? $pearl->pearl_final_total : ''}}">
            </div>
        </div>

    </div>
</div>
<div id="all_pearl_div"></div>
@if((isset($loop) && $loop->last) || !isset($loop))
 <div class="row add-more-row-sec mb-3">
    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <hr>
         <a type="button" class="add-more-btn all_pearl_calculate" style="margin-left: 108px;"><i class="fa fa-calculator" aria-hidden="true"></i> Calculate Pearl Prices</a>
        <a type="button" class="add-more-btn all_pearl_add"><i class="fa fa-plus" aria-hidden="true"></i> Add More</a>
    </div>

</div>
@endif
 <!-- pearls details end -->