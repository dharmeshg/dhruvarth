<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MetalRate;
use App\Models\MetalPurity;
use DateTime;
use Carbon\Carbon;

class MetalRateController extends Controller
{
    public function index()
    {

        $purities = MetalPurity::get();
        return view('metalrate.index',compact('purities'));
    }
    public function list()
    {
        $rates = MetalRate::with('metal_purity')->latest()->get();

        $counter = 1;
        $rates->transform(function ($item) use (&$counter) {
            // $item['ser_id'] = $counter++;

            $item['ser_id'] = '<div class="custom-control custom-checkbox">
            <input type="checkbox" class="pinned_chekbox" id="is_featured" data-id="' . $item['id'] . '"';

            if ($item['pinned'] == 1) {
                $item['ser_id'] .= ' checked';
            }


            $item['ser_id'] .= '></div>';
            $item['rate'] = number_format($item['rate'], 2, '.', ',');
            
            if (isset($item['updated_at']) && $item['updated_at'] != '') {
                $dateTime = new DateTime($item['updated_at']);
                $formattedDate = $dateTime->format('d-m-Y | h:iA');
                $item['date'] = $formattedDate; 
            }else{
                $item['date'] = "-";
            }

            if ($item['status'] == '1') {
                $item['status'] = '<input type="checkbox" data-id="' . $item['id'] . '" data-toggle="toggle" id="is_status"  checked class="is_featured_class">';
            } else {
                $item['status'] = '<input type="checkbox" data-id="' . $item['id'] . '" data-toggle="toggle" id="is_status"  class="is_featured_class">';
            }
            
            $item['action'] = '<a href="javascript:;" class="table-btn table-btn1 mx-2 edit" data-id="' . $item['id'] . '" title="Click here to Edit Metal Rate"><img src="'.asset('images/dashbord/create.png').'" class="image-fuild" alt="user-img"></a>';

            $item['action'] .= '<a href="javascript:;" data-id="' . $item['id'] . '" data-title="testrete" data-original-title="Delete Metal Rate" class="table-btn table-btn1 delete" title="Click here to Delete Metal Rate"><img src="'.asset('images/dashbord/delete.png').'" class="image-fuild" alt="user-img"></a>';

            return $item;
        });

        return response()->json(['data' => $rates]);
    }

    public function save(Request $request)
    {

        if(isset($request->rate_id) && $request->rate_id != '' && $request->rate_id != null)
        {
            $rate = MetalRate::findOrfail($request->rate_id);
        }else{
            $check_metal = MetalRate::where('purity',$request->purity)->first();
            if (isset($check_metal) && $check_metal != '') {
                $rate = MetalRate::findOrfail($check_metal->id);
            }else{
                $rate = new MetalRate();
                $rate->status = '1';

            }
            
        }
        $rate->purity = isset($request->purity) ? $request->purity : null;
        $rate->rate = isset($request->rate) ? $request->rate : null;

        $rate->save();
        $response['status'] = 1;
        $response['message'] = "Metal Rate Saved Successfully.";
        return response()->json($response);
    }
    public function edit(Request $request)
    {
        $id = $request->id;
        if ($id) {
            $data = MetalRate::where('id', $id)->first();
            return json_encode($data);
        }
    }

    public function delete(Request $request)
    {
        $response['status'] = 0;
        $response['message'] = "Something Went Wrong!";
        if(isset($request->id) && $request->id != '' && $request->id != null)
        {
            $rate = MetalRate::findOrfail($request->id);
            $rate->delete();
            $response['status'] = 1;
            $response['message'] = "Metal Rate Deleted Successfully!";
        }
        return response()->json($response);
    }

    public function pinned_status(Request $request)
    {
        $all = MetalRate::where('pinned',1)->get()->count();
        // dd($all);

        $id = $request->id;
        $response['pinned'] = 0;
        $response['message'] = "Pinned canceled";
        

        if (isset($request->isChecked) && $request->isChecked != 'true') {
            $data['pinned'] = 0;
            $save = MetalRate::where('id', $id)->update($data);
            $response['pinned'] = 1;
            $response['message'] = "Metal Rate Unpinned Successfully";

        } else {
            if(isset($all) && $all == 2)
            {
                return response()->json(['pinned' => 3, 'message' => 'Only Two Metal Rate Can be Pinned!']);
            }else{
                $data['pinned'] = 1;
                $save = MetalRate::where('id', $id)->update($data);
                $response['pinned'] = 2;
                $response['message'] = "Metal Rate Pinned Successfully";
            }

        }
        return response()->json($response);
    }

