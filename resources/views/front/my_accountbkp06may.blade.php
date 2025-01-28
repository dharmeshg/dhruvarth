@extends('front.layout.index')
@section('main_content')



<div class="marg-top"></div>
    <div class="" xmlns="http://www.w3.org/1999/html"></div>
    <div class="container">
        <nav class="mt-3" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('home')}}"><img
                                src="{{asset('front/home-icon.svg')}}"
                                alt="Home"/></a></li>
                <li class="breadcrumb-item active" aria-current="page">My Account</li>
            </ol>
        </nav>
    </div>

    <section class="my-account-section">
        <div class="container">
            <div class="s-title">
                <h5>MY ACCOUNT</h5>
            </div>
            <div class="my-account-detail">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a
                                class="nav-link active"
                                data-toggle="tab"
                                href="#tabs-1"
                                role="tab"
                                >MY PROFILE</a
                                >
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab"
                                >MY ORDERS</a
                                >
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tabs-3" role="tab"
                                >MY WISHLIST</a
                                >
                    </li>
                </ul>
                <!-- Tab panes -->
                {{--<div class="order-dropdown">
                    <select>
                        <option>Order Time</option>
                        <option>Order Time1</option>
                        <option>Order Time1</option>
                        <option>Order Time1</option>
                        <option>Order Time1</option>
                        <option>Order Time1</option>
                    </select>
                    <select>
                        <option>Order Status</option>
                        <option>Order Status1</option>
                        <option>Order Status1</option>
                        <option>Order Status1</option>
                        <option>Order Status1</option>
                        <option>Order Status1</option>
                    </select>
                </div>--}}
                <div class="tab-content">
                    <div class="tab-pane active" id="tabs-1" role="tabpanel">
                        <div class="row">
                            <div class="col-12">
                                <div class="account-info">
                                    <h5 class="border-color">Account Info <a class="float-right" data-toggle="modal" data-target="#changePasswordModal">Change Password</a></h5>
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
                        <div class="order-delivere pt-xl-5 pt-4">
                            @if(isset($order_details) && !empty($order_details) && $order_details->isNotEmpty())
                            @foreach($order_details as $single_order)

                            @php
                            $date = new DateTime($single_order->updated_at);
                            $formattedDate = $date->format('d M Y');
                            @endphp


                            <div class="border-color delivere-date pt-4 pb-3">
                                <span>Order on {{$formattedDate}}</span>
                                <p class="mb-0">Order # {{$single_order->id}}</p>
                                <p class="mb-0">Order Status : <strong>{{$single_order->status}}</strong></p>
                                <div class="view-more text-left">
                                    <a href="{{route('order_details',[$single_order->id])}}">View More</a>
                                    @if($single_order->status == 'Pending')
                                    @php
                                        $order_items = App\Models\OrderItems::where('order_id',$single_order->id)->get();
                                        $total_weight = 0;
                                        $sub_total = 0;
                                        $totalGrandPrice = 0;
                                        foreach($order_items as $single_items_w)
                                        {
                                            $product = App\Models\Product::where('id',$single_items_w->product_id)->first();
                                            $total_price = str_replace(',', '', $product->total_price($product->id));
                                            $total_price_numeric = (float) $total_price;
                                            $total_weight += floatval($product->p_metal_weigth);
                                            $sub_total += floatval($single_items_w->total_price);
                                            $product_price = $total_price_numeric * floatval($single_items_w->qty);
                                            $totalGrandPrice += $product_price;
                                        }
                                    @endphp
                                    <a onclick="makePayment('{{$single_order->id}}','{{$user_address->email}}','{{$totalGrandPrice}}');">Make Payment</a>
                                    @endif
                                </div>
                            </div>
                                @endforeach
                            @else
                                <div class="col-12 no-product-cart mb-0">
                                    <div class="row text-center">
                                        <div class="col-12">
                                            <h5>No orders or transitions found</h5>
                                            <p>Orders placed will appear here</p>

                                            <p class="my-3">Check out our Latest Discount Offers, <a
                                                        class="no-product-cart-promo-popup" data-toggle="modal"
                                                        data-target="#initial_promo_code_list">click here</a></p>
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
                            @foreach($Wishlist as $single_wishlist2)

                            @php

                            $single_wishlist = App\Models\Product::where('id', $single_wishlist2->product_id)->first();
				            $p_image = App\Models\ProductImage::where('product_id',$single_wishlist->id)->first();
				            $metal_color = App\Models\Metal::where('id',$single_wishlist->p_metal_color)->first();


								if(isset($p_image->name) && $p_image->name != '' && $p_image->name != null)
								{
									if(isset($single_wishlist->db_status) && $single_wishlist->db_status != '' && $single_wishlist->db_status != null && $single_wishlist->db_status == 'manually')
                                    {
                                        $path = asset('product_media/product_images/'.$p_image->name);
                                    }else{
                                        $path = asset('uploads/'.$p_image->name);
                                    }
								}else{
									$path = asset('assets/images/user/img-demo_1041.jpg');
								}
						
							@endphp
                            <div class="border-color wishlist-detail">
                                <h4>
                                    {{$single_wishlist->p_title}}
                                </h4>
                                <div class="wishlist-content">
                                    <div class="column-image">
                                        <img
                                                src="{{$path}}"
                                                alt="{{$single_wishlist->p_title}}"
                                                />
                                    </div>
                                    <div class="column-right-content">
                                        <div class="column-product-detail">
                                            <div class="product-info-inner">
                                                @if(isset($single_wishlist->p_sku) && !empty($single_wishlist->p_sku))
                                                <div><label>SKU:</label><span>{{$single_wishlist->p_sku}}</span></div>
                                                @endif
                                                @if(isset($metal_color->title) && !empty($metal_color->title))
                                                <div><label>Metal:</label><span>{{isset($metal_color->title) ? $metal_color->title : ''}}</span></div>
                                                @endif
                                            </div>
                                            <div class="product-info-price">
                                                <div class="p-price">
                                                    <span>₹ {{ number_format($single_wishlist->total_price($single_wishlist->id), 2, '.', ',') }}</span>
                                                    <div class="p-check">{{$single_wishlist->offer_price}}</div>
                                                </div>
                                            </div>
                                        </div>
                                        @if(isset($single_wishlist->Status) && !empty($single_wishlist->Status))
                                        <div class="column-availabilty">
                                            <div class="availability">
                                                Availability: <span>{{$single_wishlist->Status}}</span>
                                            </div>
                                        </div>
                                        @endif
                                        <div class="column-add-cart">
                                            <div class="p-link">
                                                <form action="{{route('front.move.cart.products')}}" method="POST">
                                                      {{ csrf_field() }}
                                                      <input type="hidden" value="1" name="pro_qty" id="move_pro_qty_qtu{{$loop->index}}" data-inputid="qtu{{$loop->index}}">
                                                      <input type="hidden" value="{{$single_wishlist->id}}" name="product_id">
                                                <button type="submit" class="my-profile-to-cart"
                                                        ><img src="{{ asset('front/theme2/images/cart-icon.svg')}}" alt="Cart" /> ADD TO
                                                    CART</button>
                                                    </form>
                                            </div>
                                        </div>
                                        <div class="column-continue-shipping">
                                            <div class="p-link">
                                                <a href="{{route('front.all.products')}}">Continue Shipping</a>
                                            </div>
                                            <div class="p-link p-link-grey">
                                                <form action="{{ route('front.remove.wishlist.products') }}"
                                                      method="POST">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" value="{{ $single_wishlist2->product_id }}" name="product_id">
                                                <button type="submit" class="my-profile-to-cart"
                                                        ><img
                                                            src="{{ asset('front/theme2/images//close-icon.svg')}}"
                                                            alt="Close"
                                                            />  Remove</button>
                                                    </form>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            @endforeach
                            @else
                                <div class="col-12 no-product-cart mb-0">
                                    <div class="row text-center">
                                        <div class="col-12">
                                            <h5>You haven't added any products yet</h5>
                                            <p class="css_display_heart_icon">Click <img class="mx-2"
                                                        src="{{ asset(Config::get('services.website_constant.THEME_NAME').'/images/wishlist.svg')}}"
                                                        alt="Wishlist"> to save products</p>

                                            <p class="my-3">Check out our Latest Discount Offers, <a
                                                        class="no-product-cart-promo-popup" data-toggle="modal"
                                                        data-target="#initial_promo_code_list">click here</a></p>
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
    <div class="modal fade login-popup width-700" id="changePasswordModal" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body d-block">
                    <button type="button" class="close-modal" data-dismiss="modal">
                        <img src="{{asset('front/theme2/images/close-icon.svg')}}" alt="close">
                    </button>
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







