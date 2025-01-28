@extends('front.layout.index')
@section('main_content')
<div class="margin-top-head @if($display_pg == 1) header-note @endif"></div>
<section class="common-section all-product-list-section">
    <div class="container-md">
        <div class="row">
            <div class="col-xxl-8">
                <span class="d-flex page-nav-text">
                    <a href="{{ route('home') }}" aria-label="home icon"><img src="{{asset('front/src/images/home-icon.svg')}}" alt="Home" width="auto" height="auto"></a> <span class="dash-line">/</span>
                    <a aria-label="home icon">Whishlist</a>
                </span>
            </div>
        </div>
        @if(isset($wish_list) && !empty($wish_list))

        <div class="row">
            <div class="col-xxl-12">
                <h3>WISHLIST</h3>

                @foreach($wish_list as $item)

					@php
					if($item['product_type'] == 'simple')
					{
						$product = App\Models\Product::where('id', $item['product_id'])->first();
					}else{
						$product = App\Models\VariantProduct::where('id', $item['product_id'])->first();
					}
					if(!$product){
						continue;
					}
					$p_image = App\Models\ProductImage::where('product_id',$product->id)->where('type',$item['product_type'])->first();
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
	                                <a href="{{ route('front.detail.products', [$product->p_slug]) }}"><img src="{{$path}}" alt="{{ $product->p_title }}"></a>
	                            </div>
	                            <div class="product-details">
	                                <h4><a href="{{ route('front.detail.products', [$product->p_slug]) }}">{{ $product->p_title }}</a></h4>
	                                <ul>
	                                    @if (isset($product->p_status) && !empty($product->p_status))
											<li><span>Availability :</span> @if($product->p_status == 'by_order') By Order @else Ready Stock @endif</li>
										@endif
	                                    @if (isset($product->p_metal_color) && !empty($product->p_metal_color))
											@if($product->db_status == 'migrated')
                                                <li><span>Metal:</span> {{ isset($product->p_metal_color) ? $product->p_metal_color : '' }}</li>
                                            @else
                                                <li><span>Metal:</span> {{ isset($product->metalcolor->title) ? $product->metalcolor->title : '' }}</li>
                                            @endif
										@endif

	                                    @if (isset($product->p_sku) && !empty($product->p_sku))
											<li><span>SKU :</span> {{ $product->p_sku }}</li>
										@endif
	                                    
	                                </ul>
	                                <div class="price-and-cart d-flex align-items-center justify-content-between">
	                                    <div class=" d-flex align-items-center">
	                                        <!-- <div class="cart-box qty"> 
												<span class="qtyminus qty qty-minus" data-id=""
												data-inputid="qtu{{$loop->index}}"
												field='quantity'>-</span>
												<input type='text' name='quantity' id="qtu{{$loop->index}}"
												data-id=""
												value='{{ isset($item['qty']) ? $item['qty'] : 1 }}' class="qty class_qty" min="1" disabled/>
												<span class="qtyplus qty qty-plus" data-id="{{$loop->index}}"
												data-inputid="qtu{{$loop->index}}"
												field='quantity'>+</span>
											</div> -->
	                                        <h3 class="price">₹ {{ number_format($product->total_price($product->id), 2, '.', ',') }}</h3>
	                                    </div>
	                                    <div class="move_to_cart remove-wishlist">
	                                    <form action="{{ route('front.move.cart.products') }}"
											method="POST">
											{{ csrf_field() }}
											<input type="hidden" value="{{ isset($item['qty']) ? $item['qty'] : 1 }}" name="pro_qty" id="move_pro_qty_qtu{{$loop->index}}" data-inputid="qtu{{$loop->index}}">
											<input type="hidden" value="{{ $item['product_id'] }}" name="product_id">
											<input type="hidden" value="{{ $item['product_type'] }}" name="product_type">
											<button type="submit" class="remove-wishlist-text rmv_button" data-product-id="{{ $item['product_id'] }}"><svg style="width: 17px;margin-right: 10px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path d="M0 24C0 10.7 10.7 0 24 0H69.5c22 0 41.5 12.8 50.6 32h411c26.3 0 45.5 25 38.6 50.4l-41 152.3c-8.5 31.4-37 53.3-69.5 53.3H170.7l5.4 28.5c2.2 11.3 12.1 19.5 23.6 19.5H488c13.3 0 24 10.7 24 24s-10.7 24-24 24H199.7c-34.6 0-64.3-24.6-70.7-58.5L77.4 54.5c-.7-3.8-4-6.5-7.9-6.5H24C10.7 48 0 37.3 0 24zM128 464a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm336-48a48 48 0 1 1 0 96 48 48 0 1 1 0-96z" fill="var(--theme-orange-red)"/></svg> Move to Cart</button>
										</form>
										</div>
	                                    <div class="remove-wishlist">
	                         
	                                        <form action="{{ route('front.remove.wishlist.products') }}" method="POST">
												{{ csrf_field() }}
												<input type="hidden" value="{{ $item['product_id'] }}" id="product_id" name="product_id" >
												<input type="hidden" value="{{ $item['product_type'] }}" name="product_type">
												<button class="rmv_button remove_wishlist remove-wishlist-text"  data-product-id="{{ $item['product_id'] }}" data-product-type="{{ $item['product_type'] }}" type="button"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 13 13" style="width: 14px;margin-right: 10px;"><polyline class="arrow" fill="none" stroke="currentColor" points="1 1,6.5 6.5,12 1"/><polyline class="arrow" fill="none" stroke="currentColor" points="1 12,6.5 6.5,12 12"/></svg>Remove from wishlist</button>
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

        @else
        <div class="row no-product-wishlist">
        	<div class="col-xxl-12">
				<div class="row text-center">
					<div class="col-12">
						<p>You have no items in your wish list.</p>
					</div>
				</div>
				<div class="row mt-3">
					<div class="col-12 col-md mt-3 mt-sm-0 mb-sm-0 mb-2 text-center text-md-center p-link">
						<a href="{{ route('front.all.products') }}">Continue Shopping</a>
					</div>
				</div>
			</div>
		</div>

        @endif
    </div>
