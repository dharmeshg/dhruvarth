<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
.card {
  position: relative;
  display: -ms-flexbox;
  display: flex;
  -ms-flex-direction: column;
  flex-direction: column;
  min-width: 0;
  word-wrap: break-word;
  background-color: #fff;
  background-clip: border-box;
  border: 1px solid rgba(0, 0, 0, 0.125);
  border-radius: 0.25rem;
}

.card > hr {
  margin-right: 0;
  margin-left: 0;
}

.card > .list-group {
  border-top: inherit;
  border-bottom: inherit;
}

.card > .list-group:first-child {
  border-top-width: 0;
  border-top-left-radius: calc(0.25rem - 1px);
  border-top-right-radius: calc(0.25rem - 1px);
}

.card > .list-group:last-child {
  border-bottom-width: 0;
  border-bottom-right-radius: calc(0.25rem - 1px);
  border-bottom-left-radius: calc(0.25rem - 1px);
}

.card > .card-header + .list-group,
.card > .list-group + .card-footer {
  border-top: 0;
}

.card-body {
  -ms-flex: 1 1 auto;
  flex: 1 1 auto;
  min-height: 1px;
  padding: 1.25rem;
}

.card-title {
  margin-bottom: 0.75rem;
}

.card-subtitle {
  margin-top: -0.375rem;
  margin-bottom: 0;
}

.card-text:last-child {
  margin-bottom: 0;
}

.card-link:hover {
  text-decoration: none;
}

.card-link + .card-link {
  margin-left: 1.25rem;
}

.card-header {
  padding: 0.75rem 1.25rem;
  margin-bottom: 0;
  background-color: rgba(0, 0, 0, 0.03);
  border-bottom: 1px solid rgba(0, 0, 0, 0.125);
}

.card-header:first-child {
  border-radius: calc(0.25rem - 1px) calc(0.25rem - 1px) 0 0;
}

.card-footer {
  padding: 0.75rem 1.25rem;
  background-color: rgba(0, 0, 0, 0.03);
  border-top: 1px solid rgba(0, 0, 0, 0.125);
}

.card-footer:last-child {
  border-radius: 0 0 calc(0.25rem - 1px) calc(0.25rem - 1px);
}

.card-header-tabs {
  margin-right: -0.625rem;
  margin-bottom: -0.75rem;
  margin-left: -0.625rem;
  border-bottom: 0;
}

.card-header-pills {
  margin-right: -0.625rem;
  margin-left: -0.625rem;
}

.card-img-overlay {
  position: absolute;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  padding: 1.25rem;
  border-radius: calc(0.25rem - 1px);
}

.card-img,
.card-img-top,
.card-img-bottom {
  -ms-flex-negative: 0;
  flex-shrink: 0;
  width: 100%;
}

.card-img,
.card-img-top {
  border-top-left-radius: calc(0.25rem - 1px);
  border-top-right-radius: calc(0.25rem - 1px);
}

.card-img,
.card-img-bottom {
  border-bottom-right-radius: calc(0.25rem - 1px);
  border-bottom-left-radius: calc(0.25rem - 1px);
}

.card-deck .card {
  margin-bottom: 15px;
}

@media (min-width: 576px) {
  .card-deck {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-flow: row wrap;
    flex-flow: row wrap;
    margin-right: -15px;
    margin-left: -15px;
  }
  .card-deck .card {
    -ms-flex: 1 0 0%;
    flex: 1 0 0%;
    margin-right: 15px;
    margin-bottom: 0;
    margin-left: 15px;
  }
}

.card-group > .card {
  margin-bottom: 15px;
}

@media (min-width: 576px) {
  .card-group {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-flow: row wrap;
    flex-flow: row wrap;
  }
  .card-group > .card {
    -ms-flex: 1 0 0%;
    flex: 1 0 0%;
    margin-bottom: 0;
  }
  .card-group > .card + .card {
    margin-left: 0;
    border-left: 0;
  }
  .card-group > .card:not(:last-child) {
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
  }
  .card-group > .card:not(:last-child) .card-img-top,
  .card-group > .card:not(:last-child) .card-header {
    border-top-right-radius: 0;
  }
  .card-group > .card:not(:last-child) .card-img-bottom,
  .card-group > .card:not(:last-child) .card-footer {
    border-bottom-right-radius: 0;
  }
  .card-group > .card:not(:first-child) {
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
  }
  .card-group > .card:not(:first-child) .card-img-top,
  .card-group > .card:not(:first-child) .card-header {
    border-top-left-radius: 0;
  }
  .card-group > .card:not(:first-child) .card-img-bottom,
  .card-group > .card:not(:first-child) .card-footer {
    border-bottom-left-radius: 0;
  }
}

