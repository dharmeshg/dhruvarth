

@if(isset($products) && count($products) > 0)
    <div class="middle-section-of-all-product-part-2">
            <!-- NEW DESIGNS Section -->

            <section class="common-padding common-section most-popular-section product-box-section">
                <div class="container-md">

                    <div class="row">
                        
                        @if($section->checked_title == 1)
                        <h2>NEW DESIGNS</h2>
                        <a href="{{route('front.all.products')}}" class="view-all" aria-label="view-all-link">View all</a>
                        @endif
                        
                        <div class="product-carousel owl-loaded" id="new-design-slider">
                            @foreach($products as $products_value)
                            <div class="col-12 new-design-each" data-product-type="{{ isset($products_value->is_public) && $products_value->is_public == 1 ? 'public' : 'private' }}">
                                <article>
                                    <div class="product-images">
                                        @php
                                            if(isset($products_value) && $products_value->p_pricetype == 'dynamic')
                                            {
                                                $overall_discount_amount = $products_value->overall_discount($products_value->id,$products_value->total_price($products_value->id),$products_value->making_rate($products_value->id));
                                                $original_price = $products_value->total_price($products_value->id);
                                            }else{
                                                $overall_discount_amount = isset($products_value->p_discount) ? $products_value->p_discount : 0;
                                                $original_price = (isset($products_value->p_fix_price) ? floatval($products_value->p_fix_price) : 0) - $overall_discount_amount;
                                            }                                        
                                        @endphp
                                        @if(isset($overall_discount_amount) && $overall_discount_amount > 0 && $products_value->p_pricetype != 'no_price')
                                            @php
                                            $discounted_price = $overall_discount_amount + $products_value->total_price($products_value->id);
                                            $diff =  $discounted_price - $original_price ;
                                            $div = $diff / $discounted_price;
                                            $percentage = $div * 100;
                                            @endphp
                                            <div class="new-collections-tagline number-text">{{number_format($percentage,2)}}% OFF</div>
                                        @endif
                                        <a href="{{ route('front.detail.products',['slug' => $products_value->p_slug]) }}" aria-label="Product Image">
                                            @php
                                                $p_image = App\Models\ProductImage::where('product_id',$products_value->id)->first();
                                                if(isset($p_image->name) && $p_image->name != '' && $p_image->name != null)
                                                {
                                                    if(isset($products_value->db_status) && $products_value->db_status != '' && $products_value->db_status != null && $products_value->db_status == 'manually')
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
                                            <img src="{{$path}}" class="img-fluid" loading="lazy" width="auto"
                                                height="auto" alt="Product Image">
                                        </a>
                                    </div>
                                    <div class="product-details-section">
                                        <a href="{{ route('front.detail.products',['slug' => $products_value->p_slug]) }}" aria-label="Product Namr">
                                            <h3>{{ isset($products_value->p_title) ? Str::limit($products_value->p_title, 100) : '' }}</h3>
                                        </a>
                                        <div class="price-and-gram">
                                            @if($products_value->total_price($products_value->id) != '0.00')
                                            <div>
                                                <span class="price number-text">
                                                    @if($products_value->total_price($products_value->id) != '0.00')
                                                        ₹ {{ number_format($products_value->total_price($products_value->id), 2, '.', ',') }}
                                                    @endif
                                                </span>
                                                @if(isset($overall_discount_amount) && $overall_discount_amount > 0)
                                              
                                                    @if(isset($overall_discount_amount) && $overall_discount_amount > 0)
                                                        <span class="discount-price number-text">₹ {{ number_format($overall_discount_amount + $products_value->total_price($products_value->id), 2, '.', ',') }}</span>
                                                    @endif
                                                    
                                                @endif
                                            </div>
                                            @endif

                                            @if(isset($products_value->p_gross_weight) && $products_value->p_gross_weight != null && $products_value->p_gross_weight > 0)
                                                <span class="gram number-text">
                                                    {{ isset($products_value->p_gross_weight) ? $products_value->p_gross_weight : '' }} 
                                                    @if(isset($products_value->p_gross_weight) && $products_value->p_gross_weight != '') 
                                                        {{ isset($products_value->p_gross_weight_unit) ? $products_value->p_gross_weight_unit : '' }} 
                                                    @endif
                                                </span>
                                            @endif
                                        </div>
                                        <div class="product-action-section">
                                            <a onclick="addToWishlist('{{$products_value->id}}','{{$products_value->p_title}}','{{$products_value->p_slug}}','','{{ $products_value->p_grand_price_total }}','simple');" aria-label="Whishlist" class="whishlist">
                                                <img src="{{ asset('front/src/images/wishlist-icon.svg') }}" width="18" height="18">
                                            </a>

                                            @if(isset($products_value->p_status) && $products_value->p_status != null && $products_value->p_status == 'by_order')

                                                <a onclick="addToCart('{{$products_value->id}}','{{$products_value->p_title}}','{{$products_value->p_grand_price_total}}',null,'','simple');" aria-label="Shop Now" class="shop-now desktop-show-now"><span class="shop-now-span">Shop Now</span></a>
                                                <a onclick="addToCart('{{$products_value->id}}','{{$products_value->p_title}}','{{$products_value->p_grand_price_total}}',null,'','simple');" aria-label="Shop Now" class="shop-now mobile-show-now">
                                                <img src="{{ asset('front/src/images/p-cart.svg') }}" width="18" height="18"></a>

                                            @elseif(isset($products_value->p_status) && $products_value->p_status != '' && $products_value->p_status != null && $products_value->p_status == 'ready_stock')

                                                @if((isset($products_value->p_avail_stock_qty) && $products_value->p_avail_stock_qty != 0 && $products_value->p_avail_stock_qty != '') || $products_value->p_avail_stock_qty == null)
                                                    <a onclick="addToCart('{{$products_value->id}}','{{$products_value->p_title}}','{{$products_value->p_grand_price_total}}',null,'','simple');" aria-label="Shop Now" class="shop-now desktop-show-now"><span class="shop-now-span">Shop Now</span></a>
                                                    <a onclick="addToCart('{{$products_value->id}}','{{$products_value->p_title}}','{{$products_value->p_grand_price_total}}',null,'','simple');" aria-label="Shop Now" class="shop-now mobile-show-now"><img src="{{ asset('front/src/images/p-cart.svg') }}" width="18" height="18"></a>
                                                @else
                                                    <a class="shop-now desktop-show-now"><span class="shop-now-span">OUT OF STOCK</span></a>
                                                    <a class="shop-now mobile-show-now"><img src="{{ asset('front/src/images/notcart.svg') }}" width="18" height="18"></a>
                                                @endif

                                            @endif

                                            <a onclick="share_model('{{$products_value->id}}','product')" aria-label="Share Product" class="add-to-cart">
                                                <img src="{{ asset('front/src/images/share-btn-icon.svg') }}" width="18" height="18">
                                            </a>
                                        </div>
                                    </div>
                                </article>
                            </div>
                            @endforeach
               
                        </div>
                    </div>
                </div>
            </section>
          
    </div>
 @endif