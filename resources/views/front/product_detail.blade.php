
@extends('front.layout.index')
@if(isset($SEOSchemaCode))
@section('seoSchemaContent')
    <script type='application/ld+json'>{!! $SEOSchemaCode !!}</script>
@endsection
@endif
@section('main_content')
<link rel="stylesheet" href="{{asset('front/src/css/product.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" async="">
<style type="text/css">
	.discount-price{
		text-decoration: line-through;
		margin-right: 10px;
    	font-size: 18px !important;
    	line-height: 24px;
    	color: red;
	}
	.minus, .plus{
		font-size:19px;
	}
</style>

<div class="margin-top-head @if($display_pg == 1) header-note @endif"></div>
<section class="common-section all-product-list-section">
    <div class="container-md">
        <div class="row">
            <div class="col-xxl-8">
                <span class="d-flex page-nav-text">
                    <a href="{{route('home')}}" aria-label="home icon"><img src="{{ asset('front/src/images/home-icon.svg') }}" alt="Home Icon" width="auto" height="auto"></a> <span class="dash-line">/</span>
                    <a href="{{route('front.all.products')}}" aria-label="home icon">All Product</a> <span class="dash-line">/</span>
                    <a href="" aria-label="home icon">{{ isset($product->p_title) ? $product->p_title : '' }}</a>
                </span>
            </div>
        </div>
    </div>
</section>

