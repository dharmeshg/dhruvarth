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
use App\Models\DirectionLink;




class DirectionLinkController extends Controller
{
    public function index()
    {
        $direction_link = DirectionLink::findOrfail('1');
        return view('direction_link.index')->with(compact('direction_link'));
    }

    public function save(Request $request)
    {
        $id = $request->direction_link_id;

        // if ($id != '') {
            $direction_link = DirectionLink::findOrfail($id);
         
            $direction_link->link = $request->link;
            
            $direction_link->update();
            return redirect()->route('direction_link.index')->with('success', 'Direction Link successfully Update.');
        // } else {
          
        //     $direction_link = new DirectionLink();
        //     $direction_link->link = $request->link;
        //     $direction_link->save();

        //     return redirect()->route('direction_link.index')->with('success', 'Direction Link successfully Submit.');
        // }

    }

   
    public function list()
    {
        $direction_link_list = DirectionLink::get();

        $counter = 1;
        $direction_link_list->transform(function ($item) use (&$counter) {

            $item['ser_id'] = $counter++;
     
            return $item;
        });

        return response()->json(['data' => $direction_link_list]);
    }

   
}