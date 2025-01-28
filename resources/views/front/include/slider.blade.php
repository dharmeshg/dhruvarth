<!-- Banner Section -->

        <section class="banner-slider-section header-note">
            <div class="banner-carousel">
                @if(isset($slider_banner) && count($slider_banner) > 0)
                    @foreach($slider_banner as $sk => $slider_banner_value)
                        <div class="gallery-item">
                            <a @if(isset($slider_banner_value->destination_link) && $slider_banner_value->destination_link != null) href="{{ $destination = $slider_banner_value->destination_link }}" @endif target="_blank">
                                <img class="desktop-banner" src="{{ asset('uploads/slider_banner/'.$slider_banner_value->large_img) }}" width="auto"height="600px" alt="banner image" @if($sk>0) loading="lazy" @endif/>
                            </a>
                            <a @if(isset($slider_banner_value->destination_link) && $slider_banner_value->destination_link != null) href="{{ $destination = $slider_banner_value->destination_link }}" @endif target="_blank">
                                <img class="tablet-banner" src="{{ asset('uploads/slider_banner/'.$slider_banner_value->medium_img) }}" width="auto" height="400px" @if($sk > 0) loading="lazy" @endif alt="banner image"/>
                            </a>
                            <a @if(isset($slider_banner_value->destination_link) && $slider_banner_value->destination_link != null) href="{{ $destination = $slider_banner_value->destination_link }}" @endif target="_blank">
                                <img class="mobile-banner" src="{{ asset('uploads/slider_banner/'.$slider_banner_value->small_img) }}" width="auto" height="200px" @if($sk > 0) loading="lazy" @endif alt="banner image"/>
                            </a>
                        </div>
                    @endforeach
                @endif
               
            </div>

            <section class="mobile-header-box-sec">
                <div class="container-md">
                    <div class="mobile-header-box-sec-inner">
                        <article>
                            @if(isset($mr) && count($mr) > 0)
                                @foreach($mr as $key => $mr_value)
                                    @php
                                        $purities = App\Models\MetalPurity::where('id',$mr_value->purity)->first();
                                    @endphp
                                    <div class="header-two-block @if($key == 1) second-block @endif">
                                        <div>
                                            <p>{{isset($purities->title) ? $purities->title : ''}} Rate</p>
                                            <p class="price-text"><span class="number-text">₹ {{isset($mr_value->rate) ? number_format($mr_value->rate, 2, '.', ',') : ''}}</span>(per 1gm)</p>
                                        </div>
                                        <div>
                                            <a id="book_a_rate" onclick="book_a_gold_rate('Gold 22K / 916','5,700.00');" aria-level="header Book Rate">
                                                <img src="{{asset('front/src/images/header-wahtsapp-icon.svg') }}" alt="Search" height="20"
                                                    width="20" class="img-fluid" >
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </article>
                    </div>
                </div>
            </section>
        </section>