<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use App\Models\Updatelog;
use App\Models\Family;
use App\Models\Sections;
use App\Models\Article;
use App\Models\MediaImage;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Redirect;
use Illuminate\Support\Str;



class FamilyController extends Controller
{
    public function index()
    {

        $category_list = Family::with('parent')->with('categoryList')->get();
        $sections = Sections::select('title', 'id')->where('deleted_at', null)->get();

        $categories = Family::select('*')->where('parent_category', 0)->where('deleted_at', null)->orderby('category', 'asc')->get();

        // $category_list = Category::with('parent')->with('categoryList')->get();

        return view('families.index')->with(compact('categories', 'sections', 'category_list'));
    }

    public function save(Request $request)
    {
        // dd($request->all());
        $id = $request->category_id;

        if ($id != '') {
            $category = Family::findOrfail($id);
            $edata = json_encode($category);
            if (isset($request->parent_category) && $request->parent_category > 0) {
                $sub_category = Family::where('id', $request->parent_category)->first();
                $sub_category = $sub_category->parent_category;
            } else {
                $sub_category = $id;
            }
            $check = Family::where('slug', $request->slug)->first();
        
            if (isset($check) && $id != $check->id) {
                $slug = SlugService::createSlug(Family::class, 'slug', $request->slug);
            }else{
                $slug_update = $request->slug;
                $slug = Str::slug($slug_update, '-');
            }
            $category->category = $request->name;
            $category->slug = $slug;
            $category->parent_category = isset($request->parent_category) ? $request->parent_category : null;
            $category->description = isset($request->description) ? $request->description : null;
            $category->image = isset($request->cat_img) ? $request->cat_img : null;
            $category->sub_category = $sub_category;
            $category->update();
            $edt = Updatelog::create(['tablename'=>'categories','table_primary_id'=>$category->id,'edit_log'=>$edata]);
            return redirect()->route('families')->with('success', 'Family successfully Update.');
        } else {

            $slug = SlugService::createSlug(Family::class, 'slug', $request->slug);
            $category = new Family();
            $category->category = $request->name;
            $category->slug = $slug;
            $category->parent_category = isset($request->parent_category) ? $request->parent_category : null;
            $category->description = isset($request->description) ? $request->description : null;
            $category->image = isset($request->cat_img) ? $request->cat_img : null;
            $category->sub_category = $request->parent_category;
            $category->save();

            return redirect()->route('families')->with('success', 'Family successfully Submit.');
        }

    }

    public function delete($id)
    {
        if ($id != "") {

            $articles = Article::where('deleted_at', null)
                ->where('category_id', 'like', '%' . $id . '%')
                ->get();
            if (isset($articles) && count($articles) != 0) {
                return redirect()->intended('/admin/categories')->withError('Can not delete category, some Articles are available for this category!');
            } else {
                $record = Family::find($id);
                $update_pre_category['parent_category'] = $record->parent_category;
                Family::where('parent_category', $id)->update($update_pre_category);
                $record->delete();
                return redirect()->route('families')->with('error', 'Family deleted successfully');
            }

        }
    }

