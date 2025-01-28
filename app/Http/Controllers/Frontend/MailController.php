<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use App\Models\Category;
use App\Models\User;
use App\Models\Cart;
use App\Models\WishList;
use App\Models\BusinessSetting;
use App\Models\Country;
use App\Models\State;
use App\Models\Citie;
use App\Models\Order;
use App\Models\UserAddress;
use App\Models\Catalogue;
use App\Models\OrderItems;
use App\Mail\NotifyMail;
use App\Mail\SendOtpMail;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Mail;
use URL;


class MailController extends Controller
{
    
    public function send_mail_verification_code($user_email, $randomPassword,$name='')
    {
        $biz_details_tmp = BusinessSetting::first();
        
        $data['business_logo'] = URL::to('/')."/uploads/images/".$biz_details_tmp->business_logo;
        $data['business_url'] = $biz_details_tmp->website_link;
        $data['business_name'] = $biz_details_tmp->business_name;
        $data['otp'] = $randomPassword;
  
        // $admin_email = $this->admin_email;
        // $data['business_data'] = $this->getBusinessDetails();
        // $domain_name = Config::get('services.website_constant.JWL_SENDER_EMAIL');
        // $from = "$domain_name";
        // $headers = "From: $from\r\n";
        // $headers .= "MIME-Version: 1.0" . "\r\n";
        // $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        // $subject = 'Email Verification Code';
        // $data['email'] = $user_email;
        // $data['randomPassword'] = $randomPassword;
        // $data['business_url'] = $this->business_url;
        // $biz_address_details = $this->get_biz_address_details($this->bd_id);
        // $data['ba_address_line_1'] = @$biz_address_details->ba_address_line_1 ? $biz_address_details->ba_address_line_1 : '';
        // $data['ba_address_line_2'] = @$biz_address_details->ba_address_line_2 ? $biz_address_details->ba_address_line_2 : '';
        // $data['ba_city'] = @$biz_address_details->ba_city ? $biz_address_details->ba_city : '';
        // $data['ba_state'] = @$biz_address_details->ba_state ? $biz_address_details->ba_state : '';
        // $data['ba_country'] = @$biz_address_details->ba_country ? $biz_address_details->ba_country : '';
        // $data['business_logo'] = $data['business_data']->bd_biz_logo;
        // $data['admin_email'] = $admin_email;
        // if (!empty(Config::get('services.website_constant.BREVO_KEY'))) {
        //     $exploded_email = explode('@', $user_email);
        //     $array = [
        //         'to' => [
        //             [
        //                 'email' => $user_email,
        //                 'name' => !empty($name)?$name:$exploded_email[0],
        //             ],
        //         ],
        //         'templateId' => intval(Config::get('services.website_constant.BREVO_EMAIL_VERIFICATION_OTP_APP_EMAIL_TEMPLATE_ID')),
        //         'params' => [
        //             'name' => !empty($name)?$name:$exploded_email[0],
        //             'random_password' => $randomPassword,
        //             'domain_name' => $data['business_data']->bd_business_name
        //         ],
        //         'headers' => [
        //             'charset' => 'iso-8859-1',
        //         ],
        //     ];
        //     $this->sendBrevoEmail($array);
        //     //$this->saveEmailContact($user_email,$exploded_email[0]);
        //     return true;
        // } else {
        //     $subcribe_email_body = view('email-template.sent_email_verification_otp_template', $data)->render();
        //     mail($user_email, $subject, $subcribe_email_body, $headers);
        //     return true;
        // }
        Mail::to($user_email)->send(new SendOtpMail($data));
    }
    
