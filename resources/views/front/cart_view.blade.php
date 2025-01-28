@extends('front.layout.index')
@if(isset($SEOSchemaCode))
@section('seoSchemaContent')
    <script type='application/ld+json'>{!! $SEOSchemaCode !!}</script>
@endsection
@endif
@section('main_content')

<div class="margin-top-head @if($display_pg == 1) header-note @endif"></div>
<section class="common-section all-product-list-section">
    <div class="container-md">
        <div class="row">
            <div class="col-xxl-8">
                <span class="d-flex page-nav-text">
                    <a href="{{ route('home') }}" aria-label="home"><img src="{{asset('front/src/images/home-icon.svg')}}" alt="Home" width="auto" height="auto"></a> <span class="dash-line">/</span>
                    <a aria-label="home icon">Cart</a>
                </span>
            </div>
        </div>

        <input type="hidden" id="user_id" value="{{ Auth::user() ? Auth::user()->id : '' }}">

        <div class="row cart-details">
            @if (isset($cart_list) && !empty($cart_list))
                <div class="col-xxl-8" id="left-side-list-div">
                    <h3>CART</h3>
                    @php
                        $totalGrandPrice = 0;
                        $totalqty = 0;
                    @endphp
                    <div id="each-list-div">
                    @foreach ($cart_list as $single_cart_list)

                        @php
                            if($single_cart_list['product_type'] == 'simple')
                            {
                                $product = App\Models\Product::where('id', $single_cart_list['product_id'])->first();
                            }else{
                                $product = App\Models\VariantProduct::where('id', $single_cart_list['product_id'])->first();
                            }
                            
                            
                            if(!$product){
                                continue;
                            }
                            
                            $p_image = App\Models\ProductImage::where('product_id', $product->id)->where('type',$single_cart_list['product_type'])->first();

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
                            $total_price = str_replace(',', '', $product->total_price($product->id));
                            $total_price_numeric = (float) $total_price;
                            $product_price = $total_price_numeric * $single_cart_list['qty'];
                            $totalGrandPrice += $product_price;
                            $totalqty += $single_cart_list['qty'];

                        @endphp
                        <div class="cart_product_list" data-sku="{{ isset($product->p_sku) ? $product->p_sku : '' }}" data-product-id="{{ isset($product->id) ? $product->id : '' }}" data-product-type="{{ isset($single_cart_list['product_type']) ? $single_cart_list['product_type'] : ''  }}">
                            <article>
                                <div class="d-flex inner-div align-items-center">
                                    <div class="product-image">
                                        <a href="{{ route('front.detail.products', [$product->p_slug]) }}"><img src="{{ $path }}" alt="{{ $product->p_title }}" /></a>
                                    </div>
                                    <div class="product-details">
                                        <h4><a href="{{ route('front.detail.products', [$product->p_slug]) }}">{{ $product->p_title }}</a></h4>
                                            @if(isset($product->p_status) && $product->p_status != '' && $product->p_status != null && $product->p_status == 'ready_stock')
                                                <input type="hidden" id="p_avail_qty_{{ $loop->index }}" value="{{ isset($product->p_avail_stock_qty) ? $product->p_avail_stock_qty : 0 }}">
                                            @endif
                                        <ul>
                                            
                                            @if (isset($product->p_status) && !empty($product->p_status))
                                                <li><span>Availability :</span> @if($product->p_status == 'by_order') By Order @else Ready Stock @endif</li>
                                            @endif
                                            @if (isset($product->p_sku) && !empty($product->p_sku))
                                                <li><span>SKU :</span> {{ $product->p_sku }}</li>
                                            @endif
                                            @if (isset($product->p_metal_color) && !empty($product->p_metal_color))

                                                @if($product->db_status == 'migrated')
                                                    <li><span>Metal:</span> {{ isset($product->p_metal_color) ? $product->p_metal_color : '' }}</li>
                                                @else
                                                    <li><span>Metal:</span> {{ isset($product->metalcolor->title) ? $product->metalcolor->title : '' }}</li>
                                                @endif
                                            @endif
                                            
                                        </ul>
                                        <div class="price-and-cart d-flex align-items-center justify-content-between">
                                            <div class=" d-flex align-items-center">
                                                <!-- <div class="cart-box"> 
                                                    <div class="qty qty-minus" onclick="decreaseQty('cartQty')"><span>-</span></div> 
                                                    <input id="cartQty" class="qty" type="number" value="1" min="1" size="1"> 
                                                    <div class="qty qty-plus" onclick="increaseQty('cartQty')"><span>+</span></div> 
                                                </div> -->

                                                <div class="number cart-box" id="myform">
                                                    <span class="qtyminus qty qty-minus"
                                                        data-id=""
                                                        onclick="minQuantity('{{ isset($single_cart_list['id']) ? $single_cart_list['id'] : '' }}','qtu{{ $loop->index }}','{{ $product->id }}','{{ $loop->index }}','{{ $single_cart_list['product_type'] }}')"
                                                        data-inputid="qtu{{ $loop->index }}"
                                                        field='quantity'>-</span>
                                                    <input type='text' name='quantity'
                                                        id="qtu{{ $loop->index }}"
                                                        data-id=""
                                                        value="{{ $single_cart_list['qty'] }}"
                                                        class="class_qty qty" readonly />
                                                    <span class="qty qty-plus"
                                                        data-id=""
                                                        onclick="maxQuantity('{{ isset($single_cart_list['id']) ? $single_cart_list['id'] : '' }}','qtu{{ $loop->index }}','{{ $product->id }}','{{ $loop->index }}','{{ $single_cart_list['product_type'] }}')"
                                                        data-inputid="qtu{{ $loop->index }}"
                                                        field='quantity'>+</span>
                                                </div>
                                            
                                                <input type="hidden" id="price_{{ $loop->index }}" value="{{str_replace(',', '', $product->total_price($product->id))}}">
                                                <div class="pricing-sec">
                                                    <div class="inner-price-sec">
                                                        <h3 class="price" >{{ number_format($product->total_price($product->id), 2, '.', ',') }}</h3>
                                                        <span class="promo_discount_price" id="cart_offer_price_{{ $loop->index }}"></span>
                                                    </div>
                                                    <div class="code-discount-sec desktop">
                                                        
                                                    </div>
                                                </div>
                                                </div>
                                                <div class="code-discount-sec mobile">
                                                    
                                                </div>
                                            <div class="add-note-form">
                                                <textarea name="cart_item_comment" id="cart_item_comment_{{ $loop->index }}" class="cart-item-comment form-control" placeholder="Add a note" data-id="{{ isset($single_cart_list['id']) ? $single_cart_list['id'] : $loop->index }}" data-product-id="{{ isset($product->id) ? $product->id : '' }}">{{ isset($single_cart_list['order_comment']) ? $single_cart_list['order_comment'] : '' }}</textarea>
                                            </div>
                                        </div>

                                        <div class="price-and-cart d-flex align-items-center justify-content-between">
                                           
                                            <div class="remove-cart">
                                                <form action="{{ route('front.move.wishlist.products') }}" method="POST">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="c_product_id" value="{{ isset($single_cart_list['product_id']) ? $single_cart_list['product_id'] : '' }}">
                                                    <input type="hidden" name="c_qty" value="{{ isset($single_cart_list['qty']) ? $single_cart_list['qty'] : 1 }}" id="c_qty_{{ $loop->index }}">
                                                    <input type="hidden" name="c_product_type" value="{{ isset($single_cart_list['product_type']) ? $single_cart_list['product_type'] : '' }}">
                                                    <button class="rmv_button remove-cart-text" type="submit"><svg style="width: 17px;margin-right: 10px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path d="M0 24C0 10.7 10.7 0 24 0H69.5c22 0 41.5 12.8 50.6 32h411c26.3 0 45.5 25 38.6 50.4l-41 152.3c-8.5 31.4-37 53.3-69.5 53.3H170.7l5.4 28.5c2.2 11.3 12.1 19.5 23.6 19.5H488c13.3 0 24 10.7 24 24s-10.7 24-24 24H199.7c-34.6 0-64.3-24.6-70.7-58.5L77.4 54.5c-.7-3.8-4-6.5-7.9-6.5H24C10.7 48 0 37.3 0 24zM128 464a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm336-48a48 48 0 1 1 0 96 48 48 0 1 1 0-96z" fill="var(--theme-orange-red)"/></svg>Move to Wishlist
                                                    </button>
                                                </form>
                                            </div>
                                            <div class="remove-cart">
                                                <!-- <a data-bs-toggle="modal" data-bs-target="#remove_cart" class="remove-cart-text"><img src="./src/images/whishlist-close.svg" height="20px" width="20px" alt="cart-cart"> Remove from cart</a> -->
                                                <form
                                                        action="{{ route('front.remove.cart.products') }}"
                                                        method="POST">
                                                        {{ csrf_field() }}
                                                        <input type="hidden" id="cart_id" name="cart_id" value="{{ isset($single_cart_list['id']) ? $single_cart_list['id'] : '' }}">
                                                        <input type="hidden" id="product_id" name="product_id" value="{{ isset($single_cart_list['product_id']) ? $single_cart_list['product_id'] : '' }}">
                                                        <input type="hidden" id="qty" name="qty" value="{{ isset($single_cart_list['qty']) ? $single_cart_list['qty'] : '' }}">
                                                        <input type="hidden" id="product_type" name="product_type" value="{{ isset($single_cart_list['product_type']) ? $single_cart_list['product_type'] : '' }}">
                                                        <button class="rmv_button remove_cart remove-cart-text" type="button" data-cart-id="{{ isset($single_cart_list['id']) ? $single_cart_list['id'] : '' }}" data-product-id="{{ isset($single_cart_list['product_id']) ? $single_cart_list['product_id'] : '' }}" data-qty="{{ isset($single_cart_list['qty']) ? $single_cart_list['qty'] : '' }}" data-product-type="{{ isset($single_cart_list['product_type']) ? $single_cart_list['product_type'] : '' }}">
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 13 13" style="width: 14px;margin-right: 10px;color: var(--theme-orange-red);">
                                                              <polyline class="arrow" fill="none" stroke="currentColor" points="1 1,6.5 6.5,12 1"/>
                                                              <polyline class="arrow" fill="none" stroke="currentColor" points="1 12,6.5 6.5,12 12"/>
                                                            </svg>
                                                            Remove from Cart
                                                        </button>
                                                    </form>
                                            </div>
                                        </div>

                                        
                                    </div>

                                </div>


                               
                            </article>
                        </div>
                    @endforeach
                    </div>
                </div>

                <div class="col-xxl-4 cart-right-side">
                    @if(isset($avail_promo_codes) && count($avail_promo_codes) > 0)
                        <article class="promo-code-sec">
                            <h4>Coupons &amp; Offers</h4>
                            <ul>
                                @if (!Auth::user())
                                <li><span class="left">Login to unlock the best prices and offers, save more.</span></li>
                                @elseif(Auth::user()->role == 'customer')
                                <input type="hidden" name="applied_promo_code" id="applied_promo_code">
                                <input type="hidden" name="applied_promo_id" id="applied_promo_id">
                                <li><span class="left">Save more with coupons &amp; offers</span></li>
                                @else
                                <li><span class="left">Login to unlock the best prices and offers, save more.</span></li>
                                @endif
                            </ul>
                            <div class="input-sec">
                                <div class="form-group">
                                    <input type="text" id="cart_promo_code" class="form-control" name="promo_code"
                                        data-toggle="tooltip" data-placement="top" title="Promo Code required" placeholder="Enter Promo Code">
                                </div>
                                @if (!Auth::user())
                                <button type="button" data-bs-toggle="modal" data-bs-target="#login-popup">Apply</button>
                                @elseif(Auth::user()->role == 'customer')
                                <button type="button" id="apply_promo_code_btn">Apply</button>
                                @else
                                <button type="button" data-bs-toggle="modal" data-bs-target="#login-popup">Apply</button>
                                @endif
                            </div>
                            <span id="msg_invalid_promocode" class="text-danger"></span>
                            <div class="remove-promo-sec">
                                
                            </div>
                            <div class="list-sec">
                                @if(isset($avail_promo_codes) && count($avail_promo_codes) > 0)
                                <ul>
                                    @foreach($avail_promo_codes as $key => $avail_promo_code)
                                    <li class="promo-item" data-code="{{ isset($avail_promo_code->code) ? $avail_promo_code->code : '' }}">
                                        <div>
                                            <span class="code-class">{{ isset($avail_promo_code->code) ? $avail_promo_code->code : '' }}</span>
                                            <p>{{ isset($avail_promo_code->title) ? $avail_promo_code->title : '' }}</p>
                                            @php
                                                if($avail_promo_code->included_category)
                                            @endphp
                                            <span>@if(isset($avail_promo_code->discount_type) && $avail_promo_code->discount_type == 'amount') {{ $avail_promo_code->discount }}/- @else {{ $avail_promo_code->discount }}% @endif off on selected products.</span>
                                        </div>
                                        @if (!Auth::user())
                                        <button type="button" data-bs-toggle="modal" data-bs-target="#login-popup">Apply</button>
                                        @elseif(Auth::user()->role == 'customer')
                                        <button type="button" class="each-apply-promo-btn" data-code="{{ isset($avail_promo_code->code) ? $avail_promo_code->code : '' }}">Apply</button>
                                        @else
                                        <button type="button" data-bs-toggle="modal" data-bs-target="#login-popup">Apply</button>
                                        @endif
                                    </li>
                                    @endforeach
                                </ul>
                                @if(count($other_avail_promocodes) > 0)
                                    <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#cart-promocodes-popup">View All</a>
                                @endif
                                @endif
                            </div>
                        </article>
                    @endif
                    <div id="order-summary-article-div">
                        <article class="order-summary-article">
                            <h4>Order Summary</h4>
                            <ul>
                                <li><span class="left" id="order_total_items_cal_count">Order Total ({{ $totalqty }} Items)</span><span class="right" id="order_total">{{ number_format($totalGrandPrice, 2) }}</span></li>
                                <li style="display: none;" id="summary-promomcode-discount"><span class="left">Your savings</span><span class="right total-price" id="promocode_discount"></span></li>
                                <li><span class="left">You Pay</span><span class="right total-price" id="you_pay">{{ number_format($totalGrandPrice, 2) }}</span></li>
                            </ul>
                            <p><i>(Inclusive Of All Taxes*)</i></p>
                            @if (!Auth::user())
                                    <button data-bs-toggle="modal" data-bs-target="#login-popup" class="plece_the_order">PLACE ORDER</button>
                                @elseif(Auth::user()->role == 'customer')
                                    <button class="plece_the_order" onclick="placeOrder();">PLACE ORDER</button>
                                @else
                                    <button data-bs-toggle="modal" data-bs-target="#login-popup" class="plece_the_order">PLACE ORDER</button>
                                @endif

                        </article>
                    </div>
                </div>
            @else
                <div class="col-12 no-product-cart mb-0">
                    <div class="row text-center">
                        <div class="col-12">
                            <p>You have no items in your Cart.</p>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12 col-md mt-3 mt-sm-0 mb-sm-0 mb-2 text-center text-md-center p-link">
                            <a href="{{ route('front.all.products') }}">Continue Shopping</a>
                        </div>
                    </div>
                </div>
            @endif
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
</section>

