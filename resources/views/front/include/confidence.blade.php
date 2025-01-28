
@if(isset($bs->buy_icons) && $bs->buy_icons != '')
@php
   $icons = json_decode($bs->buy_icons, true);
@endphp

<!-- BUY WITH CONFIDENCE Section -->

@php
    $product_icons = isset($product) && is_object($product) && isset($product->buy_with_confidence_sec) ? json_decode($product->buy_with_confidence_sec, true) : [];
@endphp

<section class="common-padding common-section buy-with-confidence-section">
    <div class="container-md">

        <div class="row">
            @if(isset($section))
                @if($section->checked_title == 1)
                        <h2>{{ isset($bs->buy_sec_title) ? $bs->buy_sec_title : 'BUY WITH CONFIDENCE' }}</h2>
                @endif
            @else
                        <h2>{{ isset($bs->buy_sec_title) ? $bs->buy_sec_title : 'BUY WITH CONFIDENCE' }}</h2>
            @endif
            
            @if (!empty($product_icons) && array_filter($product_icons, function($icon) {
                    return !empty($icon['title']) || !empty($icon['icon']);
                }))
                    @foreach($product_icons as $icons_value)
                    <div class="col-xxl-3 xol-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <article>
                            <img src="{{ asset('uploads/images/'.$icons_value['icon']) }}" class="img-fluid" loading="lazy" width="auto" height="auto" alt="{{isset($icons_value['title']) ? $icons_value['title'] : '' }}">
                            <h4>{{isset($icons_value['title']) ? $icons_value['title'] : '' }}</h4>
                        </article>
                    </div>
                    @endforeach 
            @else
                
                @foreach($icons as $icons_value)
                    <div class="col-xxl-3 xol-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                        <article>
                            <img src="{{ asset('uploads/images/'.$icons_value['icon']) }}" class="img-fluid" loading="lazy" width="auto" height="auto" alt="{{isset($icons_value['title']) ? $icons_value['title'] : '' }}">
                            <h4>{{isset($icons_value['title']) ? $icons_value['title'] : '' }}</h4>
                        </article>
                    </div>
                @endforeach 

            @endif 

        </div>
    </div>
</section>
@endif