</section>

@endsection
@section('script')

<script>
	$('.qty').focusout(function (e){
		var id = $(this).attr('data-id');

		if($(this).val() > 0)
		{
			change_qty($(this).val(),id);
		}
		else{

			$(this).val(1);
			change_qty(1,id);
		}
	});

	$('.qtyplus').click(function (e) {
		var id = $(this).attr('data-id');
		var inputId = $(this).attr('data-inputid');
            // Stop acting like a button
            e.preventDefault();
            // Get the field name

            // Get its current value
            var currentVal = parseInt($('#'+inputId).val());
            // If is not undefined
            if (!isNaN(currentVal)) {
                // Increment
                var dataInputId = $('#move_pro_qty_' + inputId).attr('data-inputid');
                if (dataInputId === inputId) {
			        $('#move_pro_qty_' + inputId).val(currentVal + 1);
			    }
                $('#'+inputId).val(currentVal + 1);
                // change_qty(currentVal + 1, id);
            } else {
                // Otherwise put a 0 there
                $('#'+inputId).val(1);
                // change_qty(1,id);
            }

        });
        // This button will decrement the value till 0
        $(".qtyminus").click(function (e) {
        	var id = $(this).attr('data-id');
        	var inputId = $(this).attr('data-inputid');
            // Stop acting like a button
            e.preventDefault();
            // Get its current value
            var currentVal = parseInt($('#'+inputId).val());
            // If it isn't undefined or its greater than 0
            if (!isNaN(currentVal) && currentVal > 1) {
                // Decrement one
                if (currentVal == 0) {
                    // Increment
                    $('#'+inputId).val( 1);
                    var dataInputId = $('#move_pro_qty_' + inputId).attr('data-inputid');
	                if (dataInputId === inputId) {
				        $('#move_pro_qty_' + inputId).val(currentVal1);
				    }
                    change_qty(1, id);
                } else {
                	$('#'+inputId).val(currentVal - 1);
                	var dataInputId = $('#move_pro_qty_' + inputId).attr('data-inputid');
	                if (dataInputId === inputId) {
				        $('#move_pro_qty_' + inputId).val(currentVal - 1);
				    }
                	change_qty(currentVal - 1, id);

                }

            } else {
                // Otherwise put a 0 there
                $('input[name=' + fieldName + ']').val(1);
            }

        });
        function change_qty(quantity, id) {
        	$('#loader').show();
        	$.ajax({
        		type: "post",
        		url: '',
        		data: {
        			'quantity': quantity,
        			'id': id,
        			'_token': '<?php echo csrf_token();?>'
        		},
        		success: function (data) {
        			$('#loader').hide();
        		},
        		error:function(data){
        			$('#loader').hide();
        		}
        	});

        }
    </script>

        <script>
        $(document).on("click",".remove_wishlist",function() {
            // var cart_id =$('#cart_id').val();
            var product_id =$(this).data('product-id');
			var product_type =$(this).data('product-type');
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
						'product_type':product_type,
                        '_token': '<?php echo csrf_token(); ?>'
                    },
                    success: function(response) {
                        if (response.status == 1) {
                            // $('#loader').hide();
							Swal.fire("Success", "Product removed successfully!", "success");
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