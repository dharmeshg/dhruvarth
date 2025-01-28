<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use App\Models\Category;
use App\Models\User;
use App\Models\Cart;
use App\Models\WishList;
use App\Models\Order;
use App\Models\Product;
use App\Models\StaticPage;
use App\Models\FAQ;
use App\Models\OrderItems;
use App\Models\UserAddress;
use App\Models\BusinessSetting;
use App\Models\Setting;
use App\Models\Country;
use App\Models\VariantProduct;
use App\Models\PromoCode;
use App\Mail\NotifyMail;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Barryvdh\DomPDF\Facade\Pdf as Pdf;
use Mail;
use Razorpay\Api\Api;

class OrderController extends Controller
{
	public function order_details($id)
	{
		$order_details = Order::where('id', $id)->where('status', '!=', null)->orderByDesc('id')->first();
		$order_items = OrderItems::where('order_id',$order_details->id)->get();
		$address_details = UserAddress::where('user_id',$order_details->user_id)->first();
		$SEOController = new SEOController();
        $SEOTitleDescription = $SEOController->_seoTitleDescriptionHome();
        return view('front.order_details', compact('order_details','order_items','address_details','SEOTitleDescription'));
		
	}

	public function privacy_policy()
	{
		$terms_condition = StaticPage::where('id', 2)->first();
		$SEOController = new SEOController();
		$title = 'Privacy Policy';
        $SEOTitleDescription = $SEOController->_seoTitleDescriptionPrivacyPolicy();
        $SEOSchemaCode = $SEOController->_seoSchemaCodePrivacy();
		return view('front.static_pages',compact('terms_condition','SEOTitleDescription','title','SEOSchemaCode'));
	}
	public function terms_and_condition()
	{
		$terms_condition = StaticPage::where('id', 1)->first();
		$SEOController = new SEOController();
        $SEOTitleDescription = $SEOController->_seoTitleDescriptionTermsAndCondition();
        $SEOSchemaCode = $SEOController->_seoSchemaCodeTerms();
        $title = 'Terms and Condition';
		return view('front.static_pages',compact('terms_condition','SEOTitleDescription', 'title','SEOSchemaCode'));
	}
	public function refund_policy()
	{
		$terms_condition = StaticPage::where('id', 3)->first();
		$SEOController = new SEOController();
        $SEOTitleDescription = $SEOController->_seoTitleDescriptionRefundPolicy();
        $SEOSchemaCode = $SEOController->_seoSchemaCodeRefund();
        $title = 'Refund Policy';
		return view('front.static_pages',compact('terms_condition','SEOTitleDescription','title','SEOSchemaCode'));
	}
	public function shipping_policy()
	{
		$terms_condition = StaticPage::where('id', 4)->first();
		$SEOController = new SEOController();
		$title = 'Shipping Policy';
        $SEOTitleDescription = $SEOController->_seoTitleDescriptionShippingPolicy();
        $SEOSchemaCode = $SEOController->_seoSchemaCodeShipping();
		return view('front.static_pages',compact('terms_condition','SEOTitleDescription','title','SEOSchemaCode'));
	}
	public function disclaimer()
	{
		$terms_condition = StaticPage::where('id', 5)->first();
		$SEOController = new SEOController();
		$title = 'Disclaimer';
        $SEOTitleDescription = $SEOController->_seoTitleDescriptionDisclaimer();
        $SEOSchemaCode = $SEOController->_seoSchemaCodedesclamier();
		return view('front.static_pages',compact('terms_condition','SEOTitleDescription','title','SEOSchemaCode'));
	}
	public function faq()
	{
		$terms_condition = StaticPage::where('id', 6)->first();
		if(isset($terms_condition) && $terms_condition->id == 6)
		{
			$faqs = FAQ::all();
		}
		$SEOController = new SEOController();
		$title = 'FAQs';
        $SEOTitleDescription = $SEOController->_seoTitleDescriptionFaqPage();
        $SEOSchemaCode = $SEOController->_seoSchemaCodeFAQ();
		return view('front.static_pages',compact('terms_condition','faqs','SEOTitleDescription', 'title','SEOSchemaCode'));
	}
	public function text_mail()
	{
		$url = "https://api.brevo.com/v3/smtp/email";

		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

		$headers = array(
	
		    "Content-Type: application/json",
		    "accept: application/json",
		    "api-key: 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",
		    "X-Sib-Sandbox: drop"
		);

		$data = '{  "to":[  {  "email":"niharika@karmaasource.com","name":"Niharika"}],
   			"templateId":15, "params":{  "business_name":"Madhuvan Gold","Business_Name":"Madhuvan Gold"}}';

