    <div class="modal fade login-popup width-700" id="forgotPasswordModal" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body d-block">
                    <button type="button" class="close-modal" data-dismiss="modal">
                        <img src="{{ asset('front/theme2/images/close-icon.svg') }}" alt="close">
                    </button>
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