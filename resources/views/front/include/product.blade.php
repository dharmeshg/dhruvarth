

<div class="row">
    <div class="col-xxl-3 menu-col-1">
        @if(isset($product_details) && count($product_details) > 0)
        <h3>Products</h3>
        <ul>
            @php
                $showCount = 7; // Number of items to initially show
                $totalCount = count($product_details);
                $extraItems = $totalCount - $showCount;
                $allProductsLinkShown = false;
                $product_details_array = $product_details->toArray();

                // Sort the product_details array based on check_count
                usort($product_details_array, function($a, $b) use ($product_id) {
                    $check_count_a = App\Models\Product::where('p_category',$product_id)->where('p_family',$a['id'])->where('visiblity',1)->count();
                    $check_count_b = App\Models\Product::where('p_category',$product_id)->where('p_family',$b['id'])->where('visiblity',1)->count();
                    return $check_count_b - $check_count_a;
                });
            @endphp
            @foreach($product_details_array as $index => $product_details_val)
                @php
                    $product_count = $product_details_val['products_count'];
                    $check_count = App\Models\Product::where('p_category',$product_id)->where('p_family',$product_details_val['id'])->where('visiblity',1)->count();
                @endphp
                @if(isset($product_count) && $product_count > 0)
                    <li class="@if($index >= $showCount) d-none product-extra-item @endif">
                        <a href="{{route('front.cat.fam.products',['cat' => $category->slug,'fam' => $product_details_val['slug']])}}">{{$product_details_val['family']}}<small class="menu-p-count">@if(isset($check_count) && $check_count > 0) ({{$check_count}}) @else (0) @endif</small></a>
                    </li>
                @endif
            @endforeach
         
            @if($totalCount > $showCount && !$allProductsLinkShown)
            <li class="view-more-sec">
                <a  class="view-more-link" style="text-decoration: underline;">View More</a>
            </li>
            @endif
           
        @endif
        </ul>
    </div>
    <div class="col-xxl-3 menu-col-2">
        @if(isset($metal_purities) && count($metal_purities) > 0)
            <h3>Metal Purity</h3>
            <ul>
                @foreach($metal_purities as $key => $mr_value)
                <li><a href="{{route('front.caret.products',['cat' => $category->slug, 'purity' => $mr_value->slug])}}">{{$mr_value->title}}</a></li>
                @endforeach    
            </ul>
        @endif
        @if(isset($genders) && count($genders) > 0)
            <h3 class="second-h3">Gender</h3>
            <ul>
                @foreach($genders as $p_gender)
                @php
                    $gender_counts = App\Models\Product::where('p_gender',$p_gender->title)->count();
                @endphp
                @if($gender_counts > 0)
                <li>
                    <a
                    href="{{route('front.gen.products',['cat' => $category->slug,'gender'=> $p_gender->title])}}">{{ $p_gender->title }}</a>
                </li>
                @endif
                @endforeach
            </ul>
        @endif
    </ul>

    </div>
    <div class="col-xxl-3 menu-col-3">
        @if(isset($collection) && count($collection) > 0)
            <h3>Collection</h3>
            <ul>
                @foreach($collection as $collection_value)
                    <li><a href="{{ route('collection.catalogues',['id' => $collection_value->slug]) }}">{{$collection_value->name}}</a></li>
                @endforeach
                <li><a href="{{ route('front.collection') }}">ALL COLLECTIONS</a>
            </ul>
        @endif

    </div>
    <div class="col-xxl-3 menu-col-4">

        @if(isset($product_images) && count($product_images) > 0)
        
        <ul>
            @foreach($product_images as $product_images_val)
                @php
                    $productImage = App\Models\ProductImage::where('product_id',$product_images_val->id)->where('name','!=','business_product/')->first();
                @endphp
                     @if($productImage)
                        <li>
                            <span class="product-image-box">
                                <a href="{{ route('front.detail.products',['slug' => $product_images_val->p_slug]) }}">
                                    @if(isset($product_images_val->db_status) && $product_images_val->db_status == 'manually')
                                    <img src="{{ asset('product_media/product_images/'.$productImage->name) }}" alt="">
                                    @else
                                    <img src="{{ asset('uploads/'.$productImage->name) }}" alt="">
                                    @endif
                                </a>
                            </span>
                        </li>
                    @endif
                    
            @endforeach
        </ul>

        @endif
        <a href="{{route('front.cat.products',['cat' => $category->slug])}}">SEE ALL PRODUCTS</a>
    </div>
</div>
