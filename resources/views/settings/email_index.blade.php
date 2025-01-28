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
                                <form action="{{ route('email.setting.add') }}" method="POST" data-parsley-validate=""
                                    enctype="multipart/form-data">
                        @csrf
                    <div class="row">
                        <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-8 cpl-sm-12 col-xs-12 add-article form-main-sec ">
                            <div class="card Recent-Users">
                                <h5>E-Mail Settings</h5>
                                <div class="card-block px-0 py-3">
                                        <div class="row form-sec">
                                            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12 label-sec">
                                                <input type="hidden" name="emailsetting_id"
                                                    value="{{ isset($email->id) ? $email->id : '' }}">
                                                <label for="">Mailer <span style="color: red;margin: 0;">*</span></label>
                                            </div>
                                            <div class="col-xxl-9 col-xl-9 col-lg-9 col-md-9 col-sm-12 col-xs-12">
                                                <input type="text" name="mail_driver" id="mail_driver" placeholder="Mailer" required
                                                data-parsley-required-message="Please Enter Mailer" value="{{ isset($email->transport) ? $email->transport : '' }}">
                                            </div>
                                        </div>
                                        <div class="row form-sec">
                                            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12 label-sec">
                                                <label for="">Mail Host <span style="color: red;margin: 0;">*</span></label>
                                            </div>
                                            <div class="col-xxl-9 col-xl-9 col-lg-9 col-md-9 col-sm-12 col-xs-12">
                                                <input type="text" name="mail_host" id="mail_host" placeholder="Mail Host" required
                                                data-parsley-required-message="Please Enter Mail Host" value="{{ isset($email->host) ? $email->host : '' }}">
                                            </div>
                                        </div>
                                        <div class="row form-sec">
                                            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12 label-sec">
                                                <label for="">Mail Port <span style="color: red;margin: 0;">*</span></label>
                                            </div>
                                            <div class="col-xxl-9 col-xl-9 col-lg-9 col-md-9 col-sm-12 col-xs-12">
                                                <input type="text" name="mail_port" id="mail_port" required
                                                data-parsley-required-message="Please Enter Mail Port" value="{{ isset($email->port) ? $email->port : '' }}" placeholder="Mail Port">
                                            </div>
                                        </div>
                                        <div class="row form-sec">
                                            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12 label-sec">
                                                <label for="">E-Mail <span style="color: red;margin: 0;">*</span></label>
                                            </div>
                                            <div class="col-xxl-9 col-xl-9 col-lg-9 col-md-9 col-sm-12 col-xs-12">
                                                <input type="text" name="mail_username" id="mail_username" class="" placeholder="Mail Username" required
                                                data-parsley-required-message="Please Enter Mail Username" value="{{ isset($email->username) ? $email->username : '' }}" >
                                            </div>
                                        </div>
                                        <div class="row form-sec">
                                            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12 label-sec">
                                                <label for="">Mail Password <span style="color: red;margin: 0;">*</span></label>
                                            </div>
                                            <div class="col-xxl-9 col-xl-9 col-lg-9 col-md-9 col-sm-12 col-xs-12">
                                                <input type="password" name="mail_password" id="mail_password" class="" placeholder="Mail Password" required
                                                data-parsley-required-message="Please Enter Mail Password" value="{{ isset($email->password) ? $email->password : '' }}" >
                                            </div>
                                        </div>
                                        <div class="row form-sec">
                                            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12 label-sec">
                                                <label for="">Mail Encryption <span style="color: red;margin: 0;">*</span></label>
                                            </div>
                                            <div class="col-xxl-9 col-xl-9 col-lg-9 col-md-9 col-sm-12 col-xs-12">
                                                <input type="text" name="mail_encryption" id="mail_encryption" class="" placeholder="Mail Encryption" required
                                                data-parsley-required-message="Please Enter Mail Encryption" value="{{ isset($email->encryption) ? $email->encryption : '' }}" >
                                            </div>
                                        </div>
                                        <div class="row form-sec">
                                            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12 label-sec">
                                                <label for="">Mail From Address <span style="color: red;margin: 0;">*</span></label>
                                            </div>
                                            <div class="col-xxl-9 col-xl-9 col-lg-9 col-md-9 col-sm-12 col-xs-12">
                                                <input type="text" name="mail_from" id="mail_from" class="" placeholder="Mail From Address" required
                                                data-parsley-required-message="Please Enter Mail From Address" value="{{ isset($email->from_address) ? $email->from_address : '' }}" >
                                            </div>
                                        </div>
                                        <div class="row form-sec">
                                            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12 label-sec">
                                                <label for="">Mail From Name <span style="color: red;margin: 0;">*</span></label>
                                            </div>
                                            <div class="col-xxl-9 col-xl-9 col-lg-9 col-md-9 col-sm-12 col-xs-12">
                                                <input type="text" name="mail_from_name" id="mail_from_name" class="" placeholder="Mail From Name" required
                                                data-parsley-required-message="Please Enter Mail From Name" value="{{ isset($email->from_name) ? $email->from_name : '' }}" >
                                            </div>
                                        </div>
                                      
                                        
                                        <div class="row form-sec">
                                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 label-sec">
                                                <button type="submit" class="btn btn-primary">Save</button>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                        <!--[ Recent Users ] end-->

                    </div>
                </form>
                    <!-- [ Main Content ] end -->
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
@section('script')

@endsection