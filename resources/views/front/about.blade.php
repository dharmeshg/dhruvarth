@extends('front.layout.index')
@if(isset($SEOSchemaCode))
@section('seoSchemaContent')
    <script type='application/ld+json'>{!! $SEOSchemaCode !!}</script>
@endsection
@endif
@section('main_content')
<div class="margin-top-head @if($display_pg == 1) header-note @endif"></div>
<section class="common-section all-product-list-section">
    <div class="container-md">
        <div class="row align-items-center">
            <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12 left-side">
                <span class="d-flex page-nav-text">
                    <a href="{{route('home')}}" aria-label="home icon"><img src="{{asset('front/src/images/home-icon.svg')}}" alt="Home" width="auto" height="auto"></a> <span class="dash-line">/</span>
                    <a aria-label="home icon">About</a>
                </span>
            </div>
           
        </div>
    </div>
</section>

@php
    $json = json_decode($about->data);
@endphp

@foreach($json as $about)
    <section class="about-us-section">
        <div class="container">
            <div class="row">
                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="full-content">
                        <h1>{{ isset($about->title) ? $about->title : '' }}</h1>
                    </div>
                </div>
            </div>

            <div class="row mga-welcome">
                @if(isset($about->description) && $about->description != '')
                    @if(isset($about->image) && $about->image != '')
                        @if($loop->iteration % 2 == 0)
                            <!-- <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <img src="{{ asset('uploads/images/' . $about->image) }}" class="img-fluid img-view" id="cover-item-img-output">
                            </div> -->
                            <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                <div class="full-content">
                                    <p>{!! $about->description !!}</p>
                                </div>
                            </div>
                        @else
                            <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                <div class="full-content">
                                    <p>{!! $about->description !!}</p>
                                </div>
                            </div>
                            <!-- <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <img src="{{ asset('uploads/images/' . $about->image) }}" class="img-fluid img-view" id="cover-item-img-output">
                            </div> -->
                        @endif
                    @else
                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="full-content">
                                <p>{!! $about->description !!}</p>
                            </div>
                        </div>
                    @endif
                @endif
            </div>
       
            <!-- @if(isset($about->youtube_video) && $about->youtube_video != '')
                <div class="row justify-content-md-center">
                    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="full-content">
                            @php
                                $explode = explode('/',$about->youtube_video);
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
            @endif -->
        </div>
    </section>
@endforeach


<!-- buy WITH CONFIDENCE -->

@include('front.include.confidence')

@endsection