<section class="common-section single-product-details-section common-padding">
    <div class="container-md">
        <div class="row">
            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 left-side inner-img-div">
				<div class="mobile-product-arrows">
					@if(isset($nextProduct)  && $nextProduct != null)
						<a class="slick-next slick-arrow btn-next"
						href="{{ route('front.detail.products',['slug' => $nextProduct->p_slug]) }}"><i class="fa fa-angle-right" aria-hidden="true"></i></a>
					@endif
					@if(isset($previousProduct)  && $previousProduct != null)
						<a class="slick-prev slick-arrow btn-back"
						href="{{ route('front.detail.products',['slug' => $previousProduct->p_slug]) }}"><i class="fa fa-angle-left" aria-hidden="true"></i></a>
					@endif
				</div>
				<div class="outer">
					<div id="syncbig1" class="sync1 owl-carousel owl-theme">
					@if(isset($product->images) && count($product->images) > 0)
						@foreach($product->images as $key => $img)
						@if($img->type == $product_type)
						<div class="item @if(isset($key) && $key == 0) active @endif">
							@if(isset($product->db_status) && $product->db_status != '' && $product->db_status != null && $product->db_status == 'manually')
							<img src="{{ asset('product_media/product_images/'.$img->name) }}" data-zoom="{{ asset('product_media/product_images/'.$img->name) }}" alt="{{  isset($product->p_title) ? $product->p_title : '' }}" class="demo-trigger">
							@else
							<img src="{{ asset('uploads/'.$img->name) }}" data-zoom="{{ asset('uploads/'.$img->name) }}" alt="{{  isset($product->p_title) ? $product->p_title : '' }}" class="demo-trigger">
							@endif
						</div>
						@endif
						@endforeach
						@if(isset($product->p_video) && $product->p_video != '' && $product->p_video != null)
						<div class="item">
							<video class="rounded display-video img-fluid" controls="" autoplay="" loop="">
								@if(isset($product->db_status) && $product->db_status != '' && $product->db_status != null && $product->db_status == 'manually')
								<source src="{{asset('product_media/product_videos/'.$product->p_video)}}" type="video/mp4">
								@else
								<source src="{{asset('uploads/'.$product->p_video)}}" type="video/mp4">
								@endif
							</video>
						</div>
						@endif
					@endif
					</div>
					<div id="syncsmall1" class="sync2 owl-carousel owl-theme">
					@if(isset($product->images) && count($product->images) > 0)
						@foreach($product->images as $key => $img)
						@if($img->type == $product_type)
						<div class="item thumbnail @if(isset($key) && $key == 0) active @endif">
							@if(isset($product->db_status) && $product->db_status != '' && $product->db_status != null && $product->db_status == 'manually')
							<img src="{{ asset('product_media/product_images/'.$img->name) }}" data-zoom="{{ asset('product_media/product_images/'.$img->name) }}" alt="{{  isset($product->p_title) ? $product->p_title : '' }}">
							@else
							<img src="{{ asset('uploads/'.$img->name) }}" data-zoom="{{ asset('uploads/'.$img->name) }}" alt="{{  isset($product->p_title) ? $product->p_title : '' }}">
							@endif
						</div>
						@endif
						@endforeach
						@if(isset($product->p_video) && $product->p_video != '' && $product->p_video != null)
						<div class="item thumbnail">
							<a class="selected" data-target="#custCarousel">
								<img src="{{ asset('front/src/images/video-Icon.webp') }}" alt="{{ asset('uploads/'.$img->name) }}" class="img-fluid">
							</a>
						</div>
						@endif
					@endif
					</div>
				</div>
            </div>
            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 right-side">
                <div class="p-category-list">
                    <div class="row">

                        <small class="ml-3 top-samll-text">{{ isset($product->metalpurity->title) ? $product->metalpurity->title : '' }} <span @if(!isset($product->metalpurity->title)) style="padding:0" @endif >{{ isset($product->family->family) ? $product->family->family : '' }}</span></small>
                        <div class="desktop-product-arrows">
                        @if(isset($nextProduct)  && $nextProduct != null)
							<a class="slick-next slick-arrow btn-next"
							href="{{ route('front.detail.products',['slug' => $nextProduct->p_slug]) }}"><i class="fa fa-angle-right" aria-hidden="true"></i></a>
						@endif
						@if(isset($previousProduct)  && $previousProduct != null)
							<a class="slick-prev slick-arrow btn-back"
							href="{{ route('front.detail.products',['slug' => $previousProduct->p_slug]) }}"><i class="fa fa-angle-left" aria-hidden="true"></i></a>
						@endif
					</div>
                        
                    </div>
                    <h5>{{ isset($product->p_title) ? $product->p_title : '' }}</h5>
                    <div class="p-code">SKU: <span>{{ isset($product->p_sku) ? $product->p_sku : '' }}</span></div>
                    <div class="row align-items-center">

                        @php
							if(isset($product) && $product->p_pricetype == 'dynamic')
							{
								$overall_discount_amount = $product->overall_discount($product->id,$product->total_price($product->id),$product->making_rate($product->id));
								$original_price = $product->total_price($product->id);
							}else{
								$overall_discount_amount = isset($product->p_discount) ? $product->p_discount : 0;
								$original_price = $product->total_price($product->id);
							}
						@endphp
						@if($original_price !== null && $original_price !== '0.00')
						@if(isset($product) && $original_price > 0)
						<div class="col-sm-6 mt-4">	
							<div class="p-price">
								<span>₹ {{ isset($product) ? number_format($original_price , 2, '.', ',') : '' }}</span>
								@if(isset($overall_discount_amount) && $overall_discount_amount > 0)
								<span class="overall-dicount">₹ {{ number_format($overall_discount_amount + $original_price, 2, '.', ',')  }}</span>
								@endif
							</div>
						
						</div>
						@endif
						@endif
                        
                        <div class="col-sm-6 availability-col">
							<div class="availability">Availability:
								<span>
									@if(isset($product->p_status) && $product->p_status != '' && $product->p_status != null && $product->p_status == 'by_order')
										By Order
									@elseif(isset($product->p_status) && $product->p_status != '' && $product->p_status != null && $product->p_status == 'ready_stock') 
										@if((isset($product->p_avail_stock_qty) && $product->p_avail_stock_qty != 0 && $product->p_avail_stock_qty != '') || $product->p_avail_stock_qty == null)
											Ready Stock
										@else
											Sold Out
										@endif
								 	@endif
								</span>
							</div>
						</div>
                    </div>

                     @if(isset($product->p_pricebreakdown) && $product->p_pricebreakdown == 'yes' && $product->p_pricetype != 'no_price')
						<hr class="mb-0 mt-2">
						<div id="accordion" class="price-backup">
							<div class=" border-0 ">
								<div class=" card-header pl-0 pr-0 border-0 bg-white " id="newheadingOne">
									<a href="" class="mb-0 accord price-breakup-title" data-bs-toggle="collapse" data-bs-target="#newcollapseOne" aria-expanded="true" aria-controls="newcollapseOne">
										<div class="row">
											<div class="col-9">
												Price Breakup
											</div>
											<div class="col-3 text-right">
												<i class="fa fa-plus accordion_hide"></i>
												<i class="fa fa-minus accordion_show" style="display: none;"></i>
											</div>
										</div>
									</a>
								</div>
								<div id="newcollapseOne" class="collapse" aria-labelledby="newheadingOne" data-bs-parent="#accordion" style="">
									<div class="col-12 pt-1">
										<div class="row price-backup-sec">
											@if($product->p_pricetype != 'fix_price' && $product->p_pricetype != 'no_price')
											@if($product->metal_rate($product->id) != '0.00' )
											<div class="col-12 p-0">
												<div class="p-weight dynamic-price-p-weight">Metal Charges:
													<span class="float-right">₹ {{ $product->metal_rate($product->id) }}</span>
												</div>
											</div>
											@endif
											@endif
											@if($product->p_pricetype != 'fix_price' && $product->p_pricetype != 'no_price')
											@if($product->diamond_rate($product->id) != '0.00')
											<div class="col-12 p-0">
												<div class="p-weight dynamic-price-p-weight">Diamond Charges:
													<div class="float-right d-flex">
														@php
														    $discounted_diamond_amount = $product->discount_metal($product->id, $product->diamond_rate($product->id));
														@endphp
														@if($discounted_diamond_amount > 0)
														<span class="discount-price">₹ {{ number_format($discounted_diamond_amount , 2, '.', ',') }}</span>
														@endif
														<span class="float-right" id="gold_rate">₹ {{ number_format($product->diamond_rate($product->id), 2, '.', ',') }}</span>
													</div>
												</div>
											</div>
											@endif
											@endif
											@if($product->p_pricetype != 'fix_price' && $product->p_pricetype != 'no_price')
											@if($product->pearl_rate($product->id) != '0.00')
											<div class="col-12 p-0">
												<!-- @php
													$final_pearl = str_replace(',', '', $product->pearl_rate($product->id));
													$discounted_pearl_amount = $product->discount_pearl($product->id, $product->pearl_rate($product->id));
												@endphp -->
												@php
												if(isset($product->pearl_dis) && $product->pearl_dis != '' && $product->pearl_dis != null)
												{
													$pearl_type = str_replace(',', '', $product->p_dis_pearl_price);
													if(isset($pearl_type) && $pearl_type != null && $pearl_type != '')
													{
														$discounted_pearl_amount = $product->p_total_pearl_charge;
														$discounted_pearl_amount = str_replace(',', '', $discounted_pearl_amount);
													}
												}
												@endphp
												<div class="p-weight dynamic-price-p-weight">Pearl Charges:
													<div class="float-right d-flex">
														@if($discounted_pearl_amount > 0)
														<span class="discount-price">₹ {{ number_format($discounted_pearl_amount, 2, '.', ',') }}</span>
														@endif
														<span class="float-right" id="gold_rate">₹ {{ $product->pearl_rate($product->id) }}</span>
													</div>
												</div>
											</div>
											@endif
											@endif
											@if($product->p_pricetype != 'fix_price' && $product->p_pricetype != 'no_price')
											@if($product->gemstone_rate($product->id) != '0.00' )
											<div class="col-12 p-0">
												@php
												if(isset($product->gemstone_dis) && $product->gemstone_dis != '' && $product->gemstone_dis != null)
												{
													$gem_type = str_replace(',', '', $product->p_dis_gemstone_price);
													if(isset($gem_type) && $gem_type != null && $gem_type != '')
													{
														$discounted_gem_amount = $product->p_total_gemstone_charge;
														$discounted_gem_amount = str_replace(',', '', $discounted_gem_amount);
													}
												}
												@endphp
												<div class="p-weight dynamic-price-p-weight">Gemstone Charges:
													<div class="float-right d-flex">
														@if(isset($discounted_gem_amount) && $discounted_gem_amount > 0)
														<span class="discount-price">₹ {{ number_format($discounted_gem_amount, 2, '.', ',') }}</span>
														@endif
														<span class="float-right" id="gold_rate">₹ {{ $product->gemstone_rate($product->id) }}</span>
													</div>
												</div>
											</div>
											@endif
											@endif
											@if($product->p_pricetype != 'fix_price' && $product->p_pricetype != 'no_price')
											@if($product->making_rate($product->id) != '0.00' )
											<div class="col-12 p-0">
												<!-- @php
													$discounted_mak_amount = $product->discount_mak($product->id, $product->making_rate($product->id));
												@endphp -->
												@php
												if(isset($product->make_dis) && $product->make_dis != '' && $product->make_dis != null)
												{
													$make_type = str_replace(',', '', $product->only_making_charges);
													if(isset($make_type) && $make_type != null && $make_type != '')
													{
														$discounted_mak_amount = $product->total_making_charges;
														$discounted_mak_amount = str_replace(',', '', $discounted_mak_amount);
													}
												}
												@endphp
												<div class="p-weight dynamic-price-p-weight">Making Charges:
													<div class="float-right d-flex">
														@if($discounted_mak_amount > 0)
														<span class="discount-price">₹ {{ number_format($discounted_mak_amount, 2, '.', ',') }}</span>
														@endif
														<span class="float-right" id="gold_rate" style="">₹ {{ $product->making_rate($product->id) }}</span>
													</div>
												</div>
											</div>
											@endif
											@endif
											@if($product->p_pricetype != 'fix_price' && $product->p_pricetype != 'no_price')
											@if($product->other_rate($product->id) != '0.00' )
											<div class="col-12 p-0">
												<!-- @php
													$final_other = str_replace(',', '', $product->other_rate($product->id));
													$discounted_other_amount = $product->discount_other($product->id, $product->other_rate($product->id));
												@endphp -->
												@php
												if(isset($product->other_dis) && $product->other_dis != '' && $product->other_dis != null)
												{
													$other_type = str_replace(',', '', $product->p_dis_other_price);
													if(isset($other_type) && $other_type != null && $other_type != '')
													{
														$discounted_other_amount = $product->p_total_other_charge;
														$discounted_other_amount = str_replace(',', '', $discounted_other_amount);
													}
												}
												@endphp
												<div class="p-weight dynamic-price-p-weight">Other Charges:
													<div class="float-right d-flex">
														@if($discounted_other_amount > 0)
														<span class="discount-price">₹ {{ number_format($discounted_other_amount, 2, '.', ',') }}</span>
														@endif
														<span class="float-right">₹ {{ $product->other_rate($product->id) }}</span>
													</div>
												</div>
											</div>
											@endif
											@endif
											@if(isset($product->p_fix_price) && $product->p_fix_price != null && $product->p_pricetype == 'fix_price')
											<div class="col-12 p-0">
												<div class="p-weight dynamic-price-p-weight">Fix Price:
													<div class="float-right d-flex">
														@if($overall_discount_amount > 0)
														<span class="discount-price">₹ {{ number_format(($product->p_fix_price - $overall_discount_amount) +$overall_discount_amount , 2, '.', ',') }}</span>
														@endif
														<span class="float-right">₹ {{ number_format($product->p_fix_price - $overall_discount_amount, 2, '.', ',') }}</span>
													</div>
												</div>
											</div>
											@endif
											@if($product->tax_rate($product->id) != '0.00')
											<div class="col-12 p-0">
												<div class="p-weight dynamic-price-p-weight">Tax:
													<span class="float-right" id="gold_rate" style="">₹ {{ $product->tax_rate($product->id) }}</span>
												</div>
											</div>
											@endif
										</div>
										<hr class="my-0">
										<div class="row">
											<div class="col-12 p-0">
												<div class="p-weight dynamic-price-p-weight dynamic-price-p-weight-last">Final Price Including Tax:
													<span class="float-right">₹ {{ isset($product) ? number_format($product->total_price($product->id), 2, '.', ',') : '' }}</span>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<hr class="mb-2 mt-0">
					@endif


                    @if(isset($product->p_gross_weight) || isset($product->p_size) || isset($product->p_measurement))
						<div class="p-weight-size">
						@if(isset($product->p_gross_weight) && $product->p_gross_weight != '' && $product->p_gross_weight != null)
							<div class="p-weight">Weight:
								<span>{{ isset($product->p_gross_weight) ? $product->p_gross_weight : '' }} {{ isset($product->p_gross_weight_unit) ? $product->p_gross_weight_unit : '' }}</span>
							</div> 
							@endif
							@if(isset($product->p_gross_weight) && $product->p_gross_weight != '' && $product->p_gross_weight != null && isset($product->p_size) && $product->p_size != '' && $product->p_size != null)
							<span class="pipe-line-icon">|</span>
							<div class="p-weight">Size:
								<span>{{ isset($product->p_size) ? $product->p_size : '' }} {{ isset($product->p_unit) ? $product->p_unit : '' }}</span>
							</div>
							@endif
							
							@if(isset($product->p_measurement) && $product->p_measurement != '' && $product->p_measurement != null)
							<span class="pipe-line-icon">|</span>
							<div class="p-weight">Measurements:
								<span>{{ isset($product->p_measurement) ? $product->p_measurement : '' }} {{ isset($product->p_measurement_unit) ? $product->p_measurement_unit : '' }}</span>
							</div>
						@endif
						
						</div>
					@endif
					@php
						$selected_size = '';
						$selected_size_unit = '';
						$selected_gender = '';
						$selected_metal_color = '';
						$selected_metal_purity = '';
						$selected_metal_weight = '';
						$selected_metal_weight_unit = '';
						$arr_metal_colors = [];
						$arr_metal_purities = [];
						$arr_metal_weights = [];
						$arr_genders = [];
					@endphp
					@if(isset($sizes) && count($sizes) > 0)
						<div class="p-size">
							<p class="gender-heading">Size:</p>
							<ul class="gender-ul">
								@foreach($sizes as $size)
								@if(isset($size['p_size']) && $size['p_size'] != null && $size['p_size'] != '')
								@php 
								$s_checked = '';
								$s_class = '';
								if(isset($all_attr) && count($all_attr) > 1)
								{
									if(!empty($sessionData['dashed_sizes']) && !in_array($size['p_size'] . ' ' . $size['p_unit'], $sessionData['dashed_sizes'])) {
									   $s_class = 'dashed';
								   	}
								}
								   if((isset($product->p_size) && $product->p_size == $size['p_size']) && (isset($product->p_unit) && $product->p_unit == $size['p_unit'])) {
									   $s_checked = "checked";
									   $s_class = 'active';
									   $selected_size = $product->p_size;
									   $selected_size_unit = $product->p_unit;
									   $s_query = App\Models\VariantProduct::query();
										$s_p_query = App\Models\Product::query();
										if(isset($selected_size) && $selected_size != null && isset($selected_size_unit) && $selected_size_unit != null)
										{
											$s_query->where('p_size',$selected_size)->where('p_unit',$selected_size_unit);
											$s_p_query->where('p_size',$selected_size)->where('p_unit',$selected_size_unit);
										}
										$s_query->where('parent_product_id',$main_parent_id);
										$s_p_query->where('id',$main_parent_id);
										$s_variants = $s_query->get();
										$s_parent = $s_p_query->first();
										if(isset($s_variants) && count($s_variants) > 0)
										{
											foreach($s_variants as $s_variant)
											{
												$arr_genders[] = isset($s_variant->p_gender) ? $s_variant->p_gender : '';
												$arr_metal_colors[] = isset($s_variant->p_metal_color) ? $s_variant->p_metal_color : '';
												$arr_metal_purities[] = isset($s_variant->p_metal_purity) ? $s_variant->p_metal_purity : '';
												$arr_metal_weights[] = (isset($s_variant->p_metal_weigth) ? $s_variant->p_metal_weigth : '') . ' ' . (isset($g_variant->p_metal_weight_unit) ? $g_variant->p_metal_weight_unit : '');
											}
										}
										if(isset($s_parent) && $s_parent != null)
										{
											$arr_genders[] = isset($s_parent->p_gender) ? $s_parent->p_gender : '';
											$arr_metal_colors[] = isset($s_parent->p_metal_color) ? $s_parent->p_metal_color : '';
											$arr_metal_purities[] = isset($s_parent->p_metal_purity) ? $s_parent->p_metal_purity : '';
											$arr_metal_weights[] = (isset($s_parent->p_metal_weigth) ? $s_parent->p_metal_weigth : '') . ' ' . (isset($s_parent->p_metal_weight_unit) ? $s_parent->p_metal_weight_unit : '');
										}
								   }
							   @endphp
								<input type="radio" id="size_{{ $loop->index }}" class="all_radio select_attribute" name="all_sizes" data-selected="size" value="{{ isset($size['p_size']) ? $size['p_size'] : '' }}_{{ isset($size['p_unit']) ? $size['p_unit'] : '' }}" {{ isset($s_checked) ? $s_checked : '' }}>
 								<label for="size_{{ $loop->index }}" class="{{ $s_class }}">{{ isset($size['p_size']) ? $size['p_size'] : '' }} {{ isset($size['p_unit']) ? $size['p_unit'] : '' }}</label>
                                @endif
								@endforeach
                            </ul>
						</div>
					@endif
					@if(isset($genders) && count($genders) > 0)
					@php
						$arr_metal_colors = [];
						$arr_metal_purities = [];
						$arr_metal_weights = [];
					@endphp
						<div class="p-size">
                            <p class="gender-heading">Gender:</p>
                            <ul class="gender-ul">
								@foreach($genders as $gender)
								@if(isset($gender['p_gender']) && $gender['p_gender'] != null && $gender['p_gender'] != '')
								@php 
								 $g_class = '';
								 $g_checked = '';
									if(isset($all_attr) && count($all_attr) > 1)
									{
										if(!empty($sessionData['dashed_genders']) && !in_array($gender['p_gender'], $sessionData['dashed_genders'])) {
											$g_class = 'dashed';
										}
									}
									if(isset($all_attr) && count($all_attr) > 1)
									{
										if(!empty($arr_genders) && !in_array($gender['p_gender'], $arr_genders)) {
											$m_p_class = 'dashed';
										}
									}
									if(isset($product->p_gender) && $product->p_gender == $gender['p_gender']) {
										$g_checked = "checked";
										$g_class = 'active';
										$selected_gender = $gender['p_gender'];
										$g_query = App\Models\VariantProduct::query();
										$g_p_query = App\Models\Product::query();
										if(isset($selected_size) && $selected_size != null && isset($selected_size_unit) && $selected_size_unit != null)
										{
											$g_query->where('p_size',$selected_size)->where('p_unit',$selected_size_unit);
											$g_p_query->where('p_size',$selected_size)->where('p_unit',$selected_size_unit);
										}
										$g_query->where('p_gender',$gender['p_gender'])->where('parent_product_id',$main_parent_id);
										$g_p_query->where('p_gender',$gender['p_gender'])->where('id',$main_parent_id);
										$g_variants = $g_query->get();
										$g_parent = $g_p_query->first();
										if(isset($g_variants) && count($g_variants) > 0)
										{
											foreach($g_variants as $g_variant)
											{
												$arr_genders[] = isset($g_variant->p_gender) ? $g_variant->p_gender : '';
												$arr_metal_colors[] = isset($g_variant->p_metal_color) ? $g_variant->p_metal_color : '';
												$arr_metal_purities[] = isset($g_variant->p_metal_purity) ? $g_variant->p_metal_purity : '';
												$arr_metal_weights[] = (isset($g_variant->p_metal_weigth) ? $g_variant->p_metal_weigth : '') . ' ' . (isset($g_variant->p_metal_weight_unit) ? $g_variant->p_metal_weight_unit : '');
											}
										}
										if(isset($g_parent) && $g_parent != null)
										{
											$arr_genders[] = isset($g_parent->p_gender) ? $g_parent->p_gender : '';
											$arr_metal_colors[] = isset($g_parent->p_metal_color) ? $g_parent->p_metal_color : '';
											$arr_metal_purities[] = isset($g_parent->p_metal_purity) ? $g_parent->p_metal_purity : '';
											$arr_metal_weights[] = (isset($g_parent->p_metal_weigth) ? $g_parent->p_metal_weigth : '') . ' ' . (isset($g_parent->p_metal_weight_unit) ? $g_parent->p_metal_weight_unit : '');
										}
									}
								@endphp
								<input type="radio" id="gender_{{ $loop->index }}" class="all_radio select_attribute" data-selected="gender" name="all_genders" value="{{ isset($gender['p_gender']) ? $gender['p_gender'] : '' }}" {{ isset($g_checked) ? $g_checked : '' }}>
  								<label for="gender_{{ $loop->index }}" class="{{ $g_class }}">{{ isset($gender['p_gender']) ? $gender['p_gender'] : '' }}</label>
                                @endif
								@endforeach
                            </ul>
                        </div>
					@endif	
					@if(isset($purities) && count($purities) > 0)
					@php
						$arr_metal_colors = [];
						$arr_metal_weights = [];
					@endphp
						<div class="p-size">
							<p class="gender-heading">Purities:</p>
							<ul class="gender-ul">
							@foreach($purities as $purity)
								@if(isset($purity['p_metal_purity']) && $purity['p_metal_purity'] != null && $purity['p_metal_purity'] != '')
									@php 
										$m_p_checked = '';
										$m_p_class = '';
										if(isset($all_attr) && count($all_attr) > 1)
										{
											if(!empty($sessionData['dashed_purities']) && !in_array($purity['p_purity_id'], $sessionData['dashed_purities'])) {
												$m_p_class = 'dashed';
											}
										}
										if(isset($all_attr) && count($all_attr) > 1)
										{
											if(!empty($arr_metal_purities) && !in_array($purity['p_purity_id'], $arr_metal_purities)) {
												$m_p_class = 'dashed';
											}
										}
										if(isset($product->p_metal_purity) && $product->p_metal_purity == $purity['p_purity_id']) {
											$m_p_checked = "checked";
											$m_p_class = 'active';
											$p_query = App\Models\VariantProduct::query();
											$p_p_query = App\Models\Product::query();
											$selected_metal_purity = $purity['p_purity_id'];
											if(isset($selected_size) && $selected_size != null && isset($selected_size_unit) && $selected_size_unit != null)
											{
												$p_query->where('p_size',$selected_size)->where('p_unit',$selected_size_unit);
												$p_p_query->where('p_size',$selected_size)->where('p_unit',$selected_size_unit);
											}
											if(isset($selected_gender) && $selected_gender != null)
											{
												$p_query->where('p_gender',$selected_gender);
												$p_p_query->where('p_gender',$selected_gender);
											}

											$p_query->where('p_metal_purity',$purity['p_purity_id'])->where('parent_product_id',$main_parent_id);
											$p_p_query->where('p_metal_purity',$purity['p_purity_id'])->where('id',$main_parent_id);
											$p_variants = $p_query->get();
											$p_parent = $p_p_query->first();
											
											if(isset($p_variants) && count($p_variants) > 0)
											{
												foreach($p_variants as $p_variant)
												{
													$arr_genders[] = isset($p_variant->p_gender) ? $p_variant->p_gender : '';
													$arr_metal_colors[] = isset($p_variant->p_metal_color) ? $p_variant->p_metal_color : '';
													$arr_metal_purities[] = isset($p_variant->p_metal_purity) ? $p_variant->p_metal_purity : '';
													$arr_metal_weights[] = (isset($p_variant->p_metal_weigth) ? $p_variant->p_metal_weigth : '') . ' ' . (isset($p_variant->p_metal_weight_unit) ? $p_variant->p_metal_weight_unit : '');
													if(isset($p_variant->diamond_details) && $p_variant->diamond_details != null && $p_variant->diamond_details != '')
													{
														$d_diamond_details = json_decode($p_variant->diamond_details, true);
														foreach ($d_diamond_details as $detail) {
															if (isset($detail['attr_clarity'])) {
																$arr_d_clarities[] = $detail['attr_clarity'];
															}
														}
													}
												}
											}
											if(isset($p_parent) && $p_parent != null)
											{
												$arr_genders[] = isset($p_parent->p_gender) ? $p_parent->p_gender : '';
												$arr_metal_colors[] = isset($p_parent->p_metal_color) ? $p_parent->p_metal_color : '';
												$arr_metal_purities[] = isset($p_parent->p_metal_purity) ? $p_parent->p_metal_purity : '';
												$arr_metal_weights[] = (isset($p_parent->p_metal_weigth) ? $p_parent->p_metal_weigth : '') . ' ' . (isset($p_parent->p_metal_weight_unit) ? $p_parent->p_metal_weight_unit : '');
												if(isset($p_parent->diamond_details) && $p_parent->diamond_details != null && $p_parent->diamond_details != '')
												{
													$p_diamond_details = json_decode($p_parent->diamond_details, true);
													foreach ($p_diamond_details as $detail) {
														if (isset($detail['attr_clarity'])) {
															$arr_d_clarities[] = $detail['attr_clarity'];
														}
													}
												}
												
											}
										}
									@endphp
									<input type="radio" id="m_pu_{{ $loop->index }}" class="all_radio select_attribute" data-selected="metal_purity" name="all_metal_purity" value="{{ isset($purity['p_purity_id']) ? $purity['p_purity_id'] : '' }}" {{ isset($m_p_checked) ? $m_p_checked : '' }}>
									<label for="m_pu_{{ $loop->index }}" class="{{ $m_p_class }}">{{ isset($purity['p_metal_purity']) ? $purity['p_metal_purity'] : '' }}</label>
								@endif
							@endforeach
							</ul>
						</div>
					@endif
					@if(isset($metal_colors) && count($metal_colors) > 0)
					@php
						$arr_metal_weights = [];
					@endphp
                        <div class="p-size">
                            <p class="gender-heading">Metal Color:</p>
                            <ul class="gender-ul">
							@foreach($metal_colors as $m_color)
							@if(isset($m_color['p_metal_color']) && $m_color['p_metal_color'] != null && $m_color['p_metal_color'] != '')
							@php 
								$m_c_checked = '';
								$m_c_class = '';
								if(isset($all_attr) && count($all_attr) > 1)
								{
									if(!empty($sessionData['dashed_m_colors']) && !in_array($m_color['p_metal_color_id'], $sessionData['dashed_m_colors'])) {
										$m_c_class = 'dashed';
									}
								}
								if(isset($all_attr) && count($all_attr) > 1)
								{
									if(!empty($arr_metal_colors) && !in_array($m_color['p_metal_color_id'], $arr_metal_colors)) {
										$m_c_class = 'dashed';
									}
								}
								if(isset($product->p_metal_color) && $product->p_metal_color == $m_color['p_metal_color_id']) {
									$m_c_checked = "checked";
									$m_c_class = 'active';
									$selected_metal_color = $m_color['p_metal_color_id'];
									$m_c_query = App\Models\VariantProduct::query();
									$m_c_p_query = App\Models\Product::query();
									if(isset($selected_size) && $selected_size != null && isset($selected_size_unit) && $selected_size_unit != null)
									{
										$m_c_query->where('p_size',$selected_size)->where('p_unit',$selected_size_unit);
										$m_c_p_query->where('p_size',$selected_size)->where('p_unit',$selected_size_unit);
									}
									if(isset($selected_gender) && $selected_gender != null)
									{
										$m_c_query->where('p_gender',$selected_gender);
										$m_c_p_query->where('p_gender',$selected_gender);
									}
									if(isset($selected_metal_purity) && $selected_metal_purity != null)
									{
										$m_c_query->where('p_metal_purity',$selected_metal_purity);
										$m_c_p_query->where('p_metal_purity',$selected_metal_purity);
									}
									$m_c_query->where('p_metal_color',$m_color['p_metal_color_id'])->where('parent_product_id',$main_parent_id);
									$m_c_p_query->where('p_metal_color',$m_color['p_metal_color_id'])->where('id',$main_parent_id);
									$m_c_variants = $m_c_query->get();
									$m_c_p_parent = $m_c_p_query->first();
									if(isset($m_c_variants) && count($m_c_variants) > 0)
									{
										foreach($m_c_variants as $m_c_variant)
										{
											$arr_genders[] = isset($m_c_variant->p_gender) ? $m_c_variant->p_gender : '';
											$arr_metal_colors[] = isset($m_c_variant->p_metal_color) ? $m_c_variant->p_metal_color : '';
											$arr_metal_purities[] = isset($m_c_variant->p_metal_purity) ? $m_c_variant->p_metal_purity : '';
											$arr_metal_weights[] = (isset($m_c_variant->p_metal_weigth) ? $m_c_variant->p_metal_weigth : '') . ' ' . (isset($m_c_variant->p_metal_weight_unit) ? $m_c_variant->p_metal_weight_unit : '');
											if(isset($m_c_variant->diamond_details) && $m_c_variant->diamond_details != null && $m_c_variant->diamond_details != '')
											{
												$d_diamond_details = json_decode($m_c_variant->diamond_details, true);
												foreach ($d_diamond_details as $detail) {
													if (isset($detail['attr_clarity'])) {
														$arr_d_clarities[] = $detail['attr_clarity'];
													}
												}
											}
										}
									}
									if(isset($m_c_p_parent) && $m_c_p_parent != null)
									{
										$arr_genders[] = isset($m_c_p_parent->p_gender) ? $m_c_p_parent->p_gender : '';
										$arr_metal_colors[] = isset($m_c_p_parent->p_metal_color) ? $m_c_p_parent->p_metal_color : '';
										$arr_metal_purities[] = isset($m_c_p_parent->p_metal_purity) ? $m_c_p_parent->p_metal_purity : '';
										$arr_metal_weights[] = (isset($m_c_p_parent->p_metal_weigth) ? $m_c_p_parent->p_metal_weigth : '') . ' ' . (isset($m_c_p_parent->p_metal_weight_unit) ? $m_c_p_parent->p_metal_weight_unit : '');
										if(isset($m_c_p_parent->diamond_details) && $m_c_p_parent->diamond_details != null && $m_c_p_parent->diamond_details != '')
										{
											$d_diamond_details = json_decode($m_c_p_parent->diamond_details, true);
											foreach ($d_diamond_details as $detail) {
												if (isset($detail['attr_clarity'])) {
													$arr_d_clarities[] = $detail['attr_clarity'];
												}
											}
										}
									}
								}
								
								
							@endphp
								<input type="radio" id="m_co_{{ $loop->index }}" class="all_radio select_attribute" data-selected="metal_color" name="all_metal_color" value="{{ isset($m_color['p_metal_color_id']) ? $m_color['p_metal_color_id'] : '' }}" {{ isset($m_c_checked) ? $m_c_checked : '' }}>
  								<label for="m_co_{{ $loop->index }}" class="{{ $m_c_class }}">{{ isset($m_color['p_metal_color']) ? $m_color['p_metal_color'] : '' }}</label>
							@endif
							@endforeach
                            </ul>
                        </div>
					@endif
					@if(isset($metal_weights) && count($metal_weights) > 0)
						<div class="p-size">
							<p class="gender-heading">Metal Weight:</p>
							<ul class="gender-ul">
								@foreach($metal_weights as $m_weight)
								@if(isset($m_weight['p_metal_weight']) && $m_weight['p_metal_weight'] != null && $m_weight['p_metal_weight'] != '')
								@php 
									$m_w_checked = '';
									$m_w_class = '';
									if(isset($all_attr) && count($all_attr) > 1)
									{
										if(!empty($sessionData['dashed_m_weights']) && !in_array($m_weight['p_metal_weight'] . ' ' . $m_weight['p_metal_unit'], $sessionData['dashed_m_weights'])) {
											$m_w_class = 'dashed';
										}
										if(!empty($arr_metal_weights) && !in_array($m_weight['p_metal_weight'] . ' ' . $m_weight['p_metal_unit'], $arr_metal_weights)) {
											$m_w_class = 'dashed';
										}
									}
									if(isset($product->p_metal_weigth) && $product->p_metal_weigth == $m_weight['p_metal_weight']) {
										$m_w_checked = "checked";
										$m_w_class = 'active';
										$selected_metal_weight = $m_weight['p_metal_weight'];
										$selected_metal_weight_unit = $m_weight['p_metal_unit'];
									}
								@endphp
								<input type="radio" id="m_we_{{ $loop->index }}" class="all_radio select_attribute" data-selected="metal_wieght" name="all_metal_weigts" value="{{ isset($m_weight['p_metal_weight']) ? $m_weight['p_metal_weight'] : '' }}_{{ isset($m_weight['p_metal_unit']) ? $m_weight['p_metal_unit'] : '' }}" {{ isset($m_w_checked) ? $m_w_checked : '' }}>
  								<label for="m_we_{{ $loop->index }}" class="{{ $m_w_class }}">{{ isset($m_weight['p_metal_weight']) ? $m_weight['p_metal_weight'] : '' }} {{ isset($m_weight['p_metal_unit']) ? $m_weight['p_metal_unit'] : '' }}</label>
                                @endif
								@endforeach
								</ul>
						</div>
					@endif
					@if(isset($diamond_clarities) && count($diamond_clarities) > 0)
						<div class="p-size">
							<p class="gender-heading">Diamond Clarities:</p>
							<ul class="gender-ul">
								@foreach($diamond_clarities as $diamond_clarity)
								@if(isset($diamond_clarity['p_diamond_clarity']) && $diamond_clarity['p_diamond_clarity'] != null && $diamond_clarity['p_diamond_clarity'] != '')
								@php 
								$d_c_checked = '';
								$d_c_class = '';
								if(isset($product->diamond_details) && $product->diamond_details != null && $product->diamond_details != '')
								{
									$diamonds = json_decode($product->diamond_details);
									if(isset($diamonds) && count($diamonds) > 0)
									{
										foreach($diamonds as $v_c_key => $diamond)
										{
											if(isset($diamond->attr_clarity) && $diamond->attr_clarity == $diamond_clarity['p_diamond_clarity'])
											{
												$d_c_checked = "checked";
									   			$d_c_class = 'active';
											}else{
												$d_c_checked = "";
									   			$d_c_class = '';
											}
										}
									}
								}
								if(isset($all_attr) && count($all_attr) > 1)
								{
									if(!empty($sessionData['dashed_d_clarities']) && !in_array($diamond_clarity['p_diamond_clarity'], $sessionData['dashed_d_clarities'])) {
									   $d_c_class = 'dashed';
								   	}
									if(!empty($arr_d_clarities) && !in_array($diamond_clarity['p_diamond_clarity'], $arr_d_clarities)) {
										$d_c_class = 'dashed';
									}
								}
							   @endphp
								<input type="radio" id="diamond_clarity_{{ $loop->index }}" class="all_radio select_attribute" name="all_diamond_clarity" data-selected="diamond_clarity" value="{{ isset($diamond_clarity['p_diamond_clarity']) ? $diamond_clarity['p_diamond_clarity'] : '' }}" {{ isset($d_c_checked) ? $d_c_checked : '' }}>
  								<label for="diamond_clarity_{{ $loop->index }}" class="{{ $d_c_class }}" id="diamond_clarity_{{ isset($diamond_clarity['p_diamond_clarity']) ? $diamond_clarity['p_diamond_clarity'] : '' }}">{{ isset($diamond_clarity['p_diamond_clarity']) ? $diamond_clarity['p_diamond_clarity'] : '' }}</label>
                                @endif
								@endforeach
                            </ul>
						</div>
					@endif
                    <div class="p-value">
                        <div class="number">
                            <div class="qty">QTY</div>
                            <span class="minus qty_decrease">-</span>
                            <input type="text" id="product_qty" name="product_qty" value="1" disabled="">
                            @if(isset($product->p_status) && $product->p_status != '' && $product->p_status != null && $product->p_status == 'ready_stock')
							<input type="hidden" id="available_qty" name="available_qty" value="{{ isset($product->p_avail_stock_qty) ? $product->p_avail_stock_qty : '' }}" disabled />
							<input type="hidden" id="final_available_qty" name="final_available_qty" value="{{ isset($product->p_avail_stock_qty) ? $product->p_avail_stock_qty : '' }}" disabled />
							@endif
                            <span class="plus qty_increase">+</span>
                        </div>
                        <div class="p-images">
							<a id="addToWhishlist" onclick="addToWishlist('{{$product->id}}','{{$product->p_title}}','{{$product->p_slug}}','','{{ $product->p_grand_price_total }}','{{ $product_type }}');">
								<img src="{{asset('front/src/images/heart-icon.svg')}}" alt="Heart">
							</a>
							<a href="https://api.whatsapp.com/send?phone=+{{$bs->country_code_number.''.$bs->whatsapp_number}}&text=Hi, I would like to see this product design through video call. I look forward to your reply. Thank you. {{route('front.detail.products',['slug'=>$product->p_slug])}}" title="Book a video call to see this design Live." target="_blank">
								<img src="{{asset('front/src/images/video-icon.svg')}}" alt="Video">
							</a>
							<a onclick="share_model('{{$product->id}}','product','{{ $product_type }}')">
								<img src="{{ asset('front/src/images/share-share.svg') }}" alt="Share">
							</a>
						</div>
                    </div>

                    <div class="p-link">
						<div class="row">
							@if(isset($product->p_status) && $product->p_status != '' && $product->p_status != null && $product->p_status == 'by_order')
								<div class="add-and-visit-btn">
									<a onclick="addToCart('{{$product->id}}','{{$product->p_title}}','{{$product->p_grand_price_total}}',null,'','{{ $product_type }}');" id="addToCart" class="add-to-cart-btn text-center">
										<svg xmlns="http://www.w3.org/2000/svg" width="13" height="15" viewBox="0 0 13 15" fill="none">
											<path d="M12.9978 14.5069L11.8561 3.65032C11.8443 3.54084 11.7924 3.43954 11.7104 3.36592C11.6284 3.29229 11.522 3.25153 11.4117 3.25138H9.26335V2.76303C9.26335 2.03066 8.97204 1.3283 8.45346 0.810429C7.93488 0.292559 7.23156 0.00164795 6.49817 0.00164795C5.76479 0.00164795 5.06147 0.292559 4.54289 0.810429C4.02431 1.3283 3.7328 2.03066 3.7328 2.76303V3.25138H1.59318C1.48279 3.25134 1.37631 3.29208 1.29415 3.36572C1.212 3.43937 1.16008 3.54071 1.14825 3.65032L0.00656053 14.5069C7.70162e-05 14.5691 0.00670594 14.6319 0.0260666 14.6914C0.0454272 14.7508 0.0770475 14.8056 0.118915 14.8521C0.160783 14.8986 0.211953 14.9357 0.269112 14.9612C0.326271 14.9867 0.388115 14.9998 0.450713 14.9999H12.5575C12.6201 14.9998 12.682 14.9867 12.7391 14.9612C12.7963 14.9357 12.8475 14.8986 12.8893 14.8521C12.9312 14.8056 12.9628 14.7508 12.9822 14.6914C13.0015 14.6319 13.0082 14.5691 13.0017 14.5069H12.9978ZM4.62852 2.76226C4.63864 2.27325 4.84021 1.80778 5.1901 1.46552C5.53998 1.12325 6.01034 0.931395 6.50012 0.931395C6.98991 0.931395 7.46026 1.12325 7.81015 1.46552C8.16004 1.80778 8.36161 2.27325 8.37173 2.76226V3.2506H4.6293L4.62852 2.76226ZM0.942851 14.1072L1.99111 4.14334H3.73456V5.12802C3.73456 5.24641 3.78161 5.35986 3.86544 5.44358C3.94927 5.5273 4.06288 5.57429 4.18144 5.57429C4.3 5.57429 4.4138 5.5273 4.49763 5.44358C4.58146 5.35986 4.62852 5.24641 4.62852 5.12802V4.14334H8.37173V5.12802C8.37173 5.24631 8.41866 5.35974 8.50242 5.44339C8.58618 5.52703 8.69996 5.5739 8.81842 5.5739C8.93687 5.5739 9.05046 5.52703 9.13422 5.44339C9.21798 5.35974 9.26491 5.24631 9.26491 5.12802V4.14334H11.0091L12.0574 14.1072H0.942851Z" fill="white"/>
										</svg>ADD TO CART
									</a>
								</div>
							@elseif(isset($product->p_status) && $product->p_status != '' && $product->p_status != null && $product->p_status == 'ready_stock')

								@if((isset($product->p_avail_stock_qty) && $product->p_avail_stock_qty != 0 && $product->p_avail_stock_qty != '') || $product->p_avail_stock_qty == null)
								<div class="add-and-visit-btn">
									<a onclick="addToCart('{{$product->id}}','{{$product->p_title}}','{{$product->p_grand_price_total}}',null,'','{{ $product_type }}');" id="addToCart" class="add-to-cart-btn text-center">
									<svg xmlns="http://www.w3.org/2000/svg" width="13" height="15" viewBox="0 0 13 15" fill="none">
										<path d="M12.9978 14.5069L11.8561 3.65032C11.8443 3.54084 11.7924 3.43954 11.7104 3.36592C11.6284 3.29229 11.522 3.25153 11.4117 3.25138H9.26335V2.76303C9.26335 2.03066 8.97204 1.3283 8.45346 0.810429C7.93488 0.292559 7.23156 0.00164795 6.49817 0.00164795C5.76479 0.00164795 5.06147 0.292559 4.54289 0.810429C4.02431 1.3283 3.7328 2.03066 3.7328 2.76303V3.25138H1.59318C1.48279 3.25134 1.37631 3.29208 1.29415 3.36572C1.212 3.43937 1.16008 3.54071 1.14825 3.65032L0.00656053 14.5069C7.70162e-05 14.5691 0.00670594 14.6319 0.0260666 14.6914C0.0454272 14.7508 0.0770475 14.8056 0.118915 14.8521C0.160783 14.8986 0.211953 14.9357 0.269112 14.9612C0.326271 14.9867 0.388115 14.9998 0.450713 14.9999H12.5575C12.6201 14.9998 12.682 14.9867 12.7391 14.9612C12.7963 14.9357 12.8475 14.8986 12.8893 14.8521C12.9312 14.8056 12.9628 14.7508 12.9822 14.6914C13.0015 14.6319 13.0082 14.5691 13.0017 14.5069H12.9978ZM4.62852 2.76226C4.63864 2.27325 4.84021 1.80778 5.1901 1.46552C5.53998 1.12325 6.01034 0.931395 6.50012 0.931395C6.98991 0.931395 7.46026 1.12325 7.81015 1.46552C8.16004 1.80778 8.36161 2.27325 8.37173 2.76226V3.2506H4.6293L4.62852 2.76226ZM0.942851 14.1072L1.99111 4.14334H3.73456V5.12802C3.73456 5.24641 3.78161 5.35986 3.86544 5.44358C3.94927 5.5273 4.06288 5.57429 4.18144 5.57429C4.3 5.57429 4.4138 5.5273 4.49763 5.44358C4.58146 5.35986 4.62852 5.24641 4.62852 5.12802V4.14334H8.37173V5.12802C8.37173 5.24631 8.41866 5.35974 8.50242 5.44339C8.58618 5.52703 8.69996 5.5739 8.81842 5.5739C8.93687 5.5739 9.05046 5.52703 9.13422 5.44339C9.21798 5.35974 9.26491 5.24631 9.26491 5.12802V4.14334H11.0091L12.0574 14.1072H0.942851Z" fill="white"/>
									</svg>ADD TO CART</a>
								</div>
								@else
								<div class="add-and-visit-btn">
									<a id="addToCart" class="add-to-cart-btn text-center">
									OUT OF STOCK</a>
								</div>
								@endif
						
							@endif
							
							@if(isset($product->p_status) && $product->p_status != '' && $product->p_status != null && $product->p_status == 'by_order')
								<div class="add-and-visit-btn buy_now_prdct">
									<a href="javascript:;" onclick="addToCart('{{$product->id}}','{{$product->p_title}}','{{$product->p_grand_price_total}}',null,'buynow','{{ $product_type }}');" class="add-to-cart-btn text-center visit-store">Buy Now</a>
								</div>
							@elseif(isset($product->p_status) && $product->p_status != '' && $product->p_status != null && $product->p_status == 'ready_stock')
								@if((isset($product->p_avail_stock_qty) && $product->p_avail_stock_qty != 0 && $product->p_avail_stock_qty != '') || $product->p_avail_stock_qty == null)
								<div class="add-and-visit-btn buy_now_prdct">
									<a href="javascript:;" onclick="addToCart('{{$product->id}}','{{$product->p_title}}','{{$product->p_grand_price_total}}',null,'buynow','{{ $product_type }}');" class="add-to-cart-btn text-center visit-store">Buy Now</a>
								</div>
								@endif
							@endif
						</div>
					</div>

                    <div class="p-link enter-pin-code-section">
						<div class="row">
							<div class="col-lg-8 col-md-8 col-sm-8 col-12" style="padding-left:0">
								
							<p class="estimate-delivery">Estimated Delivery Date</p>
								<div class="d-flex">
									<div class="estimate-delivery-sec">
									<input type="text" name="pincode_check" id="pincode_check" placeholder="ENTER PIN CODE"><img src="{{asset('front/src/images/location-icon.svg')}}">
								</div>
									<a href="javascript:;" id="check_pin_code">CHECK</a>

								</div>
								<p id="pincode_string" style="text-align: left; color: var(--theme-orange-red);padding: 0;"></p>
							</div>
						</div>
						<span id="pincode_error" style="height: 20px;width: auto;display: block;"></span>
					</div>


                    
                </div>
            </div>
        </div>
    </div>
