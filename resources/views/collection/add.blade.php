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
                    <li class="breadcum-item"><a href="{{route('collection.index')}}"> Collection</a></li>
                    <li class="breadcum-item active"><a href="javascript:;"> {{ isset($collection) ? 'Edit' : 'Add' }} Collection</a></li>
				</ul>
			</div>

			<div class="main-body">
				<div class="page-wrapper">
					<div class="d-flex align-items-center justify-content-between">
						<h3 class="">{{ isset($collection) ? 'Edit' : 'Add' }} Collection</h3>
						<a href="{{ route('collection.index') }}" class="back-btn">Back to Collection</a>
					</div>
					<form action="{{ route('collection.save') }}" id="daily_status_add" method="POST" enctype='multipart/form-data' data-parsley-validate>
						@csrf
						<input type="hidden" name="collection_id" value="{{ isset($collection->id) ? $collection->id : '' }}">
						<div class="input_group mt-3">
							<div class="mb-3">
								<div class="row">
									<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">
										<label>Collection Name <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter collection name"><i class="fa fa-info-circle" aria-hidden="true"></i></span><span style="color: red;margin: 0;">*</label>
										<input type="text" name="name" class="form-control" required data-parsley-required-message="Catalogue Name is Required" placeholder="Enter Collection Name" value="{{ isset($collection->name) ? $collection->name : '' }}">
									</div>
								</div>
							</div>
							<div class="mb-3">
								<div class="row">
									<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">
										<label>Status <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please select Visibility Status"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
										<div>
											<label class="hide_show" style="color: #888; font-weight: 400;">Hide</label>
											<input type="checkbox" class="is_featured_class" id="" name="status" @if(isset($collection->status) && $collection->status == 1) checked @endif>
											<label for="hide_show" style="color: #888; font-weight: 400;">Show</label>
										</div>
									</div> 
								</div> 
							</div>
							<div class="mb-3">
								<label>Cover Image <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please upload cover image for collection"><i class="fa fa-info-circle" aria-hidden="true"></i></span><span style="color: red;margin: 0;">*</label>
								<p><span style="color: red;margin: 0;">*Recommended	Size: 400x400 pixel upto 500KB.</span></p>
								<div class="row">
									<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12 d-flex align-items-center">
										<div class="me-3">
											<label class="img_upload daily_status_image" for="large_file"><i class="fa fa-plus mx-1"></i> Upload</label>
											<input type="file"  style="display: none;" id="large_file" name="cover_image" class="cover-item-img" >
										</div>
										<div>
											@if(isset($collection->cover_image) && $collection->cover_image != '' && $collection->cover_image != null)
											<div class="p_img_parent" style="position: relative;">
												<img src="{{asset('uploads/collections/'.$collection->cover_image)}}" class="img-fluid preview_image" id="cover-item-img-output">
												<a><span class="remove_icons"><i class="fa fa-times-circle" aria-hidden="true"></i></span></a>
											</div>
											@else
											<div class="p_img_parent" style="position: relative;">
												<img src="{{asset('assets/images/user/img-demo_1041.jpg')}}" class="img-fluid preview_image" id="cover-item-img-output">
												<a><span class="remove_icons" style="display: none;"><i class="fa fa-times-circle" aria-hidden="true"></i></span></a>
											</div>
											@endif
										</div>
										<input type="hidden" name="cover_old_img" value="{{ isset($collection->cover_image) ? $collection->cover_image : ''}}" id="old_img">
									</div>
								</div>
								<span id="large_cont"></span>
								<span id="error-message" style="display: none; color: red;" class="parsley-errors-list"></span>
							</div>
							<!-- <div class="mb-3">
								<div class="row">
									<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">
										<label>Destination Link <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter destination link"><i class="fa fa-info-circle" aria-hidden="true"></i></span><span style="color: red;margin: 0;">*</label>
										<input type="text" name="link" class="form-control" required data-parsley-required-message="Destination is Required"  placeholder="Enter Destination Link" value="{{ isset($collection->link) ? $collection->link : '' }}">
									</div>
								</div>
							</div> -->
							<div class="mb-3">
								<div class="row">
									<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">
										<label>Collection Description <span data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter collection description"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
										<textarea class="form-control" maxlength="100" name="description" placeholder="Enter Collection Description. Character Limit:100" data-parsley-trigger="keyup" rows="5" cols="5">{{ isset($collection->description) ? $collection->description : '' }}</textarea>
									</div>
								</div>
							</div>
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
				 $('.remove_icons').show();
				$('.common-sub-btn').prop('disabled', true);
				$('.cover-item-img').val('');
				return;
			}
			var reader = new FileReader();

			reader.onload = function (e) {
				var img = new Image();
				img.src = e.target.result;

				img.onload = function () {
					// if (img.width === 250 && img.height === 250 ) {
                        // Image is valid
                        $('#cover-item-img-output').attr('src', e.target.result);
                        $('#error-message').hide();
                        $('.common-sub-btn').prop('disabled', false);
                    // } else {
                    //     // Invalid image, reset input
                    //     $('#error-message').text('Please select a valid image with dimensions 250x250 and size up to 500kb.');
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
