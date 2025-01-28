<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\ContactUsSetting;

class ContacUsController extends Controller
{
    public function contact_index()
    {
        $setting = ContactUsSetting::first();
        $countries = Country::all();
        $alt_numbers = json_decode($setting->phone_numbers);
        $alt_w_numbers = json_decode($setting->w_numbers);
        return view('pagesetting.contactus_index',compact('setting','countries','alt_numbers','alt_w_numbers'));
    }
    public function contact_save(Request $request)
    {
        // dd($request->all());
        $setting = ContactUsSetting::first();
        $input = $request->all();
        $whatsapp_data = [];
        $phone_data = [];
        if(isset($request->whatsapp_no) && count($request->whatsapp_no) > 0)
        {
            for ($i = 0; $i < count($request->whatsapp_no); $i++) {
                $whatsapp_data[] = [
                    'code' => isset($request['alt_country_code'][$i]) ? $request['alt_country_code'][$i] : '',
                    'number' => $request->whatsapp_no[$i],

                ];
            }
            $n_json = json_encode($whatsapp_data);
        }
        if(isset($request->phone_no) && count($request->phone_no) > 0)
        {
            for ($i = 0; $i < count($request->phone_no); $i++) {
                $phone_data[] = [
                    'code' => isset($request['alt_country_code'][$i]) ? $request['alt_country_code'][$i] : '',
                    'number' => $request->phone_no[$i],

                ];
            }
            $p_json = json_encode($phone_data);
        }
        // if(isset($request['alt_number']) && $request['alt_number'] != null && $request['alt_number'] != '')
        // {
          
        //     for ($i = 0; $i < count($request['alt_number']); $i++) {
        //         $number_data[] = [
        //             'code' => $request['alt_country_code'][$i],
        //             'number' => $request['alt_number'][$i],
        //             'coun_number' => $request['alt_country_number'][$i],

        //         ];
        //     }
        //     $n_json = json_encode($number_data);
        // }
        if(isset($request['alt_email']) && $request['alt_email'] != null && $request['alt_email'] != '')
        {
            $e_string = implode(',', $request['alt_email']);
        }
        $input['status'] = isset($request->status) && $request->status == 'on' ? 1 : 0 ;
        $input['w_numbers'] = isset($n_json) ? $n_json : null ;
        $input['phone_numbers'] = isset($p_json) ? $p_json : null ;
        $input['alt_email'] = isset($e_string) ? $e_string : null ;
        $input['country_number'] = isset($request->country_number) ? $request->country_number : null ;

        $setting->update($input);

        return redirect()->route('pagesetting.contact_index')->with('success','Contact Page Setting Saved Successfully.');
    }
}