</section>

<section class="common-section single-product-details-content common-padding">
    <div class="container-md">
        <div class="row">
            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 left-side">
                <div class="accordion product-list-items" id="accordionExample">

                    <div class="accordion-item">
                      <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                            Specifications
                        </button>
                      </h2>
                      <div id="collapseTwo" class="accordion-collapse collapse show" aria-labelledby="headingTwo">
                        <div class="accordion-body">
                            <ul>

	                    		<li>
									<span>Category</span>
									<span class="right-text">: {{ isset($product->category->category) ? $product->category->category : '' }}</span>
								</li>
								@if(isset($product->occasion->title) && $product->occasion->title != null)
								<li>
									<span>Occasion</span>
									<span class="right-text">: {{ isset($product->occasion->title) ? $product->occasion->title : '' }}</span>
								</li>
								@endif
								@if(isset($product->trend->title) && $product->trend->title != null)
								<li>
									<span>Trend</span>
									<span class="right-text">: {{ isset($product->trend->title) ? $product->trend->title : '' }}</span>
								</li>
								@endif
								@if(isset($product->p_gender) && $product->p_gender != null)
								<li>
									<span>Gender</span>
									<span class="right-text">: {{ isset($product->p_gender) ? $product->p_gender : '' }}</span>
								</li>
								@endif
								@if(isset($product->style->title) && $product->style->title != null)
								<li>
									<span>Style</span>
									<span class="right-text">: {{ isset($product->style->title) ? $product->style->title : '' }}</span>
								</li>
								@endif
								@if(isset($product->p_brand) && $product->p_brand != null)
								<li>
									<span>Brand</span>
									<span class="right-text">: {{ isset($product->p_brand) ? $product->p_brand : '' }}</span>
								</li>
								@endif
								@if(isset($product->p_theme) && $product->p_theme != null)
								<li>
									<span>Theme</span>
									<span class="right-text">: {{ isset($product->p_theme) ? $product->p_theme : '' }}</span>
								</li>
								@endif
								@if(isset($product->design->title) && $product->design->title != null)
								<li>
									<span>Design</span>
									<span class="right-text">: {{ isset($product->design->title) ? $product->design->title : '' }}</span>
								</li>
								@endif
								@if(isset($product->p_popular_gemstone) && $product->p_popular_gemstone != null)
								<li>
									<span>Popular Gemstone</span>
									<span class="right-text">: {{ isset($product->p_popular_gemstone) ? $product->p_popular_gemstone : '' }}</span>
								</li>
								@endif
								@if(isset($product->p_gemstone_shape) && $product->p_gemstone_shape != null)
								<li>
									<span>Shape</span>
									<span class="right-text">: {{ isset($product->p_gemstone_shape) ? $product->p_gemstone_shape : '' }}</span>
								</li>
								@endif
								@if(isset($product->p_gemstone_caret) && $product->p_gemstone_caret != null)
								<li>
									<span>Carat</span>
									<span class="right-text">: {{ isset($product->p_gemstone_caret) ? $product->p_gemstone_caret : '' }}</span>
								</li>
								@endif
								@if(isset($product->p_gemstone_color) && $product->p_gemstone_color != null)
								<li>
									<span>Colour</span>
									<span class="right-text">: {{ isset($product->p_gemstone_color) ? $product->p_gemstone_color : '' }}</span>
								</li>
								@endif
								@if(isset($product->p_gemstone_clarity) && $product->p_gemstone_clarity != null)
								<li>
									<span>Clarity</span>
									<span class="right-text">: {{ isset($product->p_gemstone_clarity) ? $product->p_gemstone_clarity : '' }}</span>
								</li>
								@endif
								@if(isset($product->p_gemstone_cut) && $product->p_gemstone_cut != null)
								<li>
									<span>Cut</span>
									<span class="right-text">: {{ isset($product->p_gemstone_cut) ? $product->p_gemstone_cut : '' }}</span>
								</li>
								@endif
								@if(isset($product->p_gemstone_treatment) && $product->p_gemstone_treatment != null)
								<li>
									<span>Treatment</span>
									<span class="right-text">: {{ isset($product->p_gemstone_treatment) ? $product->p_gemstone_treatment : '' }}</span>
								</li>
								@endif
								@if(isset($product->country->name) && $product->country->name != null)
								<li>
									<span>Made In</span>
									<span class="right-text">: {{ isset($product->country->name) ? $product->country->name : '' }}</span>
								</li>
								@endif
                            </ul>
                        </div>
                      </div>
                    </div>
			       
					@if((isset($product->metalpurity->title) && $product->metalpurity->title != null) || (isset($product->p_metal_color) && $product->p_metal_color != "") || (isset($product->p_metal_weigth) && $product->p_metal_weigth != ''))
					<div class="accordion-item">
                      <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#metalinfoCollapse" aria-expanded="false" aria-controls="metalinfoCollapse">
                            Metal Information
                        </button>
                      </h2>
                      <div id="metalinfoCollapse" class="accordion-collapse collapse" aria-labelledby="headingOne">
                        <div class="accordion-body">
                          <ul>
                            
                            @if(isset($product->metalpurity->title) && $product->metalpurity->title != null)
								<li>
		                			<span>Metal Purity</span>
		                			<span class="right-text">: {{ isset($product->metalpurity->title) ? $product->metalpurity->title : '' }}</span>
		                		</li>
		                	@endif
							@if(isset($product->p_metal_color) && $product->p_metal_color != "")
		                		<li>
		                			<span>Metal Colour</span>
		                			@if($product->db_status == 'migrated')
		                				<span class="right-text">: {{ isset($product->p_metal_color) ? $product->p_metal_color : '' }}</span>
		                			@else
		                				<span class="right-text">: {{ isset($product->metalcolor->title) ? $product->metalcolor->title : '' }}</span>
		                			@endif
		                		</li>
		                	@endif
		                	@if(isset($product->p_metal_weigth) && $product->p_metal_weigth != '')
		                		<li>
		                			<span>Metal Weight</span>
		                			<span class="right-text">: {{ isset($product->p_metal_weigth) ? $product->p_metal_weigth : '' }} {{ isset($product->p_metal_weight_unit) ? $product->p_metal_weight_unit : '' }}</span>
		                		</li>
				             @endif
                          </ul>
                        </div>
                      </div>
                    </div>

					@endif

					@if(isset($product->diamond_details) && $product->diamond_details != "" && $product->diamond_details != null)
					@php
					if (!empty($product->diamond_details) && ($product->diamond_details[0] == '{' || $product->diamond_details[strlen($product->diamond_details) - 1] == '}')) {
					    // Add [ at the start and ] at the end
					    $product->diamond_details = '[' . $product->diamond_details . ']';
					}
					
			        $diamond_details = json_decode($product->diamond_details, true);
				        if($diamond_details !== null && is_array($diamond_details)) {
				            $allBlank = true;
				            foreach($diamond_details as $diamond_detail) {
				                if(is_array($diamond_detail)) {
				                    foreach($diamond_detail as $key => $value) {
				                        if (!empty($value)) {
				                            $allBlank = false;
				                            break 2; 
				                        }
				                    }
				                } else {
				                    // Handle the case where $diamond_detail is not a valid array
				                    $allBlank = false;
				                    break; // Break the outer loop
				                }
				            }
				        } 
				    @endphp
				    @if (isset($allBlank) && !$allBlank)

					<div class="accordion-item">
                      <h2 class="accordion-header" id="headingfourmetal">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#diamondinfocol" aria-expanded="false" aria-controls="diamondinfocol">
                            Diamond Information
                        </button>
                      </h2>
                      <div id="diamondinfocol" class="accordion-collapse collapse" aria-labelledby="headingfourmetal">
                        <div class="accordion-body">
                          <ul>
		                		@foreach($diamond_details as $key => $diamond_details_value)
									@if(count($diamond_details) > 1)
									<li>
			                			<span>#{{ $key+1 }}</span>
			                		</li>
									@endif
									@if(isset($diamond_details_value['attr_type_dynamic']) && $diamond_details_value['attr_type_dynamic'] != '')
			                		@php
			                		$type = App\Models\DynamicDiamondType::where('id' , $diamond_details_value['attr_type_dynamic'])->first();
			                		@endphp
									<li>
			                			<span>Type</span>
			                			<span>: {{ isset($product->metalpurity->title) ? $product->metalpurity->title : '' }}</span>
			                		</li>
			                		@endif
									@if(isset($diamond_details_value['attr_type_quality']) && $diamond_details_value['attr_type_quality'] != '')
			                		<li>
			                			<span>Quality</span>
			                			<span>: {{$diamond_details_value['attr_type_quality']}}</span>
			                		</li>
			                		@endif
			                		@if(isset($diamond_details_value['attr_type']) &&  $diamond_details_value['attr_type'] != '')
			                		<li>
			                			<span>Types Of Diamond</span>
			                			<span>: {{$diamond_details_value['attr_type']}}</span>
			                		</li>
			                		@endif
			                		@if(isset($diamond_details_value['attr_fancy_color']) ? $diamond_details_value['attr_fancy_color'] : '')
			                		<li>
			                			<span>Fancy Colour</span>
			                			<span>: {{$diamond_details_value['attr_fancy_color']}}</span>
			                		</li>
			                		@endif
			                		@if(isset($diamond_details_value['attr_color']) ? $diamond_details_value['attr_color'] : '')
			                		<li>
			                			<span>Colour</span>
			                			<span>: {{$diamond_details_value['attr_color']}}</span>
			                		</li>
			                		@endif
			                		@if(isset($diamond_details_value['attr_gemstone']) ? $diamond_details_value['attr_gemstone'] : '')
			                		<li>
			                			<span>Gemstone</span>
			                			<span>: {{$diamond_details_value['attr_gemstone']}}</span>
			                		</li>
			                		@endif
			                		@if(isset($diamond_details_value['attr_shape']) ? $diamond_details_value['attr_shape'] : '')
			                		<li>
			                			<span>Shape</span>
			                			<span>: {{$diamond_details_value['attr_shape']}}</span>
			                		</li>
			                		@endif
			                		@if(isset($diamond_details_value['attr_diamond_caret']) ? $diamond_details_value['attr_diamond_caret'] : '')
			                		<li>
			                			<span>Carat</span>
			                			<span>: {{$diamond_details_value['attr_diamond_caret']}}</span>
			                		</li>
			                		@endif
			                		@if(isset($diamond_details_value['attr_clarity']) ? $diamond_details_value['attr_clarity'] : '')
			                		<li>
			                			<span>Clarity</span>
			                			<span>: {{$diamond_details_value['attr_clarity']}}</span>
			                		</li>
			                		@endif
			                		@if(isset($diamond_details_value['attr_cut']) ? $diamond_details_value['attr_cut'] : '')
			                		<li>
			                			<span>Cut</span>
			                			<span>: {{$diamond_details_value['attr_cut']}}</span>
			                		</li>
			                		@endif
			                		@if(isset($diamond_details_value['attr_setting']) ? $diamond_details_value['attr_setting'] : '')
			                		<li>
			                			<span>Setting</span>
			                			<span>: {{$diamond_details_value['attr_setting']}}</span>
			                		</li>
			                		@endif
			                		@if(isset($diamond_details_value['attr_total_diamond_count']) ? $diamond_details_value['attr_total_diamond_count'] : '')
			                		<li>
			                			<span>Total Diamond Count</span>
			                			<span>: {{$diamond_details_value['attr_total_diamond_count']}}</span>
			                		</li>
			                		@endif
			                		@if(isset($diamond_details_value['attr_total_diamond_wight']) ? $diamond_details_value['attr_total_diamond_wight'] : '')
			                		<li>
			                			<span>Total Diamond Weight</span>
			                			<span>: {{$diamond_details_value['attr_total_diamond_wight']}} Carat</span>
			                		</li>
			                		@endif
								

								@endforeach
		                	
							
                          </ul>
                        </div>
                      </div>
                    </div>
					@endif
					@endif
					@if(isset($product->gemstone_details) && $product->gemstone_details != "" && $product->gemstone_details != null)
					@php
			            $gemstone_details = json_decode($product->gemstone_details , true);
			        @endphp
			        
			        @php

    					if (!empty($product->gemstone_details) && ($product->gemstone_details[0] == '{' || $product->gemstone_details[strlen($product->gemstone_details) - 1] == '}')) {
    					    // Add [ at the start and ] at the end
    					    $product->gemstone_details = '[' . $product->gemstone_details . ']';
    					}
    					
    			        $gemstone_details = json_decode($product->gemstone_details, true);
    				        if($gemstone_details !== null && is_array($gemstone_details)) {
    				            $allBlankg = true;
    				            foreach($gemstone_details as $gem_s_detail) {
    				                if(is_array($gem_s_detail)) {
    				                    foreach($gem_s_detail as $key => $value) {
    				                        if (!empty($value)) {
    				                            $allBlankg = false;
    				                            break 2; 
    				                        }
    				                    }
    				                } else {
    				                    // Handle the case where $gem_s_detail is not a valid array
    				                    $allBlankg = false;
    				                    break; // Break the outer loop
    				                }
    				            }
    				        } 
    				@endphp
					
                    @if (isset($allBlankg) && !$allBlankg)
					<div class="accordion-item">
                      <h2 class="accordion-header" id="headinggemstone">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#geminfoCollapse" aria-expanded="false" aria-controls="geminfoCollapse">
                            Gemstone Information
                        </button>
                      </h2>
                      <div id="geminfoCollapse" class="accordion-collapse collapse" aria-labelledby="headinggemstone">
                        <div class="accordion-body">
                          <ul>
                           
                            @foreach($gemstone_details as $key => $gemstone_details_value) 
									
								@if(count($gemstone_details) > 1)
								<p class="hashtag">#{{$key+1}}</p>
								@endif
								@if(isset($gemstone_details_value['attr_gemstone_type']) ? $gemstone_details_value['attr_gemstone_type'] : '')
								<li>
		                			<span>Type</span>
		                			<span>: {{$gemstone_details_value['attr_gemstone_type']}}</span>
		                		</li>
		                		@endif
								@if(isset($gemstone_details_value['attr_gemstone_color']) ? $gemstone_details_value['attr_gemstone_color'] : '')
		                		<li>
		                			<span>Colour</span>
		                			<span>: {{$gemstone_details_value['attr_gemstone_color']}}</span>
		                		</li>
		                		@endif
		                		@if(isset($gemstone_details_value['attr_gemstone_gem']) ? $gemstone_details_value['attr_gemstone_gem'] : '')
		                		<li>
		                			<span>Gemstone</span>
		                			<span>: {{$gemstone_details_value['attr_gemstone_gem']}}</span>
		                		</li>
		                		@endif
		                		@if(isset($gemstone_details_value['attr_gemstone_shape']) ? $gemstone_details_value['attr_gemstone_shape'] : '')
		                		<li>
		                			<span>Shape</span>
		                			<span>: {{$gemstone_details_value['attr_gemstone_shape']}}</span>
		                		</li>
		                		@endif
		                		@if(isset($gemstone_details_value['attr_gemstone_caret']) ? $gemstone_details_value['attr_gemstone_caret'] : '')
		                		<li>
		                			<span>Carat</span>
		                			<span>: {{$gemstone_details_value['attr_gemstone_caret']}}</span>
		                		</li>
		                		@endif
		                		@if(isset($gemstone_details_value['attr_gemstone_clarity']) ? $gemstone_details_value['attr_gemstone_clarity'] : '')
		                		<li>
		                			<span>Clarity</span>
		                			<span>: {{$gemstone_details_value['attr_gemstone_clarity']}}</span>
		                		</li>
		                		@endif
		                		@if(isset($gemstone_details_value['attr_gemstone_cut']) ? $gemstone_details_value['attr_gemstone_cut'] : '')
		                		<li>
		                			<span>Cut</span>
		                			<span>: {{$gemstone_details_value['attr_gemstone_cut']}}</span>
		                		</li>
		                		@endif
		                		@if(isset($gemstone_details_value['attr_gemstone_setting']) ? $gemstone_details_value['attr_gemstone_setting'] : '')
		                		<li>
		                			<span>Setting</span>
		                			<span>: {{$gemstone_details_value['attr_gemstone_setting']}}</span>
		                		</li>
		                		@endif
		                		@if(isset($gemstone_details_value['attr_gemstone_total_gem_count']) ? $gemstone_details_value['attr_gemstone_total_gem_count'] : '')
		                		<li>
		                			<span>Total Gem Count</span>
		                			<span>: {{$gemstone_details_value['attr_gemstone_total_gem_count']}}</span>
		                		</li>
		                		@endif
		                		@if(isset($gemstone_details_value['attr_gemstone_total_wight']) ? $gemstone_details_value['attr_gemstone_total_wight'] : '')
		                		<li>
		                			<span>Total Gem Weight</span>
		                			<span>: {{$gemstone_details_value['attr_gemstone_total_wight']}} Carat</span>
		                		</li>
		                		@endif
							@endforeach
                          </ul>
                        </div>
                      </div>
                    </div>
                    
                    @endif
					@endif
					@if(isset($product->pearl_details) && $product->pearl_details != "" && $product->pearl_details != null)
					
    			        @php

    					if (!empty($product->pearl_details) && ($product->pearl_details[0] == '{' || $product->pearl_details[strlen($product->pearl_details) - 1] == '}')) {
    					    // Add [ at the start and ] at the end
    					    $product->pearl_details = '[' . $product->pearl_details . ']';
    					}
    					
    			        $pearl_details = json_decode($product->pearl_details, true);
    				        if($pearl_details !== null && is_array($pearl_details)) {
    				            $allBlankp = true;
    				            foreach($pearl_details as $pearl_s_detail) {
    				                if(is_array($pearl_s_detail)) {
    				                    foreach($pearl_s_detail as $key => $value) {
    				                        if (!empty($value)) {
    				                            $allBlankp = false;
    				                            break 2; 
    				                        }
    				                    }
    				                } else {
    				                    // Handle the case where $pearl_s_detail is not a valid array
    				                    $allBlankp = false;
    				                    break; // Break the outer loop
    				                }
    				            }
    				        } 
    				    @endphp
    				    
    				    @if (isset($allBlankp) && !$allBlankp)
    
    					<div class="accordion-item">
                          <h2 class="accordion-header" id="pearlHeading">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#pearlinfoCollapse" aria-expanded="false" aria-controls="pearlinfoCollapse">
                                Pearl Information
                            </button>
                          </h2>
                          <div id="pearlinfoCollapse" class="accordion-collapse collapse" aria-labelledby="pearlHeading">
                            <div class="accordion-body">
                              <ul>
    
                              	@foreach($pearl_details as $key => $pearl_details_value)
    						
    								@if(count($pearl_details) > 1)
    								<p class="hashtag">#{{$key+1}}</p>
    								@endif
    								@if(isset($pearl_details_value['attr_pearl_type']) ? $pearl_details_value['attr_pearl_type'] : '')
    		                		<li>
    		                			<span>Type</span>
    		                			<span>: {{$pearl_details_value['attr_pearl_type']}}</span>
    		                		</li>
    		                		@endif
    		                		@if(isset($pearl_details_value['attr_pearl_color']) ? $pearl_details_value['attr_pearl_color'] : '')
    		                		<li>
    		                			<span>Colour</span>
    		                			<span>: {{$pearl_details_value['attr_pearl_color']}}</span>
    		                		</li>
    		                		@endif
    		                		@if(isset($pearl_details_value['attr_pearl_gem']) ? $pearl_details_value['attr_pearl_gem'] : '')
    		                		<li>
    		                			<span>Pearl</span>
    		                			<span>: {{$pearl_details_value['attr_pearl_gem']}}</span>
    		                		</li>
    		                		@endif
    		                		@if(isset($pearl_details_value['attr_pearl_shape']) ? $pearl_details_value['attr_pearl_shape'] : '')
    		                		<li>
    		                			<span>Shape</span>
    		                			<span>: {{$pearl_details_value['attr_pearl_shape']}}</span>
    		                		</li>
    		                		@endif
    		                		@if(isset($pearl_details_value['attr_pearl_caret']) ? $pearl_details_value['attr_pearl_caret'] : '')
    		                		<li>
    		                			<span>Carat</span>
    		                			<span>: {{$pearl_details_value['attr_pearl_caret']}}</span>
    		                		</li>
    		                		@endif
    		                		@if(isset($pearl_details_value['attr_pearl_grade']) ? $pearl_details_value['attr_pearl_grade'] : '')
    		                		<li>
    		                			<span>Grade</span>
    		                			<span>: {{$pearl_details_value['attr_pearl_grade']}}</span>
    		                		</li>
    		                		@endif
    		                		@if(isset($pearl_details_value['attr_pearl_setting']) ? $pearl_details_value['attr_pearl_setting'] : '')
    		                		<li>
    		                			<span>Setting</span>
    		                			<span>: {{$pearl_details_value['attr_pearl_setting']}}</span>
    		                		</li>
    		                		@endif
    		                		@if(isset($pearl_details_value['attr_pearl_total_gem_count']) ? $pearl_details_value['attr_pearl_total_gem_count'] : '')
    		                		<li>
    		                			<span>Total Pearl Count</span>
    		                			<span>: {{$pearl_details_value['attr_pearl_total_gem_count']}}</span>
    		                		</li>
    		                		@endif
    		                		@if(isset($pearl_details_value['attr_pearl_total_wight']) ? $pearl_details_value['attr_pearl_total_wight'] : '')
    		                		<li>
    		                			<span>Total Pearl Weight</span>
    		                			<span>: {{$pearl_details_value['attr_pearl_total_wight']}} Carat</span>
    		                		</li>
    		                		@endif
    						
    							@endforeach
                                
                              </ul>
                            </div>
                          </div>
                        </div>
                        
                        @endif

					@endif
                    
                    @if(isset($product->p_description) && $product->p_description != "")
    				<div class="accordion-item">
                      <h2 class="accordion-header" id="moreinfo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#moreinfocollapse" aria-expanded="false" aria-controls="moreinfocollapse">
                            More Information
                        </button>
                      </h2>
                      <div id="moreinfocollapse" class="accordion-collapse collapse " aria-labelledby="moreinfo">
                        <div class="accordion-body">
                            {!!  html_entity_decode($product->p_description) !!}
                        </div>
                      </div>
                    </div>
					@endif
                </div>
                  
            </div>
            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 right-side">
                <div class="buy-confidence">
                    <p class="buy-confidence-text">Buy With Confidence</p>
                    @if(isset($setting->buy_with_confidence_sec) && $setting->buy_with_confidence_sec != '')
						@php
						   $icons = json_decode($setting->buy_with_confidence_sec, true);
						@endphp
					@endif
					@php
	                    $product_icons = isset($product) && is_object($product) && isset($product->buy_with_confidence_sec) ? json_decode($product->buy_with_confidence_sec, true) : [];
	                @endphp
					<div class="buy-confidence-inner">
						@if (!empty($product_icons) && array_filter($product_icons, function($icon) {
		                    return !empty($icon['title']) || !empty($icon['icon']);
		                }))
		                @foreach($product_icons as $icons_value)
						<div class="buy-confidence-box">
							<img src="{{ asset('product_media/product_icons/'.$icons_value['icon']) }}" alt="{{isset($icons_value['title']) ? $icons_value['title'] : '' }}" style="width: 34px; height: 34px;">
							<p>{{isset($icons_value['title']) ? $icons_value['title'] : '' }}</p>
						</div>
						@endforeach
						@else
    					@foreach($icons as $icons_value)
    					<div class="buy-confidence-box">
							<img src="{{ asset('uploads/images/'.$icons_value['icon']) }}" alt="{{isset($icons_value['title']) ? $icons_value['title'] : '' }}" style="width: 34px; height: 34px;">
							<p>{{isset($icons_value['title']) ? $icons_value['title'] : '' }}</p>
						</div>
    					@endforeach
    					@endif
					</div>

                </div>

                <div class="any-qtn">Any Questions?</div>
				<div class="c-inquiry">
					<span>For custom enquiry</span><span class="whatsapp-call">
						<img src="{{asset('front/src/images/whatsapp.svg')}}" alt="Whatsapp">
						<a target="_blank" href="https://api.whatsapp.com/send?phone=+{{$bs->country_code_number.''.$bs->whatsapp_number}}&text=Hi, Need more information, let's discuss. {{route('front.detail.products',['slug'=>$product->p_slug])}}">+{{$bs->country_code_number.''.$bs->whatsapp_number}}</a>
					</span>
				</div>
                 @if(isset($product->p_tags) && $product->p_tags != null && $product->p_tags != '')
                    @php
                        $p_tags = explode(',', $product->p_tags);

                        $products_with_tags = App\Models\Product::where(function($query) use ($p_tags) {
                            foreach ($p_tags as $tag) {
                                $query->orWhere('p_tags', 'LIKE', "%$tag%");
                            }
                        })->get();

                        $clickable_tags = $products_with_tags->flatMap(function ($product) {
                            return explode(',', $product->p_tags);
                        })->unique()->toArray();
                    @endphp
                @endif
                @if(isset($p_tags) && count($p_tags) > 0)
                    <div class="popular-design">
                        <h3>Popular Design Tags</h3>
                        <ul>
                            @foreach($p_tags as $tag)
                                @php
                                    $tag_slug = App\Models\Tags::where('name', $tag)->first();
                                    if(isset($tag_slug) && $tag_slug != null)
                                    {
                                    	$products = App\Models\Product::whereRaw("FIND_IN_SET(?, p_tags)", [$tag_slug->name])->where('visiblity',1)->where(function ($query) {
                      					$query->where('publish_status', '!=', 'draft')
                            			->orWhereNull('publish_status');
                 					})->get();
                                    }
                                    
                 	
                                @endphp
                                <li>
                                	@if(isset($products) && $products->count() > 0)
                                    <a @if(in_array($tag, $clickable_tags) && isset($tag_slug)) href="{{ route('front.tags', ['slug' => $tag_slug->slug]) }}" @endif class="keyword-btn">{{ $tag }}</a>
                                    @else
                                    <a class="keyword-btn no-link">{{ $tag }}</a>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>


