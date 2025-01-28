@extends('layouts.app')

@section('content')
<style>
    .parsley-errors-list{
        padding: 0 !important;
    }
    .parsley-errors-list li{
        text-align: left !important;
    }
</style>
<div class="auth-wrapper">
    <div class="auth-content custom_login">
        <div class="mb-4 text-center">
            @if(isset($bs) && $bs->business_logo != '' && $bs->business_logo != null)
            <img src="{{ asset('uploads/images/'.$bs->business_logo) }}" class="img-fluid"> 
            @endif
        </div>
        <div class="card">
            <div class="card-body text-center">
               
                <form method="POST" action="{{ route('reset.pass.link') }}" data-parsley-validate="">
                    @csrf
                <h3 class="mb-4">Reset Password</h3>
                <div class="input-group mb-3">
                    <input type="email" class="form-control" placeholder="Email" name="email" required data-parsley-errors-container="#content_required" data-parsley-required-message="Please Enter Email">
                </div>
                <span id="content_required"></span> 
                <button class="btn login_btn mb-4" type="submit">Send Password Reset Link</button>
            </form>
            </div>
        </div>
    </div>
</div>

@endsection