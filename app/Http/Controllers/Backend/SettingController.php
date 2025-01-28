<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\EmailSetting;
use App\Models\HomePageSetting;
use App\Models\CommentSetting;
use App\Models\BusinessSetting;
use App\Models\Currency;
use App\Models\Country;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Config;
use App\Models\Updatelog;
use App\Models\RegistrationFormSetting;
use DB;

class SettingController extends Controller
{
    public function dash_index()
    {
         return view('settings.dash_index');
    }
    public function global_settings()
    {
         return view('settings.global_settings');
    }
    // public function page_settings()
    // {
    //      return view('settings.page_settings');
    // }
    public function index()
    {
        $setting = Setting::first();
        if(isset($setting) && $setting != '' && $setting != null)
        {   
            return view('settings.index', compact('setting'));
        }else{
            return view('settings.index');
        }
        
    }
    public function business_index()
    {
        $setting = BusinessSetting::first();
        $currencies = Currency::all();
        $countries = Country::all();
        if(isset($setting) && $setting != '' && $setting != null)
        {   
            return view('settings.business_index', compact('setting','currencies','countries'));
        }else{
            return view('settings.business_index',compact('currencies','countries'));
        }
        
    }

    public function buy_with_confidence()
    {
        $setting = Setting::first();
        return view ('settings.buy-with-confidence',compact('setting'));
    }
    public function buy_with_confidence_save(Request $request)
    {
    
        $buyIcons = [];
        if(isset($request->buy_title) && count($request->buy_title) > 0)
        {
            foreach($request->buy_title as $key =>$buy_img)
            {
                if (array_key_exists($key, $request->file('buy_icon') ?? [])) {
                    $current = Carbon::now()->format('YmdHs');
                    $uploadpdf = $request->file('buy_icon')[$key];
                    $extension = $uploadpdf->getClientOriginalExtension();
                    $filename = $current . '_' . $key . '.' . $extension;
                    $uploadpdf->move('uploads/images/', $filename);
                }else{
                    $filename = isset($request->old_buy_icon[$key]) ? $request->old_buy_icon[$key] : '';
                }
                    $buyIcon = [
                        'title' => isset($request->buy_title[$key]) ? $request->buy_title[$key] : '',
                        'icon' => isset($filename) ? $filename : '',
                    ];
                    $buyIcons[] = $buyIcon;
            }
            $icon_json = json_encode($buyIcons);
        }
        $setting = Setting::first();
        // $setting->buy_sec_title = isset($request->buy_sec_title) ? $request->buy_sec_title : null;
        $setting->buy_with_confidence_sec = isset($icon_json) ? $icon_json : null;
        $setting->save();

        return redirect()->back()->with('success', 'Data saved successfully!');
    }

