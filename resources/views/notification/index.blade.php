@extends('layouts.backend.index')

<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.css'>
@section('main_content')
<style>
.is_featured_class{margin: 0px 10px -4px 10px;}
.iti--allow-dropdown{
	width: 100%;
}
#mobile_code{
	padding-left: 82px !important;
}
.radio-options .radio-inline{margin-right: 20px;cursor: pointer;}
	.radio-options .radio-inline input{margin-right: 10px;}
</style>

<div class="pcoded-wrapper">
	<div class="pcoded-content">
		<div class="pcoded-inner-content">
			<div class="custom_breadcum">
                <ul>
                    <li class="breadcum-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                    <li class="breadcum-item"><a href="{{route('daily_update.index')}}"> Daily Updates </a></li>
                    <li class="breadcum-item active"><a href="javascript:;"> Announcement</a></li>
                </ul>
            </div>
			<div class="main-body">
				<div class="page-wrapper">
					<div class="d-flex align-items-center justify-content-between">
						<h3 class="add_heading">Announcement</h3>
					</div>
					<form action="{{ route('notification.save') }}" id="daily_status_add" method="POST" data-parsley-validate>
						@csrf
						<input type="hidden" name="notification_id" value="{{ isset($notifications->id) ? $notifications->id : '' }}">
						<div class="input_group">

							<div class="mb-3">
								<div class="row">
									<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">
										<label>Title <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Title is for reference only" ><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
										<input type="text" name="title"  placeholder="Enter Title" class="form-control" required data-parsley-required-message="Please Enter Title" value="{{ isset($notifications->title) ? $notifications->title : '' }}">
									</div>
								</div>
							</div>
							<div class="mb-3">
								<div class="row">
									<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">
										<label>Link <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please insert link for notification" ><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
										<input type="url" name="link" placeholder="Enter Link" class="form-control" required data-parsley-required-message="Please Enter Link" value="{{ isset($notifications->link) ? $notifications->link : '' }}">
									</div>
								</div>
							</div>
							<div class="mb-3">
								<div class="row">
									<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">
										<label>Content <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter content to display" ><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
										<textarea class="form-control" maxlength="50" data-parsley-trigger="keyup" id="content" name="content" placeholder="Please enter Notification. Character Limit:50">{{isset($notifications->content) ? $notifications->content : ''}}</textarea>
									</div>
								</div>
							</div>
							<div class="mb-3">
								<div class="row">
									<div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">
										<label>Status <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please select Visibility Status"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
										<div>
											<label class="hide_show" style="color: #888; font-weight: 400;">Hide</label>
											<input type="checkbox" class="is_featured_class" id="" name="status" @if(isset($notifications->status) && $notifications->status == 1) checked @endif>
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
	                                        	<input type="radio" name="display" value="home" @if(isset($notifications->display) && $notifications->display == 'home') checked @endif>Home Page</label>
	                                      	<label class="radio-inline">
	                                        	<input type="radio" name="display" value="all" @if(isset($notifications->display) && $notifications->display == 'all') checked @endif>All
	                                    	</label>
                                		</div>
									</div>
								</div>
							</div>

							<div class="mb-3">
								<button type="submit" id="customer_update" class="common-submit-btn">Submit</button> 
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

</script>

@endsection
