@extends('front.layout.index')
@if(isset($SEOSchemaCode))
@section('seoSchemaContent')
    <script type='application/ld+json'>{!! $SEOSchemaCode !!}</script>
@endsection
@endif
@section('main_content')

@include('front.include.slider')

 <div class="middle-section-of-all-product-part-1">
    <div class="middle-part-1">
    @foreach($sections as $section)
        <!-- product family section start -->
        @if($section->id == 1)
            @include('front.include.shop_by_family')
        @endif
        <!-- product family section end -->

        <!-- new design section start -->
        @if($section->id == 9)
            @include('front.include.new_designs')
        @endif
        <!-- new design section end -->

        <!-- most popular section start -->
        @if($section->id == 24)
            @include('front.include.most_popular')
        @endif
        <!-- most popular section end -->
 
        <!-- buy with confidence start -->
        @if($section->id == 3)
            @include('front.include.confidence')
        @endif     
        <!-- buy with confidence end -->

        <!-- catalogue  start -->
        @if($section->id == 11)
            @include('front.include.catalogs')
        @endif
        <!-- catalogue  end -->
 
        <!-- collection  start -->
        @if($section->id == 2)
            @include('front.include.collection')
        @endif
        <!-- collection  end -->
 
        <!-- testimonisal  start -->
        @if($section->id == 12)
            @include('front.include.testimonial')
        @endif
        <!-- testimonisal  end -->

        <!-- testimonisal  start -->
        @if($section->id == 36)
            @include('front.include.youtube')
        @endif
        <!-- testimonisal  end -->
 
        @if($section->type == 'logo-slider')
            @include('front.include.logo_slider_sec')
        @endif
        
        @if($section->type == 'ads-poster')
            @include('front.include.add_poster_sec')
        @endif
        
        @if($section->type == 'pdf-list')
            @include('front.include.pdfsec')
        @endif

        @if($section->id == 10)
            @include('front.include.gemstone_product')
        @endif
    @endforeach
    </div>
</div>
<div class="middle-section-of-all-product-part-2">
    <div class="middle-part-2">
    @foreach($sections2 as $section)
        <!-- product family section start -->
        @if($section->id == 1)
            @include('front.include.shop_by_family')
        @endif
        <!-- product family section end -->

        <!-- new design section start -->
        @if($section->id == 9)
            @include('front.include.new_designs')
        @endif
        <!-- new design section end -->

        <!-- most popular section start -->
        @if($section->id == 24)
            @include('front.include.most_popular')
        @endif
        <!-- most popular section end -->
 
        <!-- buy with confidence start -->
        @if($section->id == 3)
            @include('front.include.confidence')
        @endif     
        <!-- buy with confidence end -->

        <!-- catalogue  start -->
        @if($section->id == 11)
            @include('front.include.catalogs')
        @endif
        <!-- catalogue  end -->
 
        <!-- collection  start -->
        @if($section->id == 2)
            @include('front.include.collection')
        @endif
        <!-- collection  end -->
 
        <!-- testimonisal  start -->
        @if($section->id == 12)
            @include('front.include.testimonial')
        @endif
        <!-- testimonisal  end -->

        <!-- testimonisal  start -->
        @if($section->id == 36)
            @include('front.include.youtube')
        @endif
        <!-- testimonisal  end -->
 
        @if($section->type == 'logo-slider')
            @include('front.include.logo_slider_sec')
        @endif
        
        @if($section->type == 'ads-poster')
            @include('front.include.add_poster_sec')
        @endif
        
        @if($section->type == 'pdf-list')
            @include('front.include.pdfsec')
        @endif

        @if($section->id == 10)
            @include('front.include.gemstone_product')
        @endif
    @endforeach

    @include('front.include.cta_sec')
    </div>
</div>

@endsection

    
@section('script')


@endsection
  