@if(isset($similar_products) && count($similar_products) > 0)
    <div class="middle-section-of-all-product-part-2">
        <!-- NEW DESIGNS Section -->

        <section class="common-padding common-section most-popular-section product-box-section">
            <div class="container-md">

                <div class="row">
                    <h2>Similar Products</h2>
                     <a href="{{route('front.collection')}}" class="view-all" aria-label="view-all-link">View all</a>
                    <div class="product-carousel owl-loaded" id="similar-products-slider">
                        @foreach($similar_products as $products_value)
                        <div class="col-12 similar-each-product" data-product-type="{{ isset($products_value->is_public) && $products_value->is_public == 1 ? 'public' : 'private' }}">
                            <article>
                                <div class="product-images">
                                    @php
                                        if(isset($products_value) && $products_value->p_pricetype == 'dynamic')
                                        {
                                            $overall_discount_amount = $products_value->overall_discount($products_value->id,$products_value->total_price($products_value->id),$products_value->making_rate($products_value->id));
                                            $original_price = $products_value->total_price($products_value->id);
                                        }else{
                                            $overall_discount_amount = isset($products_value->p_discount) ? $products_value->p_discount : 0;
                                            $original_price = (isset($products_value->p_fix_price) ? floatval($products_value->p_fix_price) : 0) - $overall_discount_amount;
                                        } 
                                    @endphp
                                    @if(isset($overall_discount_amount) && $overall_discount_amount > 0 && $products_value->p_pricetype != 'no_price')
                                        @php
                                            $discounted_price = $overall_discount_amount + $products_value->total_price($products_value->id);
                                            $diff =  $discounted_price - $original_price ;
                                            $div = $diff / $original_price;
                                            $percentage = $div * 100;
                                        @endphp
                                        <div class="new-collections-tagline number-text">{{number_format($percentage,2)}}% OFF</div>
                                    @endif
                                    <a href="{{ route('front.detail.products',['slug' => $products_value->p_slug]) }}" aria-label="Product Image">
                                        @php
                                            $p_image = App\Models\ProductImage::where('product_id',$products_value->id)->first();
                                            if(isset($p_image->name) && $p_image->name != '' && $p_image->name != null)
                                            {
                                                if(isset($products_value->db_status) && $products_value->db_status != '' && $products_value->db_status != null && $products_value->db_status == 'manually')
                                                {
                                                    if (file_exists(public_path('product_media/product_images/' . $p_image->name))) {

                                                        $path = asset('product_media/product_images/'.$p_image->name);
                                                    }else{
                                                        $path = asset('assets/images/user/img-demo_1041.jpg');
                                                    }
                                                }else{
                                                   if (file_exists(public_path('uploads/' . $p_image->name))) {

                                                        $path = asset('uploads/'.$p_image->name);

                                                    }else{
                                                        $path = asset('assets/images/user/img-demo_1041.jpg');
                                                    }
                                                }
                                                
                                            }else{
                                                $path = asset('assets/images/user/img-demo_1041.jpg');
                                            }


                                        @endphp
                                        <img src="{{$path}}" class="img-fluid" loading="lazy" width="auto"
                                            height="auto" alt="Product Image">
                                    </a>
                                </div>
                                <div class="product-details-section">
                                    
                                    <div class="price-and-gram">
                                        @if($products_value->total_price($products_value->id) != '0.00')
                                        <div>
                                            <span class="price number-text">
                                                @if($products_value->total_price($products_value->id) != '0.00')
                                                    ₹ {{ number_format($products_value->total_price($products_value->id), 2, '.', ',') }}
                                                @endif
                                            </span>
                                            @if(isset($overall_discount_amount) && $overall_discount_amount > 0)
                                          
                                                @if(isset($overall_discount_amount) && $overall_discount_amount > 0)
                                                    <span class="discount-price number-text">₹ {{ number_format($overall_discount_amount + $products_value->total_price($products_value->id), 2, '.', ',') }}</span>
                                                @endif
                                                
                                            @endif
                                        </div>
                                        @endif

                                        @if(isset($products_value->p_gross_weight) && $products_value->p_gross_weight != null && $products_value->p_gross_weight > 0)
                                            <span class="gram number-text">
                                                {{ isset($products_value->p_gross_weight) ? $products_value->p_gross_weight : '' }} 
                                                @if(isset($products_value->p_gross_weight) && $products_value->p_gross_weight != '') 
                                                    {{ isset($products_value->p_gross_weight_unit) ? $products_value->p_gross_weight_unit : '' }} 
                                                @endif
                                            </span>
                                        @endif
                                    </div>
                                    <div class="product-action-section">
                                        <a onclick="addToWishlist('{{$products_value->id}}','{{$products_value->p_title}}','{{$products_value->p_slug}}','','{{ $products_value->p_grand_price_total }}','simple');" aria-label="Whishlist" class="whishlist">
                                            <img src="{{ asset('front/src/images/wishlist-icon.svg') }}" width="18" height="18">
                                        </a>
                                        
                                        @if(isset($products_value->p_status) && $products_value->p_status != null && $products_value->p_status == 'by_order')

                                            <a onclick="addToCart('{{$products_value->id}}','{{$products_value->p_title}}','{{$products_value->p_grand_price_total}}',null,'','simple');" aria-label="Shop Now" class="shop-now desktop-show-now"><span class="shop-now-span">Shop Now</span></a>
                                            <a onclick="addToCart('{{$products_value->id}}','{{$products_value->p_title}}','{{$products_value->p_grand_price_total}}',null,'','simple');" aria-label="Shop Now" class="shop-now mobile-show-now">
                                            <img src="{{ asset('front/src/images/p-cart.svg') }}" width="18" height="18"></a>

                                        @elseif(isset($products_value->p_status) && $products_value->p_status != '' && $products_value->p_status != null && $products_value->p_status == 'ready_stock')

                                            @if((isset($products_value->p_avail_stock_qty) && $products_value->p_avail_stock_qty != 0 && $products_value->p_avail_stock_qty != '') || $products_value->p_avail_stock_qty == null)
                                                <a onclick="addToCart('{{$products_value->id}}','{{$products_value->p_title}}','{{$products_value->p_grand_price_total}}',null,'','simple');" aria-label="Shop Now" class="shop-now desktop-show-now"><span class="shop-now-span">Shop Now</span></a>
                                                <a onclick="addToCart('{{$products_value->id}}','{{$products_value->p_title}}','{{$products_value->p_grand_price_total}}',null,'','simple');" aria-label="Shop Now" class="shop-now mobile-show-now"><img src="{{ asset('front/src/images/p-cart.svg') }}" width="18" height="18"></a>
                                            @else
                                                <a class="shop-now desktop-show-now"><span class="shop-now-span" style="color:red">OUT OF STOCK</span></a>
                                                <a class="shop-now mobile-show-now"><img src="{{ asset('front/src/images/notcart.svg') }}" width="18" height="18"></a>
                                            @endif

                                        @endif
                                        <a onclick="share_model('{{$products_value->id}}','product')" aria-label="Share Product" class="add-to-cart">
                                            <img src="{{ asset('front/src/images/share-btn-icon.svg') }}" width="18" height="18">
                                        </a>                                        </div>
                                </div>
                            </article>
                        </div>
                        @endforeach
           
                    </div>
                </div>
            </div>
        </section>
          
    </div>
 @endif