.card-columns .card {
  margin-bottom: 0.75rem;
}

@media (min-width: 576px) {
  .card-columns {
    -webkit-column-count: 3;
    -moz-column-count: 3;
    column-count: 3;
    -webkit-column-gap: 1.25rem;
    -moz-column-gap: 1.25rem;
    column-gap: 1.25rem;
    orphans: 1;
    widows: 1;
  }
  .card-columns .card {
    display: inline-block;
    width: 100%;
  }
}
.text-right {
    text-align: right !important;
}
.table {
  width: 100%;
  margin-bottom: 1rem;
  color: #212529;
}

.table th,
.table td {
  padding: 0.75rem;
  vertical-align: top;
  border-top: 1px solid #dee2e6;
}

.table thead th {
  vertical-align: bottom;
  border-bottom: 2px solid #dee2e6;
}

.table tbody + tbody {
  border-top: 2px solid #dee2e6;
}

.table-sm th,
.table-sm td {
  padding: 0.3rem;
}

.table-striped tbody tr:nth-of-type(odd) {
  background-color: rgba(255, 255, 255, 0.05);
}
</style>
<div class="margin-top-head @if($display_pg == 1) header-note @endif"></div>
<section class="common-section all-product-list-section">
    <div class="container-md">
        <div class="row">
            <div class="col-xxl-8">
                <span class="d-flex page-nav-text">
                    <a href="{{ route('home') }}" aria-label="home"><img src="{{asset('front/src/images/home-icon.svg')}}" alt="Home" width="auto" height="auto"></a> <span class="dash-line">/</span>
                    <a href="{{route('user.account.details')}}" aria-label="home icon">My Account</a><span class="dash-line">/</span>
                    <a href="{{route('user.account.details')}}" aria-label="home icon">My Orders</a> <span class="dash-line">/</span> <a>Order # {{ $order_details->id }}</a>
                </span>
            </div>
        </div>
    </div>
</section>
  
