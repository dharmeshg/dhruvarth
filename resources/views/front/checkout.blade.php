@extends('front.layout.index')

{{-- Seo Schema Start --}}
@section('seoSchemaContent')
    {{-- <script type='application/ld+json'>{!! $SEOSchemaCode !!}</script> --}}
@endsection
{{-- Seo Schema End --}}

@section('main_content')
<div class="margin-top-head @if($display_pg == 1) header-note @endif"></div>

    <section class="common-section all-product-list-section">
        <div class="container-md">
            <div class="row">
                <div class="col-xxl-8">
                    <span class="d-flex page-nav-text">
                        <a href="{{ route('home') }}" aria-label="home"><img src="{{asset('front/src/images/home-icon.svg')}}" alt="Home" width="auto" height="auto"></a> <span class="dash-line">/</span>
                        <a aria-label="home icon">Checkout</a>
                    </span>
                </div>
            </div>
        </div>
    </section>

    <section class="user-form">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 order-1">
                    <form class="contact-detail">
                        <div class="user-form-single">
                            <h3>Personal Information</h3>
                            <div class="row">
                                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group @if (isset($user_address->fullname) && !empty($user_address->fullname)) focused @endif">
                                        <label class="control-label">Enter Your Name</label>
                                        <input type="text" name="fullname" id="fullname" class="form-control"
                                            value="@if (isset($user_address->fullname) && !empty($user_address->fullname)) {{$user_address->fullname}} @endif" />
                                    </div>
                                    <div class="invalid-feedback" id="msg_fullname"></div>
                                </div>
                                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group @if (isset($user_address->email) && !empty($user_address->email)) focused @endif">
                                        <label class="control-label">Enter Your Email</label>
                                        <input type="email" name="email" id="email" class="form-control"
                                            value="@if (isset($user_address->email) && !empty($user_address->email)) {{$user_address->email}} @endif" />
                                    </div>
                                    <div class="invalid-feedback" id="msg_email"></div>
                                </div>
                                
                                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group @if (isset($user_address->gst_number) && !empty($user_address->gst_number)) focused @endif">
                                        <label class="control-label">Enter GST Number (Optional)</label>
                                        <input type="text" name="gst_number" id="gst_number" class="form-control" value="@if (isset($user_address->gst_number) && !empty($user_address->gst_number)) {{$user_address->gst_number}} @endif"/>
                                    </div>
                                    <div class="invalid-feedback" id="msg_gst_number"></div>
                                </div>
                            </div>
                        </div>
                        <div class="user-form-single">
                            <h3>Billing Address</h3>
                            <div class="row">
                                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group @if (isset($user_address->address) && !empty($user_address->address)) focused @endif">
                                        <label class="control-label">Address 1</label>
                                        <input type="text" name="address" id="address" class="form-control"
                                            value="@if (isset($user_address->address) && !empty($user_address->address)) {{$user_address->address}} @endif" />
                                    </div>
                                    <div class="invalid-feedback" id="msg_address"></div>
                                </div>
                                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group @if (isset($user_address->address2) && !empty($user_address->address2)) focused @endif">
                                        <label class="control-label">Address 2</label>
                                        <input type="text" name="address2" id="address2" class="form-control"
                                            value="@if (isset($user_address->address2) && !empty($user_address->address2)) {{$user_address->address2}} @endif" />
                                    </div>
                                </div>
                                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label">Country</label>
                                        <!-- <input type="text" name="country" id="country" class="form-control"
                                            value="@if (isset($user_address->country) && !empty($user_address->country)) {{$user_address->country}} @endif" /> -->
                                        <select name="country" id="country" class="form-control">
                                            <option>Select</option>
                                            @if(isset($countries) && count($countries) > 0)
                                            @foreach($countries as $country)
                                            <option value="{{ $country->id }}" {{ isset($user_address->country) && $user_address->country == $country->id ? 'selected' : '' }}>{{ isset($country->name) ? $country->name : '' }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="invalid-feedback" id="msg_country"></div>
                                </div>
                                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label">State</label>
                                        <!-- <input type="text" name="state" id="state" class="form-control"
                                            value="@if (isset($user_address->state) && !empty($user_address->state)) {{$user_address->state}} @endif" /> -->
                                            <select name="state" id="state" class="form-control">
                                                <option>Select State</option>
                                            </select>
                                    </div>
                                    <div class="invalid-feedback" id="msg_state"></div>
                                </div>
                                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label">City</label>
                                        <!-- <input type="text" name="city" id="city" class="form-control"
                                            value="@if (isset($user_address->city) && !empty($user_address->city)) {{$user_address->city}} @endif" /> -->
                                            <select name="city" id="city" class="form-control">
                                                <option>Select City</option>
                                            </select>
                                    </div>
                                    <div class="invalid-feedback" id="msg_city"></div>
                                </div>
                                
                                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label">Pincode</label>
                                        <input type="text" name="zipcode" id="zipcode" class="form-control"
                                            value="@if (isset($user_address->zipcode) && !empty($user_address->zipcode)) {{$user_address->zipcode}} @endif" />
                                    </div>
                                    <div class="invalid-feedback" id="msg_zip"></div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-4 order-1">
                    <?php
                    if (isset($shipping_amount) && !empty($shipping_amount)) {
                        $shipping_amount = $shipping_amount;
                    } else {
                        $shipping_amount = 0.0;
                    }
                    ?>
                    <div class="order-summary-main">
                        <div class="order-summary">
                            <div class="order-summary-bottom">

                                @if (isset($cart_list) && !empty($cart_list))
                                @php

                                    $totalGrandPrice = 0;
                                    $totalqty = 0;
                                    $php_array = [];
                                    $hasZeroValue = false;
                                    $p_pay_type = [];
                                @endphp
                                @foreach ($cart_list as $single_cart_list)
                                @php
                                    if($single_cart_list['product_type'] == 'simple')
                                    {
                                        $product = App\Models\Product::where('id',$single_cart_list['product_id'])->first();
                                    }else{
                                        $product = App\Models\VariantProduct::where('id',$single_cart_list['product_id'])->first();
                                    }
                                    
                                    if(!$product){
                                        continue;
                                    }
                                    $each_p_pay_type = [
                                        'p_payment_g' => isset($product->p_payment_g) ? $product->p_payment_g : NULL,
                                        'p_cod' => isset($product->p_cod) ? $product->p_cod : NULL,
                                        'p_ccod' => isset($product->p_ccod) ? $product->p_ccod : NULL,
                                    ];
                                    $total_price = str_replace(',', '', $product->total_price($product->id));
                                    $total_price_numeric = (float) $total_price;
                                    $product_price = $total_price_numeric * $single_cart_list['qty'];
                                    $php_array[] = $product_price;
                                    $totalGrandPrice += $product_price;
                                    $totalqty += $single_cart_list['qty'];
                                    $p_pay_type[] = $each_p_pay_type;
                                @endphp
                                @endforeach
                                @endif
                                @foreach ($php_array as $price)
                                    @if ($price === 0.0 || $price === 0.00)
                                        @php
                                            $hasZeroValue = true; 
                                        @endphp
                                        @break
                                    @endif
                                @endforeach
                                <h5>Order Summary</h5>
                                
                                <div class="summary-list">
                                    <div class="summary-list-single">
                                        <label>Order Total ({{ $totalqty }} Items)</label>
                                        <span id="order_total">{{ number_format($totalGrandPrice, 2) }}</span>
                                    </div>
                                    @if (isset($promoCodeData) && $promoCodeData != '' && $promoCodeData != null )
                                        @if(isset($promoCodeData['promo_discount']) && $promoCodeData['promo_discount'] != null && $promoCodeData['promo_discount'] != '0.00')
                                        <div class="summary-list-single" id="order_summary_discount">
                                            <label>Your Saving</label>
                                            <span id="discounted_price"> - {{ $promoCodeData['promo_discount'] }}</span>
                                        </div>
                                        @php
                                            $promoDiscount = floatval(str_replace(',', '', $promoCodeData['promo_discount']));
                                            $totalGrandPrice = $totalGrandPrice - $promoDiscount;
                                        @endphp
                                        <div class="display_pro_title mb-3"><span id="promo_title"></span></div>
                                        @endif
                                    @endif
                                    <div class="summary-list-single" id="shipping_charge_div" style="display: none;">
                                        <label>Shipping Charges</label>
                                        <span id="shiping_charges"></span>
                                    </div>
                                    <div class="summary-list-single">
                                        <label>You Pay</label>
                                        <span class="order-total" id="you_pay">{{ number_format($totalGrandPrice, 2) }}</span>
                                    </div>
                                    <div class="inclusive-text">(Inclusive Of All Taxes*)</div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="cart_id" value=>
                        <input type="hidden" id="grand_total" value="{{$totalGrandPrice}}">
                        <div class="order-summary">
                            @php
                            $gs = App\Models\Setting::first();
                            $payment_gateway = false;
                            $cod = false;
                            $ccod = false;
                            $all_products_same_values = true;
                            $unique_payment_gateway_values = [];
                            $unique_cod_values = [];
                            $unique_ccod_values = [];
                       
                            /*foreach ($p_pay_type as $product) {
                                $unique_payment_gateway_values[] = $product["p_payment_g"];
                                $unique_cod_values[] = $product["p_cod"];
                                $unique_ccod_values[] = $product["p_ccod"];
                                if ($product["p_payment_g"] !== $p_pay_type[0]["p_payment_g"] || 
                                    $product["p_cod"] !== $p_pay_type[0]["p_cod"] || 
                                    $product["p_ccod"] !== $p_pay_type[0]["p_ccod"]) {
                                    $all_products_same_values = false;
                                }
                                if ($product["p_payment_g"] === "yes" && $product["p_cod"] === "no" && $product["p_ccod"] === "no") {
                                    $payment_gateway = true;
                                    $cod = false;
                                    $ccod = false;
                                    break;
                                }

                            }

                            if ($all_products_same_values) {
                                $payment_gateway = true;
                                $cod = true;
                                $ccod = true;                         
                            }*/

                            foreach ($p_pay_type as $product) {
                                $unique_payment_gateway_values[] = $product["p_payment_g"];
                                $unique_cod_values[] = $product["p_cod"];
                                $unique_ccod_values[] = $product["p_ccod"];
                            }

                            if (in_array(true, $unique_payment_gateway_values) && count($unique_payment_gateway_values) == count($p_pay_type))
                            {
                                $payment_gateway = true;
                            }
                            if (in_array(true, $unique_cod_values))
                            {
                                $cod = true;
                            }
                            if (in_array(true, $unique_ccod_values))
                            {
                                $ccod = true;
                            }

                            /*if ($all_products_same_values) {
                                $payment_gateway = true;
                                $cod = true;
                                $ccod = true;                         
                            }*/
                           
                            @endphp
                            @if(isset($hasZeroValue) && $hasZeroValue == false)
                                @if(isset($gs) && isset($gs->payment_g) && isset($gs->cod) && isset($gs->ccod) &&
                                    ($gs->payment_g == 'yes' || $gs->cod == 'yes' || $gs->ccod == 'yes') || (isset($payment_gateway) && $payment_gateway == true || (isset($cod) && $cod == true) || (isset($ccod) && $ccod == true)))
                            <div class="order-summary-bottom-last">
                                <div class="summary-list">
                                    <h5>Pay With</h5>
                                    <div class="cart-wrap d-flex align-items-center">
                                        @php
                                            $razorpay = 'No';
                                            $Paypal = 'No';
                                            $cashdelevary = 'No';
                                            $cashfree = 'No';
                                        @endphp
                                            @if($gs->payment_g == 'yes' || (isset($payment_gateway) && $payment_gateway == true))
                                            @if(isset($bs->payment_method_type) && $bs->payment_method_type != null && $bs->payment_method_type == 'Cashfree')
                                            <div class="form-check" style="margin-right: 20px;">
                                                <input id="{{ Str::slug('Cashfree') }}"
                                                    name="paymentMethod" type="radio"
                                                    value="Cashfree" class="form-check-input"
                                                    checked>
                                                <label class="form-check-label"
                                                    for="{{ Str::slug('Cashfree') }}" style="cursor: pointer;">Cashfree</label>
                                            </div>
                                            @endif
                                            @if(isset($bs->payment_method_type) && $bs->payment_method_type != null && $bs->payment_method_type == 'razor_pay')
                                            <div class="form-check" style="margin-right: 20px;">
                                                <input id="{{ Str::slug('razor_pay') }}"
                                                    name="paymentMethod" type="radio"
                                                    value="razor_pay" class="form-check-input"
                                                    checked>
                                                <label class="form-check-label"
                                                    for="{{ Str::slug('razor_pay') }}" style="cursor: pointer;">Razor Pay / Online</label>
                                            </div>
                                            @endif
                                            @endif
                                            @if($gs->cod == 'yes' || (isset($cod) && $cod == true))
                                            <div class="form-check" style="margin-right: 20px;">
                                                <input id="{{ Str::slug('COD') }}"
                                                    name="paymentMethod" type="radio"
                                                    value="COD" class="form-check-input"
                                                    >
                                                <label class="form-check-label"
                                                    for="{{ Str::slug('COD') }}" style="cursor: pointer;">COD</label>
                                            </div>
                                            @endif
                                            @if($gs->ccod == 'yes' || (isset($ccod) && $ccod == true))
                                            <div class="form-check" style="margin-right: 20px;">
                                                <input id="{{ Str::slug('CCOD') }}"
                                                    name="paymentMethod" type="radio"
                                                    value="CCOD" class="form-check-input"
                                                    >
                                                <label class="form-check-label"
                                                    for="{{ Str::slug('CCOD') }}" style="cursor: pointer;">CCOD</label>
                                            </div>
                                        @endif
                                        
                                    </div>
                                    <div class="invalid-feedback" id="msg_payment_method"></div>
                                </div>
                            </div>
                            @endif
                        @endif
                        </div>
                        <div class="user-form-single">
                            <div class="submit-btn">
                                    @if((isset($hasZeroValue) && $hasZeroValue == true))
                                    <input id="{{ Str::slug('zero_payment') }}"
                                                    name="paymentMethod" type="radio"
                                                    value="zero_payment" class="form-check-input"
                                                    checked style="display: none;">
                                    <button class="w-100" type="button" id="zero_payment">Place Order</button>
                                    @elseif((isset($payment_gateway) && $payment_gateway == true) || (isset($cod) && $cod == true) || (isset($ccod) && $ccod == true))
                                    <button class="w-100" type="button" id="cashfree_payment">Pay</button>
                                    @elseif(isset($gs) && ($gs->payment_g == 'yes' || $gs->cod == 'yes' || $gs->ccod == 'yes'))
                                    <button class="w-100" type="button" id="cashfree_payment">Pay</button>
                                    @else
                                    <input id="{{ Str::slug('zero_payment') }}"
                                                    name="paymentMethod" type="radio"
                                                    value="zero_payment" class="form-check-input"
                                                    checked style="display: none;">
                                    <button class="w-100" type="button" id="zero_payment">Place Order</button>
                                    @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div id="loader" class="overlay common-loader" style="background-color: rgba(255, 255, 255, 0.34); display: none;">
            <div style="position: relative; top: 46%;">
                <div class="row justify-content-center">
                    <div class="col-auto text-center">
                        <img src="{{ asset('front/src/images/black-spinner.svg') }}">
                    </div>
                </div>
            </div>
        </div>
        <!-- The Cashfree Payment Getway Modal -->
        <div class="modal fade promo-code-popup width-700" id="cash_free_payment_modal" data-backdrop="static"
            data-keyboard="false">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <button type="button" class="close-modal" data-dismiss="modal">
                            <img src="{{ asset('front/close-icon.svg') }}"
                                alt="close">
                        </button>
                        <div id="payment-form"></div>
                    </div>
                </div>
            </div>
        </div>

        
        <input type="hidden" id="img" value="{{ asset('uploads/'.$bs->business_logo) }}">
        <input type="hidden" id="hidden_order_id" name="hidden_order_id">
        <input type="hidden" id="old_order_id" value="{{ Session::get('order_id') }}">
        <input type="hidden" id="old_razorpay_order_id" value="{{ Session::get('razorpay_order_id') }}">
        <input type="hidden" id="order_promo_code_id" value="{{ isset($promoCodeData['promo_code_id']) ? $promoCodeData['promo_code_id'] : '' }}">
        <input type="hidden" id="order_promo_code_discount" value="{{ isset($promoDiscount) ? $promoDiscount : '' }}">
        <input type="hidden" id="total_price_shi" value="{{ $totalGrandPrice }}">
    </section>
   
@endsection
@section('script')
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script src="https://sdk.cashfree.com/js/ui/1.0.26/dropinClient.sandbox.js"></script>
    <script>
        function updateOldOrder(e) {
            var paymentMethod_1 = $("input[name='paymentMethod']:checked").val();
            $('#loader').hide();
            var order_id_1 = $('#old_order_id').val();
            var old_razorpay_order_id_1 = $('#old_razorpay_order_id').val();
            var cart_id_1 = $('#cart_id').val();
            var fullname_1 = $('#fullname').val();
            var address_1 = $('#address').val();
            var address2_2 = $('#address2').val();
            var email_1 = $('#email').val();
            var country_2 = $('#country').val();
            var city_2 = $('#city').val();
            var state_2 = $('#state').val();
            var zipcode_2 = $('#zipcode').val();
            var gst_number_2 = $('#gst_number').val();
            var grand_total_1 = parseFloat($('#grand_total').val()).toFixed(2);
            var final_grand_total = parseInt(grand_total_1 * 100);
            var image_1 = $('#img').val();
            var order_promo_code_id = $('#order_promo_code_id').val();
            var order_promo_code_discount = $('#order_promo_code_discount').val();
            var final_total_ship = parseFloat($('#total_price_shi').val()).toFixed(2);
            var flag_1 = 0;
             if (fullname_1 == '' || fullname_1 == null) {
                flag_1++;
                $("#msg_fullname").html("Name is required");
                $("#msg_fullname").css("display", "block");
            } else {
                $("#msg_fullname").html("");
                $("#msg_fullname").css("display", "none");
            }
            if (address_1 == '' || address_1 == null) {
                flag_1++;
                $("#msg_address").html("Address is required");
                $("#msg_address").css("display", "block");
            } else {
                $("#msg_address").html("");
                $("#msg_address").css("display", "none");
            }
            if (country_2 == '' || country_2 == null || country_2 == 'Select') {
                flag_1++;
                $("#msg_country").html("Country is required");
                $("#msg_country").css("display", "block");
            } else {
                $("#msg_country").html("");
                $("#msg_country").css("display", "none");
            }
            if (state_2 == '' || state_2 == null || state_2 == 'Select State') {
                flag_1++;
                $("#msg_state").html("State is required");
                $("#msg_state").css("display", "block");
            } else {
                $("#msg_state").html("");
                $("#msg_state").css("display", "none");
            }
            if (city_2 == '' || city_2 == null || city_2 == 'Select City') {
                flag_1++;
                $("#msg_city").html("City is required");
                $("#msg_city").css("display", "block");
            } else {
                $("#msg_city").html("");
                $("#msg_city").css("display", "none");
            }
            if (email_1 == '' || email_1 == null) {
                flag_1++;
                $("#msg_email").html("Email is required");
                $("#msg_email").css("display", "block");
            } else {
                $("#msg_email").html("");
                $("#msg_email").css("display", "none");
            }
            if (zipcode_2 == '' || zipcode_2 == null) {
                flag_1++;
                $("#msg_zip").html("Zipcode is required");
                $("#msg_zip").css("display", "block");
            } else {
                $("#msg_zip").html("");
                $("#msg_zip").css("display", "none");
            }
            if (paymentMethod_1 == '' || paymentMethod_1 == null || paymentMethod_1 == undefined) {
                flag_1++;
                $("#msg_payment_method").html("Please Select Payment Method");
                $("#msg_payment_method").css("display", "block");
            } else {
                $("#msg_payment_method").html("");
                $("#msg_payment_method").css("display", "none");
            }
            if (flag_1 == 0) {
                $('#cashfree_payment').prop('disabled', true);
                $('#loader').show();
                $.ajax({
                    url: '{{route('save_checkout_data')}}',
                    type: 'POST',
                    data: {
                        'paymentMethod' : paymentMethod_1,
                        'fullname': fullname_1,
                        'address': address_1,
                        'address2': address2_2,
                        'country': country_2,
                        'state': state_2,
                        'zipcode': zipcode_2,
                        'city': city_2,
                        'email': email_1,
                        'gst_number': gst_number_2,
                        'checkout_method': 'cashfree',
                        'payment_id': '',
                        'shipping_amount': final_total_ship,
                        'total_item_count': '{{ $totalqty }}',
                        'total': grand_total_1.replace(',', ''),
                        'promo_code_id': order_promo_code_id,
                        'promo_code_discount': order_promo_code_discount,
                        '_token': '<?php echo csrf_token(); ?>'
                    },
                    success: function(response) {  

                        $('#cashfree_payment').prop('disabled', false);
                        if(response.status == 1)
                        {

                            if((paymentMethod_1 == 'zero_payment' || paymentMethod_1 == 'COD' || paymentMethod_1 == 'CCOD') && paymentMethod_1 != 'Cashfree')
                            {
                                 console.log(response.message);
                                // swal("Success", response.message, "success");
                                $('#loader').hide();
                                Swal.fire({
                                  title: "Success",
                                  text: response.message,
                                  icon: "success",
                                  buttonsStyling: false,
                                  confirmButtonColor: "var(--theme-orange-red)", // Set your desired color here
                                });
                                var redirectUrl = "{{ route('order_details', ['id' => ':id']) }}";
                                redirectUrl = redirectUrl.replace(':id', response.order_id);
                                window.location.href = redirectUrl;
                            }else if(paymentMethod_1 == 'Cashfree')
                            {
                               console.log(response);
                                var user_order_id = response.order_id;
                                $.ajax({
                                    url: '{{route('fatchCashFreeToken')}}',
                                    type: 'POST',
                                    data: {
                                        '_token': '<?php echo csrf_token(); ?>',
                                        'customer_email': email_1,
                                        'order_amount': grand_total_1,
                                        'order_note': "Order Placed Successfully"
                                    },
                                    success: function(result) {
                                        console.log(result);
                                        orderToken_3 = result.order_token;
                                        // alert(orderToken_3);
                                        $('#loader').hide();
                                        $('#cash_free_payment_modal').modal('show');
                                        const dropConfig = {
                                            "components": [
                                            "order-details",
                                            "netbanking",
                                            "app",
                                            "upi",
                                            "paylater",
                                            "credicardemi"
                                            ],
                                            "orderToken": orderToken_3, // Pass orderToken_3 here
                                            "onSuccess": function(data) {
                                                //on payment flow complete
                                                var cf_order_status = data['order']['status'];
                                                var cf_orderID = data['order']['orderId'];
                                                var cf_transactionId = data['transaction'][
                                                'transactionId'
                                                ];
                                                if (cf_order_status == 'PAID') {
                                                    saveCashfreePaymentID(user_order_id,cf_order_status,
                                                        orderToken_3, cf_orderID,
                                                        cf_transactionId, grand_total_1)
                                                    //console.log(data);
                                                    // swal("Success", "Order Successfully Placed", "success");
                                                    //window.location ='';
                                                } else {
                                                    saveCashfreePaymentID(user_order_id,cf_order_status,
                                                        orderToken_3, cf_orderID,
                                                        cf_transactionId, grand_total_1)
                                                    //on failure during payment initiation
                                                    // swal("Error", "Payment is in pending!",
                                                    // "error");
                                                    Swal.fire({
                                                          title: "Error",
                                                          text: "Payment is in pending!",
                                                          icon: "error",
                                                          buttonsStyling: false,
                                                          confirmButtonColor: "var(--theme-orange-red)", // Set your desired color here
                                                        });
                                                    // swal("Error", "Error while placeing order.","error");
                                                    //console.log(data);
                                                }
                                            },
                                            "onFailure": function(data) {
                                                var cf_order_status = data['order']['status'];
                                                var cf_orderID = data['order']['orderId'];
                                                var cf_transactionId = data['transaction'][
                                                'transactionId'
                                                ];
                                                saveCashfreePaymentID(user_order_id,cf_order_status,
                                                        orderToken_3, cf_orderID,
                                                        cf_transactionId, grand_total_1)
                                                //on failure during payment initiation
                                                Swal.fire({
                                                          title: "Error",
                                                          text: "Payment is in pending!",
                                                          icon: "error",
                                                          buttonsStyling: false,
                                                          confirmButtonColor: "var(--theme-orange-red)", // Set your desired color here
                                                        });
                                                //console.log(data);
                                            },
                                            "style": {
                                                //to be replaced by the desired values
                                                "backgroundColor": "#ffffff",
                                                "color": "#11385b",
                                                "fontFamily": "Lato",
                                                "fontSize": "14px",
                                                "errorColor": "#ff0000",
                                                "theme": "light", //(or dark)
                                            }
                                        }
                                        const cashfree = new Cashfree();
                                        $("#payment-form").find('iframe').remove();
                                        const paymentElement = document.getElementById("payment-form");
                                        try {
                                            cashfree.initialiseDropin(paymentElement, dropConfig);
                                        } catch (err) {
                                            console.log(err);
                                        }
                                    }
                                }); 
                            }
                            else if(paymentMethod_1 == 'razor_pay')
                            {
                                $('#loader').hide();
                                var user_order_id = response.order_id;
                                var razor_pay_order_id = response.razorpay_order_id;
                                var fullname = $('#fullname').val();
                                var address = $('#address').val();
                                var email = $('#email').val();
                                var grand_total = grand_total_1.replace(',', '');
                                var image = $('#img').val();
                                var flag = 0;
                                if (flag == 0) {
                                    var options = {
                                        "key": "{{ env('RAZORPAY_KEY') }}",
                                        "order_id": razor_pay_order_id,
                                        "amount": parseInt(grand_total *
                                            100), // 2000 paise = INR 20
                                        "name": "{{ env('JWL_FOOTER_COPYRIGHT_CONTENT') }}",
                                        "description": "{{ env('JWL_FOOTER_COPYRIGHT_CONTENT') }}",
                                        "image": image /*"https://cdn1.jewelxy.com/live/img/business_logo/150x150/JaaK8u94aK_20190417121202.jpg"*/ ,
                                        "handler": function(response) {
                                            var payment_id = response
                                                .razorpay_payment_id;
                                            saverazorpayId(payment_id, user_order_id, grand_total);
                                        },
                                        "prefill": {
                                            "name": fullname,
                                            "email": email,
                                            "contact": "{{ Auth::user()->phone }}"
                                        },
                                        "notes": {
                                            "address": address
                                        },
                                        "theme": {
                                            "color": "#00bbff"
                                        }
                                    };
                                    var rzp1 = new Razorpay(options);
                                    rzp1.on('payment.failed', function(response) {
                                        /*alert(response.error.code);
                                            alert(response.error.reason);*/
                                        swal("Error", response.error.reason,
                                            "error");
                                            var redirectUrl = "{{ route('home') }}";
                                            window.location.href = redirectUrl;
                                        rzp1.close();
                                    });
                                    rzp1.on('close', function() {
                                        $('#loader').hide();
                                        $('#rzp-button1').prop('disabled', false);
                                        $('#proceed_checkout').prop('disabled',
                                            false);
                                        swal("Error", obj.MESSAGE, "error");
                                    });
                                    rzp1.open();
                                    // e.preventDefault();
                                }
                            }
                        }else{
                            $('#loader').hide();
                            Swal.fire("Access Expired", response.message, "error").then(function() {
                                setTimeout(function() {
                                    window.location = '{{ route('home') }}';
                                }, 500); 
                            });
                        }
                    }
                });
            }

        }
        $(document).on("click","#cashfree_payment,#zero_payment",function() {
                updateOldOrder();
        });
        function saverazorpayId(payment_id,user_order_id,grand_total){

            $('#loader').show();
            $.ajax({
                url: '{{route('update_order_detail')}}',
                type: 'POST',
                data: {
                    'type': 'razor_pay',
                    'order_id': user_order_id,
                    'payment_id': payment_id,
                    'grand_total': grand_total,
                    '_token': '<?php echo csrf_token(); ?>'
                },
                success: function(response) {
                    // var obj = jQuery.parseJSON(response);
                    if (response.status == 1) {
                        $('#loader').hide();
                        $('#cashfree_payment').prop('disabled', true);
                        // swal("Success", response.message, "success");
                        Swal.fire({
                          title: "Success",
                          text: response.message,
                          icon: "success",
                          buttonsStyling: false,
                          confirmButtonColor: "var(--theme-orange-red)", // Set your desired color here
                        });
                        var redirectUrl = "{{ route('order_details', ['id' => ':id']) }}";
                        redirectUrl = redirectUrl.replace(':id', user_order_id);
                        window.location.href = redirectUrl;
                        // purchase('{{ $shipping_amount }}', cf_transactionId, grand_total);
                        // facebook_purchase(grand_total);
                    } else {
                        $('#loader').hide();
                        $('#cashfree_payment').prop('disabled', false);
                        // swal("Error", 'Payment Failed', "error");
                        Swal.fire({
                              title: "Error",
                              text: "Payment Failed",
                              icon: "error",
                              buttonsStyling: false,
                              confirmButtonColor: "var(--theme-orange-red)", // Set your desired color here
                            });
                    }
                }
            });
        }
        function saveCashfreePaymentID(user_order_id,cf_order_status, orderToken, cf_orderID, cf_transactionId, grand_total) {
            $('#loader').show();
            $.ajax({
                url: '{{route('update_order_detail')}}',
                type: 'POST',
                data: {
                    'cf_order_token': orderToken,
                    'order_id': user_order_id,
                    'cf_order_id': cf_orderID,
                    'cf_transection_id': cf_transactionId,
                    'grand_total': grand_total,
                    'cf_order_status': cf_order_status,
                    '_token': '<?php echo csrf_token(); ?>'
                },
                success: function(response) {
                    // var obj = jQuery.parseJSON(response);
                    if (response.status == 1) {
                        $('#loader').hide();
                        $('#cashfree_payment').prop('disabled', true);
                        // swal("Success", response.message, "success");
                        Swal.fire({
                          title: "Success",
                          text: response.message,
                          icon: "success",
                          buttonsStyling: false,
                          confirmButtonColor: "var(--theme-orange-red)", // Set your desired color here
                        });
                        var redirectUrl = "{{ route('order_details', ['id' => ':id']) }}";
                        redirectUrl = redirectUrl.replace(':id', user_order_id);
                        window.location.href = redirectUrl;
                        // purchase('{{ $shipping_amount }}', cf_transactionId, grand_total);
                        // facebook_purchase(grand_total);
                    } else {
                        $('#loader').hide();
                        $('#cashfree_payment').prop('disabled', false);
                        // swal("Error", 'Payment Failed', "error");
                        Swal.fire({
                              title: "Error",
                              text: "Payment Failed",
                              icon: "error",
                              buttonsStyling: false,
                              confirmButtonColor: "var(--theme-orange-red)", // Set your desired color here
                            });
                    }
                }
            });
        }
        @if(isset($user_address->state) && $user_address->state != null)
            var country = '{{$user_address->country}}';
                  $("#state").html('');
                  $.ajax({
                    url: "{{route('business.get_state')}}",
                    type: "POST",
                    data: {
                      country: country,
                      _token: '{{csrf_token()}}'
                    },
                    dataType: 'json',
                    success: function(result) {
                      $('#state').html('<option value="">Select State</option>');
                      var state_id = '{{$user_address->state}}';
                      $.each(result.state, function(key, value) {
                        var selected = '';
                          if (state_id == value.id) {
                            var isselected = 'selected';
                          }
                        $("#state").append('<option value="' + value.id + '" ' + isselected + '>' + value.name + '</option>');
                      });
                    }
            });
        @endif
        @if(isset($user_address->city) && $user_address->city != null)
        var state = '{{$user_address->state}}';
        $("#city").html('');
              $.ajax({
                url: "{{route('business.get_city')}}",
                type: "POST",
                data: {
                  state: state,
                  _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function(result) {
                  $('#city').html('<option value="">Select City</option>');
                  var city_id = '{{$user_address->city}}';
                  $.each(result.city, function(key, value) {
                    var iscityselected = '';
                    if (city_id == value.id) {
                        var iscityselected = 'selected';
                      }
                    $("#city").append('<option value="' + value.id + '" '+ iscityselected +'>' + value.name + '</option>');
                  });
                }
              }); 
        @endif
        $('#country').on('change', function () { 
        var country = this.value;
          $("#state").html('');
          $.ajax({
            url: "{{route('business.get_state')}}",
            type: "POST",
            data: {
              country: country,
              _token: '{{csrf_token()}}'
            },
            dataType: 'json',
            success: function(result) {
              $('#state').html('<option value="">Select State</option>');
              $.each(result.state, function(key, value) {
                $("#state").append('<option value="' + value.id + '">' + value.name + '</option>');
              });
            }
          }); 
    });
        $('#state').on('change', function () { 
        var state = this.value;
          $("#city").html('');
          $.ajax({
            url: "{{route('business.get_city')}}",
            type: "POST",
            data: {
              state: state,
              _token: '{{csrf_token()}}'
            },
            dataType: 'json',
            success: function(result) {
              $('#city').html('<option value="">Select City</option>');
              $.each(result.city, function(key, value) {
                $("#city").append('<option value="' + value.id + '">' + value.name + '</option>');
              });
              
            }
          }); 
        });
        $('#city').on('change', function () { 
            $('#zipcode').trigger("change");
        });
        @if(isset($user_address->zipcode) && $user_address->zipcode != null)
            var country = '{{ isset($user_address->country) ? $user_address->country : '' }}';
            var state = '{{ isset($user_address->state) ? $user_address->state : '' }}';
            var city = '{{ isset($user_address->city) ? $user_address->city : '' }}';
            var zipcode = '{{ isset($user_address->zipcode) ? $user_address->zipcode : '' }}';
            $('#cashfree_payment').prop('disabled', true);
            $('#loader').show();
            $.ajax({
                url: "{{route('front.pincode.checkout')}}",
                type: "POST",
                data: {
                    country: country,
                    state: state,
                    city: city,
                    zipcode: zipcode,
                    total_paid :  '{{$totalGrandPrice}}',
                  _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function(result) {
                 if(result.status == 1)
                 {
                    $('#shipping_charge_div').show();
                    $('#shiping_charges').text('+ '+result.shipping);
                    $('#you_pay').text(result.final_amount);
                    $('#grand_total').val(result.hidden_amount);
                    $('#cashfree_payment').prop('disabled', false);
                    $('#loader').hide();
                 }else if(result.status == 0){
                    $('#loader').hide();
                    Swal.fire({
                      title: "Error",
                      text: result.message,
                      icon: "error",
                      buttonsStyling: false,
                      confirmButtonColor: "var(--theme-orange-red)", // Set your desired color here
                    });
                    $('#zero_payment').prop('disabled',true);
                    $('#cashfree_payment').prop('disabled',true);
                 }else{
                    $('#loader').hide();
                    Swal.fire({
                      title: "Error",
                      text: result.message,
                      icon: "error",
                      buttonsStyling: false,
                      confirmButtonColor: "var(--theme-orange-red)", // Set your desired color here
                    });
                    $('#zero_payment').prop('disabled',true);
                    $('#cashfree_payment').prop('disabled',true);
                 }
                }
            });
        @endif
        $('#zipcode').on('change', function () {
            var country = $('#country').val();
            var state = $('#state').val();
            var city = $('#city').val();
            var zipcode = $(this).val();
            $('#cashfree_payment').prop('disabled', true);
            $('#loader').show();
            $.ajax({
                url: "{{route('front.pincode.checkout')}}",
                type: "POST",
                data: {
                    country: country,
                    state: state,
                    city: city,
                    zipcode: zipcode,
                    total_paid :  '{{$totalGrandPrice}}',
                  _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function(result) {
                 if(result.status == 1)
                 {
                    $('#shipping_charge_div').show();
                    $('#shiping_charges').text(result.shipping);
                    $('#you_pay').text(result.final_amount);
                    $('#grand_total').val(result.hidden_amount);
                    $('#cashfree_payment').prop('disabled', false);
                    $('#loader').hide();
                 }else if(result.status == 0){
                    $('#loader').hide();
                    Swal.fire({
                      title: "Info",
                      text: result.message,
                      icon: "info",
                      buttonsStyling: false,
                      confirmButtonColor: "var(--theme-orange-red)", // Set your desired color here
                    });
                    $('#zero_payment').prop('disabled',true);
                    $('#cashfree_payment').prop('disabled',true);
                 }else{
                    $('#loader').hide();
                    Swal.fire({
                      title: "Info",
                      text: result.message,
                      icon: "info",
                      buttonsStyling: false,
                      confirmButtonColor: "var(--theme-orange-red)", // Set your desired color here
                    });
                    $('#zero_payment').prop('disabled',true);
                    $('#cashfree_payment').prop('disabled',true);
                 }
                }
            });
        });
    </script>
@endsection