		curl_setopt($curl, CURLOPT_POST,true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($curl, CURLOPT_HEADER, true);
		$response = curl_exec($curl);
		curl_close($curl);
		echo $response;

	}

	public function order_details_store(Request $request)
	{
		$user_id = $request->user_id;
		if(isset($user_id) && $user_id != null && $user_id != '')
		{
			// $order = new Order();
			// $order->user_id = $user_id;
			// $order->status = 'Pending';
			// $order->save();
			// $order_id = $order->id;

			// $cart_items = Cart::where('user_id',$user_id)->get();
			// if(isset($cart_items) && count($cart_items) > 0)
			// {
			// 	foreach ($cart_items as $key => $value) {
			// 		$product = Product::where('id',$value->product_id)->first();
			// 		$order_item = new OrderItems();
			// 		$order_item->user_id = $user_id;
			// 		$order_item->order_id = $order_id;
			// 		$order_item->product_id = isset($value->product_id) ? $value->product_id : null;
			// 		$order_item->qty = isset($value->qty) ? $value->qty : null;
			// 		$order_item->total_price = isset($product->p_grand_price_total) ? $product->p_grand_price_total : null;
			// 		$order_item->save();
			// 	}
			// }
			return response()->json(['status' => 1 , 'message' => 'Order added']);
		}else{
			return response()->json(['status' => 0, 'message' => 'Something Went Wrong!']);
		}
	}
	public function order_checkout()
	{
		
		$user_id = Auth::user()->id;
		$user_address = UserAddress::where('user_id',$user_id)->first();
		$db_cart_list = Cart::where('user_id',$user_id)->latest()->get();
		// foreach($db_cart_list as $key => $db){
		// 	$pdct = Product::where('id', $db->product_id)->first();
		// 	if(!$pdct){
		// 		$db_cart_list->forget($key);
		// 	}
		// }

		if($db_cart_list->count() <= 0){
        	return redirect()->route('front.cart.view');
        }
        
        $cart_list = $db_cart_list->map(function ($cart) {
            return [
                "id" => $cart->id,
                "product_id" => $cart->product_id,
				"product_type" => $cart->product_type,
                "qty" => $cart->qty, 
            ];
        })->toArray();


        if(count($cart_list)>0){
        	redirect()->route('front.cart.view');
        }
        if(count($cart_list)>0){
        	redirect()->route('front.cart.view');
        }
		$promoCodeSession = session('promo_code');
		$promoCodeData = ($promoCodeSession && $promoCodeSession['user_id'] == $user_id) ? $promoCodeSession : null;
        $countries = Country::all();
        $SEOController = new SEOController();
        $SEOTitleDescription = $SEOController->_seoTitleDescriptionCheckout();
		return view('front.checkout',compact('cart_list','user_address','SEOTitleDescription','countries','promoCodeData'));
	}

