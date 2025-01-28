<div class="each-variant-sec">
    <a><span class="remove_attr_details"><i class="fa fa-times-circle" aria-hidden="true"></i></span></a>
    <div class="row">
        @if (in_array('Metal Purity', $checked_attributes))
        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="form-sec">
                <label for="">Metal Purity <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select metal purity"><i class="fa fa-info-circle" aria-hidden="true" style="color: black;"></i></span></label>
                <select name="variant_metal_purity" class="form-control" id="variant_metal_purity">
                    <option selected="" disabled>Select</option>
                    @if(isset($metal_paurities) && count($metal_paurities) > 0)
                    @foreach($metal_paurities as $purity)
                    <option data-purity="{{$purity->rate}}" value="{{ $purity->id }}" {{ isset($product->p_metal_purity) && $product->p_metal_purity == $purity->id ? 'selected' : ''}}>{{ isset($purity->title) ? $purity->title : '' }}</option>
                    @endforeach
                    @endif
                </select>
            </div>
        </div>
        @endif
        @if (in_array('Metal Color', $checked_attributes))
        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="form-sec">
                <label for="">Metal Color <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select metal purity"><i class="fa fa-info-circle" aria-hidden="true" style="color: black;"></i></span></label>
                <select name="variant_metal_color" class="form-control" id="variant_metal_color">
                    <option selected="" disabled>Select</option>
                    @if(isset($metals) && count($metals) > 0)
                    @foreach($metals as $val)
                    <option value="{{ $val->id }}" {{ isset($product->p_metal_color) && $product->p_metal_color == $val->id ? 'selected' : ''}}>{{ isset($val->title) ? $val->title : '' }}</option>
                    @endforeach
                    @endif
                </select>
            </div>
        </div>
        @endif
        @if (in_array('Metal Purity', $checked_attributes))
        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="form-sec">
                <label for="">Metal Weight <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select metal purity"><i class="fa fa-info-circle" aria-hidden="true" style="color: black;"></i></span></label>
                <input type="number" step="0.0001" class="form-control" name="variant_metal_weigth" id="variant_metal_weigth" placeholder="Enter Metal Weight"  data-parsley-group="block-2">
            </div>
        </div>
        @endif
        @if (in_array('Size/Length/Unit', $checked_attributes))
        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="form-sec">
                <label for="">Size <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select metal purity"><i class="fa fa-info-circle" aria-hidden="true" style="color: black;"></i></span></label>
                <input type="number" step="0.0001" class="form-control" name="variant_size" id="variant_size" placeholder="Enter Size"  data-parsley-group="block-2">
            </div>
        </div>
        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="form-sec">
                <label for="">Lenght <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select metal purity"><i class="fa fa-info-circle" aria-hidden="true" style="color: black;"></i></span></label>
                <input type="number" step="0.0001" class="form-control" name="variant_length" id="variant_length" placeholder="Enter Length"  data-parsley-group="block-2">
            </div>
        </div>
        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="form-sec">
                <label for="">Unit <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select metal purity"><i class="fa fa-info-circle" aria-hidden="true" style="color: black;"></i></span></label>
                <select name="variant_unit" class="form-control" id="variant_unit">
                    <option selected="" disabled>Select</option>
                    <option value="Kilogram">Kilogram</option>
                    <option value="grams" >Grams</option>
                    <option value="Carat">Carat</option>
                    <option value="Milligram">Milligram</option>
                    <option value="Pieces">Pieces</option>
                    <option value="Ounce">Ounce</option>
                </select>
            </div>
        </div>
        @endif
        @if (in_array('Gender', $checked_attributes))
        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="form-sec">
                <label for="">Gender <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select metal purity"><i class="fa fa-info-circle" aria-hidden="true" style="color: black;"></i></span></label>
                <select name="variant_gender" class="form-control">
                    <option selected="" disabled>Select</option>
                    <option value="Men">Men</option>
                    <option value="Women">Women</option>
                    <option value="Kids">Kids</option>
                    <option value="Unisex">Unisex</option>
                </select>
            </div>
        </div>
        @endif
        @if (in_array('Certificate', $checked_attributes))
        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="form-sec">
                <label for="">Certificate No. <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select metal purity"><i class="fa fa-info-circle" aria-hidden="true" style="color: black;"></i></span></label>
                <input type="number" step="0.0001" class="form-control" name="variant_certificate" id="variant_certificate" placeholder="Enter Certificate No."  data-parsley-group="block-2">
            </div>
        </div>
        @endif
    </div>
</div>