	public function send_mail_forget_password($user_email, $randomPassword, $user_full_name)
    {
    	// $businessSetting = BusinessSetting::first();


        $biz_details_tmp = BusinessSetting::first();
        // $domain_name = Config::get('services.website_constant.JWL_SENDER_EMAIL');
        // $from = "$domain_name";
        // $headers  = "From: $from\r\n";
        // $headers .= "MIME-Version: 1.0" . "\r\n";
        // $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        // $subject = "$domain_name - Your Temporary Access Code";
        $data['email'] = $user_email;
        $data['randomPassword'] = $randomPassword;
        // $data['domain_name'] = $domain_name;
        $data['user_full_name'] = $user_full_name;
        // $data['business_url'] = $this->business_url;
        $data['business_email'] = $biz_details_tmp->email;
        $data['business_whatsapp_no'] = $biz_details_tmp->whatsapp_number;
        $data['business_name'] = $biz_details_tmp->business_name;
        // $biz_address_details = $this->get_biz_address_details($this->bd_id);
        // $data['ba_address_line_1'] = @$biz_address_details->ba_address_line_1 ? $biz_address_details->ba_address_line_1 : '';
        // $data['ba_address_line_2'] = @$biz_address_details->ba_address_line_2 ? $biz_address_details->ba_address_line_2 : '';
        // $data['ba_city'] = @$biz_address_details->ba_city ? $biz_address_details->ba_city : '';
        // $data['ba_state'] = @$biz_address_details->ba_state ? $biz_address_details->ba_state : '';
        // $data['ba_country'] = @$biz_address_details->ba_country ? $biz_address_details->ba_country : '';
        // $data['business_logo'] = $biz_details_tmp->bd_biz_logo;
        if (!empty(Config::get('services.website_constant.BREVO_KEY'))) {
            $array = [
                'to' => [
                    [
                        'email' => $user_email,
                        'name' => 'admin',
                    ],
                ],
                'templateId' => intval(Config::get('services.website_constant.BREVO_FORGET_PASSWORD_EMAIL_TEMPLATE_ID')),
                'params' => [
                    'random_password' => $data['randomPassword'],
                    'domain_name' => $data['business_name']
                ],
                'headers' => [
                    'charset' => 'iso-8859-1',
                ],
            ];



            $this->sendBrevoEmail($array);
           
            return true;
        } else {
            $subcribe_email_body =  view('email-template.forgot_pass_email_template', $data)->render();
            mail($user_email, $subject, $subcribe_email_body, $headers);
            return $subcribe_email_body;
        }
    }

    public function sendWelComeEmail($user_email, $user_full_name)
    {
        // $biz_details_tmp = $this->getBusinessDetails();
        $biz_details_tmp = BusinessSetting::first();
        $domain_name = $biz_details_tmp->business_name;
        $from = "$domain_name";
        $headers  = "From: $from\r\n";
        $headers .= "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $subject = "Welcome to $biz_details_tmp->business_name";
        $data['email'] = $user_email;
        // $data['domain_name'] = $domain_name;
        // $data['user_full_name'] = $user_full_name;
        // $data['business_url'] = $this->business_url;
        // $data['business_email'] = $biz_details_tmp->email;
        // $data['business_whatsapp_no'] = $biz_details_tmp->bd_whatsapp_no;
        $data['business_name'] = $biz_details_tmp->business_name;
        // $biz_address_details = $this->get_biz_address_details($this->bd_id);
        // $data['ba_address_line_1'] = @$biz_address_details->ba_address_line_1 ? $biz_address_details->ba_address_line_1 : '';
        // $data['ba_address_line_2'] = @$biz_address_details->ba_address_line_2 ? $biz_address_details->ba_address_line_2 : '';
        // $data['ba_city'] = @$biz_address_details->ba_city ? $biz_address_details->ba_city : '';
        // $data['ba_state'] = @$biz_address_details->ba_state ? $biz_address_details->ba_state : '';
        // $data['ba_country'] = @$biz_address_details->ba_country ? $biz_address_details->ba_country : '';
        // $data['business_logo'] = $biz_details_tmp->bd_biz_logo;
        if (!empty(Config::get('services.website_constant.BREVO_KEY'))) {
            $array = [
                'to' => [
                    [
                        'email' => $user_email,
                        'name' => $user_full_name,
                    ],
                ],
                'templateId' => intval(Config::get('services.website_constant.BREVO_WELCOME_EMAIL_TEMPLATE_ID')),
                'params' => [
                    'business_name' => $data['business_name'],
                    'Business_Name' => $data['business_name']
                ],
                'headers' => [
                    'charset' => 'iso-8859-1',
                ],
            ];


            $this->sendBrevoEmail($array);
            
            return true;
        } else {
            $subcribe_email_body =  view('email-template.welcome_email_template', $data)->render();
            mail($user_email, $subject, $subcribe_email_body, $headers);
            return true;
        }
    }


