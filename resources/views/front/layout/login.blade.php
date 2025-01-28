
 <style type="text/css">
    .text-danger{
        width: 100%;
        margin-top: .25rem;
        font-size: .875em;
        color: #dc3545;
    }   
 </style>
<section class="popup-section">
    <div class="modal fade login-popup" id="login-popup" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div id="mobile_number"></div>
                <div class="modal-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" id="login-modal-close-btn">x</button>

                    <div class="my-account-detail">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#login" role="tab">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#signup" role="tab">Sign up</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="login" role="tabpanel">
                                <div class="user-form-single">
                                    <div class="row">
                                        <div class="col-12" id="login_email_div">
                                            <div class="form-group">
                                                <label class="control-label">Enter Your Email Or Mobile Number</label>
                                                <input type="email" id="login-email" class="form-control" name="email"
                                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Email is required"
                                                    onkeyup="checkValueStringOrNumber('email')">
                                                <input type="hidden" name="role" value="customer" id="user_role">
                                            </div>
                                            <div class="invalid-feedback msg_email_for_login" id="msg_email"></div>
                                        </div>
                                        <div class="col-12 d-none" id="login_mobile_div">
                                            <div class="form-group telphone-field">
                                                <!-- <span class="flag-code"><input type="tel" id="login_mobile_number"
                                                        name="login_mobile_number" class="form-control"></span> -->
                                                <label class="control-label login_mobile">Enter Your Email Or Mobile
                                                    Number</label>
                                                    <input type="hidden" class="country_code" id="country_code_login" name="country_code_login" value="in">
                                                        <input type="hidden" id="country_number_login" name="country_number_login" value="91">
                                                <input type="tel" name="login_mobile" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="Mobile number is required"
                                                    id="login_mobile" onkeyup="checkValueStringOrNumber('mobile')"
                                                    class="form-control login_mobile" max="10">
                                            </div>
                                            <div class="invalid-feedback" id="msg_mobile4"></div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group password-show">
                                                <label class="control-label">Enter Password</label>
                                                <input type="password" id="login_password" class="form-control"
                                                    name="login_password" data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="Password is required">
                                                <span class="fa fa-eye-slash mt-4" id="hide_password_login"></span>
                                                <span class="fa fa-eye mt-4 d-none" id="show_password_login"></span>
                                            </div>
                                            <span class="invalid-feedback text-dark-gray"
                                                id="msg_login_password"></span>
                                            
                                        </div>

                                        <div class="col-12">    
                                            <a class="text-dark-gray float-right" id="forgot_password"
                                                onclick="showForgotPasswordModal()">Forgot password?</a>
                                        </div> 
                                        <div class="col-12">
                                            <div id="g-recaptcha-response1" class="g-recaptcha" data-sitekey="{{env('G_SITE_KEY')}}" data-callback="loginCallback"></div>
                                            <span id="msg_rec_name1" class="text-danger"></span>
                                            <input type="hidden" id="msg_rec_name_checked" name="msg_rec_name_checked">
                                        </div>
                                    </div>
                                </div>
                                <div class="alert alert-danger d-none res-msg" id="login_alert">
                                    <div class="row">
                                        <div id="login_alert_msg"></div>
                                        <div class="ml-2">
                                            <a href="https://api.whatsapp.com/send?phone=+{{$bs->country_code_number.''.$bs->whatsapp_number}}&text=Hi, I am not able to login to my account, please advise. Thank you."
                                                target="_blank">
                                                <i class="fab fa-whatsapp res-icon"></i> +{{$bs->country_code_number.''.$bs->whatsapp_number}}</a> or
                                            <a href="{{route('home.contact_us')}}" class=""> &nbsp;Contact Us</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="user-form-single mt-2" id="user_login_button">
                                    <div class="submit-btn">
                                        <button type="button" id="user_login1" onclick="userLogin()">Login</button>
                                    </div>
                                </div>
                                <div class="form-content">
                                    <p>Dont have an account? <a onclick="activaTab('signup')">Sign
                                            up</a> Now
                                    </p>
                                    <p id="skip_login_text"><a data-bs-dismiss="modal">Skip</a> Login For Now</p>
                                    <p>Contact support : <a
                                            href="https://api.whatsapp.com/send?phone={{$bs->country_code_number.''.$bs->whatsapp_number}}&text=Hi, I am not able to login to my account, please advise. Thank you."
                                            target="_blank">
                                            <i class="fab fa-whatsapp res-icon"></i> +{{$bs->country_code_number.''.$bs->whatsapp_number}}</a> or
                                        <a href="{{route('home.contact_us')}}" class=""> &nbsp;Contact Us</a>
                                    </p>
                                </div>
                            </div>
                            <div class="tab-pane" id="signup" role="tabpanel">
                                <form class="contact-detail parsley-examples" method="post" id="registration_form"
                                    role="form" enctype="multipart/form-data">
                                    @csrf
                                    <div class="user-form-single">
                                        <div class="row">
                                            @if(isset($rs['full_name']) && $rs['full_name']->display != null && $rs['full_name']->display == 1)
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label class="control-label">Enter Your Name</label>
                                                    <input type="text" name="reg_name" id="reg_name" value=""
                                                        class="form-control" data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="Name Required" parsley-trigger="change"
                                                        data-parsley-required-message="Name Required"
                                                        data-parsley-pattern="/^[a-zA-Z ]+$/" required="">
                                                </div>
                                                <span id="msg_reg_name" class="text-danger"></span>
                                            </div>
                                            @endif
                                            @if(isset($rs['mobile']) && $rs['mobile']->display != null && $rs['mobile']->display == 1)
                                            <div class="col-12">
                                                <div class="form-group telphone-field">
                                                    <label class="control-label login_mobile">Enter Your Mobile
                                                        Number</label>
                                                        <input type="hidden" class="country_code" id="country_code" name="country_code" value="in">
                                                        <input type="hidden" id="country_number" name="country_number" value="91">
                                                    <input type="tel" name="reg_mobile" id="reg_mobile" minlength="10"
                                                        maxlength="10" data-parsley-type="digits" value=""
                                                        class="form-control login_mobile" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="Mobile Number is Required"
                                                        data-original-title="Mobile Number is Required."
                                                        parsley-trigger="change"
                                                        data-parsley-required-message="Mobile Number is Required."
                                                        required="" placeholder="">
                                                </div>
                                                <span id="msg_mobile" class="text-danger"></span>
                                            </div>
                                            @endif
                                            @if(isset($rs['email']) && $rs['email']->display != null && $rs['email']->display == 1)
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label class="control-label">Enter Your Email</label>
                                                            <input type="email" name="reg_email" id="reg_email"
                                                                class="form-control" data-bs-toggle="tooltip"
                                                                data-bs-placement="top" title="Email Required"
                                                                parsley-trigger="change"
                                                                data-parsley-required-message="Email Required"
                                                                required="">
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="col-auto mt-sm-3 mb-sm-0 text-center text-md-center p-link">
                                                        <a href="javascript:void(0)" id="reg_send_email_otp"
                                                            name="reg_send_email_otp" onclick="sendRegOtp()">Send
                                                            OTP <span class="spinner_btn" style="display:none"><img src="{{ asset('front/src/images/white-spinner.svg') }}"></span></a>
                                                        <a href="javascript:void(0)" id="reg_resend_email_otp"
                                                            name="reg_resend_email_otp" onclick="ResendRegOtp()"
                                                            class="d-none">Resend
                                                            OTP <span class="spinner_btn" style="display:none"><img src="{{ asset('front/src/images/white-spinner.svg') }}"></span></a>
                                                    </div> 
                                                </div>
                                                <span id="msg_email_reg" class="text-danger"></span>
                                                <div class="d-none" id="reg_send_expired_otp">
                                                    Code Expires In : <span id="reg_login_timer"></span></div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label class="control-label">Enter OTP</label>
                                                    <input type="text" name="reg_otp" id="reg_otp" value=""
                                                        class="form-control" data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="OTP Required" parsley-trigger="change"
                                                        data-parsley-required-message="OTP Required" required="">
                                                </div>
                                                <span id="msg_reg_otp" class="text-danger"></span>
                                            </div> 
                                            @endif
                                            @if(isset($rs['password']) && $rs['password']->display != null && $rs['password']->display == 1)
                                            <div class="col-6">
                                                <div class="form-group password-show">
                                                    <label class="control-label">Enter Password</label>
                                                    <input type="password" name="registration_password"
                                                        id="registration_password" value="" class="form-control"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="Password Required" parsley-trigger="change"
                                                        data-parsley-required-message="Password Required" minlength="6"
                                                        required="">
                                                    <span class="fa fa-eye-slash mt-4" id="hide_password_reg"></span>
                                                    <span class="fa fa-eye mt-4 d-none" id="show_password_reg"></span>
                                                </div>
                                                <span id="msg_password" class="text-danger"></span>
                                            </div>
                                            
                                            <div class="col-6">
                                                <div class="form-group password-show">
                                                    <label class="control-label">Confirm Password</label>
                                                    <input type="password" name="confirm_password"
                                                        id="confirm_password" value="" class="form-control"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="Confirm Password Required" parsley-trigger="change"
                                                        data-parsley-required-message="Confirm Password Required" minlength="6"
                                                        required="">
                                                    <span class="fa fa-eye-slash mt-4" id="hide_password_reg"></span>
                                                    <span class="fa fa-eye mt-4 d-none" id="show_password_reg"></span>
                                                </div>
                                                <span id="cmsg_password" class="text-danger"></span>
                                            </div>
                                            @endif
                                            @if(isset($rs['business_name']) && $rs['business_name']->display != null && $rs['business_name']->display == 1)
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label class="control-label">Business Name</label>
                                                    <input type="text" name="business_name" id="business_name" value=""
                                                        class="form-control" data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="Business Name" parsley-trigger="change"
                                                        data-parsley-required-message="Business Name is required" required="">
                                                </div>
                                                <span id="msg_business_name" class="text-danger"></span>
                                            </div> 
                                            @endif
                                            @if(isset($rs['gat_number']) && $rs['gat_number']->display != null && $rs['gat_number']->display == 1)
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label class="control-label">GST Number</label>
                                                    <input type="text" name="gst_number" id="gst_number" value=""
                                                        class="form-control" data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="GST Number" parsley-trigger="change"
                                                        data-parsley-required-message="GST Number is required" required="">
                                                </div>
                                                <span id="msg_gst_number" class="text-danger"></span>
                                            </div> 
                                            @endif
                                            @if(isset($rs['country_state_city']) && $rs['country_state_city']->display != null && $rs['country_state_city']->display == 1)
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label class="control-label">Country</label>
                                                    <select class="form-control" id="reg_country" name="country">
                                                        <option value="">Select</option>
                                                        @if(isset($all_countries) && count($all_countries) > 0)
                                                        @foreach($all_countries as $country)
                                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                                        @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                                <span id="msg_country" class="text-danger"></span>
                                            </div>
                                            @endif
                                            @if(isset($rs['country_state_city']) && $rs['country_state_city']->display != null && $rs['country_state_city']->display == 1)
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label class="control-label">State</label>
                                                    <select class="form-control" id="reg_state" name="state">
                                                        <option value="">Select</option>
                                                    </select>
                                                </div>
                                                <span id="msg_state" class="text-danger"></span>
                                            </div>
                                            @endif
                                            @if(isset($rs['country_state_city']) && $rs['country_state_city']->display != null && $rs['country_state_city']->display == 1)
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label class="control-label">City</label>
                                                    <select class="form-control" id="reg_city" name="city">
                                                        <option value="">Select</option>
                                                    </select>
                                                </div>
                                                <span id="msg_city" class="text-danger"></span>
                                            </div>
                                            @endif
                                            @if(isset($rs['address_1']) && $rs['address_1']->display != null && $rs['address_1']->display == 1)
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label class="control-label">Address Line 1</label>
                                                    <input type="text" name="address_1" id="address_1" value=""
                                                        class="form-control" data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="Address Line 1" parsley-trigger="change"
                                                        data-parsley-required-message="Address Line 1 is required" required="">
                                                </div>
                                                <span id="msg_address_1" class="text-danger"></span>
                                            </div> 
                                            @endif
                                            @if(isset($rs['address_2']) && $rs['address_2']->display != null && $rs['address_2']->display == 1)
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label class="control-label">Address Line 2</label>
                                                    <input type="text" name="address_2" id="address_2" value=""
                                                        class="form-control" data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="Address Line 2" parsley-trigger="change"
                                                        data-parsley-required-message="Address Line 2 is required" required="">
                                                </div>
                                                <span id="msg_address_2" class="text-danger"></span>
                                            </div>
                                            @endif
                                            @if(isset($rs['website']) && $rs['website']->display != null && $rs['website']->display == 1)
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label class="control-label">Website</label>
                                                    <input type="text" name="website" id="website" value=""
                                                        class="form-control" data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="Website" parsley-trigger="change"
                                                        data-parsley-required-message="Website is required" required="">
                                                </div>
                                                <span id="msg_website" class="text-danger"></span>
                                            </div> 
                                            @endif
                                            @if(isset($rs['business_card']) && $rs['business_card']->display != null && $rs['business_card']->display == 1)
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label class="control-label">Business Card Image</label>
                                                    <input type="file" name="business_card" id="business_card" value=""
                                                        class="form-control" data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="Business Card" parsley-trigger="change"
                                                        data-parsley-required-message="Business Card is required" required="">
                                                </div>
                                                <span id="msg_business_Card" class="text-danger"></span>
                                            </div> 
                                            @endif
                                            @if(isset($rs['social_1']) && $rs['social_1']->display != null && $rs['social_1']->display == 1)
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label class="control-label">Social 1</label>
                                                    <input type="text" name="social_1" id="social_1" value=""
                                                        class="form-control" data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="Social 1" parsley-trigger="change"
                                                        data-parsley-required-message="Social 1 is required" required="">
                                                </div>
                                                <span id="msg_social_1" class="text-danger"></span>
                                            </div> 
                                            @endif
                                            @if(isset($rs['social_2']) && $rs['social_2']->display != null && $rs['social_2']->display == 1)
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label class="control-label">Social 2</label>
                                                    <input type="text" name="social_2" id="social_2" value=""
                                                        class="form-control" data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="Social 2" parsley-trigger="change"
                                                        data-parsley-required-message="Social 2 is required" required="">
                                                </div>
                                                <span id="msg_social_2" class="text-danger"></span>
                                            </div> 
                                            @endif
                                            <div class="col-12 mt-3">
                                                <div class="custom-checkbox">
                                                    <input name="terms" class="checkbox-custom" id="terms" value="true"
                                                        type="checkbox">
                                                    <label class="checkbox-custom-label" for="terms">I accept the
                                                        <u><a href="{{route('front.terms_and_condition')}}">Terms & Conditions</a></u></label>
                                                </div>
                                                
                                            </div>
                                            <div class="col-12 mt-3">
                                                <div id="g-recaptcha-response" class="g-recaptcha" data-sitekey="{{env('G_SITE_KEY')}}" data-callback="registerCallback"></div>
                                                <span id="msg_rec_name" class="text-danger"></span>
                                                <input type="hidden" id="rec_name_checked" name="rec_name_checked">
                                            </div> 
                                        </div>
                                    </div>
                                    <div class="user-form-single">
                                        <div class="submit-btn">

                                            <button type="button" value="Sign up" id="register_btn"
                                                class="form-submit-btn g-recaptcha w-auto"
                                                data-action='submit' onclick="saveData();"
                                                >Sign up</button>
                                        </div>
                                    </div>
                                </form>
                                <div class="form-content">
                                    <p>Already have an account? <a onclick="activaTab('login')">Login
                                            Now</a>
                                    </p>
                                    <p><a data-bs-dismiss="modal">Skip</a> Sign up For Now</p>
                                    <p>Contact support : <a
                                            href="https://api.whatsapp.com/send?phone=+{{$bs->country_code_number.''.$bs->whatsapp_number}}&text=Hi, I am not able to login to my account, please advise. Thank you."
                                            target="_blank">
                                            <i class="fab fa-whatsapp res-icon"></i>
                                            +{{$bs->country_code_number.''.$bs->whatsapp_number}}</a>
                                        or
                                        <a href="{{route('home.contact_us')}}" class=""> &nbsp;Contact Us</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade login-popup width-700" id="forgotPasswordModal" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body d-block">
                    <button type="button" class="btn-close" data-bs-dismiss="modal">x</button>
                    <h5>Forgot Password</h5>

                    <div class="user-form-single mt-2">
                        <div class="row">
                            <div class="col-12" id="forgot_password_email_div">
                                <div class="form-group">
                                    <label class="control-label">Enter Your Email Address</label>
                                    <input type="email" id="email2" class="form-control" name="email2"
                                        data-toggle="tooltip" data-placement="top" title="Email is required"
                                        onkeyup="checkForgetPasswordValueStringOrNumber('email')">
                                </div>
                                <div class="invalid-feedback msg_email_for_login" id="msg_email2"></div>
                            </div>
                        </div>
                    </div>
                    <div class="user-form-single mt-2" id="user_login_button">
                        <div class="submit-btn">
                            <button type="button" id="forgot_password" onclick="forgetPassword()">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade login-popup width-700" id="changePasswordModal" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body d-block">
                    <button type="button" class="btn-close" data-bs-dismiss="modal">x</button>
                    <h5>Update Password</h5>

                    <div id="message_update_password"></div>
                    <div class="user-form-single mt-2">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="control-label">Enter Temporary Access Code</label>
                                    <input type="text" id="temporary_access_code" class="form-control"
                                        name="temporary_access_code" data-toggle="tooltip" data-placement="top"
                                        title="Temporary Access Code required">
                                </div>
                                <div class="invalid-feedback" id="msg_temp_access_code"></div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="control-label">Enter new Password</label>
                                    <input type="password" id="new_update_password" class="form-control"
                                        name="new_update_password" data-toggle="tooltip" data-placement="top"
                                        title="New Password required">
                                    <span class="fa fa-eye-slash mt-4" id="hide_new_forgot_password"></span>
                                    <span class="fa fa-eye mt-4 d-none" id="show_new_forgot_password"></span>
                                </div>
                                <div class="invalid-feedback" id="msg_new_update_password"></div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="control-label">Confirm Password</label>
                                    <input type="password" id="update_confirm_password" class="form-control"
                                        name="update_confirm_password" data-toggle="tooltip" data-placement="top"
                                        title="Confirm Password is required">
                                    <span class="fa fa-eye-slash mt-4" id="hide_confirm_forgot_password"></span>
                                    <span class="fa fa-eye mt-4 d-none" id="show_confirm_forgot_password"></span>
                                </div>
                                <div class="invalid-feedback" id="msg_update_password"></div>
                                <div class="invalid-feedback" id="msg_update_confirm_password"></div>
                            </div>
                            
                        </div>
                    </div>
                    <div class="alert alert-danger d-none res-msg" id="update_password_alert">
                        <div class="row">
                            <div id="update_password_alert_msg"></div>

                        </div>
                    </div>
                    <div class="user-form-single mt-2" id="user_login_button">
                        <div class="submit-btn">
                            <button type="button" id="change_password" onclick="updatePassword()">Update
                                Password</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- All Public promocodes modal --}}
    <div class="modal fade login-popup promo-code-modal-sec width-700" id="all-promocodes-popup" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body d-block">
                    <button type="button" class="btn-close" data-bs-dismiss="modal">x</button>
                    <div class="header-sec">
                        <h2>Available Offers</h2>
                    </div>
                    <div class="main-promo-sec">
                        @if(isset($public_promocodes) && count($public_promocodes) > 0)
                        @foreach($public_promocodes as $public_promocode)
                        <div class="each-promo-sec">
                            <div class="inner-promo-sec">
                                <div class="first-sec">
                                    <span>{{ isset($public_promocode->code) ? $public_promocode->code : '' }}</span>
                                    <div>
                                        <a onclick="sharepromocode('{{ isset($public_promocode->id) ? $public_promocode->id : '' }}')"><img src="{{asset('front/src/images/promo-share.svg') }}" class="img-fluid"></a>
                                        <a onclick="copypromocode('{{ isset($public_promocode->code) ? $public_promocode->code : '' }}')"><img src="{{asset('front/src/images/promo-copy.svg') }}" class="img-fluid"></a>
                                    </div>
                                </div>
                                <div class="second-sec">
                                    <span>{{ isset($public_promocode->title) ? $public_promocode->title : '' }}</span>
                                    <p class="description">{{ isset($public_promocode->description) ? $public_promocode->description : '' }}</p>
                                </div>
                                <div class="third-sec">
                                    <p><strong>Valid Till:</strong> {{ \Carbon\Carbon::parse($public_promocode->endDate)->format('d F Y') }}</p>
                                    <p><strong>Discounted Amount:</strong> @if(isset($public_promocode->discount_type) && $public_promocode->discount_type == 'amount') {{ $public_promocode->discount }}/- @else {{ $public_promocode->discount }}% @endif</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @else
                        <div class="each-promo-sec">
                            <div class="inner-promo-sec">
                                <p class="text-center">No Offers Available!</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade login-popup width-700 share_popup" id="share_promocode_popup">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal">x</button>
                    <div class="modal-body">
                        <h2 id="share_type">SHARE A PROMO CODE</h2>
                        <div class="share-product-image mt-3">
                            <img id="product_images" src="" alt="" class="img-fluid">
                        </div>
                        <div class="each-promo-sec">
                            <div class="inner-promo-sec">
                                <div class="first-sec">
                                    <span id="share_p_code"></span>
                                </div>
                                <div class="second-sec">
                                    <span id="share_p_title"></span>
                                    <p id="share_p_description" class="description"></p>
                                </div>
                                <div class="third-sec">
                                    <p id="share_p_valid_till"></p>
                                    <p id="share_p_discount"></p>
                                </div>
                            </div>
                        </div>
                        <ul>
                            <li><a class="p_whatsapp_share"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="30px" height="30px"><path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7 .9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z" fill="var(--theme-color)"></path></svg></a></li>
    
                            <li><a class="p_facebook_share"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" width="25px" height="25px"><path d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z" fill="var(--theme-color)"></path></svg></a></li>
    
                            <li><a class="p_twitter_share"><svg width="30" height="24" viewBox="0 0 35 35" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_1886_20)"><path d="M27.5645 0H32.9311L21.2064 14.8259L35 35H24.1994L15.7405 22.7642L6.06136 35H0.691045L13.2319 19.1423L0 0H11.0741L18.7206 11.1837L27.5645 0ZM25.6808 31.446H28.6547L9.45841 3.36743H6.26739L25.6808 31.446Z" fill="var(--theme-color)"/></g><defs><clipPath id="clip0_1886_20"><rect width="35" height="35" fill="var(--theme-color)"/></clipPath></defs></svg></a></li>
    
                            <li><a class="p_insta_share"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="30px" height="30px"><path d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z" fill="var(--theme-color)"></path></svg></a></li>
    
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        {{-- cart page modal --}}
        <div class="modal fade login-popup promo-code-modal-sec width-700" id="cart-promocodes-popup" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body d-block">
                        <button type="button" class="btn-close" data-bs-dismiss="modal">x</button>
                        <div class="header-sec">
                            <h2>Available Offers</h2>
                        </div>
                        <div class="main-promo-sec">
                            @if(isset($other_avail_promocodes) && count($other_avail_promocodes) > 0)
                            @foreach($other_avail_promocodes as $other_avail_promocode)
                            <div class="each-promo-sec">
                                <div class="inner-promo-sec">
                                    <div class="first-sec">
                                        <span>{{ isset($other_avail_promocode->code) ? $other_avail_promocode->code : '' }}</span>
                                        <div>
                                            @if (!Auth::user())
                                            <button type="button" class="modal-apply-btn" data-bs-toggle="modal" data-bs-target="#login-popup">Apply</button>
                                            @elseif(Auth::user()->role == 'customer')
                                            <button type="button" class="each-apply-promo-btn modal-apply-btn">Apply</button>
                                            @else
                                            <button type="button" class="modal-apply-btn" data-bs-toggle="modal" data-bs-target="#login-popup">Apply</button>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="second-sec">
                                        <span>{{ isset($other_avail_promocode->title) ? $other_avail_promocode->title : '' }}</span>
                                        <p class="description">{{ isset($other_avail_promocode->description) ? $other_avail_promocode->description : '' }}</p>
                                    </div>
                                    <div class="third-sec">
                                        <p><strong>Valid Till:</strong> {{ \Carbon\Carbon::parse($other_avail_promocode->endDate)->format('d F Y') }}</p>
                                        <p><strong>Discounted Amount:</strong> @if(isset($other_avail_promocode->discount_type) && $other_avail_promocode->discount_type == 'amount') {{ $other_avail_promocode->discount }}/- @else {{ $other_avail_promocode->discount }}% @endif</p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @endif
                            @if(isset($unavail_promo_codes) && count($unavail_promo_codes) > 0)
                            @foreach($unavail_promo_codes as $unavail_promo_code)
                            <div class="each-promo-sec">
                                <div class="inner-promo-sec">
                                    <div class="first-sec">
                                        <span>{{ isset($unavail_promo_code->code) ? $unavail_promo_code->code : '' }}</span>
                                        <div>
                                            <button type="button" disabled class="modal-apply-btn not-applicable" data-code="{{ isset($other_avail_promocode->code) ? $other_avail_promocode->code : '' }}">Not Applicable</button>
                                        </div>
                                    </div>
                                    <div class="second-sec">
                                        <span>{{ isset($unavail_promo_code->title) ? $unavail_promo_code->title : '' }}</span>
                                        <p class="description">{{ isset($unavail_promo_code->description) ? $unavail_promo_code->description : '' }}</p>
                                    </div>
                                    <div class="third-sec">
                                        <p><strong>Valid Till:</strong> {{ \Carbon\Carbon::parse($unavail_promo_code->endDate)->format('d F Y') }}</p>
                                        <p><strong>Discounted Amount:</strong> @if(isset($unavail_promo_code->discount_type) && $unavail_promo_code->discount_type == 'amount') {{ $unavail_promo_code->discount }}/- @else {{ $unavail_promo_code->discount }}% @endif</p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>


