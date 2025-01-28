@extends('layouts.backend.index')
@section('main_content')
<style>
    .mobile_code{padding-left: 100px !important;}
    .iti--allow-dropdown{width: 100%;}
    .note_error{color: red;}
</style>
<div class="pcoded-wrapper">
    <div class="pcoded-content">
        <div class="pcoded-inner-content">
            <!-- [ breadcrumb ] start -->
            <div class="custom_breadcum">
                <ul>
                    <li class="breadcum-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                     <li class="breadcum-item"><a href="{{route('setting_all.index')}}">Settings</a></li>
                    <li class="breadcum-item active"><a href="javascript:;"> Business Settings </a></li>
                </ul>
            </div>
            <!-- [ breadcrumb ] end -->
            <div class="main-body">
                <div class="page-wrapper">
                    <!-- [ Main Content ] start -->
                                <form action="{{ route('setting.business_save') }}" method="POST" data-parsley-validate=""
                                    enctype="multipart/form-data">
                        @csrf
                    <div class="row">
                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 cpl-sm-12 col-xs-12 add-article form-main-sec ">
                            <div class="Recent-Users">
                                <h5>Business Settings</h5>

                                <div class="card-block px-0 py-3">
                                    <div class="row">
                                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="form-sec">
                                                    <input type="hidden" name="setting_id"
                                                        value="{{ isset($setting->id) ? $setting->id : '' }}" class="form-control">
                                                    <label for="">Business Name <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please insert a business name"><i class="fa fa-info-circle" aria-hidden="true"></i></span><span style="color: red;margin: 0;">*</label>
                                                    <input type="text" name="business_name" id="business_name" placeholder="Enter Business Name" required
                                                    data-parsley-required-message="Please Enter Business Name" class="form-control" value="{{ isset($setting->business_name) ? $setting->business_name : '' }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="form-sec">
                                                    <label for="">Business Logo <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please upload a business logo" ><i class="fa fa-info-circle" aria-hidden="true"></i></span><span style="color: red;margin: 0;">*Recommended Size: Upto 5MB.</span></label>
                                                    <div class="d-flex align-items-center">
                                                    <div class="input_group me-3">
                                                        <label class="img_upload" for="large_file"><i class="fa fa-plus mx-1"></i> Upload</label>
                                                        <input type="file" name="business_logo" style="display: none;" id="large_file" class="cover-item-img" @if(isset($setting->business_logo))  @else required @endif data-parsley-required-message="Please Upload Business Logo">
                                                    </div>
                                                <div class="preview_image">
                                                    @if(isset($setting->business_logo) && $setting->business_logo != '' && $setting->business_logo != null)
                                                    <img src="{{asset('uploads/images/'.$setting->business_logo)}}" class="img-fluid preview_image" id="cover-item-img-output">
                                                    @else
                                                    <img src="{{asset('assets/images/user/img-demo_1041.jpg')}}" class="img-fluid preview_image" id="cover-item-img-output">
                                                    @endif
                                                </div>
                                            </div>
                                                <input type="hidden" name="old_business_logo" value="{{ isset($setting->business_logo) ? $setting->business_logo : '' }}" id="cover_old_img"> 
                                            </div>
                                        </div>
                                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="form-sec">
                                                    <label for="">Favicon Image  <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please upload a favicon image" ><i class="fa fa-info-circle" aria-hidden="true"></i></span><span style="color: red;margin: 0;">*Recommended Size: 30x30 Upto 500KB.</span></label>
                                                    <div class="d-flex align-items-center">
                                                    <div class="input_group me-3">
                                                        <label class="img_upload" for="favicon_file"><i class="fa fa-plus mx-1"></i> Upload</label>
                                                        <input type="file"  name="business_favicon" style="display: none;" id="favicon_file" class="cover-item-img" @if(isset($setting->business_favicon))  @else required @endif  data-parsley-required-message="Please Upload Favicon Image">
                                                    </div>
                                                <div class="preview_image">
                                                    @if(isset($setting->business_favicon) && $setting->business_favicon != '' && $setting->business_favicon != null)
                                                    <img src="{{asset('uploads/images/'.$setting->business_favicon)}}" class="img-fluid preview_image" id="favicon-item-img-output">
                                                    @else
                                                    <img src="{{asset('assets/images/user/img-demo_1041.jpg')}}" class="img-fluid preview_image" id="favicon-item-img-output">
                                                    @endif
                                                </div>
                                            </div>
                                                <input type="hidden" name="old_business_favicon" id="cover_old_img_favicon" value="{{ isset($setting->business_favicon) ? $setting->business_favicon : '' }}"> 
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="form-sec">
                                                    <div class="d-flex align-items-center">
                                                        <label for="" style="width: auto !important;">Theme Color <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please select theme color" ><i class="fa fa-info-circle" aria-hidden="true"></i></span><span style="color: red;margin: 0;">*</span></label>
                                                        <div class="custom-control custom-checkbox mx-3">
                                                            <input type="checkbox" class="custom-control-input" id="customCheck1" name="">
                                                            <label class="custom-control-label" for="customCheck1" style="cursor: pointer;">Set As Default</label>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex background-color-sec">
                                                    <input type="text" class="form-control" placeholder="#000000" id="background-color-id" name="theme_color" value="{{ isset($setting->theme_color) ? $setting->theme_color : '' }}">
                                                    <div class="">
                                                        <input type="color" class="form-control" id="color-picker-id" style="width: 50px;height: 50px;cursor: pointer;" value="{{ isset($setting->theme_color) ? $setting->theme_color : '' }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="form-sec">
                                                @if(isset($setting->business_nature) && $setting->business_nature != '' && $setting->business_nature!= null)
                                                    @php
                                                        $nature = explode(',' , $setting->business_nature);
                                                    @endphp
                                                    @endif
                                                    <label for="">Nature of Business <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please select nature of business" ><i class="fa fa-info-circle" aria-hidden="true"></i></span><span style="color: red;margin: 0;">*</span></label>
                                                    <select name="business_nature[]" class="form-control select2" multiple="multiple">
                                                        <option value="Showroom" @if(isset($setting->business_nature) && in_array('Show Room',$nature)) selected @endif>Showroom</option>
                                                        <option value="Manufacturer" @if(isset($setting->business_nature) && in_array('Manufacturer',$nature)) selected @endif>Manufacturer</option>
                                                        <option value="Retailer" @if(isset($setting->business_nature) && in_array('Retailer',$nature)) selected @endif>Retailer</option>
                                                        <option value="Wholesaler" @if(isset($setting->business_nature) && in_array('Wholesaler',$nature)) selected @endif>Wholesaler</option>
                                                    </select>
                                            </div>
                                        </div>
                                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="form-sec">
    
                                                    <label for="">Default Currency <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please select a default currency" ><i class="fa fa-info-circle" aria-hidden="true"></i></span><span style="color: red;margin: 0;">*</span></label>
                                                    <select name="business_currency" class="form-control select2">
                                                        @if(isset($currencies) && count($currencies) > 0)
                                                        @foreach($currencies as $cur)
                                                        <option value="{{ $cur->value }}" @if(isset($setting->business_currency) && $setting->business_currency == $cur->value) selected @endif>{{ $cur->label }}</option>
                                                        @endforeach
                                                        @endif
                                                    </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="form-sec">
                                                    <label for="">Primary Category <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please select a primary category" ><i class="fa fa-info-circle" aria-hidden="true"></i></span><span style="color: red;margin: 0;">*</span></label>
                                                    <select name="primary_category" class="form-control">
                                                        <option value="Gold Jewelry" @if(isset($setting->primary_category) && $setting->primary_category == 'Gold Jewelry') selected @endif>Gold Jewelry</option>
                                                        <option value="Silver Jewelry" @if(isset($setting->primary_category) && $setting->primary_category == 'Silver Jewelry') selected @endif>Silver Jewelry</option>
                                                        <option value="Diamond Jewelry" @if(isset($setting->primary_category) && $setting->primary_category == 'Diamond Jewelry') selected @endif>Diamond Jewelry</option>
                                                        <option value="Gemstone Jewelry" @if(isset($setting->primary_category) && $setting->primary_category == 'Gemstone Jewelry') selected @endif>Gemstone Jewelry</option>
                                                        <option value="Pearl Jewelry" @if(isset($setting->primary_category) && $setting->primary_category == 'Pearl Jewelry') selected @endif>Pearl Jewelry</option>
                                                        <option value="Platinum Jewelry" @if(isset($setting->primary_category) && $setting->primary_category == 'Platinum Jewelry') selected @endif>Platinum Jewelry</option>
                                                        <option value="Fashion Jewelry" @if(isset($setting->primary_category) && $setting->primary_category == 'Fashion Jewelry') selected @endif>Fashion Jewelry</option>
                                                        <option value="Palladium Jewelry" @if(isset($setting->primary_category) && $setting->primary_category == 'Palladium Jewelry') selected @endif>Palladium Jewelry</option>
                                                        <option value="Gemstone" @if(isset($setting->primary_category) && $setting->primary_category == 'Gemstone') selected @endif>Gemstone</option>
                                                        <option value="Article" @if(isset($setting->primary_category) && $setting->primary_category == 'Article') selected @endif>Article</option>
                                                        <option value="Coin" @if(isset($setting->primary_category) && $setting->primary_category == 'Coin') selected @endif>Coin</option>
                                                    </select>
                                            </div>
                                        </div>
                                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="form-sec">
                                                    @if(isset($setting->secondary_category) && $setting->secondary_category != '' && $setting->secondary_category!= null)
                                                    @php
                                                        $category = explode(',' , $setting->secondary_category);
                                                    @endphp
                                                    @endif
                                                    <label for="">Secondary Categories <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please select a secondary category" ><i class="fa fa-info-circle" aria-hidden="true"></i></span><span style="color: red;margin: 0;">*</span></label>
                                                    <select name="secondary_category[]" class="form-control select2" multiple="multiple">
                                                        <option value="Silver Articles" @if(isset($setting->secondary_category) && in_array('Silver Articles',$category)) selected @endif>Silver Articles</option>
                                                        <option value="One Gram Gold Jewelry" @if(isset($setting->secondary_category) && in_array('One Gram Gold Jewelry',$category)) selected @endif>One Gram Gold Jewelry</option>
                                                        <option value="Kundan Jewelry" @if(isset($setting->secondary_category) && in_array('Kundan Jewelry',$category)) selected @endif>Kundan Jewelry</option>
                                                        <option value="Jadtar Jewelry" @if(isset($setting->secondary_category) && in_array('Jadtar Jewelry',$category)) selected @endif>Jadtar Jewelry</option>
                                                        <option value="Gold Articles" @if(isset($setting->secondary_category) && in_array('Gold Articles',$category)) selected @endif>Gold Articles</option>
                                                        <option value="Enamel Jewelry" @if(isset($setting->secondary_category) && in_array('Enamel Jewelry',$category)) selected @endif>Enamel Jewelry</option>
                                                        <option value="CZ Jewelry" @if(isset($setting->secondary_category) && in_array('CZ Jewelry',$category)) selected @endif>CZ Jewelry</option>
                                                        <option value="Antique Jewelry" @if(isset($setting->secondary_category) && in_array('Antique Jewelry',$category)) selected @endif>Antique Jewelry</option>
                                                    </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="form-sec">
                                                    <label for="">Ios Mobile App Links <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please insert a Ios mobile app link" ><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                                    <input type="text" name="ios_link" id="ios_link" class="form-control" placeholder="Enter Ios Mobile App Links" value="{{ isset($setting->ios_link) ? $setting->ios_link : '' }}" >
                                            </div>
                                        </div>
                                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="form-sec">
                                                    <label for="">Android Mobile App Links <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please insert a Android mobile app link" ><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                                    <input type="text" name="android_link" id="android_link" class="form-control" placeholder="Enter Android Mobile App Links" value="{{ isset($setting->android_link) ? $setting->android_link : '' }}" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="form-sec">
                                                    <label for="">Email Address <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please insert email address" ><i class="fa fa-info-circle" aria-hidden="true"></i></span><span style="color: red;margin: 0;">*</span></label>
                                                    <input type="email" name="email" id="email" class="form-control" placeholder="Enter Email Address" required
                                                data-parsley-required-message="Please Enter E-Mail" value="{{ isset($setting->email) ? $setting->email : '' }}" >
                                            </div>
                                        </div>
                                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="form-sec">
                                                    <label for="">WhatsApp Number <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please insert a Whatsapp number" ><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                                    <input type="text" name="whatsapp_number" id="whatsapp_number" class="form-control phone-imput-mask mobile_code" placeholder="Enter WhatsApp Number" value="{{ isset($setting->whatsapp_number) ? $setting->whatsapp_number : '' }}" >
                                                    <input type="hidden" class="country_code" id="country_code" name="country_code" value="{{ isset($setting->country_code) ? $setting->country_code : 'in' }}">
                                                     <input type="hidden" id="country_number" name="country_number" value="{{ isset($setting->country_code_number) ? $setting->country_code_number : '91' }}">
                                        
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="form-sec">
                                                    <label for="">Address Line 1 <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter Address Line 1" ><i class="fa fa-info-circle" aria-hidden="true"></i></span><span style="color: red;margin: 0;">*</span></label>
                                                    <input type="text" name="street" id="street" class="form-control" placeholder="Enter Address 1" required
                                                data-parsley-required-message="Please Enter Address 1" value="{{ isset($setting->street) ? $setting->street : '' }}" >
                                            </div>
                                        </div>
                                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="form-sec">
                                                    <label for="">Address Line 2 <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please enter Address Line 2" ><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                                    <input type="text" name="street2" id="street2" class="form-control" placeholder="Enter Address 2" required
                                                data-parsley-required-message="Please Enter Address 2" value="{{ isset($setting->street2) ? $setting->street2 : '' }}" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="form-sec">
                                                    <label for="">Area <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please insert area name" ><i class="fa fa-info-circle" aria-hidden="true"></i></span><span style="color: red;margin: 0;">*</span></label>
                                                    <input type="text" name="area" id="area" class="form-control" placeholder="Enter Area" required
                                                data-parsley-required-message="Please Enter Street Number" value="{{ isset($setting->area) ? $setting->area : '' }}" >
                                            </div>
                                        </div>
                                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="form-sec">
                                                    <label for="">Country <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please select a country" ><i class="fa fa-info-circle" aria-hidden="true"></i></span><span style="color: red;margin: 0;">*</span></label>
                                                    <select name="country" class="form-control select2" id="country">
                                                        @if(isset($countries) && count($countries) > 0)
                                                        @foreach($countries as $coun)
                                                        <option value="{{ $coun->id }}" @if(isset($setting->country) && $setting->country == $coun->id) selected @endif>{{ $coun->name }}</option>
                                                        @endforeach
                                                        @endif
                                                    </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="form-sec">
                                                    <label for="">State <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please select a state" ><i class="fa fa-info-circle" aria-hidden="true"></i></span><span style="color: red;margin: 0;">*</span></label>
                                                    <select name="state" class="form-control select2" id="state"> 
                                                    </select>
                                            </div>
                                        </div>
                                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="form-sec">
                                                    <label for="">City <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please select a city" ><i class="fa fa-info-circle" aria-hidden="true"></i></span><span style="color: red;margin: 0;">*</span></label>
                                                    <select name="city" class="form-control select2" id="city">
                                                        
                                                    </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">    
                                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="form-sec">
                                                    <label for="">Pincode <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please insert pincode" ><i class="fa fa-info-circle" aria-hidden="true"></i></span> <span style="color: red;margin: 0;">*</span></label>
                                                    <input type="text" name="pincode" id="pincode" class="form-control" placeholder="Enter Pincode" required
                                                data-parsley-required-message="Please Enter Pincode" value="{{ isset($setting->pincode) ? $setting->pincode : '' }}" >
                                            </div>
                                        </div>
                             
                                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="form-sec">
                                                    <label for="">YouTube Video Link <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please insert youtube video link" ><i class="fa fa-info-circle" aria-hidden="true"></i></span> <span style="color: red;margin: 0;">(No short Video Link Allowed)</span></label>
                                                    <input type="url" name="youtube_video" id="youtube_video" class="form-control" placeholder="Enter YouTube Video Link" value="{{ isset($setting->youtube_video) ? $setting->youtube_video : '' }}" >
                                            </div>
                                        </div>
                                    </div>
                                    <h5 class="mt-3">Social Links</h5>
                                    <div class="row">
                                       <!--  <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="form-sec">
                                                    <label for="">Website Link <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please insert website link" ><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                                    <input type="url" name="website_link" id="website_link" class="form-control" placeholder="Enter Website Link" required
                                                data-parsley-required-message="Please Enter Website Link" value="{{ isset($setting->website_link) ? $setting->website_link : '' }}" >
                                            </div>
                                        </div> -->
                                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="form-sec">
                                                    <label for="">Facebook Business Page Link <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please insert facebook business page link" ><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                                    <input type="url" name="facebook_link" id="facebook_link" class="form-control" placeholder="Enter Facebook Business Page Link" value="{{ isset($setting->facebook_link) ? $setting->facebook_link : '' }}" >
                                            </div>
                                        </div>
                                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="form-sec">
                                                    <label for="">LinkedIn Profile Link <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please insert linkedin profile link" ><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                                    <input type="url" name="linkedin_link" id="linkedin_link" class="form-control" placeholder="Enter LinkedIn Profile Link" value="{{ isset($setting->linkedin_link) ? $setting->linkedin_link : '' }}" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        
                                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="form-sec">
                                                    <label for="">Pinterest Account Link <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please insert pinterest account link" ><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                                    <input type="url" name="pinterest_link" id="pinterest_link" class="form-control" placeholder="Enter Pinterest Account Link" value="{{ isset($setting->pinterest_link) ? $setting->pinterest_link : '' }}" >
                                            </div>
                                        </div>
                                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="form-sec">
                                                    <label for="">Twitter (X) Page Link <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please insert twitter page link " ><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                                    <input type="url" name="twitter_link" id="twitter_link" class="form-control" placeholder="Enter Twitter (X) Page Link" value="{{ isset($setting->twitter_link) ? $setting->twitter_link : '' }}" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        
                                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="form-sec">
                                                    <label for="">Instagram Page Link <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please insert instagram page link" ><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                                    <input type="url" name="insta_link" id="insta_link" class="form-control" placeholder="Enter Instagram Page Link" value="{{ isset($setting->insta_link) ? $setting->insta_link : '' }}" >
                                            </div>
                                        </div>
                                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="form-sec">
                                                    <label for="">YouTube Channel Link <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please insert youtube channel link" ><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                                    <input type="url" name="youtube_link" id="youtube_link" class="form-control" placeholder="Enter YouTube Channel Link" value="{{ isset($setting->youtube_link) ? $setting->youtube_link : '' }}" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="form-sec">
                                                    <label for="">Insert Store Direction Link <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please insert store direction link" ><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                                    <span style="color: red;margin: 0;">(Add Google Map Link)</span>
                                                    <input type="url" name="instore_link" id="instore_link" class="form-control" placeholder="Insert Store Direction Link" value="{{ isset($setting->instore_link) ? $setting->instore_link : '' }}" >
                                            </div>
                                        </div>
                                    </div>
                                    <h5 class="mt-3">Opening Hours</h5>
                                    <div class="row">
                                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="form-sec">
                                                <label for="">Monday <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please select Open/Close for monday" ><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                                @if(isset($setting->monday) && $setting->monday != 'closed' && $setting->monday != null)
                                                @php
                                                $m_opend = true;
                                                $m_json = json_decode($setting->monday);
                                                @endphp
                                                @endif
                                                <div class="row">
                                                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                        <select name="monday_choose" class="form-control"> 
                                                            <option value="open" {{ isset($m_opend) ? 'selected' : '' }}>Open</option>
                                                            <option value="close" {{ isset($setting->monday) && $setting->monday == 'closed' ? 'selected' : '' }}>Closed</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                        <input class="form-control" id="monday_form" name="monday_form" type="time" value="{{ isset($m_json->from) ? $m_json->from : ''}}" placeholder="From">
                                                    </div>
                                                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                        <input class="form-control" id="monday_to" name="monday_to" type="time" value="{{ isset($m_json->to) ? $m_json->to : ''}}" placeholder="To">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="form-sec">
                                                <label for="">Tuesday <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please select Open/Close for tuesday" ><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                                @if(isset($setting->tuesday) && $setting->tuesday != 'closed' && $setting->tuesday != null)
                                                @php
                                                $t_opend = true;
                                                $t_json = json_decode($setting->tuesday);
                                                @endphp
                                                @endif
                                                <div class="row">
                                                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                        <select name="tuesday_choose" class="form-control"> 
                                                            <option value="open" {{ isset($t_opend) ? 'selected' : '' }}>Open</option>
                                                            <option value="close" {{ isset($setting->tuesday) && $setting->tuesday == 'closed' ? 'selected' : '' }}>Closed</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                        <input class="form-control" id="tuesday_form" name="tuesday_form" type="time" value="{{ isset($t_json->from) ? $t_json->from : ''}}" placeholder="From">
                                                    </div>
                                                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                        <input class="form-control" id="tuesday_to" name="tuesday_to" type="time" value="{{ isset($t_json->to) ? $t_json->to : ''}}" placeholder="To">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="form-sec">
                                                <label for="">Wednesday <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please select Open/Close for wednesday" ><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                                @if(isset($setting->wedsday) && $setting->wedsday != 'closed' && $setting->wedsday != null)
                                                @php
                                                $w_opend = true;
                                                $w_json = json_decode($setting->wedsday);
                                                @endphp
                                                @endif
                                                <div class="row">
                                                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                        <select name="wedsday_choose" class="form-control"> 
                                                            <option value="open" {{ isset($w_opend) ? 'selected' : '' }}>Open</option>
                                                            <option value="close" {{ isset($setting->wedsday) && $setting->wedsday == 'closed' ? 'selected' : '' }}>Closed</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                        <input class="form-control" id="wed_form" name="wed_form" type="time" value="{{ isset($w_json->from) ? $w_json->from : ''}}" placeholder="From">
                                                    </div>
                                                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                        <input class="form-control" id="wed_to" name="wed_to" type="time" value="{{ isset($w_json->to) ? $w_json->to : ''}}" placeholder="To">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="form-sec">
                                                <label for="">Thursday <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please select Open/Close for thursday" ><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                                @if(isset($setting->thursday) && $setting->thursday != 'closed' && $setting->thursday != null)
                                                @php
                                                $th_opend = true;
                                                $th_json = json_decode($setting->thursday);
                                                @endphp
                                                @endif
                                                <div class="row">
                                                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                        <select name="thursday_choose" class="form-control"> 
                                                            <option value="open" {{ isset($th_opend) ? 'selected' : '' }}>Open</option>
                                                            <option value="close" {{ isset($setting->thursday) && $setting->thursday == 'closed' ? 'selected' : '' }}>Closed</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                        <input class="form-control" id="thur_form" name="thur_form" type="time" value="{{ isset($th_json->from) ? $th_json->from : ''}}" placeholder="From">
                                                    </div>
                                                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                        <input class="form-control" id="thur_to" name="thur_to" type="time" value="{{ isset($th_json->to) ? $th_json->to : ''}}" placeholder="To">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="form-sec">
                                                <label for="">Friday <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please select Open/Close for friday" ><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                                @if(isset($setting->friday) && $setting->friday != 'closed' && $setting->friday != null)
                                                @php
                                                $f_opend = true;
                                                $f_json = json_decode($setting->friday);
                                                @endphp
                                                @endif
                                                <div class="row">
                                                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                        <select name="friday_choose" class="form-control"> 
                                                            <option value="open" {{ isset($f_opend) ? 'selected' : '' }}>Open</option>
                                                            <option value="close" {{ isset($setting->friday) && $setting->friday == 'closed' ? 'selected' : '' }}>Closed</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                        <input class="form-control" id="friday_form" name="friday_form" type="time" value="{{ isset($f_json->from) ? $f_json->from : ''}}" placeholder="From">
                                                    </div>
                                                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                        <input class="form-control" id="friday_to" name="friday_to" type="time" value="{{ isset($f_json->to) ? $f_json->to : ''}}" placeholder="To">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="form-sec">
                                                <label for="">Saturday <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please select Open/Close for saturday" ><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                                @if(isset($setting->sat) && $setting->sat != 'closed' && $setting->sat != null)
                                                @php
                                                $s_opend = true;
                                                $s_json = json_decode($setting->sat);
                                                @endphp
                                                @endif
                                                <div class="row">
                                                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                        <select name="sat_choose" class="form-control"> 
                                                            <option value="open" {{ isset($f_opend) ? 'selected' : '' }}>Open</option>
                                                            <option value="close" {{ isset($setting->sat) && $setting->sat == 'closed' ? 'selected' : '' }}>Closed</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                        <input class="form-control" id="sat_form" name="sat_form" type="time" value="{{ isset($s_json->from) ? $s_json->from : ''}}" placeholder="From">
                                                    </div>
                                                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                        <input class="form-control" id="sat_to" name="sat_to" type="time" value="{{ isset($s_json->to) ? $s_json->to : ''}}" placeholder="To">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="form-sec">
                                                <label for="">Sunday <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please select Open/Close for sunday" ><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                                @if(isset($setting->sun) && $setting->sun != 'closed' && $setting->sun != null)
                                                @php
                                                $su_opend = true;
                                                $su_json = json_decode($setting->sun);
                                                @endphp
                                                @endif
                                                <div class="row">
                                                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                        <select name="sun_choose" class="form-control"> 
                                                            <option value="open" {{ isset($su_opend) ? 'selected' : '' }}>Open</option>
                                                            <option value="close" {{ isset($setting->sat) && $setting->sun == 'closed' ? 'selected' : '' }}>Closed</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                        <input class="form-control" id="sunday_form" name="sunday_form" type="time" value="{{ isset($su_json->from) ? $su_json->from : ''}}" placeholder="From">
                                                    </div>
                                                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                        <input class="form-control" id="sunday_to" name="sunday_to" type="time" value="{{ isset($su_json->to) ? $su_json->to : ''}}" placeholder="To">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                     <h5 class="mt-3">Intro Section</h5>
                                    <div class="row">
                                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-sec">
                                                    <label for="">Description <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please insert description" ><i class="fa fa-info-circle" aria-hidden="true"></i></span><span style="color: red;margin: 0;">*</label>
                                                    <textarea class="form-control intro-sec" id="summernote" name="intro_sec"  placeholder="Enter Description" rows="3" cols="3" data-parsley-required-message="Description is required" style="height:auto !important;" >{{ isset($setting->intro_sec) ? $setting->intro_sec : '' }}</textarea>
                                                    <div id="charCount" class="note_error"></div>
                                            </div> 
                                        </div>
                                    </div>
                                    <h5 class="mt-3">Our Commitment</h5>
                                    <div class="row">
                                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="form-sec">
                                                    <label for="">Title <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please insert Section title" ><i class="fa fa-info-circle" aria-hidden="true"></i></span><span style="color: red;margin: 0;">*</label>
                                                    <input class="form-control" id="buy_sec_title" name="buy_sec_title" type="text" value="{{ isset($setting->buy_sec_title) ? $setting->buy_sec_title : ''}}" placeholder="Section Title">
                                            </div> 
                                        </div>
                                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-sec">
                                                    <label for="">Description <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please insert description" ><i class="fa fa-info-circle" aria-hidden="true"></i></span><span style="color: red;margin: 0;">*</label>
                                                    <textarea class="form-control" id="summernote_commitment" name="buy_desc" placeholder="Enter Description" rows="2" cols="2"  data-parsley-required-message="Description is required" style="height:auto !important;">{{ isset($setting->buy_desc) ? $setting->buy_desc : '' }}</textarea>
                                                    <div id="charCount_n" class="note_error"></div>
                                            </div> 
                                        </div>
                                    </div>
                                    @if(isset($setting->buy_icons) && $setting->buy_icons != '' && $setting->buy_icons != null)
                                    @php
                                        $buy_json = json_decode($setting->buy_icons);
                                    @endphp
                                    @endif
                                    @if(isset($buy_json) && count($buy_json) > 0)
                                    <input type="hidden" value="{{count($buy_json)}}" id="buy_count">
                                    @foreach($buy_json as $key => $json)
                                    <div class="each-icon-details mt-3">
                                    <div class="row">
                                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="form-sec">
                                                    <label for="">Name <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please insert name" ><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                                    <input type="text" name="buy_title[]"  placeholder="Enter Name" id="buy_icon_name" class="form-control" value="{{ isset($json->title) ? $json->title : '' }}">
                                            </div> 
                                        </div>
                                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                            <div class="form-sec">
                                                    <label for="">Icon <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please upload the icon" ><i class="fa fa-info-circle" aria-hidden="true"></i></span><span style="color: red;margin: 0;"> *1:1 square PNG only, max 512 px.</span></label>
                                                    <div class="d-flex align-items-center">
                                                    <div class="input_group me-3">
                                                        <label class="img_upload" for="buy_icon_{{$key}}"><i class="fa fa-plus mx-1"></i> Upload</label>
                                                        <input type="file" name="buy_icon[]" style="display: none;" id="buy_icon_{{$key}}" class="buy_icon" >
                                                    </div>
                                                <div class="preview_image">
                                                    @if(isset($json->icon) && $json->icon != '' && $json->icon != null)
                                                    <img src="{{asset('uploads/images/'.$json->icon)}}" class="img-fluid preview_image icon_img" >
                                                    @else
                                                    <img src="{{asset('assets/images/user/img-demo_1041.jpg')}}" class="img-fluid preview_image icon_img" >
                                                    @endif
                                                </div>
                                            </div>
                                                <input type="hidden" name="old_buy_icon[]" value="{{ isset($json->icon) ? $json->icon : '' }}"> 
                                            </div>
                                        </div>
                                        <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12" style="text-align: end;margin-top: 18px;">
                                        @if(isset($key) && $key == 0)
                                        <a class="back-btn" href="javascript:;" id="add_icon">+ Add Icon</a>
                                        @else
                                        <a class="remove remove_icon" href=javascript:;><i class="fa-times-circle fas"></i></a>
                                        @endif
                                        </div>
                                    </div>
                                    </div>
                                    @endforeach
                                    @else
                                    <div class="each-icon-details mt-3">
                                    <div class="row">
                                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="form-sec">
                                                    <label for="">Name <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please insert name" ><i class="fa fa-info-circle" aria-hidden="true"></i></span> </label>
                                                    <input type="text" name="buy_title[]" id="buy_icon_name" class="form-control">
                                            </div> 
                                        </div>
                                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                            <div class="form-sec">
                                                    <label for="">Icon <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please upload the icon" ><i class="fa fa-info-circle" aria-hidden="true"></i></span></label>
                                                    <div class="d-flex align-items-center">
                                                    <div class="input_group me-3">
                                                        <label class="img_upload" for="buy_icon_0"><i class="fa fa-plus mx-1"></i> Upload</label>
                                                        <input type="file" name="buy_icon[]" style="display: none;" id="buy_icon_0" class="buy_icon" >
                                                    </div>
                                                <div class="preview_image">
                                                    <img src="{{asset('assets/images/user/img-demo_1041.jpg')}}" class="img-fluid preview_image icon_img" >
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                        <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12" style="text-align: end;margin-top: 18px;">
                                        <a class="back-btn" href="javascript:;" id="add_icon">+ Add Icon</a>
                                        </div>
                                    </div>
                                    </div>
                                    @endif
                                    <div id="append_icons">

                                    </div>
                                        <div class="row form-sec mt-4">
                                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 label-sec">
                                                <button type="submit" id="submit_form" class="common-sub-btn">Save</button>
                                            </div>
                                    </div>
                                </div>  
                            </div>
                        </div>
                </form>
                    <!-- [ Main Content ] end -->
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
@section('script')
<script>
    $(document).ready(function() {
        var mobileCode = $("#whatsapp_number").intlTelInput({
                        initialCountry: "{{ isset($setting->country_code) ? $setting->country_code : 'in' }}",
                        separateDialCode: true,

                 
      });

            mobileCode.on("countrychange", function (e) {
                var selectedCountryData = mobileCode.intlTelInput('getSelectedCountryData');
            $("#country_code").val(selectedCountryData.iso2);

              var selectedCountryNumber = mobileCode.intlTelInput('getSelectedCountryData').dialCode;
            $("#country_number").val(selectedCountryNumber);
        });   

            });
   
    </script>
