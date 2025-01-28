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
					<form action="{{ route('comment.save') }}" method="POST" data-parsley-validate=""
					enctype="multipart/form-data" id="home_form">
					@csrf
					<div class="row">
						<input type="hidden" name="comment_id" value="{{ isset($comments->id) ? $comments->id : '' }}">
						<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 cpl-sm-12 col-xs-12 add-article form-main-sec ">
							<div class="card Recent-Users">
								<div class="d-flex justify-content-between">
									<h5>Comment Settings</h5>
								</div>
								<div class="card-block px-0 py-3">
									<div class="row form-sec">
										<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 label-sec">
											<label for="">Default Blog settings</label>
										</div>
										<div class="col-xxl-8 col-xl-8 col-lg-8 col-md-8 col-sm-12 col-xs-12">
											<div class="custom-control custom-checkbox setting_check">
												<input type="checkbox" class="custom-control-input" id="customCheck1" name="show_comments" {{ isset($comments->show_comments) && $comments->show_comments == 1 ? 'checked' : '' }}>
												<label class="custom-control-label" for="customCheck1">Allow people to submit comments on new blogs</label>
											</div>
										</div>       
									</div> 
									<div class="row form-sec">
										<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 label-sec">
											<label for="">Other comment settings</label>
										</div>
										<div class="col-xxl-8 col-xl-8 col-lg-8 col-md-8 col-sm-12 col-xs-12">
											<div class="custom-control custom-checkbox setting_check">
												<input type="checkbox" class="custom-control-input" id="customCheck2" name="comment_details" {{ isset($comments->comment_details) && $comments->comment_details == 1 ? 'checked' : '' }}>
												<label class="custom-control-label" for="customCheck2">Comment author must fill out name and email</label>
											</div>
											<!-- <div class="custom-control custom-checkbox setting_check">
												<input type="checkbox" class="custom-control-input" id="customCheck3">
												<label class="custom-control-label" for="customCheck3">Users must be registered and logged in to comment</label>
											</div> -->
											<!-- <div class="custom-control custom-checkbox setting_check">
												<input type="checkbox" class="custom-control-input" id="customCheck3">
												<label class="custom-control-label" for="customCheck3">Automatically close comments on blogs older than
													<input type="number" name="" style="width: 65px !important;">
												days
												</label>
											</div> -->
										</div>       
									</div>   
									<button type="submit" class="btn btn-lg btn-primary" id="submit_form">Update Settings</button>
								</div>
							</div>
							<!--[ Recent Users ] end-->

						</div>
					</div>
				</form>
				<!-- [ Main Content ] end -->
			</div>
		</div>
	</div>
</div>
</div>

@endsection