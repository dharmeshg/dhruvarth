<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AdsPoster;
use App\Models\Catalogue;
use App\Models\Collection;
use App\Models\MediaSection;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use DateTime;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class AdsPosterController extends Controller
{
    public function index($slug)
    {
        $sec_title = MediaSection::where('slug',$slug)->first();
        return view('adsposter.index',compact('slug','sec_title'));
    }

    public function add($sec)
    {
        $catalogs = Catalogue::where('status',1)->get();
        $collections = Collection::where('status',1)->get();
         return view('adsposter.add',compact('sec','catalogs','collections'));
    }
    public function save(Request $request)
    {

        if(isset($request->poster_id) && $request->poster_id != null && $request->poster_id != '')
        {
            $ads_poster = AdsPoster::findOrfail($request->poster_id);
        }else{
            $ads_poster = new AdsPoster();
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

            $manager = new ImageManager(new Driver());
            $image = $manager->read(base_path('/public/uploads/media/').$imageName);

            $image = $image->resize(575,383);
            $image->save(base_path('/public/uploads/media/thumb/'.$imageName));
        }else{
            
            $imageName = $request->cover_old_img;
        }

        if ($request->select_type == "URL") {
            $destination_link = $request->destination_link;
        }elseif ($request->select_type == "Catalogue") {
            $destination_link = $request->catalogue;
        }elseif ($request->select_type == "Collection") {
            $destination_link = $request->collection;
        }
        $ads_poster->cover_image = isset($imageName) ? $imageName : null;
        $ads_poster->type = isset($request->type) ? $request->type : null;
        $ads_poster->select_type = isset($request->select_type) ? $request->select_type : null;
        $ads_poster->destination_link = isset($destination_link) ? $destination_link : null;
        $ads_poster->status = isset($request->status) && $request->status == 'on' ? 1 : 0;
        $ads_poster->save();

        return redirect()->route('adsposter.index', ['slug' => $request->type])->with('success', 'Logo Slider Saved Successfully');
    }
    public function list(Request $request)
    {

        $ads_list = AdsPoster::where('type',$request->slug)->latest()->get();
        // dd($logo_list);
        $counter = 1;
        
        $ads_list->transform(function ($item) use (&$counter) {
            $item['ser_id'] = $counter++;
            // $item['ser_id'] = '<div class="custom-control custom-checkbox">
            // <input type="checkbox" class="pinned_chekbox" id="pinned_chekbox" data-id="' . $item['id'] . '"';

            // if ($item['pinned'] == 1) {
            //     $item['ser_id'] .= ' checked';
            // }
            //   $item['ser_id'] .= '></div>';

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
            $item['action'] = '<a href="' . route('adsposter.edit', $item['id']) . '" class="table-btn table-btn1 edit first-button" data-id="' . $item['id'] . '" title="Click here to Edit Poster" ><img src="'.asset('images/dashbord/create.png').'" class="image-fuild" alt="user-img"></a>';
            $item['action'] .= '<a href="javascript:;" data-href="' . route('adsposter.delete', $item['id']) . '" title="Click here to Delete Poster" class="table-btn table-btn1 delete"><img src="'.asset('images/dashbord/delete.png').'" class="image-fuild" alt="user-img"></a>';
            return $item;
        });

        return response()->json(['data' => $ads_list]);
    }
     public function edit($id)
    {
        $ads_poster = AdsPoster::findOrfail($id);
        $catalogs = Catalogue::where('status',1)->get();
        $collections = Collection::where('status',1)->get();
         return view('adsposter.add', compact('ads_poster','catalogs','collections'));

        // if(isset($ads_poster) && $ads_poster != '' && $ads_poster != null)
        // {
        //     $data = $ads_poster;
        //     $data['img_url'] = asset('uploads/media/' . $ads_poster['cover_image']);

        //     return response()->json(['data' => $data , 'message' => 'success' , 'status' => 'success']);
        // }else{
        //     return response()->json(['message' => 'something went wrong!', 'status' => 'error']);
        // }
    }
    public function delete($id)
    {
        // dd($id);
        $ads_poster = AdsPoster::findOrfail($id);
        if(isset($ads_poster) && $ads_poster != '' && $ads_poster != null)
        {
            if(isset($ads_poster->cover_image) && $ads_poster->cover_image != '')
            {
                $file_path = public_path('uploads/media/' . $ads_poster->cover_image);


                if (File::exists(public_path('uploads/media/' . $ads_poster->cover_image))) {
                    File::delete($file_path);
                }
            }
            $slug = $ads_poster->type;
            $ads_poster->delete();
            return redirect()-> route('adsposter.index', ['slug' => $slug])->with('error','Ads Poster Deleted Successfully!');
        }else{
            return redirect()-> route('adsposter.index', ['slug' => $slug])->with('error','something went wrong!');
        }
    }
    public function status(Request $request)
    {
        $id = $request->id;
        $response['status'] = 0;
        $response['message'] = "Check Featured canceled";
      

        if (isset($request->isChecked) && $request->isChecked != 'true') {
            $data['status'] = 0;
            $save = AdsPoster::where('id', $id)->update($data);
            $response['status'] = 1;
            $response['message'] = "Disable Successfully";

        } else {
            $data['status'] = 1;
            $save = AdsPoster::where('id', $id)->update($data);
            $response['status'] = 2;
            $response['message'] = "Enable Successfully";

        }
        return response()->json($response);
    }
}
