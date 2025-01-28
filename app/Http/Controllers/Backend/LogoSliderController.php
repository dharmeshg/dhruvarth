<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LogoSlider;
use App\Models\MediaSection;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use DateTime;

class LogoSliderController extends Controller
{
    public function index($slug)
    {
        $sec_title = MediaSection::where('slug',$slug)->first();
        return view('logoslider.index',compact('slug','sec_title'));
    }
    public function add($sec)
    {
        return view('logoslider.add',compact('sec'));
    }
    public function save(Request $request)
    {
         // dd($request->all());
        if(isset($request->logo_id) && $request->logo_id != null && $request->logo_id != '')
        {
            $logo_slider = LogoSlider::findOrfail($request->logo_id);
        }else{
            $logo_slider = new LogoSlider();
        }
        if ($request->hasFile('cover_image')) {
            $file_path = public_path('uploads/media/' . $request->cover_old_img);
                if (File::exists(public_path('uploads/media/' . $request->cover_old_img))) {
                    File::delete($file_path);
                }
            $current = Carbon::now()->format('YmdHs');
            $uploadpdf = $request->file('cover_image');
            $image = $current . $uploadpdf->getClientOriginalName();
            $uploadpdf->move('uploads/media/', $image);
            $imageName = $image;
        }else{   
            $imageName = $request->cover_old_img;
        }
        $logo_slider->cover_image = isset($imageName) ? $imageName : null;
        $logo_slider->type = isset($request->type) ? $request->type : null;
        $logo_slider->title = isset($request->title) ? $request->title : null;
        $logo_slider->link = isset($request->link) ? $request->link : null;
        $logo_slider->save();

        return redirect()->route('logoslider.index', ['slug' => $request->type])->with('success', 'Logo Slider Saved Successfully');
    }
    public function list(Request $request)
    {

        $logo_list = LogoSlider::where('type',$request->slug)->latest()->get();
        // dd($logo_list);
        $counter = 1;
        $logo_list->transform(function ($item) use (&$counter) {
            // $item['ser_id'] = '<div class="custom-control custom-checkbox">
            // <input type="checkbox" class="pinned_chekbox" id="pinned_chekbox" data-id="' . $item['id'] . '"';

            // if ($item['pinned'] == 1) {
            //     $item['ser_id'] .= ' checked';
            // }
            //   $item['ser_id'] .= '></div>';

            $item['ser_id'] = $counter++;

            if (isset($item['updated_at']) && $item['updated_at'] != '') {
                $dateTime = new DateTime($item['updated_at']);
                $formattedDate = $dateTime->format('d-m-Y');
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
            $item['action'] = '<a class="table-btn table-btn1 first-button logo_slider_edit" data-id="' . $item['id'] . '" href="' . route('logoslider.edit', $item['id']) . '" title="Click here to Edit Logo" ><img src="'.asset('images/dashbord/create.png').'" class="image-fuild" alt="user-img"></a>';

            $item['action'] .= '<a data-href="' . route('logoslider.delete', $item['id']) . '" data-title="Logo Slider" data-original-title="Delete Logo Slider" class="logo_slider_delete table-btn table-btn1 delete" title="Click here to Delete Logo" ><img src="'.asset('images/dashbord/delete.png').'" class="image-fuild" alt="user-img"></a>';

                // $item['action'] = '<a href="javascript:;" class="table-btn table-btn1 mx-2 edit" data-id="' . $item['id'] . '" ><img src="'.asset('images/dashbord/create.png').'" class="image-fuild" alt="user-img"></a>';
                // $item['action'] .= '<a href="javascript:;" data-href="' . route('logoslider.delete', $item['id']) . '" class="table-btn table-btn1 delete"><img src="'.asset('images/dashbord/delete.png').'" class="image-fuild" alt="user-img"></a>';
            return $item;
        });

        return response()->json(['data' => $logo_list]);
    }

    public function edit(Request $request)
    {
        $logo_slider = LogoSlider::findOrfail($request->id);
        if(isset($logo_slider) && $logo_slider != '' && $logo_slider != null)
        {
            $data = $logo_slider;
            $data['img_url'] = asset('uploads/media/' . $logo_slider['cover_image']);
                // dd($data);
            return view('logoslider.add',compact('data'));
        }else{
            return redirect()->back()->with(['message' => 'something went wrong!', 'status' => 'error']);
        }
    }

    public function delete($id)
    {
        // dd($id);
        $logo_slider = LogoSlider::findOrfail($id);
        if(isset($logo_slider) && $logo_slider != '' && $logo_slider != null)
        {
            if(isset($logo_slider->cover_image) && $logo_slider->cover_image != '')
            {
                $file_path = public_path('uploads/media/' . $logo_slider->cover_image);


                if (File::exists(public_path('uploads/media/' . $logo_slider->cover_image))) {
                    File::delete($file_path);
                }
            }
            $slug = $logo_slider->type;
            $logo_slider->delete();
            return redirect()-> route('logoslider.index', ['slug' => $slug])->with('error','Logo Slider Deleted Successfully!');
        }else{
            return redirect()-> route('logoslider.index', ['slug' => $slug])->with('error','something went wrong!');
        }
    }
    public function status(Request $request)
    {
        $id = $request->id;
        $response['status'] = 0;
        $response['message'] = "Check Featured canceled";
      

        if (isset($request->isChecked) && $request->isChecked != 'true') {
            $data['status'] = 0;
            $save = LogoSlider::where('id', $id)->update($data);
            $response['status'] = 1;
            $response['message'] = "Disable Successfully";

        } else {
            $data['status'] = 1;
            $save = LogoSlider::where('id', $id)->update($data);
            $response['status'] = 2;
            $response['message'] = "Enable Successfully";

        }
        return response()->json($response);
    }
}
