<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Cviebrock\EloquentSluggable\Services\SlugService;
use App\Models\ProjectGallery;
use App\Models\Updatelog;
use App\Models\GalleryImage;
use App\Models\MediaImage;
use App\Models\GalleryCategory;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;





class GalleryController extends Controller
{
    public function index()
    {
        return view('gallery.index');
    }
    public function add()
    {
        $galleryCategories = GalleryCategory::select('*')->where('parent_category', 0)->where('deleted_at', null)->get();
        return view('gallery.add', compact('galleryCategories'));
    }

    public function store(Request $request)
    {

        $response['status'] = 0;
        $response['message'] = 'Gallery not submit';
        $id = $request->gallery_id;

       
        if ($id != '') {
            $check = ProjectGallery::where('slug', $request->slug)->first();
            if (isset($check) && $id != $check->id) {
                $slug = SlugService::createSlug(ProjectGallery::class, 'slug', $request->slug);
            }else{
                $slug_update = $request->slug;
                $slug = Str::slug($slug_update, '-');
            }
            $gallery = ProjectGallery::findOrfail($id);
            $edata = json_encode($gallery);
        } else {
            $slug = SlugService::createSlug(ProjectGallery::class, 'slug', $request->slug);
            $gallery = new ProjectGallery();
        }

        if (isset($request->gallery_categories) && $request->gallery_categories != '') {
            $cats = implode(',', $request->gallery_categories);
        } else {
            $cats = null;
        }
        $gallery->category_id = $cats;
      
        $gallery->title = isset($request->title) ? $request->title : null;
        $gallery->slug = $slug ;
        $gallery->featured_img = isset($request->img_id) ? $request->img_id : null;
        $gallery->banner_image = isset($request->banner_img_id_gallery) ? $request->banner_img_id_gallery : null;
        $gallery->is_publish = isset($request->is_publish) && $request->is_publish == 'on' ? '1' : '0';
        $gallery->description = isset($request->description) ? $request->description : null;

        if ($id != '') {
            $gallery->update();
            $edt = Updatelog::create(['tablename'=>'gallery','table_primary_id'=>$gallery->id,'edit_log'=>$edata]);
            $response['status'] = 1;
            $response['message'] = "Gallery successfully Update";
        } else {
            $gallery->save();
            $response['status'] = 1;
            $response['message'] = "Gallery successfully submit";
        }
     
        if (!$request->multi_image == "") {
            if (isset($gallery) && $gallery->id != "") {
                $image = json_decode($request->multi_image);
                foreach ($image as $key => $value) {
                    $dataImage = array();
                    $extension = explode('/', mime_content_type($value->dataURL))[1];
                    $filename = date('YmdHi') . "_" . $request->title . "_" . rand(10, 10000) . "." . $extension;
                    file_put_contents(public_path('/uploads/gallery_multi_img/') . $filename, file_get_contents($value->dataURL));
                    $gallery_image = new GalleryImage();
                    $gallery_image->project_galleries_id = $gallery->id;
                    $gallery_image->name = $filename;
                    $gallery_image->save();
                }
            }
        }
        return json_encode($response);

    }
    public function list(Request $request)
    {
        $gallery_list = ProjectGallery::select('*')->where('deleted_at', null)->latest()->get();

        $counter = 1;
        $gallery_list->transform(function ($item) use (&$counter) {
            $item['ser_id'] = $counter++;
            if (isset($item['featured_img']) && $item['featured_img'] != '') {
                $image_name = MediaImage::where('id' ,$item['featured_img'])->first();
                $item['image'] = '<img src="' . asset('uploads/' . $image_name->name) . '" class="img-fluid white_logo rounded-circle" alt="" style="width:50px;height:50px;">';
            } else {
                $item['image'] = '<img src="' . asset('assets/img/new-profile.svg') . '" class="img-fluid white_logo rounded-circle" alt="" style="width:50px;height:50px;">';
            }
            if ($item['is_publish'] == '1') {
                // $item['publish'] = '<input type="checkbox" data-id="' . $item['id'] . '"  id="is_publish" name="is_publish" checked>';
                $item['publish'] = '<input type="checkbox" data-id="' . $item['id'] . '" data-toggle="toggle" id="is_publish" name="is_publish"  checked class="is_featured_class">';
            } else {
                // $item['publish'] = '<input type="checkbox" data-id="' . $item['id'] . '" id="is_publish" name="is_publish">';
                $item['publish'] = '<input type="checkbox" data-id="' . $item['id'] . '" data-toggle="toggle" id="is_publish"  class="is_featured_class">';
            }
            if ($item['is_featured'] == '1') {
                // $item['publish'] = '<input type="checkbox" data-id="' . $item['id'] . '"  id="is_publish" name="is_publish" checked>';
                $item['featured'] = '<input type="checkbox" data-id="' . $item['id'] . '" data-toggle="toggle" id="is_featured" name="is_featured"  checked class="is_featured_class">';
            } else {
                // $item['publish'] = '<input type="checkbox" data-id="' . $item['id'] . '" id="is_publish" name="is_publish">';
                $item['featured'] = '<input type="checkbox" data-id="' . $item['id'] . '" data-toggle="toggle" id="is_featured"  class="is_featured_class">';
            }
            $item['action'] = '<a class="label theme-bg2 text-white f-12 tags_edit" data-id="' . $item['id'] . '" href="' . route('gallery.edit', $item['id']) . '"><i class="fa fa-edit"></i></a>';
            $item['action'] .= '<a data-href="' . route('gallery.delete', $item['id']) . '" data-title="testrete" data-original-title="Delete Tags" class="label theme-bg text-white f-12 gallery_delete"><i class="fa fa-trash" aria-hidden="true"></i></a>';
            return $item;
        });

        return response()->json(['data' => $gallery_list]);
    }

