<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SliderBanner;
use Illuminate\Support\Facades\File;
use DateTime;
use Carbon\Carbon;

class SliderBannerController extends Controller
{
    public function index(){
        $banners = SliderBanner::latest()->paginate(10);
        return view('sliderbanner.index',compact('banners'));
    }
    public function add()
    {
        return view('sliderbanner.add');
    }
    public function save(Request $request)
    {
        // dd($request->all());
        if(isset($request->banner_id) && $request->banner_id != null && $request->banner_id != '')
        {
            $banner = SliderBanner::findOrfail($request->banner_id);
        }else{
            $banner = new SliderBanner();
        }
        if ($request->hasFile('large_image')) {
            $current = Carbon::now()->format('YmdHs');
            $uploadpdf = $request->file('large_image');
            $image = $current . $uploadpdf->getClientOriginalName();
            $uploadpdf->move('uploads/slider_banner/', $image);
            $imageName = $image;
        }else{
            
            $imageName = $request->large_old_img;
        }
        if ($request->hasFile('medium_image')) {
            $current = Carbon::now()->format('YmdHs');
            $uploadpdf = $request->file('medium_image');
            $image_m = $current . $uploadpdf->getClientOriginalName();
            $uploadpdf->move('uploads/slider_banner/', $image_m);
            $imageName_m = $image_m;
        }else{
            
            $imageName_m = $request->medium_old_img;
        }
        if ($request->hasFile('small_image')) {
            $current = Carbon::now()->format('YmdHs');
            $uploadpdf = $request->file('small_image');
            $image_s = $current . $uploadpdf->getClientOriginalName();
            $uploadpdf->move('uploads/slider_banner/', $image_s);
            $imageName_s = $image_s;
        }else{
            
            $imageName_s = $request->small_old_img;
        }
        $banner->large_img = isset($imageName) ? $imageName: null;
        $banner->medium_img = isset($imageName_m) ? $imageName_m: null;
        $banner->small_img = isset($imageName_s) ? $imageName_s: null;
        $banner->destination_link = isset($request->destination_link) ? $request->destination_link : null;
        $banner->save();
        return redirect()->route('sliderbanner.index')->with('success','Slider Banner Saved Successfully.');
    }

    public function list(Request $request)
    {
        $slider_list = SliderBanner::latest()->get();
        // dd($logo_list);
        $counter = 1;
        $slider_list->transform(function ($item) use (&$counter) {
            // $item['ser_id'] = '<div class="custom-control custom-checkbox">
            // <input type="checkbox" class="pinned_chekbox" id="" data-id="' . $item['id'] . '"';

            // if ($item['pinned'] == 1) {
            //     $item['ser_id'] .= ' checked';
            // }


            // $item['ser_id'] .= '></div>';

            $item['ser_id'] = $counter++;

            if (isset($item['updated_at']) && $item['updated_at'] != '') {
                $dateTime = new DateTime($item['updated_at']);
                $formattedDate = $dateTime->format('d-m-Y');
                $item['date'] = $formattedDate; 
            }else{
                $item['date'] = "-";
            }

            if (isset($item['large_img']) && $item['large_img'] != '') {
                $item['large_img'] = '<img src="' . asset('uploads/slider_banner/' . $item['large_img']) . '" class="img-fluid white_logo" alt="" style="width:50px;height:50px;">';
            } else {
                $item['large_img'] = '<img src="' . asset('assets/images/user/img-demo_1041.jpg') . '" class="img-fluid white_logo" alt="" style="width:50px;height:50px;">';
            }
             if (isset($item['medium_img']) && $item['medium_img'] != '') {
                $item['medium_img'] = '<img src="' . asset('uploads/slider_banner/' . $item['medium_img']) . '" class="img-fluid white_logo" alt="" style="width:50px;height:50px;">';
            } else {
                $item['medium_img'] = '<img src="' . asset('assets/images/user/img-demo_1041.jpg') . '" class="img-fluid white_logo" alt="" style="width:50px;height:50px;">';
            }
             if (isset($item['small_img']) && $item['small_img'] != '') {
                $item['small_img'] = '<img src="' . asset('uploads/slider_banner/' . $item['small_img']) . '" class="img-fluid white_logo" alt="" style="width:50px;height:50px;">';
            } else {
                $item['small_img'] = '<img src="' . asset('assets/images/user/img-demo_1041.jpg') . '" class="img-fluid white_logo" alt="" style="width:50px;height:50px;">';
            }
            
            if ($item['status'] == '1') {
                $item['status'] = '<input type="checkbox" data-id="' . $item['id'] . '"  id="is_featured"  checked class="is_featured_class">';
            } else {
                $item['status'] = '<input type="checkbox" data-id="' . $item['id'] . '"  id="is_featured"  class="is_featured_class">';
            }
            $item['action'] = '<a href="' . route('sliderbanner.edit', $item['id']) . '" title="Click here to Edit Slider Banner"  class="table-btn table-btn1 edit first-button" data-id="' . $item['id'] . '" ><img src="'.asset('images/dashbord/create.png').'" class="image-fuild" alt="user-img"></a>';
            $item['action'] .= '<a href="javascript:;" data-href="' . route('sliderbanner.delete', $item['id']) . '" class="table-btn table-btn1 delete" title="Click here to Delete Slider Banner"><img src="'.asset('images/dashbord/delete.png').'" class="image-fuild" alt="user-img"></a>';
            return $item;
        });

        return response()->json(['data' => $slider_list]);
    }

