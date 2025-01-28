@extends('layouts.backend.index')
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
                    <li class="breadcum-item"><a href="{{route('media.index')}}"> Media </a></li>
                    <li class="breadcum-item"><a href="{{route('adsposter.index',['slug'=> isset($ads_poster->type) ? $ads_poster->type : $sec])}}"> Ads Posters</a></li>
                    <li class="breadcum-item active"><a href="javascript:;"> {{isset($ads_poster) ? 'Edit' : 'Add'}} ADS Poster</a></li>
                </ul>
            </div>

			<div class="main-body">
				<div class="page-wrapper">
					<h3 class="">Add Poster</h3>
					<form action="{{ route('adsposter.save') }}" id="daily_status_add" method="POST" enctype='multipart/form-data' data-parsley-validate>
						@csrf
						<input type="hidden" name="poster_id" value="{{ isset($ads_poster->id) ? $ads_poster->id : '' }}">
						<input type="hidden" name="type" value="{{ isset($ads_poster->type) ? $ads_poster->type : $sec }}">
						<div class="input_group mt-3">
							<div class="mb-3">
								<label>Poster Image <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please Upload Poster Image"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
								<p><span style="color: red;margin: 0;">*Recommended Size: 600x400 pixel upto 500KB.</span></p>
								<div class="row">
									<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12 d-flex align-items-center">
										<div class="me-3">
											<label class="img_upload daily_status_image" for="large_file"><i class="fa fa-plus mx-1"></i> Upload</label>
											<input type="file"  style="display: none;" id="large_file" name="cover_image" class="cover-item-img"  @if(isset($ads_poster->cover_image) && $ads_poster->cover_image != null && $ads_poster->cover_image != '') @else required @endif data-parsley-required-message="Poster Image is Required" data-parsley-errors-container="#large_cont">
										</div>
										<div class="image-sec">
											@if(isset($ads_poster->cover_image) && $ads_poster->cover_image != '' && $ads_poster->cover_image != null)
											<img src="{{asset('uploads/media/'.$ads_poster->cover_image)}}" class="img-fluid preview_image" id="cover-item-img-output">
											<a class="show_close_icon" ><span class="remove_icons" style="left: 225px; !important;font-size: 20px !important;"><i class="fa fa-times-circle" aria-hidden="true"></i></span></a>
											@else
											<img src="{{asset('assets/images/user/img-demo_1041.jpg')}}" class="img-fluid preview_image" id="cover-item-img-output">
											<a class="show_close_icon" style="display: none;"><span class="remove_icons" style="left: 225px; !important;font-size: 20px !important;"><i class="fa fa-times-circle" aria-hidden="true"></i></span></a>
											@endif

												<input type="hidden" name="cover_old_img" class="cover_old_img" value="{{ isset($ads_poster->cover_image) ? $ads_poster->cover_image : ''}}" id="old_img">
										</div>
									
									</div>
								</div>
								<span id="large_cont"></span>
								<span id="error-message" style="display: none; color: red;" class="parsley-errors-list"></span>
							</div>
							<div class="mb-3">
								<div class="row">
									<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">
										<label>Status <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please select Visibility Status"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
										<div>
											<label class="hide_show" style="color: #888; font-weight: 400;">Hide</label>
											<input type="checkbox" class="is_featured_class me-3" id="status" name="status"  data-parsley-multiple="is_featured" @if(isset($ads_poster->status) && $ads_poster->status == 1) checked @endif>
											<label for="hide_show" style="color: #888; font-weight: 400;">Show</label>
										</div>
									</div> 
								</div> 
							</div>
							<div class="mb-3">
								<div class="row">
									<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">
										<label class="form-label" for="exampleFormControlInput1">Destination <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please Select Destination"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
										<select class="form-control" name="select_type" id="select_type">
										<option disabled selected>Select</option>
										<option value="URL"  @if(isset($ads_poster->select_type) && $ads_poster->select_type == "URL") selected  @endif >URL</option>
										<option value="Catalogue" @if(isset($ads_poster->select_type) && $ads_poster->select_type == "Catalogue") selected  @endif >Catalogue</option>
										<option value="Collection" @if(isset($ads_poster->select_type) && $ads_poster->select_type == "Collection") selected  @endif >Collection</option>
									</select>
								</div>
							</div>
						</div>
						<div class="mb-3">
							<div class="row">
								<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12" @if(isset($ads_poster->select_type) && $ads_poster->select_type == "URL") style="display: block;" @else style="display: none;"  @endif   id="insert_link">
									<label>Insert Link <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter the Destination Link for Poster"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
									<input type="url" name="destination_link" id="destination_link"  class="form-control" data-parsley-required-message="Please enter the Destination Link for Poster" @if(isset($ads_poster->select_type) && $ads_poster->select_type == "URL") required @endif value="@if(isset($ads_poster->select_type) && $ads_poster->select_type == 'URL') {{$ads_poster->destination_link}} @endif">
								</div>
								<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12" @if(isset($ads_poster->select_type) && $ads_poster->select_type == "Catalogue") style="display: block; required" @else style="display: none;"  @endif id="catalogue_type">
									<label class="form-label" for="exampleFormControlInput1">Catalogue <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please select catalogue for the poster"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
									<select class="form-control" data-parsley-required-message="Please Select Catalogue" @if(isset($ads_poster->select_type) && $ads_poster->select_type == "Catalogue") required @endif name="catalogue" id="catalogue">
									<option disabled selected>Select</option>
									@if(isset($catalogs) && count($catalogs) > 0)
									@foreach($catalogs as $catlog)
									@php
									$url = route('catalogue.product',['id' => $catlog->slug])
									@endphp
									<option value="{{ $url }}" {{ isset($ads_poster->destination_link) && $ads_poster->destination_link ==  $url ? 'selected' : '' }}>{{ $catlog->name }}</option>
									@endforeach
									@endif
								</select>
							</div>
							<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12" @if(isset($ads_poster->select_type) && $ads_poster->select_type == "Collection") style="display: block;" @else style="display: none; required"  @endif id="collection_type">
								<label class="form-label" for="exampleFormControlInput1">Collection <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please select collection for the poster"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
								<select class="form-control" data-parsley-required-message="Please Select Collection" name="collection" @if(isset($ads_poster->select_type) && $ads_poster->select_type == "Collection") required @endif  id="collection">
									<option disabled selected>Select</option>
									@if(isset($collections) && count($collections) > 0)
									@foreach($collections as $collection)
									@php
									$url = route('collection.catalogues',['id' => $collection->slug])
									@endphp
									<option value="{{ $url }}" {{ isset($ads_poster->destination_link) && $ads_poster->destination_link ==  $url ? 'selected' : '' }}>{{ $collection->name }}</option>
									@endforeach
									@endif
								</select>
							</div>
						</div>
					</div>

					<div class="mb-3">
						<button type="submit" class="common-sub-btn">Submit</button> 
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
	$('.cover-item-img').on('change', function () { 

	var input = this;

        if (input.files && input.files[0]) {
        	if (!input.files[0].type.startsWith('image/')) {
	            $('#error-message').text('Please select a valid image file.');
	            $('#error-message').show();
	            $('.common-sub-btn').prop('disabled', true);
	            $('.cover-item-img').val('');
	            return;
	        }
            var reader = new FileReader();

            reader.onload = function (e) {
                var img = new Image();
                img.src = e.target.result;


                img.onload = function () {
                    // if (img.width === 600 && img.height === 400 ) {
                        // Image is valid

                        $('#cover-item-img-output').attr('src', e.target.result);
                        $('#error-message').hide();
                        $('.common-sub-btn').prop('disabled', false);
                        $('#old_img').val();
                        $('.show_close_icon').css('display','block');


                    // } else {
                    //     // Invalid image, reset input
                    //     $('#error-message').text('Please select a valid image with dimensions 600x400 and size up to 500kb.');
                    //     $('#error-message').show();
                    //     $('.common-sub-btn').prop('disabled', true);
                    //     $('.cover-item-img').val('');
                    // }
                };
            };

            reader.readAsDataURL(input.files[0]);
        } 
	});
    </script>
    <script>
    	$(document).on('change', '#select_type', function() {
    		var check_type = $('#select_type').val();
    		if(check_type == 'URL'){
    			$("#insert_link").css('display','block');
    			$("#catalogue_type").css('display','none');
    			$("#collection_type").css('display','none');
    			$('#destination_link').prop('required', true);
    			$('#catalogue').prop('required', false);
    			$('#catalogue').prop('required', false);


    		}else if (check_type == 'Collection') {
    			$("#insert_link").css('display','none');
    			$("#catalogue_type").css('display','none');
    			$("#collection_type").css('display','block');
    			$('#collection').prop('required', true);
    			$('#destination_link').prop('required', false);
    			$('#catalogue').prop('required', false);


    		}else if (check_type == 'Catalogue') {
    			$("#insert_link").css('display','none');
    			$("#catalogue_type").css('display','block');
    			$("#collection_type").css('display','none');
    			$('#catalogue').prop('required', true);
    			$('#collection').prop('required', false);
    			$('#destination_link').prop('required', false);
    		}

    	});

    	$(document).on("click", ".show_close_icon", function() { 
	        var $this = $(this);
	        $this.closest('.image-sec').find('#old_img').val(''); 
	        $this.closest('.image-sec').find('.preview_image').attr('src', '{{asset('assets/images/user/img-demo_1041.jpg')}}'); 
	        // $('#old_img').val('');
	        $this.hide();
	    });
    </script>

    @endsection
