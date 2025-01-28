
@php
        $add_poster = App\Models\MediaSection::where('id', $section->section_id)->first();
        $add_poster_image = App\Models\AdsPoster::where('type', $add_poster->slug)->where('status', 1)->latest()->get();
@endphp

@if(isset($add_poster_image) && $add_poster_image->isNotEmpty())
        <section class="common-padding common-section color-stone-jewelry-section only-images-section">
            <div class="container-md">
                <div class="row">
                    @if($section->checked_title == 1)
                        <div class="col-xxl-12">
                                <h2>{{$section->title}}</h4>
                        </div>
                    @endif
                    @foreach($add_poster_image as $key => $add_poster_image_value)
                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 images-col-section">
                        <a href="" aria-label="COLOR-STONE JEWELRY">
                        @if(isset($add_poster_image_value->destination_link) && $add_poster_image_value->destination_link != '')
                            <a href="{{$add_poster_image_value->destination_link}}" aria-label="">
                        @endif
                            <img src="{{ asset('uploads/media/'. $add_poster_image_value->cover_image) }}" width="600" height="400"
                                alt="COLOR-STONE JEWELRY Image" class="img-fluid" loading="lazy">
                        @if(isset($add_poster_image_value->destination_link) && $add_poster_image_value->destination_link != '')
                            </a>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
@endif

