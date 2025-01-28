@php
        $youtube_video_url = strtok($bs->youtube_video, '&') . "?autoplay=1";
@endphp
@if(isset($youtube_video_url))
<section class="testimonial-and-video-section common-section">
    <div class="container-md">
        <div class="row">
            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">  
                @php
                    $explode = explode('/',$youtube_video_url);
                    $video = end($explode);
                    $url = explode('?', $video);
                    $link = $url[0];
                @endphp
                @if(isset($link) && $link != '')
                    <lite-youtube videoid="{{$link}}" params="controls-1"></lite-youtube>
                @endif         
            </div>
        </div>
    </div>
</section>
@endif