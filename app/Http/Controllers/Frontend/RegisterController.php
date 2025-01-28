<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use App\Models\Category;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\Cart;
use App\Models\WishList;
use App\Models\SubscriberEmail;
use App\Models\Setting;
use App\Models\UserVerification;
use App\Mail\NotifyMail;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Mail;


class RegisterController extends Controller
{
    // public function index() {
    //     $user = User::where('role','!=','admin')->get();
    //     return view('user.add',compact('user'));
    // }
    // public function generate(Request $request)
    // {
    //     $password = Str::random(12);
    //     return response()->json(['password' => $password]);
    // }

    public function register(Request $request) {

        // $mobileCountryCode = $request->input('mobile_country_code');
        // dd($mobileCountryCode);
        // dd($request->all());
        // $rules = [
        //     'name' => 'required|string|max:255',
        //     'email' => 'required|email|unique:users',
        //     'phone' => 'nullable|max:255',
        //     'website' => 'nullable|url|max:255',
        //     'role' => 'required|string|max:255',
        //     'password' => 'required|min:6',
        // ];
        // $validatedData = $request->validate($rules);
        // $hashed = Hash::make($request->registration_password);

        // $user = new User();
        // $user->name = $request->reg_name;
        // $user->country_code_number = isset($request->reg_name) ? $request->reg_name : null ;
        // $user->phone = $request->reg_mobile;
        // $user->email  = $request->reg_email;
        // $user->password  = $hashed;
        // $user->role  = 'customer';
        // $user->terms = isset($request->terms) && $request->terms == 'true' ? 1 : 0 ;

        // $user->save();
        // return response()->json(['status' => 1, 'message' => 'User Register Successfully!']);

        // dd($request->all());
        $status_Code = 401;
        $status_message = "Invalid Request.";
      
        $secret_key = env('G_SECRET_KEY'); 
  
        
      if(isset($_POST) && !empty($_POST)){
        $status_Code = 402;
        $status_message = "Your account already exists. Forgot password CTA";
        
        $verify = $this->checkVerifyEmailOTP($request->reg_email,$request->reg_otp);
        
        if(!$verify){
            $status_Code = 402;
            $status_message = "OTP verification Failed!";
            return response()->json(['status' => $status_Code, 'message' => $status_message]);
        }
        
        $check_exist = User::check_user_login($_POST['reg_email'],$_POST['reg_mobile']);

        if(isset($check_exist) && count($check_exist) > 0)
        {
            foreach($check_exist as $check)
            {
                if(isset($check) && $check->deleted_at != '' && $check->deleted_at != null)
                {
                    $check->forceDelete();
                }
            }
        }
        $setting = Setting::first();
        if(isset($check_exist) && count($check_exist) == 0){

            if ($request->hasFile('business_card')) {
                $current = Carbon::now()->format('YmdHs');
                $uploadpdf1 = $request->file('business_card');
                $image1 = $current . $uploadpdf1->getClientOriginalName();
                $uploadpdf1->move('uploads/users/', $image1);
                $imageName1 = $image1;
            }else{
    
                $imageName1 = $request->b_old_img;
            }
           $hashed = Hash::make($request->registration_password);
           $user_email = $request->reg_email;
           $user_full_name = $request->reg_name;
           $user = new User();
           $user->name = $request->reg_name;
           $user->country_code = $request->country_code ? $request->country_code : null;
           $user->country_code_number = '+' . ($request->has('country_number') ? $request->country_number : null);
           $user->phone = $request->reg_mobile;
           $user->email  = $request->reg_email;
           $user->password  = $hashed;  
           $user->role  = 'customer';
           $user->terms = isset($request->terms) && $request->terms == 'true' ? 1 : 0 ;
           if(isset($setting->approval_for_login) && $setting->approval_for_login == 0)
           {
                if(isset($setting->access_limited_access) && $setting->access_limited_access != null && $setting->access_limited_access == 1)
                {
                    $currentDateTime = now();
                    $globalAccessHours = (int) $setting->global_access_hours;
                    $globalAccessMinutes = (int) $setting->global_access_min;
                    $endDateTime = $currentDateTime->copy()->addHours($globalAccessHours)->addMinutes($globalAccessMinutes);
                    $siteAccessStartDate = $currentDateTime->format('m/d/Y');
                    $siteAccessStartTime = $currentDateTime->format('H:i');
                    $siteAccessEndDate = $endDateTime->format('m/d/Y');
                    $siteAccessEndTime = $endDateTime->format('H:i');
                    $user->site_access_start_date = isset($siteAccessStartDate) ? $siteAccessStartDate : null;
                    $user->site_access_start_time = isset($siteAccessStartTime) ? $siteAccessStartTime : null;
                    $user->site_access_end_date = isset($siteAccessEndDate) ? $siteAccessEndDate : null;
                    $user->site_access_end_time = isset($siteAccessEndTime) ? $siteAccessEndTime : null;
                    $user->site_access = 1;
                }else{
                    $user->site_access = 0;
                }
                $user->approval = 1;
           }
           $user->business_name = isset($request->business_name) ? $request->business_name : null;
           $user->business_card = isset($imageName1) ? $imageName1 : null;
           $user->website = isset($request->website) ? $request->website : null;
           $user->save();
           $userAddress = UserAddress::where('user_id',$user->id)->first();
            if(!$userAddress)
            {
                $userAddress = new UserAddress();
            }
            $userAddress->user_id = $user->id;
            $userAddress->address = isset($request->address_1) ? $request->address_1 : null;
            $userAddress->address2 = isset($request->address_2) ? $request->address_2 : null;
            $userAddress->country = isset($request->country) ? $request->country : null;
            $userAddress->state = isset($request->state) ? $request->state : null;
            $userAddress->city = isset($request->city) ? $request->city : null;
            $userAddress->gst_number = isset($request->gst_number) ? $request->gst_number : null;
            $userAddress->social_1 = isset($request->social_1) ? $request->social_1 : null;
            $userAddress->social_2 = isset($request->social_2) ? $request->social_2 : null;
            $userAddress->email = isset($request->reg_email) ? $request->reg_email : null;
            $userAddress->fullname = isset($request->reg_name) ? $request->reg_name : null;
            $userAddress->save();
           $status_Code = 200;
           $status_message = "Registration Successful. Please Login";

           $MailController = new MailController();
           $MailController->sendWelComeEmail($user_email, $user_full_name);

           return response()->json(['status' => $status_Code, 'message' => $status_message]);
       }else{
                // send_response_api($status_Code, $status_message, '');
        return response()->json(['status' => $status_Code, 'message' => $status_message]);
    }
}else{
            // send_response_api($status_Code, $status_message, '');
    return response()->json(['status' => $status_Code, 'message' => $status_message]);
}
}

public function sentEmailVerificationCodeForLogin()
{

    if (isset($_POST['email']) && !empty($_POST['email'])) {
        $user_email = trim($_POST['email']);
        $User = new User();
        //User::set_email($_POST['email']);
        $check_exist = User::where('email', $user_email)->get();
        if ($check_exist == '' || $check_exist == null || $check_exist->isEmpty()) {
            $randomPassword = rand(100000, 999999);
            $User = new User();
            $ver = UserVerification::where('user_verification_email', $user_email)->first();
            if($ver){
                $ver->delete();
            }
            $id = UserVerification::insertGetId([
                'user_verification_email' => $_POST['email'],
                'user_verification_code' => $randomPassword,
                'add_date' => time()
            ]);
            $name = !empty($_POST['name'])? $_POST['name'] : '';
            if (isset($id) && !empty($id)) {
                $MailController = new MailController();
                $MailController->send_mail_verification_code($user_email, $randomPassword, $name);
                $code = 200;
                $mesage = 'OTP Sent To Your Email.Please Check Your Email.';
            } else {
                $code = 202;
                $mesage = 'OTP Not Sent';
            }
        } else {
            $code = 202;
            $mesage = 'Email is already registered, Please use another email.';
           
        }
    } else {
        $code = 404;
        $mesage = 'Invalid Request.';
    }
    
    return response()->json(['status' => $code, 'message' => $mesage]);
}
public function checkVerifyEmailOTPLogin()
{

    if (isset($_POST['login_email_otp']) && !empty($_POST['login_email_otp'])) {
        $useremail = $_POST['email'];
        $entered_otp = $_POST['login_email_otp'];
        $email_otp = UserVerification::where('user_verification_email', $useremail)->orderByDesc('user_verification_id')->first();
        $email_otp = $email_otp->login_email_otp;
        if ($entered_otp == $email_otp) {
            send_response_api('200', 'OTP Valid', '');
        } else {
            send_response_api('202', 'OTP Invalid', '');
        }
    }
}

public function checkVerifyEmailOTP($email,$otp)
{

    if (isset($email) && !empty($email)) {
        $useremail = $email;
        $entered_otp = $otp;
        $email_otp = UserVerification::where('user_verification_email', $useremail)->value('user_verification_code');
        $etimes = UserVerification::where('user_verification_email', $useremail)->value('created_at');
        
        if ($entered_otp == $email_otp) {
            return true;
        } else {
            return false;
        }
    }
}
public function login(Request $request)
{
 
    if(isset($request->phone) && $request->phone != '' && $request->phone != null)
    {
        $credentials = $request->only('phone', 'password','role');
    }else{
        $credentials = $request->only('email', 'password','role');
    }

    if (Auth::attempt($credentials)) {
        if(Auth::user()->approval == 1)
        {
            $cartData = session()->get('cart');
          
            if (!empty($cartData)) {
                foreach($cartData as $key => $cart_d)
                {
                    $existing = Cart::where('user_id',Auth::user()->id)->where('product_id',$cart_d['product_id'])->where('product_type',$cart_d['product_type'])->first();
                    if(isset($existing) && $existing != '' && $existing != null)
                    {
                        $cart = Cart::findOrfail($existing->id);
                    }else{
                        $cart = new Cart();
                    }
                    $cart->user_id = Auth::user()->id;
                    $cart->product_id = $cart_d['product_id'];
                    $cart->qty = $cart_d['qty'];
                    $cart->comment = isset($cart_d['order_comment']) ? $cart_d['order_comment'] : null;
                    $cart->product_type = isset($cart_d['product_type']) ? $cart_d['product_type'] : null;
                    $cart->save();
                }
            }
            $wishData = session()->get('wishlist');
            if (!empty($wishData)) {
                foreach($wishData as $key => $wish_d)
                {
                    $existing = WishList::where('user_id',Auth::user()->id)->where('product_id',$wish_d['product_id'])->where('product_type',$wish_d['product_type'])->first();
                    if(isset($existing) && $existing != '' && $existing != null)
                    {
                        $cart = WishList::findOrfail($existing->id);
                    }else{
                        $cart = new WishList();
                    }
                    $cart->user_id = Auth::user()->id;
                    $cart->product_id = $wish_d['product_id'];
                    $cart->product_type = $wish_d['product_type'];
                    $cart->qty = isset($wish_d['qty']) ? $wish_d['qty'] : null;
                    $cart->save();
                }
            }
            return response()->json(['status' => 1, 'message' => 'Login Successfully!']);
        }else{
            Auth::logout();
            return response()->json(['status' => 0, 'message' => 'Your Request is Pending!']);
        }
        
    }else{
        return response()->json(['status' => 0, 'message' => 'Login Failed!']);
    }
}
public function logout(Request $request)
{
        // dd($request->all());
    $previousUrl = url()->previous();
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    if ($request->ajax()) {
        return response()->json(['status' => 1]);
    }else{
        return redirect($previousUrl);
    }
}
    // public function delete($id) {
    //     if ($id !== "" && $id !== null) {
    //        User::where('id', $id)->delete();
    //        return redirect()->intended('users')
    //        ->withSuccess('User Deleted');
    //     }
    // }