    public function edit($id)
    {
        $banner = SliderBanner::findOrfail($id);
        return view('sliderbanner.add', compact('banner'));
        // if(isset($banner) && $banner != '' && $banner != null)
        // {
        //     $data = $banner;
        //     $data['large_url'] = asset('uploads/daily_updates/' . $banner['large_img']);
        //     $data['medium_url'] = asset('uploads/daily_updates/' . $banner['medium_img']);
        //     $data['small_url'] = asset('uploads/daily_updates/' . $banner['small_img']);

        //     return response()->json(['data' => $data , 'message' => 'success' , 'status' => 'success']);
        // }else{
        //     return response()->json(['message' => 'something went wrong!', 'status' => 'error']);
        // }
    }

    public function delete($id)
    {
        // dd($id);
        $banner = SliderBanner::findOrfail($id);
        if(isset($banner->large_img) && $banner->large_img != '')
        {
            $file_path_l = public_path('uploads/slider_banner/' . $banner->large_img);


            if (File::exists(public_path('uploads/slider_banner/' . $banner->large_img))) {
                File::delete($file_path_l);
            }
        }
        if(isset($banner->medium_img) && $banner->medium_img != '')
        {
            $file_path_m = public_path('uploads/slider_banner/' . $banner->medium_img);
            if (File::exists(public_path('uploads/slider_banner/' . $banner->medium_img))) {
                File::delete($file_path_m);
            }
        }
        if(isset($banner->small_img) && $banner->small_img != '')
        {
            $file_path_s = public_path('uploads/slider_banner/' . $banner->small_img);
            if (File::exists(public_path('uploads/slider_banner/' . $banner->small_img))) {
                File::delete($file_path_s);
            }
        }
        $banner->delete();
        return redirect()->route('sliderbanner.index')->with('error','Slider Banner Deleted Successfully!');
    }

    public function status(Request $request)
    {
        $id = $request->id;
        $all = SliderBanner::where('status',1)->get()->count();
        $response['status'] = 0;
        $response['message'] = "Check Featured canceled";
      

        if (isset($request->isChecked) && $request->isChecked != 'true') {
            $data['status'] = 0;
            $save = SliderBanner::where('id', $id)->update($data);
            $response['status'] = 1;
            $response['message'] = "Disable Successfully";

        } else {
            if(isset($all) && $all == 5)
                {
                    return response()->json(['status' => 3, 'message' => 'Only Five Can be Enable!']);
                }else{
            $data['status'] = 1;
            $save = SliderBanner::where('id', $id)->update($data);
            $response['status'] = 2;
            $response['message'] = "Enable Successfully";
        }
        }
        return response()->json($response);
    }

