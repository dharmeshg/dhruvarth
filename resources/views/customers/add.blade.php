@extends('layouts.backend.index')

@section('main_content')
<style>
.is_featured_class{margin: 0px 10px -4px 10px;}
.iti--allow-dropdown{
    width: 100%;
}
#mobile_code{
    padding-left: 82px !important;
}
</style>

<div class="pcoded-wrapper">
	<div class="pcoded-content">
		<div class="pcoded-inner-content">
			<div class="custom_breadcum">
                <ul>
                    <li class="breadcum-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                    <li class="breadcum-item"><a href="{{route('orders.dash_index')}}"> Orders </a></li>
                    <li class="breadcum-item"><a href="{{route('customers.index')}}"> Customers</a></li>
                    <li class="breadcum-item active"><a href="javascript:;"> {{ isset($users) ? 'Edit' : 'Add' }} Customer </a></li>
                </ul>
            </div>
			<div class="main-body">
				<div class="page-wrapper">
					<div class="d-flex align-items-center justify-content-between">
						<h3 class="add_heading">{{ isset($users) ? 'Edit' : 'Add' }} Customer</h3>
					</div>
					<form action="{{ route('customers.save') }}" id="daily_status_add" method="POST" enctype='multipart/form-data' data-parsley-validate>
						@csrf
						<input type="hidden" name="customers_id" value="{{ isset($users->id) ? $users->id : '' }}">
						<div class="input_group add-article mt-3">
							<div class="row">
								<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12">
									<div class="mb-3">
										<label>Customer Image <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please Upload Customer Photo/Icon" ><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
										<div class="row">
											<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12 d-flex align-items-center">
												<div class="me-3">
													<label class="img_upload daily_status_image" for="image_file"><i class="fa fa-plus mx-1"></i> Upload</label>
													<input type="file"  style="display: none;" id="image_file" name="image" class="item-img">
												</div>
												<div>
													@if(isset($users->image) && $users->image != '' && $users->image != null)
													<img src="{{asset('uploads/users/'.$users->image)}}" class="img-fluid preview_image" id="item-img-output">
													@else
													<img src="{{asset('assets/images/user/img-demo_1041.jpg')}}" class="img-fluid preview_image" id="item-img-output">
													@endif
												</div>
												<input type="hidden" name="old_img" value="{{ isset($users->image) ? $users->image : ''}}" id="old_img">
											</div>
												<span id="error-message" style="display: none; color: red; margin-left: 15px;" class="parsley-errors-list"></span>
										</div>
									</div>
								</div>
								<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12">
									<div class="mb-3">
										<label>Business Card Image <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please Upload Business Card Image" ><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
										<div class="row">
											<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12 d-flex align-items-center">
												<div class="me-3">
													<label class="img_upload business_card_image" for="business_card"><i class="fa fa-plus mx-1"></i> Upload</label>
													<input type="file"  style="display: none;" id="business_card" name="business_card" class="business-item-img" data-parsley-required-message="please choose business card image" data-parsley-errors-container="#b-error-message">
												</div>
												<div>
													@if(isset($users->business_card) && $users->business_card != '' && $users->business_card != null)
													<img src="{{asset('uploads/users/'.$users->business_card)}}" class="img-fluid preview_image" id="item-b-img-output">
													@else
													<img src="{{asset('assets/images/user/img-demo_1041.jpg')}}" class="img-fluid preview_image" id="item-b-img-output">
													@endif
												</div>
												<input type="hidden" name="b_old_img" value="{{ isset($users->business_card) ? $users->business_card : ''}}" id="b_old_img">
											</div>
												<span id="b-error-message" style="display: none; color: red; margin-left: 15px;" class="parsley-errors-list"></span>
										</div>
									</div>
								</div>
							</div>
							<div class="mb-3">
								<div class="row">
									@if(isset($data['full_name']) && $data['full_name'] != null && $data['full_name']->display == 1)
									<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12">
										<label>Full Name <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter customer name" ><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
										<input type="text" name="name" placeholder="Enter Name"class="form-control" @if(isset($data['full_name']->mandatory) && $data['full_name']->mandatory == 1) required data-parsley-required-message="Please Enter Name" @endif value="{{ isset($users->name) ? $users->name : '' }}">
									</div>
									@endif
									@if(isset($data['business_name']) && $data['business_name'] != null && $data['business_name']->display == 1)
									<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12">
										<label>Business Name <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter Business Name" ><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
										<input type="text" name="business_name" placeholder="Enter Business Name"class="form-control" @if(isset($data['business_name']->mandatory) && $data['business_name']->mandatory == 1) required  data-parsley-required-message="Please Business Name" @endif value="{{ isset($users->business_name) ? $users->business_name : '' }}">
									</div>
									@endif
									@if(isset($data['email']) && $data['email'] != null && $data['email']->display == 1)
									<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12">
										<label>Mail Id <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter Email ID" ><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
										<input type="email" name="mail_id" placeholder="Enter Mail Id" class="form-control" @if(isset($data['email']->mandatory) && $data['email']->mandatory == 1) required data-parsley-required-message="Please Enter Mail Id" @endif value="{{ isset($users->email) ? $users->email : '' }}">
									</div>
									@endif
									@if(isset($data['mobile']) && $data['mobile'] != null && $data['mobile']->display == 1)
									<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12 mt-2">
										<label>Mobile Number <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter mobile number" ><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
										<input type="tel" name="phone" id="mobile_code" class="form-control" @if(isset($data['mobile']->mandatory) && $data['mobile']->mandatory == 1) required data-parsley-required-message="Please Enter Contact" @endif value="{{ isset($users->phone) ? $users->phone : '' }}" data-parsley-errors-container="#mobile-error-container">
										 <input type="hidden" id="country_code" name="country_code" value="{{ isset($users->country_code) ? $users->country_code : 'in' }}">
										 <input type="hidden" id="country_number"  name="country_number" placeholder="Enter Mobile Number"value="{{ isset($users->country_code_number) ? $users->country_code_number : '91' }}">
										<span id="mobile-error-container"></span>
									</div>
									@endif
									@if(isset($data['country_state_city']) && $data['country_state_city'] != null && $data['country_state_city']->display == 1)
									<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12 mt-2">
										<label>Country <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please Select Country" ><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
										<select class="form-control" id="country" name="country" @if(isset($data['country_state_city']->mandatory) && $data['country_state_city']->mandatory == 1) required data-parsley-required-message="Please Select Country" @endif>
										@if(isset($countries) && count($countries) > 0)
										@foreach($countries as $country)
											<option value="{{ $country->id }}" {{ isset($userAddress->country)  && $userAddress->country == $country->id ? 'selected' : '' }}>{{ isset($country->name) ? $country->name : ''}}</option>
										@endforeach
										@endif
										</select>
									</div>
									@endif
									@if(isset($data['country_state_city']) && $data['country_state_city'] != null && $data['country_state_city']->display == 1)
									<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12 mt-2">
										<label>State <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please Select State" ><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
										<select class="form-control" id="state" name="state" @if(isset($data['country_state_city']->mandatory) && $data['country_state_city']->mandatory == 1) required data-parsley-required-message="Please Select State" @endif>
											<option>Select</option>
										</select>
									</div>
									@endif
									@if(isset($data['country_state_city']) && $data['country_state_city'] != null && $data['country_state_city']->display == 1)
									<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12 mt-2">
										<label>City <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter City" ><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
										<select class="form-control" id="city" name="city" @if(isset($data['country_state_city']->mandatory) && $data['country_state_city']->mandatory == 1) required data-parsley-required-message="Please Select City" @endif>
											<option>Select</option>
										</select>
									</div>
									@endif
									@if(isset($data['gat_number']) && $data['gat_number'] != null && $data['gat_number']->display == 1)
									<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12 mt-2">
										<label>GST Number <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter GST Number" ><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
										<input type="text" name="gst_no" placeholder="Enter GST Number" class="form-control" @if(isset($data['gat_number']->mandatory) && $data['gat_number']->mandatory == 1) required data-parsley-required-message="Please Enter GST Number" @endif value="{{ isset($userAddress->gst_number) ? $userAddress->gst_number : '' }}">
									</div>
									@endif
									@if(isset($data['address_1']) && $data['address_1'] != null && $data['address_1']->display == 1)
									<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12 mt-2">
										<label>Address Line 1 <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter Address Line 1" ><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
										<input type="text" name="address_1" placeholder="Enter Address Line 1" class="form-control" @if(isset($data['address_1']->mandatory) && $data['address_1']->mandatory == 1) required data-parsley-required-message="Please Enter Address Line 1" @endif value="{{ isset($userAddress->address) ? $userAddress->address : '' }}">
									</div>
									@endif
									@if(isset($data['address_2']) && $data['address_2'] != null && $data['address_2']->display == 1)
									<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12 mt-2">
										<label>Address Line 2 <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter Address Line 2" ><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
										<input type="text" name="address_2" placeholder="Enter Address Line 2" class="form-control"  @if(isset($data['address_2']->mandatory) && $data['address_2']->mandatory == 1) required data-parsley-required-message="Please Enter Address Line 2" @endif value="{{ isset($userAddress->address2) ? $userAddress->address2 : '' }}">
									</div>
									@endif
									@if(isset($data['website']) && $data['website'] != null && $data['website']->display == 1)
									<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12 mt-2">
										<label>Website <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter Website" ><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
										<input type="url" name="website" placeholder="Enter Website" class="form-control" @if(isset($data['website']->mandatory) && $data['website']->mandatory == 1) required data-parsley-required-message="Please Enter Website" @endif value="{{ isset($users->website) ? $users->website : '' }}">
									</div>
									@endif
									@if(isset($data['social_1']) && $data['social_1'] != null && $data['social_1']->display == 1)
									<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12 mt-2">
										<label>Social 1 <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter Social 1" ><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
										<input type="text" name="social_1" placeholder="Enter Social 1" class="form-control" @if(isset($data['social_1']->mandatory) && $data['social_1']->mandatory == 1) required data-parsley-required-message="Please Enter Social 1" @endif value="{{ isset($userAddress->social_1) ? $userAddress->social_1 : '' }}">
									</div>
									@endif
									@if(isset($data['social_2']) && $data['social_2'] != null && $data['social_2']->display == 1)
									<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12 mt-2">
										<label>Social 2 <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter Social 2" ><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
										<input type="text" name="social_2" placeholder="Enter Social 2" class="form-control" @if(isset($data['social_2']->mandatory) && $data['social_2']->mandatory == 1) required data-parsley-required-message="Please Enter Social 2" @endif value="{{ isset($userAddress->social_2) ? $userAddress->social_2 : '' }}">
									</div>
									@endif
								</div>
							</div>
							@if(isset($data['password']) && $data['password'] != null && $data['password']->display == 1) 
							@if(isset($users))
							<div class="mb-3">
									<div class="form-check">
									  <input class="form-check-input" type="checkbox" value="" id="update_password" name="update_password">
									  <label class="form-check-label" for="flexCheckDefault">
									    Update Password <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please click here to update password" ><i class="fa fa-info-circle" aria-hidden="true"></i></span>
									  </label>
									</div> 
							</div>
							@endif
							<div class="mb-3 new_password_update" @if(isset($users)) style="display:none;" @endif>
								<div class="row">
									<div class="col-xxl-3 col-xl-3 col-lg-3 col-md-12 col-sm-12 col-xs-12">
										<label>@if(isset($users)) New @endif Password</label>
										<div class="input-group" id="show_hide_password">
										<input type="password" name="new_password" id="new_password" class="form-control" data-parsley-required-message="Please Enter New Password" value="">
										<div class="input-group-addon" style="background: #ECF0F5;width: 35px;"><a class="show-password" style="margin-left: 5px;" onclick="myFunction()"><i class="fa fa-eye" style="font-size: 20px;margin-top: 10px; color: #757683 " aria-hidden="true"></i></a></div>
										</div>
										<div style="color: red;" id="passwordStrength"></div>
									</div>
									<div class="col-xxl-3 col-xl-3 col-lg-3 col-md-12 col-sm-12 col-xs-12">
										<label>Confirm Password</label>
										<input type="password" name="con_password" id="con_password" class="form-control" data-parsley-required-message="Please Enter Confirm Password" value="">
										<div style="color: red;" id="CheckPasswordMatch"></div>
									</div>
								</div> 
							</div> 
							@endif
							<h5 class="mt-3">Private Product Access</h5>
							<div class="row">
								<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 mb-3">
									<div class="form-check form-check-inline">
										<input class="form-check-input modal_access_radio" type="radio" name="product_access" id="inlineRadio1" checked value="1" @if(isset($users->product_access) && $users->product_access == 1) checked @endif>
										<label class="form-check-label" for="inlineRadio1" style="cursor: pointer;">Limited Access</label>
									</div>
									<div class="form-check form-check-inline">
										<input class="form-check-input modal_access_radio" type="radio" name="product_access" id="inlineRadio2" value="0" @if(isset($users->product_access) && $users->product_access == 0) checked @endif>
										<label class="form-check-label" for="inlineRadio2" style="cursor: pointer;">Unlimited Access</label>
									</div>
								</div>
							</div>
							<div class="row l-date-time-sec">
								<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 mb-3">
									<label>Start Date </label>
									<div class="row">
										<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
										<input type="text" name="start_date" class="form-control me-2" placeholder="Start Date" readonly id="start_date" value="{{ isset($users->start_date) ? $users->start_date : '' }}">
										</div> 
										<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
											<input class="form-control" id="start_time" name="start_time" type="time" placeholder="Start Time" value="{{ isset($users->start_time) ? $users->start_time : '' }}">
										</div> 
									</div>
								</div>
								<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 mb-3">
									<label>End Date </label>
									<div class="row">
										<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
											<input type="text" name="end_date" placeholder="End Date" class="form-control" id="end_date" readonly value="{{ isset($users->end_date) ? $users->end_date : '' }}">
										</div> 
										<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
											<input class="form-control" id="end_time" name="end_time" type="time" placeholder="End Time" value="{{ isset($users->end_time) ? $users->end_time : '' }}">
										</div> 
									</div>
								</div>
							</div>
								<div class="mb-3">
									<button type="submit" id="customer_update" class="common-submit-btn">Submit</button> 
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

	$(document).ready(function() {
        var mobileCode = $("#mobile_code").intlTelInput({
            initialCountry: "{{ isset($users->country_code) ? $users->country_code : 'in' }}",
            separateDialCode: true,        
      });

        mobileCode.on("countrychange", function (e) {
        	console.log("Country changed:", e);
		    var selectedCountryData = mobileCode.intlTelInput('getSelectedCountryData');
		    $("#country_code").val(selectedCountryData.iso2);
		    
		    // Get only the dial code without any extra characters
		    var selectedCountryNumber = selectedCountryData.dialCode.replace(/\D/g, ''); // Remove non-numeric characters
		    $("#country_number").val(selectedCountryNumber);
		});
		
		$("#start_date").datepicker({ 
        autoclose: true, 
        todayHighlight: true
        }).on('changeDate', function(selected) {
        var startDate = new Date(selected.date.valueOf());
        $('#end_date').datepicker('setStartDate', startDate);
        });

        $("#end_date").datepicker({ 
        autoclose: true, 
        todayHighlight: true
        });

		@if(isset($userAddress->state) && $userAddress->state != null)
		var country = '{{$userAddress->country}}';
			$("#state").html('');
			$.ajax({
				url: "{{route('business.get_state')}}",
				type: "POST",
				data: {
				country: country,
				_token: '{{csrf_token()}}'
				},
				dataType: 'json',
				success: function(result) {
				$('#state').html('<option value="">Select State</option>');
				var state_id = '{{$userAddress->state}}';
				$.each(result.state, function(key, value) {
					var selected = '';
					if (state_id == value.id) {
						var isselected = 'selected';
					}
					$("#state").append('<option value="' + value.id + '" ' + isselected + '>' + value.name + '</option>');
				});
				}
		});
		@endif
		@if(isset($userAddress->city) && $userAddress->city != null)
		var state = '{{$userAddress->state}}';
		$("#city").html('');
			$.ajax({
				url: "{{route('business.get_city')}}",
				type: "POST",
				data: {
				state: state,
				_token: '{{csrf_token()}}'
				},
				dataType: 'json',
				success: function(result) {
				$('#city').html('<option value="">Select City</option>');
				var city_id = '{{$userAddress->city}}';
				$.each(result.city, function(key, value) {
					var iscityselected = '';
					if (city_id == value.id) {
						var iscityselected = 'selected';
					}
					$("#city").append('<option value="' + value.id + '" '+ iscityselected +'>' + value.name + '</option>');
				});
				}
			}); 
		@endif
   	});
    </script>

	<script>
 $('.item-img').on('change', function () {
        var input = this;

        if (input.files && input.files[0]) {
        	if (!input.files[0].type.startsWith('image/')) {
	            $('#error-message').text('Please select a valid image file.');
	            $('#error-message').show();
	            $('.common-submit-btn').prop('disabled', true);
	            $('.item-img').val('');
	            return;
	        }
            var reader = new FileReader();

            reader.onload = function (e) {
                var img = new Image();
                img.src = e.target.result;

                img.onload = function () {
                    // if (img.width === 500 && img.height === 500 && input.files[0].size <= 500 * 1024) {
                        // Image is valid
                        $('#item-img-output').attr('src', e.target.result);
                        $('#error-message').hide();
                        $('.common-submit-btn').prop('disabled', false);
                        $('#old_img').val();
                    // } else {
                    //     // Invalid image, reset input
                    //     $('#error-message').text('Please select a valid image with dimensions 500x500 and size up to 500kb.');
                    //     $('#error-message').show();
                    //     $('.common-submit-btn').prop('disabled', true);
                    //     $('.item-img').val('');
                    // }
                };
            };

            reader.readAsDataURL(input.files[0]);
        }
    });

	$('.business-item-img').on('change', function () {
        var input = this;

        if (input.files && input.files[0]) {
        	if (!input.files[0].type.startsWith('image/')) {
	            $('#b-error-message').text('Please select a valid image file.');
	            $('#b-error-message').show();
	            $('.common-submit-btn').prop('disabled', true);
	            $('.business-item-img').val('');
	            return;
	        }
            var reader = new FileReader();

            reader.onload = function (e) {
                var img = new Image();
                img.src = e.target.result;

                img.onload = function () {
                    // if (img.width === 500 && img.height === 500 && input.files[0].size <= 500 * 1024) {
                        // Image is valid
                        $('#item-b-img-output').attr('src', e.target.result);
                        $('#b-error-message').hide();
                        $('.common-submit-btn').prop('disabled', false);
                        $('#b_old_img').val();
                    // } else {
                    //     // Invalid image, reset input
                    //     $('#error-message').text('Please select a valid image with dimensions 500x500 and size up to 500kb.');
                    //     $('#error-message').show();
                    //     $('.common-submit-btn').prop('disabled', true);
                    //     $('.item-img').val('');
                    // }
                };
            };

            reader.readAsDataURL(input.files[0]);
        }
    });
	$(document).on('change', '.modal_access_radio', function() {
        var access_type = $("input[name='product_access']:checked").val();
        if(access_type == '1')
        {
            $('.l-date-time-sec').removeClass('d-none');
        }else{
            $('.l-date-time-sec').addClass('d-none');
        }
    });
    </script>

    <script>
    	$(document).on('click', '#update_password', function() {
    		if (this.checked) {
    			$('.new_password_update').css('display','block');
    			$("#new_password").attr("required", "true");
    			$("#con_password").attr("required", "true");
                 $('#customer_update').prop('disabled', true);

    		}else{
    			$('.new_password_update').css('display','none');
    			$("#new_password").attr("required", false);
    			$("#con_password").attr("required", false);
    			$('#customer_update').prop('disabled', false);
    		}
    	})


    	$(document).on('keyup','#con_password', function(){

               var password = $("#new_password").val();

                var confirmPassword = $("#con_password").val();

          if (password != confirmPassword){
              $("#CheckPasswordMatch").html("Password does not with new password match !").css("color","#dd4949");
              $('#customer_update').prop('disabled', true);
           }else{
                $("#CheckPasswordMatch").html("");
                $('#customer_update').prop('disabled', false);
            }

         });

    	$(document).on('keyup','#new_password', function(){
            var password = $(this).val();
            var uppercaseLetters = /[A-Z]/;
            var lowercaseLetters = /[a-z]/;
            var specialCharacters = /[-._!"`'#%&,:;<>=@{}~\$\(\)\*\+\/\\\?\[\]\^\|]+/;
            var numbers = /[0-9]/;

            if (password.length < 8) {
                $('#passwordStrength').html("should be atleast 8 characters.");
                 $('#customer_update').prop('disabled', true);
            }else{
                if (password.match(numbers) && password.match(uppercaseLetters) && password.match(lowercaseLetters) && password.match(specialCharacters)) {
                    $("#passwordStrength").html("");
                    
                    $('#customer_update').prop('disabled', false);

                }else if(lowercaseLetters.test(password) ^ uppercaseLetters.test(password) ^ numbers.test(password)){
                    $("#passwordStrength").html("Requires upper and lowercase letters, at least 8 characters long, and include numbers and special characters");
                    $('#customer_update').prop('disabled', true);

                }else{
                    $("#passwordStrength").html("Requires upper and lowercase letters, at least 8 characters long, and include numbers and special characters");
                    $('#customer_update').prop('disabled', true);
                }
                if (password.length < 8) {
                    $('#passwordStrength').html("Requires upper and lowercase letters, at least 8 characters long, and include numbers and special characters.");
                    $('#customer_update').prop('disabled', true);
                }
            }

        })

		$('#country').on('change', function () { 
			var country = this.value;
			$("#state").html('');
			$.ajax({
				url: "{{route('business.get_state')}}",
				type: "POST",
				data: {
				country: country,
				_token: '{{csrf_token()}}'
				},
				dataType: 'json',
				success: function(result) {
				$('#state').html('<option value="">Select State</option>');
				$.each(result.state, function(key, value) {
					$("#state").append('<option value="' + value.id + '">' + value.name + '</option>');
				});
				}
			}); 
		});
		$('#state').on('change', function () { 
			var state = this.value;
			$("#city").html('');
			$.ajax({
				url: "{{route('business.get_city')}}",
				type: "POST",
				data: {
				state: state,
				_token: '{{csrf_token()}}'
				},
				dataType: 'json',
				success: function(result) {
				$('#city').html('<option value="">Select City</option>');
				$.each(result.city, function(key, value) {
					$("#city").append('<option value="' + value.id + '">' + value.name + '</option>');
				});
				}
			}); 
		});
    </script>
    <script>
    function myFunction() {
		var x = document.getElementById("new_password");
		if (x.type === "password") {
			x.type = "text";
		} else {
			x.type = "password";
		}
	}
</script>
    @endsection
