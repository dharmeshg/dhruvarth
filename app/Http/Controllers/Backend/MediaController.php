<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MediaSection;
use App\Models\HomePageSetting;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class MediaController extends Controller
{
    public function index()
    {
        // $images = MediaImage::orderBy('id', 'desc')->with('creator')->get();
        return view('media.index');
    }
    public function section($sec)
    {
        $title = '';
        if($sec == 'ads-poster')
        {
            $title = 'Poster Section';
        }
        if($sec == 'logo-slider')
        {
            $title = 'Logo Slider Section';
        }
        if($sec == 'pdf-list')
        {
            $title = 'PDF Section';
        }
        if($sec == 'page-banner')
        {
            $title = 'Page Banner Section';
        }
        $sections = MediaSection::where('type',$sec)->latest()->get();

        return view('media.section',compact('title','sec','sections'));
    }
    public function section_store(Request $request)
    {
        // dd($request->all());
        if(isset($request->sec_id) && $request->sec_id != '' && $request->sec_id != null)
        {
            $section = MediaSection::findOrfail($request->sec_id);
        }else{
            $section = new MediaSection();
        }
        if ($request->hasFile('sec_image')) {
            $current = Carbon::now()->format('YmdHs');
            $uploadpdf = $request->file('sec_image');
            $image_m = $current . $uploadpdf->getClientOriginalName();
            $uploadpdf->move('uploads/media/', $image_m);
            $imageName_m = $image_m;
        }else{
            $imageName_m = $request->sec_old_img;
        }
        $section->type = isset($request->type) ? $request->type : null;
        $section->title = isset($request->title) ? $request->title : null;
        $section->image = isset($imageName_m) ? $imageName_m : null;
        $section->save();
        $section_id = $section->id;
        $home_sec = HomePageSetting::where('section_id', '!=', null)->where('section_id',$section_id)->first();
        if(isset($home_sec) && $home_sec != null && $home_sec != '')
        {
           $home_sec->title =  isset($request->title) ? $request->title : null;
           $home_sec->type = isset($request->type) ? $request->type : null;
           $home_sec->save();
        }else{
            $home_sec = new HomePageSetting();
            $home_sec->title =  isset($request->title) ? $request->title : null;
            $home_sec->type = isset($request->type) ? $request->type : null;
            $home_sec->section_id = isset($section_id) ? $section_id : null;
            $home_sec->save();
        }

        return response()->json(['status' => 1, 'message' => 'Section Saved Successfully!']);
    }

    public function get_section(Request $request)
    {
        // dd($request->all());
        $section = MediaSection::findOrfail($request->id);
        $data = [];
        if(isset($section) && $section != '' && $section != null)
        {
            $data = $section;
            if(isset($section->image) && $section->image != '' && $section->image != null)
            {
                $data['url'] = asset('uploads/media/'.$section->image);
            }else{
                $data['url'] = asset('assets/images/user/img-demo_1041.jpg');
            }
            return response()->json(['status' => 1, 'data' => $data]);

        }else{
            return response()->json(['status' => 0, 'message' => 'Something Went Wrong!']);
        }
    }

    public function del_section(Request $request)
    {
        $section = MediaSection::findOrfail($request->id);
        if(isset($section) && $section != '' && $section != null)
        {
            $home = HomePageSetting::where('section_id',$section->id)->first();
            if(isset($home) && $home != null && $home != '')
            {
                $home->delete();
            }
            $section->delete();
            return response()->json(['status' => 1, 'message' => 'Section Deleted Successfully!']);

        }else{
            return response()->json(['status' => 0, 'message' => 'Something Went Wrong!']);
        }
    }
}