    public function pinned(Request $request)
    {
           $id = $request->id;
            $response['status'] = 0;
            $response['message'] = "Check Pinned canceled";


            if (isset($request->isChecked) && $request->isChecked != 'true') {
                $data['pinned'] = 0;
                $save = SliderBanner::where('id', $id)->update($data);
                $response['status'] = 1;
                $response['message'] = "Unchecked Successfully";

            } else {
                $data['pinned'] = 1;
                $save = SliderBanner::where('id', $id)->update($data);
                $response['status'] = 2;
                $response['message'] = "checked Successfully";

            }
            return response()->json($response);
    }
    public function search_slider_status(Request $request)
    {
        // dd($request->all());

        
        $query = SliderBanner::select('*');

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

        $slider_list =  $query->latest()->get();


        // $slider_list = SliderBanner::where('status',$request->status)->whereBetween('updated_at', [Carbon::createFromFormat('m/d/Y', $request->from_date)->startOfDay(), Carbon::createFromFormat('m/d/Y', $request->to_date)->endOfDay()])->latest()->get();

        $counter = 1;
        $slider_list->transform(function ($item) use (&$counter) {
            $item['ser_id'] = $counter++;
            if (isset($item['updated_at']) && $item['updated_at'] != '') {
                $dateTime = new DateTime($item['updated_at']);
                $formattedDate = $dateTime->format('d-m-Y | h:iA');
                $item['date'] = $formattedDate; 
            }else{
                $item['date'] = "-";
            }

            if (isset($item['large_img']) && $item['large_img'] != '') {
                $item['large_img'] = '<img src="' . asset('uploads/slider_banner/' . $item['large_img']) . '" class="img-fluid white_logo" alt="" style="width:50px;height:50px;">';
            } else {
                $item['large_img'] = '<img src="' . asset('assets/images/user/img-demo_1041.jpg') . '" class="img-fluid white_logo" alt="" style="width:50px;height:50px;">';
            }
             if (isset($item['medium_img']) && $item['medium_img'] != '') {
                $item['medium_img'] = '<img src="' . asset('uploads/slider_banner/' . $item['medium_img']) . '" class="img-fluid white_logo" alt="" style="width:50px;height:50px;">';
            } else {
                $item['medium_img'] = '<img src="' . asset('assets/images/user/img-demo_1041.jpg') . '" class="img-fluid white_logo" alt="" style="width:50px;height:50px;">';
            }
             if (isset($item['small_img']) && $item['small_img'] != '') {
                $item['small_img'] = '<img src="' . asset('uploads/slider_banner/' . $item['small_img']) . '" class="img-fluid white_logo" alt="" style="width:50px;height:50px;">';
            } else {
                $item['small_img'] = '<img src="' . asset('assets/images/user/img-demo_1041.jpg') . '" class="img-fluid white_logo" alt="" style="width:50px;height:50px;">';
            }
            
            if ($item['status'] == '1') {
                $item['status'] = '<input type="checkbox" data-id="' . $item['id'] . '"  id="is_featured"  checked class="is_featured_class">';
            } else {
                $item['status'] = '<input type="checkbox" data-id="' . $item['id'] . '"  id="is_featured"  class="is_featured_class">';
            }
            $item['action'] = '<a href="' . route('sliderbanner.edit', $item['id']) . '" class="table-btn table-btn1 mx-2 edit" data-id="' . $item['id'] . '" title="Click here to Edit Slider Banner"><img src="'.asset('images/dashbord/create.png').'" class="image-fuild" alt="user-img"></a>';
            $item['action'] .= '<a href="javascript:;" data-href="' . route('sliderbanner.delete', $item['id']) . '" class="table-btn table-btn1 delete" title="Click here to Delete Slider Banner"><img src="'.asset('images/dashbord/delete.png').'" class="image-fuild" alt="user-img"></a>';
            return $item;
        });

        return response()->json(['data' => $slider_list]);
    }

}