    public function is_status(Request $request)
    {
       

        $id = $request->id;
        $response['status'] = 0;
        $response['message'] = "Status canceled";
        

        if (isset($request->isChecked) && $request->isChecked != 'true') {
            $data['status'] = 0;
            $save = MetalRate::where('id', $id)->update($data);
            $response['status'] = 1;
            $response['message'] = "Disable Successfully";

        } else {
            $data['status'] = 1;
            $save = MetalRate::where('id', $id)->update($data);
            $response['status'] = 1;
            $response['message'] = "Enable Successfully";

        }
        return response()->json($response);
    }
    public function search_metal(Request $request)
    {
        // dd($request->all());

        if ($request->search_text != "") {
            $metal_purity = MetalPurity::select('id')->where('title', 'LIKE', '%' . $request->search_text . '%')->get();
        }else{
            $metal_purity = MetalPurity::select('id')->get();
        }


        $query = MetalRate::whereIn('purity', $metal_purity)->with('metal_purity');

        if ($request->from_date != "") {
             $from_date = Carbon::createFromFormat('m/d/Y', $request->from_date)->startOfDay();
             $query->where('updated_at', '>=',$from_date);

        }

        if ($request->to_date != "") {
            $to_date = Carbon::createFromFormat('m/d/Y', $request->to_date)->endOfDay();
             $query->where('updated_at', '<=', $to_date);
        }

       $rates =  $query->latest()->get();



        // $metal_purity = MetalPurity::select('id')->where('title', 'LIKE', '%' . $request->search_text . '%')->get();
        // $rates = MetalRate::whereIn('purity', $metal_purity)->with('metal_purity')
        // ->whereBetween('updated_at', [Carbon::createFromFormat('m/d/Y', $request->from_date)->startOfDay(), Carbon::createFromFormat('m/d/Y', $request->to_date)->endOfDay()])
        // ->latest()->get();



        $counter = 1;
        $rates->transform(function ($item) use (&$counter) {


            $item['ser_id'] = '<div class="custom-control custom-checkbox">
            <input type="checkbox" class="pinned_chekbox" id="is_featured" data-id="' . $item['id'] . '"';

            if ($item['pinned'] == 1) {
                $item['ser_id'] .= ' checked';
            }


            $item['ser_id'] .= '></div>';

            
            if (isset($item['updated_at']) && $item['updated_at'] != '') {
                $dateTime = new DateTime($item['updated_at']);
                $formattedDate = $dateTime->format('d-m-Y | h:iA');
                $item['date'] = $formattedDate; 
            }else{
                $item['date'] = "-";
            }

            if ($item['status'] == '1') {
                $item['status'] = '<input type="checkbox" data-id="' . $item['id'] . '" data-toggle="toggle" id="is_status"  checked class="is_featured_class">';
            } else {
                $item['status'] = '<input type="checkbox" data-id="' . $item['id'] . '" data-toggle="toggle" id="is_status"  class="is_featured_class">';
            }
            
            $item['action'] = '<a href="javascript:;" class=" table-btn table-btn1 mx-2 edit" data-id="' . $item['id'] . '" title="Click here to Edit Metal Rate"><img src="'.asset('images/dashbord/create.png').'" class="image-fuild" alt="user-img"></a>';
            $item['action'] .= '<a href="javascript:;" data-id="' . $item['id'] . '" title="Click here to Delete Metal Rate" data-title="testrete" data-original-title="Delete Metal Rate" class="table-btn table-btn1 delete"><img src="'.asset('images/dashbord/delete.png').'" class="image-fuild" alt="user-img"></a>';
            return $item;
        });

        return response()->json(['data' => $rates]);
    }

}
