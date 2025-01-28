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
                        <form action="{{ route('delivery_zip.update',['zip'=>$zip_code->id]) }}" id="daily_status_add" method="POST" enctype='multipart/form-data' data-parsley-validate>
                            @csrf
                            <div class="input_group mt-3">
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                            <label class="form-label" for="exampleFormControlInput1">Country <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please Select Country" ><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                            <select class="form-control select2" name="country" id="country" required data-parsley-required-message="Please Select Country">
                                                @if(isset($contries) && count($contries) > 0)
                                                    @foreach($contries as $country_n)
                                                        <option value="{{ $country_n->id }}" {{ isset($country) && $country ==  $country_n->id ? 'selected' : ''}}>{{ $country_n->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                            <label class="form-label"
                                                   for="exampleFormControlTextarea1">State <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="You can select multiple States" ><i class="fa fa-info-circle" aria-hidden="true"></i></span><span style="color: red;margin: 0;">*</label>
                                            <select class="form-control select2" name="state" id="state" required data-parsley-required-message="Please Select State">

                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                            <label class="form-label"
                                                   for="exampleFormControlTextarea1">City <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please Select City" ><i class="fa fa-info-circle" aria-hidden="true"></i></span><span style="color: red;margin: 0;">*</label>
                                            <select class="form-control select2" name="city" id="city" required data-parsley-required-message="Please Select City">

                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3" id="zip_div">
                                    <div class="row">
                                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                            <label class="form-label" for="exampleFormControlInput1">Zip Code <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="You can select multiple Zipcodes" ><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                            <input class="form-control" id="code" name="code"  placeholder="Enter Zip Code" type="text" data-parsley-required-message="Please Select Zipcode" value="{{$zip_code->code}}">
                                        </div>
                                    </div>
                                </div>
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
        $('input[name="p_hallmarked"]').on('change', function(){
            var val = $(this).val();
            if(val == 'file')
            {
                $('#file_div').show();
                $('#file').prop('required',true);
                $('#zip_div').hide();
                $('#code').prop('required',false);
            }else{
                $('#file_div').hide();
                $('#zip_div').show();
                $('#file').prop('required',false);
                $('#code').prop('required',true);
            }
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
        @if(isset($country) && $country != '' && $country != null)
        var country = '{{$country}}';
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
                var state_id = '{{$state}}';
                var isselected = '';
                $.each(result.state, function(key, value) {
                    if(value.id == state_id)
                    {
                        var isselected = 'selected';
                    }
                    $("#state").append('<option value="' + value.id + '" '+ isselected +'>' + value.name + '</option>');
                });
            }
        });
        @endif
        @if(isset($city) && $city != null)
        var state = '{{$state}}';
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
                var city_id = '{{$city}}';
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
    </script>
@endsection