<section class="order-detail-pages common-padding padding-pages">  
@if (isset($order_details) && !empty($order_details))
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="row">
                    <div class="container mt-5 mb-5">
                        <div class="row">
                            @if ($order_details->status != 'Canceled')
                                <div class="col-12 p-text-link mt-3 text-right">
                                    @if (
                                        $order_details->status == 'Pending' ||
                                            $order_details->status == 'Processing' ||
                                            $order_details->status == 'Pending Payment')
                                        <button class="btn rmv_button mb-2 btn-danger" id="cancel_Order"
                                            data-id="{{ $order_details->id }}"><i class="fa fa-close"></i> Cancel
                                            Order
                                        </button>
                                    @endif

                                    @if ($order_details->status == 'Pending')
                                        <a class="mr-0" onclick="makePayment();"><i class="fa fa-credit-card"></i> Make Payment</a>
                                    @endif

                                    <a class="btn rmv_button mb-2 btn-primary" href="{{$order_details->pdf_path}}" download="{{substr($order_details->pdf_path, strrpos($order_details->pdf_path, '/') + 1)}}"><i class="fa fa-download"></i> Download Invoice</a>
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
                                                if($single_items_w->product_type == 'simple')
                                                {
                                                    $product = App\Models\Product::withoutGlobalScope(\App\Scopes\IsPublicScope::class)->where('id',$single_items_w->product_id)->first();
                                                }else{
                                                    $product = App\Models\VariantProduct::withoutGlobalScope(\App\Scopes\IsPublicVarinatScope::class)->where('id',$single_items_w->product_id)->first();
                                                }
                                                if(!$product)
                                                {
                                                    continue;
                                                }
                                                // $product = App\Models\Product::where('id',$single_items_w->product_id)->first();
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


                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th class="center">Sr No</th>
                                            <th>Product</th>
                                            <th>Product Code</th>
                                            <th>Product Weight</th>
                                            <th>Quantity</th>
                                            @if($order_items->contains('promo_code_id', '!=', null))
                                                <th class="right">Code Discount</th>
                                            @endif
                                            <th class="right">Price</th>
                                            <th class="right">Total</th>
                                        </tr>
                                    </thead>

                                           <tbody>
                                        <?php $i = 1;

                                      
                                         ?>
                                        @foreach ($order_items as $single_items)
                                        @php
                                        if($single_items->product_type == 'simple')
                                        {
                                            $product = App\Models\Product::withoutGlobalScope(\App\Scopes\IsPublicScope::class)->where('id',$single_items->product_id)->first();
                                        }else{
                                            $product = App\Models\VariantProduct::withoutGlobalScope(\App\Scopes\IsPublicVarinatScope::class)->where('id',$single_items->product_id)->first();
                                        }
                                        if(!$product)
                                        {
                                            continue;
                                        }
                                            // $product = App\Models\Product::where('id',$single_items->product_id)->first();
                                        @endphp
                                            <?php
                                            if ($single_items->price == 'TBC') {
                                                $single_items->price = 0.0;
                                            }
                                            ?>
                                            <tr>
                                                <td class="center" width="5%">{{ $i }}</td>
                                                <td class="left strong" width="30%">
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
                                                <td class="left strong" width="10%">
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
                                                @if($order_items->contains('promo_code_id', '!=', null))
                                                
                                                    <td class="right" width="10%"> {{ $single_items->promo_code_discount ? '₹ '. number_format($single_items->promo_code_discount, 2) : '-' }}</td>
                                                @endif
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
                                                        @php 
                                                        if(isset($single_items->promo_code_discount) && $single_items->promo_code_discount != null)
                                                        {
                                                            $each_total = ($single_items->qty * $single_items->total_price) - $single_items->promo_code_discount;
                                                        }else{
                                                            $each_total = $single_items->qty * $single_items->total_price;
                                                        }
                                                        @endphp
                                                        ₹
                                                        {{ number_format($each_total, 2) }}
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
                                            @php 
                                                $promo_code_dicount = 0;
                                            @endphp
                                            @if (isset($order_details->promo_code_discount) && !empty($order_details->promo_code_discount))
                                            @php 
                                                $promo_code_dicount = $order_details->promo_code_discount;
                                            @endphp
                                                <tr>
                                                    <td class="left">
                                                        <strong>Your Saving </strong>
                                                    </td>
                                                    <td class="text-right right"> -
                                                        ₹
                                                        {{ number_format($promo_code_dicount, 2) }}
                                                    </td>
                                                </tr>
                                            @endif  
                                            <tr>
                                                <td class="left">
                                                    <strong>Shipping </strong>
                                                </td>
                                                <td class="text-right right"> +
                                                    ₹ {{ number_format($shipping_amount, 2) }}</td>
                                            </tr>
                                            <tr>
                                                <td class="left">
                                                    <strong>Total</strong>
                                                </td>
                                                <td class="text-right right">
                                                    <strong>₹
                                                        {{ number_format($totalGrandPrice + $shipping_amount - $promo_code_dicount, 2) }}</strong>
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
</section>
    
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
<input type="hidden" value="{{ isset($bs->payment_method_type) ? $bs->payment_method_type : '' }}" id="payment_method_type">
<input type="hidden" id="img" value="{{ asset('uploads/'.$bs->business_logo) }}">
@endsection
@section('script')
    <script src="https://sdk.cashfree.com/js/ui/1.0.26/dropinClient.sandbox.js"></script>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
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
            var paymentMethod_1 = $('#payment_method_type').val();
            $('#loader').show();
                var cf_order_id_2 = '{{ $order_details->id }}';
                var cf_email_2 = '{{ $address_details->email }}';
                var grand_to = $('#grand_total_order').val();
                var cf_grand_total_2 = grand_to.replace(',', '');
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
                        // swal("Success", response.message, "success");
                        Swal.fire({
                        title: "Success",
                        text: response.message,
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonColor: "var(--theme-orange-red)", // Set your desired color here
                        });
                        location.reload();
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
                        $('#rzp-button1').prop('disabled', true);
                        $('#proceed_checkout').prop('disabled', true);
                        $('#proceed_checkout').prop('disabled', true);
                        $('#cashfree_payment').prop('disabled', true);
                        Swal.fire("Success", response.message, "success");
                        location.reload();
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