    public function get_state(Request $request)
    {
        $data['state'] = DB::table('states')->where("country_id", $request->country)->get();
        return response()->json($data);
    }
    public function get_city(Request $request)
    {
        $data['city'] = DB::table('cities')->where("state_id", $request->state)->get();
        return response()->json($data);
    }
    public function save(Request $request)
    {

        $id = $request->setting_id;
        if (isset($id) && $id != '') {
            $setting = Setting::findOrfail($id);
            $edata = json_encode($setting);
            if(isset($setting)){
                $setting->email = $request->email1;
                $setting->email2 = isset($request->email2) ? $request->email2 : null;
                $setting->contact_no = isset($request->contact_no) ? $request->contact_no : null;
                $setting->location = isset($request->location) ? $request->location : null;
                $setting->content = isset($request->content) ? $request->content : null;
                $setting->footer_text = isset($request->footer_text) ? $request->footer_text : null;
                $setting->site_title = isset($request->title) ? $request->title : null;
                $setting->site_tagline = isset($request->tagline) ? $request->tagline : null;
                $setting->site_url = isset($request->url) ? $request->url : null;
                $setting->site_logo = isset($request->site_logo) ? $request->site_logo : null;
                $setting->footer_logo = isset($request->footer_logo) ? $request->footer_logo : null;
                $setting->site_favicon = isset($request->site_favicon) ? $request->site_favicon : null;
                $setting->facebook_url = isset($request->facebook_url) ? $request->facebook_url : null;
                $setting->insta_url = isset($request->insta_url) ? $request->insta_url : null;
                $setting->twitter_url = isset($request->twitter_url) ? $request->twitter_url : null;
                $setting->linked_url = isset($request->linked_url) ? $request->linked_url : null;
                $setting->map = isset($request->map) ? $request->map : null;
                $setting->copyright = isset($request->copyright) ? $request->copyright : null;

                $setting->cta_image = isset($request->bg_img_id_cta) ? $request->bg_img_id_cta : null;
                $setting->cta_title = isset($request->cta_title) ? $request->cta_title : null;
                $setting->cta_btn_url = isset($request->cta_btn_url) ? $request->cta_btn_url : null;
                $setting->cta_btn_name = isset($request->cta_btn_name) ? $request->cta_btn_name : null;
                $setting->cta_description = isset($request->cta_description) ? $request->cta_description : null;
                $edt = Updatelog::create(['tablename'=>'general-setting','table_primary_id'=>$setting->id,'edit_log'=>$edata]);
                $setting->update();
                return redirect()->route('setting.index')->with('success','General Setting Updated Successfully.');
            }else{
                return redirect()->route('setting.index')->with('error','General Setting Update Failed!');
            }
        }else{
            $setting = new Setting();
            $setting->email = $request->email;
            $setting->email2 = isset($request->email2) ? $request->email2 : null;
            $setting->contact_no = isset($request->contact_no) ? $request->contact_no : null;
            $setting->location = isset($request->location) ? $request->location : null;
            $setting->content = isset($request->content) ? $request->content : null;
            $setting->footer_text = isset($request->footer_text) ? $request->footer_text : null;
            $setting->site_title = isset($request->title) ? $request->title : null;
            $setting->site_tagline = isset($request->tagline) ? $request->tagline : null;
            $setting->site_url = isset($request->url) ? $request->url : null;
            $setting->site_logo = isset($request->site_logo) ? $request->site_logo : null;
            $setting->footer_logo = isset($request->footer_logo) ? $request->footer_logo : null;
            $setting->site_favicon = isset($request->site_favicon) ? $request->site_favicon : null;
            $setting->facebook_url = isset($request->facebook_url) ? $request->facebook_url : null;
            $setting->insta_url = isset($request->insta_url) ? $request->insta_url : null;
            $setting->twitter_url = isset($request->twitter_url) ? $request->twitter_url : null;
            $setting->linked_url = isset($request->linked_url) ? $request->linked_url : null;
            $setting->map = isset($request->map) ? $request->map : null;
            $setting->copyright = isset($request->copyright) ? $request->copyright : null;
                $setting->cta_image = isset($request->bg_img_id_cta) ? $request->bg_img_id_cta : null;
                $setting->cta_title = isset($request->cta_title) ? $request->cta_title : null;
                $setting->cta_btn_url = isset($request->cta_btn_url) ? $request->cta_btn_url : null;
                $setting->cta_btn_name = isset($request->cta_btn_name) ? $request->cta_btn_name : null;
                $setting->cta_description = isset($request->cta_description) ? $request->cta_description : null;
            $setting->save();
            return redirect()->route('setting.index')->with('success','General Setting Saved Successfully.');
        }

    }
    public function email_setting()
    {
        $email = EmailSetting::first();
        if(isset($email) && $email != '' && $email != null)
        {
            return view('settings.email_index', compact('email'));
        }else{
            return view('settings.email_index');
        }
        
    }
    public function email_setting_save(Request $request)
    {
        $id = $request->emailsetting_id;
        $data['transport'] = isset($request->mail_driver) ? $request->mail_driver : null;
        $data['host'] = isset($request->mail_host) ? $request->mail_host : null;
        $data['port'] = isset($request->mail_port) ? $request->mail_port : null;
        $data['encryption'] = isset($request->mail_encryption) ? $request->mail_encryption : null;
        $data['username'] = isset($request->mail_username) ? $request->mail_username : null;
        $data['password'] = isset($request->mail_password) ? $request->mail_password : null;
        $data['from_address'] = isset($request->mail_from) ? $request->mail_from : null;
        $data['from_name'] = isset($request->mail_from_name) ? $request->mail_from_name : null;
        
        if (isset($id) && $id != '') {
            $email_seting = EmailSetting::findOrFail($id);
            $edata = json_encode($email_seting);
            if(isset($email_seting))
            {
                $save = EmailSetting::where('id', $id)->update($data);
                $edt = Updatelog::create(['tablename'=>'email-setting','table_primary_id'=>$email_seting->id,'edit_log'=>$edata]);
                $email_seting->update();
                return redirect()->route('setting.email.index')->with('success','E-Mail Setting Updated Successfully.');
            }else{
                return redirect()->route('setting.email.index')->with('success','E-Mail Setting Update Failed!');
            }
            
        }else{
            $data['created_at'] = Carbon::now();
            $save = EmailSetting::insert($data);
            return redirect()->route('setting.email.index')->with('success','E-Mail Setting Saved Successfully.');
        }
        
    }

    public function homepage_setting_view()
    {
        $home = HomePageSetting::orderBy('order', 'asc')->get();
        return view('settings.homepagesetting',compact('home'));
    }

