<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Redirect;
use Illuminate\Support\Str;
use App\Models\SocialLink;




class SocialLinkController extends Controller
{
    public function index()
    {
        $link = SocialLink::get();
        return view('socialLink.index')->with(compact('link'));
    }

    public function save(Request $request)
    {
        // $id = $request->link_id;

        // if ($id != '') {

            if (isset($request->website_url)) {
                $social_link = SocialLink::findOrfail('1');
                $social_link->url = $request->website_url;
                $social_link->update();
            }
            if (isset($request->facebook)) {
                $social_link = SocialLink::findOrfail('2');
                $social_link->url = $request->facebook;
                $social_link->update();
            }
            if (isset($request->linkedin)) {
                $social_link = SocialLink::findOrfail('3');
                $social_link->url = $request->linkedin;
                $social_link->update();
            }
            if (isset($request->pinterest)) {
                $social_link = SocialLink::findOrfail('4');
                $social_link->url = $request->pinterest;
                $social_link->update();
            }
            if (isset($request->twitter)) {
                $social_link = SocialLink::findOrfail('5');
                $social_link->url = $request->twitter;
                $social_link->update();
            }
             if (isset($request->instagram)) {
                $social_link = SocialLink::findOrfail('6');
                $social_link->url = $request->instagram;
                $social_link->update();
            }
             if (isset($request->youtube)) {
                $social_link = SocialLink::findOrfail('7');
                $social_link->url = $request->youtube;
                $social_link->update();
            }
            
            
            return redirect()->route('socialLink.index')->with('success', 'Social Link successfully Update.');
        // } else {
          
        //     $social_link = new SocialLink();
        //      $social_link->website_url = $request->website_url;
        //     $social_link->facebook = $request->facebook;
        //     $social_link->linkedin = $request->linkedin;
        //     $social_link->pinterest = $request->pinterest;
        //     $social_link->twitter = $request->twitter;
        //     $social_link->instagram = $request->instagram;
        //     $social_link->youtube_url = $request->youtube;
        //     $social_link->save();

        //     return redirect()->route('socialLink.index')->with('success', 'Social Link successfully Submit.');
        // }

    }

   
    public function list()
    {
        $youtube_list = SocialLink::get();

        $counter = 1;
        $youtube_list->transform(function ($item) use (&$counter) {

            $item['ser_id'] = $counter++;
     
            return $item;
        });

        return response()->json(['data' => $youtube_list]);
    }

   
}