	public function save_checkout_data(Request $request)
	{

		$user_id = Auth::user()->id;
		$user = Auth::user();
		if ($this->hasValidSiteAccess($user)) {
			if(isset($user_id) && $user_id != '' && $user_id != null)
			{
				$promoCodeSession = session('promo_code');
				$promoCodeData = ($promoCodeSession && $promoCodeSession['user_id'] == $user_id) ? $promoCodeSession : null;
				// dd($promoCodeData['products']);
				$user_address = UserAddress::where('user_id',$user_id)->first();
				if(isset($user_address) && $user_address != '' && $user_address != null)
				{
					$user_address = UserAddress::findOrfail($user_address->id);
				}else{
					$user_address = new UserAddress();
				}
				$user_address->user_id = $user_id;
				$user_address->fullname = isset($request->fullname) ? $request->fullname : Auth::user()->name;
				$user_address->address = isset($request->address) ? $request->address : null;
				$user_address->address2 = isset($request->address2) ? $request->address2 : null;
				$user_address->country = isset($request->country) ? $request->country : null;
				$user_address->state = isset($request->state) ? $request->state : null;
				$user_address->zipcode = isset($request->zipcode) ? $request->zipcode : null;
				$user_address->city = isset($request->city) ? $request->city : null;
				$user_address->email = isset($request->email) ? $request->email : Auth::user()->email;
				$user_address->gst_number = isset($request->gst_number) ? $request->gst_number : null;
				$user_address->save();
	
				$order = new Order();
				$order->user_id = $user_id;
				
				//dd($request->checkout_method);
				if(($request->paymentMethod == 'zero_payment' || $request->paymentMethod == 'COD' || $request->paymentMethod == 'CCOD') && $request->paymentMethod != 'Cashfree' && $request->paymentMethod != 'razor_pay')
				{
					if($request->paymentMethod == 'COD') // Use '==' for comparison
					{
						$checkout_method = 'COD';
					}
					else if($request->paymentMethod == 'CCOD') // Use '==' for comparison
					{
						$checkout_method = 'CCOD';
					}
					else
					{
						$checkout_method = '-';
					}
					$order->checkout_method = $checkout_method;
					$order->payment_status = 'UnPaid';
					$order->status = 'Pending';
				}
				elseif($request->paymentMethod == 'Cashfree')
				{
					$order->checkout_method = 'Cashfree';
					$order->status = 'Pending';
					$order->status = null;
				}
				elseif($request->paymentMethod == 'razor_pay')
				{
					$order->checkout_method = 'Razor Pay / Online';
					$order->status = 'Pending';
					$order->status = null;
				}
				$order->promo_code_id = isset($request->promo_code_id) ? $request->promo_code_id : null;
				$order->promo_code_discount = isset($request->promo_code_discount) ? $request->promo_code_discount : null;
				$order->save();
				if(isset($request->promo_code_id) && $request->promo_code_id != '' && $request->promo_code_id != null)
				{
					$promocode = PromoCode::findOrfail($request->promo_code_id);
					$promocode->no_of_use += 1;
					$promocode->save();
				}
				$order_id = $order->id;
                $cart_items = Cart::where('user_id',$user_id)->get();
                $comment = optional($cart_items[count($cart_items) - 1])->comment??'';
                if($comment!==''){
                    Order::where('id',$order_id)->update(['comment'=>$comment]);
                }
                if($order->checkout_method == 'Razor Pay / Online')
                {
                    $razorpay_order_id = $this->createrazorpayid($request->total,$order_id);
                    Order::where('id',$order_id)
					->update([
						'razorpay_order_id' => $razorpay_order_id
					]);
                }
				if(isset($cart_items) && count($cart_items) > 0)
				{
					foreach ($cart_items as $key => $value) {
						if($value->product_type == 'simple')
						{
							$product = Product::where('id',$value->product_id)->first();
						}else{
							$product = VariantProduct::where('id',$value->product_id)->first();
						}
						
						if(!$product){
							continue;
						}
						$grand_price = str_replace(',', '', $product->total_price($product->id));
						if(isset($promoCodeData) && $promoCodeData != null)
						{
							$promoData = collect($promoCodeData['products'])->first(function ($promo) use ($value) {
								return $promo['product_id'] == $value->product_id && $promo['product_type'] == $value->product_type;
							});
						}
						$order_item = new OrderItems();
						$order_item->user_id = $user_id;
						$order_item->order_id = $order_id;
						$order_item->product_id = isset($value->product_id) ? $value->product_id : null;
						$order_item->product_type = isset($value->product_type) ? $value->product_type : null;
						$order_item->qty = isset($value->qty) ? $value->qty : null;
						$order_item->total_price = isset($grand_price) ? $grand_price : null;
						if (isset($promoData) && $promoData != null) {
							if(isset($promoData['promo_discount_price']) && $promoData['promo_discount_price'] != '' && $promoData['promo_discount_price'] != null)
							{
								$order_item->promo_code_discount = $promoData['promo_discount_price'];
								$order_item->promo_code_id = $promoCodeData['promo_code_id'];
							}
						}
						$order_item->save();
						if(($request->paymentMethod == 'zero_payment' || $request->paymentMethod == 'COD' || $request->paymentMethod == 'CCOD') && $request->paymentMethod != 'Cashfree' && $request->paymentMethod != 'razor_pay')
						{
							if($product->p_status = 'ready_stock'){
								if(isset($product->p_avail_stock_qty) && $product->p_avail_stock_qty != '' && $product->p_avail_stock_qty != null && $product->p_avail_stock_qty != 0)
								{
									$avail_qty = $product->p_avail_stock_qty - $value->qty;
									$product->update(['p_avail_stock_qty' => $avail_qty]);
								}
							}
						}
	
							// $cart = Cart::findOrfail($value->id);
			 //                $cart->delete();
					}
				}
				$file_url = $this->generatePDF($user_id,$order_id);
				$order_udate = Order::where('id',$order_id)->update(['pdf_path' => $file_url]);
				if(($request->paymentMethod == 'zero_payment' || $request->paymentMethod == 'COD' || $request->paymentMethod == 'CCOD') && $request->paymentMethod != 'Cashfree')
				{
					$MailController = new MailController();
					$MailController->send_new_order_mail_to_admin($order_id);
					$MailController->send_new_order_mail_to_user($order_id);
				}
	
				if(($request->paymentMethod == 'zero_payment' || $request->paymentMethod == 'COD' || $request->paymentMethod == 'CCOD') && $request->paymentMethod != 'Cashfree' && $request->paymentMethod != 'razor_pay')
				{
					if (isset($cart_items) && count($cart_items) > 0) {
						foreach ($cart_items as $key => $value) {
							$cart = Cart::findOrfail($value->id);
								$cart->delete();
						}
					}
				}
				session()->forget('promo_code');
				return response()->json(['status' => 1 , 'message' => 'Order added', 'order_id' => $order_id]);
			}else{
				return response()->json(['status' => 0, 'message' => 'Something Went Wrong!']);
			}
		}else {
			Auth::logout();
			return response()->json(['status' => 0, 'message' => 'Your access time has expired.']);
		}
		
	}
	public function update_order_detail(Request $request)
	{
		$user_id = Auth::user()->id;
		$order = Order::findOrfail($request->order_id);
		if($request->type == 'razor_pay')
		{
			$status = 'Completed';
			$p_status = 'Paid';
			$order->completed_order_id = $request->payment_id;
			$order->checkout_method = 'Razor Pay / Online';
		}else{
			if($request->cf_order_status == 'ACTIVE')
			{
				$status = 'Pending';
				$p_status = 'UnPaid';
			}else if($request->cf_order_status == 'PAID')
			{
				$status = 'Processing';
				$p_status = 'Paid';
			}else{
				$status = 'Pending';
				$p_status = 'UnPaid';
			}
			$order->completed_order_id = $request->cf_order_id;
			$order->transection_id = $request->cf_transection_id;
			$order->checkout_method = 'Cashfree';
		}
		$order->total_cost = $request->grand_total;
		$order->status = $status;
		$order->payment_status = $p_status;
		$order->save();

		$order_item = OrderItems::where('order_id',$request->order_id)->get();
		foreach($order_item as $order_e){
			if($order_e->product_type == 'simple')
			{
				$product = Product::where('id',$order_e->product_id)->first();
			}else{
				$product = VariantProduct::where('id',$order_e->product_id)->first();
			}
			
			if($product->p_status = 'ready_stock'){
				if(isset($product->p_avail_stock_qty) && $product->p_avail_stock_qty != '' && $product->p_avail_stock_qty != null && $product->p_avail_stock_qty != 0)
				{
					$avail_qty = $product->p_avail_stock_qty - $order_e->qty;
					$product->update(['p_avail_stock_qty' => $avail_qty]);
				}
			}
		}
		$cart_items = Cart::where('user_id',$user_id)->get();
		if(($order->checkout_method == 'Cashfree' || $order->checkout_method == 'Razor Pay / Online' ))
			{
        		if (isset($cart_items) && count($cart_items) > 0) {
					foreach ($cart_items as $key => $value) {
						$cart = Cart::findOrfail($value->id);
							$cart->delete();
					}
				}
			}
		$MailController = new MailController();
        $MailController->send_new_order_mail_to_admin($order->id);
        $MailController->send_new_order_mail_to_user($order->id);
		return response()->json(['status' => 1, 'message' => 'Payment Successfully']);
	}
	public function cancel_order(Request $request)
	{
		$user_id = Auth::user()->id;
		$order = Order::findOrfail($request->order_id);
		$order->status = 'Declined';
		$order->comment = $request->comment;
		$order->save();
		$order_item = OrderItems::where('order_id',$order->id)->get();
		foreach($order_item as $order_e){
			if($order_e->product_type == 'simple')
			{
				$product = Product::where('id',$order_e->product_id)->first();
			}else{
				$product = VariantProduct::where('id',$order_e->product_id)->first();
			}
			// $product = Product::where('id',$order_e->product_id)->first();
			if($product->p_status = 'ready_stock'){
				if(isset($product->p_avail_stock_qty) && $product->p_avail_stock_qty != '' && $product->p_avail_stock_qty != null)
				{
					$avail_qty = $product->p_avail_stock_qty + $order_e->qty;
					$product->update(['p_avail_stock_qty' => $avail_qty]);
				}
			}
		}
		$cart_items = Cart::where('user_id', $user_id)->whereIn('product_id', $order_item->pluck('product_id'))->delete();
		$MailController = new MailController();
        $MailController->send_cancel_order_mail_to_admin($order->id);
        $MailController->send_cancel_order_mail_to_user($order->id,$user_id);
		return response()->json(['status' => 1, 'message' => 'Order has been canceled successfully.']);

	}
	public function generatePDF($user_id,$order_id){
		$bs = BusinessSetting::first();
        $data['bs_logo'] = asset('uploads/images/'.$bs->business_logo);
        $data['order_details'] = Order::where('id', $order_id)->orderByDesc('id')->first();
		$data['order_items'] = OrderItems::where('order_id',$data['order_details']->id)->get();
		$data['address_details'] = UserAddress::where('user_id',$data['order_details']->user_id)->first();
		$data['user_details'] = User::where('id',$data['order_details']->user_id)->first();

        $pdf = Pdf::loadView('front.pdf.order_pdf', ['data'=>$data ,'bs' =>$bs]);
        $file_name = 'invoice_'.$order_id.time().'.pdf';
        // If you want to store the generated pdf to the server then you can use the store function
        $pdf->save(public_path().'/invoice/'.$file_name);
        $pdf->download($file_name);
        $baseUrl = url('/');
        $file_url = $baseUrl.'/invoice/'.$file_name;
        return $file_url;
    }
	public function fetchrazorpayid(Request $request)
	{
		$razorpay_order_id = $this->createrazorpayid($request->total,$request->order_id);
		return response()->json(['status' => 1, 'razorpay_order_id' => $razorpay_order_id]);
	}
	public function createrazorpayid($amount,$order_no){
        $payment = intval($amount * 100);	
        $fields = array();
        $fields["amount"] = $payment;
        $fields["currency"] = "INR";
        $fields["receipt"] =  (string)$order_no;
        $api_key=env('RAZORPAY_KEY');
        $api_secret=env('RAZORPAY_SECRET');
        //dd($api_key, $api_secret,$fields);
        $api = new Api($api_key, $api_secret);
        $result  = $api->order->create($fields);
        if(@$result['id']){
            $razorpay_order_id =$result['id'];
        }else{
            $razorpay_order_id=null;
        }
        return $razorpay_order_id;
    }
	private function hasValidSiteAccess($user)
	{
		$setting = Setting::first();
		if ($user->site_access === null) {
			return false; // Do not process if site_access is null
		}
		if ((isset($user->site_access) && $user->site_access == 1) && (isset($setting->access_limited_access) && $setting->access_limited_access != null && $setting->access_limited_access == 1)) {
			$startDateTime = Carbon::createFromFormat('m/d/Y H:i', $user->site_access_start_date . ' ' . $user->site_access_start_time);
			$endDateTime = Carbon::createFromFormat('m/d/Y H:i', $user->site_access_end_date . ' ' . $user->site_access_end_time);
			$currentDateTime = Carbon::now();

			return $currentDateTime->between($startDateTime, $endDateTime);
		}
		return true;
	}
}