<input type="hidden" id="product-detail-type" value="{{ isset($product->is_public) && $product->is_public == 1 ? 'public' : 'private' }}">
@endsection
@section('script')
<script src="https://www.royalediamonds.com/front/theme2/js/Drift.min.js"></script>
<script>
	$(document).ready(function () {
		var scrrenWidth = $(document).width();
		if (scrrenWidth > 768) {
			$('.demo-trigger').each(function () {
				var demoTrigger = this;
				var paneContainer = document.querySelector('.sync1');

				new Drift(demoTrigger, {
					paneContainer: paneContainer,
					inlinePane: false,
					zoomFactor: 2.5
				});
			});
		}

	});
	$(document).ready(function () {
		$('#accordion').on('show.bs.collapse', function () {
			$('.accordion_show').show();
			$('.accordion_hide').hide();
		});

		$('#accordion').on('hide.bs.collapse', function () {
			$('.accordion_show').hide();
			$('.accordion_hide').show();
		});
		// specification
		$('#accordion_spe').on('show.bs.collapse', function () {
			$('.accordion_show_spe').show();
			$('.accordion_hide_spe').hide();
		});

		$('#accordion_spe').on('hide.bs.collapse', function () {
			$('.accordion_show_spe').hide();
			$('.accordion_hide_spe').show();
		});
		// metal
		$('#accordion_metal').on('show.bs.collapse', function () {
			$('.accordion_show_metal').show();
			$('.accordion_hide_metal').hide();
		});

		$('#accordion_metal').on('hide.bs.collapse', function () {
			$('.accordion_show_metal').hide();
			$('.accordion_hide_metal').show();
		});
		// Diamond
		$('#accordion_diamond').on('show.bs.collapse', function () {
			$('.accordion_show_dia').show();
			$('.accordion_hide_dia').hide();
		});

		$('#accordion_diamond').on('hide.bs.collapse', function () {
			$('.accordion_show_dia').hide();
			$('.accordion_hide_dia').show();
		});
		// gemstone
		$('#accordion_gemstone').on('show.bs.collapse', function () {
			$('.accordion_show_gem').show();
			$('.accordion_hide_gem').hide();
		});

		$('#accordion_gemstone').on('hide.bs.collapse', function () {
			$('.accordion_show_gem').hide();
			$('.accordion_hide_gem').show();
		});
		// pearl
		$('#accordionpearl').on('show.bs.collapse', function () {
			$('.accordion_show_pearl').show();
			$('.accordion_hide_pearl').hide();
		});

		$('#accordionpearl').on('hide.bs.collapse', function () {
			$('.accordion_show_pearl').hide();
			$('.accordion_hide_pearl').show();
		});
	});
	