<script>
     $(document).ready(function() {
        $('.input-mask').inputmask('(999) 999-9999');
    @if(isset($setting->state) && $setting->state != null)
    var country = '{{$setting->country}}';
          $("#state").html('');
          $.ajax({
            url: "{{route('business.get_state')}}",
            type: "POST",
            data: {
              country: country,
              _token: '{{csrf_token()}}'
            },
            dataType: 'json',
            success: function(result) {
              $('#state').html('<option value="">Select State</option>');
              var state_id = '{{$setting->state}}';
              $.each(result.state, function(key, value) {
                var selected = '';
                  if (state_id == value.id) {
                    var isselected = 'selected';
                  }
                $("#state").append('<option value="' + value.id + '" ' + isselected + '>' + value.name + '</option>');
              });
            }
    });
    @endif
    @if(isset($setting->city) && $setting->city != null)
    var state = '{{$setting->state}}';
    $("#city").html('');
          $.ajax({
            url: "{{route('business.get_city')}}",
            type: "POST",
            data: {
              state: state,
              _token: '{{csrf_token()}}'
            },
            dataType: 'json',
            success: function(result) {
              $('#city').html('<option value="">Select City</option>');
              var city_id = '{{$setting->city}}';
              $.each(result.city, function(key, value) {
                var iscityselected = '';
                if (city_id == value.id) {
                    var iscityselected = 'selected';
                  }
                $("#city").append('<option value="' + value.id + '" '+ iscityselected +'>' + value.name + '</option>');
              });
            }
          }); 
    @endif
    });
    $('#country').on('change', function () { 
        var country = this.value;
          $("#state").html('');
          $.ajax({
            url: "{{route('business.get_state')}}",
            type: "POST",
            data: {
              country: country,
              _token: '{{csrf_token()}}'
            },
            dataType: 'json',
            success: function(result) {
              $('#state').html('<option value="">Select State</option>');
              $.each(result.state, function(key, value) {
                $("#state").append('<option value="' + value.id + '">' + value.name + '</option>');
              });
            }
          }); 
    });
    $('#state').on('change', function () { 
        var state = this.value;
          $("#city").html('');
          $.ajax({
            url: "{{route('business.get_city')}}",
            type: "POST",
            data: {
              state: state,
              _token: '{{csrf_token()}}'
            },
            dataType: 'json',
            success: function(result) {
              $('#city').html('<option value="">Select City</option>');
              $.each(result.city, function(key, value) {
                $("#city").append('<option value="' + value.id + '">' + value.name + '</option>');
              });
            }
          }); 
    });
