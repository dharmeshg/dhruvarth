<?php
echo '<?xml version="1.0" encoding="utf-8"?>';
?>
<rss xmlns:g="http://base.google.com/ns/1.0" version="2.0">
    <channel>
        <title>{{ isset($bs->business_name) ? $bs->business_name : '' }}</title>
        <link>{{ url('/') }}</link>
        <description>{{ isset($bs->business_description) ? $bs->business_description : '' }}</description>
        @if(isset($products) && count($products) > 0)
        @foreach($products as $product)
        @php
            $image = App\Models\ProductImage::where('product_id',$product->id)->where('type',$type)->first();
            if(isset($image) && $image != null)
            {
                $url = asset('product_media/product_images/'.$image->name);
            }
            if(isset($product->p_status) && $product->p_status == 'by_order')
            {
                $p_status = 'in stock';
            }else if(isset($product->p_status) && $product->p_status == 'ready_stock')
            {
                if((isset($product->p_avail_stock_qty) && $product->p_avail_stock_qty != 0 && $product->p_avail_stock_qty != '') || $product->p_avail_stock_qty == null)
                {
                    $p_status = 'in stock'; 
                }else{
                    $p_status = 'Out of stock'; 
                }
            }else{
                $p_status = 'in stock'; 
            }
            $genderMapping = [
                'Men' => 'male',
                'Women' => 'female',
                'Kids' => 'unisex', // or other appropriate mapping
                'Unisex' => 'unisex'
            ];

            $genderValue = isset($product->p_gender) ? $product->p_gender : '';
            $mappedGender = isset($genderMapping[$genderValue]) ? $genderMapping[$genderValue] : '';
        @endphp
        <item>
            @if(isset($product->p_sku) && $product->p_sku != null && $product->p_sku != '')
            <g:id>{{ isset($product->p_sku) ? $product->p_sku : '' }}</g:id>
            <g:mpn>{{ isset($product->p_sku) ? $product->p_sku : '' }}</g:mpn>
            @endif
            @if(isset($product->p_title) && $product->p_title != null && $product->p_title != '')
            <title>{{ $product->p_title }}</title>
            @endif
            @if(isset($product->p_description) && $product->p_description != null && $product->p_description != '')
            <description>{{ isset($product->p_description) ? $product->p_description : '' }}</description>
            @endif
            @if(isset($product->p_slug) && $product->p_slug != null && $product->p_slug != '')
            <link>{{ route('front.detail.products', ['slug' => $product->p_slug]) }}</link>
            @endif
            @if(isset($url) && $url != null && $url != '')
            <g:image_link>{{ isset($url) ? $url : '' }}</g:image_link>
            @endif
            <g:condition>new</g:condition>
            @if(isset($p_status) && $p_status != null && $p_status != '')
            <g:availability>{{ isset($p_status) ? $p_status : '' }}</g:availability>
            @endif
            @if($product->total_price($product->id) !== null && $product->total_price($product->id) !== '0.00')
            <g:price>{{ $product->total_price($product->id) }} INR</g:price>
            @endif
            @if(isset($product->category->category) && $product->category->category != null && $product->category->category != '')
            <g:google_product_category>Apparel &amp; Accessories &gt;  Jewelry &gt; {{ isset($product->category->category) ? $product->category->category : '' }}</g:google_product_category>
            @endif
            @if(isset($product->family->family) && $product->family->family != null && $product->family->family != '')
            <g:product_type>Home &gt; {{ isset($product->category->category) ? $product->category->category : '' }} &gt; {{ isset($product->family->family) ? $product->family->family : '' }}</g:product_type>
            @endif
            @if(isset($product->p_metal_color) && $product->p_metal_color != null && $product->p_metal_color != '')
            @if($product->db_status == 'migrated')
            <g:color>{{ isset($product->p_metal_color) ? $product->p_metal_color : '' }}</g:color>
            @else
            <g:color>{{ isset($product->metalcolor->title) ? $product->metalcolor->title : '' }}</g:color>
            @endif
            @endif
            @if((isset($product->p_size) && $product->p_size != null && $product->p_size != '') && (isset($product->p_unit) && $product->p_unit != null && $product->p_unit != ''))
            <g:size>{{ isset($product->p_size) ? $product->p_size : '' }} {{ isset($product->p_unit) ? $product->p_unit : '' }}</g:size>
            @endif
            @if(isset($mappedGender) && $mappedGender != null && $mappedGender != '')
            <g:gender>{{ isset($mappedGender) ? $mappedGender : '' }}</g:gender>
            @endif
            @if(isset($product->p_brand) && $product->p_brand != null && $product->p_brand != '')
            <g:brand>{{ isset($product->p_brand) ? $product->p_brand : '' }}</g:brand>
            @endif
            <g:custom_label_0>Rating: 4.9</g:custom_label_0>
            @if(isset($product->diamond_details) && $product->diamond_details != null && $product->diamond_details != '')
            @php
                $diamond_json = json_decode($product->diamond_details);
                if(isset($diamond_json[0]->attr_setting) && $diamond_json[0]->attr_setting != '' && $diamond_json[0]->attr_setting != null)
                {
                    $setting = $diamond_json[0]->attr_setting;
                }
            @endphp
            @if(isset($setting) && $setting != '' && $setting != null)
            <g:custom_label_1>Setting Type: {{ $setting }}</g:custom_label_1>
            @endif
            @endif
            @if(isset($product->design->title) && $product->design->title != '' && $product->design->title != null)
            <g:custom_label_2>Silhouette: {{ $product->design->title }}</g:custom_label_2>
            @endif
            <g:custom_label_3>Seller: {{ isset($bs->business_name) ? $bs->business_name : '' }}</g:custom_label_3>
            @if(isset($product->metalpurity->title) && $product->metalpurity->title != null && $product->metalpurity->title != '')
            <g:custom_label_4>Gold Caratage: {{ $product->metalpurity->title }}</g:custom_label_4>
            @endif
            <g:shipping>
                <g:country>IN</g:country>
                <g:service>Standard</g:service>
                <g:price>0.00 INR</g:price>
            </g:shipping>
            @php
                $original_price = $product->total_price($product->id);
                $overall_discount_amount = 0;
                $sale_price = 0;

                if (isset($product) && $product->p_pricetype == 'dynamic') {
                    $overall_discount_amount = $product->overall_discount($product->id, $original_price, $product->making_rate($product->id));
                    $sale_price = $overall_discount_amount + $original_price;
                } else {
                    $overall_discount_amount = isset($product->p_discount) ? $product->p_discount : 0;
                    $sale_price = $overall_discount_amount + $original_price;
                }
                $original_price = (float) $original_price;
                $sale_price = (float) $sale_price;
                $show_offer = $original_price !== $sale_price;
            @endphp

            @if($show_offer)
            <g:offer>
                @if($original_price !== null && $original_price !== 0.00)
                    <g:price>{{ number_format($sale_price, 2, '.', ',') }} INR</g:price>
                @endif
                @if($original_price !== null && $original_price !== 0.00)
                    <g:sale_price>{{ number_format($original_price, 2, '.', ',') }} INR</g:sale_price>
                @endif
                <g:sale_price_effective_date>{{ date('Y-m-d\TH:i:s\Z') }}</g:sale_price_effective_date>
            </g:offer>
            @endif 
        </item>
        @endforeach
        @endif
    </channel>
</rss>