<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\DailyStatus;
use Carbon\Carbon;
use File;
use DateTime;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class DailyStatusController extends Controller
{
    public function index()
    {
        $data = DailyStatus::first();
        return view('dailystatus.index',compact('data'));
    }
    public function add()
    {
        return view('dailystatus.add');
    }
    public function save(Request $request)
    {
        // dd($request->all());
        if ($request->hasFile('image')) {
            $current = Carbon::now()->format('YmdHs');
            $uploadpdf = $request->file('image');
            $image = $current . $uploadpdf->getClientOriginalName();
            $uploadpdf->move('uploads/daily_updates/', $image);
            $imageName = $image;

            $manager = new ImageManager(new Driver());
            $image = $manager->read(base_path('/public/uploads/daily_updates/').$imageName);

            $image = $image->resize(300,300);
            $image->save(base_path('/public/uploads/daily_updates/thumb/'.$imageName));
        }else{

            $imageName = $request->old_img;
        }

        if(isset($request->status_id) && $request->status_id != null && $request->status_id != '')
        {
            $updates = DailyStatus::findOrfail($request->status_id);
        }else{
            $updates = new DailyStatus();
        }
        $updates->image = isset($imageName) ? $imageName : null;
        $updates->destination_link = isset($request->destination_link) ? $request->destination_link : null;
        $updates->status = isset($request->is_featured) && $request->is_featured == 'on' ? 1 : 0;
        $updates->notification_message = isset($request->notification_message) ? $request->notification_message : null;
        $updates->display = isset($request->display) ? $request->display : null;
        $updates->save();
        return redirect()->route('daliystatus.index')->with('success', 'Daily Status Saved Successfully!');
    }

    public function list()
    {
        $dailyStatus_list = DailyStatus::get();

        $counter = 1;
        $dailyStatus_list->transform(function ($item) use (&$counter) {
            $item['ser_id'] = $counter++;

            if (isset($item['image']) && $item['image'] != '') {
                $item['image'] = '<img src="' . asset('uploads/daily_updates/' . $item['image']) . '" class="img-fluid white_logo rounded-circle" alt="" style="width:50px;height:50px;" >';
            } else {
                $item['image'] = '<img src="' . asset('assets/img/new-profile.svg') . '" class="img-fluid white_logo rounded-circle" alt="" style="width:50px;height:50px;">';
            }

            if (isset($item['updated_at']) && $item['updated_at'] != '') {
                $dateTime = new DateTime($item['updated_at']);
                $formattedDate = $dateTime->format('d-m-Y | h:iA');
                $item['date'] = $formattedDate; 
            }else{
                $item['date'] = "-";
            }

            $item['action'] = '<a class="table-btn table-btn1 mx-2 daliy_status_edit" data-id="' . $item['id'] . '" href="' . route('daliystatus.edit', $item['id']) . '" title="Click here to Edit Daily Status"><img src="'.asset('images/dashbord/create.png').'" class="image-fuild" alt="user-img"></a>';


            $item['action'] .= '<a data-href="' . route('daliystatus.delete', $item['id']) . '" data-title="testrete" data-original-title="Delete Tags" class="daliy_status_delete table-btn table-btn1 delete" title="Click here to Delete Daily Status"><img src="'.asset('images/dashbord/delete.png').'" class="image-fuild" alt="user-img"></a>';


            if ($item['status'] == '1') {
                $item['status'] = '<input type="checkbox" class="is_featured_class" data-id="' . $item['id'] . '"  id="is_featured" name="is_featured" checked>';
            } else {
                $item['status'] = '<input type="checkbox" class="is_featured_class" data-id="' . $item['id'] . '" id="is_featured" name="is_featured">';
            }

            return $item;
        });

        return response()->json(['data' => $dailyStatus_list]);
    }

    public function edit($id)
    {
        $data = DailyStatus::findOrFail($id);
        return view('dailystatus.add',compact('data'));
    }

    public function delete($id)
    {
           if ($id != "") {
                $record = DailyStatus::find($id);

                $record->delete();
                return redirect()->route('daliystatus.index')
                ->withSuccess('Daliy Status Delete Successfully.');

            }
    }

    public function check_featured(Request $request)
    {
           $id = $request->id;
           $all = DailyStatus::where('status',1)->get()->count();
            $response['status'] = 0;
            $response['message'] = "Check Featured canceled";


            if (isset($request->isChecked) && $request->isChecked != 'true') {
                $data['status'] = 0;
                $save = DailyStatus::where('id', $id)->update($data);
                $response['status'] = 1;
                $response['message'] = "Disable Successfully";

            } else {
                if(isset($all) && $all == 1)
                {
                    return response()->json(['status' => 3, 'message' => 'Only One Can be Enable!']);
                }else{
                    $data['status'] = 1;
                    $save = DailyStatus::where('id', $id)->update($data);
                    $response['status'] = 2;
                    $response['message'] = "Enable Successfully";
                }
            }
            return response()->json($response);
    }
    public function check_pinned(Request $request)
    {
           $id = $request->id;
            $response['status'] = 0;
            $response['message'] = "Check Pinned canceled";


            if (isset($request->isChecked) && $request->isChecked != 'true') {
                $data['pinned'] = 0;
                $save = DailyStatus::where('id', $id)->update($data);
                $response['status'] = 1;
                $response['message'] = "Unchecked Successfully";

            } else {
                $data['pinned'] = 1;
                $save = DailyStatus::where('id', $id)->update($data);
                $response['status'] = 2;
                $response['message'] = "checked Successfully";

            }
            return response()->json($response);
    }
    public function search_status(Request $request)
    {

        $query = DailyStatus::select('*');

        if ($request->status != "2") {
            $query->where('status',$request->status);
        }

        if ($request->from_date != "") {
            $from_date = Carbon::createFromFormat('m/d/Y', $request->from_date)->startOfDay();
            $query->where('updated_at', '>=',$from_date);

        }

        if ($request->to_date != "") {
             $to_date = Carbon::createFromFormat('m/d/Y', $request->to_date)->endOfDay();
             $query->where('updated_at', '<=', $to_date);
        }

        $dailyStatus_list =  $query->latest()->get();

        $counter = 1;
        $dailyStatus_list->transform(function ($item) use (&$counter) {

            $item['ser_id'] = $counter++;

            if (isset($item['image']) && $item['image'] != '') {
                $item['image'] = '<img src="' . asset('uploads/daily_updates/' . $item['image']) . '" class="img-fluid white_logo rounded-circle" alt="" style="width:50px;height:50px;">';
            } else {
                $item['image'] = '<img src="' . asset('assets/img/new-profile.svg') . '" class="img-fluid white_logo rounded-circle" alt="" style="width:50px;height:50px;">';
            }

            if (isset($item['updated_at']) && $item['updated_at'] != '') {
                $dateTime = new DateTime($item['updated_at']);
                $formattedDate = $dateTime->format('d-m-Y | h:iA');
                $item['date'] = $formattedDate; 
            }else{
                $item['date'] = "-";
            }

            $item['action'] = '<a class="table-btn table-btn1 mx-2 daliy_status_edit" data-id="' . $item['id'] . '" href="' . route('daliystatus.edit', $item['id']) . '" title="Click here to Edit Daily Status"><img src="'.asset('images/dashbord/create.png').'" class="image-fuild" alt="user-img"></a>';

            $item['action'] .= '<a data-href="' . route('daliystatus.delete', $item['id']) . '" data-title="testrete" data-original-title="Delete Tags" class="daliy_status_delete table-btn table-btn1 delete" title="Click here to Delete Daily Status"><img src="'.asset('images/dashbord/delete.png').'" class="image-fuild" alt="user-img"></a>';

            if ($item['status'] == '1') {
                $item['status'] = '<input type="checkbox" class="is_featured_class" data-id="' . $item['id'] . '"  id="is_featured" name="is_featured" checked>';
            } else {
                $item['status'] = '<input type="checkbox" class="is_featured_class" data-id="' . $item['id'] . '" id="is_featured" name="is_featured">';
            }

            return $item;
        });

        return response()->json(['data' => $dailyStatus_list]);
    }


}
