<div class="delivery-field-sec mt-4">
    <div class="row delivery-field-sec-row">
        @if((isset($key) && $key != 0) || !isset($key))
        <a><span class="remove_deliver_sec"><i class="fa fa-times-circle"></i></span></a>
        @endif
        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="form-sec">
                <label for="">Country <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select Country"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                <select name="p_deliver_contry[{{isset($counter) ? $counter : $key+1}}][]" class="form-control delivery_country select2" >
                    <option selected="" disabled>Select Country
                    </option>
                    @if(isset($countries) && count($countries) > 0)
                    @foreach($countries as $country)
                    <option value="{{ $country->id }}" {{ isset($delivery->p_deliver_contry) && $delivery->p_deliver_contry == $country->id ? 'selected' : ''}}>{{ isset($country->name) ? $country->name : '' }}</option>
                    @endforeach
                    @endif
                </select>
            </div>
        </div>

        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="form-sec state_sec">
                <label for="">State (Multiple) <span data-bs-toggle="tooltip" data-bs-placement="right" title="You can select multiple States"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                <select name="p_deliver_state[{{isset($counter) ? $counter : $key+1}}][]" class="form-control delivery_state select2" multiple id="del_state_{{isset($counter) ? $counter : $key+1}}">

                </select>
            </div>
        </div>
        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="form-sec city_sec">
                    <label for="">City (Multiple) <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select any city"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                    <select name="p_deliver_city[{{isset($counter) ? $counter : $key+1}}][]" class="form-control delivery_city select2" multiple id="del_city_{{isset($counter) ? $counter : $key+1}}">
                        
                    </select>
            </div>
        </div>
        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="form-sec zip_sec">
                <label for="">Post Code / Zip Code (Multiple) <span data-bs-toggle="tooltip" data-bs-placement="right" title="You can select multiple Zipcodes"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                <select name="p_deliver_code[{{isset($counter) ? $counter : $key+1}}][]" class="form-control select2 delivery_zip" multiple id="del_code_{{isset($counter) ? $counter : $key+1}}">
                    
                </select>
            </div>
        </div>
        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="form-sec">
                <label for="">Processing Time <span data-bs-toggle="tooltip" data-bs-placement="right" title="Mention Total no of days for Shipping estimation"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                <input type="text" class="form-control" name="p_deliver_duration[{{isset($counter) ? $counter : $key+1}}][]" id="" placeholder="Enter Processing Time" value="{{ isset($delivery->p_deliver_duration) ? $delivery->p_deliver_duration : ''}}">
            </div>
        </div>
    </div>
</div>