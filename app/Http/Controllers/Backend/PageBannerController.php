<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PageBanner;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use DateTime;

class PageBannerController extends Controller
{
    public function index()
    {
        $page_banners = PageBanner::latest()->get();
        return view('pagebanner.index',compact('page_banners'));
    }
    public function save(Request $request)
    {
        // dd($request->all());
        if(isset($request->p_banner_id) && $request->p_banner_id != null && $request->p_banner_id != '')
        {
            $page_banner = PageBanner::findOrfail($request->p_banner_id);
        }else{
            $page_banner = new PageBanner();
        }
        if ($request->hasFile('sec_image')) {
            $file_path = public_path('uploads/media/' . $request->cover_old_img);
                if (File::exists(public_path('uploads/media/' . $request->cover_old_img))) {
                    File::delete($file_path);
                }
            $current = Carbon::now()->format('YmdHs');
            $uploadpdf = $request->file('sec_image');
            $image = $current . $uploadpdf->getClientOriginalName();
            $uploadpdf->move('uploads/media/', $image);
            $imageName = $image;
        }else{
            
            $imageName = $request->sec_old_img;
        }
        if ($request->hasFile('sec_med_image')) {
            $file_path = public_path('uploads/media/' . $request->cover_old_img);
                if (File::exists(public_path('uploads/media/' . $request->cover_old_img))) {
                    File::delete($file_path);
                }
            $current = Carbon::now()->format('YmdHs');
            $uploadpdf = $request->file('sec_med_image');
            $image = $current . $uploadpdf->getClientOriginalName();
            $uploadpdf->move('uploads/media/', $image);
            $imageName2 = $image;
        }else{
            
            $imageName2 = $request->sec_med_old_img;
        }

        if ($request->hasFile('sec_small_image')) {
            $file_path = public_path('uploads/media/' . $request->cover_old_img);
                if (File::exists(public_path('uploads/media/' . $request->cover_old_img))) {
                    File::delete($file_path);
                }
            $current = Carbon::now()->format('YmdHs');
            $uploadpdf = $request->file('sec_small_image');
            $image = $current . $uploadpdf->getClientOriginalName();
            $uploadpdf->move('uploads/media/', $image);
            $imageName3 = $image;
        }else{
            
            $imageName3 = $request->sec_small_old_img;
        }
        $page_banner->cover_image = isset($imageName) ? $imageName : null;
        $page_banner->medium_image = isset($imageName2) ? $imageName2 : null;
        $page_banner->small_image = isset($imageName3) ? $imageName3 : null;
    
        $page_banner->title = isset($request->title) ? $request->title : null;
        $page_banner->url = isset($request->url) ? $request->url : null;
        $page_banner->status = isset($request->status) && $request->status == 'on' ? 1 : 0;
        $page_banner->save();

        return response()->json(['status' => 1 , 'message' => 'Page Banner Saved Successfully']);
        // return redirect()->route('pagebanner.index', ['slug' => $request->type])->with('success', 'Page Banner Saved Successfully');
    }
    public function list(Request $request)
    {

        $banner_list = PageBanner::where('type',$request->slug)->latest()->get();
        // dd($logo_list);
        $counter = 1;
        $banner_list->transform(function ($item) use (&$counter) {
            // $item['ser_id'] = '<div class="custom-control custom-checkbox">
            // <input type="checkbox" class="pinned_chekbox" id="pinned_chekbox" data-id="' . $item['id'] . '"';

            // if ($item['pinned'] == 1) {
            //     $item['ser_id'] .= ' checked';
            // }
            //   $item['ser_id'] .= '></div>';

            $item['ser_id'] = $counter++;

            if (isset($item['updated_at']) && $item['updated_at'] != '') {
                $dateTime = new DateTime($item['updated_at']);
                $formattedDate = $dateTime->format('d-m-Y | h:iA');
                $item['date'] = $formattedDate; 
            }else{
                $item['date'] = "-";
            }
            if (isset($item['cover_image']) && $item['cover_image'] != '') {
                $item['image'] = '<img src="' . asset('uploads/media/' . $item['cover_image']) . '" class="img-fluid white_logo" alt="" style="width:50px;height:50px;">';
            } else {
                $item['image'] = '<img src="' . asset('assets/images/user/img-demo_1041.jpg') . '" class="img-fluid white_logo" alt="" style="width:50px;height:50px;">';
            }
            
            
            if ($item['status'] == '1') {
                $item['status'] = '<input type="checkbox" data-id="' . $item['id'] . '" data-toggle="toggle" id="is_featured"  checked class="is_featured_class">';
            } else {
                $item['status'] = '<input type="checkbox" data-id="' . $item['id'] . '" data-toggle="toggle" id="is_featured"  class="is_featured_class">';
            }
            $item['action'] = '<a href="' . route('pagebanner.edit', $item['id']) . '" class="table-btn table-btn1 mx-2 edit" data-id="' . $item['id'] . '" ><img src="'.asset('images/dashbord/create.png').'" title="Click here for edit product" class="image-fuild" alt="user-img"></a>';
            $item['action'] .= '<a href="javascript:;" data-href="' . route('pagebanner.delete', $item['id']) . '" class="table-btn table-btn1 delete" title="Click here for delete product"><img src="'.asset('images/dashbord/delete.png').'" class="image-fuild" alt="user-img"></a>';
            return $item;
        });

        return response()->json(['data' => $banner_list]);
    }
    public function add($sec)
    {
        return view('pagebanner.add',compact('sec'));
    }
    public function edit(Request $request)
    {
        $page_banner = PageBanner::findOrfail($request->id);
        // return view('pagebanner.add',compact('page_banner'));

        if(isset($page_banner) && $page_banner != '' && $page_banner != null)
        {
            $data = $page_banner;
            if(isset($page_banner['cover_image']) && $page_banner['cover_image'] != null && $page_banner['cover_image'] != '')
            {
                $data['img_url'] = asset('uploads/media/' . $page_banner['cover_image']);
            }
            if(isset($page_banner['medium_image']) && $page_banner['medium_image'] != null && $page_banner['medium_image'] != '')
            {
                $data['med_img_url'] = asset('uploads/media/' . $page_banner['medium_image']);
            }
            if(isset($page_banner['small_image']) && $page_banner['small_image'] != null && $page_banner['small_image'] != '')
            {
                $data['small_img_url'] = asset('uploads/media/' . $page_banner['medium_image']);
            }
            return response()->json(['data' => $data , 'message' => 'success' , 'status' => 1]);
        }else{
            return response()->json(['message' => 'something went wrong!', 'status' => 0]);
        }
    }
    public function delete(Request $request)
    {
        // dd($request->all());
        $page_banner = PageBanner::findOrfail($request->id);
        if(isset($page_banner) && $page_banner != '' && $page_banner != null)
        {
            if(isset($page_banner->cover_image) && $page_banner->cover_image != '')
            {
                $file_path = public_path('uploads/media/' . $page_banner->cover_image);


                if (File::exists(public_path('uploads/media/' . $page_banner->cover_image))) {
                    File::delete($file_path);
                }
            }
            $page_banner->delete();
            return response()->json(['message' => 'PageBanner Deleted Successfully!' , 'status' => 1]);
            // return redirect()-> route('pagebanner.index', ['slug' => $slug])->with('error','Page Banner Deleted Successfully!');
        }else{
            return response()->json(['message' => 'something went wrong!', 'status' => 0]);
            // return redirect()-> route('pagebanner.index', ['slug' => $slug])->with('error','something went wrong!');
        }
    }
    public function status(Request $request)
    {
        $id = $request->id;
        $response['status'] = 0;
        $response['message'] = "Check Featured canceled";
      

        if (isset($request->isChecked) && $request->isChecked != 'true') {
            $data['status'] = 0;
            $save = PageBanner::where('id', $id)->update($data);
            $response['status'] = 1;
            $response['message'] = "Disable Successfully";

        } else {
            $data['status'] = 1;
            $save = PageBanner::where('id', $id)->update($data);
            $response['status'] = 2;
            $response['message'] = "Enable Successfully";

        }
        return response()->json($response);
    }
}
