@extends('layouts.backend.index')
@section('main_content')

<style>
	.delivery-option-field-add-more-btn{
		position: absolute;
		top: 2px;
		left: 45%;
		background-color: var(--theme-orange-red);
		color: #40404c !important;
		padding: 4px 11px;
		font-size: 13px;
		line-height: normal;
		border: 1px solid var(--theme-orange-red);
		font-weight: 600;
	}
.last_add_div a{color: #000 !important;font-size: 35px;cursor: pointer;}
</style>

<div class="pcoded-wrapper add-product-step-form-sec">
	<div class="pcoded-content">
		<div class="pcoded-inner-content">
			<div class="custom_breadcum">
				<ul>
					<li class="breadcum-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
					<li class="breadcum-item"><a href="{{route('setting_all.index')}}">Settings</a></li>
					<li class="breadcum-item"><a href="{{route('global_settings.index')}}">Global Settings</a></li>
					<li class="breadcum-item active"><a href="javascript:;"> Shipping </a></li>
				</ul>
			</div>

			<div class="main-body">
				<div class="page-wrapper">
					<form action="{{ route('delivery_option.save') }}" method="POST" data-parsley-validate="" enctype="multipart/form-data">
						@csrf
						<div class="row">
							<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 cpl-sm-12 col-xs-12">
								<div class="Recent-Users">
									<h5>Delivery Option</h5>

									<div class="">
										<div id="delivery_all_div">
											
											<input type="hidden" name="del_counter" id="del_counter" value="{{ isset($data) && count($data) > 0 ? count($data) : 1 }}">
											@if(isset($data) && count($data) > 0)
											@php
												$counter = 1;
											@endphp
											@foreach($data as $key => $item)
												@include('delivery_option.delivery_sec')
												@php
													$counter++
												@endphp
											@endforeach
											@else
											<div class="delivery-field-sec">
												<div class="row delivery-field-sec-row">
													<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
														<div class="form-sec">
															<label for="">Country <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select Country"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
															<select name="p_deliver_contry[1][]" class="form-control delivery_country select2">
																<option selected="" disabled>Select Country
																</option>
																@if(isset($countries) && count($countries) > 0)
																@foreach($countries as $country)
																<option value="{{ $country->id }}" {{ isset($product->p_made_in) && $product->p_made_in == $country->id ? 'selected' : ''}}>{{ isset($country->name) ? $country->name : '' }}</option>
																@endforeach
																@endif
															</select>
														</div>
													</div>

													<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
														<div class="form-sec state_sec">
															<label for="">State (Multiple) <span data-bs-toggle="tooltip" data-bs-placement="right" title="You can select multiple States"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
															<select name="p_deliver_state[1][]" class="form-control delivery_state select2" multiple>

															</select>
														</div>
													</div>
													<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
														<div class="form-sec city_sec">
															<label for="">City (Multiple) <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please Select Any City"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
															<select name="p_deliver_city[1][]" class="form-control delivery_city select2" multiple>

															</select>
														</div>
													</div>

													<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
														<div class="form-sec zip_sec">
															<label for="">Post Code / Zip Code (Multiple) <span data-bs-toggle="tooltip" data-bs-placement="right" title="You can select multiple Zipcodes"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
															<select name="p_deliver_code[1][]" class="form-control select2 delivery_zip" multiple>

															</select>
														</div>
													</div>

													<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
														<div class="form-sec">
															<label for="">Processing Time <span data-bs-toggle="tooltip" data-bs-placement="right" title="Mention Total no of days for Shipping estimation"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
															<input type="text" class="form-control" name="p_deliver_duration[1][]" id="" placeholder="Enter Processing Time" value="">
														</div>
													</div>

													<h5>Shipping Calculation</h5>
													<div class="">
														<div class="row delivery-field-sec-row">
															<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
																<div class="form-sec">
																	 <label for=""></label>
																	<div class="radio-options">
																		<label class="radio-inline">
																			<input type="radio" name="shipping_type_1[]" class="shipping_type" value="fixed" >Fixed
																		</label>
																		<label class="radio-inline">
																			<input type="radio" name="shipping_type_1[]" class="shipping_type" value="on_price" >On Price
																		</label>
																		<label class="radio-inline">
																			<input type="radio" name="shipping_type_1[]" class="shipping_type" value="on_weight" >On Weight
																		</label>
																	</div>
																</div>
															</div>
															<div id="fixed_charge" class="fixed_charge">
																<div class="row">
																	<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
																		<div class="form-sec">
								                                             <label for="">Shipping Charges <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter Shipping Charges"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
								                                             <input type="number" class="form-control" name="fixed_shipping_charge_1[]" id="" placeholder="Enter Shipping Charges" value="" data-parsley-group="block-0" step="0.0001">
								                                        </div>
																	</div>
																</div>
															</div>
															<div id="on_price_charge" class="on_price_charge">
																
																<div class="row each-ship-price-row">
																	<input type="hidden" value="yes" name="price_hidden_1[]">
																	<div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
																		<div class="form-sec">
								                                             <label for="">From <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter From Amount"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
								                                             <input type="number" class="form-control" name="price_from_amount_1[]" id="" placeholder="Enter From Amount" value="" data-parsley-group="block-0" step="0.0001">
								                                        </div>
																	</div>
																	<div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
																		<div class="form-sec">
								                                             <label for="">To <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter To Amount"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
								                                             <input type="number" class="form-control" name="price_to_amount_1[]" id="" placeholder="Enter To Amount" value="" data-parsley-group="block-0" step="0.0001">
								                                        </div>
																	</div>
																	<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">
																		<div class="form-sec">
								                                             <label for="">Shipping Charges <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter Shipping Charges"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
								                                             <input type="number" class="form-control" name="price_shipping_charge_1[]" id="" placeholder="Enter Shipping Charges" value="" data-parsley-group="block-0" step="0.0001">
								                                        </div>
																	</div>
																	<div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12 last_add_div">
																		<label for=""></label>
																		<a><span class="add_charge_amount" data-counter="1"><i class='fas fa-plus-circle'></i></span></a>
																	</div>
																</div>
																
																<div id="amout_ship_div" class="amout_ship_div"></div>
																<div class="row">
																	<div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
																		<div class="form-sec">
								                                             <label for="">From Amount Above <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter From Amount Above"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
								                                             <input type="number" class="form-control" name="price_above_amount_1[]" id="" placeholder="Enter From Amount Above" value="{{ isset($product->price_above_amount) ? $product->price_above_amount : '' }}" data-parsley-group="block-0" step="0.0001">
								                                        </div>
																	</div>
																	<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">
																		<div class="form-sec">
								                                             <label for="">Shipping Charges <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter Shipping Charges"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
								                                             <input type="number" class="form-control" name="price_above_shipping_charge_1[]" id="" placeholder="Enter Shipping Charges" value="{{ isset($product->	price_above_shipping_charge) ? $product->	price_above_shipping_charge : '' }}" data-parsley-group="block-0" step="0.0001">
								                                        </div>
																	</div>
																</div>
															</div>
															<div id="on_weight_charge" class="on_weight_charge">
																
																<div class="row each-ship-weight-row">
																	<input type="hidden" value="yes" name="weight_hidden_1[]">
																	<div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
																		<div class="form-sec">
								                                             <label for="">From <span data-bs-toggle="tooltip" data-bs-placement="right" title="Enter Weight in Grams"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
								                                             <input type="number" class="form-control" name="weight_from_amount_1[]" id="" placeholder="Enter From Weight" value="" data-parsley-group="block-0" step="0.0001">
								                                        </div>
																	</div>
																	<div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
																		<div class="form-sec">
								                                             <label for="">To <span data-bs-toggle="tooltip" data-bs-placement="right" title="Enter Weight in Grams"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
								                                             <input type="number" class="form-control" name="weight_to_amount_1[]" id="" placeholder="Enter To Weight" value="" data-parsley-group="block-0" step="0.0001">
								                                        </div>
																	</div>
																	<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">
																		<div class="form-sec">
								                                             <label for="">Shipping Charges <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter Shipping Charges"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
								                                             <input type="number" class="form-control" name="weight_shipping_charge_1[]" id="" placeholder="Enter Shipping Charges" value="" data-parsley-group="block-0" step="0.0001" >
								                                        </div>
																	</div>
																	<div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12 last_add_div">
																		<label for=""></label>
																		<a><span class="add_weight_amount" data-counter="1"><i class='fas fa-plus-circle'></i></span></a>
																	</div>
																</div>
																<div id="amout_weight_div" class="amout_weight_div"></div>
																<div class="row">
																	<div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
																		<div class="form-sec">
								                                             <label for="">From weight Above <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter From weight Above"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
								                                             <input type="number" class="form-control" name="weight_above_amount_1[]" id="" placeholder="Enter From weight Above" value="{{ isset($product->weight_above_amount) ? $product->weight_above_amount : '' }}" data-parsley-group="block-0" step="0.0001">
								                                        </div>
																	</div>
																	<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">
																		<div class="form-sec">
								                                             <label for="">Shipping Charges <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter Shipping Charges"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
								                                             <input type="number" class="form-control" name="weight_above_shipping_charge_1[]" id="" placeholder="Enter Shipping Charges" value="{{ isset($product->weight_above_shipping_charge) ? $product->weight_above_shipping_charge : '' }}" data-parsley-group="block-0" step="0.0001">
								                                        </div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
											@endif
										</div>

										<div class="row add-more-row-sec">
											<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
												<hr>
												<a type="button" class="add-more-btn delivery-option-field-add-more-btn"><i class="fa fa-plus" aria-hidden="true"></i> Add More</a>
											</div>
										</div>
										
										<div class="row">
											<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
												<button type="submit" id="submit_form" class="common-sub-btn">Save</button>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>        	
					</form>
				</div>
			</div>    	
		</div>
	</div>
</div>

@endsection
@section('script')

<script>
	$(document).ready(function () {

		@if(isset($data) && $data != null)
		@foreach($data as $key => $delivery)
		var country = '{{$delivery->country}}';
		$("#del_state_{{$key+1}}").html('');
		$.ajax({
			url: "{{route('business.get_state')}}",
			type: "POST",
			data: {
				country: country,
				_token: '{{csrf_token()}}'
			},
			dataType: 'json',
			success: function(result) {
				$('#del_state_{{$key+1}}').html('<option value="">Select State</option>');
				var state_ids = '{{$delivery->state}}'.split(',');
				$.each(result.state, function(key, value) {
					var selected = state_ids.includes(value.id.toString()) ? 'selected' : '';
					$("#del_state_{{$key+1}}").append('<option value="' + value.id + '" ' + selected + '>' + value.name + '</option>');
				});
			}
		});
		@endforeach
		@endif


		@if(isset($data) && $data != null)
		@foreach($data as $key => $delivery)
		var state = '{{$delivery->state}}'.split(',');
		$("#del_city_{{$key+1}}").html('');
		$.ajax({
			url: admin_url +"get-deliver-city",
			type: "POST",
			data: {
				state: state,
				_token: '{{csrf_token()}}'
			},
			dataType: 'json',
			success: function(result) {
				$('#del_city_{{$key+1}}').html('<option value="">Select city</option>');
				var city_ids = '{{$delivery->city}}'.split(',');
				$.each(result.city, function(key, value) {
					var selected = city_ids.includes(value.id.toString()) ? 'selected' : '';
					$("#del_city_{{$key+1}}").append('<option value="' + value.id + '" ' + selected + '>' + value.name + '</option>');
				});
			}
		});
		@endforeach
		@endif
		@if(isset($data) && $data != null)
		@foreach($data as $key => $delivery)
		var city = '{{$delivery->city}}'.split(',');
		$("#del_code_{{$key+1}}").html('');
		$.ajax({
			url: admin_url +"get-deliver-zip",
			type: "POST",
			data: {
				city: city,
				_token: '{{csrf_token()}}'
			},
			dataType: 'json',
			success: function(result) {
				$('#del_code_{{$key+1}}').html('<option value="">Select Code</option>');
				var code_ids = '{{$delivery->code}}'.split(',');
				$.each(result.zip, function(key, value) {
					var selected = code_ids.includes(value.id.toString()) ? 'selected' : '';
					$("#del_code_{{$key+1}}").append('<option value="' + value.id + '" ' + selected + '>' + value.code + '</option>');
				});
			}
		});
		@endforeach
		@endif







// $(document).on("click", ".delivery-option-field-add-more-btn", function() {
	$(".delivery-option-field-add-more-btn").click(function() {
		var counter = $('#del_counter').val();
		$.ajax({
			url: admin_url +"get-deliver-data-global",
			type: "POST",
			data: {
				counter: parseInt(counter) + 1,
				_token: $('meta[name="csrf-token"]').attr('content'),
			},
			dataType: 'json',
			success: function(result) {

				if(result.status == 1)
				{
					$('#del_counter').val(result.counter);
					$("#delivery_all_div").append(result.html);
				}
				$('.select2').select2({
					placeholder: "Select"
				});
			}
		});
            // var field = '<div class="delivery-field-sec mt-4"><div class="row delivery-field-sec-row"><a><span class="remove_deliver_sec"><i class="fa fa-times-circle"></i></span></a><div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12"><div class="form-sec"><label for="">Country <span data-bs-toggle="tooltip" data-bs-placement="right" title="Dummy information text"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label><select name="dCountry" class="form-control"><option selected="" disabled>Select Country</option><option value="Option 1"> Option 1</option><option value="Option 2">Option 2</option></select></div></div><div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12"><div class="form-sec"><label for="">State (Multiple) <span data-bs-toggle="tooltip" data-bs-placement="right" title="Dummy information text"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label><select name="dState" class="form-control"><option selected="" disabled>Select State</option><option value="Option 1"> Option 1</option><option value="Option 2">Option 2</option></select></div></div><div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12"><div class="form-sec"><label for="">Post Code / Zip Code (Multiple) <span data-bs-toggle="tooltip" data-bs-placement="right" title="Dummy information text"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label><select name="dPost Code" class="form-control"><option selected="" disabled>Enter Duration / Days</option><option value="Option 1"> Option 1</option><option value="Option 2">Option 2</option></select></div></div><div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12"><div class="form-sec"><label for="">Duration / Days <span data-bs-toggle="tooltip" data-bs-placement="right" title="Dummy information text"><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label><select name="dDuration" class="form-control"><option selected="" disabled>Enter Duration / Days</option><option value="Option 1"> Option 1</option><option value="Option 2">Option 2</option></select></div></div></div></div>';
            // $("#delivery_all_div").append(field);
        });
});

$(document).on("click", ".remove_deliver_sec", function() {
	$(this).closest('.delivery-field-sec').remove();
});


$(document).on("change", ".delivery_country", function() {
	var country = this.value;
	var stateContainer = $(this).closest('.col-xxl-6').next('.col-xxl-6').find('.state_sec .delivery_state');
	stateContainer.html('');
          // $("#state").html('');
          $.ajax({
          	url: admin_url +"get-state",
          	type: "POST",
          	data: {
          		country: country,
          		_token: $('meta[name="csrf-token"]').attr('content'),
          	},
          	dataType: 'json',
          	success: function(result) {

          		stateContainer.html('<option value="">Select State</option>');
          		$.each(result.state, function(key, value) {
          			stateContainer.append('<option value="' + value.id + '">' + value.name + '</option>');
          		});

          	}
          }); 
      });

$(document).on("change", ".delivery_state", function() {
	var state = $(this).val();
	var zipContainer = $(this).closest('.col-xxl-6').next('.col-xxl-6').find('.city_sec .delivery_city');
	zipContainer.html('');
          // $("#state").html('');
          $.ajax({
          	url: admin_url +"get-deliver-city",
          	type: "POST",
          	data: {
          		state: state,
          		_token: $('meta[name="csrf-token"]').attr('content'),
          	},
          	dataType: 'json',
          	success: function(result) {
          		if(result.status == 1)
          		{
          			zipContainer.html('<option value="">Select city</option>');
          			$.each(result.city, function(key, value) {
          				zipContainer.append('<option value="' + value.id + '">' + value.name + '</option>');
          			}); 
          		}


          	}
          }); 
      });  
$(document).on("change", ".delivery_city", function() {
	var city = $(this).val();
	var zipContainer = $(this).closest('.col-xxl-6').next('.col-xxl-6').find('.zip_sec .delivery_zip');
	zipContainer.html('');
          // $("#state").html('');
          $.ajax({
          	url: admin_url +"get-deliver-zip",
          	type: "POST",
          	data: {
          		city: city,
          		_token: $('meta[name="csrf-token"]').attr('content'),
          	},
          	dataType: 'json',
          	success: function(result) {
          		if(result.status == 1)
          		{
          			zipContainer.html('<option value="">Select Zip Code</option>');
          			$.each(result.zip, function(key, value) {
          				zipContainer.append('<option value="' + value.id + '">' + value.code + '</option>');
          			}); 
          		}


          	}
          }); 
      });   
  </script>

 <script>
 	$(document).on("change", ".shipping_type", function() {
 		var value = $(this).val();
 		var fix_div = $(this).closest('.delivery-field-sec').find('.fixed_charge');
 		var on_price_div = $(this).closest('.delivery-field-sec').find('.on_price_charge');
 		var on_weight_div = $(this).closest('.delivery-field-sec').find('.on_weight_charge');
 		if(value == 'fixed')
 		{
 			fix_div.show();
 			on_price_div.hide();
 			on_weight_div.hide();
 		}
 		if(value == "on_price")
 		{
 			fix_div.hide();
 			on_price_div.show();
 			on_weight_div.hide();
 		}
 		if(value == "on_weight")
 		{
 			fix_div.hide();
 			on_price_div.hide();
 			on_weight_div.show();
 		}
 	});

 	$(document).on("click", ".add_charge_amount", function() {
 		var t_counter = $(this).data('counter');
 		var s_html = '<div class="row each-ship-price-row"><input type="hidden" value="yes" name="price_hidden_'+ t_counter +'[]"><div class="col-sm-12 col-xs-12 col-lg-3 col-md-3 col-xl-3 col-xxl-3"><div class=form-sec><label for="">From <span data-bs-placement=right data-bs-toggle=tooltip title="Please enter From Amount"><i class="fa fa-info-circle"aria-hidden=true></i></span></label> <input class=form-control data-parsley-group=block-0 name=price_from_amount_'+ t_counter +'[] placeholder="Enter From Amount"type=number step="0.0001"></div></div><div class="col-sm-12 col-xs-12 col-lg-3 col-md-3 col-xl-3 col-xxl-3"><div class=form-sec><label for="">To <span data-bs-placement=right data-bs-toggle=tooltip title="Please enter To Amount"><i class="fa fa-info-circle"aria-hidden=true></i></span></label> <input class=form-control data-parsley-group=block-0 name=price_to_amount_'+ t_counter +'[] placeholder="Enter To Amount"type=number step="0.0001"></div></div><div class="col-sm-12 col-xs-12 col-lg-4 col-md-4 col-xl-4 col-xxl-4"><div class=form-sec><label for="">Shipping Charges <span data-bs-placement=right data-bs-toggle=tooltip title="Please enter Shipping Charges"><i class="fa fa-info-circle"aria-hidden=true></i></span></label> <input class=form-control data-parsley-group=block-0 name=price_shipping_charge_'+ t_counter +'[] placeholder="Enter Shipping Charges"type=number step="0.0001"></div></div><div class="col-sm-12 col-xs-12 col-lg-2 col-md-2 col-xl-2 col-xxl-2 last_add_div"><label for=""></label> <a><span class=remove_charge_amount><i class="fa fa-minus-circle"></i></span></a></div></div>';
 		$(this).closest('.delivery-field-sec').find('.amout_ship_div').append(s_html);
 	});
 	$(document).on("click", ".remove_charge_amount", function() {
 		$(this).closest('.each-ship-price-row').remove();
 	});
 	$(document).on("click", ".add_weight_amount", function() {
 		var v_vounter = $(this).data('counter');
 		var s_html = '<div class="row each-ship-weight-row"><input type="hidden" value="yes" name="weight_hidden_'+ v_vounter +'[]"><div class="col-sm-12 col-xs-12 col-lg-3 col-md-3 col-xl-3 col-xxl-3"><div class=form-sec><label for="">From <span data-bs-placement=right data-bs-toggle=tooltip title="Enter Weight in Grams"><i class="fa fa-info-circle"aria-hidden=true></i></span></label> <input class=form-control data-parsley-group=block-0 name=weight_from_amount_'+ v_vounter +'[] placeholder="Enter From Amount"type=number step="0.0001"></div></div><div class="col-sm-12 col-xs-12 col-lg-3 col-md-3 col-xl-3 col-xxl-3"><div class=form-sec><label for="">To <span data-bs-placement=right data-bs-toggle=tooltip title="Enter Weight in Grams"><i class="fa fa-info-circle"aria-hidden=true></i></span></label> <input class=form-control data-parsley-group=block-0 name=weight_to_amount_'+ v_vounter +'[] placeholder="Enter To Amount"type=number step="0.0001"></div></div><div class="col-sm-12 col-xs-12 col-lg-4 col-md-4 col-xl-4 col-xxl-4"><div class=form-sec><label for="">Shipping Charges <span data-bs-placement=right data-bs-toggle=tooltip title="Please enter Shipping Charges"><i class="fa fa-info-circle"aria-hidden=true></i></span></label> <input class=form-control data-parsley-group=block-0 name=weight_shipping_charge_'+ v_vounter +'[] placeholder="Enter Shipping Charges"type=number step="0.0001"></div></div><div class="col-sm-12 col-xs-12 col-lg-2 col-md-2 col-xl-2 col-xxl-2 last_add_div"><label for=""></label> <a><span class=remove_weight_amount><i class="fa fa-minus-circle"></i></span></a></div></div>';
 		$(this).closest('.delivery-field-sec').find('.amout_weight_div').append(s_html);
 	});
 	$(document).on("click", ".remove_weight_amount", function() {
 		$(this).closest('.each-ship-weight-row').remove();
 	});
 </script>
  @endsection