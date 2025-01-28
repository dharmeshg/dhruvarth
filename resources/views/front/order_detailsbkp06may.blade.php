@extends('front.layout.index')
@section('main_content')
<style>
    .custom-confirm-button-class {
    background-color: var(--theme-orange-red) !important; /* Green */
    border: none;
    color: white;
    padding: 10px 24px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
    border-radius: 12px;
}
</style>
<div class="marg-top"></div>
    <div class=" " xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
    </div>
    <div class="container">
        <nav class="mt-3" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('home')}}"><img
                            src="{{asset('front/home-icon.svg')}}"
                            alt="Home" /></a></li>
                <li class="breadcrumb-item"><a href="{{route('user.account.details')}}">My Account</a></li>
                <li class="breadcrumb-item active" aria-current="page">My Orders</li>
                <li class="breadcrumb-item active" aria-current="page">
                    Order # {{ $order_details->id }}
                </li>
            </ol>
        </nav>
    </div>
    @if (isset($order_details) && !empty($order_details))
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="container mt-5 mb-5">
                            <div class="row">
                                @if ($order_details->status == 'Pending')
                                    <div class="col-12 p-link ml-3 text-right">
                                        <a class="mr-0" onclick="makePayment();">Make
                                            Payment</a>
                                    </div>
                                @endif
                                @if ($order_details->status != 'Canceled')
                                    <div class="col-12 p-text-link mt-3 text-right">
                                        @if (
                                            $order_details->status == 'Pending' ||
                                                $order_details->status == 'Processing' ||
                                                $order_details->status == 'Pending Payment')
                                            <button class="btn rmv_button mb-2 btn-danger" id="cancel_Order"
                                                data-id="{{ $order_details->id }}">Cancel
                                                Order
                                            </button>
                                        @endif
                                        
                                            <a class="btn rmv_button mb-2 btn-primary" href="{{$order_details->pdf_path}}" download="{{substr($order_details->pdf_path, strrpos($order_details->pdf_path, '/') + 1)}}">
                                                Download Invoice <i class="fa fa-download"></i></a>
                                    </div>
                                @endif
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="row mb-4">
                                        <div class="col-sm-6">
                                            @if ($order_details->status != 'Pending')
                                                <div>
                                                    <strong>Invoice # {{ $order_details->id }}</strong>
                                                </div>
                                            @endif
                                            <div>Order # {{ $order_details->id }}</div>
                                            <div>Order Date: {{ $order_details->updated_at->format('l, d M Y h:i A') }}</div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div>
                                                <strong>Tax Invoice / Bill of Supply / Cash Memo</strong>
                                            </div>
                                            @if (isset($address_details) && !empty($address_details))
                                                @if (isset($address_details->gst_number) && !empty($address_details->gst_number))
                                                    <div>GST NUMBER : {{ $address_details->gst_number }}</div>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body" style="background-color: #8080802b;color: #000">
                                    <div class="row mb-4">
                                        <div class="col-sm-6">
                                            <div>
                                                Order Status : <strong>{{ $order_details->status }}</strong>
                                            </div>

                                        </div>
                                        <div class="col-sm-6">
                                            <div>
                                                <strong>Order Comment</strong>
                                            </div>
                                            <div>
                                                @if ($order_details->status != 'Pending Payment' && isset($order_details->comment) && !empty($order_details->comment))
                                                    {{ $order_details->comment }}
                                                @else
                                                Your order has been placed successfully. We will update you once it is confirmed.
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-4">
                                        <div class="col-sm-6">
                                            <?php

                                                // $product_id = explode(',', $order_details->product_id);
                                                // $order_items = App\Models\Product::where('id', $product_id)->where('visiblity' , 1)->get();
                                                $total_weight = 0;
                                                $sub_total = 0;
                                                $totalGrandPrice = 0;
                                                foreach($order_items as $single_items_w)
                                                {
                                                    $product = App\Models\Product::where('id',$single_items_w->product_id)->first();
                                                    $total_price = str_replace(',', '', $product->total_price($product->id));
                                                    $total_price_numeric = (float) $total_price;
                                                    $total_weight += floatval($product->p_metal_weigth);
                                                    $sub_total += $single_items_w->total_price;
                                                    $product_price = $total_price_numeric * floatval($single_items_w->qty);
                                                    $totalGrandPrice += $product_price;
                                                }
                                                ?>
                                            <div><strong>Ship to:</strong></div>
                                            @if (isset($address_details) && !empty($address_details))
                                                <div>{{ isset($address_details->fullname) ? $address_details->fullname : '' }}<br>
                                                    {{ isset($address_details->email) ? $address_details->email : '' }}<br>
                                                    {{ isset($address_details->address) ? $address_details->address : '' }},{{ isset($address_details->address2) ? $address_details->address2 : '' }}<br>
                                                    {{ isset($address_details->get_city->name) ? $address_details->get_city->name : '' }}, {{ isset($address_details->get_state->name) ? $address_details->get_state->name : '' }}<br>
                                                    {{ isset($address_details->get_country->name) ? $address_details->get_country->name : '' }}<br>
                                                    {{ isset($address_details->zipcode) ? $address_details->zipcode : ''}}<br>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="col-sm-6 ">
                                            @if (isset($order_details->checkout_method) && !empty($order_details->checkout_method))
                                                <div>
                                                    <strong>Payment Method </strong>
                                                </div>
                                                <div>{{ $order_details->checkout_method }}</div>
                                            @endif
                                            <br>

                                            <div>
                                                <strong>Shipping Method:</strong>
                                            </div>
                                            <div></div>
                                            <div>
                                                @php
                                                    $shipping_amount = $order_details->check_shipping_amount($order_details->id);   
                                                @endphp
                                                (Total Shipping Charges
                                                ₹ {{ number_format($shipping_amount, 2) }})
                                            </div>
                                        </div>


                                    </div>


                                </div>


                                <div class="table-responsive-sm">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th class="center">Sr No</th>
                                                <th>Product</th>
                                                <th>Product Code</th>
                                                <th>Product Weight</th>
                                                <th>Quantity</th>
                                                <th class="right">Price</th>
                                                <th class="right">Total</th>
                                            </tr>
                                        </thead>

                                               <tbody>
                                            <?php $i = 1;

                                          
                                             ?>

                                            @foreach ($order_items as $single_items)
                                            @php
                                                $product = App\Models\Product::where('id',$single_items->product_id)->first();
                                            @endphp
                                                <?php
                                                if ($single_items->price == 'TBC') {
                                                    $single_items->price = 0.0;
                                                }
                                                ?>
                                                <tr>
                                                    <td class="center" width="5%">{{ $i }}</td>
                                                    <td class="left strong" width="35%">
                                                        {{ $product->p_title }}@if (isset($single_items->cart_item_comment) && !empty($single_items->cart_item_comment))
                                                            <br><br><strong>Note : </strong>
                                                            
                                                        @endif
                                                    </td>
                                                    @if (isset($product->p_sku) && !empty($product->p_sku))
                                                        <td class="left strong" width="15%">{{ $product->p_sku }}
                                                        </td>
                                                    @else
                                                        <td class="left strong" width="15%"></td>
                                                    @endif
                                                    <td class="left strong" width="15%">
                                                        @if (isset($product->p_metal_weigth) &&
                                                                !empty($product->p_metal_weigth) &&
                                                                isset($product->p_metal_weight_unit) &&
                                                                !empty($product->p_metal_weight_unit))
                                                            {{ $product->p_metal_weigth }}
                                                            {{ $product->p_metal_weight_unit }}
                                                        @endif
                                                    </td>
                                                    <td class="right" width="10%">{{ $single_items->qty }}
                                                    </td>
                                                    @if (isset($single_items->offer_price) && !empty($single_items->offer_price))
                                                        <td class="right" width="10%">
                                                            ₹ {{ number_format($single_items->offer_price, 2) }}<br>
                                                            <small
                                                                class="price-strike-over">{{ number_format($single_items->total_price, 2) }}</small>
                                                        </td>
                                                    @else
                                                        <td class="right" width="10%">
                                                            ₹ {{ number_format($single_items->total_price, 2) }}</td>
                                                    @endif
                                                    @if (isset($single_items->offer_price) && !empty($single_items->offer_price))
                                                        <td class="right" width="10%">
                                                            ₹
                                                            {{ number_format($single_items->qty * $single_items->total_price, 2) }}
                                                            <br>
                                                            <small
                                                                class="price-strike-over">{{ number_format($single_items->qty * $single_items->total_price, 2) }}</small>
                                                        </td>
                                                    @else
                                                        <td class="right" width="10%">
                                                            ₹
                                                            {{ number_format($single_items->qty * $single_items->total_price, 2) }}
                                                        </td>
                                                    @endif
                                                </tr>
                                                <?php $i++; ?>
                                            @endforeach
                                        </tbody>


                                    </table>
                                </div>
                                <div class="row">
                                    <div class="col-lg-8"></div>
                                    <div class="col-lg-4 ml-auto">
                                        <table class="table table-clear">
                                            <tbody>
                                                
                                                <input type="hidden" id="grand_total_order" value="{{$totalGrandPrice + $shipping_amount}}">
                                                <tr>
                                                    <td class="left">
                                                        <strong>Total Weight</strong>
                                                    </td>
                                                    <td class="text-right right">
                                                        
                                                            {{ number_format($total_weight, 2) }}
                                                            grams
                                                      
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="left">
                                                        <strong>Subtotal</strong>
                                                    </td>
                                                    <?php
                                                    $order_discounted_amount_via_promo_code = 0.0;
                                                    if (isset($order_details->order_discounted_amount_via_promo_code) && !empty($order_details->order_discounted_amount_via_promo_code)) {
                                                        $order_discounted_amount_via_promo_code = $order_details->order_discounted_amount_via_promo_code;
                                                    }
                                                    //$order_details->total = $order_details->total - $order_details->shipping_amount;
                                                    $order_details->total = $order_details->total + $order_discounted_amount_via_promo_code;
                                                    ?>
                                                    <td class="text-right right">
                                                        ₹ {{ number_format($totalGrandPrice, 2) }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="left">
                                                        <strong>Shipping </strong>
                                                    </td>
                                                    <td class="text-right right"> +
                                                        ₹ {{ number_format($shipping_amount, 2) }}</td>
                                                </tr>
                                                @if (isset($order_details->order_promo_code) && !empty($order_details->order_promo_code))
                                                    <tr>
                                                        <td class="left">
                                                            <strong>Discount </strong><br>
                                                            <span>Promo Code :
                                                                {{ $order_details->order_promo_code }}</span>
                                                        </td>
                                                        <td class="text-right right"> -
                                                            ₹
                                                            {{ number_format($order_details->order_discounted_amount_via_promo_code, 2) }}
                                                        </td>
                                                    </tr>
                                                @endif
                                                <tr>
                                                    <td class="left">
                                                        <strong>Total</strong>
                                                    </td>
                                                    <td class="text-right right">
                                                        <strong>₹
                                                            {{ number_format($totalGrandPrice + $shipping_amount, 2) }}</strong>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                              

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="product">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="text-center mt-3">No Order Found</h3>
                </div>
            </div>
        </div>
    @endif
    <div id="loader" class="overlay" style="background-color:rgba(255, 255, 255, 0.34);">
            <div style="position: relative; top: 46%;">
                <div class="row justify-content-center">
                    <div class="col-auto text-center">
                        <img src="{{ asset('front/loading-image.gif') }}">
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
@endsection
@section('script')
    <script src="https://sdk.cashfree.com/js/ui/1.0.26/dropinClient.sandbox.js"></script>
    <script src="https://jewelxy.workdemo.in.net/js/sweetalert/sweetalert2.all.min.js"></script>
    <script>
 $("#cancel_Order").click(function() {
            var order_id = $(this).data("id");
            Swal.fire({
                title: 'Comment',
                input: 'text',
                inputPlaceholder: 'Please enter your comment',
                showCancelButton: true,
                confirmButtonText: 'Comment!',
                confirmButtonColor: "var(--theme-orange-red)",
                showLoaderOnConfirm: true,
                preConfirm: (comment) => {
                    if (!comment || comment.trim() === '') {
                        Swal.showValidationMessage('Please enter a comment');
                    }
                    return comment;
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('cancel_order') }}',
                        type: 'POST',
                        data: {
                            'comment': result.value,
                            'order_id': order_id,
                            '_token': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.status == 1) {
                                Swal.fire({
                                    title: 'Success',
                                    text: response.message,
                                    icon: 'success',
                                    customClass: {
                                        confirmButton: 'custom-confirm-button-class'
                                    }
                                }).then(() => {
                                    window.location.reload();
                                });
                            } else {
                                Swal.fire('Error', 'Something went wrong!', 'error');
                                // swal({
                                //   title: "Error",
                                //   text: "Something went wrong!",
                                //   icon: "error",
                                //   buttonsStyling: false,
                                //   confirmButtonColor: "var(--theme-orange-red)", // Set your desired color here
                                // });
                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.fire('Error', 'Something went wrong!', 'error');
                        }
                    });
                }
            });
        });


    </script>
    <script>
        function makePayment() {
            $('#loader').show();
                var cf_order_id_2 = '{{ $order_details->id }}';
                var cf_email_2 = '{{ $address_details->email }}';
                var grand_to = $('#grand_total_order').val();
                var cf_grand_total_2 = parseFloat(grand_to).toFixed(2);
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
                                alert('success');
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
                                    saveCashfreePaymentID(cf_order_id_2,cf_order_status,
                                        orderToken_3, cf_orderID,
                                        cf_transactionId, cf_grand_total_2)
                                                //on failure during payment initiation
                                                swal("Error", "Payment is in pending!",
                                                "error");
                                    //console.log(data);
                                }
                            },
                            "onFailure": function(data) {

                                //on failure during payment initiation
                                saveCashfreePaymentID(cf_order_id_2,cf_order_status,
                                        orderToken_3, cf_orderID,
                                        cf_transactionId, cf_grand_total_2)
                                                //on failure during payment initiation
                                                swal("Error", "Payment is in pending!",
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
                    'cf_order_status': cf_order_status,
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
    </script>
@endsection
