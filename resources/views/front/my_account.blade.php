@extends('front.layout.index')
@section('main_content')
<div class="margin-top-head @if($display_pg == 1) header-note @endif"></div>
<section class="common-section all-product-list-section">
    <div class="container-md">
        <div class="row">
            <div class="col-xxl-8">
                <span class="d-flex page-nav-text">
                    <a href="{{ route('home') }}" aria-label="home"><img src="{{asset('front/src/images/home-icon.svg')}}" alt="Home" width="auto" height="auto"></a> <span class="dash-line">/</span>
                    <a aria-label="home icon">My Account</a>
                </span>
            </div>
        </div>
    </div>
</section>

<section class="my-account-section common-padding padding-pages">
    <div class="container">
        <div class="s-title">
            <h1>My Account</h1>
        </div>
        <div class="my-account-detail">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a
                            class="nav-link active"
                            data-bs-toggle="tab"
                            href="#tabs-1"
                            role="tab"
                            >MY PROFILE</a
                            >
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#tabs-2" role="tab"
                            >MY ORDERS</a
                            >
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#tabs-3" role="tab"
                            >MY WISHLIST</a
                            >
                </li>
            </ul>
            
            <div class="tab-content">
                <div class="tab-pane active" id="tabs-1" role="tabpanel">
                    <div class="row">
                        <div class="col-12">
                            <div class="account-info">
                                <h5 class="border-color">Account Info <a class="float-right" data-bs-toggle="modal" data-bs-target="#changePasswordModal">Change Password</a></h5>
                            </div>
                        </div>
                    </div>
                    <div class="a-info-detail">
                        <ul>
                            @if(isset($user_details->name) && !empty($user_details->name))
                            <li>
                                <label>Name</label>
                                <span>{{$user_details->name}}</span>
                            </li>
                            @endif
                            @if(isset($user_details->email) && !empty($user_details->email))
                            <li>
                                <label>Email</label>
                                <span>{{$user_details->email}}</span>
                            </li>
                            @endif
                            @if(isset($user_details->phone) && !empty($user_details->phone))
                            <li>
                                <label>Phone</label>
                                <span>{{$user_details->country_code_number}} {{$user_details->phone}}</span>
                            </li>
                            @endif
                        </ul>
                    </div>
                  
                </div>
                <div class="tab-pane" id="tabs-2" role="tabpanel">
                    <!-- <div class="row">
                        <div class="col-12">
                            <div class="account-info">
                                <h5 class="border-color">Orders</h5>
                            </div>
                        </div>
                    </div> -->
                    <div class="order-delivere pt-3 row">
                        @if(isset($order_details) && !empty($order_details) && $order_details->isNotEmpty())
                        @foreach($order_details as $single_order)

                        @php
                        $date = new DateTime($single_order->updated_at);
                        $formattedDate = $date->format('d M Y');
                        @endphp


                        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-4 col-sm-6 col-xs-6 left-side inner-img-div">
                            <div class="inner-section-order">
                                <div class="upper_text">
                                    <p class="orderno">Order # {{$single_order->id}}</p>
                                    <p class="orderdate">Order on {{$formattedDate}}</p>
                                    <p class="orderstatus">Order Status : <strong>{{$single_order->status}}</strong></p>
                                </div>
                                <div class="view-more text-left">
                                    @if($single_order->status == 'Pending')
                                        @php
                                            $order_items = App\Models\OrderItems::where('order_id',$single_order->id)->get();
                                            $total_weight = 0;
                                            $sub_total = 0;
                                            $totalGrandPrice = 0;
                                            foreach($order_items as $single_items_w)
                                            {
                                                if($single_items_w->product_type == 'simple')
                                                {
                                                    $product = App\Models\Product::where('id',$single_items_w->product_id)->first();
                                                }else{
                                                    $product = App\Models\VariantProduct::where('id',$single_items_w->product_id)->first();
                                                }
                                                
                                                if(!$product)
                                                {
                                                    continue;
                                                }
                                                $total_price = str_replace(',', '', $product->total_price($product->id));
                                                $total_price_numeric = (float) $total_price;
                                                $total_weight += (isset($product->p_metal_weigth) && $product->p_metal_weigth) ? floatval($product->p_metal_weigth) : '0';
                                                $sub_total += floatval($single_items_w->total_price);
                                                $product_price = $total_price_numeric * $single_items_w->qty;
                                                $totalGrandPrice += $product_price;
                                            }
                                            $shipping_amount = $single_order->check_shipping_amount($single_order->id);   
                                        @endphp
                                        <a href="{{route('order_details',[$single_order->id])}}" class="width50 viewmr">View More</a>
                                        <a onclick="makePayment('{{$single_order->id}}','{{$user_address->email}}','{{$totalGrandPrice + $shipping_amount}}');" class="width50 makpay">Make Payment</a>
                                    @else
                                        <a href="{{route('order_details',[$single_order->id])}}" class="width100 viewmr">View More</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                            @endforeach
                        @else
                            <div class="col-12 no-product-cart mb-0">
                                <div class="row text-center">
                                    <div class="col-12">
                                        <h5>No orders or transitions found</h5>
                                        <p>Orders placed will appear here</p>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-12 col-md mt-3 mt-sm-0 mb-sm-0 mb-2 text-center text-md-center p-link">
                                        <a href="{{route('front.all.products')}}">Continue Shopping</a>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="tab-pane" id="tabs-3" role="tabpanel">
                    <div class="wishlist">
                        @if(isset($Wishlist) && !empty($Wishlist) && $Wishlist->isNotEmpty())
                            @foreach($Wishlist as $item)
                                @php
                                if($item->product_type == 'simple')
                                {
                                    $product = App\Models\Product::where('id',$item['product_id'])->first();
                                }else{
                                    $product = App\Models\VariantProduct::where('id',$item['product_id'])->first();
                                }
                                
                                if(!$product){
                                    continue;
                                }
                                $p_image = App\Models\ProductImage::where('product_id',$product->id)->where('type',$item->product_type)->first();
                                if(isset($p_image->name) && $p_image->name != '' && $p_image->name != null)
                                {
                                    if(isset($product->db_status) && $product->db_status != '' && $product->db_status != null && $product->db_status == 'manually')
                                    {
                                        $path = asset('product_media/product_images/'.$p_image->name);
                                    }else{
                                        $path = asset('uploads/'.$p_image->name);
                                    }
                                }else{
                                    $path = asset('assets/images/user/img-demo_1041.jpg');
                                }
                                @endphp
                                <div class="whishlist_product_list">
                                    <article>
                                        <div class="d-flex inner-div align-items-center">
                                            <div class="product-image">
                                                <img src="{{$path}}" alt="{{ $product->p_title }}">
                                            </div>
                                            <div class="product-details">
                                                <h4>{{ $product->p_title }}</h4>
                                                <ul>
                                                    @if (isset($product->p_status) && !empty($product->p_status))
                                                        <li><span>Availability :</span> @if($product->p_status == 'by_order') By Order @else Ready Stock @endif</li>
                                                    @endif
                                                    @if($product->db_status == 'migrated')
                                                        <li><span>Metal:</span> {{ isset($product->p_metal_color) ? $product->p_metal_color : '' }}</li>
                                                    @else
                                                        <li><span>Metal:</span> {{ isset($product->metalcolor->title) ? $product->metalcolor->title : '' }}</li>
                                                    @endif

                                                    @if (isset($product->p_sku) && !empty($product->p_sku))
                                                        <li><span>SKU :</span> {{ $product->p_sku }}</li>
                                                    @endif
                                                    
                                                </ul>
                                                <div class="price-and-cart d-flex align-items-center justify-content-between">
                                                    <div class=" d-flex align-items-center">
                                                        <h3 class="price">₹ {{ number_format($product->total_price($product->id), 2, '.', ',') }}</h3>
                                                    </div>
                                                    <div class="move_to_cart remove-wishlist">
                                                    <form action="{{ route('front.move.cart.products') }}"
                                                        method="POST">
                                                        {{ csrf_field() }}
                                                        <input type="hidden" value="{{ isset($item['qty']) ? $item['qty'] : 1 }}" name="pro_qty" id="move_pro_qty_qtu{{$loop->index}}" data-inputid="qtu{{$loop->index}}">
                                                        <input type="hidden" value="{{ $item['product_id'] }}" name="product_id">
                                                        <button type="submit" class="remove-wishlist-text rmv_button" data-product-id="{{ $item['product_id'] }}"><svg style="width: 17px;margin-right: 10px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path d="M0 24C0 10.7 10.7 0 24 0H69.5c22 0 41.5 12.8 50.6 32h411c26.3 0 45.5 25 38.6 50.4l-41 152.3c-8.5 31.4-37 53.3-69.5 53.3H170.7l5.4 28.5c2.2 11.3 12.1 19.5 23.6 19.5H488c13.3 0 24 10.7 24 24s-10.7 24-24 24H199.7c-34.6 0-64.3-24.6-70.7-58.5L77.4 54.5c-.7-3.8-4-6.5-7.9-6.5H24C10.7 48 0 37.3 0 24zM128 464a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm336-48a48 48 0 1 1 0 96 48 48 0 1 1 0-96z" fill="var(--theme-orange-red)"/></svg> Move to Cart</button>
                                                    </form>
                                                    </div>
                                                    <div class="remove-wishlist">
                                                        <form action="{{ route('front.remove.wishlist.products') }}" method="POST">
                                                            {{ csrf_field() }}
                                                            <button class="rmv_button remove_wishlist remove-wishlist-text"  data-product-id="{{ $item['product_id'] }}" type="button"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 13 13" style="width: 14px;margin-right: 10px;"><polyline class="arrow" fill="none" stroke="currentColor" points="1 1,6.5 6.5,12 1"/><polyline class="arrow" fill="none" stroke="currentColor" points="1 12,6.5 6.5,12 12"/></svg>Remove from wishlist</button>
                                                        </form>
                                                    </div>
                                                </div>

                                                
                                            </div>

                                        </div>


                                       
                                    </article>
                                </div>
                            @endforeach
                        @else
                            <div class="col-12 no-product-cart mb-0">
                                <div class="row text-center">
                                    <div class="col-12">
                                        <h5>You haven't added any products yet</h5>
                                        <p class="css_display_heart_icon">Click <img class="mx-2"
                                                    src="{{ asset('front/src/images/wishlist-icon.svg')}}"
                                                    alt="Wishlist"> to save products</p>
                                        
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-12 col-md mt-3 mt-sm-0 mb-sm-0 mb-2 text-center text-md-center p-link">
                                        <a href="{{route('front.all.products')}}">Continue Shopping</a>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- The Cashfree Payment Getway Modal -->
