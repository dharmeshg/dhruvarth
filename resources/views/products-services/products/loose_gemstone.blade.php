 <div class="row">
    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="form-sec">
            <label for="">Popular Gemstone <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select type of popular gemstone"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
            <select name="p_popular_gemstone" class="form-control">
                <option selected="" disabled>Select</option>
                <option value="Zodiac Gemstone" {{ isset($product->p_popular_gemstone) && $product->p_popular_gemstone == 'Zodiac Gemstone' ? 'selected' : '' }}>Zodiac Gemstone</option>
                <option value="Astro Birthstones" {{ isset($product->p_popular_gemstone) && $product->p_popular_gemstone == 'Astro Birthstones' ? 'selected' : '' }}>Astro Birthstones</option>
                <option value="Navagraha Gemstones" {{ isset($product->p_popular_gemstone) && $product->p_popular_gemstone == 'Navagraha Gemstones' ? 'selected' : '' }}>Navagraha Gemstones</option>
                <option value="Healing Gemstones" {{ isset($product->p_popular_gemstone) && $product->p_popular_gemstone == 'Healing Gemstones' ? 'selected' : '' }}>Healing Gemstones</option>
                <option value="Precious Gemstones" {{ isset($product->p_popular_gemstone) && $product->p_popular_gemstone == 'Precious Gemstones' ? 'selected' : '' }}>Precious Gemstones</option>
                <option value="Semi-precious Gemstones" {{ isset($product->p_popular_gemstone) && $product->p_popular_gemstone == 'Semi-precious Gemstones' ? 'selected' : '' }}>Semi-precious Gemstones</option>
            </select>
        </div>
    </div>
    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="form-sec">
            <label for="">Shape <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select type of gemstone"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
            <select name="p_gemstone_shape" class="form-control">
                <option selected="" disabled>Select</option>
                <option value="Round" {{ isset($product->p_gemstone_shape) && $product->p_gemstone_shape == 'Round' ? 'selected' : '' }}>Round</option>
                <option value="Princess" {{ isset($product->p_gemstone_shape) && $product->p_gemstone_shape == 'Princess' ? 'selected' : '' }}>Princess</option>
                <option value="Emerald" {{ isset($product->p_gemstone_shape) && $product->p_gemstone_shape == 'Emerald' ? 'selected' : '' }}>Emerald</option>
                <option value="Sq Emerald" {{ isset($product->p_gemstone_shape) && $product->p_gemstone_shape == 'Sq Emerald' ? 'selected' : '' }}>Sq Emerald</option>
                <option value="Asscher" {{ isset($product->p_gemstone_shape) && $product->p_gemstone_shape == 'Asscher' ? 'selected' : '' }}>Asscher</option>
                <option value="Oval" {{ isset($product->p_gemstone_shape) && $product->p_gemstone_shape == 'Oval' ? 'selected' : '' }}>Oval</option>
                <option value="Radiant" {{ isset($product->p_gemstone_shape) && $product->p_gemstone_shape == 'Radiant' ? 'selected' : '' }}>Radiant</option>
                <option value="Pear" {{ isset($product->p_gemstone_shape) && $product->p_gemstone_shape == 'Pear' ? 'selected' : '' }}>Pear</option>
                <option value="Marquise" {{ isset($product->p_gemstone_shape) && $product->p_gemstone_shape == 'Marquise' ? 'selected' : '' }}>Marquise</option>
                <option value="Heart" {{ isset($product->p_gemstone_shape) && $product->p_gemstone_shape == 'Heart' ? 'selected' : '' }}>Heart</option>
                <option value="Triangle" {{ isset($product->p_gemstone_shape) && $product->p_gemstone_shape == 'Triangle' ? 'selected' : '' }}>Triangle</option>
                <option value="Baguette" {{ isset($product->p_gemstone_shape) && $product->p_gemstone_shape == 'Baguette' ? 'selected' : '' }}>Baguette</option>
                <option value="Trapezoid" {{ isset($product->p_gemstone_shape) && $product->p_gemstone_shape == 'Trapezoid' ? 'selected' : '' }}>Trapezoid</option>
                <option value="Kite" {{ isset($product->p_gemstone_shape) && $product->p_gemstone_shape == 'Kite' ? 'selected' : '' }}>Kite</option>
                <option value="Rose Cut" {{ isset($product->p_gemstone_shape) && $product->p_gemstone_shape == 'Rose Cut' ? 'selected' : '' }}>Rose Cut</option>
                <option value="Briolette" {{ isset($product->p_gemstone_shape) && $product->p_gemstone_shape == 'Briolette' ? 'selected' : '' }}>Briolette</option>
            </select>

        </div>
    </div>
    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="form-sec">
            <label for="">Caret <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter caret for gemstone"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
            <input type="text" name="p_gemstone_caret" class="form-control" value="{{ isset($product->p_gemstone_caret) ? $product->p_gemstone_caret : '' }}">
        </div>
    </div>
    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="form-sec">
            <label for="">Colour <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select colour for gemstone"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
            <select name="p_gemstone_color" class="form-control">
                <option selected="" disabled>Select</option>
                <option value="Banded" {{ isset($product->p_gemstone_color) && $product->p_gemstone_color == 'Banded' ? 'selected' : '' }}>Banded</option>
                <option value="Bi-color" {{ isset($product->p_gemstone_color) && $product->p_gemstone_color == 'Bi-color' ? 'selected' : '' }}>Bi-color</option>
                <option value="Black" {{ isset($product->p_gemstone_color) && $product->p_gemstone_color == 'Black' ? 'selected' : '' }}>Black</option>
                <option value="Blue" {{ isset($product->p_gemstone_color) && $product->p_gemstone_color == 'Blue' ? 'selected' : '' }}>Blue</option>
                <option value="Brown" {{ isset($product->p_gemstone_color) && $product->p_gemstone_color == 'Brown' ? 'selected' : '' }}>Brown</option>
                <option value="Color-Change" {{ isset($product->p_gemstone_color) && $product->p_gemstone_color == 'Color-Change' ? 'selected' : '' }}>Color-Change</option>
                <option value="Colorless" {{ isset($product->p_gemstone_color) && $product->p_gemstone_color == 'Colorless' ? 'selected' : '' }}>Colorless</option>
                <option value="Cream" {{ isset($product->p_gemstone_color) && $product->p_gemstone_color == 'Cream' ? 'selected' : '' }}>Cream</option>
                <option value="Golden" {{ isset($product->p_gemstone_color) && $product->p_gemstone_color == 'Golden' ? 'selected' : '' }}>Golden</option>
                <option value="Gray" {{ isset($product->p_gemstone_color) && $product->p_gemstone_color == 'Gray' ? 'selected' : '' }}>Gray</option>
                <option value="Green" {{ isset($product->p_gemstone_color) && $product->p_gemstone_color == 'Green' ? 'selected' : '' }}>Green</option>
                <option value="London Blue" {{ isset($product->p_gemstone_color) && $product->p_gemstone_color == 'London Blue' ? 'selected' : '' }}>London Blue</option>
                <option value="Metallic" {{ isset($product->p_gemstone_color) && $product->p_gemstone_color == 'Metallic' ? 'selected' : '' }}>Metallic</option>
                <option value="Multicolored" {{ isset($product->p_gemstone_color) && $product->p_gemstone_color == 'Multicolored' ? 'selected' : '' }}>Multicolored</option>
                <option value="Orange" {{ isset($product->p_gemstone_color) && $product->p_gemstone_color == 'Orange' ? 'selected' : '' }}>Orange</option>
                <option value="Paraiba" {{ isset($product->p_gemstone_color) && $product->p_gemstone_color == 'Paraiba' ? 'selected' : '' }}>Paraiba</option>
                <option value="Pink" {{ isset($product->p_gemstone_color) && $product->p_gemstone_color == 'Pink' ? 'selected' : '' }}>Pink</option>
                <option value="Purple" {{ isset($product->p_gemstone_color) && $product->p_gemstone_color == 'Purple' ? 'selected' : '' }}>Purple</option>
                <option value="Red" {{ isset($product->p_gemstone_color) && $product->p_gemstone_color == 'Red' ? 'selected' : '' }}>Red</option>
                <option value="Royal Blue" {{ isset($product->p_gemstone_color) && $product->p_gemstone_color == 'Royal Blue' ? 'selected' : '' }}>Royal Blue</option>
                <option value="Silver" {{ isset($product->p_gemstone_color) && $product->p_gemstone_color == 'Silver' ? 'selected' : '' }}>Silver</option>
                <option value="Sky" {{ isset($product->p_gemstone_color) && $product->p_gemstone_color == 'Sky' ? 'selected' : '' }}>Sky</option>
                <option value="Sky Blue" {{ isset($product->p_gemstone_color) && $product->p_gemstone_color == 'Sky Blue' ? 'selected' : '' }}>Sky Blue</option>
                <option value="Smoky" {{ isset($product->p_gemstone_color) && $product->p_gemstone_color == 'Smoky' ? 'selected' : '' }}>Smoky</option>
                <option value="Swiss" {{ isset($product->p_gemstone_color) && $product->p_gemstone_color == 'Swiss' ? 'selected' : '' }}>Swiss</option>
                <option value="Swiss Blue" {{ isset($product->p_gemstone_color) && $product->p_gemstone_color == 'Swiss Blue' ? 'selected' : '' }}>Swiss Blue</option>
                <option value="Violet" {{ isset($product->p_gemstone_color) && $product->p_gemstone_color == 'Violet' ? 'selected' : '' }}>Violet</option>
                <option value="White" {{ isset($product->p_gemstone_color) && $product->p_gemstone_color == 'White' ? 'selected' : '' }}>White</option>
                <option value="Yellow" {{ isset($product->p_gemstone_color) && $product->p_gemstone_color == 'Yellow' ? 'selected' : '' }}>Yellow</option>
                <option value="Other" {{ isset($product->p_gemstone_color) && $product->p_gemstone_color == 'Other' ? 'selected' : '' }}>Other</option>
                <option value="Chocolate" {{ isset($product->p_gemstone_color) && $product->p_gemstone_color == 'Chocolate' ? 'selected' : '' }}>Chocolate</option>
                <option value="Grey" {{ isset($product->p_gemstone_color) && $product->p_gemstone_color == 'Grey' ? 'selected' : '' }}>Grey</option>
                <option value="Ivory" {{ isset($product->p_gemstone_color) && $product->p_gemstone_color == 'Ivory' ? 'selected' : '' }}>Ivory</option>
                <option value="Lavender" {{ isset($product->p_gemstone_color) && $product->p_gemstone_color == 'Lavender' ? 'selected' : '' }}>Lavender</option>
                <option value="Peach" {{ isset($product->p_gemstone_color) && $product->p_gemstone_color == 'Peach' ? 'selected' : '' }}>Peach</option>
                <option value="White Gold" {{ isset($product->p_gemstone_color) && $product->p_gemstone_color == 'White Gold' ? 'selected' : '' }}>White Gold</option>
                <option value="White Pink" {{ isset($product->p_gemstone_color) && $product->p_gemstone_color == 'White Pink' ? 'selected' : '' }}>White Pink</option>
            </select>
        </div>
    </div>
    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="form-sec">
            <label for="">Clarity <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select clarity for gemstone"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
            <select name="p_gemstone_clarity" class="form-control">
                <option selected="" disabled>Select</option>
                <option value="Translucent" {{ isset($product->p_gemstone_clarity) && $product->p_gemstone_clarity == 'Translucent' ? 'selected' : '' }}>Translucent</option>
                <option value="Opaque" {{ isset($product->p_gemstone_clarity) && $product->p_gemstone_clarity == 'Opaque' ? 'selected' : '' }}>Opaque</option>
                <option value="FL" {{ isset($product->p_gemstone_clarity) && $product->p_gemstone_clarity == 'FL' ? 'selected' : '' }}>FL</option>
                <option value="IF" {{ isset($product->p_gemstone_clarity) && $product->p_gemstone_clarity == 'IF' ? 'selected' : '' }}>IF</option>
                <option value="VVS1" {{ isset($product->p_gemstone_clarity) && $product->p_gemstone_clarity == 'VVS1' ? 'selected' : '' }}>VVS1</option>
                <option value="VVS2" {{ isset($product->p_gemstone_clarity) && $product->p_gemstone_clarity == 'VVS2' ? 'selected' : '' }}>VVS2</option>
                <option value="VS1" {{ isset($product->p_gemstone_clarity) && $product->p_gemstone_clarity == 'VS1' ? 'selected' : '' }}>VS1</option>
                <option value="VS2" {{ isset($product->p_gemstone_clarity) && $product->p_gemstone_clarity == 'VS2' ? 'selected' : '' }}>VS2</option>
                <option value="SI1" {{ isset($product->p_gemstone_clarity) && $product->p_gemstone_clarity == 'SI1' ? 'selected' : '' }}>SI1</option>
                <option value="SI2" {{ isset($product->p_gemstone_clarity) && $product->p_gemstone_clarity == 'SI2' ? 'selected' : '' }}>SI2</option>
                <option value="SI3" {{ isset($product->p_gemstone_clarity) && $product->p_gemstone_clarity == 'SI3' ? 'selected' : '' }}>SI3</option>
                <option value="I1" {{ isset($product->p_gemstone_clarity) && $product->p_gemstone_clarity == 'I1' ? 'selected' : '' }}>I1</option>
                <option value="I2" {{ isset($product->p_gemstone_clarity) && $product->p_gemstone_clarity == 'I2' ? 'selected' : '' }}>I2</option>
                <option value="I3" {{ isset($product->p_gemstone_clarity) && $product->p_gemstone_clarity == 'I3' ? 'selected' : '' }}>I3</option>
            </select>

        </div>
    </div>
    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="form-sec">
            <label for="">Cut <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select cut for gemstone"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
            <select name="p_gemstone_cut" class="form-control">
                <option selected="" disabled>Select</option>
                <option value="Cabochon" {{ isset($product->p_gemstone_cut) && $product->p_gemstone_cut == 'Cabochon' ? 'selected' : '' }}>Cabochon</option>
                <option value="Brilliant" {{ isset($product->p_gemstone_cut) && $product->p_gemstone_cut == 'Brilliant' ? 'selected' : '' }}>Brilliant</option>
                <option value="Faceted" {{ isset($product->p_gemstone_cut) && $product->p_gemstone_cut == 'Faceted' ? 'selected' : '' }}>Faceted</option>
                <option value="Carved" {{ isset($product->p_gemstone_cut) && $product->p_gemstone_cut == 'Carved' ? 'selected' : '' }}>Carved</option>
                <option value="Fancy" {{ isset($product->p_gemstone_cut) && $product->p_gemstone_cut == 'Fancy' ? 'selected' : '' }}>Fancy</option>
                <option value="Mix Cut" {{ isset($product->p_gemstone_cut) && $product->p_gemstone_cut == 'Mix Cut' ? 'selected' : '' }}>Mix Cut</option>
                <option value="Step Cut" {{ isset($product->p_gemstone_cut) && $product->p_gemstone_cut == 'Step Cut' ? 'selected' : '' }}>Step Cut</option>
                <option value="Beads" {{ isset($product->p_gemstone_cut) && $product->p_gemstone_cut == 'Beads' ? 'selected' : '' }}>Beads</option>
            </select>
        </div>
    </div>
    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="form-sec">
            <label for="">Teatment <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select teatment for gemstone"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
            <select name="p_gemstone_treatment" class="form-control">
                <option selected="" disabled>Select</option>
                <option value="Buff" {{ isset($product->p_gemstone_treatment) && $product->p_gemstone_treatment == 'Buff' ? 'selected' : '' }}>Buff</option>
                <option value="Unheated" {{ isset($product->p_gemstone_treatment) && $product->p_gemstone_treatment == 'Unheated' ? 'selected' : '' }}>Unheated</option>
                <option value="Tumbled" {{ isset($product->p_gemstone_treatment) && $product->p_gemstone_treatment == 'Tumbled' ? 'selected' : '' }}>Tumbled</option>
                <option value="None" {{ isset($product->p_gemstone_treatment) && $product->p_gemstone_treatment == 'None' ? 'selected' : '' }}>None</option>
                <option value="HPHT" {{ isset($product->p_gemstone_treatment) && $product->p_gemstone_treatment == 'HPHT' ? 'selected' : '' }}>HPHT</option>
                <option value="Beryllium" {{ isset($product->p_gemstone_treatment) && $product->p_gemstone_treatment == 'Beryllium' ? 'selected' : '' }}>Beryllium</option>
                <option value="Coating" {{ isset($product->p_gemstone_treatment) && $product->p_gemstone_treatment == 'Coating' ? 'selected' : '' }}>Coating</option>
                <option value="Diffusion" {{ isset($product->p_gemstone_treatment) && $product->p_gemstone_treatment == 'Diffusion' ? 'selected' : '' }}>Diffusion</option>
                <option value="Dye" {{ isset($product->p_gemstone_treatment) && $product->p_gemstone_treatment == 'Dye' ? 'selected' : '' }}>Dye</option>
                <option value="Heated" {{ isset($product->p_gemstone_treatment) && $product->p_gemstone_treatment == 'Heated' ? 'selected' : '' }}>Heated</option>
                <option value="Irradiation" {{ isset($product->p_gemstone_treatment) && $product->p_gemstone_treatment == 'Irradiation' ? 'selected' : '' }}>Irradiation</option>
                <option value="Oiling" {{ isset($product->p_gemstone_treatment) && $product->p_gemstone_treatment == 'Oiling' ? 'selected' : '' }}>Oiling</option>
                <option value="Thermal" {{ isset($product->p_gemstone_treatment) && $product->p_gemstone_treatment == 'Thermal' ? 'selected' : '' }}>Thermal</option>
                <option value="Treated" {{ isset($product->p_gemstone_treatment) && $product->p_gemstone_treatment == 'Treated' ? 'selected' : '' }}>Treated</option>
                <option value="Waxing" {{ isset($product->p_gemstone_treatment) && $product->p_gemstone_treatment == 'Waxing' ? 'selected' : '' }}>Waxing</option>
                <option value="Untreated" {{ isset($product->p_gemstone_treatment) && $product->p_gemstone_treatment == 'Untreated' ? 'selected' : '' }}>Untreated</option>
                <option value="Coloration" {{ isset($product->p_gemstone_treatment) && $product->p_gemstone_treatment == 'Coloration' ? 'selected' : '' }}>Coloration</option>
                <option value="Bleached" {{ isset($product->p_gemstone_treatment) && $product->p_gemstone_treatment == 'Bleached' ? 'selected' : '' }}>Bleached</option>
            </select>
        </div>
    </div>
</div>