    // public function edit(Request $request) {
    //     $id = $request->id;
    //     if ($id) {
    //         $data = User::where('id', $id)->first();
    //         return json_encode($data);
    //     }
    // }


public function sentEmailVerificationCode()
{

    if (isset($_POST['email']) && !empty($_POST['email'])) {
        $user_email = trim($_POST['email']);
        $User = new User();
        //User::set_email($_POST['email']);
        $check_exist = User::where('email', $user_email)->get();
        if ($check_exist == '' || $check_exist == null || $check_exist->isEmpty()) {
            $randomPassword = rand(100000, 999999);
            $User = new User();
            $ver = UserVerification::where('user_verification_email', $user_email)->first();
            if($ver){
                $ver->delete();
            }
            $id = UserVerification::insertGetId([
                'user_verification_email' => $_POST['email'],
                'user_verification_code' => $randomPassword,
                'add_date' => time()
            ]);
            $name = !empty($_POST['name'])? $_POST['name'] : '';
            if (isset($id) && !empty($id)) {
                $MailController = new MailController();
                $MailController->send_mail_verification_code($user_email, $randomPassword, $name);
                $code = 200;
                $mesage = 'OTP Sent To Your Email.Please Check Your Email.';
            } else {
                $code = 202;
                $mesage = 'OTP Not Sent';
            }
        } else {
            $code = 202;
            $mesage = 'Email is already registered, Please use another email.';
           
        }
    } else {
        $code = 404;
        $mesage = 'Invalid Request.';
    }
    
    return response()->json(['status' => $code, 'message' => $mesage]);
}

public function changePassword(Request $request)
{
   $response = array();
   $code = 401;
   $status_message = "Invalid Request.";
   
   $login_data = Auth::id();


   if (isset($login_data) && !empty($login_data)) {
    $user_id = trim($login_data);
    $new_password = $_POST['new_password'];
    $new_pass_update = Hash::make($new_password);
    $change_password = User::where('id', $user_id)
    ->update(['password' => $new_pass_update]);

    $code = 304;
    $status_message = "Something Went Wrong.";
    if ($change_password) {
        $code = 200;
        $status_message = "Password Changed.";
    }
}

return response()->json(['status' => $code, 'message' => $status_message]);
}

public function forgotPassword(Request $request)
{

   
   $response = array();
   $code = 401;
   $status_message = "Invalid Request.";
   $data = '';
   if (isset($_POST['email']) && !empty($_POST['email'])) {
    $user_email = trim($_POST['email']);
            // $User = new Users();
            // User::set_email($_POST['email']);
    $check_exist = User::check_user_login($_POST['email'], '');

    $code = 404;
    $status_message = "Email is not registered.";
    if (isset($check_exist) && !empty($check_exist)) {
        $user_full_name = $check_exist[0]->name;
        $randomPassword = randomPassword();

        $user_name = User::where('email', $user_email)->first();
        
        $user_full_name = $user_name->name;
        $update = User::where('email', $user_email)
        ->update(['temporary_access_code' => $randomPassword]);
        $code = 417;
        $status_message = "Please Check Your Email.";
        if ($update) {
            $MailController = new MailController();
            $MailController->send_mail_forget_password($user_email, $randomPassword, $user_full_name);
            $data = [
                'email' => $user_email
            ];
            $code = 200;
            $status_message = "Password Sent To Your Email.Please Check Your Email.";
        }
    }
}

return response()->json(['status' => $code, 'message' => $status_message]);

}


public function updatePassword(Request $request)
{

  $access_code = $_POST['temporary_access_code'];
  $new_password = $_POST['new_password'];
  $email = $_POST['email'];
  $check_exist = User::check_user_login($email, '');

  if (isset($check_exist) && !empty($check_exist) && $access_code == $check_exist[0]->temporary_access_code) {
    $change_password = User::where('id', $check_exist[0]->id)
    ->update(['password' => Hash::make($new_password)]);
    if ($change_password) {
                // send_response_api(200, "Password Update Successfully.", '');
        return response()->json(['status' => 200, 'message' => "Password Update Successfully."]);
    }
} else {
            // send_response_api(202, "Invalid Access Code.", '');
    return response()->json(['status' => 202, 'message' => "Invalid Access Code."]);
}
}



public function scribe_email(Request $request)
{
        $response = array();
        if(isset($request->email) && !empty($request->email)){
             $subscriber_email = new SubscriberEmail();
             $subscriber_email->subscriber_email = $request->email;
             $subscriber_email->save();

            
            $MailController = new MailController();
            $success = $MailController->subscribe_email_body($request->email);
            if(isset($success) && !empty($success)) {
                $response['success'] = 'TRUE';
                $response['message'] = 'Successfully Subscribe Email';
            }
        }else{
            $response['success'] = 'FALSE';
            $response['message'] = 'Please Provide Email';
        }

       return response()->json($response);
}



}


function randomPassword()
{
    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 6; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}
