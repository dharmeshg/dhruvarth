<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Family;
use App\Models\MetalPurity;
use App\Models\ProductImage;
use App\Models\MetalRate;
use App\Models\Cart;
use App\Models\WishList;
use App\Models\Occasion;
use App\Models\Tags;
use App\Models\PageBanner;
use App\Models\Gender;
use App\Models\ProductAttribute;
use App\Models\VariantProduct;
use App\Models\OldSlug;
use App\Models\PromoCode;
use App\Models\Setting;
use Auth;
use Illuminate\Support\Arr;
use Carbon\Carbon;
use App\Helpers\ProductHelper;
use DB;

class ProductController extends Controller
{
    public function all_products()
    {
        $products = Product::where('visiblity',1)->where(function ($query) {
                      $query->where('publish_status', '!=', 'draft')
                            ->orWhereNull('publish_status');
                  })->latest()->get();
        $catagories = Category::orderBy('category', 'asc')->get();
        $families = Family::all();
        $purities = MetalPurity::all();
        $genders = Gender::all();
        $page_banners = PageBanner::latest()->get();
        $SEOController = new SEOController();
        $SEOTitleDescription = $SEOController->_seoTitleDescriptionProductList();
        $SEOSchemaCode = $SEOController->_seoSchemaCodeProductList();
        return view('front.all_products',compact('products','catagories','families','purities','SEOTitleDescription','page_banners','SEOSchemaCode','genders'));
    }
    public function page_products(Request $request)
    {
        // dd($request->all());
        $perPage = 8;
        $currentPage = $request->input('currentPage', 1);
        $skip = ($currentPage - 1) * $perPage;
        $products = Product::skip($skip)->take($perPage)->where('visiblity',1)->where(function ($query) {
                      $query->where('publish_status', '!=', 'draft')
                            ->orWhereNull('publish_status');
                  })->latest()->get();
        $html = view('front.include.ajax-product-page', compact('products'))->render();
        return response()->json(['status' => 1 , 'html' => $html]);
    }
    public function cat_products($cat=null,$fam=null)
    {
        $category = Category::where('slug',$cat)->first();
        $family = Family::where('slug',$fam)->first();
        $catagories = Category::all();
        $families = Family::all();
        $purities = MetalPurity::all();
        if(!$category)
        {
            return redirect()->route('home');
        }
        $query = Product::query();
        if(isset($category) && $category != '' && $category != null)
        {
            $query->where('p_category',$category->id);
        }
        if(isset($family) && $family != '' && $family != null)
        {
            $query->where('p_family', $family->id);
        }
        if(isset($purity) && $purity != null && $purity != '')
        {
            $query->where('p_metal_purity', $purity->id);
        }
        if(isset($gender) && $gender != null && $gender != '')
        {
            $query->where('p_gender', $gender);
        }
        if(isset($cat) && $cat != '' && $cat != null)
        {
            $SEOController = new SEOController();
            $SEOTitleDescription = $SEOController->_seoTitleDescriptionProductCategoryList($category->category);
            $SEOSchemaCode = $SEOController->_seoSchemaCodeProductPFDetailsBreadcrumbList($category->category);
        }
        if(isset($fam) && $fam != '' && $fam != null)
        {
            $SEOController = new SEOController();
            $SEOTitleDescription = $SEOController->_seoTitleDescriptionProductFamilyList($family->family);
            $SEOSchemaCode = $SEOController->_seoSchemaCodeProductPFDetailsBreadcrumbList($family->family);
        }
        $products = $query->where('visiblity',1)->where(function ($query) {
                      $query->where('publish_status', '!=', 'draft')
                            ->orWhereNull('publish_status');
                  })->latest()->get();

        return view('front.all_products',compact('products','catagories','families','purities','category','family','SEOTitleDescription','SEOSchemaCode'));
    } 
    public function attr_products($cat,$gender=null)
    {
        // dd($gender);
        $category = Category::where('slug',$cat)->first();
        $catagories = Category::all();
        $families = Family::all();
        $purities = MetalPurity::all();
        $query = Product::query();
        if(!$category)
        {
            return redirect()->route('home');
        }
        $check_gender = Gender::where('title',trim($gender))->first();
        if(!$check_gender)
        {
            return redirect()->route('home');
        }
        if(isset($category) && $category != '' && $category != null)
        {
            $query->where('p_category',$category->id);
        }
        if(isset($gender) && $gender != null && $gender != '')
        {
            $query->where('p_gender', $gender);
        }
        $products = $query->where('visiblity',1)->where(function ($query) {
                      $query->where('publish_status', '!=', 'draft')
                            ->orWhereNull('publish_status');
                  })->latest()->get();
        $SEOController = new SEOController();
        $SEOTitleDescription = $SEOController->_seoTitleDescriptionProductGenderList($gender);
        $SEOSchemaCode = $SEOController->_seoSchemaCodeProductPFDetailsBreadcrumbList($gender);
        return view('front.all_products',compact('products','catagories','families','purities','category','gender','SEOTitleDescription','SEOSchemaCode'));
    }
    public function gender_products($gender)
    {
        // dd($gender);
        $catagories = Category::all();
        $families = Family::all();
        $purities = MetalPurity::all();
        $check_gender = Gender::where('title',trim($gender))->first();
        if(!$check_gender)
        {
            return redirect()->route('home');
        }
        $query = Product::query();
        if(isset($gender) && $gender != null && $gender != '')
        {
            $query->where('p_gender', $gender);
        }
        $products = $query->where('visiblity',1)->where(function ($query) {
                      $query->where('publish_status', '!=', 'draft')
                            ->orWhereNull('publish_status');
                  })->latest()->get();
        $SEOController = new SEOController();
        $SEOTitleDescription = $SEOController->_seoTitleDescriptionProductGenderList($gender);
        $SEOSchemaCode = $SEOController->_seoSchemaCodeProductPFDetailsBreadcrumbList($gender);
        return view('front.all_products',compact('products','catagories','families','purities','gender','SEOTitleDescription','SEOSchemaCode'));
    }
    public function occasion_products($occasion)
    {
        $p_occasion = Occasion::where('slug',$occasion)->first();
        if(!$p_occasion)
        {
            return redirect()->route('home');
        }
        $catagories = Category::all();
        $families = Family::all();
        $purities = MetalPurity::all();
        $query = Product::query();
        if(isset($p_occasion) && $p_occasion != '' && $p_occasion != null)
        {
            $query->where('p_occasion',$p_occasion->id);
        }
        $products = $query->where('visiblity',1)->where(function ($query) {
                      $query->where('publish_status', '!=', 'draft')
                            ->orWhereNull('publish_status');
                  })->latest()->get();
        $SEOController = new SEOController();
        $SEOTitleDescription = $SEOController->_seoTitleDescriptionProductOccasionList($p_occasion->title);
        $SEOSchemaCode = $SEOController->_seoSchemaCodeProductPFDetailsBreadcrumbList($p_occasion->title);
        return view('front.all_products',compact('products','catagories','families','purities','SEOTitleDescription','SEOSchemaCode'));
    }
    public function cat_occasion_products($cat,$occasion)
    {
        // dd($gender);
        $category = Category::where('slug',$cat)->first();
        if(!$category)
        {
            return redirect()->route('home');
        }
        $p_occasion = Occasion::where('slug',$occasion)->first();
        if(!$p_occasion)
        {
            return redirect()->route('home');
        }
        $catagories = Category::all();
        $families = Family::all();
        $purities = MetalPurity::all();
        $query = Product::query();
        if(isset($category) && $category != '' && $category != null)
        {
            $query->where('p_category',$category->id);
        }
        if(isset($p_occasion) && $p_occasion != '' && $p_occasion != null)
        {
            $query->where('p_occasion',$p_occasion->id);
        }
        $products = $query->where('visiblity',1)->where(function ($query) {
                      $query->where('publish_status', '!=', 'draft')
                            ->orWhereNull('publish_status');
                  })->latest()->get();
        $SEOController = new SEOController();
        $SEOTitleDescription = $SEOController->_seoTitleDescriptionProductOccasionList($p_occasion->title);
        $SEOSchemaCode = $SEOController->_seoSchemaCodeProductPFDetailsBreadcrumbList($p_occasion->title);
        return view('front.all_products',compact('products','catagories','families','purities','category','SEOTitleDescription','SEOSchemaCode'));
    }
     public function caret_products($purity)
    {
        $catagories = Category::all();
        $families = Family::all();
        $purities = MetalPurity::all();
        $purity = MetalPurity::where('slug',$purity)->first();
        if(!$purity)
        {
            return redirect()->route('home');
        }
        $query = Product::query();
        if(isset($category) && $category != '' && $category != null)
        {
            $query->where('p_category',$category->id);
        }
        if(isset($purity) && $purity != null && $purity != '')
        {
            $query->where('p_metal_purity', $purity->id);
        }
        $products = $query->where('visiblity',1)->where(function ($query) {
                      $query->where('publish_status', '!=', 'draft')
                            ->orWhereNull('publish_status');
                  })->latest()->get();
        $SEOController = new SEOController();
        $SEOTitleDescription = $SEOController->_seoTitleDescriptionProductKaratList($purity->title);
        $SEOSchemaCode = $SEOController->_seoSchemaCodeProductPFDetailsBreadcrumbList($purity->title);
        return view('front.all_products',compact('products','catagories','families','purities','purity','SEOTitleDescription','SEOSchemaCode'));
    }
    public function purity_products($cat,$purity=null)
    {
        $category = Category::where('slug',$cat)->first();
        if(!$category)
        {
            return redirect()->route('home');
        }
        $catagories = Category::all();
        $families = Family::all();
        $purities = MetalPurity::all();
        $purity = MetalPurity::where('slug',$purity)->first();
        if(!$purity)
        {
            return redirect()->route('home');
        }
        $query = Product::query();
        if(isset($category) && $category != '' && $category != null)
        {
            $query->where('p_category',$category->id);
        }
        if(isset($purity) && $purity != null && $purity != '')
        {
            $query->where('p_metal_purity', $purity->id);
        }
        $products = $query->where('visiblity',1)->where(function ($query) {
                      $query->where('publish_status', '!=', 'draft')
                            ->orWhereNull('publish_status');
                  })->latest()->get();
        $SEOController = new SEOController();
        $SEOTitleDescription = $SEOController->_seoTitleDescriptionProductKaratList($purity->title);
        $SEOSchemaCode = $SEOController->_seoSchemaCodeProductPFDetailsBreadcrumbList($purity->title);
        return view('front.all_products',compact('products','catagories','families','purities','category','purity','SEOTitleDescription','SEOSchemaCode'));
    }
    public function family_products($fam)
    {
        $catagories = Category::all();
        $families = Family::all();
        $purities = MetalPurity::all();
        $query = Product::query();
        $family = Family::where('slug',$fam)->first();
        if(!$family)
        {
            return redirect()->route('home');
        }
        if(isset($family) && $family != '' && $family != null)
        {
            $query->where('p_family',$family->id);
        }
        $products = $query->where('visiblity',1)->where(function ($query) {
                      $query->where('publish_status', '!=', 'draft')
                            ->orWhereNull('publish_status');
                  })->latest()->get();
        $SEOController = new SEOController();
        $SEOTitleDescription = $SEOController->_seoTitleDescriptionProductFamilyList($family->family);
        $SEOSchemaCode = $SEOController->_seoSchemaCodeProductPFDetailsBreadcrumbList($family->family);
        return view('front.all_products',compact('products','catagories','families','purities','family','SEOTitleDescription','SEOSchemaCode'));
    }
    public function tags($slug)
    {
        $tag = Tags::where('slug',$slug)->first();
        if(isset($tag) && $tag != null)
        {
            $products = Product::whereRaw("FIND_IN_SET('$tag->name', p_tags)")->where('visiblity',1)->where(function ($query) {
                      $query->where('publish_status', '!=', 'draft')
                            ->orWhereNull('publish_status');
                  })->get();
        $SEOController = new SEOController();
        $SEOTitleDescription = $SEOController->_seoTitleDescriptionTags($tag->name);
        $SEOSchemaCode = $SEOController->_seoSchemaCodeProductList();
        return view('front.all_products',compact('tag','products','SEOTitleDescription','SEOSchemaCode'));
    }else{
        return redirect()->route('home');
    }
        
    }
    public function filter_product(Request $request)
    {

        $selectedFamilies = [];
        if(isset($request->cat_id) && $request->cat_id != '' && $request->cat_id != null)
        {
            $families = Family::whereRaw('FIND_IN_SET(?, category_id)', $request->cat_id)->get();
            foreach($families as $fam)
            {
                $product_fcount = Product::where('p_category' , $request->cat_id)->where('p_family',$fam->id)->count();
                if ($product_fcount > 0) {
                    $selectedFamilies[] = $fam;
                }
            }
        }else{
            $selectedFamilies = Family::whereHas('products', function ($query) {
                    $query->whereNotNull('p_family');
                })->get(); 
        }
 
        $perPage = 8;
        $query = Product::query();
        if(isset($request->cats) && count($request->cats) > 0)
        {
            $query->whereIn('p_category',$request->cats);
        }
        if(isset($request->fams) && count($request->fams))
        {
            $query->whereIn('p_family',$request->fams);
        }
        if(isset($request->genders) && count($request->genders) && $request->genders != null)
        {
            $query->whereIn('p_gender',$request->genders);
        }
        if(isset($request->carates) && count($request->carates) && $request->carates != null)
        {
            $query->whereIn('p_metal_purity',$request->carates);
        }
        if(isset($request->status) && count($request->status) && $request->status != null)
        {
            $query->whereIn('p_status',$request->status);
        }
        if(isset($request->searchtext) && $request->searchtext != '' && $request->searchtext != null)
        {
            $query->where('p_title', 'like', '%' . $request->searchtext . '%');
        }
        if(isset($request->tag_key) && $request->tag_key != '' && $request->tag_key != null)
        {
            $query->whereRaw('FIND_IN_SET(?, p_tags)', $request->tag_key);
        }
        $products = $query->skip($request->start)->take($perPage)->where('visiblity',1)->where(function ($query) {
                      $query->where('publish_status', '!=', 'draft')
                            ->orWhereNull('publish_status');
                  })->latest()->get();
        // dd($products);
        if(isset($products) && count($products) > 0)
        {
            $html = view('front.include.ajax-product-page', compact('products'))->render();
            $count = $products->count();
        }else{
            $html = '';
            $count = 0;
        }
        return response()->json(['status' => 1, 'html' => $html,'families' => $selectedFamilies ?? '','p_count' => $count]);
    }

