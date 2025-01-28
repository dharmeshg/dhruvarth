<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Family;
use App\Models\Occasion;
use App\Models\Trend;
use App\Models\Country;
use App\Models\MetalPurity;
use App\Models\Metal;
use App\Models\MetalRate;
use App\Models\Product;
use App\Models\DeliveryZip;
use App\Models\ProductImage;
use App\Models\Designe;
use App\Models\Style;
use App\Models\OldSlug;
use App\Models\Tags;
use App\Models\DynamicDiamondType;
use App\Models\DiamondRate;
use App\Models\Setting;
use App\Models\Citie;
use App\Models\Order;
use App\Models\Cart;
use App\Models\WishList;
use App\Models\OrderItems;
use App\Models\ProductAttribute;
use App\Models\VariantProduct;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use Illuminate\Support\Str;
use DateTime;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class VariantProductController extends Controller
{
    public function index()
    {
        if (isset($_GET['type']) && $_GET['type'] != '') {
            $gemstone = $_GET['type'];
        }else{
                $gemstone = "";
        }
        $categories = Category::all();
        $families = Family::all();
        $v_products = Product::all();
        $parent_ids = VariantProduct::pluck('parent_product_id')->toArray();
        $parent_products = Product::whereIn('id',$parent_ids)->get();
        return view('products.variantsindex',compact('categories','gemstone','families','v_products','parent_products'));
    }
    public function list(Request $request)
    {
     
        // dd($request->all());
        $perPage = $request->input('length', 10);
        $page = $request->input('start', 0) / $perPage;
        $query = VariantProduct::select('*');

        if(isset($request->search_text) && $request->search_text != '')
        {
            $searchText = $request->search_text;

            $query->where(function($query) use ($searchText) {
                $query->where('p_title', 'like', '%'.$searchText.'%')
                    ->orWhere('p_sku', 'like', '%'.$searchText.'%')
                    ->orWhereHas('category', function($query) use ($searchText) {
                        $query->where('category', 'like', '%'.$searchText.'%');
                    })
                    ->orWhereHas('family', function($query) use ($searchText) {
                        $query->where('family', 'like', '%'.$searchText.'%');
                    })
                    ->orWhereHas('parent', function($query) use ($searchText) {
                        $query->where('p_sku', 'like', '%'.$searchText.'%');
                    });
            });
        }
        if ($request->status != "2") {
            if($request->status == 'sold_out')
            {
                $query->where('p_avail_stock_qty',0);
            }else{
                $query->where('p_status',$request->status);
            }
            
        }
        if ($request->category != "all") {
            $query->where('p_category',$request->category);
        }
        if ($request->family != "all") {
            $query->where('p_family',$request->family);
        }
        if ($request->visibility != "2") {
            if ($request->visibility == 'enable') {
                $query->where('visiblity', 1);
            } else {
                $query->where(function($query) {
                    $query->where('visiblity', 0)
                          ->orWhereNull('visiblity');
                });
            }
        }
        
        if ($request->public_status != "2") {
            if ($request->public_status == 'enable') {
                $query->where('is_public', 1);
            } else {
                $query->where(function($query) {
                    $query->where('is_public', 0)
                          ->orWhereNull('is_public');
                });
            }
        }
        if (isset($request->tag) && $request->tag != '') {
            $query->where('p_tags', 'like', '%' . $request->tag . '%');
        }
        if ($request->parent_product != "all") {
            $query->where('parent_product_id',$request->parent_product);
        }
        $totalRecords = $query->count();
        $product_list = $query->with(['parent','category'])
                            ->latest()
                            ->skip($page * $perPage)
                            ->take($perPage)
                            ->get();
        $counter = $page * $perPage + 1;
        $product_list->transform(function ($item) use (&$counter, &$request) {
            $item['ser_id'] = $counter++;

            $p_image = ProductImage::where('product_id',$item['id'])->where('type','variant')->first();
            if(isset($p_image) && $p_image != '' && $p_image != null)
            {
                if(isset($item['db_status']) && $item['db_status'] != '' && $item['db_status'] != null && $item['db_status'] == 'manually')
                {
                    $frst_path = base_path('public/product_media/product_images/300/'.$p_image->name);
                  
                    if(file_exists($frst_path))
                        $path = asset('product_media/product_images/300/'.$p_image->name);
                    else
                        $path = asset('product_media/product_images/'.$p_image->name);
                }else{
                    $path = asset('uploads/'.$p_image->name);
                }
                
            }else{
                $path = asset('assets/images/user/img-demo_1041.jpg');
            }
            
            $item['p_title_div'] = '<div class="p_details"><img src="'.$path.'"><p>'.(isset($item['p_title']) ? $item['p_title'] : '-').'</p></div>';
            
            $item['parent_sku'] = isset($item->parent->p_sku) ? $item->parent->p_sku : '-';

            $item['cat'] = isset($item->category->category) ? $item->category->category : '-';

            $item['fam'] = isset($item->family->family) ? $item->family->family : '-';

            $item['price'] = '&#x20B9; '.number_format($item->total_price($item['id'], 2, '.', ','));

            if(isset($item->publish_status) && $item->publish_status == 'draft')
            {
                $item['d_status'] = 'Draft';
            }else{
                $item['d_status'] = 'Published';
            }

            // $item['price'] = '&#x20B9; '. . (isset($item['p_grand_price_total']) ? number_format($item['p_grand_price_total'], 2, '.', ',') : 0) ;

            // $item['p_status'] = isset($item['p_status']) && $item['p_status'] == 'ready_stock' ? 'Ready Stock' : 'By Order';

            if($request->status == 'sold_out')
            {
                 $item['p_status'] = 'Sold Out';
            }else{
                $item['p_status'] = isset($item['p_status']) && $item['p_status'] == 'ready_stock' ? 'Ready Stock' : 'By Order';
            } 
            if ($item['visiblity'] == '1') {
                $item['visiblity'] = '<input type="checkbox" data-id="' . $item['id'] . '" data-type="variant" data-toggle="toggle" id="visiblity"  checked class="is_featured_class">';
            } else {
                $item['visiblity'] = '<input type="checkbox" data-id="' . $item['id'] . '" data-type="variant" data-toggle="toggle" id="visiblity"  class="is_featured_class">';
            }
            if ($item['is_public'] == '1') {
                $item['public_private'] = '<input type="checkbox" data-id="' . $item['id'] . '" data-type="variant" data-toggle="toggle" id="public_private" checked class="is_featured_class">';
            }else{
                $item['public_private'] = '<input type="checkbox" data-id="' . $item['id'] . '" data-type="variant" data-toggle="toggle" id="public_private"  class="is_featured_class">';
            }
            $item['attribute'] = '<button class="btn table-filter-btn edit_attribute" type="button" data-id="' . $item['id'] . '" data-attr-id="' . $item['attr_id'] . '">Edit Attribute</button>';
            $item['action'] = '<div class="action_div"><a href="' . route('product.edit', ['id' => $item['id'], 'slug' => 'variant']) . '" class="table-btn table-btn1 edit" data-id="' . $item['id'] . '" title="Click here to Edit Product" style="margin-right: 5px;"><img src="'.asset('images/dashbord/create.png').'" class="image-fuild" alt="user-img"></a>';
            $item['action'] .= '<a href="javascript:;" data-href="' . route('product.delete', ['id' => $item['id'], 'slug' => 'variant']) . '" class="table-btn table-btn1 delete" style="margin-right: 5px;"><img src="'.asset('images/dashbord/delete.png').'" title="Click here to Delete Product" class="image-fuild" alt="user-img"></a>';
            $item['action'] .= '<a href="javascript:;" data-href="' . route('product.remove.variant', ['id' => $item['id'], 'slug' => 'variant']) . '" class="table-btn table-btn1 remove_variant"><img src="'.asset('images/dashbord/remove.png').'" title="Click here to Remove product From Variant" class="image-fuild" alt="user-img"></a></div>';
            return $item;
        });
        
        return response()->json([
        'draw' => $request->input('draw'),
        'recordsTotal' => $totalRecords,
        'recordsFiltered' => $totalRecords, // For simplicity, assuming no filtering is applied
        'data' => $product_list,
    ]);
    }

    public function remove_variant($id, $slug)
    {
        // dd([$id, $slug]);
        $variant_p = VariantProduct::where('id',$id)->first();
        if ($variant_p) {
            $attributes = $variant_p->getAttributes();
            unset($attributes['parent_product_id'], $attributes['attr_id']);
            $product = new Product();
            $product->fill($attributes);
            $product->save();
            $product_images = ProductImage::where('product_id',$variant_p->id)->where('type','variant')->update(['product_id' => $product->id,'type' => 'simple']);
            $carts = Cart::where('product_id',$variant_p->id)->where('product_type','variant')->update(['product_id' => $product->id,'product_type' => 'simple']);
            $wishlists = WishList::where('product_id',$variant_p->id)->where('product_type','variant')->update(['product_id' => $product->id,'product_type' => 'simple']);
            $order_items = OrderItems::where('product_id',$variant_p->id)->where('product_type','variant')->update(['product_id' => $product->id,'product_type' => 'simple']);
            $va_attributes = ProductAttribute::where('id',$variant_p->attr_id)->delete();
            $variant_p->delete();
            return redirect()->route('variant.index')->with('success','Variant Removed Successfully!');
        } else {
            return redirect()->route('variant.index')->with('error','Something Went Wrong!');
        }
    }
    
    public function edit_variant(Request $request)
    {
        if(isset($request->attr_id) && $request->attr_id != null && $request->attr_id != '')
        {
            $attribute = ProductAttribute::findOrfail($request->attr_id);
            if(isset($attribute) && $attribute->attributes != null && $attribute->attributes != '')
            {
                $data['id'] = $attribute->id;
                $attr_arr = explode(',',$attribute->attributes);
                if(in_array('metal_purity',$attr_arr))
                {
                    $data['purity'] = 'yes';
                }else{
                    $data['purity'] = 'no';
                }
                if(in_array('metal_wieght',$attr_arr))
                {
                    $data['metal_wieght'] = 'yes';
                }else{
                    $data['metal_wieght'] = 'no';
                }
                if(in_array('metal_color',$attr_arr))
                {
                    $data['metal_color'] = 'yes';
                }else{
                    $data['metal_color'] = 'no';
                }
                if(in_array('size',$attr_arr))
                {
                    $data['size'] = 'yes';
                }else{
                    $data['size'] = 'no';
                }
                if(in_array('gender',$attr_arr))
                {
                    $data['gender'] = 'yes';
                }else{
                    $data['gender'] = 'no';
                }
                return response()->json(['status' => 1 , 'data' => $data ?? null]);
            }else{
                return response()->json(['status' => 0 ,'message' => 'Something Went Wrong!']);
            }
        }else{
            return response()->json(['status' => 0 ,'message' => 'Something Went Wrong!']);
        }
    }
    public function update_variant(Request $request)
    {
        if(isset($request->attribute_id) && $request->attribute_id != null && $request->attribute_id != '')
        {
            $attribute = ProductAttribute::findOrfail($request->attribute_id);
            if(isset($attribute) && $attribute != null)
            {
                $n_attributes = implode(',',$request->main_attr);
                $attribute->attributes = isset($n_attributes) ? $n_attributes : null;
                $attribute->save();
                return response()->json(['status' => 1,'message' => 'Attributes Updated Successfully']);
            }else{
                return response()->json(['status' => 0,'message' => 'Attributes not found!']);
            }
        }else{
            return response()->json(['status' => 0,'message' => 'Attributes not found!']);
        }
    }
}
