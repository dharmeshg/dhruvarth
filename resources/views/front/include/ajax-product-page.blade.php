@if(isset($products) && count($products) > 0)
@foreach($products as $product)
@php
if ($product instanceof App\Models\VariantProduct) {
    $p_image = App\Models\ProductImage::where('product_id',$product->id)->where('type','variant')->first();
    $send_type = 'variant';
}else{
    $p_image = App\Models\ProductImage::where('product_id',$product->id)->where('type','simple')->first();
    $send_type = 'simple';
}

if(isset($p_image->name) && $p_image->name != '' && $p_image->name != null)
{
	if(isset($product->db_status) && $product->db_status != '' && $product->db_status != null && $product->db_status == 'manually')
    {
        if (file_exists(public_path('product_media/product_images/' . $p_image->name))) {

            $path = asset('product_media/product_images/'.$p_image->name);
        }else{
            $path = asset('assets/images/user/img-demo_1041.jpg');
        }
    }else{
       if (file_exists(public_path('uploads/' . $p_image->name))) {

          $path = asset('uploads/'.$p_image->name);

      }else{
          $path = asset('assets/images/user/img-demo_1041.jpg');
      }
    }
}else{
	$path = asset('assets/images/user/img-demo_1041.jpg');
}
@endphp
<!--Single Product Start-->

<div class="col-xxl-3 col-xl-3 col-lg-3 col-md-4 col-sm-12 col-12 all-product-each" data-product-type="{{ isset($product->is_public) && $product->is_public == 1 ? 'public' : 'private' }}">
    <article>
        <div class="product-images">
             @php
          if(isset($product) && $product->p_pricetype == 'dynamic')
          {
              $overall_discount_amount = $product->overall_discount($product->id,$product->total_price($product->id),$product->making_rate($product->id));
              $original_price = $product->total_price($product->id);
          }else{
              
              $overall_discount_amount = isset($product->p_discount) ? $product->p_discount : 0;
              $original_price = (isset($product->p_fix_price) ? floatval($product->p_fix_price) : 0) - $overall_discount_amount;
          }
      @endphp
      @if(isset($overall_discount_amount) && $overall_discount_amount > 0 && $product->p_pricetype != 'no_price')
          @php
          $discounted_price = $overall_discount_amount + $product->total_price($product->id);
          $diff =  $discounted_price - $original_price ;
          $div = $diff / $discounted_price;
          $percentage = $div * 100;
          @endphp
          <div class="new-collections-tagline number-text">{{number_format($percentage,2)}}% OFF</div>
      @endif
            <a href="{{ route('front.detail.products',['slug' => $product->p_slug]) }}" aria-label="Product Image">
                <img src="{{ $path }}" class="img-fluid" loading="lazy" width="auto"
                    height="auto" alt="Product Image">
            </a>
        </div>
        <div class="product-details-section">
            <a href="{{ route('front.detail.products',['slug' => $product->p_slug]) }}" aria-label="Product Namr">
                <h3>{{ isset($product->p_title) ? Str::limit($product->p_title, 100) : '' }}</h3>
            </a>
            <div class="price-and-gram">
                @if($product->total_price($product->id) != '0.00')
                <div>
                    <span class="price number-text">
                        @if($product->total_price($product->id) != '0.00')
                            ₹ {{ number_format($product->total_price($product->id), 2, '.', ',') }}
                        @endif
                    </span>
                    @if(isset($overall_discount_amount) && $overall_discount_amount > 0)
                  
                        @if(isset($overall_discount_amount) && $overall_discount_amount > 0)
                            <span class="discount-price number-text">₹ {{ number_format($overall_discount_amount + $product->total_price($product->id), 2, '.', ',') }}</span>
                        @endif
                        
                    @endif
                </div>
                @endif

                @if(isset($product->p_gross_weight) && $product->p_gross_weight != null && $product->p_gross_weight > 0)
                    <span class="gram number-text">
                        {{ isset($product->p_gross_weight) ? $product->p_gross_weight : '' }} 
                        @if(isset($product->p_gross_weight) && $product->p_gross_weight != '') 
                            {{ isset($product->p_gross_weight_unit) ? $product->p_gross_weight_unit : '' }} 
                        @endif
                    </span>
                @endif
            </div>
            <div class="product-action-section">
                <a onclick="addToWishlist('{{$product->id}}','{{$product->p_title}}','{{$product->p_slug}}','','{{ $product->p_grand_price_total }}','{{ $send_type }}');" aria-label="Whishlist" class="whishlist">
                    <img src="{{ asset('front/src/images/wishlist-icon.svg') }}" width="18" height="18">
                </a>
                
                @if(isset($product->p_status) && $product->p_status != null && $product->p_status == 'by_order')

                    <a onclick="addToCart('{{$product->id}}','{{$product->p_title}}','{{$product->p_grand_price_total}}',null,'','{{ $send_type }}');" aria-label="Shop Now" class="shop-now desktop-show-now"><span class="shop-now-span">Shop Now</span></a>
                    <a onclick="addToCart('{{$product->id}}','{{$product->p_title}}','{{$product->p_grand_price_total}}',null,'','{{ $send_type }}');" aria-label="Shop Now" class="shop-now mobile-show-now">
                    <img src="{{ asset('front/src/images/p-cart.svg') }}" width="18" height="18"></a>

                @elseif(isset($product->p_status) && $product->p_status != '' && $product->p_status != null && $product->p_status == 'ready_stock')

                    @if((isset($product->p_avail_stock_qty) && $product->p_avail_stock_qty != 0 && $product->p_avail_stock_qty != '') || $product->p_avail_stock_qty == null)
                        <a onclick="addToCart('{{$product->id}}','{{$product->p_title}}','{{$product->p_grand_price_total}}',null,'','{{ $send_type }}');" aria-label="Shop Now" class="shop-now desktop-show-now"><span class="shop-now-span">Shop Now</span></a>
                        <a onclick="addToCart('{{$product->id}}','{{$product->p_title}}','{{$product->p_grand_price_total}}',null,'','{{ $send_type }}');" aria-label="Shop Now" class="shop-now mobile-show-now"><img src="{{ asset('front/src/images/p-cart.svg') }}" width="18" height="18"></a>
                    @else
                        <a class="shop-now desktop-show-now"><span class="shop-now-span">OUT OF STOCK</span></a>
                        <a class="shop-now mobile-show-now"><img src="{{ asset('front/src/images/notcart.svg') }}" width="18" height="18"></a>
                    @endif

                @endif
                <a onclick="share_model('{{$product->id}}','product')" aria-label="Share Product" class="add-to-cart">
                    <img src="{{ asset('front/src/images/share-btn-icon.svg') }}" width="18" height="18">
                </a>                                        </div>
            </div>
        </div>
    </article>
</div>


<!--Single Product End-->
@endforeach
@endif