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
                    <li class="breadcum-item"><a href="{{route('daily_update.index')}}"> Daily Updates </a></li>
                    <li class="breadcum-item"><a href="{{route('daliystatus.index')}}"> Daily Status </a></li>
                    <li class="breadcum-item active"><a href="javascript:;"> {{isset($data) ? 'Edit' : 'Add'}} Daily Status </a></li>
                </ul>
            </div>
			<div class="main-body">
				<div class="page-wrapper">
					<div class="d-flex align-items-center justify-content-between">
						<h3 class="add_heading">Daily Status - Loading popup banner</h3>
						<a href="{{ route('daliystatus.index') }}" class="back-btn">Back to Daily Status</a>
					</div>
					<form action="{{ route('daliystatus.save') }}" id="daily_status_add" method="POST" enctype='multipart/form-data' data-parsley-validate>
						@csrf
						<input type="hidden" name="status_id" value="{{ isset($data->id) ? $data->id : '' }}">
						<div class="input_group mt-3">
							<div class="mb-3">
								<label> Popup Image (square) <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please upload popup image for the daily status"><i class="fa fa-info-circle" aria-hidden="true"></i></span><span style="color: red;margin: 0;">*</label>
								<p><span style="color: red;margin: 0;">*Recommended Size: 500x500 pixel upto 500KB.</span></p>
								<div class="row">
									<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12 d-flex align-items-center">
										<div class="me-3">
											<label class="img_upload daily_status_image" for="image_file"><i class="fa fa-plus mx-1"></i> Upload</label>
											<input type="file"  style="display: none;" id="image_file" name="image" class="item-img" @if(isset($data->image) && $data->image != null && $data->image != '') @else required @endif data-parsley-required-message="Popup Image is Required">
										</div>
										<div>
											@if(isset($data->image) && $data->image != '' && $data->image != null)
												@if(file_exists(base_path('public/uploads/daily_updates/thumb/'.$data->image)))
													<img src="{{asset('uploads/daily_updates/thumb/'.$data->image)}}" class="img-fluid preview_image" id="item-img-output">
												@else
													<img src="{{asset('uploads/daily_updates/'.$data->image)}}" class="img-fluid preview_image" id="item-img-output">
												@endif
											@else
											<img src="{{asset('assets/images/user/img-demo_1041.jpg')}}" class="img-fluid preview_image" id="item-img-output">
											@endif
										</div>
										<input type="hidden" name="old_img" value="{{ isset($data->image) ? $data->image : ''}}" id="old_img">
									</div>
								</div>
							</div>
							<span id="error-message" style="display: none; color: red; margin-left: 15px;" class="parsley-errors-list"></span>
							<div class="mb-3">
								<div class="row">
									<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">
										<label>Insert Destination Link <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please insert destination link for the daily status"><i class="fa fa-info-circle" aria-hidden="true"></i></span><span style="color: red;margin: 0;"></label>
										<input type="url" name="destination_link" placeholder="Enter Destination Link" class="form-control" pattern="https?://.*" data-parsley-required-message="Destination Link is Required" value="{{ isset($data->destination_link) ? $data->destination_link : '' }}" data-parsley-pattern-message="Please enter valid url">
									</div>
								</div>
							</div>

							<div class="mb-3">
								<div class="row">
									<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">
										<label>Notification Message <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please insert notification message for the daily status"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
										<textarea class="form-control" name="notification_message"  maxlength="50" data-parsley-trigger="keyup" placeholder="Enter Notification message. Character Limit: 50" rows="5">{{ isset($data->notification_message) ? $data->notification_message : '' }}</textarea>
									</div>
								</div> 
							</div> 
							<div class="mb-3">
								<div class="row">
									<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">
										<label>Status <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please select Visibility Status"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
										<div>
											<label class="hide_show" style="color: #888; font-weight: 400;">Hide</label>
											<input type="checkbox" class="is_featured_class" id="" name="is_featured" @if(isset($data->status) && $data->status == 1) checked @endif>
											<label for="hide_show" style="color: #888; font-weight: 400;">Show</label>
										</div>
									</div> 
								</div> 
							</div>
							<div class="mb-3">
								<div class="row">
									<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">
										<label class="form-label" for="exampleFormControlInput1">Display On <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please select Visibility Status" ><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
										<div class="radio-options">
	                                    	<label class="radio-inline">
	                                        	<input type="radio" name="display" @if(isset($data->id) && $data->id != '') @else checked   @endif value="home" @if(isset($data->display) && $data->display == 'home') checked   @endif>Home Page</label>
	                                      	<label class="radio-inline">
	                                        	<input type="radio" name="display" value="all" @if(isset($data->display) && $data->display == 'all') checked @endif>All
	                                    	</label>
                                		</div>
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
    </script>
    @endsection
