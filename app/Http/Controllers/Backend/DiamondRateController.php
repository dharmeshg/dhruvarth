<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DiamondRate;
use App\Models\DynamicDiamondType;
use DateTime;
use Carbon\Carbon;

class DiamondRateController extends Controller
{
    public function index()
    {

        $types = DynamicDiamondType::get();
        return view('diamondrate.index',compact('types'));
    }
    public function list()
    {
        $rates = DiamondRate::with('type')->latest()->get();

        $counter = 1;
        $rates->transform(function ($item) use (&$counter) {
            $item['ser_id'] = $counter++;


            
            if (isset($item['updated_at']) && $item['updated_at'] != '') {
                $dateTime = new DateTime($item['updated_at']);
                $formattedDate = $dateTime->format('d-m-Y | h:iA');
                $item['date'] = $formattedDate; 
            }else{
                $item['date'] = "-";
            }
            $item['rate'] = number_format($item['rate'], 2, '.', ',');

            if ($item['status'] == '1') {
                $item['status'] = '<input type="checkbox" data-id="' . $item['id'] . '" data-toggle="toggle" id="is_status"  checked class="is_featured_class">';
            } else {
                $item['status'] = '<input type="checkbox" data-id="' . $item['id'] . '" data-toggle="toggle" id="is_status"  class="is_featured_class">';
            }
            
            $item['action'] = '<a href="javascript:;" class="table-btn table-btn1 mx-2 edit" data-id="' . $item['id'] . '" title="Click here to Edit Diamond Rate"><img src="'.asset('images/dashbord/create.png').'" class="image-fuild" alt="user-img"></a>';

            $item['action'] .= '<a href="javascript:;" data-id="' . $item['id'] . '" data-title="testrete" data-original-title="Delete Diamond Rate" class="table-btn table-btn1 delete" title="Click here to Delete Diamond Rate"><img src="'.asset('images/dashbord/delete.png').'" class="image-fuild" alt="user-img"></a>';

            return $item;
        });

        return response()->json(['data' => $rates]);
    }

    public function save(Request $request)
    {
        // dd($request->all());
        if(isset($request->rate_id) && $request->rate_id != '' && $request->rate_id != null)
        {
            $rate = DiamondRate::findOrfail($request->rate_id);
        }else{
            $rate = new DiamondRate();
            $rate->status = '1';
        }
        $rate->type = isset($request->type) ? $request->type : null;
        $rate->quality = isset($request->quality) ? $request->quality : null;
        $rate->rate = isset($request->rate) ? $request->rate : null;
        $rate->save();
        $response['status'] = 1;
        $response['message'] = "Diamond Rate Saved Successfully.";
        return response()->json($response);
    }
    public function edit(Request $request)
    {
        $id = $request->id;
        if ($id) {
            $data = DiamondRate::where('id', $id)->first();
            return json_encode($data);
        }
    }

    public function delete(Request $request)
    {
        $response['status'] = 0;
        $response['message'] = "Something Went Wrong!";
        if(isset($request->id) && $request->id != '' && $request->id != null)
        {
            $rate = DiamondRate::findOrfail($request->id);
            $rate->delete();
            $response['status'] = 1;
            $response['message'] = "Diamond Rate Deleted Successfully!";
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
            $save = DiamondRate::where('id', $id)->update($data);
            $response['status'] = 1;
            $response['message'] = "Disable Successfully";

        } else {
            $data['status'] = 1;
            $save = DiamondRate::where('id', $id)->update($data);
            $response['status'] = 1;
            $response['message'] = "Enable Successfully";

        }
        return response()->json($response);
    }
    public function search_diamond(Request $request)
    {
        // dd($request->all());

        if ($request->search_text != "") {
            $metal_purity = DynamicDiamondType::select('id')->where('name', 'LIKE', '%' . $request->search_text . '%')->get();
        }else{
            $metal_purity = DynamicDiamondType::select('id')->get();
        }


        $query = DiamondRate::whereIn('type', $metal_purity)->with('type');

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


            $item['ser_id'] = $counter++;

            
            if (isset($item['updated_at']) && $item['updated_at'] != '') {
                $dateTime = new DateTime($item['updated_at']);
                $formattedDate = $dateTime->format('d-m-Y | h:iA');
                $item['date'] = $formattedDate; 
            }else{
                $item['date'] = "-";
            }
            $item['rate'] = number_format($item['rate'], 2, '.', ',');

            if ($item['status'] == '1') {
                $item['status'] = '<input type="checkbox" data-id="' . $item['id'] . '" data-toggle="toggle" id="is_status"  checked class="is_featured_class">';
            } else {
                $item['status'] = '<input type="checkbox" data-id="' . $item['id'] . '" data-toggle="toggle" id="is_status"  class="is_featured_class">';
            }
            
            $item['action'] = '<a href="javascript:;" class=" table-btn table-btn1 mx-2 edit" data-id="' . $item['id'] . '" title="Click here to Edit Diamond Rate"><img src="'.asset('images/dashbord/create.png').'" class="image-fuild" alt="user-img"></a>';
            $item['action'] .= '<a href="javascript:;" data-id="' . $item['id'] . '" data-title="testrete" data-original-title="Delete Metal Rate" class="table-btn table-btn1 delete" title="Click here to Delete Diamond Rate"><img src="'.asset('images/dashbord/delete.png').'" class="image-fuild" alt="user-img"></a>';
            return $item;
        });

        return response()->json(['data' => $rates]);
    }

}
