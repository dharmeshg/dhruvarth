@extends('front.layout.index')

@if(isset($SEOSchemaCode))
@section('seoSchemaContent')
    <script type='application/ld+json'>{!! $SEOSchemaCode !!}</script>
@endsection
@endif
@section('main_content')
<style>
.c-location a{
    text-decoration:none;
}
</style>

<div class="margin-top-head @if($display_pg == 1) header-note @endif"></div>
<section class="common-section all-product-list-section">
    <div class="container-md">
        <div class="row">
            <div class="col-xxl-8">
                <span class="d-flex page-nav-text">
                    <a href="{{ route('home') }}" aria-label="home"><img src="{{asset('front/src/images/home-icon.svg')}}" alt="Home" width="auto" height="auto"></a> <span class="dash-line">/</span>
                    <a aria-label="home icon">Contact Us</a>
                </span>
            </div>
        </div>
    </div>
</section>

<section class="contact-form">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 col-md-6 user-form">
                <div class="c-title">
                    <h1>Contact Form</h1>
                </div>
                <form class="contact-detail" name="contact_send_inquiry" id="contact_send_inquiry" method="post" enctype="multipart/form-data" action="{{route('updateSendInquiryForm')}}">
                    @csrf
                    <div class="user-form-single">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="control-label">Enter Your Name</label>
                                    <input type="text" name="si_name" id="si_name" class="form-control">
                                    <span class="text-danger" id="msg_name"></span>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label class="control-label">Enter Your Email</label>
                                    <input type="email" name="si_email" id="si_email" value="" class="form-control">
                                    <span class="text-danger" id="msg_email"></span>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label class="control-label">Enter Your Mobile Number</label>
                                    <span class="flag-code"></span>
                                    
                                    <input type="hidden" class="country_code" id="country_code_contact" name="country_code_contact" value="in">
                                                            <input type="hidden" id="country_number_contact" name="country_number_contact" value="91">
                                    <input type="tel" placeholder="" name="si_mobile" id="si_mobile" value="" class="form-control" style="padding-left: 100px;" max="10">
                                    <span class="text-danger" id="msg_mobile"></span>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label class="control-label" for="selectCtrl">City</label>
                                    <input type="text" name="si_city" id="city" value="" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label class="control-label" for="pricerange">Price Range</label>

                                    <select type="text" class="form-control" id="price_range" name="si_price_range">
                                        <option value="" selected="">Select Price Range</option>
                                        <option value="2500 to 10000">2500 to 10000</option>
                                        <option value="10000 to 50000">10000 to 50000</option>
                                        <option value="50000 to 100000">50000 to 100000</option>
                                        <option value="100000 to 1000000">100000 to 1000000</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label class="control-label" for="selectCtrl">Weight Rage</label>
                                    <select type="text" class="form-control" id="weight_range" name="si_weight_range">
                                        <option value="" selected="">Select Weight Range</option>
                                        <option value="1.00 to 500.00">1.00 to 500.00</option>
                                       
                                    </select>

                                </div>
                            </div>
                          <!--   <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label class="control-label">Delivery Date</label>
                                    <input class="calendar-icon form-control" type="text" placeholder="" id="inputDate" name="si_delivery_date">
                                </div>
                            </div> -->
                             <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label class="control-label">Delivery Date</label>
                                    <input class="form-control datepicker" type="text" placeholder="" id="si_delivery_date" name="si_delivery_date">
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="control-label">Enter Your Description</label>
                                    <input class="form-control" type="text" placeholder="" name="si_description" id="si_description">
                                </div>
                            </div>
                            <!--<div class="col-lg-3 col-12">-->
                            <!--    <div class="upload-and-submit">-->
                            <!--        <div class="upload-image">-->
                            <!--            <input class="file-upload-input" type="file" accept="image/*" name="si_image" id="si_image">-->
                            <!--            <button class="file-upload-btn" type="button">-->
                            <!--                Attach Image-->
                            <!--            </button>-->
                            <!--        </div>-->
                            <!--    </div>-->
                            <!--</div>-->
                            <div class="col-lg-12 col-12">
                                <div class="form-group">
                                    <label class="control-label">Selected Image</label>
                                    <input class="form-control image-title" type="text" placeholder="" disabled="">
                                    <button type="button" class="remove-image">
                                        <img src="{{asset('front/src/images/close-icon.svg')}}" alt="Close">
                                    </button>
                                </div>
                            </div>
                            <div class="col-12">
                                <div id="g-recaptcha-response_c" class="g-recaptcha" data-sitekey="{{env('G_SITE_KEY')}}" data-callback="saveCallback"></div>
                                <span id="msg_rec_name_c" class="text-danger"></span>
                                <input type="hidden" id="cn_name_checked" name="cn_name_checked">
                            </div>
                            <div class="col-12">
                                <div class="upload-and-submit">
                                    <div class="upload-image">
                                        <input class="file-upload-input" type="file" accept="image/*" name="si_image" id="si_image">
                                        <button class="file-upload-btn" type="button">
                                            Attach Image
                                        </button>
                                    </div>
                                    <div id="html_element"></div>
                                    <div class="submit-btn">
                                       
                                                <input type="button" value="Submit" id="send_inquiry" class="form-submit-btn" onclick="saveDataContact();">

                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </form>
            </div>

            <div class="offset-md-1 col-lg-4 col-md-5 mt-md-0 mt-5 col-12">
                <div class="location_main_section">
                    <h3>GET IN TOUCH</h3>
                
                <ul class="get-in-touch-detail">
                    <!-- <li><a href="https://api.whatsapp.com/send?phone=919726222208&text=Hi, Need more information, let's discuss." class="g-whatsapp">919726222208</a></li> -->
                    <li><a href="https://api.whatsapp.com/send?phone=+{{$bs->country_code_number.''.$bs->whatsapp_number}}&text=Hi, Need more information, let's discuss." target="_blank" class="g-whatsapp">+{{$bs->country_code_number.''.$bs->whatsapp_number}}</a></li>


                    <li>
                        <!-- <a href="tel:+91 9426423006" class="g-mobile">+91 9426423006</a> -->
                        <a href="tel:+{{$bs->country_code_number.''.$bs->whatsapp_number}}" class="g-mobile">+{{$bs->country_code_number.''.$bs->whatsapp_number}}</a>

                    </li>
                    <li>
                        <a href="mailto:{{isset($bs->email) ? $bs->email : ''}}" class="g-mail">{{isset($bs->email) ? $bs->email : ''}}</a>
                    </li>
                </ul>
            </div>
				@php