    public function edit(Request $request)
    {
        $id = $request->id;
        if ($id) {
            $data = Family::where('id', $id)->first();
            $data['categories'] = Family::select('*')->where('sub_category', $data->parent_category)->where('deleted_at', null)->get();
            $data['image_data'] = MediaImage::where('id',$data->image)->first();
            if(isset($data['image_data']->name) && $data['image_data']->name != null && $data['image_data']->name != '')
            {
                $data['url'] = asset('uploads/'.$data['image_data']->name);
            }else{
                $data['url'] = asset('assets/images/user/img-demo_1041.jpg');
            }
            return json_encode($data);
        }
    }
    public function list()
    {
        $category_list = Family::with('parent')->with('categoryList')->get();

        $counter = 1;
        $category_list->transform(function ($item) use (&$counter) {

            if (isset($item->parent) && $item->parent != "") {
                $pare_category = $item->parent;
                $item['parent_category'] = $pare_category->category;
            } else {
                $item['parent_category'] = "-";
            }
            if (isset($item->categoryList) && $item->categoryList != "") {
                $pare_category = $item->categoryList;
                $item['sections'] = $pare_category->title;
            } else {
                $item['sections'] = "-";
            }


            $item['ser_id'] = $counter++;
            if ($item['status'] == '1') {
                $item['status'] = '<input type="checkbox" class="is_featured_class" data-id="' . $item['id'] . '"  id="is_featured" name="is_featured" checked>';
            } else {
                $item['status'] = '<input type="checkbox" class="is_featured_class" data-id="' . $item['id'] . '" id="is_featured" name="is_featured">';
            }
            $item['action'] = '<a href="javascript:;" class=" table-btn table-btn1 mx-2 edit" data-id="' . $item['id'] . '"><img src="'.asset('images/dashbord/create.png').'" class="image-fuild" alt="user-img"></a>';
            $item['action'] .= '<a href="javascript:;" data-href="' . route('family.delete', $item['id']) . '" data-title="testrete" data-original-title="Delete Family" class="table-btn table-btn1 delete"><img src="'.asset('images/dashbord/delete.png').'" class="image-fuild" alt="user-img"></a>';
            return $item;
        });

        return response()->json(['data' => $category_list]);
    }

    public function check_featured(Request $request)
    {
        $id = $request->id;
        $response['status'] = 0;
        $response['message'] = "Check Featured canceled";
      

        if (isset($request->isChecked) && $request->isChecked != 'true') {
            $data['status'] = 0;
            $save = Family::where('id', $id)->update($data);
            $response['status'] = 1;
            $response['message'] = "Family Disabled Successfully";

        } else {
            $data['status'] = 1;
            $save = Family::where('id', $id)->update($data);
            $response['status'] = 2;
            $response['message'] = "Family Enabled Successfully";

        }
        return response()->json($response);
    }

    public function check_slug(Request $request)
    {
        $check = Family::where('category', $request->name)->first();
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


     public function test_index()
    {

        $category_list = Family::with('parent')->with('categoryList')->get();
        $sections = Sections::select('title', 'id')->where('deleted_at', null)->get();

        $categories = Family::select('*')->where('parent_category', 0)->where('deleted_at', null)->orderby('category', 'asc')->get();

        // $category_list = Category::with('parent')->with('categoryList')->get();

        return view('categories.index_test')->with(compact('categories', 'sections', 'category_list'));
    }

    public function test_list()
    {
        $category_list = Family::with('parent')->with('categoryList')->get();

        $counter = 1;
        $category_list->transform(function ($item) use (&$counter) {

            if (isset($item->parent) && $item->parent != "") {
                $pare_category = $item->parent;
                $item['parent_category'] = $pare_category->category;
            } else {
                $item['parent_category'] = "-";
            }
            if (isset($item->categoryList) && $item->categoryList != "") {
                $pare_category = $item->categoryList;
                $item['sections'] = $pare_category->title;
            } else {
                $item['sections'] = "-";
            }


            $item['ser_id'] = $counter++;
            if ($item['status'] == '1') {
                $item['status'] = '<input type="checkbox" class="is_featured_class" data-id="' . $item['id'] . '"  id="is_featured" name="is_featured" checked>';
            } else {
                $item['status'] = '<input type="checkbox" class="is_featured_class" data-id="' . $item['id'] . '" id="is_featured" name="is_featured">';
            }
            $item['action'] = '<a class="label theme-bg2 text-white f-12 table-btn table-btn1 edit" data-id="' . $item['id'] . '"><i class="fa fa-edit"></i></a>';
            $item['action'] .= '<a data-href="' . route('category.delete', $item['id']) . '" data-title="testrete" data-original-title="Delete category" class="label theme-bg text-white f-12 table-btn table-btn1 delete"><i class="fa fa-trash" aria-hidden="true"></i></a>';
            return $item;
        });

        return response()->json(['data' => $category_list]);
    }
}