@extends('layouts.backend.index')
@section('main_content')
<div class="pcoded-wrapper">
    <div class="pcoded-content">
        <div class="pcoded-inner-content">
            <!-- [ breadcrumb ] start -->
            <div class="custom_breadcum">
                <ul>
                    <li class="breadcum-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                    <li class="breadcum-item"><a href="{{route('setting_all.index')}}"> Settings </a></li>
                    <li class="breadcum-item"><a href="{{route('global_settings.index')}}">Global Settings</a></li>
                    <li class="breadcum-item active"><a href="javascript:;"> Buy With Confidence </a></li>
                </ul>
            </div>
            <!-- [ breadcrumb ] end -->
            <div class="main-body">
                <div class="page-wrapper add-article">
                    <!-- [ Main Content ] start -->
                                <form action="{{ route('buy-with-confidence.save') }}" method="POST" data-parsley-validate=""
                                    enctype="multipart/form-data">
                        @csrf
                        <div class="card-block px-0 py-3">
                    <div class="row">
                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 cpl-sm-12 col-xs-12 add-article form-main-sec ">
                            <div class="Recent-Users">

                                <h5>Buy With Confidence</h5>

                                </div>  
                            </div>
                            <!-- <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-sec">
                                        <label for="">Title <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please insert Section title" ><i class="fa fa-info-circle" aria-hidden="true"></i></span><span style="color: red;margin: 0;">*</label>
                                        <input class="form-control" id="buy_sec_title" name="buy_sec_title" type="text" value="{{ isset($setting->buy_sec_title) ? $setting->buy_sec_title : ''}}" placeholder="Section Title">
                                </div> 
                            </div> -->
                        </div>

                        @if(isset($setting->buy_with_confidence_sec) && $setting->buy_with_confidence_sec != '' && $setting->buy_with_confidence_sec != null)
                                    @php
                                        $buy_json = json_decode($setting->buy_with_confidence_sec);
                                    @endphp
                                    @endif
                                    @if(isset($buy_json) && count($buy_json) > 0)
                                    <input type="hidden" value="{{count($buy_json)}}" id="buy_count">
                                    @foreach($buy_json as $key => $json)
                                    <div class="each-icon-details mt-3">
                                    <div class="row">
                                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="form-sec">
                                                    <label for="">Name <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please insert name" ><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                                    <input type="text" name="buy_title[]"  placeholder="Enter Name" id="buy_icon_name" class="form-control" value="{{ isset($json->title) ? $json->title : '' }}">
                                            </div> 
                                        </div>
                                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                            <div class="form-sec">
                                                    <label for="">Icon <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please upload the icon" ><i class="fa fa-info-circle" aria-hidden="true"></i></span><span style="color: red;margin: 0;"> *1:1 square PNG only, max 512 px.</span></label>
                                                    <div class="d-flex align-items-center">
                                                    <div class="input_group me-3">
                                                        <label class="img_upload" for="buy_icon_{{$key}}"><i class="fa fa-plus mx-1"></i> Upload</label>
                                                        <input type="file" name="buy_icon[]" style="display: none;" id="buy_icon_{{$key}}" class="buy_icon" >
                                                    </div>
                                                <div class="preview_image">
                                                    @if(isset($json->icon) && $json->icon != '' && $json->icon != null)
                                                    <img src="{{asset('uploads/images/'.$json->icon)}}" class="img-fluid preview_image icon_img" >
                                                    @else
                                                    <img src="{{asset('assets/images/user/img-demo_1041.jpg')}}" class="img-fluid preview_image icon_img" >
                                                    @endif
                                                </div>
                                            </div>
                                                <input type="hidden" name="old_buy_icon[]" value="{{ isset($json->icon) ? $json->icon : '' }}"> 
                                            </div>
                                        </div>
                                        <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12" style="text-align: end;margin-top: 18px;">
                                        @if(isset($key) && $key == 0)
                                        <a class="back-btn" href="javascript:;" id="add_icon">+ Add Icon</a>
                                        @else
                                        <a class="remove remove_icon" href=javascript:;><i class="fa-times-circle fas"></i></a>
                                        @endif
                                        </div>
                                    </div>
                                    </div>
                                    @endforeach
                                    @else
                                    <div class="each-icon-details mt-3">
                                    <div class="row">
                                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="form-sec">
                                                    <label for="">Name <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please insert name" ><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                                    <input type="text" name="buy_title[]" id="buy_icon_name" class="form-control">
                                            </div> 
                                        </div>
                                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                            <div class="form-sec">
                                                    <label for="">Icon <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please upload the icon" ><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                                    <div class="d-flex align-items-center">
                                                    <div class="input_group me-3">
                                                        <label class="img_upload" for="buy_icon_0"><i class="fa fa-plus mx-1"></i> Upload</label>
                                                        <input type="file" name="buy_icon[]" style="display: none;" id="buy_icon_0" class="buy_icon" >
                                                    </div>
                                                <div class="preview_image">
                                                    <img src="{{asset('assets/images/user/img-demo_1041.jpg')}}" class="img-fluid preview_image icon_img" >
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                        <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12" style="text-align: end;margin-top: 18px;">
                                        <a class="back-btn" href="javascript:;" id="add_icon">+ Add Icon</a>
                                        </div>
                                    </div>
                                    </div>
                                    @endif
                                    <div id="append_icons">  </div>

                                    <div class="row form-sec mt-4">
                                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 label-sec">
                                                <button type="submit" id="submit_form" class="common-sub-btn">Save</button>
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
@endsection
@section('script')
<script>
var existing_counter = $('#buy_count').val()
if(existing_counter && existing_counter != '')
{
    var counter = parseInt(existing_counter) + 1;
}else{
    var counter = 1;
}
$('#add_icon').click(function() {
    var html = '<div class="each-icon-details mt-3"><div class=row><div class="col-sm-12 col-xs-12 col-lg-6 col-md-6 col-xl-6 col-xxl-6"><div class=form-sec><label for="">Name <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please insert name" ><i class="fa fa-info-circle" aria-hidden="true"></i></span></label> <input id=buy_icon_name name=buy_title[] class=form-control></div></div><div class="col-sm-12 col-xs-12 col-lg-4 col-md-4 col-xl-4 col-xxl-4"><div class=form-sec><label for="">Icon <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please upload the icon" > <i class="fa fa-info-circle" aria-hidden="true"></i></span><span style="color: red;margin: 0;"> *1:1 square PNG only, max 512 px.</span></label><div class="align-items-center d-flex"><div class="input_group me-3"><label for=buy_icon_'+ counter +' class=img_upload><i class="fa fa-plus mx-1"></i> Upload</label> <input id=buy_icon_'+ counter +' name=buy_icon[] class="buy_icon" style=display:none type=file></div><div class=preview_image> <img class="preview_image icon_img img-fluid"  src="{{asset('assets/images/user/img-demo_1041.jpg')}}"></div></div></div></div><div class="col-sm-12 col-xs-12 col-lg-2 col-md-2 col-xl-2 col-xxl-2"style=text-align:end;margin-top:18px><a class="remove remove_icon" href=javascript:;><i class="fa-times-circle fas"></i></a></div></div></div>';
    $('#append_icons').append(html);
    counter++;
});
$(document).on("click",".remove_icon",function() {
    $(this).closest('.each-icon-details').remove();
});
$(document).on("change", ".buy_icon", function (e) {
    var input = e.target;
    var file = input.files[0]; // Assuming only one file is selected

    // Check if the file is an image
    if (/^image\//.test(file.type)) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $(input).closest('.each-icon-details').find('.icon_img').attr('src', e.target.result);
        };

        reader.readAsDataURL(file);
    } else {
        toastr.error('Please select a valid image file.');
        $(input).val(''); // Clear the input field
        // You may want to set a default image here as well
        $(input).next().attr('src', '{{ asset('assets/images/user/img-demo_1041.jpg') }}');
    }
});
</script>
@endsection
    