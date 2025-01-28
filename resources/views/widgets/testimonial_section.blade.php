<style>
    .custom-testi-title-class {
        @if(isset($config['testi_title_color']))
        color: {{ $config['testi_title_color'] }};
        @endif
    }
    .custom-testi-title-class:hover{
        @if(isset($config['testi_title_hover_color']))
        color: {{ $config['testi_title_hover_color'] }};
        @endif
    }
    .custom-testi-sub-title-class {
        @if(isset($config['testi_subtitle_color']))
        color: {{ $config['testi_subtitle_color'] }};
        @endif
    }
    .custom-testi-sub-title-class:hover{
        @if(isset($config['testi_subtitle_hover_color']))
        color: {{ $config['testi_subtitle_hover_color'] }};
        @endif
    }
    .custom-testi-class{
        @if(isset($config['testi_bg_img']) && $config['testi_bg_img'] != null)
        background-image: url('{{ $config['testi_bg_img'] }}');
        @endif
        @if(isset($config['testi_bg_color']) && $config['testi_bg_color'] != null)
        background-color: {{ $config['testi_bg_color'] }};
        @endif
        @if(isset($config['testi_bg_size']) && $config['testi_bg_size'] != null)
        background-size: {{ $config['testi_bg_size'] }};
        @endif
        @if(isset($config['testi_bg_position']) && $config['testi_bg_position'] != null)
        background-position: {{ $config['testi_bg_position'] }};
        @endif
        @if(isset($config['testi_bg_repeate']) && $config['testi_bg_repeate'] != null)
        background-repeat: {{ $config['testi_bg_repeate'] }};
        @endif
    }
</style>
@php
if(isset($config['testimonial_style']) && $config['testimonial_style'] != null && $config['testimonial_style'] != '1')
{
    $slider = 'carousel slide';
}else{
    $slider = '';
}
@endphp
<div class="testimonial-sec p-0 custom-testi-class {{ isset($config['testi_div_class']) && $config['testi_div_class'] != null ? $config['testi_div_class'] : '' }}" id="{{ isset($config['testi_div_id']) && $config['testi_div_id'] != null ? $config['testi_div_id'] : '' }}">
        <div class="row">
            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 testimonial-content">
                <div class="slider container">
                    <div id="testimonial" class="{{ isset($slider) ? $slider: '' }}" data-bs-ride="carousel">

                        <!-- The slideshow -->
                        <div class="{{ isset($slider) &&  $slider != '' ? 'carousel-inner' : '' }} ">
                            @if(isset($data['testimonials']) && count($data['testimonials']) > 0 && !empty($data['testimonials']))
                            @foreach($data['testimonials'] as $key => $item)
                            <div class="{{ isset($slider) &&  $slider != '' ? 'carousel-item' : '' }} @if($loop->first) active @endif" style="margin-bottom: 10px;">
                                <div class="client-comment">
                                     @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $item->rating)
                                            <i class="fa fa-star" style="color: #E4B513;font-size: 30px;    margin-right: 10px;"></i>
                                        @else
                                            <i class="fa fa-star" style="color: #f0f0f0;font-size: 30px;    margin-right: 10px;"></i>
                                        @endif
                                    @endfor
                                   @if(isset($item->content) && $item->content != null)
                                        <!-- {!! html_entity_decode($item->content) !!} -->
                                        {!! html_entity_decode(preg_replace('/<br\s?\/?>/i', '', $item->content)) !!}
                                    @endif
                                </div>
                                <div class="client-details d-flex">
                                    <div class="name-letter">
                                        @if(isset($item->img) && $item->img != null && $item->img != '')
                                        @php
                                        $img_1 = App\Models\MediaImage::select('name')->where('id', $item->img)->first();
                                        @endphp
                                        <img src="{{ asset('uploads/'.$img_1->name) }}" class="img-fluid" alt="">
                                        @else
                                        <span class="slider_name_span">
                                            @if(isset($item->name))
                                                {{ substr($item->name, 0, 1) }}
                                            @endif
                                        </span>
                                        @endif
                                    </div>
                                    <div class="name-details d-flex">
                                        <h5>{{ isset($item->name) ? $item->name : '' }}</h5>
                                         @if(isset($item->review) && $item->review == 1 && $item->review != '')
                                        <a href="https://www.google.com/maps/place/Randy+Stratton+Wedding+Officiant/@43.5329507,-79.6413747,17z/data=!4m16!1m7!3m6!1s0x882b4507d881bc73:0x5b7f7c6d69af0b18!2sRandy+Stratton+Wedding+Officiant!8m2!3d43.5329469!4d-79.6365038!16s%2Fg%2F11vj5dw_v5!3m7!1s0x882b4507d881bc73:0x5b7f7c6d69af0b18!8m2!3d43.5329469!4d-79.6365038!9m1!1b1!16s%2Fg%2F11vj5dw_v5?entry=ttu" target="blank"><img class="img_google" src="{{ asset('assets/src/images/google.webp') }}" class="img-fluid" alt=""></a>
                                        @endif
                                        <p><!-- @ Jelena and Jesse . 4 months <img
                                                src="{{ asset('assets/src/images/google.webp') }}" class="img-fluid"
                                                alt=""> --></p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @endif
                        </div>
                        
                        <!-- Left and right controls -->
                        <div class="left-right-controls">
                            <div class="container">
                                <button class="carousel-control-prev" type="button" data-bs-target="#testimonial"
                                    data-bs-slide="prev">
                                    <i class="fa fa-long-arrow-left"></i>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#testimonial"
                                    data-bs-slide="next">
                                    <i class="fa fa-long-arrow-right"></i>
                                </button>
                            </div>
                        </div>



                    </div>
                </div>
            </div>
        </div>
    </div>