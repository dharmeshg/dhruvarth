 <div class="modal fade login-popup width-700" id="changePasswordModal" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body d-block">
                    <button type="button" class="close-modal" data-dismiss="modal">
                        <img src="{{ asset('front/theme2/images/close-icon.svg') }}" alt="close">
                    </button>
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