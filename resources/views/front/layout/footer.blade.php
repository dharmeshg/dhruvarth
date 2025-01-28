@php
 $product_family = App\Models\Family::whereRaw('FIND_IN_SET(?, category_id)', 1)->take(5)->get();  
 $product_family = App\Models\Product::select('p_family')->distinct()->get()->pluck('p_family')->toArray();
 $product_family_array = array_filter($product_family); 

 $product_family = App\Models\Family::with(['products' => function ($query) {
            $query;
        }, 'products'])
            ->withCount('products')
            ->orderBy('products_count', 'desc')
            ->limit(5)
            ->get();

if(isset($bs->country) && $bs->country != '' && isset($bs->state) && $bs->state){
    $countryf = App\Models\Country::where('id',$bs->country)->first();
    $statef = App\Models\State::where('id',$bs->state)->first();
    $cityf = App\Models\Citie::where('id',$bs->city)->first();
}
@endphp
<div class="bottom-section">
    <section class="footer-sign-up-section common-padding common-section">
                <div class="container-md">
                    <div class="row">
                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <h3>Subscribe for latest updates!</h3>
                            <h3>Get Special offers, fashion tips, and more!</h3>
                        </div>
                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <form>
                                <article>
                                    <input type="text" placeholder="Enter your email" name="email" id="text_subscribe_email" value="">
                                    <button type="button" onclick="fun_scribe_email()">Sign Up</button>
                                </article>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
            
            <footer>
                <div class="container-md">
                    <div class="row">
                        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12 footer-quick-links">
                            <h3>Quick Links</h3>
                            <ul>
                                <li><a href="{{route('home')}}">Home</a></li>
                                <li><a href="{{route('front.about')}}">About Us</a></li>
                                <li><a href="{{route('front.catalogue')}}">Catalogues</a></li>
                                <li><a href="{{route('front.collection')}}">Collections</a></li>
                                <li><a href="{{route('front.faq')}}">FAQ’S</a></li>
                                <li><a href="{{route('home.contact_us')}}">Contact Us</a></li>
                            </ul>
                        </div>
                        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12 footer-all-product">
                            <h3>All Products</h3>
                            
                            <ul>
                                @if(isset($product_family) && count($product_family) > 0)
                                    @foreach($product_family as $product_family_value)
                                        <li><a href="{{ route('front.fam.products',['fam' => $product_family_value->slug]) }}">{{$product_family_value->family}}</a></li>
                                    @endforeach
                                @endif
                                <li><a href="{{route('front.all.products')}}">All Products</a></li>
                            </ul>
                        </div>
                        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12 footer-custome-care">
                            <h3>Customer Care</h3>
                            
                            <ul>
                                <li><a href="{{route('front.terms_and_condition')}}">Terms Of Use</a></li>
                                <li><a href="{{route('front.privacy_policy')}}">Privacy Policy</a></li>
                                <li><a href="{{route('front.refund_policy')}}">Refund Policy</a></li>
                                <li><a href="{{route('front.shipping_policy')}}">Shipping Policy</a></li>
                                <li><a href="{{route('front.disclaimer')}}">Disclaimer</a></li>
                            </ul>
                        </div>
                        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12 footer contact-us">
                            <h3>Contact Us</h3>
                            
                            <p>{{$bs->street.", ".$bs->street2}}</p>
                            <p>{{$cityf->name.', '.$statef->name.', '.$bs->pincode}}</p>
                            <ul class="information-section">
                                <li><a href="{{ isset($bs->instore_link) ? $bs->instore_link : '' }}">Map Location</a></li>
                                <li><a href="mailto: {{isset($bs->email) ? $bs->email : ''}}">{{isset($bs->email) ? $bs->email : ''}}</a></li>
                                <li class="number-text"><a href="tel: +{{$bs->country_code_number.''.$bs->whatsapp_number}}">+{{$bs->country_code_number.''.$bs->whatsapp_number}}</a></li>
                            </ul>
                        </div>
                    </div>
    
                    <div class="row inner-row">
                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 left-side">
                            <ul>
                                @if(isset($bs->facebook_link) && $bs->facebook_link != "")
                                    <li><a href="{{$bs->facebook_link}}" target="_blank"><img src="{{asset('front/src/images/facebook.svg')}}" width="auto" height="auto" alt="facebook" class="img-fluid" loading="lazy"></a></li>
                                @endif
                                @if(isset($bs->linkedin_link) && $bs->linkedin_link != "")
                                    <li><a href="{{$bs->linkedin_link}}" target="_blank"><img src="{{asset('front/src/images/linked_in.svg')}}" width="auto" height="auto" alt="twitter" class="img-fluid" loading="lazy"></a></li>
                                @endif
                                @if(isset($bs->twitter_link) && $bs->twitter_link != "")
                                    <li><a href="{{$bs->twitter_link}}" target="_blank"><img src="{{asset('front/src/images/twitter.svg')}}" width="auto" height="auto" alt="twitter" class="img-fluid" loading="lazy"></a></li>
                                @endif
                                @if(isset($bs->pinterest_link) && $bs->pinterest_link != "")
                                    <li><a href="{{$bs->pinterest_link}}" target="_blank"><img src="{{asset('front/src/images/printress.svg')}}" width="auto" height="auto" alt="printress" class="img-fluid" loading="lazy"></a></li>
                                @endif
                                @if(isset($bs->insta_link) && $bs->insta_link != "")
                                    <li><a href="{{$bs->insta_link}}" target="_blank"><img src="{{asset('front/src/images/instra.svg')}}" width="auto" height="auto" alt="instra" class="img-fluid" loading="lazy"></a></li>
                                @endif
                                @if(isset($bs->youtube_link) && $bs->youtube_link != "")
                                    <li><a href="{{$bs->youtube_link}}" target="_blank"><img src="{{asset('front/src/images/youtube.svg')}}" width="auto" height="auto" alt="youtube" class="img-fluid" loading="lazy"></a></li>
                                @endif
                            </ul>
                        </div>
                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 right-side">
                            <ul>
                                <li><a><img src="{{asset('front/src/images/visa-icon_result.webp')}}" width="auto" height="auto" alt="visa" class="img-fluid" loading="lazy"></a></li>
                                <li><a><img src="{{asset('front/src/images/master-card-icon_result.webp')}}" width="auto" height="auto" alt="master card" class="img-fluid" loading="lazy"></a></li>
                                <li><a><img src="{{asset('front/src/images/american-express-icon_result.webp')}}" width="auto" height="auto" alt="american express" class="img-fluid" loading="lazy"></a></li>
                                <li><a><img src="{{asset('front/src/images/upi-icon_result.webp')}}" width="auto" height="auto" alt="upi" class="img-fluid" loading="lazy"></a></li>
                                <li><a><img src="{{asset('front/src/images/stripe_result.webp')}}" width="auto" height="auto" alt="stripe" class="img-fluid" loading="lazy"></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
        
                <div class="back-top" id="back-top">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-up-fill" viewBox="0 0 16 16"><path d="m7.247 4.86-4.796 5.481c-.566.647-.106 1.659.753 1.659h9.592a1 1 0 0 0 .753-1.659l-4.796-5.48a1 1 0 0 0-1.506 0z" fill="var(--theme-dark-color)"></path>
                    </svg>
                </div>
        
                <div class="whatsapp">
                    <a target="_blank" href="https://api.whatsapp.com/send?phone={{$bs->country_code_number.''.$bs->whatsapp_number}}&amp;text=Hi, Need more information, let's discuss. "><img src="{{asset('front/src/images/whatsapp.svg')}}     " height="39" width="39" class="img-fluid" loading="lazy" alt="WhatsApp"></a>
                </div>
    
            </footer>
    
            <section class="copyright-section">
                <div class="container-md">
                    <div class="row">
                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <p>© <span class="number-text">2024</span> {{ isset($bs->business_name) ? $bs->business_name : '' }} | All rights reserved</p>
                        </div>
                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 text-end">
                            <p>Powered by <a href="https://bit.ly/ft-jewelxy" target="_blank">JEWELXY</a></p>
                        </div>
                    </div>
                </div>
            </section>
    
            <section class="cookies-section" id="cookiesSection">
                <div class="container-md">
                    <div class="row">
                        <div class="col-xxl-10 col-xl-10 col-lg-10 col-md-10 col-sm-12 col-xs-12">
                            <p>We use cookies to improve your experience. By clicking any link, you consent to our cookie usage.</p>
                        </div>
                        <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12 text-end">
                            <a href="javascript:void(0);" aria-label="cookies Text" class="cookies-btn">OK</a>
                        </div>
                    </div>
                </div>
            </section>
        </div> 