</script>
<script>
    // summernote
    $('textarea#summernote').summernote({
        placeholder: 'Content',
        tabsize: 2,
        height: 150 ,
        toolbar: [
                ['font', ['bold', 'italic', 'underline']],
                // ['para', ['ul', 'ol']],
              ],
         callbacks: {
            onKeyup: function(e) {
                var maxChars = 500;
                var text = $(this).summernote('code').replace(/(<([^>]+)>)/ig, '');
                if (text.length > maxChars) {
                    $(this).summernote('code', text.substring(0, maxChars));
                    $('#charCount').text('You have reached the limit');
                } else {
                    var remainingChars = maxChars - text.length;
                    $('#charCount').text(remainingChars + ' characters remaining');
                }
            }
        }
      });
    $('textarea#summernote_commitment').summernote({
        placeholder: 'Content',
        tabsize: 2,
        height: 150 ,
        toolbar: [
                ['font', ['bold', 'italic', 'underline']],
                // ['para', ['ul', 'ol']],
              ],
         callbacks: {
            onKeyup: function(e) {
                var maxChars = 500;
                var text = $(this).summernote('code').replace(/(<([^>]+)>)/ig, '');
                if (text.length > maxChars) {
                    $(this).summernote('code', text.substring(0, maxChars));
                    $('#charCount_n').text('You have reached the limit');
                } else {
                    var remainingChars = maxChars - text.length;
                    $('#charCount_n').text(remainingChars + ' characters remaining');
                }
            }
        }
      });
    // Logo
    $('#large_file').change(function (e) {
            var input = e.target;
            var file = input.files[0];
            if (file) {               
                if (file.size <= 5 * 1024 * 1024) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('#cover-item-img-output').attr('src', e.target.result);
                    };
                    reader.readAsDataURL(file);
                } else {
                    toastr.error('File size should be less than or equal to 5 MB');
                    $('#large_file').val('');
                    $('#cover-item-img-output').attr('src', '{{ asset('assets/images/user/img-demo_1041.jpg') }}');
                }
            }
        });
    // Favicon
     $('#favicon_file').change(function (e) {
            var input = e.target;
            var file = input.files[0];

            if (file) {
                // Check file size
                if (file.size <= 500 * 1024) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('#favicon-item-img-output').attr('src', e.target.result);
                    };

                    reader.readAsDataURL(file);
                } else {
                    // Display toastr error for file size larger than 500KB
                    toastr.error('File size should be less than or equal to 500 KB');
                    // Clear the file input
                    $('#favicon_file').val('');
                    // Reset the preview image
                    $('#favicon-item-img-output').attr('src', '{{ asset('assets/images/user/img-demo_1041.jpg') }}');
                }
            }
        });
     $('#color-picker-id').change(function () {
        if (!$("#customCheck1").is(":checked")) {
            var selectedColor = $(this).val();
            $('#background-color-id').val(selectedColor);
        }
        });