    public function edit($id)
    {
        $gallery = ProjectGallery::findOrFail($id);
        $multiImage = GalleryImage::where('project_galleries_id', $id)->where('deleted_at', null)->get();
        $image_name = MediaImage::where('id' ,$gallery->featured_img)->first();
        $banner_image_name = MediaImage::where('id' ,$gallery->banner_image)->first();

        $galleryCategories = GalleryCategory::select('*')->where('parent_category', 0)->where('deleted_at', null)->get();
        return view('gallery.add', compact('gallery', 'multiImage', 'image_name', 'galleryCategories', 'banner_image_name'));
    }

    public function check_slug(Request $request){
        $check = ProjectGallery::where('title', $request->title)->first();
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

    
    public function image_remove(Request $request) {
        $img_id = $request->img_id;
        $gallery_id = $request->gallery_id;

        if ($img_id != "") {
          
            $record = GalleryImage::find($img_id);
            $record->delete();

            $gallery_list = GalleryImage::select('*')->where('project_galleries_id', $gallery_id)->where('deleted_at', null)->get();
            if(isset($gallery_list) && $gallery_list != ""){
                $response['status'] = 1;
                $response['gallery_list'] = $img_id;
            }else{
                $response['status'] = 0;
                $response['gallery_list'] = "";
            }
          
            return response()->json($response);
        }
       
        
    }
    public function publish_status(Request $request) {
        $id = $request->id;
        $response['status'] = 0;
        $response['message'] = "Check Status canceled";
      

        if (isset($request->isChecked) && $request->isChecked != 'true') {
            $data['is_publish'] = 0;
            $save = ProjectGallery::where('id', $id)->update($data);
            $response['status'] = 1;
            $response['message'] = "Publish Status Update Successfully";

        } else {
            $data['is_publish'] = 1;
            $save = ProjectGallery::where('id', $id)->update($data);
            $response['status'] = 2;
            $response['message'] = "Publish Status Update Successfully";

        }
        return response()->json($response);
    }
    public function featured_status(Request $request) {
        $id = $request->id;
        $response['status'] = 0;
        $response['message'] = "Check Status canceled";
      

        if (isset($request->isChecked) && $request->isChecked != 'true') {
            $data['is_featured'] = 0;
            $save = ProjectGallery::where('id', $id)->update($data);
            $response['status'] = 1;
            $response['message'] = "Featured Status Update Successfully";

        } else {
            $data['is_featured'] = 1;
            $save = ProjectGallery::where('id', $id)->update($data);
            $response['status'] = 2;
            $response['message'] = "Featured Status Update Successfully";

        }
        return response()->json($response);
    }

    public function delete($id) {
        if ($id != "") {
            $record = ProjectGallery::find($id);
            $image_delete = GalleryImage::where('project_galleries_id', $id)->delete();
            $record->delete();
            return redirect()->route('gallery.index')
                ->withSuccess('Gallery Delete Successfully.');

        }
    }

    public function gallery_category_slug(Request $request) {
        $check = GalleryCategory::where('category', $request->category)->first();
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

    public function gallery_create_category(Request $request) {
        $categories = GalleryCategory::where('category', $request->gallery_category)->first();
        if(isset($categories) && $categories != null && $categories != '')
        {
            return response()->json(['status' => '1', 'message' => 'Category is already exists!']);
        }
        // $slug = Str::slug($request->gallery_category);
        $slug = SlugService::createSlug(GalleryCategory::class, 'slug', $request->gallery_slug);
        $new_cat = new GalleryCategory();
        $new_cat->category = $request->gallery_category;
        $new_cat->slug = $slug;
        $new_cat->parent_category = isset($request->parent_category) ? $request->parent_category : '' ;
        $new_cat->sub_category = isset($request->parent_category) ? $request->parent_category : '' ;


        $new_cat->save();
        if($new_cat)
        {
            return response()->json(['status' => '0', 'message' => 'Category added successfully', 'newCategory' => $new_cat]);
        }
    }


}