$country = App\Models\Country::where('id', $contact->country)->first();
$state = App\Models\State::where('id', $contact->state)->first();
$city = App\Models\Citie::where('id', $contact->city)->first();



@endphp

@if($contact->status == 1)
				<section class="store-information">
    <div>
        <div class="location_section">
            <h3>STORE LOCATIONS</h3>
        
        <div class="row">
            <!-- Contact Us Single -->

            <div class="col-lg-12 col-md-12">
                <ul>
            <!--         <li class="c-location">
                        Juni Bazar,
                        Pani Darwaja Road,
                        Amreli
                        Gujarat 365601

                    </li> -->
                      <li class="c-location"><a href="{{ isset($bs->instore_link) ? $bs->instore_link : '' }}" target="_blank">{{$contact->address_line_1}}<br>{{$city->name.' '.$state->name.' '.$contact->pincode}}</a></li>
                    <!-- <li class="c-number"><a href="tel:+91 9016423087">+91 9016423087</a></li> -->
                    <!-- <li class="c-number"><a href="tel:+91 9016423087">+{{$contact->country_number.''.$contact->phone_number}}</a></li> -->
                    @if(isset($contact->phone_numbers) && $contact->phone_numbers != "")
                    @php
                    $alt_number = json_decode($contact->phone_numbers, true);
                    @endphp

                    @foreach($alt_number as $alt_number_value)
                    <li class="c-number"><a href="tel:+91{{$alt_number_value['number']}}">+91 {{$alt_number_value['number']}}</a></li>
                    @endforeach
                  
                    @endif

                    @if(isset($contact->w_numbers) && $contact->w_numbers != "")
                    @php
                    $alt_number_w = json_decode($contact->w_numbers, true);
                    @endphp

                    @foreach($alt_number_w as $alt_number_wl)
                    <li><a href="https://api.whatsapp.com/send?phone=+{{'91'.$alt_number_wl['number']}}&text=Hi, Need more information, let's discuss." target="_blank" class="g-whatsapp">+91{{$alt_number_wl['number']}}</a></li>
                    @endforeach
                  
                    @endif

                    <!-- <li class="c-number"><a href="tel:+91 9426423006">+91 9426423006</a></li> -->


                    <!-- <li class="c-mail"><a href="mailto:cgdholakia@gmail.com">cgdholakia@gmail.com</a></li> -->
                    <li class="c-mail"><a href="mailto:{{isset($contact->email) ? $contact->email : ''}}">{{isset($contact->email) ? $contact->email : ''}}</a></li>

                    @if(isset($contact->alt_email) && $contact->alt_email != '')
                        @php
                             $alt_email = explode(",", $contact->alt_email);
                        @endphp
                        @foreach($alt_email as $alt_email_value)
                        <li class="c-mail"><a href="mailto:{{$alt_email_value}}">{{$alt_email_value}}</a></li>

                        @endforeach
                          

                    @endif

                    <!-- <li class="c-mail"><a href="mailto:madhuvangold916@gmail.com">madhuvangold916@gmail.com</a></li> -->
                    <!-- <li>{{$contact->address_line_1}}</li> -->
                </ul>
            </div>
        </div>
        </div>
    </div>
</section>

