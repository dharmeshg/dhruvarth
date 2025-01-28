<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\BusinessSetting;
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
use App\Models\Gender;
use App\Models\Unit;
use App\Models\Brand;
use App\Models\Theme;
use App\Models\QUnit;
use App\Models\WUnit;
use App\Models\Laboratory;
use App\Models\ProductNature;
use App\Models\ProductFancyColor;
use App\Models\ProductColor;
use App\Models\ProductShape;
use App\Models\ProductClarity;
use App\Models\ProductCut;
use App\Models\ProductSetting;
use App\Models\ProductPearl;
use App\Models\ProductGrade;
use App\Models\ProductGemstone;
use App\Models\PopularGemstone;
use App\Models\GemstoneTreatment;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use Illuminate\Support\Str;
use DateTime;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Response;
use App\Events\ProductAccessChanged;

class ProductController extends Controller
{
    public function dash_index()
    {
        return view('products.dash_index');
    }
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
        return view('products.index',compact('categories','gemstone','families','v_products'));
    }

    public function add()
    {
        $slug = 'simple';
        $categories = Category::all();
        $occasions = Occasion::all();
        $trends = Trend::all();
        $countries = Country::all();
        $metal_paurities = MetalPurity::all();
        $metals = Metal::all();
        $styles = Style::all();
        $designes = Designe::all();
        $diamond_types = DynamicDiamondType::all();
        $setting = Setting::first();
        $genders = Gender::all();
        $units = Unit::all();
        $brands = Brand::all();
        $themes = Theme::all();
        $munits = Unit::all();
        $qunits = QUnit::all();
        $gunits = WUnit::all();
        $nunits = WUnit::all();
        $mwunits = WUnit::all();
        $labs = Laboratory::all();
        $diamond_natures = ProductNature::where('type', 'diamond')->get();
        $diamond_fancy_colors = ProductFancyColor::where('type', 'diamond')->get();
        $diamond_colors = ProductColor::where('type', 'diamond')->get();
        $diamond_shapes = ProductShape::where('type', 'diamond')->get();
        $diamond_claritys = ProductClarity::where('type', 'diamond')->get();
        $diamond_cuts = ProductCut::where('type', 'diamond')->get();
        $diamond_settings = ProductSetting::where('type', 'diamond')->get();
        $gem_natures = ProductNature::where('type', 'gemstone')->get();
        $gem_colors = ProductColor::where('type', 'gemstone')->get();
        $gem_shapes = ProductShape::where('type', 'gemstone')->get();
        $gem_settings = ProductSetting::where('type', 'gemstone')->get();
        $gem_gemstones = ProductGemstone::where('type', 'gemstone')->get();
        $gem_claritys = ProductClarity::where('type', 'gemstone')->get();
        $gem_cuts = ProductCut::where('type', 'gemstone')->get();
        $pearl_natures = ProductNature::where('type', 'pearl')->get();
        $pearl_colors = ProductColor::where('type', 'pearl')->get();
        $pearl_shapes = ProductShape::where('type', 'pearl')->get();
        $pearl_settings = ProductSetting::where('type', 'pearl')->get();
        $pearl_pearls = ProductPearl::where('type', 'pearl')->get();
        $pearl_grades = ProductGrade::where('type', 'pearl')->get();
        $popular_gemstones = PopularGemstone::get();
        $gemstone_treatments = GemstoneTreatment::get();
        return view('products.add',compact('slug','categories','occasions','trends','countries','metal_paurities','metals','styles','designes','diamond_types','setting','genders','units','brands','themes','munits','qunits','gunits','nunits','mwunits','labs','diamond_natures','diamond_fancy_colors','diamond_colors','diamond_shapes','diamond_claritys','diamond_cuts','diamond_settings','gem_natures','gem_colors','gem_shapes','gem_settings','gem_gemstones','gem_claritys','gem_cuts','pearl_natures','pearl_colors','pearl_shapes','pearl_settings','pearl_settings','pearl_pearls','pearl_grades','popular_gemstones','gemstone_treatments'));
    }

    public function quickadd()
    {
        $categories = Category::all();
        
        return view('products.quickadd',compact('categories'));

    }
    public function get_family(Request $request)
    {
       $families = Family::whereRaw('FIND_IN_SET(?, category_id)', $request->cat)->get(); 
       return response()->json(['families' => $families]);
    }
    public function all_data(Request $request)
    {
        // dd($request->all());
        $families = Family::whereRaw('FIND_IN_SET(?, category_id)', $request->cat)->get();
        $diamond_natures = ProductNature::where('type', 'diamond')->get();
        $diamond_fancy_colors = ProductFancyColor::where('type', 'diamond')->get();
        $diamond_colors = ProductColor::where('type', 'diamond')->get();
        $diamond_shapes = ProductShape::where('type', 'diamond')->get();
        $diamond_claritys = ProductClarity::where('type', 'diamond')->get();
        $diamond_cuts = ProductCut::where('type', 'diamond')->get();
        $diamond_settings = ProductSetting::where('type', 'diamond')->get();
        $gem_natures = ProductNature::where('type', 'gemstone')->get();
        $gem_colors = ProductColor::where('type', 'gemstone')->get();
        $gem_shapes = ProductShape::where('type', 'gemstone')->get();
        $gem_settings = ProductSetting::where('type', 'gemstone')->get();
        $gem_gemstones = ProductGemstone::where('type', 'gemstone')->get();
        $gem_claritys = ProductClarity::where('type', 'gemstone')->get();
        $gem_cuts = ProductCut::where('type', 'gemstone')->get();
        $pearl_natures = ProductNature::where('type', 'pearl')->get();
        $pearl_colors = ProductColor::where('type', 'pearl')->get();
        $pearl_shapes = ProductShape::where('type', 'pearl')->get();
        $pearl_settings = ProductSetting::where('type', 'pearl')->get();
        $pearl_pearls = ProductPearl::where('type', 'pearl')->get();
        $pearl_grades = ProductGrade::where('type', 'pearl')->get();
        $popular_gemstones = PopularGemstone::get();
        $gemstone_treatments = GemstoneTreatment::get();
        if(isset($request->cat) && ($request->cat == '3' || $request->cat == '4' || $request->cat == '5'))
        {
            if(isset($request->cat) && $request->cat == '3')
            {
                $type = 'Diamond';
                $diamond_types = DynamicDiamondType::all();
                $htmlContent = View::make('products.editdiamond', ['diamond_types' => $diamond_types,'families' => $families,'type' => $type,'diamond_types' => $diamond_types,'diamond_natures' => $diamond_natures,'diamond_fancy_colors' => $diamond_fancy_colors,'diamond_colors' => $diamond_colors,'diamond_shapes' => $diamond_shapes,'diamond_claritys' => $diamond_claritys,'diamond_cuts' => $diamond_cuts,'diamond_settings' => $diamond_settings])->render();
            }
            if(isset($request->cat) && $request->cat == '4')
            {
                $type = 'Gemstone';
                $htmlContent = View::make('products.editgemstone', ['families' => $families,'type' => $type,'gem_natures' => $gem_natures,'gem_colors' => $gem_colors,'gem_shapes' => $gem_shapes,'gem_settings' => $gem_settings,'gem_gemstones' => $gem_gemstones,'gem_claritys' => $gem_claritys,'gem_cuts' => $gem_cuts])->render();
            }
            if(isset($request->cat) && $request->cat == '5')
            {
                $type = 'Pearl';
                $htmlContent = View::make('products.editpearls', ['families' => $families,'type' => $type,'pearl_natures' => $pearl_natures,'pearl_colors' => $pearl_colors,'pearl_shapes' => $pearl_shapes,'pearl_settings' => $pearl_settings,'pearl_pearls' => $pearl_pearls,'pearl_grades' => $pearl_grades])->render();
            }
            $status = 'single';
            // $htmlContent = View::make('products.dimond_detail', ['families' => $families,'type' => $type])->render();
        }elseif(isset($request->cat) && ($request->cat == '1' || $request->cat == '2' || $request->cat == '6' || $request->cat == '7' || $request->cat == '8')){
            $status = 'all';
            $htmlContent = View::make('products.gold_detail', ['families' => $families])->render();
        }elseif(isset($request->cat) && $request->cat == '9'){
            $status = 'loose_gemstones';
        }else{
            $status = 'all';
        }
        return response()->json(['families' => $families,'html' => isset($htmlContent) ? $htmlContent : '','status' => $status,'cat' => $request->cat]);
    }
    public function selected_data(Request $request)
    {
        // dd($request->all());
        $diamond_natures = ProductNature::where('type', 'diamond')->get();
        $diamond_fancy_colors = ProductFancyColor::where('type', 'diamond')->get();
        $diamond_colors = ProductColor::where('type', 'diamond')->get();
        $diamond_shapes = ProductShape::where('type', 'diamond')->get();
        $diamond_claritys = ProductClarity::where('type', 'diamond')->get();
        $diamond_cuts = ProductCut::where('type', 'diamond')->get();
        $diamond_settings = ProductSetting::where('type', 'diamond')->get();
        $gem_natures = ProductNature::where('type', 'gemstone')->get();
        $gem_colors = ProductColor::where('type', 'gemstone')->get();
        $gem_shapes = ProductShape::where('type', 'gemstone')->get();
        $gem_settings = ProductSetting::where('type', 'gemstone')->get();
        $gem_gemstones = ProductGemstone::where('type', 'gemstone')->get();
        $gem_claritys = ProductClarity::where('type', 'gemstone')->get();
        $gem_cuts = ProductCut::where('type', 'gemstone')->get();
        $pearl_natures = ProductNature::where('type', 'pearl')->get();
        $pearl_colors = ProductColor::where('type', 'pearl')->get();
        $pearl_shapes = ProductShape::where('type', 'pearl')->get();
        $pearl_settings = ProductSetting::where('type', 'pearl')->get();
        $pearl_pearls = ProductPearl::where('type', 'pearl')->get();
        $pearl_grades = ProductGrade::where('type', 'pearl')->get();
        if(isset($request->checked) && $request->checked != '' && $request->checked != null)
        {
            $d_dynamic = false;
            if($request->checked == 'diamond_fix')
            {
                $htmlContent = View::make('products.editdiamond',['diamond_natures' => $diamond_natures,'diamond_fancy_colors' => $diamond_fancy_colors,'diamond_colors' => $diamond_colors,'diamond_shapes' => $diamond_shapes,'diamond_claritys' => $diamond_claritys,'diamond_cuts' => $diamond_cuts,'diamond_settings' => $diamond_settings])->render();

            }else if($request->checked == 'diamond_dynamic')
            {
                $d_dynamic = true;
                $diamond_types = DynamicDiamondType::all();
                $htmlContent = View::make('products.editdiamond', ['d_dynamic' => $d_dynamic,'diamond_types' => $diamond_types,'diamond_natures' => $diamond_natures,'diamond_fancy_colors' => $diamond_fancy_colors,'diamond_colors' => $diamond_colors,'diamond_shapes' => $diamond_shapes,'diamond_claritys' => $diamond_claritys,'diamond_cuts' => $diamond_cuts,'diamond_settings' => $diamond_settings])->render();

            }else if($request->checked == 'gemstone')
            {
                $htmlContent = View::make('products.editgemstone',['gem_natures' => $gem_natures,'gem_colors' => $gem_colors,'gem_shapes' => $gem_shapes,'gem_settings' => $gem_settings,'gem_gemstones' => $gem_gemstones,'gem_claritys' => $gem_claritys,'gem_cuts' => $gem_cuts])->render();

            }else if($request->checked == 'pearl')
            {
                $htmlContent = View::make('products.editpearls',['pearl_natures' => $pearl_natures,'pearl_colors' => $pearl_colors,'pearl_shapes' => $pearl_shapes,'pearl_settings' => $pearl_settings,'pearl_pearls' => $pearl_pearls,'pearl_grades' => $pearl_grades])->render();
            }
            return response()->json(['status' => 1 ,'html' => isset($htmlContent) ? $htmlContent : '', 'message' => 'Data Get']);
        }else{
            return response()->json(['status' => 0 ,'message' => 'Something Went Wrong!']);
        }
    }

    public function get_rate(Request $request)
    {
        $metal_rate = MetalRate::where('purity',$request->val)->first();
        return response()->json(['rate' => $metal_rate->rate]);
    }
    public function get_tag(Request $request)
    {
        $tags = Tags::all();
        return response()->json(['tags' => $tags]);
    }
    public function save(Request $request)
    {
        $input = $request->all();
        $diamond_data = [];
        $gemstone_data = [];
        $pearl_data = [];
        $contry_data = [];
        $deliver_data = [];

        if(($request->attr_type_hidden && $request->attr_type_hidden != '' && $request->attr_type_hidden != null))
        {
            foreach($request->attr_type_hidden as $key => $item)
            {
                $diamond_data[] = [
                    "attr_type" => isset($request->attr_type[$key]) ? $request->attr_type[$key] : '',
                    "attr_type_dynamic" => isset($request->attr_type_dynamic[$key]) ? $request->attr_type_dynamic[$key] : '',
                    "attr_type_quality" => isset($request->attr_type_quality[$key]) ? $request->attr_type_quality[$key] : '',
                    "attr_fancy_color" => isset($request->attr_fancy_color[$key]) ? $request->attr_fancy_color[$key] : '',
                    "attr_color" => isset($request->attr_color[$key]) ? $request->attr_color[$key] : '',
                    "attr_diamond_caret" => isset($request->attr_diamond_caret[$key]) ? $request->attr_diamond_caret[$key] : '',
                    "attr_gemstone" => isset($request->attr_gemstone[$key]) ? $request->attr_gemstone[$key] : '',
                    "attr_shape" => isset($request->attr_shape[$key]) ? $request->attr_shape[$key] : '',
                    "attr_clarity" => isset($request->attr_clarity[$key]) ? $request->attr_clarity[$key] : '',
                    "attr_cut" => isset($request->attr_cut[$key]) ? $request->attr_cut[$key] : '',
                    "attr_setting" => isset($request->attr_setting[$key]) ? $request->attr_setting[$key] : '',
                    "attr_total_diamond_count" => isset($request->attr_total_diamond_count[$key]) ? $request->attr_total_diamond_count[$key] : '',
                    "attr_total_diamond_wight" => isset($request->attr_total_diamond_wight[$key]) ? $request->attr_total_diamond_wight[$key] : '',
                    "attr_diamond_per_carat" => isset($request->attr_diamond_per_carat[$key]) ? $request->attr_diamond_per_carat[$key] : '',
                    "attr_final_diamond_price" => isset($request->attr_final_diamond_price[$key]) ? $request->attr_final_diamond_price[$key] : '',
                ];
            }
            $diamond_json = json_encode($diamond_data);
        }else{
            $diamond_json = null;
        }
        if($request->attr_gemstone_hidden && $request->attr_gemstone_hidden != '' && $request->attr_gemstone_hidden != null)
        {
            foreach($request->attr_gemstone_hidden as $key => $item)
            {
                $gemstone_data[] = [
                    "attr_gemstone_type" => isset($request->attr_gemstone_type[$key]) ? $request->attr_gemstone_type[$key] : '',
                    "attr_gemstone_color" => isset($request->attr_gemstone_color[$key]) ? $request->attr_gemstone_color[$key] : '',
                    "attr_gemstone_caret" => isset($request->attr_gemstone_caret[$key]) ? $request->attr_gemstone_caret[$key] : '',
                    "attr_gemstone_gem" => isset($request->attr_gemstone_gem[$key]) ? $request->attr_gemstone_gem[$key] : '',
                    "attr_gemstone_shape" => isset($request->attr_gemstone_shape[$key]) ? $request->attr_gemstone_shape[$key] : '',
                    "attr_gemstone_clarity" => isset($request->attr_gemstone_clarity[$key]) ? $request->attr_gemstone_clarity[$key] : '',
                    "attr_gemstone_cut" => isset($request->attr_gemstone_cut[$key]) ? $request->attr_gemstone_cut[$key] : '',
                    "attr_gemstone_setting" => isset($request->attr_gemstone_setting[$key]) ? $request->attr_gemstone_setting[$key] : '',
                    "attr_gemstone_total_gem_count" => isset($request->attr_gemstone_total_gem_count[$key]) ? $request->attr_gemstone_total_gem_count[$key] : '',
                    "attr_gemstone_total_wight" => isset($request->attr_gemstone_total_wight[$key]) ? $request->attr_gemstone_total_wight[$key] : '',
                    "gemstone_price_carat" => isset($request->gemstone_price_carat[$key]) ? $request->gemstone_price_carat[$key] : '',
                    "gemstone_final_total" => isset($request->gemstone_final_total[$key]) ? $request->gemstone_final_total[$key] : '',
                ];
            }
            $gemstone_json = json_encode($gemstone_data);
        }else{
            $gemstone_json = null;
        }
        if($request->attr_pearl_hidden && $request->attr_pearl_hidden != '' && $request->attr_pearl_hidden != null)
        {
            foreach($request->attr_pearl_hidden as $key => $item)
            {
                $pearl_data[] = [
                    "attr_pearl_type" => isset($request->attr_pearl_type[$key]) ? $request->attr_pearl_type[$key] : '',
                    "attr_pearl_color" => isset($request->attr_pearl_color[$key]) ? $request->attr_pearl_color[$key] : '',
                    "attr_pearl_caret" => isset($request->attr_pearl_caret[$key]) ? $request->attr_pearl_caret[$key] : '',
                    "attr_pearl_gem" => isset($request->attr_pearl_gem[$key]) ? $request->attr_pearl_gem[$key] : '',
                    "attr_pearl_shape" => isset($request->attr_pearl_shape[$key]) ? $request->attr_pearl_shape[$key] : '',
                    "attr_pearl_grade" => isset($request->attr_pearl_grade[$key]) ? $request->attr_pearl_grade[$key] : '',
                    "attr_pearl_setting" => isset($request->attr_pearl_setting[$key]) ? $request->attr_pearl_setting[$key] : '',
                    "attr_pearl_total_gem_count" => isset($request->attr_pearl_total_gem_count[$key]) ? $request->attr_pearl_total_gem_count[$key] : '',
                    "attr_pearl_total_wight" => isset($request->attr_pearl_total_wight[$key]) ? $request->attr_pearl_total_wight[$key] : '',
                    "pearl_price_carat" => isset($request->pearl_price_carat[$key]) ? $request->pearl_price_carat[$key] : '',
                    "pearl_final_total" => isset($request->pearl_final_total[$key]) ? $request->pearl_final_total[$key] : '',
                ];
            }
            $pearl_json = json_encode($pearl_data);
        }else{
            $pearl_json = null;
        }
        if($request->p_tax_contry && $request->p_tax_contry != '' && $request->p_tax_contry != null)
        {
            foreach($request->p_tax_contry as $key => $item)
            {
                $contry_data[] = [
                    "p_tax_contry" => isset($item) ? $item : '',
                    "p_int_tax" => isset($request->p_int_tax[$key]) ? $request->p_int_tax[$key] : '',
                    "p_int_above" => isset($request->p_int_above[$key]) ? $request->p_int_above[$key] : '',
                ];
            }
            $contry_json = json_encode($contry_data);
        }
        if($request->p_deliver_contry && $request->p_deliver_contry != '' && $request->p_deliver_contry != null)
        {
            foreach($request->p_deliver_contry as $key => $item)
            {
                $deliver_data[] = [
                    "p_deliver_contry" => isset($item) ? implode(',', $item) : '',
                    "p_deliver_state" => isset($request->p_deliver_state[$key]) ? implode(',', $request->p_deliver_state[$key]) : '',
                    "p_deliver_city" => isset($request->p_deliver_city[$key]) ? implode(',', $request->p_deliver_city[$key]) : '',
                    "p_deliver_code" => isset($request->p_deliver_code[$key]) ? implode(',', $request->p_deliver_code[$key]) : '',
                    "p_deliver_duration" => isset($request->p_deliver_duration[$key]) ? implode(',',$request->p_deliver_duration[$key]) : '',
                ];
            }
            $deliver_json = json_encode($deliver_data);
        }
        if ($request->hasFile('p_video')) {
                $uploadvideo = $request->file('p_video');
                $video_name = $request->p_sku.'_1.'. $uploadvideo->getClientOriginalExtension();
                $uploadvideo->move('product_media/product_videos/', $video_name);
                $videoName = $video_name;
        }else{
            $videoName = isset($request->old_p_video) ? $request->old_p_video : null;
        }
        if ($request->hasFile('p_certificate_file')) {
                $current = Carbon::now()->format('YmdHs');
                $uploadcerti = $request->file('p_certificate_file');
                $certi_name = $request->p_sku.'_1.'. $uploadcerti->getClientOriginalExtension();
                $uploadcerti->move('product_media/product_certificates/', $certi_name);
                $certiName = $certi_name;
        }else{
            $certiName = isset($request->p_certi_old) ? $request->p_certi_old : null;

        }

        $buyIcons = [];
        if(isset($request->buy_title) && count($request->buy_title) > 0)
        {
            foreach($request->buy_title as $key =>$buy_img)
            {
                if (array_key_exists($key, $request->file('buy_icon') ?? [])) {
                    dump('14');
                    $current = Carbon::now()->format('YmdHs');
                    $uploadpdf = $request->file('buy_icon')[$key];
                    $extension = $uploadpdf->getClientOriginalExtension();
                    $filename = $current . '_' . $key . '.' . $extension;
                    $uploadpdf->move('product_media/product_icons/', $filename);
                }else{
                    $filename = isset($request->old_buy_icon[$key]) ? $request->old_buy_icon[$key] : '';
                }
                    $buyIcon = [
                        'title' => isset($request->buy_title[$key]) ? $request->buy_title[$key] : '',
                        'icon' => isset($filename) ? $filename : '',
                    ];
                    $buyIcons[] = $buyIcon;
            }
            $icon_json = json_encode($buyIcons);
        }
      
        if (isset($request->p_pricetype) && $request->p_pricetype == 'fix_price'  && $request->p_pricetype != '' && $request->p_pricetype != null )
        {
            $input['p_grand_price_total'] = isset($request->p_fix_price) ? $request->p_fix_price  : null;
        }   
        
        $input['db_status'] = 'manually';
        $input['diamond_details'] = isset($diamond_json) ? $diamond_json : null;
        $input['gemstone_details'] = isset($gemstone_json) ? $gemstone_json : null;
        $input['pearl_details'] = isset($pearl_json) ? $pearl_json : null;
        $input['p_video'] = isset($videoName) ? $videoName : null;
        $input['p_certificate_file'] = isset($certiName) ? $certiName : null;
        $input['p_inter_taxes'] = isset($contry_json) ? $contry_json : null;
        $input['delivery_details'] = isset($deliver_json) ? $deliver_json : null;
        $input['buy_with_confidence_sec'] = isset($icon_json) ? $icon_json : null;
        $input['visiblity'] = 1;
        if(isset($request->publish) && $request->publish =='yes')
        {
          $input['publish_status'] = 'publish';  
        }else{
          $input['publish_status'] = 'draft';  
        }
        if(isset($request->p_status) && $request->p_status != null)
        {
            $input['p_status'] = $request->p_status;
        }else{
            $input['p_status'] = 'by_order';
        }
        $check = Product::where('p_slug', $request->p_slug)->first();
        if(isset($request->product_id) && $request->product_id != null && $request->product_id != '')
        {
            if(isset($request->product_type) && $request->product_type == 'simple')
            {
                $product = Product::findOrfail($request->product_id);
            }else{
                $product = VariantProduct::findOrfail($request->product_id);
            }
            $input['db_status'] = isset($product->db_status) ? $product->db_status : 'manually';
            if ($request->hasFile('p_image')) {
                $input['db_status'] = 'manually';
            }

            if(isset($product->p_slug) && $product->p_slug != $request->p_slug)
            {
                $old_slug = new OldSlug();
                $old_slug->product_id = $product->id;
                $old_slug->old_slug = $product->p_slug;
                $old_slug->save();
            }
            if (isset($check) && $request->product_id == $check->id) {
                $slug_update = $request->p_slug;
                $slug = Str::slug($slug_update, '-');
            }else{
                $slug = $request->p_slug;
            }
            $input['p_slug'] = $slug;
            $product->update($input);
            $product_imgcount = ProductImage::where('product_id', $product->id)->where('type',$request->product_type)->orderBy('id','DESC')->first();
            $stpr = 1;

            if($product_imgcount){
                $ex = explode('.',$product_imgcount->name);
                $ex2 = explode('-',$ex[0]);
                if(end($ex2) < 500 && is_numeric(end($ex2))){
                    $stpr = end($ex2) + 1;
                }   
            }

        }else{
            if (isset($request->p_title) && $request->p_title != "") {
                if(isset($request->product_type) && $request->product_type == 'simple')
                {
                    $slug = SlugService::createSlug(Product::class, 'p_slug', $request->p_title);
                }else{
                    $slug = SlugService::createSlug(VariantProduct::class, 'p_slug', $request->p_title);
                }
            }else{
                $slug = "";
            }
            // $slug = SlugService::createSlug(Product::class, 'p_slug', $request->p_title);
            $input['p_slug'] = $slug;
            if(isset($request->product_type) && $request->product_type == 'simple')
            {
                $product = Product::create($input);
            }else{
                $product = VariantProduct::create($input);
            }
            $stpr = 1;
        }

        if ($request->hasFile('p_image')) {

            $uploadedFiles = [];
            foreach ($request->file('p_image') as $fkey => $file) {
                $uploadpdf = $file;
                //$image = $request->p_sku.'_'.$current . $uploadpdf->getClientOriginalName();
                $fileHash = md5_file($file->getRealPath());
                $image = $request->p_sku.'-'.$stpr.'.'.$uploadpdf->getClientOriginalExtension();
                if (!in_array($fileHash, $uploadedFiles)) {
                    $stpr++;
                    $uploadpdf->move('product_media/product_images/', $image);
                    $uploadedFiles[] = $fileHash;
                    $imageName = $image;

                    $product_img = new ProductImage();
                    $product_img->product_id = isset($product->id) ? $product->id : null ;
                    $product_img->name = isset($imageName) ? $imageName : null ;
                    $product_img->type = $request->product_type;
                    $product_img->save();

                    $manager = new ImageManager(new Driver());
                    $image = $manager->read(base_path('/public/product_media/product_images/').$imageName);

                    $image = $image->resize(300,300);
                    $image->save(base_path('/public/product_media/product_images/300/'.$imageName));
                }
            }
        }
        if(isset($request->p_tags) && $request->p_tags != 'NULL' && $request->p_tags != null)
        {
            $tags = explode(',',$request->p_tags);
            foreach($tags as $tag)
            {
                $check_tag = Tags::where('name',$tag)->first();
                if(isset($check_tag) && $check_tag != null && $check_tag != '')
                {
                    $p_tag = Tags::findOrfail($check_tag->id);
                }else{
                    $p_tag = new Tags();
                }
                $slug = SlugService::createSlug(Tags::class, 'slug', $tag);
                $p_tag->name = isset($tag) ? $tag : null;
                $p_tag->slug = isset($slug) ? $slug : null;
                $p_tag->save();
            }
        }
        if(isset($request->product_type) && $request->product_type == 'simple')
        {
            return redirect()->route('product.index')->with('success','Product Saved Successfully!');
        }else{
            return redirect()->route('variant.index')->with('success','Variant Saved Successfully!');
        }
        
    }

    public function list(Request $request)
    {
     
        // dd($request->all());
        $perPage = $request->input('length', 10);
        $page = $request->input('start', 0) / $perPage;
        $query = Product::select('*');

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
        $totalRecords = $query->count();
        $product_list = $query->with('category')
                            ->latest()
                            ->skip($page * $perPage)
                            ->take($perPage)
                            ->get();
        $counter = $page * $perPage + 1;
        $product_list->transform(function ($item) use (&$counter, &$request) {
            $item['ser_id'] = $counter++;

            $p_image = ProductImage::where('product_id',$item['id'])->where('type','simple')->first();
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
                $item['visiblity'] = '<input type="checkbox" data-id="' . $item['id'] . '" data-type="simple" data-toggle="toggle" id="visiblity"  checked class="is_featured_class">';
            } else {
                $item['visiblity'] = '<input type="checkbox" data-id="' . $item['id'] . '" data-type="simple" data-toggle="toggle" id="visiblity"  class="is_featured_class">';
            }
            if ($item['is_public'] == '1') {
                $item['public_private'] = '<input type="checkbox" data-id="' . $item['id'] . '" data-type="simple" data-toggle="toggle" id="public_private" checked class="is_featured_class">';
            }else{
                $item['public_private'] = '<input type="checkbox" data-id="' . $item['id'] . '" data-type="simple" data-toggle="toggle" id="public_private"  class="is_featured_class">';
            }
            $item['variant'] = '<button class="btn table-filter-btn add_variant" type="button" data-id="' . $item['id'] . '">Add Variant</button>';
            $item['action'] = '<div class="action_div"><a href="' . route('product.edit', ['id' => $item['id'], 'slug' => 'simple']) . '" class="table-btn table-btn1 mx-2 edit" data-id="' . $item['id'] . '" title="Click here to Edit Product" ><img src="'.asset('images/dashbord/create.png').'" class="image-fuild" alt="user-img"></a>';
            $item['action'] .= '<a data-id="'.$item['id'].'" href="javascript:;" data-href="' . route('product.delete', ['id' => $item['id'], 'slug' => 'simple']) . '" class="table-btn table-btn1 delete"><img src="'.asset('images/dashbord/delete.png').'" title="Click here to Delete Product" class="image-fuild" alt="user-img"></a></div>';
            return $item;
        });
        
        return response()->json([
        'draw' => $request->input('draw'),
        'recordsTotal' => $totalRecords,
        'recordsFiltered' => $totalRecords, // For simplicity, assuming no filtering is applied
        'data' => $product_list,
    ]);
    }

    public function edit($id, $slug)
    {
        if(isset($slug) && $slug == 'simple')
        {
            $product = Product::findOrfail($id);
        }else{
            $product = VariantProduct::findOrfail($id);
        }
        $product_imgs = ProductImage::where('product_id',$product->id)->where('type',$slug)->get();
        $categories = Category::all();
        $occasions = Occasion::all();
        $trends = Trend::all();
        $countries = Country::all();
        $metal_paurities = MetalPurity::all();
        $metals = Metal::all();
        $styles = Style::all();
        $designes = Designe::all();
        $diamond_types = DynamicDiamondType::all();
        $setting = Setting::first();
        $genders = Gender::all();
        $units = Unit::all();
        $brands = Brand::all();
        $themes = Theme::all();
        $munits = Unit::all();
        $qunits = QUnit::all();
        $gunits = WUnit::all();
        $nunits = WUnit::all();
        $mwunits = WUnit::all();
        $labs = Laboratory::all();
        $diamond_natures = ProductNature::where('type', 'diamond')->get();
        $diamond_fancy_colors = ProductFancyColor::where('type', 'diamond')->get();
        $diamond_colors = ProductColor::where('type', 'diamond')->get();
        $diamond_shapes = ProductShape::where('type', 'diamond')->get();
        $diamond_claritys = ProductClarity::where('type', 'diamond')->get();
        $diamond_cuts = ProductCut::where('type', 'diamond')->get();
        $diamond_settings = ProductSetting::where('type', 'diamond')->get();
        $gem_natures = ProductNature::where('type', 'gemstone')->get();
        $gem_colors = ProductColor::where('type', 'gemstone')->get();
        $gem_shapes = ProductShape::where('type', 'gemstone')->get();
        $gem_settings = ProductSetting::where('type', 'gemstone')->get();
        $gem_gemstones = ProductGemstone::where('type', 'gemstone')->get();
        $gem_claritys = ProductClarity::where('type', 'gemstone')->get();
        $gem_cuts = ProductCut::where('type', 'gemstone')->get();
        $pearl_natures = ProductNature::where('type', 'pearl')->get();
        $pearl_colors = ProductColor::where('type', 'pearl')->get();
        $pearl_shapes = ProductShape::where('type', 'pearl')->get();
        $pearl_settings = ProductSetting::where('type', 'pearl')->get();
        $pearl_pearls = ProductPearl::where('type', 'pearl')->get();
        $pearl_grades = ProductGrade::where('type', 'pearl')->get();
        $popular_gemstones = PopularGemstone::get();
        $gemstone_treatments = GemstoneTreatment::get();
        // $qunits = QUnit::all();
        return view('products.add',compact('product','slug','product_imgs','categories','occasions','trends','countries','metal_paurities','metals','styles','designes','diamond_types','setting','genders','units','brands','themes','munits','qunits','gunits','nunits','mwunits','labs','diamond_natures','diamond_fancy_colors','diamond_colors','diamond_shapes','diamond_claritys','diamond_cuts','diamond_settings','gem_natures','gem_colors','gem_shapes','gem_settings','gem_gemstones','gem_claritys','gem_cuts','pearl_natures','pearl_colors','pearl_shapes','pearl_settings','pearl_settings','pearl_pearls','pearl_grades','popular_gemstones','gemstone_treatments'));
    }

    public function sku_check(Request $request)
    {
        // dd($request->all());
        $sku = Product::where('p_sku',$request->sku)->first();
        if(isset($sku) && $sku != '' && $sku != null)
        {
            $url = route('product.edit',$sku->id);
            return response()->json(['message'=> 'This Product Sku is already taken.','url' => $url, 'status' => 1]);
        }else{
            return response()->json(['status' => 0]);
        }
    }

    public function del_image(Request $request)
    {
        // dd($request->all());
        $img = ProductImage::where('id',$request->del_img_id)->first();
        if(isset($img) && $img != '' && $img != null)
        {
            $file_path_m = public_path('uploads/' . $img->name);
            if (File::exists(public_path('uploads/' . $img->name))) {
                File::delete($file_path_m);
            }
            $img->delete();
            return response()->json(['status' => 1, 'message' => 'Image Deleted Successfully!']);
        }else{
            return response()->json(['status' => 0, 'message' => 'Something Went Wrong!']);
        }
    }

    public function delete($id,$slug)
    {
        if($slug && $slug == 'simple')
        {
            $product = Product::where('id',$id)->first();
        }else{
            $product = VariantProduct::where('id',$id)->first();
        }
        
        if(isset($product) && $product != null && $product != '')
        {
            $order = OrderItems::where('product_id',$product->id)->where('product_type',$slug)->delete();
            $cart = Cart::where('product_id',$product->id)->where('product_type',$slug)->delete();
            $wishlist = WishList::where('product_id',$product->id)->where('product_type',$slug)->delete();
            $p_imgs = ProductImage::where('product_id',$product->id)->where('type',$slug)->get();
            if($slug && $slug == 'simple')
            {
                $variants = VariantProduct::where('parent_product_id',$product->id)->delete();
            }
            if(isset($p_imgs) && count($p_imgs) > 0)
            {
                foreach($p_imgs as $img)
                {
                    $file_path_m = public_path('uploads/' . $img->name);
                    if (File::exists(public_path('uploads/' . $img->name))) {
                        File::delete($file_path_m);
                    }
                    $img->delete();
                }
            }
            $product->delete();
            if($slug && $slug == 'simple')
            {
                return redirect()->route('product.index')->with('error','Product Deleted Successfully!');
            }else{
                return redirect()->route('variant.index')->with('error','Variant Deleted Successfully!');
            }    
        }else{
            return redirect()->route('product.index')->with('error','Something Went Wrong!');
        }
    }

    public function status(Request $request)
    {
        // dd($request->all());
        if(isset($request->type) && $request->type == 'simple')
        {
            $product = Product::where('id',$request->id)->first();
        }else{
            $product = VariantProduct::where('id',$request->id)->first();
        }
        if(isset($product) && $product != null && $product != '')
        {
           // $status = isset($request->isChecked) && $request->isChecked == 'true' ? 1 : 0;
            if (isset($product->visiblity) && $product->visiblity != 1) {
                 $product->update(['visiblity' => 1 ]); 
            }else{
               $product->update(['visiblity' => 0 ]);  
            }
           // $product->update(['visiblity' => $status]); 
           return response()->json(['status' => 1, 'message' => 'Status Updated Successfully']);
        }
        else{
            return response()->json(['status' => 0, 'message' => 'Something Went Wrong!']);
        }
    }
    public function update_public(Request $request)
    {
        if(isset($request->type) && $request->type == 'simple')
        {
            $product = Product::where('id',$request->id)->first();
        }else{
            $product = VariantProduct::where('id',$request->id)->first();
        }
        if(isset($product) && $product != null && $product != '')
        {
           // $status = isset($request->isChecked) && $request->isChecked == 'true' ? 1 : 0;
            if (isset($product->is_public) && $product->is_public != 1) {
                 $product->update(['is_public' => 1 ]); 
            }else{
               $product->update(['is_public' => 0 ]);  
            }
           // $product->update(['visiblity' => $status]); 
           return response()->json(['status' => 1, 'message' => 'Status Updated Successfully']);
        }
        else{
            return response()->json(['status' => 0, 'message' => 'Something Went Wrong!']);
        }
    }

    public function get_delivery(Request $request)
    {
        // dd($request->all());
        $countries = Country::all();
        $htmlContent = View::make('products.delivery_sec', ['countries' => $countries,'counter' => $request->counter,])->render();
        return response()->json(['counter' => $request->counter,'countries' => $countries,'html' => isset($htmlContent) ? $htmlContent : '','status' => 1]);
    }
    public function get_delivery_city(Request $request)
    {
        // dd($request->state);
        $city = Citie::whereIn('state_id', $request->state)->get();
        // dd($zip_codes);
        if(isset($city) && count($city) > 0 && $city->isNotEmpty())
        {
            return response()->json(['status' => 1, 'city' => $city]);
        }else{
            return response()->json(['status' => 0]);
        }
    }
    public function get_delivery_zip(Request $request)
    {
        // dd($request->state);
        $zip_codes = DeliveryZip::whereIn('city', $request->city)->get();
        // dd($zip_codes);
        if(isset($zip_codes) && count($zip_codes) > 0 && $zip_codes->isNotEmpty())
        {
            return response()->json(['status' => 1, 'zip' => $zip_codes]);
        }else{
            return response()->json(['status' => 0]);
        }
    }
    public function diamond_rate(Request $request)
    {
        // dd($request->all());
        if(isset($request->d_type) && $request->d_type != '' && $request->d_type != null)
        {
            $type = DynamicDiamondType::where('id',$request->d_type)->first();
            if(isset($type) && $type != '' && $type != null)
            {
                $query = DiamondRate::where('type',$type->id)->where('status',1);
                if(isset($request->d_quality) && $request->d_quality != '' && $request->d_quality != null)
                {
                    $query->where('quality',$request->d_quality);
                }
                $rate = $query->first();
                if(isset($rate) && $rate != null && $rate != '')
                {
                    return response()->json(['status' => 1, 'rate' => $rate, 'message' => 'get data']);
                }else{
                    return response()->json(['status' => 0, 'message' => 'Please Add Rate for This Diamond Type!']);
                }
            }else{
                return response()->json(['status' => 0,'message' => 'Something Went Wrong!']);
            }
            
        }
    }
    public function get_variant_html(Request $request)
    {
        $metal_paurities = MetalPurity::all();
        $checked_attributes = $request->checkedValues;
        $metals = Metal::all();
        $r_html = View::make('products.each_variant',['metal_paurities'=>$metal_paurities,'metals'=>$metals,'checked_attributes'=>$checked_attributes])->render();
        return response()->json(['status' => 1, 'html' => $r_html]);
    }
    public function store_variants(Request $request)
    {
        // dd($request->all());
        $parent_product_id = $request->variant_product_id;
        $child_product_id = $request->variant_child_product;
        $main_attributes = implode(',',$request->main_attr);
        
        $diamond_arr = [];
        $pearl_attr = [];
        $gemstone_attr = [];
        $attributes = [
            'diamond' => ['color', 'clarity', 'carat', 'composition'],
            'pearl' => ['color', 'clarity', 'carat', 'composition'],
            'gemstone' => ['color', 'clarity', 'carat', 'composition']
        ];
        if(isset($request->attr_t_type) && count($request->attr_t_type) > 0)
        {
            foreach ($request->attr_t_type as $type) {
                if ($type == 'diamond') {
                    foreach ($attributes['diamond'] as $attribute) {
                        $inputName = "{$type}_{$attribute}";
                        if ($request->has($inputName) && $request->$inputName == 'on') {
                            $diamond_arr[] = $attribute;
                        }
                    }
                } elseif ($type == 'pearl') {
                    foreach ($attributes['pearl'] as $attribute) {
                        $inputName = "{$type}_{$attribute}";
                        if ($request->has($inputName) && $request->$inputName == 'on') {
                            $pearl_attr[] = $attribute;
                        }
                    }
                } elseif ($type == 'gemstone') {
                    foreach ($attributes['gemstone'] as $attribute) {
                        $inputName = "{$type}_{$attribute}";
                        if ($request->has($inputName) && $request->$inputName == 'on') {
                            $gemstone_attr[] = $attribute;
                        }
                    }
                }
            }
        }
        $check_child = VariantProduct::where('parent_product_id',$child_product_id)->count();
        if(isset($check_child) && $check_child > 0)
        {
            return response()->json(['status' => 0, 'message' => 'This Product Can not be child as this already have variants!']);
        }
        $product_aatribute = new ProductAttribute();
        $product_aatribute->parent_product_id = $parent_product_id;
        $product_aatribute->attributes = $main_attributes;
        $product_aatribute->diamond_attributes = isset($diamond_arr) ? implode(',',$diamond_arr) : null;
        $product_aatribute->pearl_attributes = isset($pearl_attr) ? implode(',',$pearl_attr) : null;
        $product_aatribute->gemstone_attributes = isset($gemstone_attr) ? implode(',',$gemstone_attr) : null;
        $product_aatribute->save();

        $product = Product::find($child_product_id);
        $variantProduct = new VariantProduct();
        $variantProduct->fill($product->toArray());
        $variantProduct->parent_product_id = $parent_product_id;
        $variantProduct->attr_id = $product_aatribute->id;
        $variantProduct->save();
        $product_images = ProductImage::where('product_id',$child_product_id)->update(['product_id' => $variantProduct->id,'type' => 'variant']);
        $product->delete();
        return response()->json(['status' => 1, 'message' => 'Variant Product Added Successfully.']);
    }
    public function download_xml(Request $request)
    {
        $bs = BusinessSetting::first();
        if(isset($request->type) && $request->type != '' && $request->type != null && $request->type == 'simple')
        {
            $products = Product::with('category')->where('visiblity', 1)->where('is_public', 1)->where(function($query) {
                $query->where('publish_status', 'publish')
                  ->orWhereNull('publish_status');
            })->latest()->get();
            $file_name = $bs->business_name .' -google-product-feed.xml';

        }else{
            $products = VariantProduct::with('category')->where('visiblity', 1)->where('is_public', 1)->where(function($query) {
                $query->where('publish_status', 'publish')
                ->orWhereNull('publish_status');
            })->latest()->get();
            $file_name = $bs->business_name .' -variant-google-product-feed.xml';
        }
        $xmlContent = View::make('products.products_xml', ['products' => $products,'bs' => $bs ,'type' => $request->type])->render();
        $file_path = public_path('uploads/' . $file_name);
        if (File::exists($file_path)) {
            File::delete($file_path);
        }
        file_put_contents($file_path, $xmlContent);
        $file_url = asset('uploads/'. $file_name);
        return response()->json(['file_url' => $file_url]);
    }
    public function check_variant_exists(Request $request)
    {
        $variants = VariantProduct::where('parent_product_id',$request->product_id)->count();
        if(isset($variants) && $variants > 0)
        {
            return response()->json(['status' => 1]);
        }else{
            return response()->json(['status' => 0]);
        }
    }
}
