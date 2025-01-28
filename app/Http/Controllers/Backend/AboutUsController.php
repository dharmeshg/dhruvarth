<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AboutUsSetting;
use App\Models\Country;
use App\Models\Setting;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use DateTime;

class AboutUsController extends Controller
{
    public function about_index()
    {
        $about = AboutUsSetting::first();
        $data = json_decode($about->data);
        return view('pagesetting.aboutus_index', compact('about','data'));
    }
   
    public function about_save(Request $request)
    {
        // dd($request->all());
        if(isset($request->title) && $request->title != '' && $request->title != null)
        {
            foreach ($request->title as $key => $value) {
                if (array_key_exists($key, $request->file('image') ?? [])) {
                    $current = Carbon::now()->format('YmdHs');
                    $uploadpdf = $request->file('image')[$key];
                    $extension = $uploadpdf->getClientOriginalExtension();
                    $filename = $current . '_' . $key . '.' . $extension;
                    $uploadpdf->move('uploads/images/', $filename);
                }else{
                    $filename = isset($request->old_image[$key]) ? $request->old_image[$key] : '';
                }
                $buyIcon = [
                    'title' => isset($request->title[$key]) ? $request->title[$key] : '',
                    'description' => isset($request->description[$key]) ? $request->description[$key] : '',
                    'youtube_video' => isset($request->youtube_video[$key]) ? $request->youtube_video[$key] : '',
                    'image' => isset($filename) ? $filename : '',
                ];
                $buyIcons[] = $buyIcon;
            }
            $icon_json = json_encode($buyIcons);
        } 
        $about = AboutUsSetting::first();
        $about->data = isset($icon_json) ? $icon_json : null;
        $about->save();

        return redirect()->route('pagesetting.about_index')->with('success', 'About Us Setting Saved Successfully');
    }

    public function taxes_view()
    {
        $countries = Country::all();
        $setting = Setting::first();
        return view ('settings.taxes_index',compact('countries','setting'));
    }
    public function taxes_save(Request $request)
    {
        if($request->p_tax_contry && $request->p_tax_contry != '' && $request->p_tax_contry != null)
        {
            foreach($request->p_tax_contry as $key => $item)
            {
                $contry_data[] = [
                    "p_tax_contry" => isset($item) ? $item : '',
                    "p_int_tax" => isset($request->p_int_tax[$key]) ? $request->p_int_tax[$key] : '',
                    "p_int_above" => isset($request->p_int_above[$key]) ? $request->p_int_above[$key] : '',
                ];
            }
            $contry_json = json_encode($contry_data);
        }
        $setting = Setting::first();
        $setting->national_tax = isset($request->p_national_tax) ? $request->p_national_tax : null;
        $setting->nation_above_amount = isset($request->p_above_amount) ? $request->p_above_amount : null;
        $setting->taxes = isset($contry_json) ? $contry_json : null;
        $setting->save();
        return redirect()->route('setting.taxes')->with('success','Taxes Saved Successfully.');
    }
}