    public function update_sec_status(Request $request)
    {
        // dd($request->all());
         $id = $request->id;
        $response['status'] = 0;
        $response['message'] = "Check Featured canceled";
      

        if (isset($request->isChecked) && $request->isChecked != 'true') {
            $data['checked'] = 0;
            $save = HomePageSetting::where('id', $id)->update($data);
            $response['status'] = 1;
            $response['message'] = "Section Disable Successfully";

        } else {
            $data['checked'] = 1;
            $save = HomePageSetting::where('id', $id)->update($data);
            $response['status'] = 2;
            $response['message'] = "Section Enable Successfully";

        }
        return response()->json($response);
    }

    public function update_sec_status_title(Request $request)
    {
        // dd($request->all());
         $id = $request->id;
        $response['status'] = 0;
        $response['message'] = "Check Featured canceled";
      

        if (isset($request->isChecked) && $request->isChecked != 'true') {
            $data['checked_title'] = 0;
            $save = HomePageSetting::where('id', $id)->update($data);
            $response['status'] = 1;
            $response['message'] = "Section Title Disable Successfully";

        } else {
            $data['checked_title'] = 1;
            $save = HomePageSetting::where('id', $id)->update($data);
            $response['status'] = 2;
            $response['message'] = "Section Title Enable Successfully";

        }
        return response()->json($response);
    }

    public function update_sec_order(Request $request)
    {
        // dd($request->all());
        $sectionsData = $request->input('sections');
        // dd($sectionsData);
         foreach ($sectionsData as $section) {
            $sectionId = $section['id'];
            $order = $section['order'];
            HomePageSetting::where('id', $sectionId)->update(['order' => $order]);
         }
          return response()->json(['message' => 'Section order updated successfully']);
    }
    public function business_save(Request $request) 
    {
        // dd($request->all());
        $setting = BusinessSetting::first();
        $input = $request->all();
        if(isset($request->secondary_category) && $request->secondary_category != '')
        {
            $input['secondary_category'] = implode(',', $request->secondary_category);  
        }else{
            $input['secondary_category'] = null;
        }
        if(isset($request->business_nature) && $request->business_nature != '')
        {
            $input['business_nature'] = implode(',', $request->business_nature);
        }else{
            $input['business_nature'] = null;
        }
         
        $input['country_code_number'] = isset($request->country_number)  ? $request->country_number : '';

        if ($request->hasFile('business_logo')) {
            $current = Carbon::now()->format('YmdHs');
            $uploadpdf = $request->file('business_logo');
            $business_logo = $current . $uploadpdf->getClientOriginalName();
            $uploadpdf->move('uploads/images/', $business_logo);
            $input['business_logo'] = $business_logo;
        }else{
            $input['business_logo'] = $request->old_business_logo;
        }
        if ($request->hasFile('business_favicon')) {
            $current = Carbon::now()->format('YmdHs');
            $uploadpdf = $request->file('business_favicon');
            $business_favicon = $current . $uploadpdf->getClientOriginalName();
            $uploadpdf->move('uploads/images/', $business_favicon);
            $input['business_favicon'] = $business_favicon;
        }else{
            $input['business_favicon'] = $request->old_business_favicon;
        }
        if($request->monday_choose == 'open')
        {
            $monday = json_encode([
                'status' => 1,
                'from' => isset($request->monday_form)  ? $request->monday_form : '',
                'to' => isset($request->monday_to) ? $request->monday_to : '',

            ]);
        }
        if($request->tuesday_choose == 'open')
        {
            $tuesday = json_encode([
                'status' => 1,
                'from' => isset($request->tuesday_form)  ? $request->tuesday_form : '',
                'to' => isset($request->tuesday_to) ? $request->tuesday_to : '',

            ]);
        }
        if($request->wedsday_choose == 'open')
        {
            $wednesday = json_encode([
                'status' => 1,
                'from' => isset($request->wed_form)  ? $request->wed_form : '',
                'to' => isset($request->wed_to) ? $request->wed_to : '',

            ]);
        }
        if($request->thursday_choose == 'open')
        {
            $thursday = json_encode([
                'status' => 1,
                'from' => isset($request->thur_form)  ? $request->thur_form : '',
                'to' => isset($request->thur_to) ? $request->thur_to : '',

            ]);
        }
        if($request->friday_choose == 'open')
        {
            $friday = json_encode([
                'status' => 1,
                'from' => isset($request->friday_form) ? $request->friday_form : '',
                'to' => isset($request->friday_to) ? $request->friday_to : '',

            ]);
        }
        if($request->sat_choose == 'open')
        {
            $saturday = json_encode([
                'status' => 1,
                'from' => isset($request->sat_form) ? $request->sat_form : '',
                'to' => isset($request->sat_to) ? $request->sat_to : '',

            ]);
        }
        if($request->sun_choose == 'open')
        {
            $sunday = json_encode([
                'status' => 1,
                'from' => isset($request->sunday_form) ? $request->sunday_form : '',
                'to' => isset($request->sunday_to) ? $request->sunday_to : '',

            ]);
        }
        $buyIcons = [];
        if(isset($request->buy_title) && count($request->buy_title) > 0)
        {
            foreach($request->buy_title as $key =>$buy_img)
            {
                if (array_key_exists($key, $request->file('buy_icon') ?? [])) {
                    $current = Carbon::now()->format('YmdHs');
                    $uploadpdf = $request->file('buy_icon')[$key];
                    $extension = $uploadpdf->getClientOriginalExtension();
                    $filename = $current . '_' . $key . '.' . $extension;
                    $uploadpdf->move('uploads/images/', $filename);
                }else{
                    $filename = isset($request->old_buy_icon[$key]) ? $request->old_buy_icon[$key] : '';
                }
                    $buyIcon = [
                        'title' => isset($request->buy_title[$key]) ? $request->buy_title[$key] : '',
                        'icon' => isset($filename) ? $filename : '',
                    ];
                    $buyIcons[] = $buyIcon;
            }
            $icon_json = json_encode($buyIcons);
        }
        // dd($icon_json);
        $input['monday'] = isset($monday) ? $monday : 'closed';
        $input['tuesday'] = isset($tuesday) ? $tuesday : 'closed';
        $input['wedsday'] = isset($wednesday) ? $wednesday : 'closed';
        $input['thursday'] = isset($thursday) ? $thursday : 'closed';
        $input['friday'] = isset($friday) ? $friday : 'closed';
        $input['sat'] = isset($saturday) ? $saturday : 'closed';
        $input['sun'] = isset($sunday) ? $sunday : 'closed';
        $input['defalt_color'] = isset($request->default_color) && $request->default_color == 'on' ? 1 : 0;
        $input['buy_icons'] = isset($icon_json) ? $icon_json : null;
        $setting->update($input);
        return redirect()->route('business.setting.index')->with('success','Business Setting Saved Successfully.');
    }

