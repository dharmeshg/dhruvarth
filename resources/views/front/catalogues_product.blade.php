@extends('front.layout.index')
@if(isset($SEOSchemaCode))
@section('seoSchemaContent')
    <script type='application/ld+json'>{!! $SEOSchemaCode !!}</script>
@endsection
@endif
@section('main_content')
<div class="margin-top-head @if($display_pg == 1) header-note @endif"></div>
<section class="inner-banner-section">
	<input type="hidden" id="closePath" value="{{asset('front/src/images/close-icon.svg')}}">
	<input type ="hidden" value="{{isset($catalogues->slug) ? $catalogues->slug : ''}}" id="cat_slug">
	<input type="hidden" value="0" id="cat_count">
	@php
		$current_url = url()->current();
		$matching_banner = null;
	@endphp
	@if(isset($page_banners) && count($page_banners) > 0)
		@foreach($page_banners as $banner)
		@php
			$all_urls = explode(',',$banner->url);
			if (in_array($current_url, $all_urls))
			{
				$matching_banner = $banner;
                break;
			}
		@endphp
		@endforeach
	@endif
	@if(isset($matching_banner) && $matching_banner != '' && $matching_banner != null)
        <img src="{{ asset('uploads/media/'.$matching_banner->cover_image) }}" alt="Catalogues Banner" width="100%" height="auto">
    @else
        <img src="{{asset('front/src/images/inner-banner-all-product.jpg')}}" alt="Catalogues Banner" width="100%" height="auto">
    @endif
    <div class="banner-content">
        <div class="container-md">
            <div class="row">
                <div class="col-12">
                	<h1>{{isset($catalogues->name) ? $catalogues->name : ''}}</h1>
                </div>
            </div>
        </div>
   </div>
</section>
<section class="common-section all-product-list-section">
    <div class="container-md">
        <div class="row align-items-center">
            <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12 left-side">
                <span class="d-flex page-nav-text">
                    <a href="{{route('home')}}" aria-label="home icon"><img src="{{asset('front/src/images/home-icon.svg')}}" alt="Home" width="auto" height="auto"></a> <span class="dash-line">/</span>
                    <a href="{{route('front.catalogue')}}" aria-label="home icon">Catalogues</a> <span class="dash-line">/</span>
                    {{isset($catalogues->name) ? $catalogues->name : ''}}
					
                </span>

            </div>
        </div>
    </div>
</section>

<section class="common-section product-box-section-all-product-page" id="main_product_list">
	    <div class="container-md">

	    	<div class="row justify-content-center p-3" id="product_not_found"
			style="display: none">
				<div class="col-md-12 text-center rounded mt-sm-2">

					<center class="index-PageNotFoundContainer">
						<div>
							<p class="index-infoBig"> More items coming soon! </p>
						</div>
					</center>
				</div>                        
			</div>

	        <div class="row product-box-section all-cat-products" id="product_list">
	        	{{-- @include('front.include.ajax-product-page') --}}
	        </div>
	    </div>
	</section>
		@endsection
		@section('script')
		<script>
			var ajaxInProgress = false;
			function load_catalogues(start)
			{
				var cat_slug = $('#cat_slug').val();
					if (ajaxInProgress) {
	            return;
	        }
		        ajaxInProgress = true;
		       $.ajax({
		           url: '{{route('front.filter.catalogue')}}',
		           type: "POST",
		           data: {
		                  start: start,
		                  cat_slug: cat_slug,
		                 _token: $('meta[name="csrf-token"]').attr('content'),
		           },
		           dataType: 'json',
		           success: function(result) {
		               if(result.status == 1 && result.html != '')
		               {
		                    $('#loading-image').hide();
		                   $('#product_list').append(result.html);
		                   var product_count = $('#cat_count').val();
		                    var p_count = parseInt(result.p_count) + parseInt(product_count);
		                    $('#cat_count').val(p_count);
		                   if (result.p_count > 0) {
		                    $(window).bind('scroll', onScroll);
		                   }else if (result.p_count == 0) {
		                    $(window).unbind('scroll');
		                   }
		                   $('#total-result').text(p_count + ' Results');
		                   
		               }

		               if(result.p_count == 0 && start == 0)
		               {
		                $('#product_not_found').show();
		               }else{
		                $('#product_not_found').hide();
		               }
		               ajaxInProgress = false;
		               $('#loading-image').hide();
		           }
		       });
			}
			$(document).ready(function() {

				load_catalogues(0);
			});
			 var scroll_param = 650;
			    if ($(window).width() >= 1200) {
			        scroll_param = 450;
			    } else if ($(window).width() >= 992) {
			        scroll_param = 650;
			    } else if ($(window).width() >= 768) {
			        scroll_param = 650;
			    } else if ($(window).width() >= 576) {
			        scroll_param = 650;
			    } else if ($(window).width() < 576) {
			        scroll_param = 650;
			    }
			function onScroll() {
	        if ($(window).scrollTop() + $(window).height() >= $(document).height() - scroll_param) {
	            $(window).unbind('scroll');
	            var start = $('#cat_count').val();
	            load_catalogues(start);
	            // currentPage++;
	        }
	    }
    $(window).scroll(onScroll);
		</script>
		@endsection
