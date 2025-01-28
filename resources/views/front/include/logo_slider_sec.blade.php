@php
        $logo_slider = App\Models\MediaSection::where('id', $section->section_id)->first();
        $logo_slider_image = App\Models\LogoSlider::where('type', $logo_slider->slug)->where('status', 1)->latest()->get();

@endphp

<section class="common-padding common-section product-logo-icon-section">
    <div class="container-md">
        @if($section->checked_title == 1)
            <h2>{{$section->title}}</h2>
        @endif
        <div class="product-logo-icon-carousel owl-loaded">
            @foreach($logo_slider_image as $logo_slider_image_value)
            <div class="gallery-item">
                @if(isset($logo_slider_image_value->link) && $logo_slider_image_value->link != '')
                    <a href="{{$logo_slider_image_value->link}}" aria-label="product logo icon link" class="product-logo-icon-link">
                @endif
                    <img class="img-fluid" loading="lazy" src="{{ asset('uploads/media/'. $logo_slider_image_value->cover_image) }}" width="100" height="100"
                        alt="{{ isset($logo_slider_image_value->name) ? $logo_slider_image_value->name : '' }}" />
                @if(isset($logo_slider_image_value->link) && $logo_slider_image_value->link != '')
                        </a>
                @endif
            </div>
            @endforeach
    
        </div>
    </div>
</section>