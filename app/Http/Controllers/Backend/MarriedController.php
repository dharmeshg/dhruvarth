<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Married;
use App\Models\MediaImage;
use App\Models\Updatelog;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Support\Str;


class MarriedController extends Controller
{
    public function index()
    {
        return view('married.index');
    }
    public function add(){
        return view('married.add');
    }

    public function store(Request $request){

      
        $id = $request->married_id;

        if ($id != "") {
            $check = Married::where('slug', $request->slug)->first();
            if (isset($check->id) && $id != $check->id) {
                $slug = SlugService::createSlug(Married::class, 'slug', $request->slug);
            }else{
                $slug_update = $request->slug;
                $slug = Str::slug($slug_update, '-');
            }
         
            $married = Married::findOrfail($id);
            $edata = json_encode($married);
            $married->title = isset($request->title) ? $request->title : '';
            $married->slug = $slug;
            $married->url = isset($request->married_url) ? $request->married_url : '';
            $married->button_name = isset($request->button_name) ? $request->button_name : '';
            $married->description = isset($request->description) ? $request->description : '';
            $married->content = isset($request->content) ? $request->content : '';
            $married->image = isset($request->img_id) ? $request->img_id : '';
            $married->status = isset($request->status) && $request->status == 'on' ? '1' : '0';
            $married->meta_title = isset($request->meta_title) ? $request->meta_title : '';
            $married->meta_keyword = isset($request->meta_keyword) ? $request->meta_keyword : '';
            $married->meta_description = isset($request->meta_description) ? $request->meta_description : '';
            $married->page_index = isset($request->page_index) ? $request->page_index : 'on';
            $married->canonical_url = isset($request->canonical_url) ? $request->canonical_url : null;
            $married->update();
            $edt = Updatelog::create(['tablename'=>'married','table_primary_id'=>$married->id,'edit_log'=>$edata]);
            return redirect()->route('married.index')->with('success','Married update Successfully.');
        }else{
            $slug = SlugService::createSlug(Married::class, 'slug', $request->slug);
            $married = new Married();
            $married->title = isset($request->title) ? $request->title : '';
            $married->slug = $slug;
            $married->url = isset($request->married_url) ? $request->married_url : '';
            $married->button_name = isset($request->button_name) ? $request->button_name : '';
            $married->description = isset($request->description) ? $request->description : '';
            $married->content = isset($request->content) ? $request->content : '';
            $married->image = isset($request->img_id) ? $request->img_id : '';
            $married->status = isset($request->status) && $request->status == 'on' ? '1' : '0';
            $married->meta_title = isset($request->meta_title) ? $request->meta_title : '';
            $married->meta_keyword = isset($request->meta_keyword) ? $request->meta_keyword : '';
            $married->meta_description = isset($request->meta_description) ? $request->meta_description : '';
            $married->page_index = isset($request->page_index) ? $request->page_index : 'on';
            $married->canonical_url = isset($request->canonical_url) ? $request->canonical_url : null;
            $married->save();
            return redirect()->route('married.index')->with('success','Married Added Successfully.');
        }
    }

    public function list(Request $request) {
      
        $married_list = Married::select('*')->where('deleted_at', null)->get();

        $counter = 1;
        $married_list->transform(function ($item) use (&$counter) {
            $item['ser_id'] = $counter++;
            if (isset($item['image']) && $item['image'] != '') {
                $image_name = MediaImage::where('id' ,$item['image'])->first();
            
                $item['image'] = '<img src="' . asset('uploads/' . $image_name->name) . '" class="img-fluid white_logo rounded-circle" alt="" style="width:50px;height:50px;">';
            } else {
                $item['image'] = '<img src="' . asset('assets/images/user/img-demo_1041.jpg') . '" class="img-fluid white_logo rounded-circle" alt="" style="width:50px;height:50px;">';
            }
            if ($item['status'] == '1') {
                $item['status'] = '<input type="checkbox" data-id="' . $item['id'] . '" data-toggle="toggle" id="married_status" name="married_status"  checked class="is_featured_class">';
            } else {
                $item['status'] = '<input type="checkbox" data-id="' . $item['id'] . '" data-toggle="toggle" id="married_status"  class="is_featured_class">';
            }
            $item['action'] = '<a class="label theme-bg2 text-white f-12 tags_edit" data-id="' . $item['id'] . '" href="' . route('married.edit', $item['id']) . '"><i class="fa fa-edit"></i></a>';
            $item['action'] .= '<a data-href="' . route('married.delete', $item['id']) . '" data-title="testrete" data-original-title="Delete Tags" class="label theme-bg text-white f-12 married_delete"><i class="fa fa-trash" aria-hidden="true"></i></a>';
            return $item;

        });
    
        return response()->json(['data' => $married_list]);
    }

    public function delete($id) {
        if ($id != "") {
            $record = Married::find($id);
            $record->delete();
            return redirect()->route('married.index')
                ->withSuccess('Married Delete Successfully.');
        }
    }

    public function edit($id) {
        $married = Married::findOrFail($id);
     
        $image_name = MediaImage::where('id' ,$married->image)->first();
        return view('married.add', compact('married','image_name'));
    }

    public function check_status(Request $request) {
        $id = $request->id;
        $response['status'] = 0;
        $response['message'] = "Check Status canceled";
      

        if (isset($request->isChecked) && $request->isChecked != 'true') {
            $data['status'] = 0;
            $save = Married::where('id', $id)->update($data);
            $response['status'] = 1;
            $response['message'] = "Status Update Successfully";

        } else {
            $data['status'] = 1;
            $save = Married::where('id', $id)->update($data);
            $response['status'] = 2;
            $response['message'] = "Status Update Successfully";

        }
        return response()->json($response);
    }

    public function married_check_slug(Request $request) {
        $check = Married::where('title', $request->name)->first();
        if($check && $check != '' && $check != null)
        {
            $response['status'] = 1;
            $response['message'] = "available";
        }else{
            $response['status'] = 2;
            $response['message'] = "unavailable";
        }
        return response()->json($response);
    }
}
