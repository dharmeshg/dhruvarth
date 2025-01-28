@extends('layouts.backend.index')

<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.css'>
@section('main_content')
<style>
	.is_featured_class{margin: 0px 10px -4px 10px;}
	
</style>

<div class="pcoded-wrapper">
	<div class="pcoded-content">
		<div class="pcoded-inner-content">
			<div class="custom_breadcum">
				<ul>
					<li class="breadcum-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
					<li class="breadcum-item"><a href="javascript:;"> Settings </a></li>
					<li class="breadcum-item"><a href="{{route('global_settings.index')}}">Global Settings</a></li>
					<li class="breadcum-item"><a href="{{route('delivery_zip.index')}}"> Shipping </a></li>
					<li class="breadcum-item active"><a href="javascript:;"> {{ isset($edit) ? 'Edit' : 'Add'  }} Delivery Zip Code </a></li>
				</ul>
			</div>
			<div class="main-body">
				<div class="page-wrapper">
					<div class="d-flex align-items-center justify-content-between">
						<h3 class="add_heading">{{ isset($edit) ? 'Edit' : 'Add'  }} Delivery Zip Code</h3>
						<a href="{{ route('delivery_zip.index') }}" class="back-btn">Back to Zip Codes</a>
					</div>
					<form action="{{ route('delivery_zip.save') }}" id="daily_status_add" method="POST" enctype='multipart/form-data' data-parsley-validate>
						@csrf
						<div class="input_group mt-3">
							<div class="mb-3">
								<div class="row">
									<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">
										<label class="form-label" for="exampleFormControlInput1">Country <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please Select Country" ><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                        <select class="form-control select2" name="country" id="country" required data-parsley-required-message="Please Select Country">
                                            @if(isset($contries) && count($contries) > 0)
                                            @foreach($contries as $country_n)
                                            <option value="{{ $country_n->id }}"
                                                    {{ (isset($country) && $country == $country_n->id) || old('country') == $country_n->id ? 'selected' : '' }}>
                                                {{ $country_n->name }}
                                            </option>
                                            @endforeach
                                            @endif
                                        </select>
                                        @error('country')
                                        <span class="text-danger">
                                            {{$message}}
                                        </span>
                                        @enderror
									</div>
								</div>
							</div>
							<div class="mb-3">
								<div class="row">
									<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">
										<label class="form-label"
                                               for="exampleFormControlTextarea1">State <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="You can select multiple States" ><i class="fa fa-info-circle" aria-hidden="true"></i></span><span id="state_star" style="color: red;margin: 0;">*</span></label>
										<select class="form-control select2" name="state" id="state" required data-parsley-required-message="Please Select State">
											
										</select>
                                        @error('state')
                                        <span class="text-danger">
                                            {{$message}}
                                        </span>
                                        @enderror
									</div>
								</div>
							</div>
							<div class="mb-3">
								<div class="row">
									<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">
										<label class="form-label"
                                               for="exampleFormControlTextarea1">City <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please Select City" ><i class="fa fa-info-circle" aria-hidden="true"></i></span><span id="city_star" style="color: red;margin: 0;">*</span></label>
										<select class="form-control select2" name="city" id="city" required data-parsley-required-message="Please Select City">
											
										</select>
                                        @error('city')
                                        <span class="text-danger">
                                            {{$message}}
                                        </span>
                                        @enderror
									</div>
								</div>
							</div>
							<div class="mb-3" @if(isset($edit) && $edit !== null) style="display: none;" @endif>
								<div class="row">
									<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">
										<div class="radio-options">
	                                    	<label class="radio-inline">
	                                        	<input type="radio" name="p_hallmarked" value="code">Code</label>
	                                      	<label class="radio-inline">
	                                        	<input type="radio" name="p_hallmarked" value="file" checked="">File
	                                    	</label>
                                            @error('p_hallmarked')
                                            <span class="text-danger">
                                            {{$message}}
                                        </span>
                                            @enderror
                                		</div>
									</div>
								</div>
							</div>
							<div class="mb-3" id="zip_div" @if(isset($edit) && $edit !== null || isset($add) && $add) style="display: none;" @endif>
								<div class="row">
									<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">
										<label class="form-label" for="exampleFormControlInput1">Zip Code <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="You can select multiple Zipcodes" ><i class="fa fa-info-circle" aria-hidden="true"></i></span><span id="code_star" style="color: red;margin: 0;">*</span></label>
										<input class="form-control" id="code" name="code" placeholder="Enter Zip Code" type="text" data-parsley-required-message="Please Select Zipcode">
                                        @error('code')
                                        <span class="text-danger">
                                            {{$message}}
                                        </span>
                                        @enderror
									</div>
								</div>
							</div>
							<div id="file_div" @if(isset($edit) && $edit !== null) style="display: none;" @else style="display: block;" @endif>
								<div class="mb-3" >
									<div class="row">
										<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">
											<label class="form-label" for="exampleFormControlInput1">File <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Mention Total no of days for Shipping estimation" ><i class="fa fa-info-circle" aria-hidden="true"></i></span><span id="file_star" style="color: red;margin: 0;">*</span></label>
											<input class="form-control" id="file" name="file" type="file" accept=".xlsx" data-parsley-required-message="Please import Excel File">
										</div>
									</div>
								</div>
								<div class="mb-3">
									<label class="form-label" for="exampleFormControlInput1"><a href="{{asset('assets/sampleFile/delivery_zip.xlsx')}}" download="delivery_zip.xlsx">Sample File</a></label>
								</div>
							</div>
                            @error('file')
                            <span class="text-danger">
                                {{$message}}
                            </span>
                            @enderror
							<div class="mb-3">
								<button type="submit" class="common-submit-btn">Submit</button> 
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
    function loadStates(country, selectedState = null) {
        $("#state").html('');
        if (country) {
            $.ajax({
                url: "{{ route('business.get_state') }}",
                type: "POST",
                data: {
                    country: country,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function(result) {
                    $('#state').html('<option value="">Select State</option>');
                    $.each(result.state, function(key, value) {
                        let isSelected = (value.id == selectedState) ? 'selected' : '';
                        $("#state").append('<option value="' + value.id + '" ' + isSelected + '>' + value.name + '</option>');
                    });
                    if (selectedState) {
                        var city = '<?= old('city') ?? ''?>';
                        loadCities(selectedState,city);
                    }
                }
            });
        }
    }

    function loadCities(state, selectedCity = null) {
        $("#city").html('');
        if (state) {
            $.ajax({
                url: "{{ route('business.get_city') }}",
                type: "POST",
                data: {
                    state: state,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function(result) {
                    $('#city').html('<option value="">Select City</option>');
                    $.each(result.city, function(key, value) {
                        let isCitySelected = (value.id == selectedCity) ? 'selected' : '';
                        $("#city").append('<option value="' + value.id + '" ' + isCitySelected + '>' + value.name + '</option>');
                    });
                }
            });
        }
    }

    function toggleFileZip(val) {
        if (val === 'code') {
            $('#file_div').hide();
            $('#state_star').show();
            $('#city_star').show();
            $('#code_star').show();
            $('#file_star').hide();
            $('#zip_div').show();
            $('#file').prop('required', false);
            $('#state').prop('required', true);
            $('#city').prop('required', true);
            $('#code').prop('required', true);
        } else {
            $('#file_div').show();
            $('#file').prop('required', true);
            $('#zip_div').hide();
            $('#state_star').hide();
            $('#city_star').hide();
            $('#code_star').hide();
            $('#file_star').show();
            $('#state').prop('required', false);
            $('#city').prop('required', false);
            $('#code').prop('required', false);
        }
    }
    $(document).ready(function() {
        let country = $('#country').val();
        let state = $('#state').val() ?? '<?= old('state')?>';
        let city = $('#city').val() ?? '<?= old('city')?>';
        let oldPHallmarked = '<?= old('p_hallmarked') ?>';

        if (oldPHallmarked === 'code') {
            $('input[name="p_hallmarked"][value="code"]').prop('checked', true);
        } else {
            $('input[name="p_hallmarked"][value="file"]').prop('checked', true);
        }

        let selectedPHallmarked = $('input[name="p_hallmarked"]:checked').val();
        toggleFileZip(selectedPHallmarked);

        $('input[name="p_hallmarked"]').on('change', function() {
            toggleFileZip($(this).val());
        });
        $('#country').on('change', function() {
            let country = this.value;
            loadStates(country);
        });

        $('#state').on('change', function() {
            let state = this.value;
            loadCities(state);
        });
        if(country !== ''){
            loadStates(country,state);
        }
        if(state!==''){
            loadCities(state,city);
        }
    });

</script>
@endsection
