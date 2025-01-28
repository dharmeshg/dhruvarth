<style>
    .custom-service-title-class {
        @if(isset($data['service_css']['service_title_color']))
        color: {{ $data['service_css']['service_title_color'] }};
        @endif
    }
    .custom-service-title-class:hover{
        @if(isset($data['service_css']['service_title_hover_color']))
        color: {{ $data['service_css']['service_title_hover_color'] }};
        @endif
    }
    .custom-service-sub-title-class {
        @if(isset($data['service_css']['service_subtitle_color']))
        color: {{ $data['service_css']['service_subtitle_color'] }};
        @endif
    }
    .custom-service-sub-title-class:hover{
        @if(isset($data['service_css']['service_subtitle_hover_color']))
        color: {{ $data['service_css']['service_subtitle_hover_color'] }};
        @endif
    }
    .custom-service-class{
        @if(isset($config['service_bg_img']) && $config['service_bg_img'] != null)
        background-image: url('{{ $config['service_bg_img'] }}');
        @endif
        @if(isset($config['service_bg_color']) && $config['service_bg_color'] != null)
        background-color: {{ $config['service_bg_color'] }};
        @endif
        @if(isset($config['service_bg_size']) && $config['service_bg_size'] != null)
        background-size: {{ $config['service_bg_size'] }};
        @endif
        @if(isset($config['service_bg_position']) && $config['service_bg_position'] != null)
        background-position: {{ $config['service_bg_position'] }};
        @endif
        @if(isset($config['service_bg_repeate']) && $config['service_bg_repeate'] != null)
        background-repeat: {{ $config['service_bg_repeate'] }};
        @endif
    }
</style>
<div class="services-sec common-padding common-text custom-service-class {{ isset($config['service_div_class']) && $config['service_div_class'] != null ? $config['service_div_class'] : '' }}" id="{{ isset($config['service_div_id']) && $config['service_div_id'] != null ? $config['service_div_id'] : '' }}">
    <div class="container-md">
        <div class="row align-items-center">
            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                <h4 class="petit-text custom-service-title-class">What We Offer</h4>
                <h2 class="custom-service-sub-title-class">Our Services</h2>
            </div>
        </div>
        @if(isset($data['service_style']) && $data['service_style'] == '0')
        @php
        $service_slider = true;
        $service_col = 'col-xxl-12 col-xl-12 col-lg-12 col-md-6 col-sm-12 col-xs-12';
        @endphp
        @else
        @php
        $service_slider = false;
        $service_col = 'col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-xs-12';
        @endphp
        @endif
        <div class="row align-items-center next-row {{ isset($service_slider) && $service_slider == false ? '' : 'dynamic-service-carousel'}}" id="">
            @if(isset($data['services']) && count($data['services']) > 0)
            @foreach($data['services'] as $val)
            @if(isset($val->image) && $val->image != '' && $val->image != null)
            @php
            $img = App\Models\MediaImage::select('name')->where('id', $val->image)->first();
            $imageUrl = asset('uploads/' . $img->name);
            @endphp
            @endif
            <div class="{{ $service_col }} text-center inner-box" style="margin-bottom: 10px;">
                <a href="{{route('front.formal-wedding')}}">
                    <article class="box-1" style="background-image: url('{{ $imageUrl }}')">
                        <div class="text-content">
                            <div class="inner-text-sec">
                                <h3>{{ isset($val->sub_title) ? $val->sub_title : '' }}</h3>
                                <h4>{{ isset($val->price) ? $val->price : '' }}</h4>
                                <div class="show-on-hover">
                                    <img src="{{ asset('assets/src/images/arrow-right.webp') }}" class="img-fluid"
                                        alt="" width="auto" height="auto">
                                </div>
                            </div>

                        </div>
                    </article>
                </a>
            </div>
            @endforeach
            @endif
        </div>

    </div>
</div>
@section('script')
@parent
<script>
    $(document).ready(function () {
    $('.dynamic-service-carousel').owlCarousel({
        loop: true,
        margin: 15,
        nav: true,
        dots: false,
        autoplay: false,
        slideTransition: 'linear',
        autoplayTimeout: 0,
        autoplaySpeed: 30000,
        autoplayHoverPause: true,
        navText: ['<i class="fa fa-long-arrow-left"></i>', '<i class="fa fa-long-arrow-right"></i>'],
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 4
            },
            1000: {
                items: 4
            }
         }
        });
    });
</script>
@endsection