</script>
<script>
    $('#customCheck1').click(function () {
         if ($(this).prop('checked')) {
            $('#background-color-id').val('#e49f21');
            $('#color-picker-id').val('#e49f21');
        } else {
            $('#background-color-id').val('#0000');
            $('#color-picker-id').val('#0000');
        }
    })
</script>
<script>
var existing_counter = $('#buy_count').val()
if(existing_counter && existing_counter != '')
{
    var counter = parseInt(existing_counter) + 1;
}else{
    var counter = 1;
}
$('#add_icon').click(function() {
    var html = '<div class="each-icon-details mt-3"><div class=row><div class="col-sm-12 col-xs-12 col-lg-6 col-md-6 col-xl-6 col-xxl-6"><div class=form-sec><label for="">Name <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please insert name" ><i class="fa fa-info-circle" aria-hidden="true"></i></span></label> <input id=buy_icon_name name=buy_title[] class=form-control></div></div><div class="col-sm-12 col-xs-12 col-lg-4 col-md-4 col-xl-4 col-xxl-4"><div class=form-sec><label for="">Icon <span class="info_label" data-bs-toggle="tooltip" data-bs-placement="right" title="Please upload the icon" > <i class="fa fa-info-circle" aria-hidden="true"></i></span><span style="color: red;margin: 0;"> *1:1 square PNG only, max 512 px.</span></label><div class="align-items-center d-flex"><div class="input_group me-3"><label for=buy_icon_'+ counter +' class=img_upload><i class="fa fa-plus mx-1"></i> Upload</label> <input id=buy_icon_'+ counter +' name=buy_icon[] class="buy_icon" style=display:none type=file></div><div class=preview_image> <img class="preview_image icon_img img-fluid"  src="{{asset('assets/images/user/img-demo_1041.jpg')}}"></div></div></div></div><div class="col-sm-12 col-xs-12 col-lg-2 col-md-2 col-xl-2 col-xxl-2"style=text-align:end;margin-top:18px><a class="remove remove_icon" href=javascript:;><i class="fa-times-circle fas"></i></a></div></div></div>';
    $('#append_icons').append(html);
    counter++;
});
$(document).on("click",".remove_icon",function() {
    $(this).closest('.each-icon-details').remove();
});
$(document).on("change", ".buy_icon", function (e) {
    var input = e.target;
    var file = input.files[0]; // Assuming only one file is selected

    // Check if the file is an image
    if (/^image\//.test(file.type)) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $(input).closest('.each-icon-details').find('.icon_img').attr('src', e.target.result);
        };

        reader.readAsDataURL(file);
    } else {
        toastr.error('Please select a valid image file.');
        $(input).val(''); // Clear the input field
        // You may want to set a default image here as well
        $(input).next().attr('src', '{{ asset('assets/images/user/img-demo_1041.jpg') }}');
    }
});
</script>
@endsection
