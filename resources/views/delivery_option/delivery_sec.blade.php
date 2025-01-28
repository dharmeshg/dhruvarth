<div class="delivery-field-sec mt-4">
    <div class="row delivery-field-sec-row">
        <input type="hidden" name="each_shipping_id[{{isset($counter) ? $counter : $key+1}}][]" value="{{ isset($item) ? $item->id : '' }}">
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
                    <option value="{{ $country->id }}" {{ isset($item->country) && $item->country == $country->id ? 'selected' : ''}}>{{ isset($country->name) ? $country->name : '' }}</option>
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
                <input type="text" class="form-control" name="p_deliver_duration[{{isset($counter) ? $counter : $key+1}}][]" id="" placeholder="Enter Processing Time" value="{{ isset($item->  p_time) ? $item-> p_time : ''}}">
            </div>
        </div>
        @if(isset($item) && $item != null)
            @php
                $calculations = App\Models\ShippingCalculation::where('shipping_id',$item->id)->first();
                if(isset($calculations->data) && $calculations->data != null && $calculations->data != '')
                {
                    $json_data = json_decode($calculations->data);
                }
            @endphp
        @endif
        <h5>Shipping Calculation</h5>
        <div class="">
            <div class="row delivery-field-sec-row">
                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-sec">
                         <label for=""></label>
                        <div class="radio-options">
                            <label class="radio-inline">
                                <input type="radio" name="shipping_type_{{$counter}}[]" class="shipping_type" value="fixed" {{ isset($calculations) && $calculations->type == 'fixed' ? 'checked' : '' }}>Fixed
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="shipping_type_{{$counter}}[]" class="shipping_type" value="on_price" {{ isset($calculations) && $calculations->type == 'on_price' ? 'checked' : '' }}>On Price
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="shipping_type_{{$counter}}[]" class="shipping_type" value="on_weight" {{ isset($calculations) && $calculations->type == 'on_weight' ? 'checked' : '' }}>On Weight
                            </label>
                        </div>
                    </div>
                </div>
                <div id="fixed_charge" class="fixed_charge" {{ isset($calculations) && $calculations->type == 'fixed' ? 'style=display:block' : 'style=display:none' }}>
                    <input type="hidden" name="calculation_id_{{$counter}}[]" value="{{ isset($calculations) ? $calculations->id : ''}}">
                    <div class="row">
                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="form-sec">
                                 <label for="">Shipping Charges <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter Shipping Charges"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                 <input type="number" class="form-control" name="fixed_shipping_charge_{{$counter}}[]" id="" placeholder="Enter Shipping Charges" value="{{ isset($calculations->fix_charge) ? $calculations->fix_charge : '' }}" data-parsley-group="block-0" step="0.0001">
                            </div>
                        </div>
                    </div>
                </div>
                <div id="on_price_charge" class="on_price_charge" {{ isset($calculations) && $calculations->type == 'on_price' ? 'style=display:block' : 'style=display:none' }}>
                    <input type="hidden" name="calculation_id_{{$counter}}[]" value="{{ isset($calculations) ? $calculations->id : ''}}">
                    @if(isset($json_data) && count($json_data) > 0)
                    @foreach($json_data as $index => $json)
                    <div class="row each-ship-price-row">
                        <input type="hidden" value="yes" name="price_hidden_{{$counter}}[]">
                        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <div class="form-sec">
                                 <label for="">From <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter From Amount"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                 <input type="number" class="form-control" name="price_from_amount_{{$counter}}[]" id="" placeholder="Enter From Amount" value="{{ isset($json->from) ? $json->from : '' }}" data-parsley-group="block-0" step="0.0001">
                            </div>
                        </div>
                        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <div class="form-sec">
                                 <label for="">To <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter To Amount"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                 <input type="number" class="form-control" name="price_to_amount_{{$counter}}[]" id="" placeholder="Enter To Amount" value="{{ isset($json->to) ? $json->to : '' }}" data-parsley-group="block-0" step="0.0001">
                            </div>
                        </div>
                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div class="form-sec">
                                 <label for="">Shipping Charges <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter Shipping Charges"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                 <input type="number" class="form-control" name="price_shipping_charge_{{$counter}}[]" id="" placeholder="Enter Shipping Charges" value="{{ isset($json->shipping_amount) ? $json->shipping_amount : '' }}" data-parsley-group="block-0" step="0.0001">
                            </div>
                        </div>
                        <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12 last_add_div">
                            <label for=""></label>
                            @if(isset($index) && $index != 0)
                            <a><span class="remove_charge_amount"><i class="fa fa-minus-circle" aria-hidden="true"></i></span></a>
                            @else
                            <a><span class="add_charge_amount" data-counter="{{$counter}}"><i class='fas fa-plus-circle'></i></span></a>
                            @endif
                        </div>
                    </div>
                    @endforeach
                    @else
                    <div class="row each-ship-price-row">
                        <input type="hidden" value="yes" name="price_hidden_{{$counter}}[]">
                        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <div class="form-sec">
                                 <label for="">From <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter From Amount"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                 <input type="number" class="form-control" name="price_from_amount_{{$counter}}[]" id="" placeholder="Enter From Amount" value="" data-parsley-group="block-0" step="0.0001">
                            </div>
                        </div>
                        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <div class="form-sec">
                                 <label for="">To <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter To Amount"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                 <input type="number" class="form-control" name="price_to_amount_{{$counter}}[]" id="" placeholder="Enter To Amount" value="" data-parsley-group="block-0" step="0.0001">
                            </div>
                        </div>
                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div class="form-sec">
                                 <label for="">Shipping Charges <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter Shipping Charges"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                 <input type="number" class="form-control" name="price_shipping_charge_{{$counter}}[]" id="" placeholder="Enter Shipping Charges" value="" data-parsley-group="block-0" step="0.0001">
                            </div>
                        </div>
                        <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12 last_add_div">
                            <label for=""></label>
                            <a><span class="add_charge_amount" data-counter="{{$counter}}"><i class='fas fa-plus-circle'></i></span></a>
                        </div>
                    </div>
                    @endif
                    <div id="amout_ship_div" class="amout_ship_div"></div>
                    <div class="row">
                        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <div class="form-sec">
                                 <label for="">From Amount Above <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter From Amount Above"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                 <input type="number" class="form-control" name="price_above_amount_{{$counter}}[]" id="" placeholder="Enter From Amount Above" value="{{ isset($calculations->above_amount) ? $calculations->above_amount : '' }}" data-parsley-group="block-0" step="0.0001">
                            </div>
                        </div>
                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div class="form-sec">
                                 <label for="">Shipping Charges <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter Shipping Charges"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                 <input type="number" class="form-control" name="price_above_shipping_charge_{{$counter}}[]" id="" placeholder="Enter Shipping Charges" value="{{ isset($calculations->above_amount_shipping_charge) ? $calculations->above_amount_shipping_charge : '' }}" data-parsley-group="block-0" step="0.0001">
                            </div>
                        </div>
                    </div>
                </div>
                <div id="on_weight_charge" class="on_weight_charge" {{ isset($calculations) && $calculations->type == 'on_weight' ? 'style=display:block' : 'style=display:none' }}>
                    <input type="hidden" name="calculation_id_{{$counter}}[]" value="{{ isset($calculations) ? $calculations->id : ''}}">
                    @if(isset($json_data) && count($json_data) > 0)
                    @foreach($json_data as $index => $json)
                    <div class="row each-ship-weight-row">
                        <input type="hidden" value="yes" name="weight_hidden_{{$counter}}[]">
                        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <div class="form-sec">
                                 <label for="">From <span data-bs-toggle="tooltip" data-bs-placement="right" title="Enter Weight in Grams"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                 <input type="number" class="form-control" name="weight_from_amount_{{$counter}}[]" id="" placeholder="Enter From Weight" value="{{ isset($json->from) ? $json->from : '' }}" data-parsley-group="block-0" step="0.0001">
                            </div>
                        </div>
                        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <div class="form-sec">
                                 <label for="">To <span data-bs-toggle="tooltip" data-bs-placement="right" title="Enter Weight in Grams"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                 <input type="number" class="form-control" name="weight_to_amount_{{$counter}}[]" id="" placeholder="Enter To Weight" value="{{ isset($json->to) ? $json->to : '' }}" data-parsley-group="block-0" step="0.0001">
                            </div>
                        </div>
                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div class="form-sec">
                                 <label for="">Shipping Charges <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter Shipping Charges"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                 <input type="number" class="form-control" name="weight_shipping_charge_{{$counter}}[]" id="" placeholder="Enter Shipping Charges" value="{{ isset($json->shipping_amount) ? $json->shipping_amount : '' }}" data-parsley-group="block-0" step="0.0001" >
                            </div>
                        </div>
                        <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12 last_add_div">
                            <label for=""></label>
                            @if(isset($index) && $index != 0)
                            <a><span class="remove_weight_amount"><i class="fa fa-minus-circle" aria-hidden="true"></i></span></a>
                            @else
                            <a><span class="add_weight_amount" data-counter={{$counter}}><i class='fas fa-plus-circle'></i></span></a>
                            @endif
                        </div>
                    </div>
                    @endforeach
                    @else
                    <div class="row each-ship-weight-row">
                        <input type="hidden" value="yes" name="weight_hidden_{{$counter}}[]">
                        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <div class="form-sec">
                                 <label for="">From <span data-bs-toggle="tooltip" data-bs-placement="right" title="Enter Weight in Grams"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                 <input type="number" class="form-control" name="weight_from_amount_{{$counter}}[]" id="" placeholder="Enter From Weight" value="" data-parsley-group="block-0" step="0.0001">
                            </div>
                        </div>
                        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <div class="form-sec">
                                 <label for="">To <span data-bs-toggle="tooltip" data-bs-placement="right" title="Enter Weight in Grams"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                 <input type="number" class="form-control" name="weight_to_amount_{{$counter}}[]" id="" placeholder="Enter To Weight" value="" data-parsley-group="block-0" step="0.0001">
                            </div>
                        </div>
                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div class="form-sec">
                                 <label for="">Shipping Charges <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter Shipping Charges"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                 <input type="number" class="form-control" name="weight_shipping_charge_{{$counter}}[]" id="" placeholder="Enter Shipping Charges" value="" data-parsley-group="block-0" step="0.0001" >
                            </div>
                        </div>
                        <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12 last_add_div">
                            <label for=""></label>
                            <a><span class="add_weight_amount" data-counter={{$counter}}><i class='fas fa-plus-circle'></i></span></a>
                        </div>
                    </div>
                    @endif
                    <div id="amout_weight_div" class="amout_weight_div"></div>
                    <div class="row">
                        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <div class="form-sec">
                                 <label for="">From weight Above <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter From weight Above"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                 <input type="number" class="form-control" name="weight_above_amount_{{$counter}}[]" id="" placeholder="Enter From weight Above" value="{{ isset($calculations->above_weight) ? $calculations->above_weight : '' }}" data-parsley-group="block-0" step="0.0001">
                            </div>
                        </div>
                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div class="form-sec">
                                 <label for="">Shipping Charges <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter Shipping Charges"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                 <input type="number" class="form-control" name="weight_above_shipping_charge_{{$counter}}[]" id="" placeholder="Enter Shipping Charges" value="{{ isset($calculations->above_weight_shipping_charge) ? $calculations->above_weight_shipping_charge : '' }}" data-parsley-group="block-0" step="0.0001">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>