     public function subscribe_email_body($email)
    {
        $biz_details_tmp = BusinessSetting::first();
        $city = Citie::where('id' , $biz_details_tmp->city)->first();
        $state = State::where('id' , $biz_details_tmp->city)->first();
        $country = Country::where('id' , $biz_details_tmp->city)->first();


        // $data['business_data'] = $this->getBusinessDetails();
        $data['email'] = $email;
        $data['business_url'] = $biz_details_tmp->website_link;
        $data['admin_email'] = $biz_details_tmp->email;
        // $biz_address_details = $this->get_biz_address_details($this->bd_id);
        // $data['ba_address_line_1'] = @$biz_address_details->ba_address_line_1 ? $biz_address_details->ba_address_line_1 : '';
        // $data['ba_address_line_2'] = @$biz_address_details->ba_address_line_2 ? $biz_address_details->ba_address_line_2 : '';
        $data['ba_city'] = isset($city->name) ? $city->name : '';
        $data['ba_state'] = isset($state->name) ? $state->name : '';
        $data['ba_country'] = isset($country->name) ? $country->name : '';
        $data['business_logo'] = $biz_details_tmp->business_logo;
        if (!empty(Config::get('services.website_constant.BREVO_KEY'))) {
            $array = [
                'to' => [
                    [
                        'email' => $biz_details_tmp->email,
                        'name' => $biz_details_tmp->business_name,
                    ],
                ],
                'templateId' => intval(Config::get('services.website_constant.BREVO_SUBSCRIBE_EMAIL_TEMPLATE_ID')),
                'params' => [
                    'email_id' => $email,
                ],
                'headers' => [
                    'charset' => 'iso-8859-1',
                ],
            ];

            $this->sendBrevoEmail($array);
            //$this->saveEmailContact($email,'');
            return true;
        } else {
            $subject = 'Subscribe Email';
            $from = Config::get('services.website_constant.JWL_SENDER_EMAIL');
            $to_email = Config::get('services.website_constant.JWL_PRIMARY_EMAIL');
            $headers = "From: $from\r\n";
            $headers  .= 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            $subcribe_email_body =  view('email-template.subscribe_email_template', $data)->render();
            mail($to_email, $subject, $subcribe_email_body, $headers);
            return true;
        }
    }

     public function send_inquiry_email_body($name, $email, $mobile, $subject, $message, $city, $price_range, $weight_range, $delivery_date, $image, $description)
    {

        $biz_details_tmp = BusinessSetting::first();
        $cts = $city;
        $city = Citie::where('id' , $biz_details_tmp->city)->first();
        $state = State::where('id' , $biz_details_tmp->city)->first();
        $country = Country::where('id' , $biz_details_tmp->city)->first();

        $data['name'] = $name;
        $data['email'] = $email;
        $data['mobile'] = $mobile;
        $data['message'] = $message;
        $data['city'] = $city;
        $data['price_range'] = $price_range;
        $data['weight_range'] = $weight_range;
        $data['delivery_date'] = $delivery_date;
        $data['image'] = $image;
        $data['description'] = $description;
        $data['business_url'] = $biz_details_tmp->website_link;
        $data['admin_email'] = $biz_details_tmp->email;
        $data['business_data'] = "";
        // $biz_address_details = $this->get_biz_address_details($this->bd_id);
        // $data['ba_address_line_1'] = @$biz_address_details->ba_address_line_1 ? $biz_address_details->ba_address_line_1 : '';
        // $data['ba_address_line_2'] = @$biz_address_details->ba_address_line_2 ? $biz_address_details->ba_address_line_2 : '';
        $data['ba_city'] = isset($cts) ? $cts : '';
        $data['ba_state'] = isset($state->name) ? $state->name : '';
        $data['ba_country'] = isset($country->name) ? $country->name : '';
        $data['business_logo'] = $biz_details_tmp->business_logo;
        $send_inquiry_email_body =  view('email-template.send_inquiry_email_template', $data)->render();

        if (!empty(Config::get('services.website_constant.BREVO_KEY'))) {
            $array = [
                'to' => [
                    [
                        'email' => $biz_details_tmp->email,
                        'name' => $biz_details_tmp->business_name,
                    ],
                ],
                'templateId' => intval(Config::get('services.website_constant.BREVO_CONTACT_ENQUERY_EMAIL_TEMPLATE_ID')),
                'headers' => [
                    'charset' => 'iso-8859-1',
                ],
                'params' => [
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'phone' => $data['mobile'],
                    'city' => $data['ba_city'],
                    'price' => $data['price_range'],
                    'weight' => $data['weight_range'],
                    'date' => $data['delivery_date'],
                    'description' => $data['description'],
                    'image' => $data['image']
                ],
            ];

            $this->sendBrevoEmail($array);
            // $this->saveEmailContact($email,$name);
            return true;
        } else {
            $admin_email = $email;
            $sender_email = Config::get('services.website_constant.JWL_SENDER_EMAIL');
            $from = "$sender_email";
            $to_email = Config::get('services.website_constant.JWL_PRIMARY_EMAIL');
            $headers = "From: $from\r\n";
            $headers .= 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

            mail($to_email, $subject, $send_inquiry_email_body, $headers);
            return true;
        }
    }

public function send_cancel_order_mail_to_user($order_id,$user_id)
    {
        $biz_details_tmp = BusinessSetting::first();
        $city = Citie::where('id' , $biz_details_tmp->city)->first();
        $state = State::where('id' , $biz_details_tmp->state)->first();
        $country = Country::where('id' , $biz_details_tmp->country)->first();
        $admin_email = $biz_details_tmp->email;
        $sender_email = Config::get('services.website_constant.JWL_SENDER_EMAIL');
        $user_details = Order::where('id', $order_id)->get();
        $user_email = User::where('id',$user_id)->first();
        $headers = "From: {$sender_email}\r\n";
        $headers .= "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $subject = "Order canceled by {$biz_details_tmp->business_name}";
        $data['admin_email'] = $admin_email;
        $data['user_details'] = $user_details;
        $data['user_details_u'] = $user_email;
        $data['status'] = '';
        $data['business_url'] = $biz_details_tmp->website_link;
        $data['business_logo'] = asset('uploads/'.$biz_details_tmp->business_logo);
        $data['business_data'] = $biz_details_tmp;
        $data['ba_address_line_1'] = $biz_details_tmp->street ? $biz_details_tmp->street : '';
        $data['ba_address_line_2'] = $biz_details_tmp->area ? $biz_details_tmp->area : '';
        $data['ba_city'] = $city->name ? $city->name : '';
        $data['ba_state'] = $state->name ? $state->name : '';
        $data['ba_country'] = $country->name ? $country->name : '';


        if (!empty(Config::get('services.website_constant.BREVO_KEY'))) {
            $array = [
                'to' => [
                    [
                        'email' => $user_email->email,
                        'name' => $user_email->name,
                    ],
                ],
                'templateId' => intval(Config::get('services.website_constant.BREVO_ORDER_STATUS_CANCEL_BY_ADMIN_EMAIL_TEMPLATE_ID')),
                'params' => [
                    'name' => $user_email->name,
                    'order_id' => $order_id,
                    'x' => '',
                    'ABCD1234' => '',
                    'email' => $admin_email,
                ],
                'headers' => [
                    'charset' => 'iso-8859-1',
                ],
            ];
            //$this->saveEmailContact($user_email,$user_details[0]->customer_first_name);
            $this->sendBrevoEmail($array);
            return true;
        } else {
            $message = view('email-template.cancel_order_mail_to_user', $data)->render();
            mail($user_email, $subject, $message, $headers);
        }
    }