    public function product_detail($slug)
    {

        try {
        $product_type = '';
        // $old_slugs = OldSlug::all();
        // if(isset($old_slugs) && count($old_slugs) > 0)
        // {
        //     foreach($old_slugs as $o_slug)
        //     {
        //         if($o_slug->old_slug == $slug)
        //         {
        //             $current_slug = Product::where('id',$o_slug->product_id)->first();
        //             $slug = $current_slug->p_slug;
        //             return redirect()->route('front.detail.products', ['slug' => $slug]);
        //         }
        //     }
        // }
        $all_attr = [];
        $product = Product::where('p_slug', $slug)->where('visiblity', 1)->where(function ($query) {
            $query->where('publish_status', '!=', 'draft')
                ->orWhereNull('publish_status');
        })->first();
   
        $product_type = 'simple';
        $p_product_id = isset($product->id) ? $product->id : null;
        if (!$product) {
            $product_type = 'variant';
            $product = VariantProduct::where('p_slug', $slug)->where('visiblity', 1)->where(function ($query) {
                $query->where('publish_status', '!=', 'draft')
                    ->orWhereNull('publish_status');
            })->first();
        }
        if (!$product) {
            throw new \Illuminate\Database\Eloquent\ModelNotFoundException();
        }

     
        $p_product_id = $product_type === 'variant' ? $product->parent_product_id : $product->id;
        $parent_product = Product::where('id',$p_product_id)->where('visiblity',1)->where(function ($query) {
            $query->where('publish_status', '!=', 'draft')
                  ->orWhereNull('publish_status');
        })->first();

        if (!$parent_product) {
            throw new \Illuminate\Database\Eloquent\ModelNotFoundException();
        }
        
        $attributes = ProductAttribute::where('parent_product_id',$p_product_id)->get();
        $dashed_sizes = [];
        $dashed_genders = [];
        $dashed_m_weights = [];
        $dashed_purities = [];
        $dashed_m_colors = [];
        $dashed_d_clarities = [];
        $sizes = [];
        $genders = [];
        $purities = [];
        $metal_colors = [];
        $metal_weights = [];
        $diamond_clarities = [];
          
        if(isset($attributes) && count($attributes) > 0)
        {
            foreach($attributes as $key => $attribute)
            {
                $all_attr = array_merge($all_attr, explode(',', $attribute->attributes));
                $diamond_attrs = explode(',', $attribute->diamond_attributes);
                foreach ($diamond_attrs as $diamond_attr) {
                    $all_attr[] = 'diamond_' . $diamond_attr;
                }
                // $all_attr[] = $attribute;
            }
            $all_attr = array_unique($all_attr);    
            $attributeData = getProductAttributes($all_attr,$p_product_id,$product_type,$product);
            $sizes = $attributeData['sizes'];
            $genders = $attributeData['genders'];
            $purities = $attributeData['purities'];
            $metal_colors = $attributeData['metal_colors'];
            $metal_weights = $attributeData['metal_weights']; 
            $main_parent_id = $attributeData['main_parent_id'];
            // $diamond_clarities = $attributeData['diamond_clarities'];
            $dashed_variants = VariantProduct::where('parent_product_id',$p_product_id)->get();
            
        }else{
            $main_parent_id = $p_product_id;
            $all_attr = [];
        }
        if((isset($product->p_size) && $product->p_size != null) && (isset($product->p_unit) && $product->p_unit != null) && in_array('size',$all_attr))
        {
            $d_variants = VariantProduct::where('p_size', $product->p_size)->where('p_unit', $product->p_unit)->where('parent_product_id',$p_product_id)->get();
            $d_parent = Product::where('p_size', $product->p_size)->where('p_unit', $product->p_unit)->where('id',$p_product_id)->first();
        }else if((isset($product->p_gender) && $product->p_gender != null) && in_array('gender',$all_attr))
        {
            $d_variants = VariantProduct::where('p_gender', $product->p_gender)->where('parent_product_id',$p_product_id)->get();
            $d_parent = Product::where('p_gender', $product->p_gender)->where('id',$p_product_id)->first();
            
        }else if((isset($product->p_metal_purity) && $product->p_metal_purity != null) && in_array('metal_purity',$all_attr))
        {
            $d_variants = VariantProduct::where('p_metal_purity', $product->p_metal_purity)->where('parent_product_id',$p_product_id)->get();
            $d_parent = Product::where('p_metal_purity', $product->p_metal_purity)->where('id',$p_product_id)->first();
        }else if((isset($product->p_metal_weigth) && $product->p_metal_weigth != null) && (isset($product->p_metal_weight_unit) && $product->p_metal_weight_unit != null) && in_array('metal_wieght',$all_attr))
        {
            $d_variants = VariantProduct::where('p_metal_weigth', $product->p_metal_weigth)->where('p_metal_weight_unit',$product->p_metal_weight_unit)->where('parent_product_id',$p_product_id)->get();
            $d_parent = Product::where('p_metal_weigth', $product->p_metal_weigth)->where('p_metal_weight_unit',$product->p_metal_weight_unit)->where('id',$p_product_id)->first();
        }
        else if((isset($product->p_metal_color) && $product->p_metal_color != null) && in_array('metal_color',$all_attr))
        {
            $d_variants = VariantProduct::where('p_metal_color', $product->p_metal_color)->where('parent_product_id',$p_product_id)->get();
            $d_parent = Product::where('p_metal_color', $product->p_metal_color)->where('id',$p_product_id)->first();
        }

        if(isset($d_variants) && count($d_variants) > 0)
        {
            foreach($d_variants as $d_variant)
            {
                $dashed_sizes[] = $d_variant->p_size.' '.$d_variant->p_unit;
                $dashed_genders[] = $d_variant->p_gender;
                $dashed_m_weights[] = $d_variant->p_metal_weigth.' '.$d_variant->p_metal_weight_unit;
                $dashed_purities[] = $d_variant->p_metal_purity;
                $dashed_m_colors[] = $d_variant->p_metal_color;
                if(isset($d_variant->diamond_details) && $d_variant->diamond_details != null && $d_variant->diamond_details != '')
                {
                    $diamond_details = json_decode($d_variant->diamond_details, true);
                    foreach ($diamond_details as $detail) {
                        if (isset($detail['attr_clarity'])) {
                            $dashed_d_clarities[] = $detail['attr_clarity'];
                        }
                    }
                }
            }
        }
        if(isset($d_parent) && $d_parent != null)
        {
            $dashed_sizes[] = $d_parent->p_size.' '.$d_parent->p_unit;
            $dashed_genders[] = $d_parent->p_gender;
            $dashed_m_weights[] = $d_parent->p_metal_weigth.' '.$d_parent->p_metal_weight_unit;
            $dashed_purities[] = $d_parent->p_metal_purity;
            $dashed_m_colors[] = $d_parent->p_metal_color;
            if(isset($d_parent->diamond_details) && $d_parent->diamond_details != null && $d_parent->diamond_details != '')
                {
                    $diamond_details = json_decode($d_parent->diamond_details, true);
                    foreach ($diamond_details as $detail) {
                        if (isset($detail['attr_clarity'])) {
                            $dashed_d_clarities[] = $detail['attr_clarity'];
                        }
                    }
                }
        }
        $sessionKey = 'product_' . $product->p_slug;
            session()->forget($sessionKey);
            session()->put($sessionKey, [
                'dashed_sizes' => $dashed_sizes,
                'dashed_genders' => $dashed_genders,
                'dashed_purities' => $dashed_purities,
                'dashed_m_weights' => $dashed_m_weights,
                'dashed_m_colors' => $dashed_m_colors,
                // 'dashed_d_clarities' => $dashed_d_clarities,
            ]);
        $nextProduct = Product::where('p_slug', '>', $slug)->where('visiblity', 1)->where(function ($query) {
            $query->where('publish_status', '!=', 'draft')
                ->orWhereNull('publish_status');
        })->orderBy('p_slug', 'asc')->first();
        $previousProduct = Product::where('p_slug', '<', $slug)->where('visiblity', 1)->where(function ($query) {
            $query->where('publish_status', '!=', 'draft')
                ->orWhereNull('publish_status');
        })->orderBy('p_slug', 'desc')->first();

        $sessionKey = 'product_' . $slug;
        $sessionData = session($sessionKey);
          
     
        if (!$product) {
            throw new \Illuminate\Database\Eloquent\ModelNotFoundException();
        }
            if ($product) {
                $similar_products = Product::where('p_category', $product->p_category)->where('p_family',$product->p_family)
                    ->where('p_slug', '!=', $slug)->where('visiblity',1)->where(function ($query) {
                          $query->where('publish_status', '!=', 'draft')
                                ->orWhereNull('publish_status');
                      })
                    ->inRandomOrder()
                    ->take(8)
                    ->get();
                $tags = Tags::where('product_id',$product->id)->get();
            } else {
                $similar_products = collect();
            }
            if(isset($product))
            {
                $p_img = ProductImage::where('product_id',$product->id)->first();
            }else{
                $p_img = '';
            }
            $SEOController = new SEOController();
            $SEOTitleDescription = $SEOController->_seoTitleDescriptionProductDetail($product->p_title,isset($p_img) ? $p_img->name : '');
            $SEOSchemaCode = $SEOController->_seoSchemaCodeProductDetail($product,isset($p_img) ? $p_img->name : '');
            $setting = Setting::first();
            return view('front.product_detail',compact('product','similar_products','tags','SEOTitleDescription','SEOSchemaCode','previousProduct','nextProduct','product_type','sizes','genders','purities','metal_colors','metal_weights','main_parent_id','sessionData','all_attr','diamond_clarities','setting'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Handle case where product is not found
            return redirect()->route('home');
        }
    }
    
    public function add_to_cart(Request $request)
    {
        // dd($request->all());
        $totalQuantity = 0;
        $productId = $request->pro_id;
        if($request->pro_id && $request->qty){
            if(Auth::user())
            {
                $user_id = Auth::user()->id;
            }
            if(isset($user_id) && $user_id != null && $user_id != '')
            {
                $existing = Cart::where('user_id',$user_id)->where('product_id',$request->pro_id)->first();
                if(isset($request->product_type) && $request->product_type == 'simple')
                {
                    $product = Product::where('id',$request->pro_id)->first();
                }else{
                    $product = VariantProduct::where('id',$request->pro_id)->first();
                }
                
                if(isset($product->p_status) && $product->p_status != '' && $product->p_status != null && $product->p_status == 'ready_stock')
                {
                    if((isset($product->p_avail_stock_qty) && $product->p_avail_stock_qty != 0 && $product->p_avail_stock_qty != '') || $product->p_avail_stock_qty == null)
                    {
                       $avail_qty = $product->p_avail_stock_qty;
                    }
                }
                
                if(isset($existing) && $existing != '' && $existing != null)
                {
                    if(isset($avail_qty) && $avail_qty != null)
                    {
                        $new_qty = $existing->qty + $request->qty;
                        if($avail_qty >= $new_qty)
                        {
                            $final_qty = $existing->qty + $request->qty;
                        }else{
                            return response()->json(['status' => 0,'count' =>$totalQuantity]);
                        }
                    }else{
                        $final_qty = $existing->qty + $request->qty;
                    }
                    $cart = Cart::findOrfail($existing->id);
                    $cart->qty = $final_qty;
                    $totalQuantity += $cart->qty;
                }else{
                    if(isset($avail_qty) && $avail_qty != null)
                    {
                        $new_qty = $request->qty;
                        if($avail_qty >= $new_qty)
                        {
                            $final_qty = $request->qty;
                        }else{
                            return response()->json(['status' => 0,'count' =>$totalQuantity]);
                        }
                    }else{
                        $final_qty = $request->qty;
                    }
                    $cart = new Cart();
                    $cart->qty = $final_qty;
                    $totalQuantity += $final_qty;
                }
                $cart->user_id = $user_id;
                $cart->product_id = $request->pro_id;
                $cart->product_type = $request->product_type;
                $cart->save();
                $totalQuantity = Cart::where('user_id',$user_id)->sum('qty');
                // $totalQuantity += $request->qty;
            }else{
                $cart = session()->get('cart',[]);
                $existingItemIndex = null;
                $totalQuantity = count($cart);
                foreach ($cart as $index => $item) {
                    if(isset($request->product_type) && $request->product_type == 'simple')
                    {
                        $product = Product::where('id',$item['product_id'])->first();
                    }else{
                        $product = VariantProduct::where('id',$item['product_id'])->first();
                    }
                    if(isset($product->p_status) && $product->p_status != '' && $product->p_status != null && $product->p_status == 'ready_stock')
                    {
                        if((isset($product->p_avail_stock_qty) && $product->p_avail_stock_qty != 0 && $product->p_avail_stock_qty != '') || $product->p_avail_stock_qty == null)
                        {
                           $avail_qty = $product->p_avail_stock_qty;
                        }
                    }
                    if ($item['product_id'] == $productId) {
                        $existingItemIndex = $index;
                        break;
                    }
                    // $totalQuantity += $item['qty'];
                }
                if ($existingItemIndex !== null) {
                    if(isset($avail_qty) && $avail_qty != null)
                    {
                        $new_qty = $cart[$existingItemIndex]['qty'] + $request->qty;
                        if($avail_qty >= $new_qty)
                        {
                            $final_qty = $cart[$existingItemIndex]['qty'] + $request->qty;
                        }else{
                            return response()->json(['status' => 0,'count' =>$totalQuantity]);
                        }
                    }else{
                        $final_qty = $cart[$existingItemIndex]['qty'] + $request->qty;
                    }
                    $cart[$existingItemIndex]['qty'] =  $final_qty;
                    // $totalQuantity += $cart[$existingItemIndex]['qty'];
                }else{
                    if(isset($request->product_type) && $request->product_type == 'simple')
                    {
                        $product = Product::where('id',$request->pro_id)->first();
                    }else{
                        $product = VariantProduct::where('id',$request->pro_id)->first();
                    }
                    if(isset($product->p_status) && $product->p_status != '' && $product->p_status != null && $product->p_status == 'ready_stock')
                    {
                        if((isset($product->p_avail_stock_qty) && $product->p_avail_stock_qty != 0 && $product->p_avail_stock_qty != '') || $product->p_avail_stock_qty == null)
                        {
                           $avail_qty = $product->p_avail_stock_qty;
                        }
                    }
                    if(isset($avail_qty) && $avail_qty != null)
                    {
                        $new_qty = $request->qty;
                        if($avail_qty >= $new_qty)
                        {
                            $final_qty = $request->qty;
                        }else{
                            return response()->json(['status' => 0,'count' =>$totalQuantity]);
                        }
                    }else{
                        $final_qty = $request->qty;
                    }
                    $newProduct = [
                    'product_id' => $request->pro_id,
                    'product_type' => $request->product_type,
                    'qty' => $final_qty,
                ];
                $cart[] = $newProduct;
                // $totalQuantity += $request->qty;
                }
                
                session()->put('cart', $cart);
                $totalQuantity = array_sum(array_column($cart, 'qty'));
                // $cartCount = count($cart);
            }
            // dd($totalQuantity);
            return response()->json(['status' => 1,'count' =>$totalQuantity]);
        }
    }
    
    public function update_to_cart(Request $request)
    {
        // dd($request->all());
        $productId = $request->product_id;
        $quantity = $request->quantity;
        $totalQuantity = 0;
        $totalGrandPrice = 0;
        
        if(Auth::user() && isset($request->id) && $request->id != '' && $request->id != null)
        {
            $user_id = Auth::user()->id;
            $cart = Cart::findOrfail($request->id);
            $cart->user_id = $user_id;
            $cart->product_id = $request->product_id;
            $cart->product_type = $request->product_type;
            $cart->qty = $request->quantity;
            $cart->save();
            $totalQuantity = Cart::where('user_id',$user_id)->sum('qty');
            $db_cart_list = Cart::where('user_id',$user_id)->latest()->get();

            $cart_list = $db_cart_list->map(function ($cart) {
                return [
                    "id" => $cart->id,
                    "product_id" => $cart->product_id,
                    "product_type" => $cart->product_type,
                    "qty" => $cart->qty,
                    "order_comment" => $cart->comment, 
                ];
            })->toArray();
            
        }else{
            $cart = session()->get('cart', []);
            $existingItemIndex = null;
            $existing_cart = count($cart);
            
            foreach ($cart as $index => $item) {

                if ($item['product_id'] == $productId || $item['product_type'] == $request->product_type) {
                    $existingItemIndex = $index;
                    break;
                }
                // $totalQuantity += $item['qty'];
            }
            if ($existingItemIndex !== null) {
                $cart[$existingItemIndex]['qty'] = $quantity;
                $totalQuantity += $quantity;
                // $totalQuantity += $existing_cart;
            } else {
                $newProduct = [
                    'product_id' => $productId,
                    'product_type' => $request->product_type,
                    'qty' => $quantity,
                ];
                $cart[] = $newProduct;
            }

        session()->put('cart', $cart);
        
        $cart_list = session()->get('cart');
        $totalQuantity = array_sum(array_column($cart, 'qty'));
        
        }
        $totalqty = 0;
        if(count($cart_list) > 0){
            foreach ($cart_list as $single_cart_list){
                if($single_cart_list['product_type'] == 'simple')
                {
                    $product = Product::where('id', $single_cart_list['product_id'])->first();
                }else{
                    $product = VariantProduct::where('id', $single_cart_list['product_id'])->first();
                }
                
                        
                if(!$product){
                    continue;
                }	
                $total_price = str_replace(',', '', $product->total_price($product->id));
                $total_price_numeric = (float) $total_price;
				$product_price = $total_price_numeric * $single_cart_list['qty'];
				$totalGrandPrice += $product_price;
                $totalqty += $single_cart_list['qty'];

            } 
        }
        return response()->json(['status' => 1, 'qty' => $quantity,'total_items' =>$totalQuantity, 'total_grand_price' => $totalGrandPrice]);
    }
    public function remove_cart(Request $request)
    {
        $previousUrl = url()->previous();
        if(isset($request->cart_id) && $request->cart_id != '' && $request->cart_id != null)
        {
            // dd($request->all());
            $cart = Cart::findOrfail($request->cart_id);
            $cart->delete();
        }else{
            $requestData = $request->all();
            session()->put('cart', collect(session()->get('cart'))->filter(function ($item) use ($requestData) {
                return $item['product_id'] != $requestData['product_id'] || $item['qty'] != $requestData['qty'] || $item['product_type'] != $requestData['product_type'];
            })->values()->toArray());
        }
        // return redirect()->route('front.cart.view')->with('errort', 'Product removed from cart!');
     
        return response()->json(['status' => 1 , 'message' => 'Product removed from cart!']);
    }

    public function cart_view()
    {
        if(Auth::user())
        {
            $user_id = Auth::user()->id;
        }
        
        if(isset($user_id) && $user_id != '' && $user_id != null)
        {
            $db_cart_list = Cart::where('user_id',$user_id)->latest()->get();
            $cart_list = $db_cart_list->map(function ($cart) {
                return [
                    "id" => $cart->id,
                    "product_id" => $cart->product_id,
                    "product_type" => $cart->product_type,
                    "qty" => $cart->qty,
                    "order_comment" => $cart->comment, 
                ];
            })->toArray();
        }else{
            $cart_list = session()->get('cart');
        }
        $avail_promo_codes = [];
        $other_avail_promocodes = [];
        $unavail_promo_codes = [];
        if(isset($cart_list) && count($cart_list) > 0)
        {
            $product_ids = array_column($cart_list, 'product_id');
            $today = Carbon::today()->format('m/d/Y');
            $cart_products_cat = Product::whereIn('id',$product_ids)->pluck('p_category')->toArray();
            $avail_promo_codes = PromoCode::where('status', 'active')
            ->where('publish_status', 'yes')
            ->where(DB::raw('STR_TO_DATE("' . $today . '", "%m/%d/%Y")'), '>=', DB::raw('STR_TO_DATE(startDate, "%m/%d/%Y")'))
            ->where(DB::raw('STR_TO_DATE("' . $today . '", "%m/%d/%Y")'), '<=', DB::raw('STR_TO_DATE(endDate, "%m/%d/%Y")'))
            ->where(function($query) use ($cart_products_cat) {
                $query->orWhereRaw("FIND_IN_SET('all', included_category)");
                foreach ($cart_products_cat as $category_id) {
                    $query->orWhereRaw("FIND_IN_SET(?, included_category)", [$category_id]);
                }
            })
            ->where(function($query) {
                $query->where('one_time_use', 'no')
                    ->orWhereDoesntHave('orders', function ($subQuery) {
                        $subQuery->whereColumn('orders.promo_code_id', 'promo_code.id');
                    });
            });
            if (isset($user_id) && $user_id != null) {
            $avail_promo_codes->where(function($query) use ($user_id) {
                $query->where('single_time_use', 'no')
                    ->orWhereDoesntHave('orders', function ($subQueryn) use ($user_id) {
                        $subQueryn->where('orders.user_id', $user_id);
                    });
            });
            }

            $avail_promo_codes = $avail_promo_codes->latest()
            ->take(3)
            ->get();
            $avail_promo_code_ids = $avail_promo_codes->pluck('id')->toArray();
            $other_avail_promocodes = PromoCode::where('status', 'active')
                ->where('publish_status', 'yes')
                ->where(DB::raw('STR_TO_DATE("' . $today . '", "%m/%d/%Y")'), '>=', DB::raw('STR_TO_DATE(startDate, "%m/%d/%Y")'))
                ->where(DB::raw('STR_TO_DATE("' . $today . '", "%m/%d/%Y")'), '<=', DB::raw('STR_TO_DATE(endDate, "%m/%d/%Y")'))
                ->whereNotIn('id', $avail_promo_code_ids)
                ->where(function($query) use ($cart_products_cat) {
                    $query->orWhereRaw("FIND_IN_SET('all', included_category)");
                    foreach ($cart_products_cat as $category_id) {
                        $query->orWhereRaw("FIND_IN_SET(?, included_category)", [$category_id]);
                    }
                })
                ->where(function($query) {
                    $query->where('one_time_use', 'no')
                        ->orWhereDoesntHave('orders', function ($subQuery) {
                            $subQuery->whereColumn('orders.promo_code_id', 'promo_code.id');
                        });
                });

            if (isset($user_id)) {
                $other_avail_promocodes->where(function($query) use ($user_id) {
                    $query->where('single_time_use', 'no')
                        ->orWhereDoesntHave('orders', function ($subQueryn) use ($user_id) {
                            $subQueryn->where('orders.user_id', $user_id);
                        });
                });
            }
            $other_avail_promocodes = $other_avail_promocodes->latest()->get();
            $other_promo_code_ids = $other_avail_promocodes->pluck('id')->toArray();
            $all_promo_code_ids = array_merge($avail_promo_code_ids, $other_promo_code_ids);
            $all_avail_promo_code_ids = array_unique($all_promo_code_ids);
            $unavail_promo_codes = PromoCode::where('status', 'active')->where('publish_status', 'yes')->whereNotIn('id', $all_avail_promo_code_ids)->where(DB::raw('STR_TO_DATE(endDate, "%m/%d/%Y")'), '>=', Carbon::today())->latest()->get();
            
        }
        $SEOController = new SEOController();
        $SEOTitleDescription = $SEOController->_seoTitleDescriptionMyCart();
        $SEOSchemaCode = $SEOController->_seoSchemaCodeCartDetail();
        return view('front.cart_view',compact('cart_list','SEOTitleDescription','SEOSchemaCode','avail_promo_codes','other_avail_promocodes','unavail_promo_codes'));
    }

    public function add_to_wishlist(Request $request)
    {
        // dd($request->all());
        if(Auth::user())
        {
            $user_id = Auth::user()->id;

        }
        if(isset($user_id) && $user_id != null && $user_id != '')
        {
            $existing = WishList::where('user_id',$user_id)->where('product_id',$request->id)->first();
            if(isset($existing) && $existing != '' && $existing != null)
            {
                $wishlist = WishList::findOrfail($existing->id);
            }else{
                $wishlist = new WishList();
            }
            $wishlist->user_id = $user_id;
            $wishlist->product_id = $request->id;
            $wishlist->product_type = $request->product_type;
            $wishlist->save();

            $db_wish_list = WishList::where('user_id',$user_id)->get();
            $wish_list = $db_wish_list->map(function ($wish) {
                return [
                    "id" => $wish->id,
                    "product_id" => $wish->product_id,
                    "product_type" => $wish->product_type,
                    "qty" => isset($wish->qty) ? $wish->qty : null,
                ];
            })->toArray();

            $totalQuantity = count($wish_list);

        }
        else{
            $wishlist = session()->get('wishlist',[]);
            $ids = array_column($wishlist, 'product_id');
            if(!in_array($request->id, $ids)){
                $newProduct = [
                    'product_id' => $request->id,
                    'product_type' => $request->product_type,
                    'name' => $request->name,
                    'slug' => $request->slug,
                    'image' => $request->image,
                    'price' => $request->price,
                    'qty' => 1
                ];

                $wishlist[] = $newProduct;
            }
            
            session()->put('wishlist', $wishlist);
            $totalQuantity = count(session()->get('wishlist'));
        }
        

        return response()->json(['status' => 1, 'message' => 'Product Added In Wishlist', 'count' =>$totalQuantity]);
    }

    public function wishlist_view()
    {
        if(Auth::user())
        {
            $user_id = Auth::user()->id;
        }
        
        if(isset($user_id) && $user_id != '' && $user_id != null)
        {
            $db_wish_list = WishList::where('user_id',$user_id)->latest()->get();
            $wish_list = $db_wish_list->map(function ($wish) {
                return [
                    "id" => $wish->id,
                    "product_id" => $wish->product_id,
                    "product_type" => $wish->product_type,
                    "qty" => isset($wish->qty) ? $wish->qty : null,
                ];
            })->toArray();
        }else{
            $wish_list = session()->get('wishlist');
        }
  
        $SEOController = new SEOController();
        $SEOTitleDescription = $SEOController->_seoTitleDescriptionMyWishlist();
        $SEOSchemaCode = $SEOController->_seoSchemaCodeWishlist('Wishlist');
        return view('front.wishlist_view',compact('wish_list','SEOTitleDescription', 'SEOSchemaCode'));
    }

    public function remove_wishlist(Request $request)
    {
        
        if(Auth::user())
        {
            $user_id = Auth::user()->id;

        }
        if(isset($user_id) && $user_id != '' && $user_id != null && isset($request->product_id) && $request->product_id != '' && $request->product_id != null)
        {
            $wish_list = WishList::where('product_id',$request->product_id)->where('product_type',$request->product_type)->where('user_id',$user_id)->first();
            $wish_list->delete();
        }else{
            $requestData = $request->all();
            session()->put('wishlist', collect(session()->get('wishlist'))->filter(function ($item) use ($requestData) {
                return $item['product_id'] != $requestData['product_id'] || $item['product_type'] != $requestData['product_type'];
            })->values()->toArray());
        }
        return response()->json(['status' => 1 , 'message' => 'Product removed from Wishlist!']);
    }

    public function move_to_cart(Request $request)
    {
        // dd($request->all());
        $productId = $request->product_id;
        if(Auth::user())
        {
            $user_id = Auth::user()->id;

        }
        if(isset($user_id) && $user_id != null && $user_id != '')
            {
                $existing = Cart::where('user_id',$user_id)->where('product_id',$request->product_id)->where('product_type',$request->product_type)->first();
                if(isset($existing) && $existing != '' && $existing != null)
                {
                    $cart = Cart::findOrfail($existing->id);
                }else{
                    $cart = new Cart();
                }
                $cart->user_id = $user_id;
                $cart->qty = $request->pro_qty;
                $cart->product_id = $request->product_id;
                $cart->product_type = $request->product_type;
                $cart->save();
            }else{
                $cart = session()->get('cart',[]);
                $existingItemIndex = null;

                foreach ($cart as $index => $item) {

                    if ($item['product_id'] == $productId && $item['product_type'] == $request->product_type) {
                        $existingItemIndex = $index;
                        $cart[$index]['qty'] = $request->pro_qty;
                        break;
                    }
                    // $totalQuantity += $item['qty'];
                }
                if ($existingItemIndex !== null) {
                    // dd($request->qty);
                    $cart[$existingItemIndex]['qty'] = $request->pro_qty;
                    session()->put('cart', $cart);
                }else{
                    $newProduct = [
                    'product_id' => $request->product_id,
                    'product_type' => $request->product_type,
                    'qty' => $request->pro_qty,
                ];
                $cart[] = $newProduct;
                }
                
                session()->put('cart', $cart);
                // $cartCount = count($cart);
            }
            return redirect()->route('front.cart.view')->with('success', 'Product moved from cart!');
    }

    public function move_to_wishlist(Request $request)
    {
        // dd($request->all());
        $productId = $request->c_product_id;
        $qty = $request->c_qty;
        $existingItemIndex = null;
        if(Auth::user())
        {
            $user_id = Auth::user()->id;

        }
        if(isset($user_id) && $user_id != null && $user_id != '')
        {
            $existing = WishList::where('user_id',$user_id)->where('product_id',$request->c_product_id)->where('product_type',$request->c_product_type)->first();
            if(isset($existing) && $existing != '' && $existing != null)
            {
                $wishlist = WishList::findOrfail($existing->id);
            }else{
                $wishlist = new WishList();
            }
            $wishlist->user_id = $user_id;
            $wishlist->product_id = $request->c_product_id;
            $wishlist->product_type = $request->c_product_type;
            // $wishlist->qty = $request->c_qty;
            $wishlist->save();
        }
        else{
        $wishlist = session()->get('wishlist',[]);
        foreach ($wishlist as $index => $item) {

                    if ($item['product_id'] == $productId && $item['product_type'] == $request->c_product_type) {
                        $existingItemIndex = $index;
                        $wishlist[$index]['qty'] = $qty;
                        break;
                    }
                    // $totalQuantity += $item['qty'];
                }
        if ($existingItemIndex !== null) {
                    session()->put('wishlist', $wishlist);
                }
                else{
                    $newProduct = [
                    'product_id' => $request->c_product_id,
                    'product_type' => $request->c_product_type,
                    'qty' => $qty,
        ];
        $wishlist[] = $newProduct;
        session()->put('wishlist', $wishlist);
    }
        }
        return redirect()->route('front.wishlist.view')->with('success', 'Product Moved in Wishlist!');
    }

    public function fetch_variant(Request $request)
    {
        // dd($request->all());
        $size_m = '';
        $size_u = '';
        $metal_weight_m = '';
        $metal_weight_u = '';
        $parent = true;
        $dashed_sizes = [];
        $dashed_genders = [];
        $dashed_purities = [];
        $dashed_m_weights = [];
        $dashed_m_colors = [];
        $main_product = Product::where('id',$request->main_parent_id)->first();
        $get_variants = collect();
        $get_variants->prepend($main_product);
        // dd($get_variants);
        // $dashed_sizes[] = $main_product->p_size.' '.$main_product->p_unit;
        // $dashed_genders[] = $main_product->p_gender;
        // $dashed_purities[] = $main_product->p_metal_purity;
        // $dashed_m_weights[] = $main_product->p_metal_weigth.' '.$main_product->p_metal_weight_unit;
        // $dashed_m_colors[] = $main_product->p_metal_color;
        if(isset($request->size) && $request->size != '' && $request->size != null)
        {
            $size_check = explode('_',$request->size);
            $size_m = $size_check[0];
            $size_u = $size_check[1];
            
        }
        if(isset($request->metal_weight) && $request->metal_weight != '' && $request->metal_weight != null)
        {
            $metal_weight_check = explode('_',$request->metal_weight);
            $metal_weight_m = $metal_weight_check[0];
            $metal_weight_u = $metal_weight_check[1];
            
        }
        $db_attributes = ProductAttribute::where('parent_product_id',$request->main_parent_id)->get();
        if (isset($request->compulsory) && $request->compulsory != null) {
            foreach ($db_attributes as $att) {
                $check = explode(',', $att->attributes);
                $t_check_attr = explode(',',$att->diamond_attributes);
                    foreach ($t_check_attr as $diamond_attr) {
                        $check[] = 'diamond_' . $diamond_attr;
                    }
                if (in_array($request->compulsory, $check)) {
                    switch ($request->compulsory) {
                        case 'size':
                            $get_variants = VariantProduct::where('p_size', $size_m)->where('p_unit', $size_u)->where('parent_product_id',$request->main_parent_id)->get();
                            break;
                        case 'gender':
                            $get_variants = VariantProduct::where('p_gender', $request->gender)->where('parent_product_id',$request->main_parent_id)->get();
                            break;
                        case 'metal_wieght':
                            $get_variants = VariantProduct::where('p_metal_weigth', $metal_weight_m)->where('p_metal_weight_unit', $metal_weight_u)->where('parent_product_id',$request->main_parent_id)->get();
                            break;
                        case 'metal_purity':
                            $get_variants = VariantProduct::where('p_metal_purity', $request->metal_purity)->where('parent_product_id',$request->main_parent_id)->get();
                            break;
                        case 'metal_color':
                            $get_variants = VariantProduct::where('p_metal_color', $request->metal_color)->where('parent_product_id',$request->main_parent_id)->get();
                            break;
                        // case 'diamond_clarity':
                        //     $get_variants = VariantProduct::whereRaw('JSON_SEARCH(diamond_details, "one", ?) IS NOT NULL', [$request->diamond_clarity])->where('parent_product_id',$request->main_parent_id)->get();
                        //     break;
                    }  
                    break; // Exit the loop once a matching attribute is found
                }
            }
        }
        // dd($get_variants);
        // for dashed 
        $d_all_attr = [];
        $d_attributes = ProductAttribute::where('parent_product_id',$request->main_parent_id)->get();
        if(isset($d_attributes) && count($d_attributes) > 0)
        {
            foreach($d_attributes as $d_attribute)
            {
                $d_all_attr = array_merge($d_all_attr, explode(',', $d_attribute->attributes));
                $t_check_attr = explode(',',$d_attribute->diamond_attributes);
                foreach ($t_check_attr as $diamond_attr) {
                    $f_t_check_attr[] = 'diamond_' . $diamond_attr;
                }
                $d_all_attr = array_merge($d_all_attr, $f_t_check_attr);
            }
            $d_all_attr = array_unique($d_all_attr);
        }
        if((isset($size_m) && $size_m != null) && (isset($size_u) && $size_u != null) && in_array('size',$d_all_attr))
        {
            $d_variants = VariantProduct::where('p_size', $size_m)->where('p_unit', $size_u)->where('parent_product_id',$request->main_parent_id)->get();
            $d_parent = Product::where('p_size', $size_m)->where('p_unit', $size_u)->where('id',$request->main_parent_id)->first();
        }else if((isset($request->gender) && $request->gender != null) && in_array('gender',$d_all_attr))
        {
            $d_variants = VariantProduct::where('p_gender', $request->gender)->where('parent_product_id',$request->main_parent_id)->get();
            $d_parent = Product::where('p_gender', $request->gender)->where('id',$request->main_parent_id)->first();
            
        }else if((isset($request->metal_purity) && $request->metal_purity != null) && in_array('metal_purity',$d_all_attr))
        {
            $d_variants = VariantProduct::where('p_metal_purity', $request->metal_purity)->where('parent_product_id',$request->main_parent_id)->get();
            $d_parent = Product::where('p_metal_purity', $request->metal_purity)->where('id',$request->main_parent_id)->first();
        }else if((isset($metal_weight_m) && $metal_weight_m != null) && (isset($metal_weight_u) && $metal_weight_u != null) && in_array('metal_wieght',$d_all_attr))
        {
            $d_variants = VariantProduct::where('p_metal_weigth', $metal_weight_m)->where('p_metal_weight_unit',$metal_weight_u)->where('parent_product_id',$request->main_parent_id)->get();
            $d_parent = Product::where('p_metal_weigth', $metal_weight_m)->where('p_metal_weight_unit',$metal_weight_u)->where('id',$request->main_parent_id)->first();
        }
        else if((isset($request->metal_color) && $request->metal_color != null) && in_array('metal_color',$d_all_attr))
        {
            $d_variants = VariantProduct::where('p_metal_color', $request->metal_color)->where('parent_product_id',$request->main_parent_id)->get();
            $d_parent = Product::where('p_metal_color', $request->metal_color)->where('id',$request->main_parent_id)->first();
        }
        // else if((isset($request->diamond_clarity) && $request->diamond_clarity != null) && in_array('diamond_clarity',$d_all_attr))
        // {
        //     $d_variants = VariantProduct::where('parent_product_id', $request->main_parent_id)
        //         ->whereRaw('JSON_SEARCH(diamond_details, "one", ?) IS NOT NULL', [$request->diamond_clarity])
        //         ->get();

        //     $d_parent = Product::where('id', $request->main_parent_id)
        //                     ->whereRaw('JSON_SEARCH(diamond_details, "one", ?) IS NOT NULL', [$request->diamond_clarity])
        //                     ->first();
        // }
        // dd($d_variants);
        if(isset($d_variants) && count($d_variants) > 0)
        {
            foreach($d_variants as $d_variant)
            {
                $dashed_sizes[] = $d_variant->p_size.' '.$d_variant->p_unit;
                $dashed_genders[] = $d_variant->p_gender;
                $dashed_m_weights[] = $d_variant->p_metal_weigth.' '.$d_variant->p_metal_weight_unit;
                $dashed_purities[] = $d_variant->p_metal_purity;
                $dashed_m_colors[] = $d_variant->p_metal_color;
                // if(isset($d_variant->diamond_details) && $d_variant->diamond_details != '' && $d_variant->diamond_details != null)
                // {
                //     $diamond_details = json_decode($d_variant->diamond_details, true);
                //     foreach ($diamond_details as $detail) {
                //         if (isset($detail['attr_clarity'])) {
                //             $dashed_d_clarities[] = $detail['attr_clarity'];
                //         }
                //     }
                // }
                
            }
        }
        if(isset($d_parent) && $d_parent != null)
        {
            $dashed_sizes[] = $d_parent->p_size.' '.$d_parent->p_unit;
            $dashed_genders[] = $d_parent->p_gender;
            $dashed_m_weights[] = $d_parent->p_metal_weigth.' '.$d_parent->p_metal_weight_unit;
            $dashed_purities[] = $d_parent->p_metal_purity;
            $dashed_m_colors[] = $d_parent->p_metal_color;
            // if(isset($d_parent->diamond_details) && $d_parent->diamond_details != null && $d_parent->diamond_details != '')
            // {
            //     $diamond_details = json_decode($d_parent->diamond_details, true);
            //     foreach ($diamond_details as $detail) {
            //         if (isset($detail['attr_clarity'])) {
            //             $dashed_d_clarities[] = $detail['attr_clarity'];
            //         }
            //     }
            // }
            
        }
        if (isset($request->compulsory) && $request->compulsory != null) {
            if($request->compulsory == 'size')
            {
                $check_product = Product::where('p_size', $size_m)->where('p_unit', $size_u)->where('id',$request->main_parent_id)->first();
            }else if($request->compulsory == 'gender')
            {
                $check_query = Product::query();
                if((isset($size_m) && $size_m != null && $size_m != '') && (isset($size_u) && $size_u != '' && $size_u != null))
                {
                    $check_query->where('p_size', $size_m)->where('p_unit', $size_u);
                }
                $check_product = $check_query->where('p_gender', $request->gender)->where('id',$request->main_parent_id)->first();
            }else if($request->compulsory == 'metal_purity')
            {
                $check_query = Product::query();
                if((isset($size_m) && $size_m != null && $size_m != '') && (isset($size_u) && $size_u != '' && $size_u != null))
                {
                    $check_query->where('p_size', $size_m)->where('p_unit', $size_u);
                }
                if(isset($request->gender) && $request->gender != null && $request->gender != '')
                {
                    $check_query->where('p_gender', $request->gender);
                }
                $check_product = $check_query->where('p_metal_purity', $request->metal_purity)->where('id',$request->main_parent_id)->first();
            }else if($request->compulsory == 'metal_wieght')
            {
                $check_query = Product::query();
                if((isset($size_m) && $size_m != null && $size_m != '') && (isset($size_u) && $size_u != '' && $size_u != null))
                {
                    $check_query->where('p_size', $size_m)->where('p_unit', $size_u);
                }
                if(isset($request->gender) && $request->gender != null && $request->gender != '')
                {
                    $check_query->where('p_gender', $request->gender);
                }
                if(isset($request->metal_purity) && $request->metal_purity != null && $request->metal_purity != '')
                {
                    $check_query->where('p_metal_purity', $request->metal_purity);
                }
                $check_product = $check_query->where('p_metal_weigth', $metal_weight_m)->where('p_metal_weight_unit',$metal_weight_u)->where('id',$request->main_parent_id)->first();
            }else if($request->compulsory == 'metal_color')
            {
                $check_query = Product::query();
                if((isset($size_m) && $size_m != null && $size_m != '') && (isset($size_u) && $size_u != '' && $size_u != null))
                {
                    $check_query->where('p_size', $size_m)->where('p_unit', $size_u);
                }
                if(isset($request->gender) && $request->gender != null && $request->gender != '')
                {
                    $check_query->where('p_gender', $request->gender);
                }
                if(isset($request->metal_purity) && $request->metal_purity != null && $request->metal_purity != '')
                {
                    $check_query->where('p_metal_purity', $request->metal_purity);
                }
                if((isset($metal_weight_m) && $metal_weight_m != null && $metal_weight_m != '') && (isset($metal_weight_u) && $metal_weight_u != '' && $metal_weight_u != null))
                {
                    $check_query->where('p_metal_weigth', $size_m)->where('p_metal_weight_unit', $size_u);
                }
                $check_product = $check_query->where('p_metal_color', $request->metal_color)->where('id',$request->main_parent_id)->first();
            }
            // else if($request->compulsory == 'diamond_clarity')
            // {
            //     // dd('dgf');
            //     $check_query = Product::query();
            //     if((isset($size_m) && $size_m != null && $size_m != '') && (isset($size_u) && $size_u != '' && $size_u != null))
            //     {
            //         $check_query->where('p_size', $size_m)->where('p_unit', $size_u);
            //     }
            //     if(isset($request->gender) && $request->gender != null && $request->gender != '')
            //     {
            //         $check_query->where('p_gender', $request->gender);
            //     }
            //     if(isset($request->metal_purity) && $request->metal_purity != null && $request->metal_purity != '')
            //     {
            //         $check_query->where('p_metal_purity', $request->metal_purity);
            //     }
            //     if((isset($metal_weight_m) && $metal_weight_m != null && $metal_weight_m != '') && (isset($metal_weight_u) && $metal_weight_u != '' && $metal_weight_u != null))
            //     {
            //         $check_query->where('p_metal_weigth', $size_m)->where('p_metal_weight_unit', $size_u);
            //     }
            //     if(isset($request->metal_color) && $request->metal_color != '' && $request->metal_color != null)
            //     {
            //         $check_query->where('p_metal_color', $request->metal_color);
            //     }
            //     $check_product = $check_query->whereRaw('JSON_SEARCH(diamond_details, "one", ?) IS NOT NULL', [$request->diamond_clarity])->where('id',$request->main_parent_id)->first();
            // }
        }
        // dd($get_variants);
        if ($get_variants->isNotEmpty()) {
            // dd($get_variants);
            foreach ($get_variants as $val) {
                
                if (isset($request->compulsory) && $request->compulsory != null) {
                    $conditions = [];
                    switch ($request->compulsory) {
                        case 'size':
                            $conditions = [
                                ['field' => 'p_size', 'value' => $size_m],
                            ];
                            break;
                        case 'gender':
                            $conditions = [
                                ['field' => 'p_size', 'value' => $size_m],
                                ['field' => 'p_unit', 'value' => $size_u],
                                ['field' => 'p_gender', 'value' => $request->gender],
                            ];
                            break;
                            case 'metal_purity':
                                $conditions = [
                                    ['field' => 'p_size', 'value' => $size_m],
                                    ['field' => 'p_unit', 'value' => $size_u],
                                    ['field' => 'p_gender', 'value' => $request->gender],
                                    ['field' => 'p_metal_purity', 'value' => $request->metal_purity],
                                ];
                                break;
                        case 'metal_color':
                            $conditions = [
                                ['field' => 'p_size', 'value' => $size_m],
                                ['field' => 'p_unit', 'value' => $size_u],
                                ['field' => 'p_gender', 'value' => $request->gender],
                                ['field' => 'p_metal_weigth', 'value' => $metal_weight_m],
                                ['field' => 'p_metal_weight_unit', 'value' => $metal_weight_u],
                                ['field' => 'p_metal_purity', 'value' => $request->metal_purity],
                                ['field' => 'p_metal_color', 'value' => $request->metal_color],
                            ];
                            break;
                            case 'metal_wieght':
                            $conditions = [
                                ['field' => 'p_size', 'value' => $size_m],
                                ['field' => 'p_unit', 'value' => $size_u],
                                ['field' => 'p_gender', 'value' => $request->gender],
                                ['field' => 'p_metal_purity', 'value' => $request->metal_purity],
                                ['field' => 'p_metal_weigth', 'value' => $metal_weight_m],
                                ['field' => 'p_metal_weight_unit', 'value' => $metal_weight_u],
                                ['field' => 'p_metal_color', 'value' => $request->metal_color],
                            ];
                            break;
                            case 'diamond_clarity': // Add diamond_clarity case
                                $conditions = [
                                    ['field' => 'p_size', 'value' => $size_m],
                                    ['field' => 'p_unit', 'value' => $size_u],
                                    ['field' => 'p_gender', 'value' => $request->gender],
                                    ['field' => 'p_metal_purity', 'value' => $request->metal_purity],
                                    ['field' => 'p_metal_weigth', 'value' => $metal_weight_m],
                                    ['field' => 'p_metal_weight_unit', 'value' => $metal_weight_u],
                                    ['field' => 'p_metal_color', 'value' => $request->metal_color],
                                    // ['field' => 'diamond_details->attr_clarity', 'value' => $request->diamond_clarity, 'json' => true], // Add clarity condition
                                ];
                                break;
                    }
                    
                    if ($this->matchConditions($val, $conditions)) {
                        $final_pro = $val;
                        break; // Exit the loop once a matching variant is found
                    }
                }
            }
        }
        if(isset($check_product) && $check_product != null)
        {
            $final_pro = $check_product;
        }
        // dd($final_pro);
        $compulsoryAttribute = $request->compulsory ?? null;
        if (!isset($final_pro)) {
            if ($compulsoryAttribute == 'gender') {
                foreach ($db_attributes as $att) {
                    $check = explode(',', $att->attributes);
                    if (in_array('gender', $check)) {
                        $final_pro = VariantProduct::where('p_gender', $request->gender)->where('parent_product_id',$request->main_parent_id)->first();
                        break;
                    }
                }
            }
            if ($compulsoryAttribute == 'size') {
                foreach ($db_attributes as $att) {
                    $check = explode(',', $att->attributes);
                    if (in_array('size', $check)) {
                        $final_pro = VariantProduct::where('p_size', $size_m)->where('p_unit', $size_u)->where('parent_product_id',$request->main_parent_id)->first();
                        break;
                    }
                }
            }
            if ($compulsoryAttribute == 'metal_wieght') {
                foreach ($db_attributes as $att) {
                    $check = explode(',', $att->attributes);
                    if (in_array('metal_wieght', $check)) {
                        $final_pro = VariantProduct::where('p_metal_weigth', $metal_weight_m)->where('p_metal_weight_unit', $metal_weight_u)->where('parent_product_id',$request->main_parent_id)->first();
                        break;
                    }
                }
            }
            if ($compulsoryAttribute == 'metal_purity') {
                foreach ($db_attributes as $att) {
                    $check = explode(',', $att->attributes);
                    if (in_array('metal_purity', $check)) {
                        $final_pro = VariantProduct::where('p_metal_purity', $request->metal_purity)->where('parent_product_id',$request->main_parent_id)->first();
                        break;
                    }
                }
            }
            if ($compulsoryAttribute == 'metal_color') {
                foreach ($db_attributes as $att) {
                    $check = explode(',', $att->attributes);
                    if (in_array('metal_color', $check)) {
                        $final_pro = VariantProduct::where('p_metal_color', $request->metal_color)->where('parent_product_id',$request->main_parent_id)->first();
                        break;
                    }
                }
            }
            /*if ($compulsoryAttribute == 'diamond_clarity') {
                foreach ($db_attributes as $att) {
                    $check = explode(',', $att->diamond_attributes);
                    if (in_array('clarity', $check)) {
                        $final_pro = VariantProduct::where('parent_product_id', $request->main_parent_id)->whereRaw('JSON_SEARCH(diamond_details, "one", ?) IS NOT NULL', [$request->diamond_clarity])->first();
                        break;
                    }
                }
            }*/
        }
        // dd($final_pro);
        if(!$final_pro)
        {
            $final_pro = $main_product;
            $sessionKey = 'product_' . $final_pro->p_slug;
            session()->forget($sessionKey);
            session()->put($sessionKey, [
                'dashed_sizes' => $dashed_sizes,
                'dashed_genders' => $dashed_genders,
                'dashed_purities' => $dashed_purities,
                'dashed_m_weights' => $dashed_m_weights,
                'dashed_m_colors' => $dashed_m_colors,
            ]);
            return response()->json(['status' => 1, 'slug' => $final_pro->p_slug]);
        }else{
            $sessionKey = 'product_' . $final_pro->p_slug;
            session()->forget($sessionKey);
            session()->put($sessionKey, [
                'dashed_sizes' => $dashed_sizes,
                'dashed_genders' => $dashed_genders,
                'dashed_purities' => $dashed_purities,
                'dashed_m_weights' => $dashed_m_weights,
                'dashed_m_colors' => $dashed_m_colors,
            ]);
            return response()->json(['status' => 1, 'slug' => $final_pro->p_slug]);
        }
    }
    private function matchConditions($val, $conditions) {
        foreach ($conditions as $condition) {
            if (!isset($condition['value']) || $condition['value'] === '' || $condition['value'] === null) {
                continue;
            }
    
            // Check if the condition is for diamond clarity
            if ($condition['field'] === 'diamond_clarity') {
                // Decode the diamond_details JSON field
                $diamond_details = json_decode($val->diamond_details, true);
    
                // Check if any of the diamond details match the required clarity
                $clarityMatches = false;
                foreach ($diamond_details as $diamond) {
                    if (isset($diamond['attr_clarity']) && $diamond['attr_clarity'] === $condition['value']) {
                        $clarityMatches = true;
                        break;
                    }
                }
    
                if (!$clarityMatches) {
                    return false;
                }
            } else {
                // Regular field check
                if ($val->{$condition['field']} != $condition['value']) {
                    return false;
                }
            }
        }
        return true;
    }
}
