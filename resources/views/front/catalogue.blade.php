@extends('front.layout.index')
@if(isset($SEOSchemaCode))
@section('seoSchemaContent')
    <script type='application/ld+json'>{!! $SEOSchemaCode !!}</script>
@endsection
@endif
@section('main_content')

<div class="margin-top-head @if($display_pg == 1) header-note @endif"></div>
<section class="inner-banner-section">
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
		<img src="{{ asset('uploads/media/'.$matching_banner->cover_image) }}" class="page_large_banner" alt="Catalogues Banner" width="100%" height="auto">

		@if(isset($matching_banner->medium_image))
			<img src="{{ asset('uploads/media/'.$matching_banner->medium_image) }}" class="page_med_banner" alt="Catalogues Banner" width="100%" height="auto">
		@else
			<img src="{{ asset('uploads/media/'.$matching_banner->cover_image) }}" class="page_med_banner" alt="Catalogues Banner" width="100%" height="auto">
		@endif

		@if(isset($matching_banner->small_image))
			<img src="{{ asset('uploads/media/'.$matching_banner->small_image) }}" class="page_small_banner" alt="Catalogues Banner" width="100%" height="auto">
		@else
			<img src="{{ asset('uploads/media/'.$matching_banner->cover_image) }}" class="page_small_banner" alt="Catalogues Banner" width="100%" height="auto">
		@endif

	@else
		<img src="{{asset('front/src/images/inner-banner-all-product.jpg')}}" alt="Catalogues Banner" width="100%" height="auto">
	@endif
    <div class="banner-content">
        <div class="container-md">
            <div class="row">
                <div class="col-12">
                    <h1>Catalogues</h1>
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
                    <a aria-label="home icon">Catalogues</a>
                </span>

            </div>
            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 right-side">
                <div class="search_all_prodcut">
                	<div class="filter-chip">
						<span class="clear-filter" style="display:none">Clear Filter x</span>
					</div>
                    <form>
                    	<article>
		                        <input type="text" placeholder="Search here" name="searchallprodcut" id="search_all_prodcut" value="">
        		                <button type="button" id="search_id"><img src="{{asset('front/src/images/header-search.svg')}}" alt="Search" height="22" width="22" class="img-fluid"></button>
		                </article>
		            </form>
                    
                </div>
            </div>
           
        </div>
    </div>