@endsection
@section('script')
<!-- <script src="{{ asset('js/sweetalert/sweetalert2.all.min.js')}}"></script> -->
    <script>
        function minQuantity(id, inputId, index,key,type) {
            var currentVal = parseInt($('#' + inputId).val());
            // If it isn't undefined or its greater than 0
            if (!isNaN(currentVal) && currentVal > 1) {
                // Decrement one
                if (currentVal == 0) {
                    // Increment
                    $('#' + inputId).val(1);
                    $('#c_qty_'+ key).val(1);
                    change_qty(1, id, index,key,type);
                } else {
                    $('#' + inputId).val(currentVal - 1);
                    $('#c_qty_'+ key).val(currentVal - 1);
                    change_qty(currentVal - 1, id, index,key,type);
                }

            } else {
                // Otherwise put a 0 there
                $('input[name=quantity]').val(1);
            }
        }

        function maxQuantity(id, inputId, index,key,type) {
            // Get its current value
            var currentVal = parseInt($('#' + inputId).val());
            var maxQty = parseInt($('#p_avail_qty_'+ key).val());
            if(maxQty)
            {
                if (!isNaN(currentVal)) {
                    // Check if the updated quantity exceeds the maximum allowed quantity
                    if (currentVal + 1 <= maxQty) {
                        // Increment the quantity
                        $('#' + inputId).val(currentVal + 1);
                        $('#c_qty_'+ key).val(currentVal + 1);
                        change_qty(currentVal + 1, id, index, key,type);
                    } else {
                        Swal.fire("Error", "Quantity cannot exceed available stock quantity!", "error");
                    }
                } else {
                    // Otherwise put a 0 there
                    $('#' + inputId).val(1);
                    $('#c_qty_'+ key).val(1);
                    change_qty(1, id, index, key,type);
                }  
            }else{
                $('#' + inputId).val(currentVal + 1);
                $('#c_qty_'+ key).val(currentVal + 1);
                change_qty(currentVal + 1, id, index, key,type);
            }
            
        }
        function change_qty(quantity, id, index,key,type) {
            // alert(index);
            $('#loader').show();
            $.ajax({
                type: "post",
                url: '{{ route('front.update.cart.products') }}',
                data: {
                    'quantity': quantity,
                    'id': id,
                    'product_id': index,
                    'product_type': type,
                    '_token': '<?php echo csrf_token(); ?>'
                },
                success: function(data) {
                    $('#loader').hide();
                    if(data.status == 1)
                    {
                    let single_product_price = $('#price_' + key).val();
                    let single_product_offer_price = $('#cart_offer_price_' + key).text();
                    let single_product_saved_price = $('#saved_price_' + key).val();
                    let total_price = data.qty * single_product_price;
                    let total_offer_price = data.qty * single_product_offer_price;
                    let total_saved_price = data.qty * single_product_saved_price;
                    $('#cart_price_' + index).html(parseFloat(total_price).toFixed(2));
                    $('#cart_saved_price_' + index).html(parseFloat(total_saved_price).toFixed(2));
                    $('#product_qty_offer_price_' + index).val(parseFloat(total_offer_price).toFixed(2));
                    $('#product_qty_saved_price_' + index).val(parseFloat(total_saved_price).toFixed(2));
                    $('#product_qty_price_' + key).val(parseFloat(total_price).toFixed(2));
                    var ttl = data.total_grand_price;
                    var existing_promo = $('#applied_promo_code').val();
                    var existing_promo_id = $('#applied_promo_id').val();
                    if(existing_promo != '' && existing_promo_id != '')
                    {
                        if (typeof main_applied_skus === 'object' && !Array.isArray(main_applied_skus)) {
                            main_applied_skus = Object.values(main_applied_skus); // Convert object values to an array
                        } 
                        promocode_calculation(main_applied_skus,main_promocode,first_prices_skus);
                    }
                    
                    var promo_dicount = $('#promocode_discount').text();
                    let numeric_value = parseFloat(promo_dicount.replace(/,/g, '')) || 0;
                    var final_grand_total = ttl - numeric_value;
                    $('#order_total').html(parseFloat(ttl).toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
                    $('#you_pay').html(parseFloat(final_grand_total).toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
                    var cart_count = data.total_items;
                    $("#order_total_items_count").addClass('d-none');
                    $("#order_total_items_cal_count").removeClass('d-none');
                    $("#order_total_items_cal_count").html('Order Total (' + cart_count + '  Items)');
                    $("#cart_count").html('('+ cart_count + ')');
                    }
                },
                error: function(data) {
                    $('#loader').hide();
                }
            });

        }
    </script>
    <script>
        $(document).on("click", ".remove_cart", function() {
        var cart_id = $(this).data('cart-id');
        var product_id = $(this).data('product-id');
        var qty = $(this).data('qty');
        var product_type = $(this).data('product-type');
        Swal.fire({
                title: 'Are you sure,',
                text: 'You want to remove the Product from cart?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                $.ajax({
                    url: '{{route('front.remove.cart.products')}}',
                    type: 'POST',
                    data: {
                        'cart_id': cart_id,
                        'product_id': product_id,
                        'qty': qty,
                        'product_type': product_type,
                        '_token': '<?php echo csrf_token(); ?>'
                    },
                    success: function(response) {
                        if (response.status == 1) {
                            Swal.fire("Success", "Product removed successfully!", "success");
                            window.location = '{{ route('front.cart.view') }}';
                        } else {
                            Swal.fire("Error", response.message, "error");
                        }
                    }
                });
              }
          });
    });
    </script>
    <script>
        $(document).on("change",".cart-item-comment",function() {
            var comment = $(this).val();
            var cart_id = $(this).data('id');
            var product_id = $(this).data('product-id');
            $.ajax({
                url: '{{route('add.order.note')}}',
                type: 'POST',
                data: {
                    'comment' : comment,
                    'cart_id': cart_id,
                    'product_id': product_id,
                    '_token': '<?php echo csrf_token(); ?>'
                },
                success: function(response) {
                    if (response.status == 1) {
                        Swal.fire("Success", response.message, "success");
                        $('#cart_item_comment_'+ cart_id +'').val(comment);
                    } else {
                        
                    }
                }
            });
        });
    </script>
    <script>
        function applyPromoCode(code,first_prices_skus)
        {
            $('#loader').show();
            $.ajax({
                url: '{{route('manually_apply_promocode')}}',
                type: 'POST',
                data: {
                    'promo_code': code,
                    '_token': '<?php echo csrf_token(); ?>'
                },
                success: function(response) {
                    if (response.status == 1) {
                        $('#applied_promo_code').val(response.promocode.code);
                        $('#applied_promo_id').val(response.promocode.id);

                        let appliedSkus = response.applied_skus;
                        main_promocode = response.promocode;
                        main_applied_skus = response.applied_skus;
                        if (typeof appliedSkus === 'object' && !Array.isArray(appliedSkus)) {
                            appliedSkus = Object.values(appliedSkus); // Convert object values to an array
                        }   
                        let discountApplied = promocode_calculation(appliedSkus,main_promocode,first_prices_skus);
                        if (discountApplied) {
                            $('#apply-promocode-popup').modal('hide');
                            $('#cart_promo_code').val('');
                            $('.promo-code-sec .input-sec').hide();
                            const hidelistElement = $(`.promo-item[data-code="${response.promocode.code}"]`);
                            hidelistElement.hide();
                            $('.promo-code-sec .remove-promo-sec').addClass('with-padding');
                            $('.promo-code-sec .remove-promo-sec').html('<span>' + response.promocode.code + ' Applied</span><a class="remove-promocode-each" data-code="' + response.promocode.code + '">Remove</a>')
                            $('#cart-promocodes-popup').modal('hide');
                            const alreadappliedElement = $(`.modal-apply-btn[data-code="${response.promocode.code}"]`);
                            alreadappliedElement.text('Applied');
                            alreadappliedElement.prop('disabled', true);
                            $('#loader').hide();
                            Swal.fire("Success", 'Promo Code Applied Successfully', "success");
                        }else{
                            $('#loader').hide();
                            $('#applied_promo_code').val('');
                            $('#applied_promo_id').val('');
                            Swal.fire("Info", 'Promo Code applied, but no discount on eligible products.', "info");
                        }
                        
                    } else if (response.status == 0) {
                        $('#cart_promo_code').val('');
                        $('#loader').hide();
                        Swal.fire("Error", response.message, "error");
                    }
                    
                }
            });
        }
        $(document).on("click","#apply_promo_code_btn",function() {
            var promo_code = $('#cart_promo_code').val();
            if(promo_code == '' || promo_code == null)
            {
                $('#msg_invalid_promocode').text('Promo Code is required');
            }else{
                $('#msg_invalid_promocode').text('');
                applyPromoCode(promo_code,first_prices_skus);
            }
        });
        $(document).on("click",".each-apply-promo-btn",function() {
            var code = $(this).data('code');
            var already_applied_id = $('#applied_promo_id').val();
            var already_applied_code = $('#applied_promo_code').val();
            if(already_applied_id != '' && already_applied_code != '')
            {
                Swal.fire("Error", 'Only One Promo Code can be applied!', "error");
            }else{
                applyPromoCode(code,first_prices_skus);
            } 
        });
        $(document).on("click",".remove-promocode-each",function() {
            $('#loader').show();
            
            setTimeout(function() {
                var promo_code = $(this).data('code');
                $('.promo-code-sec .input-sec').show();
                $('#applied_promo_code').val('');
                $('#applied_promo_id').val('');
                
                $('.promo-item[data-code="' + promo_code + '"]').each(function() {
                    if ($(this).css('display') === 'none') {
                        $(this).show();
                    }
                });
                $('.promo-code-sec .remove-promo-sec').html('');
                $('#order-summary-article-div').load(' .order-summary-article', function() {
                    $('#left-side-list-div').load(' #each-list-div', function() {
                        $('.modal-apply-btn[data-code="' + promo_code + '"]').each(function() {
                            if ($(this).text() === 'Applied') {
                                $(this).text('Apply');
                                $(this).prop('disabled', false);
                            }
                        });
                        $('.promo-code-sec .remove-promo-sec').removeClass('with-padding');
                        $('#loader').hide();
                    });
                });
            }.bind(this), 100); 
        });
        var main_promocode = '';
        var main_applied_skus = [];
        var first_prices_skus = [];
        $(document).ready(function() {
            const productElements = $(`.cart_product_list`);
            productElements.each(function() {
                var sku = $(this).data('sku');
                let priceElement = $(this).find('h3.price').text().trim(); 
                first_prices_skus.push({ sku: sku, price: priceElement });
            });
            $('.each-apply-promo-btn').first().trigger('click');
        });
        function promocode_calculation(appliedSkus,promocode,first_prices_skus)
        {
            var code_icon = '{{ asset('front/src/images/cart-detail-promo.svg') }}';
            let totalOriginalPrice = 0;
            let skuPrices = [];
            let discountApplied = false;
            appliedSkus.forEach(sku => {
                const productElement = $(`.cart_product_list[data-sku="${sku}"]`);
                const priceElement = productElement.find('h3.price');
                let priceText = priceElement.text().trim().replace(/,/g, '');
                let oldPrice = parseFloat(priceText);
                const matchingSkuprice = first_prices_skus.find(item => item.sku === sku);
                let old_price_h3 = '';
                if (matchingSkuprice) {
                    old_price_h3 = matchingSkuprice.price;
                }
                let priceneweText = old_price_h3;
                let npriceText = parseFloat(priceneweText.replace(/,/g, ''));
                if (npriceText === 0.00) {
                    return;
                }
                let productqty = parseFloat(productElement.find('.class_qty.qty').val()) || 1;
                skuPrices.push({ sku, price: npriceText, qty: productqty });
                totalOriginalPrice += npriceText * productqty;
                // console.log(oldPrice);
            }); 
            if (totalOriginalPrice === 0) {
                return discountApplied;
            }
            let totalDiscountAmount = 0;
            const promoDiscount = parseFloat(promocode.discount) || 0;
            if (promocode.discount_type === "percentage") {
                totalDiscountAmount = (totalOriginalPrice * promoDiscount) / 100;
            } else {
                totalDiscountAmount = promoDiscount;
            }
            const promo_max_discount = parseFloat(promocode.max_discount_amount) || 0;
            if(promo_max_discount && promo_max_discount != '' && totalDiscountAmount > promo_max_discount)
            {
                totalDiscountAmount = promo_max_discount;
            }
            let totalRatio = 0;
            let skuRatios = skuPrices.map(skuPrice => {
                let ratio = (skuPrice.price * skuPrice.qty) / totalOriginalPrice;
                totalRatio += ratio;
                return { ...skuPrice, ratio };
            });
            // Calculate the discount for each SKU based on its ratio
            skuRatios.forEach(skuRatio => {
                const productElement = $(`.cart_product_list[data-sku="${skuRatio.sku}"]`);
                const priceElement = productElement.find('h3.price');
                const oldPriceElement = productElement.find('.promo_discount_price');
                const discountdsesktopElement = productElement.find('.code-discount-sec.desktop');
                const discountmobileElement = productElement.find('.code-discount-sec.mobile');

                // Calculate the discount amount for this SKU
                let proportionalDiscount = (skuRatio.ratio / totalRatio) * totalDiscountAmount;
                if (proportionalDiscount > 0) {
                    discountApplied = true; // Mark that at least one discount was applied
                }
                let newPrice = (skuRatio.price) - proportionalDiscount;
                newPrice = newPrice.toFixed(2);
                const matchingSku = first_prices_skus.find(item => item.sku === skuRatio.sku);
                let old_price_display = '';
                if (matchingSku) {
                    old_price_display = matchingSku.price;
                }
                let discountString = `Code Discount: <strong>${proportionalDiscount.toFixed(2)}/-</strong>`;

                oldPriceElement.text(old_price_display.toLocaleString());
                discountdsesktopElement.addClass('with-display');
                discountmobileElement.addClass('with-display');
                discountdsesktopElement.html('<img src="'+ code_icon +'" class="img-fluid"> <span class="discount-text desktop">'+ discountString +'</span>');
                discountmobileElement.html('<img src="'+ code_icon +'" class="img-fluid"> <span class="discount-text mobile">'+ discountString +'</span>');
                
                priceElement.text(newPrice.replace(/\d(?=(\d{3})+\.)/g, '$&,'));

                productElement.attr('data-discount', proportionalDiscount.toFixed(2));
            });
            if (!discountApplied) {
                return false; // No discount was applied, stop further UI updates
            }
            var old_you_pay = $('#you_pay').text();
            old_you_pay = old_you_pay.replace(/,/g, '');
            old_you_pay = parseFloat(old_you_pay);
            var new_you_pay = old_you_pay - totalDiscountAmount;
            new_you_pay = new_you_pay.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
            var formattedDiscountAmount = totalDiscountAmount.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
            $('#you_pay').text(new_you_pay);
            $('#summary-promomcode-discount').show();
            $('#promocode_discount').text(formattedDiscountAmount);
            return discountApplied;
        }
    </script>
    <script>
        function placeOrder() {
            var user_id = $('#user_id').val();
            var promo_code_id = $('#applied_promo_id').val();
            var promo_discount = $('#promocode_discount').text();
            var flag = 0;
            var cartProducts = [];
            $('.cart_product_list').each(function() {
                var productDetails = {
                    sku: $(this).data('sku'),
                    product_id: $(this).data('product-id'),
                    product_type: $(this).data('product-type'),
                    price: $(this).find('.price').text(),
                    promo_discount_price: $(this).data('discount')
                };

                cartProducts.push(productDetails);
            });
            if (flag == 0) {
                $('#loader').show();
                $.ajax({
                    url: '{{route('store_promocode_session')}}',
                    type: 'POST',
                    data: {
                        'user_id': user_id,
                        'promo_code_id': promo_code_id,
                        'promo_discount': promo_discount,
                        'cartProducts': cartProducts,
                        '_token': '<?php echo csrf_token(); ?>'
                    },
                    success: function(response) {
                        if (response.status == 1) {
                            window.location = '{{ route('order_checkout') }}';
                        } else {
                            $('#loader').hide();
                            Swal.fire("Access Expired", response.message, "error").then(function() {
                                setTimeout(function() {
                                    window.location = '{{ route('home') }}';
                                }, 500); 
                            });
                        }
                    }
                });
            } else {
                return false;
            }
        }
    </script>
@endsection