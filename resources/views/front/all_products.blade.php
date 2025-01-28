@extends('front.layout.index')
@if(isset($SEOSchemaCode))
@section('seoSchemaContent')
    <script type='application/ld+json'>{!! $SEOSchemaCode !!}</script>
@endsection
@endif
@section('main_content')

<style>
	.clear-filter {
    display: none
}

.chip-single {
    display: inline-block;
    padding: 3px 13px;
    border-radius: 15px;
    margin: 8px 8px 0 0;
    background:#f5f3f3;
}

.close-chip {
    display: inline-block;
    width: 14px;
    height: 14px;
    border-radius: 50%;
    margin-left: 14px;
    position: relative;
    top: -2px;
    text-align: center;
    line-height: 11px;
    cursor: pointer;
    background: var(--theme-color);
}

.close-chip img {
    filter: brightness(0) invert(1);
    width: 8px;
    height: 8px;
    margin-top: 3px;
}

.clear-filter {
    text-decoration: underline;
    cursor: pointer;
    transition: ease-in-out .3s
}

.filter-dropdown-single {
    position: relative;
    margin-bottom: 10px
}

.filter-dropdown {
    position: absolute;
    top: 37px;
    min-width: 165px;
    text-align: left;
    box-shadow: 0 0 4.84px 1px rgba(0,0,0,.1);
    z-index: 9;
    display: none;
    background:white;
}

.filter-dropdown li {
    padding: 6px 15px;
    transition: ease-in-out .4s;
    cursor: pointer
}

.popular-bar-main {
    display: flex;
    justify-content: space-between;
    align-items: center
}

.popular-bar-left {
    display: flex;
    flex-wrap: wrap;
    flex: 1;
    justify-content: flex-start
}

.filter-dropdown-single:not(:last-child) {
    margin-right: 22px
}

.filter-dropdown-single label {
    padding-right: 20px;
    background: url("{{asset('front/src/images/down-arrow.svg')}}") right center no-repeat;
    cursor: pointer
}

.filterd-chip-result {
    display: flex;
    justify-content: space-between;
    margin-top: 8px
}

.filter-chip {
    display: flex;
    flex: 1;
    margin-right: 10px;
    align-items: center;
    flex-wrap: wrap
}

.clear-filter {
    order: 2;
    margin: 8px 0 0 4px
}

#product_not_found{
	min-height: 160px;
    margin-top: 100px;
}

</style>

<div class="margin-top-head @if($display_pg == 1) header-note @endif"></div>
<section class="inner-banner-section">
	<input type="hidden" id="closePath" value="{{asset('front/src/images/close-icon.svg')}}">
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
                	@php
						$random_p = App\Models\Product::where('visiblity',1)->inRandomOrder()->first();
					@endphp
					@if(isset($tag) && $tag != '' && $tag != null)
						<h1>{{ $tag->name }}</h1>
					@else
						<h1>All Products</h1>
					@endif
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
                    @if(isset($tag) && $tag != '' && $tag != null)
                    	<a aria-label="home icon">{{ $tag->name }}</a>
                    @else
						<a aria-label="home icon">All Products</a>
					@endif
                </span>

            </div>
        </div>
    </div>