</section>
<section class="common-padding common-section catalogues-section product-box-section catalogues-page-product">
    <div class="container-md" id="all_catalogues">

        <div class="row" id="catalogue_list">
        	@if(isset($catalogues) && count($catalogues) > 0)
				@foreach($catalogues as $catalogue)

					@php
					if($catalogue->cover_image && $catalogue->cover_image != '' && $catalogue->cover_image != null)
					{
						$path = asset('uploads/catalogue/'.$catalogue->cover_image);
					}else{
						$path = asset('assets/images/user/img-demo_1041.jpg');
					}
					@endphp
                    <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-4 col-sm-12 col-12 cols-cat" data-item="{{ isset($catalogue->name) ? $catalogue->name : '' }}">
                        <article>
                            <div class="product-images">
                                <div class="new-collections-tagline number-text">
                                	@if(isset($catalogue->product_id) && $catalogue->product_id != '')
							        @php
							            $catalogs_pro_count = explode(",", $catalogue->product_id);
							            $filtered_count = count(array_filter($catalogs_pro_count));
							            $pro_counts = App\Models\Product::whereIn('id',$catalogs_pro_count)->where('visiblity',1)->count();
							        @endphp
							        {{ $pro_counts }} PRODUCTS
							    	@endif
                                </div>
                                <a href="{{route('catalogue.product', ['id' => $catalogue->slug])}}" aria-label="Product Image">
                                    <img src="{{ $path }}" class="img-fluid" loading="lazy" width="auto"
                                        height="auto" alt="Product Image">
                                </a>
                            </div>
                            <div class="product-details-section">
                                <div class="inner-section">
                                    <a href="{{route('catalogue.product', ['id' => $catalogue->slug])}}" aria-label="Product Namr">
                                        <h3>{{ isset($catalogue->name) ? Str::limit($catalogue->name, 50) : '' }}</h3>
                                    </a>

                                    <a onclick="share_model('{{$catalogue->id}}','catalogs')" aria-label="Add To Card" class="add-to-cart">
                                        <span class="add-to-cart-span">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="20"
                                                viewBox="0 0 18 20" fill="none">
                                                <path
                                                    d="M14.4176 12.9032C13.3312 12.9032 12.3915 13.3724 11.7455 14.1349L6.75367 11.5543C6.98858 11.085 7.10604 10.5572 7.10604 10C7.10604 9.44282 6.95922 8.91496 6.75367 8.44575L11.7455 5.8651C12.3915 6.62757 13.3605 7.09678 14.4176 7.09678C16.3556 7.09678 17.9706 5.5132 17.9706 3.54839C17.9706 1.6129 16.385 0 14.4176 0C12.4502 0 10.8646 1.67155 10.8646 3.60704C10.8646 4.07625 10.9527 4.4868 11.0995 4.89736L6.01958 7.50733C5.37357 6.86217 4.49266 6.48094 3.52365 6.48094C1.61501 6.48094 0 8.09384 0 10.0293C0 11.9648 1.58564 13.5777 3.55302 13.5777C4.52202 13.5777 5.40294 13.1965 6.04894 12.5513L11.1289 15.1613C10.9821 15.5718 10.894 15.9824 10.894 16.4516C10.894 18.3871 12.4796 20 14.447 20C16.4144 20 18 18.4164 18 16.4516C18 14.4868 16.3556 12.9032 14.4176 12.9032ZM14.4176 1.261C15.7096 1.261 16.7961 2.31672 16.7961 3.63636C16.7961 4.92669 15.739 6.01173 14.4176 6.01173C13.0962 6.01173 12.0392 4.92669 12.0392 3.60704C12.0392 2.31672 13.0962 1.261 14.4176 1.261ZM3.55302 12.4047C2.26101 12.4047 1.17455 11.349 1.17455 10.0293C1.17455 8.739 2.23165 7.65396 3.55302 7.65396C4.84502 7.65396 5.93148 8.70968 5.93148 10.0293C5.93148 11.3196 4.84502 12.4047 3.55302 12.4047ZM14.4176 18.7977C13.1256 18.7977 12.0392 17.7419 12.0392 16.4223C12.0392 15.1026 13.0962 14.0469 14.4176 14.0469C15.739 14.0469 16.7961 15.1026 16.7961 16.4223C16.7961 17.7419 15.7096 18.7977 14.4176 18.7977Z"
                                                    fill="var(--theme-color)" />
                                            </svg>
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </article>
                    </div>
            	@endforeach
			@endif
        </div>
    </div>
</section>
@endsection
		
@section('script')
	<script type="text/javascript">
		$('#search_id').click(function(){
		    $('.cols-cat').hide();
		    $('.clear-filter').show();
		   var txt = $('#search_all_prodcut').val();
		   $('.cols-cat:contains("'+txt+'")').show();

		   var inputValue = $('#search_all_prodcut').val();

   
	        $("#catalogue_list").addClass("inactive");
	        $(".cols-cat").hide();

	        $("#catalogue_list").each(function(){
	            $(".cols-cat").each(function(){
	                var item = $(this).attr("data-item");

	                if(item.toUpperCase().indexOf(inputValue.toUpperCase()) != -1){
	                    $(this).parents("#catalogue_list").removeClass("inactive");
	                    $(this).show();
	                }
	            });
	        });

		});
		$(document).on('click', '.clear-filter', function() {
			$('#search_all_prodcut').val('');
			$('.clear-filter').hide();
			$('#all_catalogues').load(' #catalogue_list');
		});
	</script>
@endsection