<section class="popup-section">
    <div class="modal fade promo-code-popup width-700" id="cash_free_payment_modal" data-backdrop="static"
        data-keyboard="false">
            <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close-modal" data-dismiss="modal">
                        <img src="{{asset('front/theme2/images/close-icon.svg')}}"
                                alt="close">
                    </button>
                    <div id="payment-form"></div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="popup-section">
    <div class="modal fade login-popup width-700" id="changePasswordModal" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body d-block change_password_form">
                    <button type="button" class="btn-close" data-bs-dismiss="modal">x</button>
                    <h5>Change Password</h5>
                    <div class="user-form-single mt-2">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="control-label">Enter new Password</label>
                                    <input type="password" id="new_password"
                                           class="form-control" name="new_password"
                                           data-toggle="tooltip"
                                           data-placement="top" title="New Password required"/>
                                    <span class="fa fa-eye-slash mt-4" id="hide_new_change_password"></span>
                                    <span class="fa fa-eye mt-4 d-none" id="show_new_change_password"></span>
                                </div>
                                <div class="invalid-feedback msg_email_for_login" id="msg_new_password"></div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="control-label">Confirm Password</label>
                                    <input type="password" id="confirm_password"
                                           class="form-control" name="confirm_password"
                                           data-toggle="tooltip"
                                           data-placement="top" title="Confirm Password is required"/>
                                    <span class="fa fa-eye-slash mt-4" id="hide_confirm_change_password"></span>
                                    <span class="fa fa-eye mt-4 d-none" id="show_confirm_change_password"></span>
                                </div>
                                <div class="invalid-feedback msg_email_for_login" id="msg_password"></div>
                                <div class="invalid-feedback msg_email_for_login" id="msg_confirm_password"></div>
                            </div>
                        </div>
                    </div>
                    <div class="user-form-single mt-2" id="user_login_button">
                        <div class="submit-btn">
                            <button type="button" id="change_password" onclick="changePassword()">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
    <!-- <div id="loader" class="overlay" style="background-color:rgba(255, 255, 255, 0.34);">
        <div style="position: relative; top: 46%;">
            <div class="row justify-content-center">
                <div class="col-auto text-center">
                    <img src="{{ asset('front/loading-image.gif') }}">
                </div>
            </div>
        </div>
    </div> -->





    <input type="hidden" value="{{ isset($bs->payment_method_type) ? $bs->payment_method_type : '' }}" id="payment_method_type">
    <input type="hidden" id="img" value="{{ asset('uploads/'.$bs->business_logo) }}">