</section>

	<input type="hidden" value="{{ isset($category->id) ? $category->id : '' }}" id="single_cat">
	<input type="hidden" value="{{ isset($family->id) ? $family->id : '' }}" id="single_fam">
	<input type="hidden" value="{{ isset($purity->id) ? $purity->id : '' }}" id="single_purity">
	<input type="hidden" value="{{ isset($gender) ? $gender : '' }}" id="single_gender">
	<input type="hidden" value="{{ isset($tag->name) ? $tag->name : '' }}" id="single_tag">
	<section class="new-arrival-list">
		<div class="container-md">
			@if(isset($tag) && $tag != '' && $tag != null)
			@else
			<div class="border-color new-arrival-search all-product-list-section">
				<div class="popular-bar-main">
					<div class="popular-bar-left">
						<div class="filter-dropdown-single">
							<label>Category</label>
							<ul class="filter-dropdown">
								@if(isset($catagories) && count($catagories) > 0)
								@foreach($catagories as $cat)
								@php
									$product_check = $cat->products()->count();
								@endphp
								@if(isset($product_check) && $product_check > 0)
								<li class="product_category_li {{isset($category->id) && $category->id == $cat->id ? 'active' : '' }}" data-id="{{ isset($cat->id) ? $cat->id : '' }}">{{ isset($cat->category) ? $cat->category : '' }}</li>
								@endif
								@endforeach
								@endif
							</ul>
						</div>
						<div class="filter-dropdown-single">
							<label>Product</label>
							<ul class="filter-dropdown" id="family_list_ul">
								
							</ul>
						</div>
						<div class="filter-dropdown-single">
							<label>Gender</label>
							<ul class="filter-dropdown">
                                @if(isset($genders) && count($genders) > 0)
                                @foreach($genders as $db_gender)
								@php
                                    $gender_count = App\Models\Product::where('p_gender',$db_gender->title)->count();
								@endphp
								@if($gender_count > 0)
								<li class="all_gender_li {{ isset($gender) && $gender == $db_gender->title ? 'active' : '' }}" data-id = "{{ $db_gender->title }}">{{ $db_gender->title }}</li>
								@endif
                                @endforeach
                                @endif
							</ul>
						</div>
						<div class="filter-dropdown-single">
							<label>Purity</label>
							<ul class="filter-dropdown custom-purity-dropdown">
								@if(isset($purities) && count($purities) > 0)
								@foreach($purities as $pur)
								@php
									$p_count = App\Models\Product::where('p_metal_purity',$pur->id)->count();
								@endphp
								@if($p_count > 0)
								<li class="all_carat_li {{isset($purity->id) && $purity->id == $pur->id ? 'active' : '' }}" data-id = "{{ isset($pur->id) ? $pur->id : '' }}">{{ isset($pur->title) ? $pur->title : '' }}</li>
								@endif
								@endforeach
								@endif
							</ul>
						</div>
						<div class="filter-dropdown-single">
							<label>Status</label>
							<ul class="filter-dropdown">
								<li class="all_status_li " data-id = "by_order">By Order</li>
								<li class="all_status_li " data-id = "ready_stock">Ready Stock</li>
							</ul>
						</div>					</div>
					
					<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 right-side">
	                    <span>
	                        <a onclick="share_model('{{isset($random_p->id) ? $random_p->id : 5 }}','product-page')">
		                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="20" viewBox="0 0 18 20" fill="none">
		                                <path d="M14.4176 12.9032C13.3312 12.9032 12.3915 13.3724 11.7455 14.1349L6.75367 11.5543C6.98858 11.085 7.10604 10.5572 7.10604 10C7.10604 9.44282 6.95922 8.91496 6.75367 8.44575L11.7455 5.8651C12.3915 6.62757 13.3605 7.09678 14.4176 7.09678C16.3556 7.09678 17.9706 5.5132 17.9706 3.54839C17.9706 1.6129 16.385 0 14.4176 0C12.4502 0 10.8646 1.67155 10.8646 3.60704C10.8646 4.07625 10.9527 4.4868 11.0995 4.89736L6.01958 7.50733C5.37357 6.86217 4.49266 6.48094 3.52365 6.48094C1.61501 6.48094 0 8.09384 0 10.0293C0 11.9648 1.58564 13.5777 3.55302 13.5777C4.52202 13.5777 5.40294 13.1965 6.04894 12.5513L11.1289 15.1613C10.9821 15.5718 10.894 15.9824 10.894 16.4516C10.894 18.3871 12.4796 20 14.447 20C16.4144 20 18 18.4164 18 16.4516C18 14.4868 16.3556 12.9032 14.4176 12.9032ZM14.4176 1.261C15.7096 1.261 16.7961 2.31672 16.7961 3.63636C16.7961 4.92669 15.739 6.01173 14.4176 6.01173C13.0962 6.01173 12.0392 4.92669 12.0392 3.60704C12.0392 2.31672 13.0962 1.261 14.4176 1.261ZM3.55302 12.4047C2.26101 12.4047 1.17455 11.349 1.17455 10.0293C1.17455 8.739 2.23165 7.65396 3.55302 7.65396C4.84502 7.65396 5.93148 8.70968 5.93148 10.0293C5.93148 11.3196 4.84502 12.4047 3.55302 12.4047ZM14.4176 18.7977C13.1256 18.7977 12.0392 17.7419 12.0392 16.4223C12.0392 15.1026 13.0962 14.0469 14.4176 14.0469C15.739 14.0469 16.7961 15.1026 16.7961 16.4223C16.7961 17.7419 15.7096 18.7977 14.4176 18.7977Z" fill="var(--theme-color)" />
		                            </svg>
		                    </a>
	                    </span>

	                    <div class="search_all_prodcut">
                                <article>
                                    <input type="text" placeholder="Search here" name="searchKeyword" id="searchKeyword" value="{{isset($search_value) ? $search_value : ''}}">
                                    <input type="hidden"  value="{{isset($search_value_on) ? $search_value_on : ''}}" id="search_value_on" name="search_value_on">
                                    <button type="button" id="search_pro"><img src="{{ asset('front/src/images/header-search.svg') }}" alt="Search" height="22" width="22" class="img-fluid"></button>
                                </article>
	                        </div>
                    	</div>
					</div>

					@if(isset($tag) && $tag != '' && $tag != null)
					@else
						<div class="filterd-chip-result">
							<div class="filter-chip">
								<span class="clear-filter">Clear All Filter</span>
							</div>
							<!-- <span class="total-result" id="total-result">
								{{ isset($products) ? count($products) : 0 }}  Results
							</span> -->
						</div>
					@endif
				</div>
			</div>
			@endif
			
			<input type="hidden" value="0" id="product_count">
			
		<!--Single Product Start-->
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

	        <div class="row product-box-section" id="product_list">
	        	{{-- @include('front.include.ajax-product-page') --}}
	        </div>

	        <div class="product_load" id="loading-image">
	        	<img src="{{ asset('front/src/images/black-spinner.svg') }}">
	        </div>
	        
	    </div>
	</section>
