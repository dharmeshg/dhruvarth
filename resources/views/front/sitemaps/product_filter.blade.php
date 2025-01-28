<?php
echo '<?xml version="1.0" encoding="utf-8"?>';
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1"
        xmlns:video="http://www.google.com/schemas/sitemap-video/1.1">
    @foreach($catagories as $catagory)
    @php
        $product_check = $catagory->products()->count();
    @endphp
    @if($product_check > 0)
    <url>
        <loc>{{route('front.cat.products',['cat' => $catagory->slug])}}</loc>
        <lastmod>2024-05-11</lastmod>
        <changefreq>monthly</changefreq>
        <priority>1.00</priority>
    </url>
    @endif
    @endforeach
    @foreach($families as $fam)
    @php
        $product_check_fam = App\Models\Product::where('p_family',$fam->id)->where('visiblity',1)->count();
    @endphp
    @if($product_check_fam > 0)
    <url>
        <loc>{{route('front.fam.products',['fam' => $fam->slug])}}</loc>
        <lastmod>2024-05-11</lastmod>
        <changefreq>monthly</changefreq>
        <priority>1.00</priority>
    </url>
    @endif
    @endforeach
    @foreach($carates as $carat)
    @php
        $product_check_carat = App\Models\Product::where('p_metal_purity',$carat->id)->where('visiblity',1)->count();
    @endphp
    @if($product_check_carat > 0)
    <url>
        <loc>{{route('front.onlycaret.products',['purity' => $carat->slug])}}</loc>
        <lastmod>2024-05-11</lastmod>
        <changefreq>monthly</changefreq>
        <priority>1.00</priority>
    </url>
    @endif
    @endforeach
    @foreach($occasions as $occasion)
    @php
        $product_check_occasion = App\Models\Product::where('p_occasion',$occasion->id)->where('visiblity',1)->count();
    @endphp
    @if($product_check_occasion > 0)
    <url>
        <loc>{{route('front.occasion.products',['occasion' => $occasion->slug])}}</loc>
        <lastmod>2024-05-11</lastmod>
        <changefreq>monthly</changefreq>
        <priority>1.00</priority>
    </url>
    @endif
    @endforeach
    @php
        $men_pro = App\Models\Product::where('p_gender','Men')->count();
        $women_pro = App\Models\Product::where('p_gender','Women')->count();
        $kids_pro = App\Models\Product::where('p_gender','Kids')->count();
        $un_pro = App\Models\Product::where('p_gender','Unisex')->count();
    @endphp
    @if($men_pro > 0)
    <url>
        <loc>{{route('front.gender.products',['gender' => 'Men'])}}</loc>
        <lastmod>2024-05-11</lastmod>
        <changefreq>monthly</changefreq>
        <priority>1.00</priority>
    </url>
    @endif
    @if($women_pro > 0)
    <url>
        <loc>{{route('front.gender.products',['gender' => 'Women'])}}</loc>
        <lastmod>2024-05-11</lastmod>
        <changefreq>monthly</changefreq>
        <priority>1.00</priority>
    </url>
    @endif
    @if($kids_pro > 0)
    <url>
        <loc>{{route('front.gender.products',['gender' => 'Kids'])}}</loc>
        <lastmod>2024-05-11</lastmod>
        <changefreq>monthly</changefreq>
        <priority>1.00</priority>
    </url>
    @endif
    @if($un_pro > 0)
    <url>
        <loc>{{route('front.gender.products',['gender' => 'Unisex'])}}</loc>
        <lastmod>2024-05-11</lastmod>
        <changefreq>monthly</changefreq>
        <priority>1.00</priority>
    </url>
    @endif
</urlset>
               