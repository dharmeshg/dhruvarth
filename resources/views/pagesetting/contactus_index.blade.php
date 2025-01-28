@extends('layouts.backend.index')
@section('main_content')
<style>
    .is_featured_class{width: 35px !important;border-radius: 50px !important;}
    .is_featured_class:checked{background: #61CF57 !important;}
    .mobile_code{padding-left: 100px !important;}
    .iti--allow-dropdown{width: 100%;}
</style>
<div class="pcoded-wrapper">
    <div class="pcoded-content">
        <div class="pcoded-inner-content">
            <!-- [ breadcrumb ] start -->
            <div class="custom_breadcum">
                <ul>
                    <li class="breadcum-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                     <li class="breadcum-item"><a href="{{route('setting_all.index')}}">Settings</a></li>
                    <li class="breadcum-item"><a href="javascript:;"> Page Settings </a></li>
                    <li class="breadcum-item active"><a href="javascript:;"> Contact Us </a></li>
                </ul>
            </div>
            <!-- [ breadcrumb ] end -->
            <div class="main-body">
                <div class="page-wrapper">
                    <!-- [ Main Content ] start -->
                                <form action="{{ route('pagesetting.contact_save') }}" method="POST" data-parsley-validate=""
                                    enctype="multipart/form-data">
                        @csrf
                    <div class="row">
                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 cpl-sm-12 col-xs-12 add-article form-main-sec ">
                            <div class="Recent-Users">
                                <h5>Contact Us Page</h5>

                                <div class="card-block px-0 py-3">
                                    <div class="row">
                                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="form-sec">
                                                    <input type="hidden" name="setting_id"
                                                        value="{{ isset($setting->id) ? $setting->id : '' }}" class="form-control">
                                                    <label for="">Address Title <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please insert address title for Contact Us page" ><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                                    <input type="text" class="form-control" placeholder="Enter Title" name="title" required data-parsley-maxlength="150" value="{{ isset($setting->title) ? $setting->title: '' }}">
                                            </div>
                                        </div>
                                    </div>
                                   <div class="row">
                                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                        <label>Status <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please select a status for Contact Us page" ><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                        <div class="d-flex align-items-center">
                                            <label class="hide_show" style="color: #888; font-weight: 400;width: auto !important;margin-right: 10px;">Hide</label>
                                            <input type="checkbox" class="is_featured_class" id="" name="status" @if(isset($setting->status) && $setting->status == 1) checked @endif style="background: #DE5757;">
                                            <label for="hide_show" style="color: #888; font-weight: 400;width: auto !important;margin-left: 10px;">Show</label>
                                        </div>
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-sec">
                                            <label for="">Address Line 1 <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please insert address line 1 for Contact Us page" ><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                                    <input type="text" class="form-control" placeholder="Enter Address Line 1" name="address_line_1" required value="{{ isset($setting->address_line_1) ? $setting->address_line_1: '' }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-sec">
                                            <label for="">Address Line 2 <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please insert address line 2 for Contact Us page" ><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                                    <input type="text" class="form-control" placeholder="Enter Address Line 2" name="address_line_2" value="{{ isset($setting->address_line_2) ? $setting->address_line_2: '' }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="form-sec">
                                                    <label for="">Country <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please select country for Contact Us page" ><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                                    <select name="country" class="form-control select2" id="country">
                                                        @if(isset($countries) && count($countries) > 0)
                                                        @foreach($countries as $coun)
                                                        <option value="{{ $coun->id }}" @if(isset($setting->country) && $setting->country == $coun->id) selected @endif>{{ $coun->name }}</option>
                                                        @endforeach
                                                        @endif
                                                    </select>
                                            </div>
                                        </div>
                                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="form-sec">
                                                    <label for="">State <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please select state for Contact Us page" ><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                                    <select name="state" class="form-control select2" id="state"> 
                                                    </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="form-sec">
                                                    <label for="">City <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please select city for Contact Us page" ><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                                    <select name="city" class="form-control select2" id="city">
                                                        
                                                    </select>
                                            </div>
                                        </div>
                                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="form-sec">
                                                    <label for="">Pin Code <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please insert Pincode for Contact Us page" ><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                                    <input type="text" name="pincode" id="pincode" class="form-control" placeholder="Enter Pincode" required
                                                data-parsley-required-message="Please Enter Pincode" value="{{ isset($setting->pincode) ? $setting->pincode : '' }}" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="add_info">
                                        <h5 class="">Mobile Info</h5>
                                        <div class="row">
                                            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                <div class="form-sec">
                                                    <label for="">First Name <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please insert first name for Contact Us page" ><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                                    <input type="text" name="first_name" id="first_name" class="form-control" placeholder="Enter First Name" required
                                                    data-parsley-required-message="Please Enter First Name" value="{{ isset($setting->first_name) ? $setting->first_name : '' }}" >
                                            </div>
                                            </div>
                                            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                <div class="form-sec">
                                                        <label for="">Last Name <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please insert last name for Contact Us page" ><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                                        <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Enter Last Name" required
                                                    data-parsley-required-message="Please Enter Last Name" value="{{ isset($setting->last_name) ? $setting->last_name : '' }}" >
                                                </div>
                                            </div>
                                            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 append_button" >
                                                <a href="javascript:;" class="back-btn" style="color: #40404c !important;" id="add_alt_num">+ Add Number</a>
                                            </div>
                                        </div>
                                        <!-- <div class="row">
                                            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                <div class="form-sec">
                                                    <label for="">Phone number <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please insert phone number for Contact Us page" ><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                                    <input type="text" name="phone_number" id="mobile_code" class="form-control mobile_code imput-mask" placeholder="Enter Phone number" required
                                                data-parsley-required-message="Please Enter Phone number" data-parsley-errors-container="#p_error" value="{{ isset($setting->phone_number) ? $setting->phone_number : '' }}" >
                                                <input type="hidden" class="country_code" id="country_code" name="country_code" value="{{ isset($setting->country_code) ? $setting->country_code : 'in' }}">
                                                <input type="hidden" class="country_number" id="country_number" name="country_number" value="{{ isset($setting->country_number) ? $setting->country_number : '91' }}">
                                                </div>
                                                <p id="p_error"></p>
                                            </div>
                                            
                                        </div> -->
                                        <div class="row">
                                            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12" >
                                                <div class="alt_n_div_class" id="alt_n_div">
                                                   
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="add_info">
                                        <h5 class="">Email</h5>
                                        <div class="row">
                                            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                <div class="form-sec">
                                                    <label for="">Add Email Address <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please insert email address for Contact Us page" ><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                                    <input type="text" name="email" id="email" class="form-control" placeholder="Enter Email Address" required
                                                data-parsley-required-message="Please Enter Email Address" value="{{ isset($setting->email) ? $setting->email : '' }}" >
                                                </div>
                                            </div>
                                            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 append_button">
                                                <a href="javascript:;" class="back-btn" style="color: #40404c !important;" id="add_alt_email">+ Add Alternate Email Address</a>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                <div class="alt_n_div_class" id="alt_e_div">
                                                    @if(isset($setting->alt_email) && $setting->alt_email != null)
                                                        @php
                                                            $alt_emails = explode(',',$setting->alt_email);
                                                        @endphp
                                                    @endif
                                                    @if(isset($alt_emails) && count($alt_emails) > 0)
                                                    @foreach($alt_emails as $email)
                                                    <div class="form-sec" style="margin-bottom: 10px !important;">
                                                        <label for="">Add Alternate Email Address <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please insert alternate email address for Contact Us page" ><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                                        <input type="text" name="alt_email[]" id="alt_email" class="form-control" placeholder="Enter Alternate Email Address" value="{{ isset($email) ? $email : '' }}">
                                                        <a class="remove remove_email"><i class="fas fa-times-circle"></i></a>
                                                    </div>
                                                    @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 append_button" style="margin-top: 20px;text-align: center;">
                                                <a href="javascript:;" class="back-btn" style="color: #40404c !important;" id="add_alt_num">+ Add Branch</a>
                                            </div>
                                    </div> -->
                                        <div class="row form-sec mt-4">
                                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 label-sec">
                                                <button type="submit" id="submit_form" class="common-sub-btn">Save</button>
                                            </div>

                                    </div>
                                </div>  
                            </div>
                        </div>
                </form>
                    <!-- [ Main Content ] end -->
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<div class="modal" tabindex="-1" id="type_modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Select Number Type</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="radio-options">
            <label class="radio-inline">
                <input type="radio" name="type" value="whatspp" checked="">WhatsApp Number</label>
            <label class="radio-inline">
                <input type="radio" name="type" value="phone">Phone Number</label>

        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="select_btn">Select</button>
      </div>
    </div>
  </div>
</div>
@endsection
@section('script')
<script>
        var mobileCode = $(".mobile_code").intlTelInput({
                        initialCountry: "{{ isset($phone_number->country_code) ? $phone_number->country_code : 'in' }}",
                        separateDialCode: true,

                 
      });

            mobileCode.on("countrychange", function (e) {
                var selectedCountryData = mobileCode.intlTelInput('getSelectedCountryData');
            $(".country_code").val(selectedCountryData.iso2);
               var selectedCountryNumber = mobileCode.intlTelInput('getSelectedCountryData').dialCode;
            $(".country_number").val(selectedCountryNumber);
        });   
   
    </script>
<script>
     $(document).ready(function() {
        @if(isset($alt_numbers) && count($alt_numbers) > 0)
        var alt_numbers = {!! json_encode($alt_numbers) !!};
        $.each(alt_numbers, function (key, number) {
            var initialCountryCode = number.code;
            var initialCountrynumber = number.coun_number;

            var append_html = '<div class="form-sec" style="margin-bottom: 10px !important;">' +
                '<label for="">Phone Number <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please Insert Phone Number For Contact Us Page" ><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>' +
                '<input type="text" name="phone_no[]" class="form-control input-mask mobile_code" placeholder="Phone Number" value="' + number.number + '">' +
                '<input type="hidden" name="alt_country_code[]" class="country_code" value="' + initialCountryCode + '">' + 
                '<input type="hidden" name="alt_country_number[]" class="country_number" value="' + initialCountrynumber + '">' +
                '<a class="remove remove_number"><i class="fas fa-times-circle"></i></a>' +
                '</div>';
            $('#alt_n_div').append(append_html);

            var newMobileCode = $(".mobile_code").last().intlTelInput({
                initialCountry: initialCountryCode, // Set the initial country code
                separateDialCode: true,
            });

            newMobileCode.on("countrychange", function (e) {
                var selectedCountryData = newMobileCode.intlTelInput('getSelectedCountryData');
                newMobileCode.closest('.form-sec').find(".country_code").val(selectedCountryData.iso2);

                var selectedCountryNumber = newMobileCode.intlTelInput('getSelectedCountryData').dialCode;
                  // $("#country_number").val(selectedCountryNumber);
                  newMobileCode.closest('.form-sec').find(".country_number").val(selectedCountryNumber);
            });

            newMobileCode.closest('.form-sec').find(".alt-country-code").append(newMobileCode);

            $('.input-mask').inputmask('(999) 999-9999');
        });
    @endif
    @if(isset($alt_w_numbers) && count($alt_w_numbers) > 0)
        var alt_numbers = {!! json_encode($alt_w_numbers) !!};
        $.each(alt_numbers, function (key, number) {
            var initialCountryCode = number.code;
            var initialCountrynumber = number.coun_number;

            var append_html = '<div class="form-sec" style="margin-bottom: 10px !important;">' +
                '<label for="">WhatsApp Number <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please Insert WhatsApp Number For Contact Us Page" ><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>' +
                '<input type="text" name="whatsapp_no[]" class="form-control input-mask mobile_code" placeholder="WhatsApp Number" value="' + number.number + '">' +
                '<input type="hidden" name="alt_country_code[]" class="country_code" value="' + initialCountryCode + '">' + 
                '<input type="hidden" name="alt_country_number[]" class="country_number" value="' + initialCountrynumber + '">' +
                '<a class="remove remove_number"><i class="fas fa-times-circle"></i></a>' +
                '</div>';
            $('#alt_n_div').append(append_html);

            var newMobileCode = $(".mobile_code").last().intlTelInput({
                initialCountry: initialCountryCode, // Set the initial country code
                separateDialCode: true,
            });

            newMobileCode.on("countrychange", function (e) {
                var selectedCountryData = newMobileCode.intlTelInput('getSelectedCountryData');
                newMobileCode.closest('.form-sec').find(".country_code").val(selectedCountryData.iso2);

                var selectedCountryNumber = newMobileCode.intlTelInput('getSelectedCountryData').dialCode;
                  // $("#country_number").val(selectedCountryNumber);
                  newMobileCode.closest('.form-sec').find(".country_number").val(selectedCountryNumber);
            });

            newMobileCode.closest('.form-sec').find(".alt-country-code").append(newMobileCode);

            $('.input-mask').inputmask('(999) 999-9999');
        });
    @endif
    @if(isset($setting->state) && $setting->state != null)
    var country = '{{$setting->country}}';
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
              var state_id = '{{$setting->state}}';
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
    @if(isset($setting->city) && $setting->city != null)
    var state = '{{$setting->state}}';
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
              var city_id = '{{$setting->city}}';
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
    $(document).on("click","#add_alt_num",function() {
        $('#type_modal').modal('show');
    });
    $(document).on("click","#select_btn",function() {
        var checked = $('input[type="radio"][name="type"]:checked').val();
        if(checked == 'whatspp')
        {
            var text = 'WhatsApp';
            var name = 'whatsapp_no';
        }else{
            var text = 'Phone';
            var name = 'phone_no'
        }
        var append_html = '<div class="form-sec" style="margin-bottom: 10px !important;"><label for="">Add '+ text +' Number</label><input type="text" name="'+ name +'[]" id="alt_number" class="form-control imput-mask mobile_code" placeholder="Alternate Phone Number"><input type="hidden" id="country_code" name="alt_country_code[]" class="country_code"><input type="hidden" id="country_number" name="alt_country_number[]" class="country_number"><a class="remove remove_number"><i class="fas fa-times-circle"></i></a></div>';
        $('#alt_n_div').append(append_html);
         var newMobileCode = $(".mobile_code").last().intlTelInput({
            initialCountry: "{{ isset($phone_number->country_code) ? $phone_number->country_code : 'in' }}",
            separateDialCode: true,
        });
        newMobileCode.on("countrychange", function (e) {
            var selectedCountryData = newMobileCode.intlTelInput('getSelectedCountryData');
            newMobileCode.closest('.form-sec').find(".country_code").val(selectedCountryData.iso2);

             var selectedCountryNumber = newMobileCode.intlTelInput('getSelectedCountryData').dialCode;
                  // $("#country_number").val(selectedCountryNumber);
                  newMobileCode.closest('.form-sec').find(".country_number").val(selectedCountryNumber);
        });
        newMobileCode.closest('.form-sec').find(".alt-country-code").append(newMobileCode);
        $('.imput-mask').inputmask('(999) 999-9999');
        $('#type_modal').modal('hide');
    });
    $(document).on("click", ".remove_number", function() {
        $(this).closest('.form-sec').remove();
    });

    $(document).on("click","#add_alt_email",function() {
        var append_email_html = '<div class="form-sec" style="margin-bottom: 10px !important;"><label for="">Add Alternate Email Address</label><input type="text" name="alt_email[]" id="alt_email" class="form-control" placeholder="Enter Alternate Email Address"><a class="remove remove_email"><i class="fas fa-times-circle"></i></a></div>';
        $('#alt_e_div').append(append_email_html);
    });
    $(document).on("click", ".remove_email", function() {
        $(this).closest('.form-sec').remove();
    });
</script>
@endsection
