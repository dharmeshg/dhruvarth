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
                    <li class="breadcum-item"><a href="{{route('accesscontrole.dash_index')}}">Access Control</a></li>
                    <li class="breadcum-item active"><a href="javascript:;">Access Control</a></li>
                </ul>
            </div>
			<div class="main-body">
				<div class="page-wrapper">
					<div class="d-flex align-items-center justify-content-between">
						<h3 class="add_heading">Access Control</h3>
					</div>
					<form action="{{ route('accesscontrole.save') }}" id="daily_status_add" method="POST" enctype='multipart/form-data' data-parsley-validate>
						@csrf
						<div class="input_group row mt-3">
                            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12 mb-3">
                                <label>Login/Registration - Optional <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please Select Login/Registration - Optional"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                <div>
                                    <label class="hide_show" style="color: #888; font-weight: 400;">No</label>
                                    <input type="checkbox" class="is_featured_class login_class" id="" name="access_login_optional" @if(isset($access->access_login_optional) && $access->access_login_optional == 1) checked @endif>
                                    <label for="hide_show" style="color: #888; font-weight: 400;">Yes</label>
                                </div>
                            </div> 
                            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12 mb-3">
                                <label>Login/Registration - Mandatory <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please Select Login/Registration - Mandatory"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                <div>
                                    <label class="hide_show" style="color: #888; font-weight: 400;">No</label>
                                    <input type="checkbox" class="is_featured_class login_class" id="" name="access_login_mandatory" @if(isset($access->access_login_mandatory) && $access->access_login_mandatory == 1) checked @endif>
                                    <label for="hide_show" style="color: #888; font-weight: 400;">Yes</label>
                                </div>
                            </div> 
                            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12 mb-3">
                                <label>Unlimited Access - On Approval <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please Select Unlimited Access - On Approval"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                <div>
                                    <label class="hide_show" style="color: #888; font-weight: 400;">No</label>
                                    <input type="checkbox" class="is_featured_class access_class" id="" name="access_unlimited_access" @if(isset($access->access_unlimited_access) && $access->access_unlimited_access == 1) checked @endif>
                                    <label for="hide_show" style="color: #888; font-weight: 400;">Yes</label>
                                </div>
                            </div>
                            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12 mb-3">
                                <label>Limited Access - On Approval <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please Select Limited Access - On Approval"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                <div>
                                    <label class="hide_show" style="color: #888; font-weight: 400;">No</label>
                                    <input type="checkbox" class="is_featured_class access_class" id="" name="access_limited_access" @if(isset($access->access_limited_access) && $access->access_limited_access == 1) checked @endif>
                                    <label for="hide_show" style="color: #888; font-weight: 400;">Yes</label>
                                </div>
                            </div> 
                            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12 mb-3">
                                <label>Approval for Login <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please Select Approval For login"><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                <div>
                                    <label class="hide_show" style="color: #888; font-weight: 400;">No</label>
                                    <input type="checkbox" class="is_featured_class" id="" name="approval_for_login" @if(isset($access->approval_for_login) && $access->approval_for_login == 1) checked @endif>
                                    <label for="hide_show" style="color: #888; font-weight: 400;">Yes</label>
                                </div>
                            </div> 
                            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12">
                            </div>
                            <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-12 col-sm-12 col-xs-12 mb-3" id="start_date_div" @if(isset($access->access_limited_access) && $access->access_limited_access == 1) style="display: block;" @else style="display: none;" @endif>
                                <label>Hours </label>
                                <input class="form-control" name="global_access_hours" type="number" value="{{ isset($access->global_access_hours) ? $access->global_access_hours : '' }}" id="global_access_hours" placeholder="0.00" min="0" @if(isset($access->access_limited_access) && $access->access_limited_access == 1) required @endif data-parsley-required-message="Start Time is Required"> 
                            </div>
                            <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-12 col-sm-12 col-xs-12" id="end_date_div" @if(isset($access->access_limited_access) && $access->access_limited_access == 1) style="display: block;" @else style="display: none;" @endif>
                                <label>Minutes </label>
                                <input type="number" name="global_access_min" placeholder="0.00" value="{{ isset($access->global_access_min) ? $access->global_access_min : '' }}" class="form-control" id="global_access_min" min="0" max="60" data-parsley-range="[0, 60]"  data-parsley-range-message="Please enter a value between 0 and 60."  @if(isset($access->access_limited_access) && $access->access_limited_access == 1) required @endif data-parsley-required-message="End Date is Required">
                            </div>
                            {{-- <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12 mb-3">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="customCheck1" name="set_limited_access_user" @if(isset($access->set_limited_access_user) && $access->set_limited_access_user == 1) checked @endif>
                                    <label class="custom-control-label" for="customCheck1" style="cursor: pointer;">Set Limited Access to users having Unlimited Access</label>
                                </div>
                            </div>  --}}
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
    $(document).ready(function() {
    $('.login_class').on('change', function() {
        $('.login_class').not(this).prop('checked', false);
    });
    $('.access_class').on('change', function() {
        $('.access_class').not(this).prop('checked', false);
        if ($('input[name="access_limited_access"]').is(':checked')) {
           $('#start_date_div').show();
           $('#end_date_div').show(); 
           $('#global_access_hours').prop('required',true);
           $('#global_access_min').prop('required',true);
        }else{
            $('#start_date_div').hide();
            $('#end_date_div').hide();
            $('#global_access_hours').prop('required',false);
            $('#global_access_min').prop('required',false);
        }
    });
});
</script>
@endsection
