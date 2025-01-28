<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\EmailSetting;
use App\Models\Slider;
use App\Models\MediaImage;
use App\Models\Updatelog;

use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Config;

class SlidersController extends Controller
{
    public function index()
    {
        return view('sliders.index');
    }

    public function add()
    {
        return view('sliders.add');
    }

    public function store(Request $request)
    {
         $id = $request->sliders_id;


        if ($id != "") {
         
            $slider = Slider::findOrfail($id);
            $edata = json_encode($slider);
            $slider->title = isset($request->title) ? $request->title : '';
            $slider->sub_title = isset($request->sub_title) ? $request->sub_title : '';
            $slider->url = isset($request->button_url) ? $request->button_url : '';
            $slider->btn_name = isset($request->button_name) ? $request->button_name : '';
            $slider->description = isset($request->description) ? $request->description : '';
            $slider->image = isset($request->img_id) ? $request->img_id : '';
            $slider->banner_image = isset($request->banner_img_id_slider) ? $request->banner_img_id_slider : '';
            $slider->status = isset($request->status) && $request->status == 'on' ? '1' : '0';
            $slider->update();
            $edt = Updatelog::create(['tablename'=>'slider','table_primary_id'=>$slider->id,'edit_log'=>$edata]);
            return redirect()->route('sliders.index')->with('success','Slider update Successfully.');
        }else{
         
            $slider = new Slider();
            $slider->title = isset($request->title) ? $request->title : '';
            $slider->sub_title = isset($request->sub_title) ? $request->sub_title : '';
            $slider->url = isset($request->button_url) ? $request->button_url : '';
            $slider->btn_name = isset($request->button_name) ? $request->button_name : '';
            $slider->description = isset($request->description) ? $request->description : '';
            $slider->image = isset($request->img_id) ? $request->img_id : '';
            $slider->banner_image = isset($request->banner_img_id_slider) ? $request->banner_img_id_slider : '';
            $slider->status = isset($request->status) && $request->status == 'on' ? '1' : '0';

            $slider->save();
            return redirect()->route('sliders.index')->with('success','Slider Added Successfully.');
        }

    }

    public function list()
    {
         $slider_list = Slider::select('*')->where('deleted_at', null)->get();

        $counter = 1;
        $slider_list->transform(function ($item) use (&$counter) {
            $item['ser_id'] = $counter++;
            if (isset($item['image']) && $item['image'] != '') {
                $image_name = MediaImage::where('id' ,$item['image'])->first();
            
                $item['image'] = '<img src="' . asset('uploads/' . $image_name->name) . '" class="img-fluid white_logo rounded-circle" alt="" style="width:50px;height:50px;">';
            } else {
                $item['image'] = '<img src="' . asset('assets/img/img-demo_1041.jpg') . '" class="img-fluid white_logo rounded-circle" alt="" style="width:50px;height:50px;">';
            }
            if ($item['status'] == '1') {
                $item['status'] = '<input type="checkbox" data-id="' . $item['id'] . '" data-toggle="toggle" id="slider_status" name="slider_status"  checked class="is_featured_class">';
            } else {
                $item['status'] = '<input type="checkbox" data-id="' . $item['id'] . '" data-toggle="toggle" id="slider_status"  class="is_featured_class" name="slider_status">';
            }
            $item['action'] = '<a class="label theme-bg2 text-white f-12 tags_edit" data-id="' . $item['id'] . '" href="' . route('sliders.edit', $item['id']) . '"><i class="fa fa-edit"></i></a>';
            $item['action'] .= '<a data-href="' . route('sliders.delete', $item['id']) . '" data-title="testrete" data-original-title="Delete Tags" class="label theme-bg text-white f-12 slider_delete"><i class="fa fa-trash" aria-hidden="true"></i></a>';
            return $item;

        });
    
        return response()->json(['data' => $slider_list]);
    }

     public function delete($id) {
        if ($id != "") {
            $record = Slider::find($id);
            $record->delete();
            return redirect()->route('sliders.index')
                ->withSuccess('Slider Delete Successfully.');
        }
    }

     public function edit($id) {
        $sliders = Slider::findOrFail($id);
     
        $image_name = MediaImage::where('id' ,$sliders->image)->first();

        $banner_image_name = MediaImage::where('id' ,$sliders->banner_image)->first();

        return view('sliders.add', compact('sliders','image_name','banner_image_name'));
    }

    public function check_status(Request $request) {
        $id = $request->id;
        $response['status'] = 0;
        $response['message'] = "Check Status canceled";
      

        if (isset($request->isChecked) && $request->isChecked != 'true') {
            $data['status'] = 0;
            $save = Slider::where('id', $id)->update($data);
            $response['status'] = 1;
            $response['message'] = "Status Update Successfully";

        } else {
            $data['status'] = 1;
            $save = Slider::where('id', $id)->update($data);
            $response['status'] = 2;
            $response['message'] = "Status Update Successfully";

        }
        return response()->json($response);
    }
  
}