@endif
                 <!-- <div class="c-title opening_hours">
                    @php
                    function convertTo12HourFormat($time) {
                        return date("g:i A", strtotime($time));
                    }

            
                    @endphp
                    <h3>OPENING HOURS</h3>
                    
                 
                        @if(isset($bs))
                        @php
                        $monday = json_decode($bs->monday);

                        $tuesday = json_decode($bs->tuesday);
                        $wedsday = json_decode($bs->wedsday);
                        $thursday = json_decode($bs->thursday);
                        $friday = json_decode($bs->friday);
                        $sat = json_decode($bs->sat);
                        $sun = json_decode($bs->sun);

                     
                        @endphp
                        <p class="opening_time">Monday: @if(isset($monday->status) && $monday->status != 0) {{convertTo12HourFormat($monday->from)}} – {{convertTo12HourFormat($monday->to)}} @else CLOSED @endif<br/>
                        Tuesday: @if(isset($tuesday->status) && $tuesday->status != 0) {{convertTo12HourFormat($tuesday->from)}} – {{convertTo12HourFormat($tuesday->to)}} @else CLOSED @endif<br/>
                        Wednesday: @if(isset($wedsday->status) && $wedsday->status != 0) {{convertTo12HourFormat($wedsday->from)}} – {{convertTo12HourFormat($wedsday->to)}}  @else CLOSED @endif<br/>
                        Thursday: @if(isset($thursday->status) && $thursday->status != 0) {{convertTo12HourFormat($thursday->from)}} – {{convertTo12HourFormat($thursday->to)}}  @else CLOSED @endif<br/>
                        Friday: @if(isset($friday->status) && $friday->status != 0) {{convertTo12HourFormat($friday->from)}} – {{convertTo12HourFormat($friday->to)}}  @else CLOSED @endif<br/>
                        Saturday: @if(isset($sat->status) && $sat->status != 0) {{convertTo12HourFormat($sat->from)}} – {{convertTo12HourFormat($sat->to)}}  @else CLOSED @endif<br/>
                        Sunday: @if(isset($sun->status) && $sun->status != 0) {{convertTo12HourFormat($sun->from)}} – {{convertTo12HourFormat($sun->to)}}  @else CLOSED @endif</p>

                        @else
                        @endif
                       
                 </div> -->
                
            </div>

        </div>
    </div>
</section>





@include('front.include.confidence')

@endsection

@section('script')

  



<script>
    $("#si_mobile").inputmask({mask: "9999999999",
        repeat: 10,
        greedy: false,
        clearMaskOnLostFocus: false});
    $(function() {
        $(".datepicker").datepicker({
            dateFormat: "dd-mm-yy", 
            minDate: 0 
        });
    });
</script>
    <script>
    function saveCallback() {
            $("#msg_rec_name_c").html("");
            $("#cn_name_checked").val('1');
        };
        function saveDataContact() {
                    // var checked = $('#cn_name_checked').val();
           
                    // if(!checked){
                    //     flag++;
                    //     $("#msg_rec_name_c").html("Please check the recaptcha");
                    // }
           
                    var si_name = $('#si_name').val();
                    var si_mobile = $('#si_mobile').val();
                    var si_email = $('#si_email').val();
                    var si_subject = $('#si_subject').val();
                    var si_message = $('#si_message').val();
                    var si_city = $('#si_city').val();
                    var si_price_range = $('#si_price_range').val();
                    var si_weight_range = $('#si_weight_range').val();
                    var si_delivery_date = $('#si_delivery_date').val();
                    var si_image = $('#si_image').files;
                    var si_description = $('#si_description').val();
                    var flag = 0;

                    /* Name Validation*/

                    if (si_name == '' || si_name == null) {
                        flag++;
                        $("#div_name").addClass('has-error');
                        $("#msg_name").html("Name is required.");
                    } else {
                        $("#div_name").removeClass('has-error');
                        $("#msg_name").html("");
                    }

                    /*
                     Mobile Validation.
                     */
                    var mobile_regx = /^\d{10}$/;
                    if (si_mobile == '' || si_mobile == null) {
                        flag++;
                        $("#div_mobile").addClass('has-error');
                        $("#msg_mobile").html("Mobile number is required");
                    } else if ((si_mobile != '') && !(si_mobile.match(mobile_regx))) {
                        $("#div_mobile").addClass('has-error');
                        $("#msg_mobile").html("Invalid Mobile Number.");
                        flag++;
                    } else {
                        $("#div_mobile").removeClass('has-error');
                        $("#msg_mobile").html("");
                    }

                    /*
                     email validation.
                     */
                    var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
                    if (si_email == '' || si_email == null) {
                        flag++;
                        $("#div_email1").addClass('has-error');
                        $("#msg_email").html("Email is required.");
                    } else if ((si_email != '') && (!(si_email.match(mailformat)))) {
                        $("#div_email1").addClass('has-error');
                        $("#msg_email").html("Invalid Email.");
                        flag++;
                    } else {
                        $("#div_email1").removeClass('has-error');
                        $("#msg_email").html("");
                    }

                    if (flag == 0) {
                        $('#contact_send_inquiry').submit();
                        $('#send_inquiry').prop('disabled', true);
                    } else {
                        return false;
                    }
                
        }
    </script>

<script>
$(document).ready(function() {
    var input = document.querySelector("#si_mobile");
    window.addEventListener("load", function () {
      
    var iti = window.intlTelInput(input, {
                initialCountry: "in",
                separateDialCode: true,
                autoPlaceholder: false,
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.15/js/utils.js",
            });
   });
})
</script>
 

@endsection

