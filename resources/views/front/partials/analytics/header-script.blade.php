@include('front.partials.analytics.google')
@if(isset($bs->facebook_pixel_id) && !empty($bs->facebook_pixel_id))
    @include('front.partials.analytics.facebook_pixel')
@endif

@if(isset($bs->hotjar_analytics_id) && !empty($bs->hotjar_analytics_id))
    @include('front.partials.analytics.hotjar')
@endif

@if(isset($bs->tawk_to_id) && !empty($bs->tawk_to_id))
    @include('front.partials.analytics.tawk-to')
@endif