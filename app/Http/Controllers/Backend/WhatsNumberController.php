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
use App\Models\WhatsNumber;




class WhatsNumberController extends Controller
{
    public function index()
    {
        $phone_number = WhatsNumber::findOrfail('1');
        return view('whatsNumber.index')->with(compact('phone_number'));
    }

    public function save(Request $request)
    {
        $id = $request->number_id;

        if ($id != '') {
            $phone_number = WhatsNumber::findOrfail($id);
         
            $phone_number->number = $request->number;
            $phone_number->country_code = $request->country_code;

            
            $phone_number->update();
            return redirect()->route('whatsNumber.index')->with('success', 'Number successfully Update.');
        } else {
          
            $phone_number = new WhatsNumber();
            $phone_number->number = $request->number;
             $phone_number->country_code = $request->country_code;
            $phone_number->save();

            return redirect()->route('whatsNumber.index')->with('success', 'Number successfully Submit.');
        }

    }

   
    public function list()
    {
        $number_list = WhatsNumber::get();

        $counter = 1;
        $number_list->transform(function ($item) use (&$counter) {

            $item['ser_id'] = $counter++;
     
            return $item;
        });

        return response()->json(['data' => $number_list]);
    }

   
}