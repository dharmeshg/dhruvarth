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
                    <li class="breadcum-item"><a href="{{route('pagebanner.index',['slug'=> isset($page_banner->type) ? $page_banner->type : $sec])}}"> Page Banners</a></li>
                    <li class="breadcum-item active"><a href="javascript:;"> {{isset($page_banner) ? 'Edit' : 'Add'}} Page Banner</a></li>
                </ul>
            </div>
			<div class="main-body">
				<div class="page-wrapper">
					<h3 class="">{{ isset($page_banner) ? 'Edit Page Banner' : 'Add Page Banner' }}</h3>
					<form action="{{ route('pagebanner.save') }}" id="daily_status_add" method="POST" enctype='multipart/form-data' data-parsley-validate>
						@csrf
						<input type="hidden" name="p_banner_id" value="{{ isset($page_banner->id) ? $page_banner->id : '' }}">
						<input type="hidden" name="type" value="{{ isset($page_banner->type) ? $page_banner->type : $sec }}">
						<div class="input_group mt-3">
							<div class="mb-3">
								<label>Cover Image <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please upload a cover image for page banner"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
								<p><span style="color: red;margin: 0;">*Required Size upto 5mb.</span></p>
								<div class="row">
									<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12 d-flex align-items-center">
										<div class="me-3">
											<label class="img_upload daily_status_image" for="large_file"><i class="fa fa-plus mx-1"></i> Upload</label>
											<input type="file"  style="display: none;" id="large_file" name="cover_image" class="cover-item-img"  @if(isset($page_banner->cover_image) && $page_banner->cover_image != null && $page_banner->cover_image != '') @else required @endif data-parsley-required-message="Cover Image is Required" data-parsley-errors-container="#large_cont">
										</div>
										<div>
											@if(isset($page_banner->cover_image) && $page_banner->cover_image != '' && $page_banner->cover_image != null)
											<img src="{{asset('uploads/media/'.$page_banner->cover_image)}}" class="img-fluid preview_image" id="cover-item-img-output">
											@else
											<img src="{{asset('assets/images/user/img-demo_1041.jpg')}}" class="img-fluid preview_image" id="cover-item-img-output">
											@endif
										</div>
										<input type="hidden" name="cover_old_img" value="{{ isset($page_banner->cover_image) ? $page_banner->cover_image : ''}}" id="old_img">
									</div>
								</div>
								<span id="large_cont"></span>
								<span id="error-message" style="display: none; color: red;" class="parsley-errors-list"></span>
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
                    if (input.files[0].size <= 5 * 1024 * 1024) {
                        // Image is valid
                        $('#cover-item-img-output').attr('src', e.target.result);
                        $('#error-message').hide();
                        $('.common-sub-btn').prop('disabled', false);
                    } else {
                        // Invalid image, reset input
                        $('#error-message').text('Please select a valid image with size up to 5mb.');
                        $('#error-message').show();
                        $('.common-sub-btn').prop('disabled', true);
                        $('.cover-item-img').val('');
                    }
                };
            };

            reader.readAsDataURL(input.files[0]);
        } 
	});
    </script>


    @endsection
