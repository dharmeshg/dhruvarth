 <div class="row">
    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="form-sec">
            <label for="">Popular Gemstone <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select type of popular gemstone"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
            <select name="p_popular_gemstone" class="form-control">
                <option selected="" disabled>Select</option>
                @if(isset($popular_gemstones) && count($popular_gemstones) > 0)
                @foreach($popular_gemstones as $popular_gemstone) 
                <option value="{{ $popular_gemstone->title }}" {{ isset($product->p_popular_gemstone) && $product->p_popular_gemstone == $popular_gemstone->title ? 'selected' : '' }}>{{ isset($popular_gemstone->title) ? $popular_gemstone->title : '' }}</option>
                @endforeach
                @endif
            </select>
        </div>
    </div>
    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="form-sec">
            <label for="">Shape <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select type of gemstone"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
            <select name="p_gemstone_shape" class="form-control">
                <option selected="" disabled>Select</option>
                @if(isset($gem_shapes) && count($gem_shapes) > 0)
                @foreach($gem_shapes as $gem_shape) 
                <option value="{{ $gem_shape->title }}" {{ isset($product->p_gemstone_shape) && $product->p_gemstone_shape == $gem_shape->title ? 'selected' : '' }}>{{ isset($gem_shape->title) ? $gem_shape->title : '' }}</option>
                @endforeach
                @endif
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
                @if(isset($gem_colors) && count($gem_colors) > 0)
                @foreach($gem_colors as $gem_color) 
                <option value="{{ $gem_color->title }}" {{ isset($product->p_gemstone_color) && $product->p_gemstone_color == $gem_color->title ? 'selected' : '' }}>{{ isset($gem_color->title) ? $gem_color->title : '' }}</option>
                @endforeach
                @endif
            </select>
        </div>
    </div>
    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="form-sec">
            <label for="">Clarity <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select clarity for gemstone"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
            <select name="p_gemstone_clarity" class="form-control">
                <option selected="" disabled>Select</option>
                @if(isset($gem_claritys) && count($gem_claritys) > 0)
                @foreach($gem_claritys as $gem_clarity) 
                <option value="{{ $gem_clarity->title }}" {{ isset($product->p_gemstone_clarity) && $product->p_gemstone_clarity == $gem_clarity->title ? 'selected' : '' }}>{{ isset($gem_clarity->title) ? $gem_clarity->title : '' }}</option>
                @endforeach
                @endif
            </select>

        </div>
    </div>
    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="form-sec">
            <label for="">Cut <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select cut for gemstone"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
            <select name="p_gemstone_cut" class="form-control">
                <option selected="" disabled>Select</option>
                @if(isset($gem_cuts) && count($gem_cuts) > 0)
                @foreach($gem_cuts as $gem_cut) 
                <option value="{{ $gem_cut->title }}" {{ isset($product->p_gemstone_cut) && $product->p_gemstone_cut == $gem_cut->title ? 'selected' : '' }}>{{ isset($gem_cut->title) ? $gem_cut->title : '' }}</option>
                @endforeach
                @endif
            </select>
        </div>
    </div>
    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="form-sec">
            <label for="">Teatment <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select teatment for gemstone"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
            <select name="p_gemstone_treatment" class="form-control">
                <option selected="" disabled>Select</option>
                @if(isset($gemstone_treatments) && count($gemstone_treatments) > 0)
                @foreach($gemstone_treatments as $gemstone_treatment) 
                <option value="{{ $gemstone_treatment->title }}" {{ isset($product->p_gemstone_treatment) && $product->p_gemstone_treatment == $gemstone_treatment->title ? 'selected' : '' }}>{{ isset($gemstone_treatment->title) ? $gemstone_treatment->title : '' }}</option>
                @endforeach
                @endif
            </select>
        </div>
    </div>
</div>