    public function comment_index()
    {
        $comments = CommentSetting::first();
        return view('settings.commentsetting', compact('comments'));
    }
    public function comment_save(Request $request)
    {
        $comment = CommentSetting::first();
        $edata = json_encode($comment);
        if(isset($request->comment_id) && $request->comment_id != '' && $request->comment_id != null)
        {
           $comment->show_comments = isset($request->show_comments) && $request->show_comments == 'on' ? 1 : 0;
           $comment->comment_details = isset($request->comment_details) && $request->comment_details == 'on' ? 1 : 0;
           $comment->save();
           $edt = Updatelog::create(['tablename'=>'comment-setting','table_primary_id'=>$comment->id,'edit_log'=>$edata]);
           return redirect()->route('comment.index')->with('success','Comment Setting Saved Successfully.');
        }
        else{
            return redirect()->route('comment.index')->with('error','Error in Saving Comment Setting!');
        }
    }

    public function payment()
    {
        $setting = Setting::first();
        return view('settings.payment',compact('setting'));
    }
    public function payment_save(Request $request)
    {
        $setting = Setting::first();
        $setting->payment_g  = isset($request->payment_g) ? $request->payment_g : null;
        $setting->cod  = isset($request->cod) ? $request->cod : null;
        $setting->ccod  = isset($request->ccod) ? $request->ccod : null;
        $setting->save();
        return redirect()->route('settings.payment-option')->with('success','Payment Settings saved successfully!');
    }
    public function registration_index()
    {
        $rs = RegistrationFormSetting::get();
        return view('settings.registration_index',compact('rs'));
    }
    public function registration_update(Request $request)
    {
        if(isset($request->id) && $request->id != null && $request->id != '')
        {
            $rs = RegistrationFormSetting::findOrfail($request->id);
            if(isset($request->isChecked) && $request->isChecked != null && $request->isChecked == "true")
            {
                if(isset($request->type) && $request->type != null && $request->type == 'display')
                {
                    $rs->display = 1; 
                    $lable = 'Display/Hide';
                }else{
                    $rs->mandatory = 1;
                    $lable = 'Mandatory/Optional';
                }
            }else{
                if(isset($request->type) && $request->type != null && $request->type == 'display')
                {
                    $rs->display = 0; 
                    $rs->mandatory = 0;
                    $lable = 'Display/Hide';
                }else{
                    $rs->mandatory = 0;
                    $lable = 'Mandatory/Optional';
                }
            }
            $rs->save();
            $message = 'Field '.$lable.' Status updated successfully';
            return response()->json(['status' => 1, 'message' => $message]);
        }else{
            return response()->json(['status' => 0, 'message' => 'Something Went Wrong!']);
        }
    }
}
