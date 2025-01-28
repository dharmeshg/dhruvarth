<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductService;
use App\Models\MediaImage;
use App\Models\Updatelog;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Support\Str;


class ProductsServicesController extends Controller
{
    public function index()
    {
        return view('products-services.index');
    }
    public function add() {
        return view('products-services.addExample');
    }

    public function store(Request $request) {
        
        $id = $request->products_services_id;
       

        if ($id != "") {
            $check = ProductService::where('slug', $request->product_Slug)->first();
            if (isset($check->id) && $id != $check->id) {
                $slug = SlugService::createSlug(ProductService::class, 'slug', $request->product_Slug);
            }else{
                $slug_update = $request->product_Slug;
                $slug = Str::slug($slug_update, '-');
            }
         
            $product_services = ProductService::findOrfail($id);
            $edata = json_encode($product_services);
            $product_services->sub_title = isset($request->sub_title) ? $request->sub_title : '';
            $product_services->slug = $slug;
            $product_services->title = isset($request->title) ? $request->title : '';
            $product_services->price = isset($request->price) ? $request->price : '';
            $product_services->short_description = isset($request->short_description) ? $request->short_description : '';
            $product_services->description =  isset($request->description) ?  $request->description : '';
            $product_services->address = isset($request->address) ? $request->address : '';
            $product_services->meta_title = isset($request->meta_title) ? $request->meta_title : '';
            $product_services->meta_keyword = isset($request->meta_keyword) ? $request->meta_keyword : '';
            $product_services->meta_description = isset($request->meta_description) ? $request->meta_description : '';
            $product_services->image = isset($request->img_id) ? $request->img_id : '';
            $product_services->banner_image = isset($request->banner_img_id) ? $request->banner_img_id : '';
            $product_services->page_index = isset($request->page_index) ? $request->page_index : 'on';
            $product_services->canonical_url = isset($request->canonical_url) ? $request->canonical_url : null;
           
            $product_services->update();

            $edt = Updatelog::create(['tablename'=>'product-services','table_primary_id'=>$product_services->id,'edit_log'=>$edata]);
            return redirect()->route('products-services')->with('success','Products Services update Successfully.');
        }else{
            $slug = SlugService::createSlug(ProductService::class, 'slug', $request->product_Slug);
            $product_services = new ProductService();
            $product_services->sub_title = isset($request->sub_title) ? $request->sub_title : '';
            $product_services->slug = $slug;

            $product_services->title = isset($request->title) ? $request->title : '';
            $product_services->price = isset($request->price) ? $request->price : '';
            $product_services->short_description = isset($request->short_description) ? $request->short_description : '';
            $product_services->description =  isset($request->description) ?  $request->description : '';
            $product_services->address = isset($request->address) ? $request->address : '';
            $product_services->meta_title = isset($request->meta_title) ? $request->meta_title : '';
            $product_services->meta_keyword = isset($request->meta_keyword) ? $request->meta_keyword : '';
            $product_services->meta_description = isset($request->meta_description) ? $request->meta_description : '';
            $product_services->page_index = isset($request->page_index) ? $request->page_index : 'on';
            $product_services->canonical_url = isset($request->canonical_url) ? $request->canonical_url : null;
            $product_services->image = isset($request->img_id) ? $request->img_id : '';
            $product_services->banner_image = isset($request->banner_img_id) ? $request->banner_img_id : '';

            $product_services->save();
            return redirect()->route('products-services')->with('success','Products Services Added Successfully.');
        }
      
    }

    public function list(Request $request) {
        $product_services_list = ProductService::select('*')->where('deleted_at', null)->get();

        $counter = 1;
        $product_services_list->transform(function ($item) use (&$counter) {
            $item['ser_id'] = $counter++;
            if (isset($item['image']) && $item['image'] != '') {
                $image_name = MediaImage::where('id' ,$item['image'])->first();
            
                $item['image'] = '<img src="' . asset('uploads/' . $image_name->name) . '" class="img-fluid white_logo rounded-circle" alt="" style="width:50px;height:50px;">';
            } else {
                $item['image'] = '<img src="' . asset('assets/img/img-demo_1041.jpg') . '" class="img-fluid white_logo rounded-circle" alt="" style="width:50px;height:50px;">';
            }
            $item['action'] = '<a class="label theme-bg2 text-white f-12 tags_edit" data-id="' . $item['id'] . '" href="' . route('products_services.edit', $item['id']) . '"><i class="fa fa-edit"></i></a>';
            $item['action'] .= '<a data-href="' . route('products_services.delete', $item['id']) . '" data-title="testrete" data-original-title="Delete Tags" class="label theme-bg text-white f-12 product_delete"><i class="fa fa-trash" aria-hidden="true"></i></a>';
            return $item;

        });
        return response()->json(['data' => $product_services_list]);
    }

    public function edit($id) {
        $products_services = ProductService::findOrFail($id);
     
        $image_name = MediaImage::where('id' ,$products_services->image)->first();

        $banner_image = MediaImage::where('id' ,$products_services->banner_image)->first();
        // return view('products-services.addExample');
        return view('products-services.addExample', compact('products_services','image_name','banner_image'));
    }

    public function delete($id) {
        if ($id != "") {
            $record = ProductService::find($id);
            $record->delete();
            return redirect()->route('products-services')
                ->withSuccess('Products Services Delete Successfully.');
        }
    }

    public function check_slug(Request $request){
        $check = ProductService::where('sub_title', $request->name)->first();
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
