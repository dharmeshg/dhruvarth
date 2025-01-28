<style>
    .custom-post-title-class {
        @if(isset($config['post_title_color']))
        color: {{ $config['post_title_color'] }};
        @endif
    }
    .custom-post-title-class:hover{
        @if(isset($config['post_title_hover_color']))
        color: {{ $config['post_title_hover_color'] }};
        @endif
    }
    .custom-post-sub-title-class {
        @if(isset($config['post_subtitle_color']))
        color: {{ $config['post_subtitle_color'] }};
        @endif
    }
    .custom-post-sub-title-class:hover{
        @if(isset($config['post_subtitle_hover_color']))
        color: {{ $config['post_subtitle_hover_color'] }};
        @endif
    }
    .custom-post-class{
        @if(isset($config['post_bg_img']) && $config['post_bg_img'] != null)
        background-image: url('{{ $config['post_bg_img'] }}');
        @endif
        @if(isset($config['post_bg_color']) && $config['post_bg_color'] != null)
        background-color: {{ $config['post_bg_color'] }};
        @endif
        @if(isset($config['post_bg_size']) && $config['post_bg_size'] != null)
        background-size: {{ $config['post_bg_size'] }};
        @endif
        @if(isset($config['post_bg_position']) && $config['post_bg_position'] != null)
        background-position: {{ $config['post_bg_position'] }};
        @endif
        @if(isset($config['post_bg_repeate']) && $config['post_bg_repeate'] != null)
        background-repeat: {{ $config['post_bg_repeate'] }};
        @endif
    }
</style>
<div class="recent-posts common-text custom-post-class {{ isset($config['post_div_class']) && $config['post_div_class'] != null ? $config['post_div_class'] : '' }}" id="{{ isset($config['post_div_id']) && $config['post_div_id'] != null ? $config['post_div_id'] : '' }}">
    <div class="container-md">
        <div class="row">
            <div class="col-xxl-12 col-xl-12 xol-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h4 class="petit-text custom-post-title-class">Recent Posts</h4>
                <h2 class="custom-post-sub-title-class">Marriage Resources</h2>
            </div>
        </div>

        @if(isset($data['post_style']) && $data['post_style'] == '0')
        @php
        $slider = true;
        @endphp
        @else
        @php
        $slider = false;
        @endphp
        @endif
        @php
        if(isset($data['post_column']) && $data['post_column'] == 'col-4')
        {
            $col = 'col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12';
            $col_4_slider = true;
        }
        else if(isset($data['post_column']) && $data['post_column'] == 'col-6')
        {
            $col_6_slider = true;
            $col = 'col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12';
        }
        else if(isset($data['post_column']) && $data['post_column'] == 'col-12')
        {
            $col_12_slider = true;
            $col = 'col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12';
        }else
        {
            $col = 'col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12';
        }
        @endphp
        <div class="post">
            <div class="post-main">
                <div class="{{ isset($slider) && $slider == false ? '' : 'dynamic-post-carousel'}} owl-loaded row" id="">
                    @foreach($data['articles'] as $item)
                    <div class="post-item {{ isset($slider) && $slider == false ? $col : 'col-12'}}">
                        <a href="{{route('front.single_blog_detail',[$item->slug])}}">
                        <div class="post-img">
                            @if(isset($item->image) && $item->image != null)
                                @php
                                    $img = App\Models\MediaImage::select('name')->where('id', $item->image)->first();
                                @endphp
                            <img src="{{ asset('uploads/'.$img->name) }}" class="img-fluid" alt="{{ $item->title }}">
                            @else
                                <img src="{{ asset('assets/src/images/blog-01.webp') }}" class="img-fluid" alt="{{ $item->title }}">
                            @endif
                        </div>
                    </a>
                        <div class="post-content">
                            <a href="{{route('front.single_blog_detail',[$item->slug])}}">
                            <h3 class="post-heading1">{{ isset($item->title) ? $item->title : '' }}</h3>
                        </a>
                            <p>{{ isset($item->short_description) ? $item->short_description : '' }}</p>
                            <ul>
                                <li>BY {{ isset($item->author_name->name) ? $item->author_name->name : 'Randy Stratton' }}</li>
                                <li>IN {{ isset($item->categories) ? $item->categories : '' }}</li>
                            </ul>
                        </div>
                        <a href="{{route('front.single_blog_detail',[$item->slug])}}" class="common-btn">READ MORE</a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@section('script')
@parent
@if(isset($col_4_slider) && $col_4_slider == true)
<script>
    $(document).ready(function () {
    $('.dynamic-post-carousel').owlCarousel({
        loop: true,
        margin: 15,
        nav: true,
        dot: false,
        autoplay: false,
        slideTransition: 'linear',
        autoplayTimeout: 0,
        autoplaySpeed: 30000,
        autoplayHoverPause: true,
        mouseDrag: false,
        navText: ['<i class="fa fa-long-arrow-left"></i>', '<i class="fa fa-long-arrow-right"></i>'],
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 3
            },
            1000: {
                items: 3
            }
         }
        });
    });
</script>
@endif
@if(isset($col_6_slider) && $col_6_slider == true)
<script>
    $(document).ready(function () {
    $('.dynamic-post-carousel').owlCarousel({
        loop: true,
        margin: 15,
        nav: true,
        dot: false,
        autoplay: false,
        slideTransition: 'linear',
        autoplayTimeout: 0,
        autoplaySpeed: 30000,
        autoplayHoverPause: true,
        mouseDrag: false,
        navText: ['<i class="fa fa-long-arrow-left"></i>', '<i class="fa fa-long-arrow-right"></i>'],
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 2
            },
            1000: {
                items: 2
            }
         }
        });
    });
</script>
@endif
@if(isset($col_12_slider) && $col_12_slider == true)
<script>
    $(document).ready(function () {
    $('.dynamic-post-carousel').owlCarousel({
        loop: true,
        margin: 15,
        nav: true,
        dot: false,
        autoplay: false,
        slideTransition: 'linear',
        autoplayTimeout: 0,
        autoplaySpeed: 30000,
        autoplayHoverPause: true,
        mouseDrag: false,
        navText: ['<i class="fa fa-long-arrow-left"></i>', '<i class="fa fa-long-arrow-right"></i>'],
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 1
            },
            1000: {
                items: 1
            }
         }
        });
    });
</script>
@endif
@endsection