@endsection
@section('script')
<script>
	$(document).ready(function(){
    var cat_id = $('#single_cat').val();
    var value = $('.filter-dropdown li.product_category_li.active').text();
    var setValueCategory = value;
    if(setValueCategory != null && setValueCategory != ''){
        $(this).siblings('li').removeClass('active');
        $(this).addClass('active');
        $(".filter-dropdown").slideUp().removeClass('active');
        $('.filter-chip').append("<span class='chip-single common_selector product_category gemstone' data-id="+ cat_id +">"+setValueCategory+"<span class='close-chip'><img src= " + closePath + "></span></span>");
        if($('.chip-single').length > 1){
            $(".clear-filter").show();
        }
    }

	var search_value_on = $('#search_value_on').val();
	if(search_value_on == 1){
        setTimeout(function() {
            $("#search_pro").trigger("click");
        }, 300);

	}
 	var fam_id = $('#single_fam').val();
    setTimeout(function () {
        // alert();
    	var value = $('.filter-dropdown li.product_family_li.active').text();
    	var setValueProductFamily = value;
    	if(setValueProductFamily != null && setValueProductFamily != ''){

        	$(this).siblings('li').removeClass('active');
        	$(this).addClass('active');
        	$(".filter-dropdown").slideUp().removeClass('active');
        	$('.filter-chip').append("<span class='chip-single common_selector product_family cut' data-id="+ fam_id +">"+setValueProductFamily+"<span class='close-chip'><img src= " + closePath + "></span></span>");
        	if($('.chip-single').length > 1){
            	$(".clear-filter").show();
        	}
    	}
	}, 500);

	var gender = $('#single_gender').val();
    var value = $('.filter-dropdown li.all_gender_li.active').text();
    var setValueGender = value;
    if(setValueGender != null && setValueGender != ''){
        $(this).siblings('li').removeClass('active');
        $(this).addClass('active');
        $(".filter-dropdown").slideUp().removeClass('active');
        $('.filter-chip').append("<span class='chip-single common_selector all_gender composition' data-id="+ gender +">"+setValueGender+"<span class='close-chip'><img src= " + closePath + "></span></span>");
        if($('.chip-single').length > 1){
            $(".clear-filter").show();
        }
    }

    var purity_id = $('#single_purity').val();
    var value = $('.filter-dropdown li.all_carat_li.active').text();
    var setValuePurity = value;
    if(setValuePurity != null && setValuePurity != ''){
        $(this).siblings('li').removeClass('active');
        $(this).addClass('active');
        $(".filter-dropdown").slideUp().removeClass('active');
        $('.filter-chip').append("<span class='chip-single common_selector all_carat color' data-id="+ purity_id +">"+setValuePurity+"<span class='close-chip'><img src= " + closePath + "></span></span>");
        if($('.chip-single').length > 1){
            $(".clear-filter").show();
        }
    }

    var value = $('.filter-dropdown li.all_status_li.active').text();
    var setValueStatus = value;
    if(setValueStatus != null && setValueStatus != ''){
        $(this).siblings('li').removeClass('active');
        $(this).addClass('active');
        $(".filter-dropdown").slideUp().removeClass('active');
        $('.filter-chip').append("<span class='chip-single common_selector all_status_li shape'>"+setValueStatus+"<span class='close-chip'><img src= " + closePath + "></span></span>");
        if($('.chip-single').length > 1){
            $(".clear-filter").show();
        }
    }

});
$(".filter-dropdown-single label").click(function () {
    $(".filter-dropdown").slideUp();
    if(!$(this).siblings(".filter-dropdown").hasClass('active')){
        $(this).siblings(".filter-dropdown").slideDown().addClass('active');
    }else{
        $(this).siblings(".filter-dropdown").slideUp().removeClass('active');
        $(".filter-dropdown").slideUp().removeClass('active');
    }
});
var closePath = $("#closePath").val();
$(document).ready(function(){
    var cat_id = '';
    var cats = [];
    var fams = [];
    var genders = [];
    var carates = [];
    var status = [];
    // var start = $('#product_count').val();
    var cat_id = $('#single_cat').val();
    var fam_id = $('#single_fam').val();
    var gender = $('#single_gender').val();
    var purity_id = $('#single_purity').val();
    var searchtext = $('#searchKeyword').val();
    var tag_key = $('#single_tag').val();

    if(cat_id && cat_id != '' && cat_id != null)
    {
        cats.push(cat_id);
    }
    if(fam_id && fam_id != '' && fam_id != null)
    {
        fams.push(fam_id);
    }
    if(gender && gender != '' && gender != null)
    {
        genders.push(gender);
    }
    if(purity_id && purity_id != '' && purity_id != null)
    {
        carates.push(purity_id);
    }
    var ajaxInProgress = false;
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
    function filter_data(cat_id,cats,fams,genders,carates,status,searchtext,tag_key)
    {
        // alert('in');
        $('#loading-image').show();
        var start = $('#product_count').val();
        if (ajaxInProgress) {
            return; // If an AJAX request is already in progress, do nothing
        }
        ajaxInProgress = true;
       $.ajax({
           url: BASE_URL +"filter-product",
           type: "POST",
           data: {
                   start: start,
                   cat_id: cat_id,
                   cats: cats,
                   fams: fams,
                   genders: genders,
                   carates: carates,
                   status: status,
                   searchtext: searchtext,
                   tag_key: tag_key,
                 _token: $('meta[name="csrf-token"]').attr('content'),
           },
           dataType: 'json',
           success: function(result) {
               if(result.status == 1 && result.html != '')
               {
                    $('#loading-image').hide();
                   $('#product_list').append(result.html);
                   var product_count = $('#product_count').val();
                    var p_count = parseInt(result.p_count) + parseInt(product_count);
                    $('#product_count').val(p_count);
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
               if(result.families.length > 0)
               {
                   $('#family_list_ul').html('');
                   var existing_fam_id = $('#single_fam').val();
                   $.each(result.families, function(key, value) {
                    var checked = '';
                    if(existing_fam_id == value.id)
                    {
                        var checked = 'active';
                    }else{
                        var checked = '';
                    }
                    $('#family_list_ul').append('<li class="product_family_li '+ checked +'" data-id="'+ value.id +'">'+ value.family +'</li>')
                   });
               }
               ajaxInProgress = false;
               $('#loading-image').hide();
           }
       });
    }
    function onScroll() {
        if ($(window).scrollTop() + $(window).height() >= $(document).height() - scroll_param) {
            $(window).unbind('scroll');
            var searchtext = $('#searchKeyword').val();
            var tag_key = $('#single_tag').val();
            filter_data(cat_id,cats,fams,genders,carates,status,searchtext,tag_key);
            // currentPage++;
        }
    }
    $(window).scroll(onScroll);
    filter_data(cat_id,cats,fams,genders,carates,status,searchtext,tag_key);
$(document).on('click', '#search_pro', function(){
    var searchtext = $('#searchKeyword').val();
    if(searchtext && searchtext != '' && searchtext != undefined)
    {
        $('#product_count').val(0);
        $('#product_list').html('');
        filter_data(cat_id,cats,fams,genders,carates,status,searchtext);
        $(".clear-filter").show();
    }
});

$(document).on('click', '#search_pro1', function(){
    var searchtext = $('#searchKeyword1').val();
    // alert(searchtext);
    if(searchtext && searchtext != '' && searchtext != undefined)
    {
        $('#product_count').val(0);
        $('#product_list').html('');
        filter_data(cat_id,cats,fams,genders,carates,status,searchtext);
        $(".clear-filter").show();
    }
});

$(document).on('click', '.filter-dropdown li:not(.active).product_category_li', function(){
    var cat_id = $(this).data('id');
    var catmatchFound = false;
    $('.common_selector.product_category').each( function(){
        if($(this).data('id') == cat_id) {
            catmatchFound = true;
            return false;
        }
    });
    if(!catmatchFound) {
        $(this).siblings('li').removeClass('active');
        $(this).addClass('active');
        $(".filter-dropdown").slideUp().removeClass('active');
        var setValueOfProductCategory = $('.filter-dropdown li.product_category_li.active').text();
        $('.filter-chip').append("<span class='chip-single common_selector product_category gemstone' data-id="+ cat_id +">"+setValueOfProductCategory+"<span class='close-chip'><img src= " + closePath + "></span></span>");
        if($('.chip-single').length > 1){
            $(".clear-filter").show();
        }
        $('.common_selector.product_category').each( function(){
            cats.push($(this).data('id'));
        });
        $('#product_count').val(0);
        $('#product_list').html('');
        filter_data(cat_id,cats,fams);
    }else{
        $(".filter-dropdown").slideUp();
    }
    /*filter_data_count();*/
});
$(document).on('click', '.filter-dropdown li:not(.active).product_family_li', function(){
    var fam_id = $(this).data('id');
    var familymatchFound = false;
    $('.common_selector.product_family').each( function(){
        if($(this).data('id') == fam_id) {
            familymatchFound = true;
            return false;
        }
    });
    if(!familymatchFound) {
        $(this).siblings('li').removeClass('active');
        $(this).addClass('active');
        $(".filter-dropdown").slideUp().removeClass('active');
        var setValueOfProductFamily = $('.filter-dropdown li.product_family_li.active').text();
        $('.filter-chip').append("<span class='chip-single common_selector product_family cut' data-id="+ fam_id +">"+setValueOfProductFamily+"<span class='close-chip'><img src= " + closePath + "></span></span>");
        if($('.chip-single').length > 1){
            $(".clear-filter").show();
        }
        $('.common_selector.product_family').each( function(){
            fams.push($(this).data('id'));
        });
        $('#product_count').val(0);
        $('#product_list').html('');
        filter_data(cat_id,cats,fams);
    }else{
        $(".filter-dropdown").slideUp();
    }
    /*filter_data_count();*/
});
$(document).on('click', '.filter-dropdown li:not(.active).all_gender_li', function(){
    var gen_id = $(this).data('id');
    var gendermatchFound = false;
    $('.common_selector.all_gender').each( function(){
        if($(this).data('id') == gen_id) {
            gendermatchFound = true;
            return false;
        }
    });
    if(!gendermatchFound) {
        $(this).siblings('li').removeClass('active');
        $(this).addClass('active');
        $(".filter-dropdown").slideUp().removeClass('active');
        var setValueOfAllGender = $('.filter-dropdown li.all_gender_li.active').text();
        $('.filter-chip').append("<span class='chip-single common_selector all_gender composition' data-id="+ gen_id +">"+setValueOfAllGender+"<span class='close-chip'><img src= " + closePath + "></span></span>");
        if($('.chip-single').length > 1){
            $(".clear-filter").show();
        }
        $('.common_selector.all_gender').each( function(){
            genders.push($(this).data('id'));
        });
        $('#product_count').val(0);
        $('#product_list').html('');
        filter_data(cat_id,cats,fams,genders);
    }else{
        $(".filter-dropdown").slideUp();
    }
    /*filter_data_count();*/
});
$(document).on('click', '.filter-dropdown li:not(.active).all_carat_li', function(){
    var puri_id = $(this).data('id');
    var purimatchFound = false;
    $('.common_selector.all_carat').each( function(){
        if($(this).data('id') == puri_id) {
            purimatchFound = true;
            return false;
        }
    });
    if(!purimatchFound) {
        $(this).siblings('li').removeClass('active');
        $(this).addClass('active');
        $(".filter-dropdown").slideUp().removeClass('active');
        var setValueOfAllCarat = $('.filter-dropdown li.all_carat_li.active').text();
        $('.filter-chip').append("<span class='chip-single common_selector all_carat color' data-id="+ puri_id +">"+setValueOfAllCarat+"<span class='close-chip'><img src= " + closePath + "></span></span>");
        if($('.chip-single').length > 1){
            $(".clear-filter").show();
        }
        $('.common_selector.all_carat').each( function(){
            carates.push($(this).data('id'));
        });
        $('#product_count').val(0);
        $('#product_list').html('');
        filter_data(cat_id,cats,fams,genders,carates);
    }else{
        $(".filter-dropdown").slideUp();
    }
    /*filter_data_count();*/
});
$(document).on('click', '.filter-dropdown li:not(.active).all_status_li', function(){
    var status_id = $(this).data('id');
    var statusmatchFound = false;
    $('.common_selector.all_status').each( function(){
        if($(this).data('id') == status_id) {
            statusmatchFound = true;
            return false;
        }
    });
    if(!statusmatchFound){
        $(this).siblings('li').removeClass('active');
        $(this).addClass('active');
        $(".filter-dropdown").slideUp().removeClass('active');
        var setValueOfAllStatus = $('.filter-dropdown li.all_status_li.active').text();
        $('.filter-chip').append("<span class='chip-single common_selector all_status shape' data-id="+ status_id +">"+setValueOfAllStatus+"<span class='close-chip'><img src= " + closePath + "></span></span>");
        if($('.chip-single').length > 1){
            $(".clear-filter").show();
        }
        $('.common_selector.all_status').each( function(){
            status.push($(this).data('id'));
        });
        $('#product_count').val(0);
        $('#product_list').html('');
        filter_data(cat_id,cats,fams,genders,carates,status);
    }else{
        $(".filter-dropdown").slideUp();
    }
    /*filter_data_count();*/
});
$(document).on('click', '.close-chip', function() {
    var removedId = $(this).parent('.chip-single').data('id');
    if($(this).parent('.chip-single').text() == $('.filter-dropdown li.active').text()){
        $('.filter-dropdown li').removeClass('active');
    }

    $(this).parent('.chip-single').remove();
    if($('.chip-single').length <= 1){
        $(".clear-filter").hide();
    }
    cats = cats.filter(id => id !== removedId);
    fams = fams.filter(id => id !== removedId);
    genders = genders.filter(id => id !== removedId);
    carates = carates.filter(id => id !== removedId);
    status = status.filter(id => id !== removedId);

    /*filter_data_count();*/
    if($('.chip-single').length == 0){
        $(".clear-filter").hide();
        $('#product_not_found').hide();
        // $('#main_product_list').load(' #product_list');
        $('#total-result').load(' #total-result');
        $('#product_count').val(0);
        $('#product_list').html('');
        cats = [];
        fams = [];
        genders = [];
        carates = [];
        status = [];
        filter_data(cat_id,cats);
    }else{
        $('#product_count').val(0);
        $('#product_list').html('');
        filter_data(cat_id,cats,fams,genders,carates,status);
    }
});
$(document).on('click', '.clear-filter', function() {
    var removedId = $(this).parent('.chip-single').data('id');
    $('.chip-single').remove();
    $('.filter-dropdown li').removeClass('active');
    $(this).hide();
    cats = cats.filter(id => id !== removedId);
    fams = fams.filter(id => id !== removedId);
    genders = genders.filter(id => id !== removedId);
    carates = carates.filter(id => id !== removedId);
    status = status.filter(id => id !== removedId);
    $('#product_count').val(0);
    $('#product_list').html('');
    $('#searchKeyword').val('');
    cats = [];
    fams = [];
    genders = [];
    carates = [];
    status = [];
    filter_data(cat_id,cats);
});
 });
</script>
@endsection
