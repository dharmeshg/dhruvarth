@extends('layouts.app')

@section('content')
<div class="auth-wrapper">
    <div class="auth-content custom_login">
        <div class="mb-4 text-center">
            @if(isset($bs) && $bs->business_logo != '' && $bs->business_logo != null)
            <img src="{{ asset('uploads/images/'.$bs->business_logo) }}" class="img-fluid"> 
            @endif
        </div>
        <div class="card">
            
            <div class="card-body text-center">
                
                <form method="POST" action="{{ route('custom.login') }}">
                    @csrf
                <h3 class="mb-4">Login into your account</h3>
                <div class="text-left custom_label">
                <label class="">Email address</label>
                </div>
                <div class="input-group login_input mb-3">
                    <span><img src="{{ asset('images/login/email.png') }}"></span>
                    <input type="email" class="form-control" placeholder="Email" name="email" @if(isset($_COOKIE['email'])) value="{{$_COOKIE['email']}}" @endif>
                </div>
                <div class="text-left custom_label">
                <label class="">Password</label>
                </div>
                <div class="input-group login_input mb-4">
                    <span><img src="{{ asset('images/login/lock.png') }}"></span>
                    <input type="password" id="password" class="form-control" placeholder="password" name="password" @if(isset($_COOKIE['password'])) value="{{$_COOKIE['password']}}" @endif>
                    <span id="show_password" style="cursor: pointer;"><i class="fa fa-eye" style="font-size: 16px;"></i><i class="fa fa-eye-slash" style="display: none;font-size: 16px;"></i></span>
                </div>
                <div class="text-right forgot">
                <a href="{{ route('reset.pass.link.view') }}">Forgot password?</a>
                </div>
                <button class="btn login_btn mb-4" type="submit">Login</button>
            </form>
                {{-- <p class="mb-2 text-muted">Forgot password? <a href="{{ route('reset.pass.link.view') }}">Reset</a></p> --}}
            </div>
        </div>
    </div>
</div>

@endsection