@endsection
@section('script')
<script src="https://sdk.cashfree.com/js/ui/1.0.26/dropinClient.sandbox.js"></script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

     <script>
        $('#hide_new_change_password').click(function(){
            $('#show_new_change_password').removeClass('d-none');
            $('#new_password').attr("type","text");
            $('#hide_new_change_password').addClass('d-none');
        });
        $('#show_new_change_password').click(function(){
            $('#hide_new_change_password').removeClass('d-none');
            $('#new_password').attr("type","password");
            $('#show_new_change_password').addClass('d-none');
        });
        $('#hide_confirm_change_password').click(function(){
            $('#show_confirm_change_password').removeClass('d-none');
            $('#confirm_password').attr("type","text");
            $('#hide_confirm_change_password').addClass('d-none');
        });
        $('#show_confirm_change_password').click(function(){
            $('#hide_confirm_change_password').removeClass('d-none');
            $('#confirm_password').attr("type","password");
            $('#show_confirm_change_password').addClass('d-none');
        });
        function changePassword(){
            var token = $("meta[name='csrf-token']").attr("content");
            var new_password = $('#new_password').val();
            var confirm_password = $('#confirm_password').val();
            var flag = 0;
            if(new_password == ''){
                $("#msg_new_password").html("New Password required");
                $("#msg_new_password").css("display", "block");
                flag++;
            }else if (new_password != '' && new_password.length < 6) {
                $("#msg_new_password").html("Please recheck, your Password should contain minimum 6 characters. It's a required Field.");
                $("#msg_new_password").css("display", "block");
                flag++;
            }else {
                $("#msg_new_password").html("");
                $("#msg_new_password").css("display", "none");
            }
            if(confirm_password == ''){
                $("#msg_confirm_password").html("Confirm Password required");
                $("#msg_confirm_password").css("display", "block");
                flag++;
            }else if(new_password != confirm_password){
                $("#msg_confirm_password").html("New Password and Confirm Password doesn't match");
                $("#msg_confirm_password").css("display", "block");
                flag++;
            }else {
                $("#msg_confirm_password").html("");
                $("#msg_confirm_password").css("display", "none");
            }
            if(flag == 0){
                $.ajax({
                    url: '{{ route('user.changePassword') }}',
                    type: 'POST',
                    data: {
                        'new_password': new_password,
                        '_token': token
                    },
                    success: function (response) {
                        // var obj = jQuery.parseJSON(response);

                        if (response.status == 200) {
                            $('#loader').hide();
                            Swal.fire("Success", response.message, "success");
                            window.location.reload();
                        } else {
                            Swal.fire("Error", response.message, "error");
                        }
                    }
                });
            }
        }

        function makePayment(single_order_id,user_email,grandtotal) {
            var paymentMethod_1 = $('#payment_method_type').val();
            $('#loader').show();
                var cf_order_id_2 = single_order_id;
                var cf_email_2 = user_email;
                var cf_grand_total_2 = parseFloat(grandtotal).toFixed(2);
                if(paymentMethod_1 == 'Cashfree')
                {
                $.ajax({
                    url: '{{route('fatchCashFreeToken')}}',
                    type: 'POST',
                    data: {
                        '_token': '<?php echo csrf_token(); ?>',
                        'customer_email': cf_email_2,
                        'order_amount': cf_grand_total_2,
                        'order_note': "Your order has been placed successfully. We will update you once it is confirmed."
                    },
                    success: function(result) {
                         orderToken_3 = result.order_token;
                        // alert(orderToken_3);
                        $('#loader').hide();
                        $('#cash_free_payment_modal').modal('show');
                        const dropConfig = {
                            "components": [
                            "order-details",
                            "card",
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
                                    saveCashfreePaymentID(cf_order_id_2,cf_order_status,
                                        orderToken_3, cf_orderID,
                                        cf_transactionId, cf_grand_total_2)
                                    //console.log(data);
                                    // Swal.fire("Success", "Order Successfully Placed", "success");
                                    //window.location ='';
                                } else {
                                    //on failure during payment initiation
                                    Swal.fire("Error", "Error while placeing order.",
                                    "error");
                                    //console.log(data);
                                }
                            },
                            "onFailure": function(data) {
                                //on failure during payment initiation
                                Swal.fire("Error", "Error while placeing order.",
                                "error");
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
                        const paymentElement = document.getElementById("payment-form");
                        try {
                            cashfree.initialiseDropin(paymentElement, dropConfig);
                        } catch (err) {
                            console.log(err);
                        }
                    }
                });
            }else if(paymentMethod_1 == 'razor_pay')
            {
                $('#loader').show();
                var user_order_id = cf_order_id_2;
                $.ajax({
                    url: '{{route('fetchrazorid')}}',
                    type: 'POST',
                    data: {
                        '_token': '<?php echo csrf_token(); ?>',
                        'total': cf_grand_total_2,
                        'order_id': user_order_id,
                        'order_note': "Your order has been placed successfully. We will update you once it is confirmed."
                    },
                    success: function(result) {
                        $('#loader').hide();
                        var razor_pay_order_id = result.razorpay_order_id;
                        var fullname = '{{ isset($address_details->fullname) ? $address_details->fullname : '' }}';
                        var address = '{{ isset($address_details->address) ? $address_details->address : '' }}';
                        var email = '{{ isset($address_details->email) ? $address_details->email : '' }}';
                        var grand_total = cf_grand_total_2.replace(',', '');
                        var image = $('#img').val();
                        var flag = 0;
                        if (flag == 0) {
                            var options = {
                                "key": "{{ env('RAZORPAY_KEY') }}",
                                "order_id": razor_pay_order_id,
                                "amount": parseInt(15000 * 100), // 2000 paise = INR 20
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
                                Swal.fire("Error", response.error.reason,
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
                                Swal.fire("Error", obj.MESSAGE, "error");
                            });
                            rzp1.open();
                            // e.preventDefault();
                        }
                    }
                });
                
            }


        }

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
                        // Swal.fire("Success", response.message, "success");
                        Swal.fire({
                        title: "Success",
                        text: response.message,
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonColor: "var(--theme-orange-red)", // Set your desired color here
                        });
                        location.reload();
                        
                    } else {
                        $('#loader').hide();
                        $('#cashfree_payment').prop('disabled', false);
                        // Swal.fire("Error", 'Payment Failed', "error");
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
                    '_token': '<?php echo csrf_token(); ?>'
                },
                success: function(response) {
                    // var obj = jQuery.parseJSON(response);
                    if (response.status == 1) {
                        $('#loader').hide();
                        $('#rzp-button1').prop('disabled', true);
                        $('#proceed_checkout').prop('disabled', true);
                        $('#proceed_checkout').prop('disabled', true);
                        $('#cashfree_payment').prop('disabled', true);
                        Swal.fire("Success", response.message, "success");
                        var redirectUrl = "{{ route('order_details', ['id' => ':id']) }}";
                        redirectUrl = redirectUrl.replace(':id', user_order_id);
                        window.location.href = redirectUrl;
                    } else {
                        $('#loader').hide();
                        $('#rzp-button1').prop('disabled', false);
                        $('#proceed_checkout').prop('disabled', false);
                        $('#cashfree_payment').prop('disabled', false);
                        Swal.fire("Error", 'Payment Failed', "error");
                    }
                }
            });
        }
        $(document).on("click",".remove_wishlist",function() {
            // var cart_id =$('#cart_id').val();
            var product_id =$(this).data('product-id');
            // var qty =$('#qty').val();
                    Swal.fire({
                title: 'Are you sure,',
                text: 'You want to remove product from wishlist!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: 'var(--theme-color)',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                $.ajax({
                    url: '{{route('front.remove.wishlist.products')}}',
                    type: 'POST',
                    data: {
                        'product_id':product_id,
                        '_token': '<?php echo csrf_token(); ?>'
                    },
                    success: function(response) {
                        if (response.status == 1) {
                            // $('#loader').hide();
                     
                            window.location = '{{ route('front.wishlist.view') }}';
                        } else {
                            // $('#loader').hide();
                            Swal.fire("Error", response.message, "error");
                        }
                    }
                });
              }
          });
        });
    </script>
   

@endsection
