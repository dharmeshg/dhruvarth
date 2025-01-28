@extends('layouts.backend.index')
@section('main_content')

<div class="pcoded-wrapper">
    <div class="pcoded-content">
        <div class="pcoded-inner-content">
            <!-- [ breadcrumb ] start -->

            <!-- [ breadcrumb ] end -->
            <div class="main-body">
                <div class="page-wrapper">
                    <!-- [ Main Content ] start -->
                    <form action="{{ route('products-services.store') }}" method="POST" data-parsley-validate=""
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div
                                class="col-xxl-8 col-xl-8 col-lg-8 col-md-8 cpl-sm-12 col-xs-12 add-article form-main-sec ">
                                <div class="card Recent-Users">
                                    @if (isset($products_services) && $products_services != '')
                                    <h5>Edit Service</h5>
                                    @else
                                    <h5>Add Service</h5>
                                    @endif
                                    <div class="card-block px-0 py-3">

                                        <div class="row form-sec">
                                            <input type="hidden" id="products_services_id" name="products_services_id"
                                                value=" {{ isset($products_services->id) ? $products_services->id : '' }} ">
                                            <div
                                                class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12 label-sec">
                                                <label for="">Title <span
                                                        style="color: red;margin: 0;">*</span></label>
                                            </div>
                                            <div class="col-xxl-10 col-xl-10 col-lg-10 col-md-10 col-sm-12 col-xs-12">
                                                <input type="text" class="form-control" id="sub_title" name="sub_title"
                                                    required data-parsley-required-message="Please Enter Title"
                                                    placeholder="Sub Title"
                                                    value="{{ isset($products_services->sub_title) ? $products_services->sub_title : '' }}">
                                                <span id="error_name" style="color:red;display:none;">This Sub Title is
                                                    Already
                                                    Taken</span>
                                            </div>
                                        </div>

                                        <div class="row form-sec">
                                            <div
                                                class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12 label-sec">
                                                <label for="">Slug <span style="color: red;margin: 0;">*</span></label>
                                            </div>
                                            <div class="col-xxl-10 col-xl-10 col-lg-10 col-md-10 col-sm-12 col-xs-12">
                                                <input type="text" class="form-control" name="product_Slug"
                                                    id="product_slug" placeholder="Slug" required
                                                    data-parsley-required-message="Please Enter Slug"
                                                    value="{{ isset($products_services->slug) ? $products_services->slug : '' }}">
                                            </div>
                                        </div>

                                        <div class="row form-sec">
                                            <div
                                                class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12 label-sec">
                                                <label for="">Sub Title <span style="color: red;margin: 0;">*</span></label>
                                            </div>
                                            <div class="col-xxl-10 col-xl-10 col-lg-10 col-md-10 col-sm-12 col-xs-12">
                                                <input type="text" class="form-control" id="title" name="title" required
                                                    data-parsley-required-message="Please Enter Sub Title"
                                                    placeholder="Title"
                                                    value="{{ isset($products_services->title) ? $products_services->title : '' }}">
                                            </div>
                                        </div>
                                        <div class="row form-sec">
                                            <div
                                                class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12 label-sec">
                                                <label for="">Price <span style="color: red;margin: 0;">*</span></label>
                                            </div>
                                            <div class="col-xxl-10 col-xl-10 col-lg-10 col-md-10 col-sm-12 col-xs-12">
                                                <input type="text" class="form-control input-money-price" id="price"
                                                    name="price" required
                                                    data-parsley-required-message="Please Enter Price"
                                                    placeholder="Price"
                                                    value="{{ isset($products_services->price) ? $products_services->price : '' }}">
                                            </div>
                                        </div>
                                        <div class="row form-sec">
                                            <div
                                                class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12 label-sec">
                                                <label for="">Short Description <span
                                                        style="color: red;margin: 0;">*</span></label>
                                            </div>
                                            <div class="col-xxl-10 col-xl-10 col-lg-10 col-md-10 col-sm-12 col-xs-12">

                                                <textarea name="short_description" data-parsley-required="true"
                                                    class="form-control" id="short_description"
                                                    data-parsley-required-message="Please enter Content"
                                                    data-parsley-errors-container="#content_required"> {{ isset($products_services->short_description) ? $products_services->short_description : '' }} </textarea>
                                                <span class="error_field" id="content_required"></span>
                                            </div>
                                        </div>
                                        <div class="row form-sec">
                                            <div
                                                class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12 label-sec">
                                                <label for="">Description 
                                                    <!-- <span
                                                        style="color: red;margin: 0;">*</span> -->
                                                    </label>
                                            </div>
                                            <div class="col-xxl-10 col-xl-10 col-lg-10 col-md-10 col-sm-12 col-xs-12">
                                                <textarea class="form-control" name="description" id="description" style="height: 300px;"  data-parsley-required-message="Please enter Description" data-parsley-errors-container="#description_required"> {{ isset($products_services->description) ? $products_services->description : '' }} </textarea>
                                                <span class="error_field" id="description_required"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card Recent-Users next-box">
                                    <h5>Seo Meta Tags</h5>
                                    <div class="card-block px-0 py-3">
                                        <div class="row form-sec">
                                            <div
                                                class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12 label-sec">
                                                <label for="">Meta title</label>
                                            </div>
                                            <div class="col-xxl-10 col-xl-10 col-lg-10 col-md-10 col-sm-12 col-xs-12">
                                                <input type="text" name="meta_title" id="" placeholder="Type here"
                                                    value="{{ isset($products_services->meta_title) ? $products_services->meta_title : '' }}">
                                            </div>
                                        </div>
                                        <div class="row form-sec">
                                            <div
                                                class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12 label-sec">
                                                <label for="">Meta Keyword</label>
                                            </div>
                                            <div class="col-xxl-10 col-xl-10 col-lg-10 col-md-10 col-sm-12 col-xs-12">
                                                <input type="text" name="meta_keyword" id="" placeholder="Type here"
                                                    value="{{ isset($products_services->meta_keyword) ? $products_services->meta_keyword : '' }}">
                                            </div>
                                        </div>

                                        <div class="row form-sec">
                                            <div
                                                class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12 label-sec">
                                                <label for="">Meta description</label>
                                            </div>
                                            <div class="col-xxl-10 col-xl-10 col-lg-10 col-md-10 col-sm-12 col-xs-12">
                                                <textarea name="meta_description" id="" rows="5"
                                                    cols="10">{{ isset($products_services->meta_description) ? $products_services->meta_description : '' }}</textarea>
                                            </div>
                                        </div>

                                        <div class="row form-sec">
                                                
                                                <div
                                                    class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12 label-sec">
                                                    <label for="">Page Index</label>
                                                </div>
                                                <div
                                                class="col-xxl-10 col-xl-10 col-lg-10 col-md-10 col-sm-12 col-xs-12">
                                                    <label class="switch">
                                                        <input type="checkbox" id="sliderindexbutton" name="page_index" @if(isset($products_services->page_index) && $products_services->page_index == '0') @else checked @endif>
                                                        <div class="slider round">
                                                            <span class="on">Yes</span>
                                                            <span class="off">No</span>
                                                        </div>
                                                    </label>
                                                </div>
                                                
                                            </div>
                                            
                                            <div class="row form-sec">
                                                <div
                                                    class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12 label-sec">
                                                    <label for="">Canonical Url</label>
                                                </div>
                                                <div class="col-xxl-10 col-xl-10 col-lg-10 col-md-10 col-sm-12 col-xs-12">
                                                    <input type="text" name="canonical_url" id=""
                                                        placeholder="Canonical Url"
                                                        value="{{ isset($products_services->canonical_url) ? $products_services->canonical_url : '' }}">
                                                </div>
                                            </div>
                                        
                                        <div class="row">
                                            <div class="mb-3" style="display: flex; justify-content: end;">
                                                <button type="submit" id="submit_form"
                                                    class="btn btn-lg btn-primary">Save</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 cpl-sm-12 col-xs-12 add-article form-main-sec right-sec">
                                <div class="card Recent-Users">
                                    <h5>Thumbnail</h5>
                                    <div class="card-block px-0 py-3">
                                        <div class="row form-sec">
                                            <div
                                                class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 label-sec">
                                                <input type="hidden"
                                                    value="{{ isset($products_services->image) ? $products_services->image : '' }}"
                                                    name="img_id" id="img_id" required data-parsley-errors-container="#logo_required" data-parsley-trigger="change" data-parsley-required-message="Please choose an image.">
                                                <div class="upload-img-sec text-center image_preview_div">
                                                    @if (isset($image_name->name) && $image_name->name != '')
                                                    <img src="{{ asset('uploads/' . $image_name->name) }}" alt=""
                                                        class="img-fluid profile_avtar" id="profile_avtar"
                                                        style="width:125px;height:125px;">
                                                    <a id="remove_image"> <i class="fa fa-times"
                                                            aria-hidden="true"></i></a>
                                                    @else
                                                    <img src="{{ asset('assets/images/user/img-demo_1041.jpg') }}" alt=""
                                                        id="profile_avtar" class="profile-img">
                                                    <a id="remove_image" style="display: none;"> <i class="fa fa-times"
                                                            aria-hidden="true"></i></a>
                                                    @endif
                                                    <label for="file" style="cursor: pointer;"
                                                        class="form-label upload_image choose_file">Choose image</label>
                                                </div>
                                                <span class="error_field" id="logo_required"></span>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="card Recent-Users">
                                    <h5>Banner Image</h5>
                                    <div class="card-block px-0 py-3">
                                        <div class="row form-sec">
                                            <div
                                                class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 label-sec">
                                                <input type="hidden"
                                                    value="{{ isset($products_services->banner_image) ? $products_services->banner_image : '' }}"
                                                    name="banner_img_id" id="banner_img_id" required data-parsley-errors-container="#banner_img_required" data-parsley-trigger="change" data-parsley-required-message="Please choose an image.">
                                                <div class="upload-img-sec text-center image_preview_div">
                                                    @if (isset($banner_image->name) && $banner_image->name != '')
                                                    <img src="{{ asset('uploads/' . $banner_image->name) }}" alt=""
                                                        class="img-fluid profile_avtar" id="banner_profile_avtar"
                                                        style="width:125px;height:125px;">
                                                    <a id="banner_remove_image"> <i class="fa fa-times"
                                                            aria-hidden="true"></i></a>
                                                    @else
                                                    <img src="{{ asset('assets/images/user/img-demo_1041.jpg') }}" alt=""
                                                        id="banner_profile_avtar" class="profile-img">
                                                    <a id="banner_remove_image" style="display: none;"> <i class="fa fa-times"
                                                            aria-hidden="true"></i></a>
                                                    @endif
                                                    <label for="file" style="cursor: pointer;" data-val="banner_profile_avtar"
                                                        class="form-label upload_image choose_file">Choose image</label>
                                                </div>
                                                <span class="error_field" id="banner_img_required"></span>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="card Recent-Users next-box">
                                    <h5>Locations</h5>
                                    <div class="card-block px-0 py-3">
                                        <div class="row form-sec">
                                            <div
                                                class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 label-sec">
                                                <input type="text" class="form-control" id="searchTextField"
                                                    name="address" required
                                                    data-parsley-required-message="Please Enter Address"
                                                    placeholder="Address"
                                                    value="{{ isset($products_services->address) ? $products_services->address : '' }}">

                                                <div id="map" style="display:none; width: 280px; height: 300px;"></div>

                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!--[ Recent Users ] end-->

                        </div>
                    </form>
                    <!-- [ Main Content ] end -->
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
@section('script')

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote.min.js"></script> -->
<!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBi7-iLb9qYk0fDp8AgWBrh9bNT2gZ8XGY=places&callback=initAutocomplete"async defer></script> -->
<script>
$(document).ready(function() {
    $('#description').summernote({
        height: 200
    });

</script>
<script>
    $(document).ready(function () {

        $('form').parsley({
            excluded: 'input[type=hidden]:not(.visible)'
        });
        $('#submit_form').on('click', function (e) {
       

         $('#img_id').addClass('visible');
         $('#banner_img_id').addClass('visible');


            // Validate the form
            if (!$('form').parsley().validate()) {
                e.preventDefault();
            }

            // Hide the hidden input again
            $('#img_id').removeClass('visible');
            $('#banner_img_id').removeClass('visible');
            

        });
    });
</script>


<!-- <script>
function initAutocomplete() {

    new google.maps.places.Autocomplete(

        (document.getElementById('searchTextField')),

    );

}
</script> -->
<script>
const assetPath = "{{ asset('assets/images/user/img-demo_1041.jpg') }}";
$('#remove_image').click(function(event) {
    event.stopPropagation();
    $('#img_id').val(null);
    $('#profile_avtar').attr('src', assetPath);
    $('#remove_image').css('display', 'none');
    $('#profile_avtar').css('opacity', '1.0');
});

$('#banner_remove_image').click(function(event) {
    event.stopPropagation();
    $('#banner_img_id').val(null);
    $('#banner_profile_avtar').attr('src', assetPath);
    $('#banner_remove_image').css('display', 'none');
    $('#banner_profile_avtar').css('opacity', '1.0');
});
</script>
<script>
$(document).on('change', '#sub_title', function(e) {
    const $nameInput = $("#sub_title");
    const $slugInput = $("#product_slug");
    var token = $("meta[name='csrf-token']").attr("content");
    var val = $(this).val();
    $.ajax({
        url: "{{ route('products_services.check_slug') }}",
        method: "POST",
        data: {
            _token: token,
            name: val
        },
        success: function(response) {
            if (response.status == 1) {
                $('#error_name').show();
            } else {
                $('#error_name').hide();
                const nameValue = $nameInput.val();
                const slugValue = nameValue.replace(/\s+/g, "-").toLowerCase();
                $slugInput.val(slugValue);
            }
        },
        error: function(xhr, status, error) {
            toastr.error('Something Went Wrong!');
        }
    });
});


// $(document).on('click', '#searchTextField', function(e) {
// function serrch_add(input) {
//     // var input = document.getElementById('searchTextField');
//     var autocomplete = new google.maps.places.Autocomplete(input);
//     // console.log(autocomplete);
//     console.log(autocomplete);

//     var map = new google.maps.Map(document.getElementById('map'), {
//         center: {
//             lat: -34.397,
//             lng: 150.644
//         },
//         zoom: 8
//     });

//     google.maps.event.addListener(autocomplete, 'place_changed', function() {
//         var place = autocomplete.getPlace();
//         if (!place.geometry) {
//             return;
//         }

//         var customMarkerIcon = {
//             url: '{{ asset('assets/img/custom-marker.jpg') }}',
//             scaledSize: new google.maps.Size(40, 40)
//         };

//         // Create a marker with the custom icon
//         var marker = new google.maps.Marker({
//             map: map,
//             position: place.geometry.location,
//             icon: customMarkerIcon
//         });

//         // Update the map to the new location
//         map.setCenter(place.geometry.location);
//         map.setZoom(17); // You can adjust the zoom level as needed
//     });
// }
// $(document).ready(function () {
//     function initializeMap() {
//         var add = $('#searchTextField').val();
//     if (add !== "") {
//         $('#map').css('display', 'block');
//         var map;
//     var geocoder = new google.maps.Geocoder();
//     var mapOptions = {
//         zoom: 16,
//         center: { lat: 23.047871, lng: 72.601452 },
//         mapTypeId: google.maps.MapTypeId.ROADMAP
//     };

//     map = new google.maps.Map(document.getElementById("map"), mapOptions);

//     var address = add;
//     geocoder.geocode({ 'address': address }, function(results, status) {
//         if (status == google.maps.GeocoderStatus.OK) {
//             map.setCenter(results[0].geometry.location);

//             var marker = new google.maps.Marker({
//                 map: map,
//                 position: results[0].geometry.location,
//                 title: address
//             });
//         } else {
//             alert("Geocode was not successful for the following reason: " + status);
//         }
//     });
//     }
//     }

//     setTimeout(initializeMap, 2000);
//     $('#searchTextField').on('click', function () {
//        $('#map').css('display', 'block');
//         var input = document.getElementById('searchTextField');
//         serrch_add(input);
//     });
// });

// });
</script>




@endsection