@endsection
@section('script')
<script src="https://sdk.cashfree.com/js/ui/1.0.26/dropinClient.sandbox.js"></script>

  
  <!--   <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script src="https://sdk.cashfree.com/js/ui/1.0.26/dropinClient.sandbox.js"></script> -->

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
                            swal("Success", response.message, "success");
                            window.location.reload();
                        } else {
                            swal("Error", response.message, "error");
                        }
                    }
                });
            }
        }

        function makePayment(single_order_id,user_email,grandtotal) {
            $('#loader').show();
                var cf_order_id_2 = single_order_id;
                var cf_email_2 = user_email;
                var cf_grand_total_2 = parseFloat(grandtotal).toFixed(2);
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
                                    // swal("Success", "Order Successfully Placed", "success");
                                    //window.location ='';
                                } else {
                                    //on failure during payment initiation
                                    swal("Error", "Error while placeing order.",
                                    "error");
                                    //console.log(data);
                                }
                            },
                            "onFailure": function(data) {
                                //on failure during payment initiation
                                swal("Error", "Error while placeing order.",
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
                        swal("Success", response.message, "success");
                        var redirectUrl = "{{ route('order_details', ['id' => ':id']) }}";
                        redirectUrl = redirectUrl.replace(':id', user_order_id);
                        window.location.href = redirectUrl;
                    } else {
                        $('#loader').hide();
                        $('#rzp-button1').prop('disabled', false);
                        $('#proceed_checkout').prop('disabled', false);
                        $('#cashfree_payment').prop('disabled', false);
                        swal("Error", 'Payment Failed', "error");
                    }
                }
            });
        }
    </script>
   

@endsection
