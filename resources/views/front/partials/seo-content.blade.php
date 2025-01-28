
    <meta name="robots" content="index, follow">
    <title>{{ isset($SEOTitleDescription['title']) ? $SEOTitleDescription['title'] : ''}}</title>
    @if(isset($SEOTitleDescription['description']))
    <meta name="description" content="{!! $SEOTitleDescription['description'] ? $SEOTitleDescription['description'] : '' !!}">
    @endif
    <link rel="canonical" href="{{Request::url()}}" />
    <meta property="og:title" content="{{ isset($SEOTitleDescription['title']) ? $SEOTitleDescription['title'] : ''}}" />
    <meta property="og:type" content="Website" />
    <meta property="og:url" content="{{Request::url()}}"/>
    <meta property="og:video" content="{{Config::get('services.website_constant.YOUTUBE_URL')}}"/>
    @if(isset($SEOTitleDescription['description']))
    <meta property="og:description" content="{!! $SEOTitleDescription['description'] ? $SEOTitleDescription['description'] : '' !!}"/>
    @endif
    <meta name="google-site-verification" content="{{Config::get('services.website_constant.JWL_GOOGLE_SITE_VERIFICATION_CONTENT')}}"/>
    <meta property="og:image:secure_url" content="<?php if(isset($product_image) && !empty($product_image)){
        echo $product_image;
    }else{?>{{asset('uploads/'.$bs->business_logo)}}<?php }?>
    "/>
    <meta property="og:image" content="<?php if(isset($product_image) && !empty($product_image)){
        echo $product_image;
    }else{?>{{asset('uploads/'.$bs->business_logo)}}<?php }?>
    "/>
    @if(Config::get('services.website_constant.JWL_FACEBOOK_ID')!='')
        <meta property="fb:app_id" content="{{Config::get('services.website_constant.JWL_FACEBOOK_ID')}}"/>
    @endif
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta property="og:image:alt" content="{{$bs->business_name}}"/>
    <meta property="og:image:width" content="250" />
    <meta property="og:image:height" content="250" />
    <meta name="twitter:card" content="summary" />

    <meta property="og:locale" content="en_US" />
    <meta property="og:site_name" content="{{Request::root()}}"/>


    <meta name="twitter:title" content="{{ isset($SEOTitleDescription['title']) ? $SEOTitleDescription['title'] : ''}}" >
    @if(isset($SEOTitleDescription['description']))
    <meta name="twitter:description" content="{!! $SEOTitleDescription['description'] ? $SEOTitleDescription['description'] : '' !!}">
    @endif
    <meta name="twitter:image" content="<?php if(isset($product_image) && !empty($product_image)){echo $product_image;}else{?>{{asset('uploads/'.$bs->business_logo)}}<?php }?>">

    @if(isset($bs->google_analytics_GA4_id) && !empty($bs->google_analytics_GA4_id))
        @php
            $exvl = explode(',',$bs->google_analytics_GA4_id);
        @endphp
        
        @if(count($exvl) > 0)
            @foreach($exvl as $gval)
            <link href="https://www.googletagmanager.com/gtag/js?id={{$gval}}" rel="preload" as="script">
            @endforeach
        @endif
    @endif
    
    @include('front.partials.analytics.header-script')