</script>
<script>
	$(document).on("click",".qty_increase",function() {
		var qty = parseInt($('#product_qty').val()) || 0;
		var available = parseInt($('#available_qty').val()) || 0;
		var final_available_qty = parseInt($('#final_available_qty').val()) || 0;
		if(final_available_qty)
		{
			if(final_available_qty > qty)
			{
				qty++;
				available--;
				$('#product_qty').val(qty);
				$('#available_qty').val(available);
			}else {
	            Swal.fire("Error", "Quantity cannot exceed available stock quantity!", "error");
	        }
		}else{
				qty++;
				available--;
				$('#product_qty').val(qty);
				$('#available_qty').val(available);
		}
		
	});
	$(document).on("click",".qty_decrease",function() {	
		var qty = parseInt($('#product_qty').val()) || 0;
		var available = parseInt($('#available_qty').val()) || 0;
		var max_available = parseInt('{{ isset($product->p_avail_stock_qty) ? $product->p_avail_stock_qty : '' }}') || 0;
			qty--;
			available++;
			qty = Math.max(qty, 1);
    		if (available > max_available) {
		        available = max_available;
		    }
			$('#product_qty').val(qty);
			$('#available_qty').val(available);
	});
</script>
<script>
	$(document).on("click","#check_pin_code",function() {
	var pincode = $('#pincode_check').val();
		if(pincode == '' || pincode == null || !/^\d+$/.test(pincode))
		{
			$('#pincode_string').removeClass('pinst_st');
			$('#pincode_error').text('PLEASE ENTER A VALID PINCODE');
			$('#pincode_string').text('');
		}else{
			$('#pincode_error').text('');
			$('#pincode_string').addClass('pinst_st');
			$('#pincode_string').html('<i class="fa fa-spinner fa-spin" style="font-size:24px;" id="loader_zipcode"></i>');
			// $('#loader_zipcode').show();
			$.ajax({
		        url: '{{route('front.pincode.check')}}',
		        type: 'POST',
		        data: {
		            'pincode': pincode,
		            '_token': $('meta[name="csrf-token"]').attr('content'),
		        },
		        success: function (response) {
		        	// $('#pincode_string').html('');
		        	$('#pincode_string').addClass('pinst_st');
		            if (response.status == 1) {
		                $('#pincode_string').text(response.string);
		            } else {
		                $('#pincode_string').text(response.message);
		            }
		        }
		    });
		}	
	});
	$(document).on("change",".select_attribute",function() {
		var compulsory = $(this).data('selected');
		var size = $("input[type='radio'][name='all_sizes']:checked").val();
		var gender = $("input[type='radio'][name='all_genders']:checked").val();
		var metal_weight = $("input[type='radio'][name='all_metal_weigts']:checked").val();
		var metal_purity = $("input[type='radio'][name='all_metal_purity']:checked").val();
		var metal_color = $("input[type='radio'][name='all_metal_color']:checked").val();
		var diamond_clarity = $("input[type='radio'][name='all_diamond_clarity']:checked").val();
		$.ajax({
			url: '{{route('front.fetch.variant')}}',
			type: 'POST',
			data: {
				'main_parent_id': '{{ $main_parent_id ?? null }}',
				'size': size,
				'gender': gender,
				'metal_weight': metal_weight,
				'metal_purity': metal_purity,
				'metal_color': metal_color,
				'diamond_clarity' : diamond_clarity,
				'compulsory': compulsory,
				'_token': $('meta[name="csrf-token"]').attr('content'),
			},
			success: function (response) {
				if (response.status == 1) {
					var redirectUrl = "{{ route('front.detail.products', ['slug' => ':slug']) }}";
					redirectUrl = redirectUrl.replace(':slug', response.slug);
					if (redirectUrl === window.location.href) {
						if(compulsory == 'diamond_clarity')
						{
							$("label[for^='diamond_clarity_']").removeClass('active');
							$("input[type='radio'][name='all_diamond_clarity']").prop('checked', false);
							$("input[type='radio'][name='all_diamond_clarity'][value='" + diamond_clarity + "']").prop('checked', true);	
							$("#diamond_clarity_" + diamond_clarity + "").addClass('active');
						}
					} else {
						window.location.href = redirectUrl;
					}
				} 
			}
		});
	});
