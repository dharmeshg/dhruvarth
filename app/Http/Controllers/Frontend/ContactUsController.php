<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use App\Models\Category;
use App\Models\User;
use App\Models\Cart;
use App\Models\WishList;
use App\Models\SubscriberEmail;
use App\Models\SendInquiry;

use App\Mail\NotifyMail;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Config;

use Mail;


class ContactUsController extends Controller
{
	public function updateSendInquiryForm(Request $request)
	{
      


		 // if ($response == 'false') {
            $sendInquiry = new SendInquiry();
            $MailController = new MailController();
            //$BSPController=new BSPController();

            $si_image = '';
            if ($request->hasFile('si_image')) {
                $allowedfileExtension = ['jpg', 'jpeg', 'png'];
                $image = $request->file('si_image');
                $extension = $image->getClientOriginalExtension();
                $check = in_array($extension, $allowedfileExtension);
                if ($check) {
                    $name = time() . '.' . $image->getClientOriginalExtension();
                    $destinationPath = public_path('/inquiry_images');
                    $image->move($destinationPath, $name);
                    $image_url = asset('public/inquiry_images') . '/' . $name;
                    $inq_data['si_image'] = $image_url;
                    $si_image = $name;
                }
            }
   

            $sendInquiry->si_name = $request->si_name;
            $sendInquiry->si_mobile = $request->si_mobile;
            $sendInquiry->si_email = $request->si_email;
            $sendInquiry->si_description = $request->si_description;
            $sendInquiry->si_city = $request->si_city;
            $sendInquiry->si_price_range = $request->si_price_range;
            $sendInquiry->si_weight_range = $request->si_weight_range;
            $sendInquiry->si_delivery_date = $request->si_delivery_date;
            $sendInquiry->si_image = $si_image;
            // $sendInquiry->si_add_date = time();
            $sendInquiry->si_read_unread_status = 'Unread';


           $inq_form_submit =  $sendInquiry->save();



            // $inq_form_submit = $SendInquiry->send_inquiry($inq_data);
            if (isset($inq_form_submit) && $inq_form_submit == true ) {
                $image = '';
                if (isset($sendInquiry->si_image) && !empty($sendInquiry->si_image)) {
                    $image = asset('inquiry_images/' . $sendInquiry->si_image);
                }
                $subject = 'New Inquiry - ' . Config::get('services.website_constant.JWL_FOOTER_COPYRIGHT_CONTENT');

                $message = '';
                if (isset($sendInquiry->si_price_range) && !empty($sendInquiry->si_price_range)) {
                    $inq_data['si_price_range'] = $sendInquiry->si_price_range;
                } else {
                    $inq_data['si_price_range'] = '';
                }
                if (isset($sendInquiry->si_description) && !empty($sendInquiry->si_description)) {
                    $inq_data['si_description'] = $sendInquiry->si_description;
                } else {
                    $inq_data['si_description'] = '';
                }
                if (isset($sendInquiry->si_weight_range) && !empty($sendInquiry->si_weight_range)) {
                    $inq_data['si_weight_range'] = $sendInquiry->si_weight_range;
                } else {
                    $inq_data['si_weight_range'] = '';
                }
                if (isset($sendInquiry->si_city) && !empty($sendInquiry->si_city)) {
                    $inq_data['si_city'] = $sendInquiry->si_city;
                } else {
                    $inq_data['si_city'] = '';
                }
                if (isset($sendInquiry->si_delivery_date) && !empty($sendInquiry->si_delivery_date)) {
                    $inq_data['si_delivery_date'] = $sendInquiry->si_delivery_date;
                } else {
                    $inq_data['si_delivery_date'] = '';
                }

                $email_body = $MailController->send_inquiry_email_body($sendInquiry->si_name, $sendInquiry->si_email, $sendInquiry->si_mobile, $subject, $message, $sendInquiry->si_city, $inq_data['si_price_range'], $inq_data['si_weight_range'], $inq_data['si_delivery_date'], $image, $inq_data['si_description']);
                return redirect()->back()->with('success','Your Inquiry has be successfully sent to Admin');
            } else {
                // $msg = "error while sending inquiry";
                // session()->put('message', $msg);
                // session()->save();
                return redirect()->back();
            }
        // } else {
        //     $msg = "Recaptcha verification failed";
        //     session()->put('message', $msg);
        //     session()->save();
        //     return redirect()->back();
        // }
	}



}
