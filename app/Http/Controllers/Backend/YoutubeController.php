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
use App\Models\Youtube;




class YoutubeController extends Controller
{
    public function index()
    {
        $youtube = Youtube::findOrfail('1');
        return view('youtube.index')->with(compact('youtube'));
    }

    public function save(Request $request)
    {
        $id = $request->youtube_id;

        if ($id != '') {
            $phone_number = Youtube::findOrfail($id);
         
            $phone_number->url = $request->videoUrl;

            
            $phone_number->update();
            return redirect()->route('youtube.index')->with('success', 'Youtube successfully Update.');
        } else {
          
            $phone_number = new Youtube();
            $phone_number->url = $request->videoUrl;
            $phone_number->save();

            return redirect()->route('youtube.index')->with('success', 'Youtube successfully Submit.');
        }

    }

   
    public function list()
    {
        $youtube_list = Youtube::get();

        $counter = 1;
        $youtube_list->transform(function ($item) use (&$counter) {

            $item['ser_id'] = $counter++;
     
            return $item;
        });

        return response()->json(['data' => $youtube_list]);
    }

   
}