</script>

<script type="text/javascript">

	$(document).ready(function() {
  var bigimage = $("#big");
  var thumbs = $("#thumbs");
  //var totalslides = 10;
  var syncedSecondary = true;

  bigimage
    .owlCarousel({
    items: 1,
    slideSpeed: 2000,
    nav: true,
    autoplay: true,
    dots: false,
    loop: true,
    responsiveRefreshRate: 200,
    navText: [
      '<i class="fa fa-arrow-left" aria-hidden="true"></i>',
      '<i class="fa fa-arrow-right" aria-hidden="true"></i>'
    ]
  })
    .on("changed.owl.carousel", syncPosition);

  thumbs
    .on("initialized.owl.carousel", function() {
    thumbs
      .find(".owl-item")
      .eq(0)
      .addClass("current");
  })
    .owlCarousel({
    items: 4,
    dots: true,
    nav: true,
    navText: [
      '<i class="fa fa-arrow-left" aria-hidden="true"></i>',
      '<i class="fa fa-arrow-right" aria-hidden="true"></i>'
    ],
    smartSpeed: 200,
    slideSpeed: 500,
    slideBy: 4,
    responsiveRefreshRate: 100
  })
    .on("changed.owl.carousel", syncPosition2);

  function syncPosition(el) {
    //if loop is set to false, then you have to uncomment the next line
    //var current = el.item.index;

    //to disable loop, comment this block
    var count = el.item.count - 1;
    var current = Math.round(el.item.index - el.item.count / 2 - 0.5);

    if (current < 0) {
      current = count;
    }
    if (current > count) {
      current = 0;
    }
    //to this
    thumbs
      .find(".owl-item")
      .removeClass("current")
      .eq(current)
      .addClass("current");
    var onscreen = thumbs.find(".owl-item.active").length - 1;
    var start = thumbs
    .find(".owl-item.active")
    .first()
    .index();
    var end = thumbs
    .find(".owl-item.active")
    .last()
    .index();

    if (current > end) {
      thumbs.data("owl.carousel").to(current, 100, true);
    }
    if (current < start) {
      thumbs.data("owl.carousel").to(current - onscreen, 100, true);
    }
  }

  function syncPosition2(el) {
    if (syncedSecondary) {
      var number = el.item.index;
      bigimage.trigger('to.owl.carousel', number);
    }
  }

  thumbs.on("click", ".owl-item", function(e) {
    e.preventDefault();
    var number = $(this).index();
    bigimage.trigger('to.owl.carousel', number);
  });
});


      $(document).ready(function() { 
  var i = 0;
  $('.sync1').each(function (bigId, smallId) {
    i++;
    // bigId = $(this).attr('id');
    bigId = 'syncbig' + i;
    smallId =  'syncsmall' + i;


    var sync1 = $("#" + bigId);
    var sync2 = $("#" + smallId);
//setTimeout(() => {
  var slidesPerPage = 4; //globaly define number of elements per page
  var syncedSecondary = true;

  sync1.owlCarousel({
    items : 1,
    slideSpeed : 5000,
    nav: true,
    autoplay: true,
    dots: true,
    loop: true,
    responsiveRefreshRate : 200,
    navText: ['<svg width="100%" height="100%" viewBox="0 0 11 20"><path style="fill:none;stroke-width: 1px;stroke: #000;" d="M9.554,1.001l-8.607,8.607l8.607,8.606"/></svg>','<svg width="100%" height="100%" viewBox="0 0 11 20" version="1.1"><path style="fill:none;stroke-width: 1px;stroke: #000;" d="M1.054,18.214l8.606,-8.606l-8.606,-8.607"/></svg>'],
  }).on('changed.owl.carousel', syncPosition);

  sync2
    .on('initialized.owl.carousel', function () {
      sync2.find(".owl-item").eq(0).addClass("current");
    })
    .owlCarousel({
    items : slidesPerPage,
    dots: true,
    nav: true,
    smartSpeed: 200,
    slideSpeed : 5000,
    slideBy: slidesPerPage, //alternatively you can slide by 1, this way the active slide will stick to the first item in the second carousel
    responsiveRefreshRate : 100,
    navText: ['<i class="fa fa-angle-left" aria-hidden="true"></i>','<i class="fa fa-angle-right" aria-hidden="true"></i>'],
  }).on('changed.owl.carousel', syncPosition2);

  function syncPosition(el) {
    //if you set loop to false, you have to restore this next line
    //var current = el.item.index;
    
    //if you disable loop you have to comment this block
    var count = el.item.count-1;
    var current = Math.round(el.item.index - (el.item.count/2) - .5) + 1;

    if(current < 0) {
      current = count;
    }
    if(current > count){
      current = 0;
    }
    
    //end block

    sync2
      .find(".owl-item")
      .removeClass("current")
      .eq(current)
      .addClass("current");
    var onscreen = sync2.find('.owl-item.active').length -1 ;
    var start = sync2.find('.owl-item.active').first().index();
    var end = sync2.find('.owl-item.active').last().index();

    if (current > end) {
      sync2.trigger('to.owl.carousel', current);
    }
    if (current < start) {
      sync2.trigger('to.owl.carousel', current - onscreen);
    }
  }
  
  function syncPosition2(el) {
  
    if(syncedSecondary) {
      var number = el.item.index;
      //sync1.data('owl.carousel').to(number, 100, true);
      //sync1.trigger("owl.goTo",number);
      sync1.trigger('to.owl.carousel', number);
    }
  }
  
  sync2.on("click", ".owl-item", function(e){
    e.preventDefault();
    var number = $(this).index();
    sync1.trigger('to.owl.carousel', number);
    sync2.find(".owl-item").removeClass("current");
    sync2.find(".owl-item").eq(number).addClass("current");
    sync2.find(".owl-item").eq(number).find('.thumbnail').addClass("active");
    syncPosition2(number);
  });
    
 
});
  });

    </script>
@if (isset($bs->facebook_pixel_id) &&
            !empty($bs->facebook_pixel_id) &&
            $bs->advance_analytics == 'Yes')
        @include('front.partials.analytics.TrackEvents.facebook.view_page')
    @endif
    @if (isset($bs->google_analytics_id) &&
            !empty($bs->google_analytics_id) &&
            $bs->advance_analytics == 'Yes')
        @include('front.partials.analytics.TrackEvents.google.view_page')
    @endif
@endsection
