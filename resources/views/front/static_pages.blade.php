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
                    <a aria-label="home icon">{{$title}}</a>
                </span>
            </div>
        </div>
    </div>
</section>

@if(isset($faqs) && count($faqs) > 0)

<section class="faq-section static-page-sec common-padding padding-pages">
	<div class="container">
		<div class="c-title">
			<h1>FAQs</h1>
		</div>
		<!-- <ul class="accordion">
			@foreach($faqs as $faq)
			<li class="border-color">
				<a class="toggle" href="#">{{$faq->title}}</a>
				<p class="inner">
					{{$faq->description}}
				</p>
			</li>
			@endforeach
		</ul> -->




<div id="accordion">

  @foreach($faqs as $kys=>$faq)
  <div class="card">
    <div class="card-header">
      <a class="btn" data-bs-toggle="collapse" href="#accr{{$kys}}">{{$faq->title}}</a>
    </div>
    <div id="accr{{$kys}}" class="collapse" data-bs-parent="#accordion">
      <div class="card-body">
        {{$faq->description}}
      </div>
    </div>
  </div>
  @endforeach

</div>


</div>
</section>
@else

<section class="static-page-sec static-page-sec common-padding padding-pages">
	<div class="container">
    	<div class="row">
			<div class="col-12">
				<div class="row">
					<div class="container">
            			<div class="text-uppercase justify-content-center text-center">
                			<h1 class="title-new">{{$title}}</h1>
            			</div>
			        </div>
			    </div>
			</div>
		</div>
	</div>

<div class="container-md content-section" >
	<div class="row">
		<div class="col-12">
			<div class="row">
				<div class="container">
					{!! $terms_condition->content !!}
				</div>
			</div>
		</div>
	</div>
</div>
</section>
@endif
@endsection
@section('script')
<script>
	$(document).ready(function() {
            // Add minus icon for collapse element which is open by default
            $(".collapse.show").each(function() {
            	$(this).prev(".card-header").find(".fa").addClass("fa-minus").removeClass("fa-plus");
            });

            // Toggle plus minus icon on show hide of collapse element
            $(".collapse").on('show.bs.collapse', function() {
            	$(this).prev(".card-header").find(".fa").removeClass("fa-plus").addClass("fa-minus");
            }).on('hide.bs.collapse', function() {
            	$(this).prev(".card-header").find(".fa").removeClass("fa-minus").addClass("fa-plus");
            });
        });
    </script>
    @endsection