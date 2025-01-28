<style>
    .custom-gallery-title-class {
        @if(isset($config['gallery_title_color']))
        color: {{ $config['gallery_title_color'] }};
        @endif
    }
    .custom-gallery-title-class:hover{
        @if(isset($config['gallery_title_hover_color']))
        color: {{ $config['gallery_title_hover_color'] }};
        @endif
    }
    .custom-gallery-sub-title-class {
        @if(isset($config['gallery_subtitle_color']))
        color: {{ $config['gallery_subtitle_color'] }};
        @endif
    }
    .custom-gallery-sub-title-class:hover{
        @if(isset($config['gallery_subtitle_hover_color']))
        color: {{ $config['gallery_subtitle_hover_color'] }};
        @endif
    }
    .custom-gallery-class{
        @if(isset($config['gallery_bg_img']) && $config['gallery_bg_img'] != null)
        background-image: url('{{ $config['gallery_bg_img'] }}');
        @endif
        @if(isset($config['gallery_bg_color']) && $config['gallery_bg_color'] != null)
        background-color: {{ $config['gallery_bg_color'] }};
        @endif
        @if(isset($config['gallery_bg_size']) && $config['gallery_bg_size'] != null)
        background-size: {{ $config['gallery_bg_size'] }};
        @endif
        @if(isset($config['gallery_bg_position']) && $config['gallery_bg_position'] != null)
        background-position: {{ $config['gallery_bg_position'] }};
        @endif
        @if(isset($config['gallery_bg_repeate']) && $config['gallery_bg_repeate'] != null)
        background-repeat: {{ $config['gallery_bg_repeate'] }};
        @endif
    }
</style>
@php
if(isset($config['gallery_style']) && $config['gallery_style'] != '' && $config['gallery_style'] != null && $config['gallery_style'] == '0')
{
    $gallery_slider = true;
}else{
    $gallery_slider = false;
}
if(isset($config['gallery_column']) && $config['gallery_column'] != '' && $config['gallery_column'] != null)
{
    if($config['gallery_column'] == 'col-4')
    {
        $gallery_col = 'col-xxl-4 col-xl-4 xol-lg-4 col-md-12 col-sm-12 col-xs-12';
    }else if($config['gallery_column'] == 'col-6')
    {
        $gallery_col = 'col-xxl-6 col-xl-6 xol-lg-6 col-md-12 col-sm-12 col-xs-12';
    }else if($config['gallery_column'] == 'col-12')
    {
        $gallery_col = 'col-xxl-12 col-xl-12 xol-lg-12 col-md-12 col-sm-12 col-xs-12';
    }else{
        $gallery_col = 'col-xxl-12 col-xl-12 xol-lg-12 col-md-12 col-sm-12 col-xs-12';
    }
}
if($gallery_slider == true && $config['gallery_column'] == 'col-4')
{
    $g_slider_4 = true;
    $gallery_col = 'col-sm-12 col-xs-12';
}
if($gallery_slider == true && $config['gallery_column'] == 'col-6')
{
    $g_slider_6 = true;
    $gallery_col = 'col-sm-12 col-xs-12';
}

if($gallery_slider == true && $config['gallery_column'] == 'col-12')
{
    $g_slider_12 = true;
    $gallery_col = 'col-sm-12 col-xs-12';
}
@endphp
<div class="our-gallery common-text text-center custom-gallery-class {{ isset($config['gallery_div_class']) && $config['gallery_div_class'] != null ? $config['gallery_div_class'] : '' }}" id="{{ isset($config['gallery_div_id']) && $config['gallery_div_id'] != null ? $config['gallery_div_id'] : '' }}">
    <div class="">
        <div class="row">
            <div class="col-xxl-12 col-xl-12 xol-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                <h4 class="petit-text custom-gallery-title-class">Our Gallery</h4>
                <h2 class="custom-gallery-sub-title-class">Captured Moments</h2>
            </div>
        </div>

        <div class="row popup-gallery {{ isset($gallery_slider) && $gallery_slider != false ? 'dynamic-gallery-carousel' : ''}}">
            @if(isset($data['gallery']) && count($data['gallery']) > 0 && !empty($data['gallery']))
            @foreach($data['gallery'] as $key => $image)  
            <div class="{{$gallery_col}} text-center">
                <figure>
                    <div class="gallery-item">
                        @if(isset($image->banner_image) && $image->banner_image != '' && $image->banner_image != null)
                        @php
                                $img_2 = App\Models\MediaImage::select('name')->where('id', $image->banner_image)->first();
                        @endphp
                        <a data-effect="mfp-zoom-in" href="{{ asset('uploads/'.$img_2->name) }}" title="" class="a">
                        @endif
                            @if(isset($image->featured_img) && $image->featured_img != '' && $image->featured_img != null)
                            @php
                                $img_1 = App\Models\MediaImage::select('name')->where('id', $image->featured_img)->first();
                            @endphp
                            <img class="img-fluid" src="{{ asset('uploads/'.$img_1->name) }}" />
                            @endif
                            <h4 class="petit-text"><img class="img-fluid" src="{{asset('assets/src/images/gallery-plus-img.webp')}}" /></h4>
                        </a>
                    </div>

                </figure>

            </div>
            @endforeach
            @endif
        </div>

        <a href="{{route('front.photo_gallary')}}" class="common-btn text-center">View All</a>

    </div>
</div>
@section('script')
@parent
@if(isset($g_slider_4) && $g_slider_4 == true)
<script>
    $(document).ready(function () {
    $('.dynamic-gallery-carousel').owlCarousel({
        loop:true,
        margin:24,
        nav: true,
        dot:false,
        autoplay: false,
        slideTransition: 'linear',
        autoplayTimeout: 0,
        autoplaySpeed: 30000,
        autoplayHoverPause: true,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:2
            },
            1000:{
                items:3
            }
        }
    })
    });
</script>
@endif
@if(isset($g_slider_6) && $g_slider_6 == true)
<script>
    $(document).ready(function () {
    $('.dynamic-gallery-carousel').owlCarousel({
        loop:true,
        margin:24,
        nav: true,
        dot:false,
        autoplay: false,
        slideTransition: 'linear',
        autoplayTimeout: 0,
        autoplaySpeed: 30000,
        autoplayHoverPause: true,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:2
            },
            1000:{
                items:2
            }
        }
    })
    });
</script>
@endif
@if(isset($g_slider_12) && $g_slider_12 == true)
<script>
    $(document).ready(function () {
    $('.dynamic-gallery-carousel').owlCarousel({
        loop:true,
        margin:24,
        nav: true,
        dot:false,
        autoplay: false,
        slideTransition: 'linear',
        autoplayTimeout: 0,
        autoplaySpeed: 30000,
        autoplayHoverPause: true,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:2
            },
            1000:{
                items:1
            }
        }
    })
    });
</script>
@endif
@endsection