    public function send_cancel_order_mail_to_admin($order_id)
    {
        $biz_details_tmp = BusinessSetting::first();
        $city = Citie::where('id' , $biz_details_tmp->city)->first();
        $state = State::where('id' , $biz_details_tmp->state)->first();
        $country = Country::where('id' , $biz_details_tmp->country)->first();
        $admin_email = $biz_details_tmp->email;
        $sender_email = Config::get('services.website_constant.JWL_SENDER_EMAIL');
        $user_details = Order::where('id', $order_id)->get();
        $user_email = User::where('id',Auth::user()->id)->first();
        $headers = "From: {$sender_email}\r\n";
        $headers .= "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $subject = "Order canceled by customer";
        $data['admin_email'] = $admin_email;
        $data['user_details'] = $user_details;
        $data['user_details_u'] = $user_email;
        $data['status'] = '';
        $data['business_url'] = $biz_details_tmp->website_link;
        $data['business_logo'] = asset('uploads/'.$biz_details_tmp->business_logo);
        $data['business_data'] = $biz_details_tmp;
        $data['ba_address_line_1'] = $biz_details_tmp->street ? $biz_details_tmp->street : '';
        $data['ba_address_line_2'] = $biz_details_tmp->area ? $biz_details_tmp->area : '';
        $data['ba_city'] = $city->name ? $city->name : '';
        $data['ba_state'] = $state->name ? $state->name : '';
        $data['ba_country'] = $country->name ? $country->name : '';

        if (!empty(Config::get('services.website_constant.BREVO_KEY'))) {
            $array = [
                'to' => [
                    [
                        'email' => $admin_email,
                        'name' => $biz_details_tmp->business_name,
                    ],
                ],
                'templateId' => intval(Config::get('services.website_constant.BREVO_ORDER_STATUS_CANCEL_BY_USER_EMAIL_TEMPLATE_ID')),
                'params' => [
                    'order_id' => $order_id
                ],
                'headers' => [
                    'charset' => 'iso-8859-1',
                ],
            ];
            $this->sendBrevoEmail($array);
            //$this->saveEmailContact($user_details[0]->customer_first_name,$user_details[0]->customer_email);
            return true;
        } else {
            $message = view('email-template.cancel_order_mail_to_admin', $data)->render();
            mail($admin_email, $subject, $message, $headers);
        }
    }
    public function send_new_order_mail_to_admin($order_id)
    {
        $biz_details_tmp = BusinessSetting::first();
        $city = Citie::where('id' , $biz_details_tmp->city)->first();
        $state = State::where('id' , $biz_details_tmp->state)->first();
        $country = Country::where('id' , $biz_details_tmp->country)->first();
        $admin_email = $biz_details_tmp->email;
        $sender_email = Auth::user()->name;
        $user_id = Auth::user()->id;
        $user_details = User::where('id', $user_id)->get();
        $order_details = Order::where('id', $order_id)->first();
        $order_items = OrderItems::where('order_id',$order_details->id)->get();
        $address_details = UserAddress::where('user_id',$order_details->user_id)->first();
        
        // Product Attributes.
        $separator = md5(time());
        $eol = PHP_EOL;
        $domain_name = Config::get('services.website_constant.APP_URL');
        $from = "$sender_email";
        $headers = "From: $from\r\n";
        //$headers .= "Bcc: vidhi.patel@bsptechno.com\r\n";
        $headers .= "MIME-Version: 1.0" . $eol;
        $headers .= "Content-Type: multipart/mixed; boundary=\"" . $separator . "\"";
        $subject = "You have received a new order #{$order_id} from {$domain_name}";
        $message = '';
        $message = "Content-Transfer-Encoding: 7bit" . $eol . $eol;
        $message .= "--" . $separator . $eol;
        $message .= "Content-Type: text/html; charset=\"iso-8859-1\"" . $eol;
        $message .= "Content-Transfer-Encoding: 8bit" . $eol . $eol;

        $data['admin_email'] = $admin_email;
        $data['order_details'] = $order_details;
        $data['order_items'] = $order_items;
        $data['user_details'] = $address_details;
        $data['status'] = '';
        $data['business_url'] = $biz_details_tmp->website_link;
        $data['business_logo'] = asset('uploads/'.$biz_details_tmp->business_logo);
        $data['business_data'] = $biz_details_tmp;
        $data['ba_address_line_1'] = $biz_details_tmp->street ? $biz_details_tmp->street : '';
        $data['ba_address_line_2'] = $biz_details_tmp->area ? $biz_details_tmp->area : '';
        $data['ba_city'] = $city->name ? $city->name : '';
        $data['ba_state'] = $state->name ? $state->name : '';
        $data['ba_country'] = $country->name ? $country->name : '';

        if (!empty(Config::get('services.website_constant.BREVO_KEY'))) {
            $array = [
                'to' => [
                    [
                        'email' => $admin_email,
                        'name' => $data['business_data']->business_name,
                    ],
                ],
                'templateId' => intval(Config::get('services.website_constant.BREVO_NEW_ORDER_TO_SELLER_EMAIL_TEMPLATE_ID')),
                'params' => [
                    'user_name' => $from,
                    'business_name' => $data['business_data']->business_name,
                ],
                'attachment' => [
                    [
                        'name' => 'order.pdf',
                        'content' => !empty($order_details->pdf_path) ? base64_encode(file_get_contents($order_details->pdf_path)) : '',
                        'type' => 'application/pdf',
                    ],
                ],
                'headers' => [
                    'charset' => 'iso-8859-1',
                ],
            ];
            $this->sendBrevoEmail($array);
            //$this->saveEmailContact($user_details->email,$user_details[0]->name);
            return true;
        } else {
            $message .= view('email-template.new_order_mail_to_admin', $data)->render();

            if (isset($order_details->pdf_path) && !empty($order_details->pdf_path)) {
                $invc_pdf = $order_details->pdf_path;
            }
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $invc_pdf);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $contents = curl_exec($ch);
            curl_close($ch);
            $attachment2 = chunk_split(base64_encode($contents));
            $message .= "--" . $separator . $eol;
            $message .= "Content-Type: application/octet-stream; name=\"" . basename($invc_pdf) . "\"" . $eol;
            $message .= "Content-Transfer-Encoding: base64" . $eol;
            $message .= "Content-Disposition: attachment" . $eol . $eol;
            $message .= $attachment2 . $eol;
            $message .= "--" . $separator . "--";
            if ($_SERVER['HTTP_HOST'] != 'localhost:7777') {
                mail($admin_email, $subject, $message, $headers);
            }
        }
    }
    public function send_new_order_mail_to_user($order_id)
    {
        $biz_details_tmp = BusinessSetting::first();
        $city = Citie::where('id' , $biz_details_tmp->city)->first();
        $state = State::where('id' , $biz_details_tmp->state)->first();
        $country = Country::where('id' , $biz_details_tmp->country)->first();
        $admin_email = $biz_details_tmp->email;
        $sender_email = Config::get('services.website_constant.JWL_SENDER_EMAIL');
        $user_id = Auth::user()->id;
        $user_details = User::where('id', $user_id)->get();
        $order_details = Order::where('id', $order_id)->first();
        $order_items = OrderItems::where('order_id',$order_details->id)->get();
        $address_details = UserAddress::where('user_id',$order_details->user_id)->first();
        
        // Product Attributes.
        $separator = md5(time());
        $eol = PHP_EOL;
        $domain_name = Config::get('services.website_constant.APP_URL');
        $from = "$sender_email";
        $headers = "From: $from\r\n";
        //$headers .= "Bcc: vidhi.patel@bsptechno.com\r\n";
        $headers .= "MIME-Version: 1.0" . $eol;
        $headers .= "Content-Type: multipart/mixed; boundary=\"" . $separator . "\"";
        $subject = "You have received new order #$order_id from $domain_name";
        $message = '';
        $message = "Content-Transfer-Encoding: 7bit" . $eol . $eol;
        $message .= "--" . $separator . $eol;
        $message .= "Content-Type: text/html; charset=\"iso-8859-1\"" . $eol;
        $message .= "Content-Transfer-Encoding: 8bit" . $eol . $eol;

        $data['admin_email'] = $biz_details_tmp->email;
        $data['order_details'] = $order_details;
        $data['order_items'] = $order_items;
        $data['user_details'] = $address_details;
        $data['status'] = '';
        $data['business_url'] = $biz_details_tmp->website_link;
        $data['business_logo'] = asset('uploads/'.$biz_details_tmp->business_logo);
        $data['business_data'] = $biz_details_tmp;
        $data['ba_address_line_1'] = $biz_details_tmp->street ? $biz_details_tmp->street : '';
        $data['ba_address_line_2'] = $biz_details_tmp->area ? $biz_details_tmp->area : '';
        $data['ba_city'] = $city->name ? $city->name : '';
        $data['ba_state'] = $state->name ? $state->name : '';
        $data['ba_country'] = $country->name ? $country->name : '';

        if (!empty(Config::get('services.website_constant.BREVO_KEY'))) {
            $array = [
                'to' => [
                    [
                        'email' => $data['user_details']->email,
                        'name' => $data['user_details']->fullname,
                    ],
                ],
                'templateId' => intval(Config::get('services.website_constant.BREVO_NEW_ORDER_TO_USER_EMAIL_TEMPLATE_ID')),
                'params' => [
                    'domain_name' => $data['business_data']->business_name,
                    'order_id' => $order_id,
                    'user_name' => $data['user_details']->fullname,
                    'business_name' => $data['business_data']->business_name,
                    'business_mobile' => Config::get('services.website_constant.JWL_PRIMARY_MOBILE')
                ],
                'attachment' => [
                    [
                        'name' => 'order.pdf',
                        'content' => !empty($order_details->pdf_path) ? base64_encode(file_get_contents($order_details->pdf_path)) : '',
                        'type' => 'application/pdf',
                    ],
                ],
                'headers' => [
                    'charset' => 'iso-8859-1',
                ],
            ];
            $this->sendBrevoEmail($array);
            //$this->saveEmailContact($user_details->email,$user_details[0]->name);
            return true;
        } else {
            $message .= view('email-template.new_order_mail_to_user', $data)->render();

            if (isset($order_details->pdf_path) && !empty($order_details->pdf_path)) {
                $invc_pdf = $order_details->pdf_path;
            }
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $invc_pdf);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $contents = curl_exec($ch);
            curl_close($ch);
            $attachment2 = chunk_split(base64_encode($contents));
            $message .= "--" . $separator . $eol;
            $message .= "Content-Type: application/octet-stream; name=\"" . basename($invc_pdf) . "\"" . $eol;
            $message .= "Content-Transfer-Encoding: base64" . $eol;
            $message .= "Content-Disposition: attachment" . $eol . $eol;
            $message .= $attachment2 . $eol;
            $message .= "--" . $separator . "--";
            if ($_SERVER['HTTP_HOST'] != 'localhost:7777') {

                mail($admin_email, $subject, $message, $headers);
            }
        }
    }
    public function send_processing_order_mail_to_user($order_id,$payment_status,$user_id)
    {
        $biz_details_tmp = BusinessSetting::first();
        $city = Citie::where('id' , $biz_details_tmp->city)->first();
        $state = State::where('id' , $biz_details_tmp->state)->first();
        $country = Country::where('id' , $biz_details_tmp->country)->first();
        $catalogue = Catalogue::inRandomOrder()->first();
        $admin_email = $biz_details_tmp->email;
        $admin_contact = $biz_details_tmp->whatsapp_number;
        $sender_email = Config::get('services.website_constant.JWL_SENDER_EMAIL');
        $user_details = Order::where('id', $order_id)->get();
        $user_email = User::where('id',$user_id)->first();
        $headers = "From: {$sender_email}\r\n";
        $headers .= "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $subject = "Order canceled by {$biz_details_tmp->business_name}";
        $data['admin_email'] = $admin_email;
        $data['user_details'] = $user_details;
        $data['user_details_u'] = $user_email;
        $data['status'] = '';
        $link = '';
        if($catalogue){
            $link = url('/').'catalogue/'.$catalogue->slug;
        }
        $data['business_url'] = $biz_details_tmp->website_link;
        $data['business_logo'] = asset('uploads/'.$biz_details_tmp->business_logo);
        $data['business_data'] = $biz_details_tmp;
        $data['ba_address_line_1'] = $biz_details_tmp->street ? $biz_details_tmp->street : '';
        $data['ba_address_line_2'] = $biz_details_tmp->area ? $biz_details_tmp->area : '';
        $data['ba_city'] = $city->name ? $city->name : '';
        $data['ba_state'] = $state->name ? $state->name : '';
        $data['ba_country'] = $country->name ? $country->name : '';
        if (!empty(Config::get('services.website_constant.BREVO_KEY'))) {
            $array = [
                'to' => [
                    [
                        'email' => $user_email->email,
                        'name' => $user_email->name,
                    ],
                ],
                'templateId' => intval(Config::get('services.website_constant.BREVO_ORDER_STATUS_PROCESSING_EMAIL_TEMPLATE_ID')),
                'params' => [
                    'name' => $user_email->name,
                    'order_id' => $order_id,
                    'payment_status' => $payment_status,
                    'contact_number' => $admin_contact,
                    'link' => $link, 
                ],
                'headers' => [
                    'charset' => 'iso-8859-1',
                ],
            ];
            //$this->saveEmailContact($user_email,$user_details[0]->customer_first_name);
            $this->sendBrevoEmail($array);
            return true;
        } else {
            $message = view('email-template.cancel_order_mail_to_user', $data)->render();
            mail($user_email, $subject, $message, $headers);
        }
    }
    public function send_dispatched_order_mail_to_user($order_id,$payment_status,$user_id, $link)
    {
        $biz_details_tmp = BusinessSetting::first();
        $city = Citie::where('id' , $biz_details_tmp->city)->first();
        $state = State::where('id' , $biz_details_tmp->state)->first();
        $country = Country::where('id' , $biz_details_tmp->country)->first();
        $admin_email = $biz_details_tmp->email;
        $admin_contact = $biz_details_tmp->whatsapp_number;
        $sender_email = Config::get('services.website_constant.JWL_SENDER_EMAIL');
        $user_details = Order::where('id', $order_id)->get();
        $user_email = User::where('id',$user_id)->first();
        $headers = "From: {$sender_email}\r\n";
        $headers .= "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $subject = "Order canceled by {$biz_details_tmp->business_name}";
        $data['admin_email'] = $admin_email;
        $data['user_details'] = $user_details;
        $data['user_details_u'] = $user_email;
        $data['status'] = '';
        $data['business_url'] = $biz_details_tmp->website_link;
        $data['business_logo'] = asset('uploads/'.$biz_details_tmp->business_logo);
        $data['business_data'] = $biz_details_tmp;
        $data['ba_address_line_1'] = $biz_details_tmp->street ? $biz_details_tmp->street : '';
        $data['ba_address_line_2'] = $biz_details_tmp->area ? $biz_details_tmp->area : '';
        $data['ba_city'] = $city->name ? $city->name : '';
        $data['ba_state'] = $state->name ? $state->name : '';
        $data['ba_country'] = $country->name ? $country->name : '';
        $site_url = url('/');
        // dd([$user_email->email,$admin_email,$site_url]);
        if (!empty(Config::get('services.website_constant.BREVO_KEY'))) {
            $array = [
                'to' => [
                    [
                        'email' => $user_email->email,
                        'name' => $user_email->name,
                    ],
                ],
                'templateId' => intval(Config::get('services.website_constant.BREVO_ORDER_STATUS_DISPATCHED_EMAIL_TEMPLATE_ID')),
                'params' => [
                    'email' => $admin_email,
                    'website' => $site_url,
                    'trackinglink' => $link
                ],
                'headers' => [
                    'charset' => 'iso-8859-1',
                ],
            ];
            //$this->saveEmailContact($user_email,$user_details[0]->customer_first_name);
            $this->sendBrevoEmail($array);
            return true;
        } else {
            $message = view('email-template.cancel_order_mail_to_user', $data)->render();
            mail($user_email, $subject, $message, $headers);
        }
    }
    public function send_completed_order_mail_to_user($order_id,$payment_status,$user_id)
    {
        $biz_details_tmp = BusinessSetting::first();
        $city = Citie::where('id' , $biz_details_tmp->city)->first();
        $state = State::where('id' , $biz_details_tmp->state)->first();
        $country = Country::where('id' , $biz_details_tmp->country)->first();
        $admin_email = $biz_details_tmp->email;
        $admin_contact = $biz_details_tmp->whatsapp_number;
        $sender_email = Config::get('services.website_constant.JWL_SENDER_EMAIL');
        $user_details = Order::where('id', $order_id)->get();
        $order_details = Order::where('id', $order_id)->first();
        $user_email = User::where('id',$user_id)->first();
        $headers = "From: {$sender_email}\r\n";
        $headers .= "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $subject = "Order canceled by {$biz_details_tmp->business_name}";
        $data['admin_email'] = $admin_email;
        $data['user_details'] = $user_details;
        $data['user_details_u'] = $user_email;
        $data['status'] = '';
        $data['business_url'] = $biz_details_tmp->website_link;
        $data['business_logo'] = asset('uploads/'.$biz_details_tmp->business_logo);
        $data['business_data'] = $biz_details_tmp;
        $data['ba_address_line_1'] = $biz_details_tmp->street ? $biz_details_tmp->street : '';
        $data['ba_address_line_2'] = $biz_details_tmp->area ? $biz_details_tmp->area : '';
        $data['ba_city'] = $city->name ? $city->name : '';
        $data['ba_state'] = $state->name ? $state->name : '';
        $data['ba_country'] = $country->name ? $country->name : '';
        $site_url = url('/');
        // dd([$user_email->email,$admin_email,$site_url]);
        if (!empty(Config::get('services.website_constant.BREVO_KEY'))) {
            $array = [
                'to' => [
                    [
                        'email' => $user_email->email,
                        'name' => $user_email->name,
                    ],
                ],
                'templateId' => intval(Config::get('services.website_constant.BREVO_ORDER_STATUS_COMPLETED_EMAIL_TEMPLATE_ID')),
                'params' => [
                    'email' => $admin_email,
                    'website' => $site_url,
                ],
                'attachment' => [
                    [
                        'name' => 'order.pdf',
                        'content' => !empty($order_details->pdf_path) ? base64_encode(file_get_contents($order_details->pdf_path)) : '',
                        'type' => 'application/pdf',
                    ],
                ],
                'headers' => [
                    'charset' => 'iso-8859-1',
                ],
            ];
            //$this->saveEmailContact($user_email,$user_details[0]->customer_first_name);
            $this->sendBrevoEmail($array);
            return true;
        } else {
            $message = view('email-template.cancel_order_mail_to_user', $data)->render();
            mail($user_email, $subject, $message, $headers);
        }
    }
    private function sendBrevoEmail($data_array)
    {
        $url = "https://api.brevo.com/v3/smtp/email";

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $headers = array(
            // 'Accept' => 'application/json',
            // 'api-key' => Config::get('services.website_constant.BREVO_KEY'),
            // 'Content-Type' => 'application/json',
            // "X-Sib-Sandbox" => "drop"


            "Content-Type: application/json",
            "accept: application/json",
            "api-key: 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",
            "X-Sib-Sandbox: drop"
        );



        $data = json_encode($data_array);

        curl_setopt($curl, CURLOPT_POST,true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_HEADER, true);
        $response = curl_exec($curl);
        curl_close($curl);
   
        return $response;
    }


    private function saveEmailContact($email,$name)
    {
        $data = [
            'email' => $email,
            'attributes' => [
                'SMS' => "",
                'FNAME' => $name,
                'LNAME' => "",
            ],
            'listIds' => [11],
            'emailBlacklisted' => false,
            'smsBlacklisted' => true,
            'updateEnabled' => false,
        ];
        $url = "https://api.brevo.com/v3/contacts";

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $headers = array(
            "Content-Type: application/json",
            "accept: application/json",
            "api-key: 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",
            "X-Sib-Sandbox: drop"
        );


        $data = json_encode($data_array);
        

        curl_setopt($curl, CURLOPT_POST,true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_HEADER, true);
        $response = curl_exec($curl);
        curl_close($curl);



        return $response;
    }
}