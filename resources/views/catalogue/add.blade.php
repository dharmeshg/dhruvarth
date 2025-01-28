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
                    <li class="breadcum-item"><a href="{{route('product_all.index')}}"> Inventory </a></li>
                    <li class="breadcum-item"><a href="{{route('catalogue.index')}}"> Catalogue</a></li>
                    <li class="breadcum-item active"><a href="javascript:;"> {{ isset($catalogue) ? 'Edit' : 'Add' }} Catalogue</a></li>
				</ul>
			</div>

			<div class="main-body">
				<div class="page-wrapper">
					<div class="d-flex align-items-center justify-content-between">
						<h3 class="">{{ isset($catalogue) ? 'Edit' : 'Add' }} Catalogue</h3>
						<a href="{{ route('catalogue.index') }}" class="back-btn">Back to Catalogue</a>
					</div>
					<form action="{{ route('catalogue.save') }}" id="daily_status_add" method="POST" enctype='multipart/form-data' data-parsley-validate>
						@csrf
						<input type="hidden" name="catalogue_id" value="{{ isset($catalogue->id) ? $catalogue->id : '' }}">
						<div class="input_group mt-3">
							<div class="mb-3">
								<div class="row">
									<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">
										<label>Catalogue Name <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter Catalogue Name"><i class="fa fa-info-circle" aria-hidden="true"></i></span><span style="color: red;margin: 0;">*</label>
										<input type="text" name="name" class="form-control" required data-parsley-required-message="Catalogue Name is Required" placeholder="Enter Catalogue Name" value="{{ isset($catalogue->name) ? $catalogue->name : '' }}">
									</div>
								</div>
							</div>
							<div class="mb-3">
								<div class="row">
									<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">
										<label>Status <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select Visibility Status"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
										<div>
											<label class="hide_show" style="color: #888; font-weight: 400;">Hide</label>
											<input type="checkbox" class="is_featured_class" id="" name="status" @if(isset($catalogue->status) && $catalogue->status == 1) checked @endif>
											<label for="hide_show" style="color: #888; font-weight: 400;">Show</label>
										</div>
									</div> 
								</div> 
							</div>
							<div class="mb-3">
								<label>Cover Image <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please upload cover image for catalogue"><i class="fa fa-info-circle" aria-hidden="true"></i></span><span style="color: red;margin: 0;">*</label>
								<p><span style="color: red;margin: 0;">*Recommended Size: 400x400 pixel upto 500KB.</span></p>
								<div class="row">
									<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12 d-flex align-items-center">
										<div class="me-3">
											<label class="img_upload daily_status_image" for="large_file"><i class="fa fa-plus mx-1"></i> Upload</label>
											<input type="file"  style="display: none;" id="large_file" name="cover_image" class="cover-item-img">
										</div>
										<div>
											@if(isset($catalogue->cover_image) && $catalogue->cover_image != '' && $catalogue->cover_image != null)
											<div class="p_img_parent" style="position: relative;">
												<img src="{{asset('uploads/catalogue/'.$catalogue->cover_image)}}" class="img-fluid preview_image" id="cover-item-img-output">
												<a><span class="remove_icons"><i class="fa fa-times-circle" aria-hidden="true"></i></span></a>
											</div>
											@else
											<div class="p_img_parent" style="position: relative;">
											<img src="{{asset('assets/images/user/img-demo_1041.jpg')}}" class="img-fluid preview_image" id="cover-item-img-output">
											<a><span class="remove_icons" style="display: none;"><i class="fa fa-times-circle" aria-hidden="true"></i></span></a>
											</div>
											@endif
										</div>
										<input type="hidden" name="cover_old_img" value="{{ isset($catalogue->cover_image) ? $catalogue->cover_image : ''}}" id="old_img">
									</div>
								</div>
								<span id="large_cont"></span>
								<span id="error-message" style="display: none; color: red;" class="parsley-errors-list"></span>
							</div>
							<!-- <div class="mb-3">
								<div class="row">
									<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">
										<label>Destination Link <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter destination link for catalogue"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
										<input type="text" name="link" class="form-control" data-parsley-required-message="Destination is Required" placeholder="Enter Destination Link"  value="{{ isset($catalogue->link) ? $catalogue->link : '' }}">
									</div>
								</div>
							</div> -->
							<!-- <div class="mt-4">
								<a class="add-catalogue-btn"> + Add Products In Catalogue </a>
							</div> -->
							<div class="mt-4">
								<button type="submit" class="common-sub-btn">Save</button> 
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
	$(document).on("click", ".remove_icons", function() {
		$('#old_img').val('');
		$('#cover-item-img-output').attr('src', '{{asset('assets/images/user/img-demo_1041.jpg')}}');
		$(this).hide();
	});
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
					// if (img.width === 360 && img.height === 360 ) {
                        // Image is valid
                        $('#cover-item-img-output').attr('src', e.target.result);
                        $('#error-message').hide();
                        $('.remove_icons').show();
                        $('.common-sub-btn').prop('disabled', false);
                    // } else {
                    //     // Invalid image, reset input
                    //     $('#error-message').text('Please select a valid image with dimensions 360x360 and size up to 500kb.');
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

</script>

@endsection
