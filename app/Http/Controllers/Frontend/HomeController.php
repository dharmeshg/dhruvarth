<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Mail;
use App\Mail\MeetingMail;
use App\Mail\SendOtpMail;
use App\Models\Setting;
use App\Models\HomePageSetting;
use App\Models\ProductService;
use App\Models\Testimonial;
use App\Models\Slider;
use App\Models\Married;
use App\Models\Article;
use App\Models\ProjectGallery;
use App\Models\GalleryCategory;
use App\Models\SidebarWidget;
use App\Models\CommentSetting;
use App\Models\Comment;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rule;
use App\Models\Page;
use App\Models\Product;
use App\Models\Collection;
use App\Models\Family;
use App\Models\Catalogue;
use App\Models\Category;
use App\Models\Citie;
use App\Models\SliderBanner;
use App\Models\AboutUsSetting;
use App\Models\ContactUsSetting;
use App\Models\ProductImage;
use App\Models\Order;
use App\Models\MetalPurity;
use App\Models\User;
use App\Models\WishList;
use App\Models\PageBanner;
use App\Models\UserAddress;
use App\Models\Shipping;
use App\Models\DeliveryZip;
use App\Models\State;
use App\Models\Country;
use App\Models\Cart;
use App\Models\VariantProduct;
use App\Models\Gender;
use App\Models\PromoCode;
use Carbon\Carbon;
use App\Models\ShippingCalculation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DB;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Events\AccessChanged;
use App\Events\ProductAccessChanged;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $slider_banner = SliderBanner::where('status' , 1)->orderBy('id','ASC')->get();
        $catalogs = Catalogue::where('status' , 1)->latest()->take(8)->get();
        $collection = Collection::where('status' , 1)->latest()->take(8)->get();
        $testimonials = Testimonial::where('is_featured' , 1)->inRandomOrder()->take(12)->get();
        $products = Product::where('visiblity' , 1)->where(function ($query) {
                      $query->where('publish_status', '!=', 'draft')
                            ->orWhereNull('publish_status');
                  })->where('p_category', '!=', 9)->latest('updated_at')->take(8)->get();

        $order = Order::select('product_id', DB::raw('count(*) as count'))
                        ->groupBy('product_id')->orderByDesc('count')->take(8)->get();
        $sections = HomePageSetting::orderby('order')->where('checked',1)->take(6)->get();

        $sections2 = HomePageSetting::orderby('order')->where('checked',1)->skip(6)->take(50)->get();

        $SEOController = new SEOController();
        $SEOTitleDescription = $SEOController->_seoTitleDescriptionHome();
        $SEOSchemaCode = $SEOController->_seoSchemaCodeHome();

        $products_gemstone = Product::where('visiblity' , 1)->where(function ($query) {
                      $query->where('publish_status', '!=', 'draft')
                            ->orWhereNull('publish_status');
                  })->where('p_category', 9)->latest()->take(8)->get();

        return view('front.home', compact('slider_banner','catalogs','collection','testimonials','products','order','sections','SEOTitleDescription','SEOSchemaCode','products_gemstone','sections2'));

    }
   

    public function store_comment(Request $request)
    {
        $comment = new Comment();
        $comment->blog_id = isset($request->blog_id) ? $request->blog_id: null;
        $comment->parent_id = isset($request->parent_id) ? $request->parent_id: null;
        $comment->user_name = isset($request->user_name) ? $request->user_name: null;
        $comment->user_email = isset($request->user_email) ? $request->user_email: null;
        $comment->subject = isset($request->user_subject) ? $request->user_subject: null;
        $comment->comment = isset($request->user_comment) ? $request->user_comment: null;
        $comment->approved_status = 1;
        $comment->spam_status = 0;
        $comment->save();
        if($comment)
        {
            return response()->json(['data' => $comment, 'message'=> 'Comment Added Sccessfully' ,'status' => 1]);
        }
        else{
            return response()->json(['message'=> 'Somethig Went Wrong!' ,'status' => 0]);
        }
    }
    public function sitemap()
    {
        $pages = Page::where('publish_status','=','Published')->get();
        $services = ProductService::latest()->get();
        $marraiges = Married::where('status', 1)->latest()->get();
        $posts = Article::where('status', 1)->latest()->get();
        return view('front.sitemap',compact('pages','services','marraiges','posts'));
    }

    public function product_details(Request $request)
    {
        $product_id = $request->id;
        $product_details = Family::whereRaw('FIND_IN_SET(?, category_id)', $request->id)
            ->withCount('products')
            ->orderByDesc('products_count')
            ->whereHas('products', function ($query) use ($product_id) {
                $query->where('visiblity', 1)->where(function ($query) {
                      $query->where('publish_status', '!=', 'draft')
                            ->orWhereNull('publish_status');
                  })
                    ->where(function ($query) use ($product_id) {
                        $query->where('p_category', $product_id)
                            ->orWhereRaw('FIND_IN_SET(?, p_sec_category)', [$product_id]);
                    });
            })
            ->get();
        $product_count = [];
        
        $metal_purity_ids = Product::where('p_category', $product_id)->orWhere('p_sec_category', $product_id)->whereNotNull('p_metal_purity')->distinct('p_metal_purity')->pluck('p_metal_purity');
        $metal_purities = MetalPurity::whereIn('id', $metal_purity_ids)->withCount('products')->orderByDesc('products_count')->get();
        
        $product_images = Product::where('visiblity',1)->where(function ($query) {
                      $query->where('publish_status', '!=', 'draft')
                            ->orWhereNull('publish_status');
                  })->where('p_category' , $request->id)
        ->orWhere(function($query) use ($request) {
            $query->whereRaw('FIND_IN_SET(?, p_sec_category)', [$request->id]);
        })
        ->latest()->take(4)->get();
        $category = Category::where('id', $request->id)->first();
       
        $collection = Collection::where('status',1)->latest()->take(6)->get();
        $genders = Gender::all();

        if (isset($product_details)) {
           $htmlVal = view('front.include.product', compact('product_details','collection','product_images','product_id','category','metal_purities','genders'));
        }else{
            $htmlVal = "";
        }

           return $htmlVal;
    }

    public function get_popups(){
        $htmlVal = view('front.layout.login');
        return $htmlVal;
    }

    public function all_catalogue()
    {
        $catalogues = Catalogue::where('status',1)->latest()->get();
        $page_banners = PageBanner::latest()->get();
        $SEOController = new SEOController();
        $SEOTitleDescription = $SEOController->_seoTitleDescriptionCatalogueList();
        $SEOSchemaCode = $SEOController->_seoSchemaCodeCatalogueBreadcrumb(null);
        return view('front.catalogue',compact('catalogues','SEOTitleDescription','SEOSchemaCode','page_banners'));
    }
    public function all_collection()
    {
        $collection = Collection::where('status',1)->latest()->get();
        $page_banners = PageBanner::latest()->get();
        $SEOController = new SEOController();
        $SEOTitleDescription = $SEOController->_seoTitleDescriptionCollectionList();
        $SEOSchemaCode = $SEOController->_seoSchemaCodeCollectionList();
        return view('front.collection',compact('collection','SEOTitleDescription','SEOSchemaCode','page_banners'));
    }

    public function share_model(Request $request)
    {
        if(isset($request->type) && $request->type != "" && $request->type == 'catalogs'){
            $catalogs = Catalogue::where('id' , $request->id)->first();
            $data['image_path'] = asset('uploads/catalogue/'.$catalogs->cover_image);
            $data['name'] = $catalogs->name;
            $data['slug'] = $catalogs->slug;
            $data['type'] = 'SHARE A CATALOGUES';
        }elseif (isset($request->type) && $request->type != "" && $request->type == 'collection') {
            $collection = Collection::where('id' , $request->id)->first();
            $data['image_path'] = asset('uploads/collections/'.$collection->cover_image);
            $data['name'] = $collection->name;
            $data['slug'] = $collection->slug;
            $data['type'] = 'SHARE A COLLECTION';
        }elseif (isset($request->type) && $request->type != "" && $request->type == 'product') {
            $products = Product::where('id' , $request->id)->first();
            $type = 'simple';
            if(!$products)
            {
                $type = 'variant';
                $products = VariantProduct::where('id' , $request->id)->first();
            }
            $p_image = ProductImage::where('product_id',$products->id)->where('type',$type)->first();
            if(isset($products->db_status) && $products->db_status != '' && $products->db_status != null && $products->db_status == 'manually')
            {
                $data['image_path'] = asset('product_media/product_images/'.$p_image->name);
            }else{
                $data['image_path'] = asset('uploads/'.$p_image->name);
            }
            $data['name'] = $products->p_title;
            $data['slug'] = $products->p_slug;
            $data['type'] = 'SHARE A PRODUCT';
        }elseif(isset($request->type) && $request->type != "" && $request->type == 'current-url')
        {
            $products = Product::where('id' , $request->id)->first();
            $p_image = ProductImage::where('product_id',$products->id)->first();
            if(isset($products->db_status) && $products->db_status != '' && $products->db_status != null && $products->db_status == 'manually')
            {
                $data['image_path'] = asset('product_media/product_images/'.$p_image->name);
            }else{
                $data['image_path'] = asset('uploads/'.$p_image->name);
            }
            $data['url'] = url()->current();
        }
        elseif(isset($request->type) && $request->type != "" && $request->type == 'product-page')
        {
            $products = Product::first();
            $p_image = ProductImage::where('product_id',$products->id)->first();
            if(isset($products->db_status) && $products->db_status != '' && $products->db_status != null && $products->db_status == 'manually')
            {
                $data['image_path'] = asset('product_media/product_images/'.$p_image->name);
            }else{
                $data['image_path'] = asset('uploads/'.$p_image->name);
            }
            $data['url'] = url()->current();
            $data['type'] = 'SHARE PRODUCTS';
        }
        return $data;
    }

    public function about()
    {
        $about = AboutUsSetting::first();
        $SEOController = new SEOController();
        $SEOTitleDescription = $SEOController->_seoTitleDescriptionAboutUs();
        $SEOSchemaCode = $SEOController->_seoSchemaCodeAbout();
        return view('front.about', compact('about','SEOTitleDescription','SEOSchemaCode'));

    }

    public function contact()
    {
        $contact = ContactUsSetting::first();
        $SEOController = new SEOController();
        $SEOTitleDescription = $SEOController->_seoTitleDescriptionContactUs($contact->address_line_1,$contact->address_line_2);
        $SEOSchemaCode = $SEOController->_seoSchemaCodeContactus();
        return view('front.include.contact_us', compact('contact','SEOTitleDescription','SEOSchemaCode'));
    }

    public function catalogue_product($id)
    {
        $catalogues = Catalogue::where('slug', $id)->first();
        if(!$catalogues)
        {
            return redirect()->route('home');
        }
        $catalogues_product = explode(',', $catalogues->product_id);
        $SEOController = new SEOController();
        $SEOTitleDescription = $SEOController->_seoTitleDescriptionCatalogueDetails($catalogues->name);
        $SEOSchemaCode = $SEOController->_seoSchemaCodeCatalogueBreadcrumb($catalogues->name);
         return view('front.catalogues_product', compact('catalogues_product','catalogues','SEOTitleDescription','SEOSchemaCode'));
    }
    public function filter_catalogue(Request $request)
    {
        $catalogues = Catalogue::where('slug', $request->cat_slug)->first();
        $catalogues_product = explode(',', $catalogues->product_id);
        $start = $request->start ?? 0; // Default start value is 0 if $request->start is not provided
        $perPage = 8; // Number of records per page

        $products = [];
        if (isset($catalogues_product) && count($catalogues_product) > 0) {
            $products = Product::whereIn('id', $catalogues_product)
                        ->skip($start)
                        ->take($perPage)
                        ->where('visiblity',1)
                        ->where(function ($query) {
                              $query->where('publish_status', '!=', 'draft')
                                    ->orWhereNull('publish_status');
                          })
                        ->get();
            $count = $products->count();
        }else{
            $count = 0;
        }
        $productHtml = view('front.include.ajax-catalogue-page', ['products' => $products])->render();
        return response()->json(['html' => $productHtml, 'status' => 1,'p_count' => $count]);
    }

    public function collection_catalogue($id)
    {
        $collection = Collection::where('slug', $id)->first();
        if(!$collection)
        {
            return redirect()->route('home');
        }
        $collection_catalogues = explode(',', $collection->catalogue_id);
        $SEOController = new SEOController();
        $SEOTitleDescription = $SEOController->_seoTitleDescriptionCollectionDetails($collection->name);
        $SEOSchemaCode = $SEOController->_seoSchemaCodeCollectionBreadcrumb($collection->name);
        return view('front.collection_catalogues', compact('collection_catalogues','collection','SEOTitleDescription','SEOSchemaCode'));
    }

    public function search_products(Request $request)
    {

        // $products = Product::where('p_title', 'like', '%' . $request->searchproduct . '%')->latest()->get();
        $products = Product::latest()->get();

        $catagories = Category::all();
        $families = Family::all();
        $purities = MetalPurity::all();
        $search_value = $request->searchproduct;
        $search_value_on = 1;

        return view('front.all_products',compact('products','catagories','families','purities','search_value','search_value_on'));
    }

    public function filter_product(Request $request)
    {

        $selectedFamilies = [];

        // Fetch selected families based on category filter
        if (isset($request->cat_id) && !empty($request->cat_id)) {
            $cat_id = $request->cat_id;
            
            $selectedFamilies = Family::whereRaw('FIND_IN_SET(?, category_id)', [$cat_id])
                ->whereHas('products', function ($query) use ($cat_id) {
                    $query->where(function ($q) use ($cat_id) {
                        $q->where('p_category', $cat_id)
                          ->orWhere('p_sec_category', $cat_id);
                    });
                })
                ->get();
        } else {
            $selectedFamilies = Family::whereHas('products', function ($query) {
                $query->whereNotNull('p_family');
            })->get();
        }
        // Initialize variables
        $perPage = 8;
        $start = $request->start ?: 0; // Get start offset from request, default to 0

        // Build queries for products and variants
        $productQuery = Product::query();
        $variantQuery = VariantProduct::query();

        // Apply filters to both queries
        $this->applyFilters($productQuery, $request);
        $this->applyFilters($variantQuery, $request);

        // Get products and variants separately
        $products = $productQuery->where('visiblity', 1)
            ->where(function ($query) {
                $query->where('publish_status', '!=', 'draft')
                    ->orWhereNull('publish_status');
            })->orderBy('created_at', 'DESC')
            ->get();

        $variants = $variantQuery->whereHas('parentProduct', function ($query) {
            $query->where('visiblity', 1)
                ->where(function ($query) {
                    $query->where('publish_status', '!=', 'draft')
                        ->orWhereNull('publish_status');
                });
        })
        ->orderBy('created_at', 'DESC')
        ->get();

        // Merge products and variants, prioritizing products
        $mergedResults = $this->mergeResults($products, $variants);

        // Slice merged results based on start offset and perPage
        $paginatedResults = $mergedResults->slice($start)->take($perPage);

        // Render HTML for paginated results
        $html = view('front.include.ajax-product-page', ['products' => $paginatedResults])->render();

        // Calculate total count of merged results for pagination controls
        $totalCount = $paginatedResults->count();

        return response()->json([
            'status' => 1,
            'html' => $html,
            'families' => $selectedFamilies ?? '',
            'p_count' => $totalCount,
        ]);
    }

    public function my_account()
    {
        $userId = Auth::id();

        if (isset($userId) && $userId != "") {
            $user_details = User::where('id', $userId)->first();
            $user_address = UserAddress::where('user_id',$userId)->first();
            $order_details = Order::where('user_id', $user_details->id)->where('status', '!=', null)->orderByDesc('id')->get();
            $Wishlist = WishList::where('user_id', $userId)->get();
            $SEOController = new SEOController();
            $SEOTitleDescription = $SEOController->_seoTitleDescriptionProfile();
            return view('front.my_account',compact('user_details','order_details','Wishlist','user_address','SEOTitleDescription'));
        }else{
              return redirect()->route('home');
        }
    }

    public function pincode_check(Request $request)
    {
        // dd($request->all());
        $pincode = $request->pincode;
        $zipcode = DeliveryZip::where('code',$pincode)->first();
        if(!$zipcode)
        {
            return response()->json(['status' => 0 ,'message' => 'Delivery Not Available on added pincode']);
        }else{
            $country = $zipcode->country;
            $state = $zipcode->state;
            $city = $zipcode->city;
            $all_code = Shipping::get();
            $final_code = [];
            $string = '';
            $final_code = $this->findBestMatch($all_code, $country, $state, $city, $pincode);
            if(isset($final_code) && !empty($final_code))
            {
                if(isset($final_code->p_time) && $final_code->p_time != '' && $final_code->p_time != null)
                {
                    $days = intval($final_code->p_time);
                    $current_date = date('Y-m-d');
                    $end_date = date('jS M, Y', strtotime("+$days days", strtotime($current_date)));
                    $string = 'Delivery Expected '. $end_date;
                    return response()->json(['status' => 1, 'string' => $string]);
                }
                else{
                    return response()->json(['status' => 0, 'message' => 'Delivery Not Available on added pincode!']);
                }
            }else{
               return response()->json(['status' => 0, 'message' => 'Delivery Not Available on added pincode!']); 
            }
        }
    }

    public function pincode_checkout_check(Request $request)
    {
//         dd($request->all());
        $zipcode = DeliveryZip::where('country',$request->country)->where('state',$request->state)->where('city',$request->city)->where('code',$request->zipcode)->first();
        if(!$zipcode)
        {
            return response()->json(['status' => 0, 'message' => 'Delivery Not Available on added pincode!']);
        }else{
            $found = false;
            $pincode = $request->zipcode;
            $all_code = Shipping::get();
            $final_code = [];
            $final_shipping = 0;
            $final_amount = 0;
            $without_format = $request->total_paid;
            // dd($all_code);
            $check_city = $request->city;
            $check_state = $request->state;
            $check_country = $request->country;
//            dd($all_code);
            $final_code = $this->findBestMatch($all_code, $check_country, $check_state, $check_city, $pincode);
            // dd($final_code);
            if(isset($final_code) && !empty($final_code))
            {
                if(isset($final_code->p_time) && $final_code->p_time != '' && $final_code->p_time != null)
                {
                    $days = intval($final_code->p_time);
                    $current_date = date('Y-m-d');
                    $end_date = date('jS M, Y', strtotime("+$days days", strtotime($current_date)));
                    $string = 'Delivery Expected '. $end_date;
                    if(isset($request->total_paid) && $request->total_paid != null && $request->total_paid != '')
                    {
                        $shipping_cal = ShippingCalculation::where('shipping_id',$final_code->id)->first();
                        if(isset($shipping_cal) && $shipping_cal != null)
                        {
                            if(isset($shipping_cal->type) && $shipping_cal->type == 'fixed')
                            {
                                $final_shipping = number_format($shipping_cal->fix_charge, 2, '.', ',');
                                $without_format = $request->total_paid + $shipping_cal->fix_charge;
                                $final_amount = number_format($request->total_paid + $shipping_cal->fix_charge, 2, '.', ',');
                            }
                            if(isset($shipping_cal->type) && $shipping_cal->type == 'on_price')
                            {
                                $data = json_decode($shipping_cal->data);
                                foreach ($data as $range) {
                                    $from = $range->from;
                                    $to = $range->to;
                                    $shipping_amount = $range->shipping_amount;
                                    if ($request->total_paid >= $from && $request->total_paid <= $to) {
                                        $final_shipping = number_format($shipping_amount, 2, '.', ',');
                                        $without_format = $request->total_paid + $shipping_amount;
                                        $final_amount = number_format($request->total_paid + $shipping_cal->fix_charge, 2, '.', ',');
                                        break;
                                    }else{
                                       $final_amount = number_format($request->total_paid, 2, '.', ','); 
                                    }
                                }
                            }
                        }
                        return response()->json(['status' => 1, 'shipping' => $final_shipping,'final_amount' => $final_amount,'hidden_amount' => $without_format]);
                    }else{
                        return response()->json(['status' => 1, 'string' => $string]);
                    }
                }
                else{
                    return response()->json(['status' => 0, 'message' => 'Delivery Not Available on added pincode!']);
                }
            }else{
               return response()->json(['status' => 0, 'message' => 'Delivery Not Available on added pincode!']); 
            }  
        }
    }
    private function findBestMatch($collection, $country, $state = null, $city = null, $code = null) {
        // First, try to match country, state, city, and code
        $match = $collection->first(function ($item) use ($country, $state, $city, $code) {
            return $item->country == $country &&
                   ($state ? in_array($state, explode(',', $item->state)) : true) &&
                   ($city ? in_array($city, explode(',', $item->city)) : true) &&
                   ($code ? in_array($code, explode(',', $item->code)) : true);
        });

        // If no match, try country, state, and city
        if (!$match) {
            $match = $collection->first(function ($item) use ($country, $state, $city) {
                return $item->country == $country &&
                       ($state ? in_array($state, explode(',', $item->state)) : true) &&
                       ($city ? in_array($city, explode(',', $item->city)) : true);
            });
        }

        // If still no match, try country and state
        if (!$match) {
            $match = $collection->first(function ($item) use ($country, $state) {
                return $item->country == $country &&
                       ($state ? in_array($state, explode(',', $item->state)) : true);
            });
        }

        // If still no match, try with country only
        if (!$match) {
            $match = $collection->first(function ($item) use ($country) {
                return $item->country == $country;
            });
        }

        return $match;
    }
    public function import_users()
    {
        $old_users = DB::table('user')->get();
  
        foreach($old_users as $user)
        {
            $existingUser = User::where('email', $user->email)->first();

            if (!$existingUser) {
            $new = new User();
            $new->name = isset($user->name) ? $user->name : null;
            $new->email = isset($user->email) ? $user->email : null;
            $new->phone = isset($user->mobile) ? $user->mobile : null;
            $new->country_code_number = '+91';
            $new->password = isset($user->password) ? $user->password: null;
            $new->role = 'customer';
            $new->save();
            }
        }
    }

    public function search_productd_detail(Request $request)
    {
        if(isset($request->search_text) && $request->search_text != null && $request->search_text != '') {
            $searchText = $request->search_text ?? '';

            // Retrieve main products matching the search text
            $parentProducts = Product::where('p_title', 'like', '%' . $searchText . '%')
                ->where('visiblity', 1)
                ->where(function ($query) {
                    $query->where('publish_status', '!=', 'draft')
                        ->orWhereNull('publish_status');
                })->latest()->get();

            // Retrieve variant products matching the search text
            $variantProducts = VariantProduct::where('p_title', 'like', '%' . $searchText . '%')
                ->where('visiblity', 1)
                ->where(function ($query) {
                    $query->where('publish_status', '!=', 'draft')
                        ->orWhereNull('publish_status');
                })->latest()->get();
            // Filter out variant products whose parents also match the search text
            $filteredVariantProducts = $variantProducts->filter(function ($variant) use ($searchText) {
                $parent = Product::find($variant->parent_product_id);
                return stripos($parent->p_title, $searchText) === false;
            });

            // Combine parent products and filtered variant products
            $products = $parentProducts->merge($filteredVariantProducts);
            // Apply additional filters
            $query = Product::query();

            if (isset($searchText) && $searchText != '' && $searchText != null) {
                $query->where('p_title', 'like', '%' . $searchText . '%');
            }

            // Retrieve products based on filters and visibility status
            $filteredProducts = $query->where('visiblity', 1)
                ->where(function ($query) {
                    $query->where('publish_status', '!=', 'draft')
                        ->orWhereNull('publish_status');
                })->orderBy('id', 'DESC')
                ->get();
            
            // Combine filtered products with the search results
            $products = $products->merge($filteredProducts);
            // Filter results by search text
            if ($searchText != '') {
                $products = $products->filter(function ($product) use ($searchText) {
                    return stripos($product->p_title, $searchText) !== false;
                });
            }
            // Limit to latest 5 products
            $latestProducts = $products->sortByDesc('created_at')->take(5);
    
            // Prepare HTML response
            $html = '';
            $count = count($latestProducts);
            if(isset($count) && $count > 0)
            {
                $html .= '<ul class="ui-autocomplete ui-front ui-menu ui-widget ui-widget-content ui-corner-all">';
                foreach ($latestProducts as $product) {
                    $html .= '<li class="ui-menu-item"><a class="ui-corner-all" href="' . route('front.detail.products', ['slug' => $product->p_slug]) . '">' . (isset($product->p_title) ? $product->p_title : '') . '</a></li>';
                }
                $html .= '</ul>';
            }
            return response()->json(['status' => 1, 'html' => $html, 'count' => $count]);
        } else {
            return response()->json(['status' => 0]);
        }
    }
    public function add_order_note(Request $request)
    {
        // dd($request->all());
        $requestData = $request->all();
        if(Auth::user())
        {
            $cart = Cart::where('id',$requestData['cart_id'])->where('product_id',$requestData['product_id'])->first();
            if(isset($cart) && $cart != null)
            {
                $cart->comment = isset($requestData['comment']) ? $requestData['comment'] : null;
                $cart->save();
                return response()->json(['status' => 1, 'message' => 'Product Note Added Successfully.']);
            }else{
                return response()->json(['status' => 0]);
            }
        }else{
            $cart = session()->get('cart',[]);
            foreach ($cart as $key => &$item) {
                if ($item['product_id'] == $requestData['product_id'] && $key == $requestData['cart_id']) {
                    $item['order_comment'] = isset($requestData['comment']) ? $requestData['comment'] : null;
                    break;
                }
            }
            session()->put('cart', $cart);
        }
        
        return response()->json(['status' => 1, 'message' => 'Product Note Added Successfully.']);
    }
    
    public function sendtestemail(){
        // $new_password = "Prish@123!";
        // dd(Hash::make($new_password));
   
    }
    private function applyFilters($query, $request)
    {
     
        if (isset($request->cats) && count($request->cats) > 0) {
            $query->where(function ($query) use ($request) {
                $query->whereIn('p_category', $request->cats)
                    ->orWhere(function ($query) use ($request) {
                        foreach ($request->cats as $cat) {
                            $query->orWhereRaw('FIND_IN_SET(?, p_sec_category)', [$cat]);
                        }
                    });
            });
        }

        if (isset($request->fams) && count($request->fams)) {
            $query->whereIn('p_family', $request->fams);
        }

        if (isset($request->genders) && count($request->genders) && $request->genders != null) {
            $query->whereIn('p_gender', $request->genders);
        }

        if (isset($request->carates) && count($request->carates) && $request->carates != null) {
            $query->whereIn('p_metal_purity', $request->carates);
        }

        if (isset($request->status) && count($request->status) && $request->status != null) {
            if (in_array('ready_stock', $request->status)) {
                $query->whereIn('p_status', $request->status)->where('p_avail_stock_qty', '!=', '0');
            } else {
                $query->whereIn('p_status', $request->status);
            }
        }

        if (isset($request->searchtext) && $request->searchtext != '' && $request->searchtext != null) {
            $query->where('p_title', 'like', '%' . $request->searchtext . '%');
        }

        if (isset($request->tag_key) && $request->tag_key != '' && $request->tag_key != null) {

            $query->whereRaw('FIND_IN_SET(?, p_tags)', [$request->tag_key]);
            $query->whereRaw("FIND_IN_SET(?, REPLACE(p_tags, ', ', ','))", [$request->tag_key]);
            
            //$query->where('p_tags','LIKE',"%{$request->tag_key}%");
        }

   
    }

    private function mergeResults($products, $variants)
    {
        $result = collect();

        $productIds = $products->pluck('id')->toArray();
        $parentProductIds = $variants->pluck('parent_product_id')->toArray();

        // Add products to result
        foreach ($products as $product) {
            $result->push($product);
        }

        // Initialize an array to track added parent product IDs
        $addedParentProductIds = [];

        // Filter variants to include only one per parent product
        foreach ($variants as $variant) {
            if (!in_array($variant->parent_product_id, $productIds) && !in_array($variant->parent_product_id, $addedParentProductIds)) {
                $result->push($variant);
                $addedParentProductIds[] = $variant->parent_product_id; // Track the added parent product ID
            }
        }

        return $result;
    }

    public function get_promocode_data(Request $request)
    {
        if(isset($request->code_id) && $request->code_id != '' && $request->code_id != null)
        {
            $promocode = PromoCode::where('id',$request->code_id)->first();
            if(isset($promocode) && $promocode != null)
            {
                if(isset($promocode->endDate) && $promocode->endDate != null)
                {
                    $promocode->valid_till = Carbon::parse($promocode->endDate)->format('d F Y');
                }
                if(isset($promocode->discount_type) && $promocode->discount_type == 'amount')
                {
                    $promocode_d_amount = $promocode->discount .'/-';
                }else{
                    $promocode_d_amount = $promocode->discount .'%';
                }
                $promocode->string_one = '<strong>Valid Till: </strong>'.$promocode->valid_till;
                $promocode->string = '<strong>Discounted Amount: </strong>'.$promocode_d_amount;
                $share_message = 'Hi! I found this amazing deal on '.url('/').'! Use promo code '. $promocode->code .' to get '.$promocode_d_amount.' off your next purchase.';
                // $share_message = url('/').','.$promocode->code.',Discount: '.$promocode_d_amount.',Max discount amount: '.(isset($promocode->max_discount_amount) ? $promocode->max_discount_amount : '').',Min. Cart Amount: '.(isset($promocode->minimum_cart_amount) ? $promocode->minimum_cart_amount : '').',Valid till: '.(isset($promocode->valid_till) ? $promocode->valid_till : '').'\n Limited time offer!';
                $promocode->share_message = $share_message;
                return response()->json(['status' => 1, 'promocode' => $promocode]);
            }else{
                return response()->json(['status' => 0, 'message' => 'Promocode not found!']);
            }
            
        }else{
            return response()->json(['status' => 0, 'message' => 'Something Went Wrong!']);
        }
    }
    public function apply_promocode(Request $request)
    {
        $promocode = PromoCode::where('code',$request->promo_code)->where('status','active')->first();
        // dd($promocode);
        if(isset($promocode) && $promocode != null && $promocode != '')
        {
            $endDate = Carbon::createFromFormat('m/d/Y', $promocode->endDate)->endOfDay();
            $currentDate = Carbon::now();
            // promo code expire check
            if ($endDate->lt($currentDate)) {
                return response()->json(['status' => 0,'message' => 'Promo code has expired']);
            }
            $user_id = Auth::user()->id;
            if(isset($promocode->one_time_use) && $promocode->one_time_use != null && $promocode->one_time_use == 'yes')
            {
                $promo_orders = Order::where('promo_code_id',$promocode->id)->get();
                if(isset($promo_orders) && count($promo_orders) > 0)
                {
                    return response()->json(['status' => 0,'message' => 'You Can not use this promocode more than once!']); 
                }
            }
            if(isset($promocode->single_time_use) && $promocode->single_time_use != null && $promocode->single_time_use == 'yes')
            {
                $user_orders = Order::where('user_id', $user_id)->where('promo_code_id',$promocode->id)->first();
                if(isset($user_orders) && $user_orders != null && $user_orders != '')
                {
                    return response()->json(['status' => 0,'message' => 'You Can not use this promocode more than once!']);  
                }
            }
            $user_carts = Cart::where('user_id', $user_id)->pluck('product_id')->toArray();

            $cart_products_cat = Product::whereIn('id',$user_carts)->pluck('p_category')->toArray();
            $carts_variants_cats = VariantProduct::whereIn('id',$user_carts)->pluck('p_category')->toArray();
            $merged_categories = array_merge($cart_products_cat, $carts_variants_cats);
            $cart_products_cat = array_unique($merged_categories);


            $cart_products_sku = Product::whereIn('id',$user_carts)->pluck('p_sku')->toArray();
            $cart_variants_sku = VariantProduct::whereIn('id',$user_carts)->pluck('p_sku')->toArray();
            $merged_skus = array_merge($cart_products_sku, $cart_variants_sku);
            $cart_products_sku = array_unique($merged_skus);


            // min cart amount check
            $products = Product::whereIn('p_sku', $cart_products_sku)->get();
            $variants = VariantProduct::whereIn('p_sku', $cart_products_sku)->get();

            $mergedResults = $products->merge($variants);

            $total_price = $mergedResults->sum(function ($product) {
                return $product->total_price($product->id);
            });
            if($total_price < $promocode->minimum_cart_amount)
            {
                return response()->json(['status' => 0,'message' => 'Cart Amount is not match with minimum amout of offer!']);
            }
            $promocode_included_cats = isset($promocode->included_category) ?  $promocode->included_category : null;
            if(isset($promocode_included_cats) && $promocode_included_cats != null)
            {
                $included_cats = explode(',',$promocode_included_cats);
            }
            $promocode_excluded_cats = isset($promocode->excluded_category) ? $promocode->excluded_category : null;
            if(isset($promocode_excluded_cats) && $promocode_excluded_cats != null)
            {
                $excluded_cats = explode(',',$promocode_excluded_cats);
            }
            $promocode_included_sku = isset($promocode->included_products) ? $promocode->included_products : null;
            if(isset($promocode_included_sku) && $promocode_included_sku != null)
            {
                $included_skus = explode(',',$promocode_included_sku);
            }
            $promocode_excluded_sku = isset($promocode->excluded_products) ? $promocode->excluded_products : null;
            if(isset($promocode_excluded_sku) && $promocode_excluded_sku != null)
            {
                $excluded_skus = explode(',',$promocode_excluded_sku);
            }
            if($included_cats[0] == 'all')
            {
                $matching_included_cats = $cart_products_cat;
            }else{
                $matching_included_cats = array_intersect($cart_products_cat, $included_cats);
            }
            if (!empty($matching_included_cats)) {
                if (isset($excluded_skus) && empty(array_diff($cart_products_sku, $excluded_skus)) && empty(array_diff($excluded_skus, $cart_products_sku))) {
                    return response()->json(['status' => 0, 'message' => 'Offer is not available for your cart products!']);
                }else{
                    $applied_products_skus = Product::whereIn('p_category', $matching_included_cats)->whereIn('id', $user_carts)->pluck('p_sku')->toArray();
                    $applied_variants_skus = VariantProduct::whereIn('p_category', $matching_included_cats)->whereIn('id', $user_carts)->pluck('p_sku')->toArray();
                    $merged_skus = array_merge($applied_products_skus, $applied_variants_skus);
                    $applied_skus = array_unique($merged_skus);

                    if(isset($included_skus) && count($included_skus) > 0)
                    {
                        $matching_included_products = array_intersect($cart_products_sku, $included_skus);
                        $merged_applied_skus = array_merge($applied_skus, $matching_included_products);
                        $applied_skus = array_unique($merged_applied_skus);
                    }  
                    if(isset($excluded_skus) && count($excluded_skus) > 0)
                    {
                        $applied_skus = array_diff($applied_skus, $excluded_skus);
                    }      
                    if(isset($promocode->discounted_product) && $promocode->discounted_product != null && $promocode->discounted_product == 'no')
                    {
                        // dd($applied_skus);
                        foreach ($applied_skus as $key => $sku) {
                            $product = Product::where('p_sku', $sku)->first();
                            if(!$product)
                            {
                                $product = VariantProduct::where('p_sku', $sku)->first();
                            }
                            if ($product) {
                                if(isset($product->p_pricetype) && $product->p_pricetype == 'dynamic')
                                {
                                    $hasDiscount = $product->overall_discount(
                                        $product->id,
                                        $product->total_price($product->id),
                                        $product->making_rate($product->id)
                                    );
                                }else if(isset($product->p_pricetype) && $product->p_pricetype == 'fix_price'){
                                    $hasDiscount = isset($product->p_discount) ? $product->p_discount : 0;
                                }else{
                                    $hasDiscount = 0;
                                }
                                
                                if (isset($hasDiscount) && $hasDiscount != 0) {
                                    unset($applied_skus[$key]);
                                }
                            }
                        }
                    }
                    if(isset($applied_skus) && count($applied_skus) > 0)
                    {
                        return response()->json(['status' => 1, 'promocode' => $promocode,'applied_skus' => $applied_skus]);
                    }else{
                        return response()->json(['status' => 0, 'message' => 'Offer is not available for your cart products!']);
                    }
                }
            }else{
                $matching_included_products = array_intersect($cart_products_sku, $included_skus);
                if (!empty($matching_included_products)) {
                    if(isset($promocode->discounted_product) && $promocode->discounted_product != null && $promocode->discounted_product == 'no')
                    {
                        foreach ($matching_included_products as $key => $sku) {
                            $product = Product::where('p_sku', $sku)->first();
                            if(!$product)
                            {
                                $product = VariantProduct::where('p_sku', $sku)->first();
                            }
                            if ($product) {
                                $hasDiscount = $product->overall_discount(
                                    $product->id,
                                    $product->total_price($product->id),
                                    $product->making_rate($product->id)
                                );
                                if (isset($hasDiscount) || $hasDiscount == 0) {
                                    unset($matching_included_products[$key]);
                                }
                            }
                        }
                    }
                    if(isset($matching_included_products) && count($matching_included_products) > 0)
                    {
                        return response()->json(['status' => 1, 'promocode' => $promocode,'applied_skus' => $matching_included_products]);
                    }else{
                        return response()->json(['status' => 0, 'message' => 'Offer is not available for your cart products!']);
                    } 
                }
            }
        }else{
            return response()->json(['status' => 0,'message' => 'Invalid Promocode!']);
        }
        
    }
    public function store_promocode_session(Request $request)
    {
        if(Auth::check())
        {
            $user = Auth::user();
            $setting = Setting::first();
            if(isset($user->site_access) && $user->site_access != null && $user->site_access == 1 && isset($setting->access_limited_access) && $setting->access_limited_access != null && $setting->access_limited_access == 1)
            {
                // dd($user);
                $startDateTime = Carbon::createFromFormat('m/d/Y H:i', $user->site_access_start_date . ' ' . $user->site_access_start_time);
                $endDateTime = Carbon::createFromFormat('m/d/Y H:i', $user->site_access_end_date . ' ' . $user->site_access_end_time);
                $currentDateTime = Carbon::now();
                if ($currentDateTime->between($startDateTime, $endDateTime)) {
                    if((isset($request->promo_code_id) && $request->promo_code_id != null && $request->promo_code_id != '') && (isset($request->promo_discount) && $request->promo_discount != null && $request->promo_discount != ''))
                    {
                        session([
                            'promo_code' => [
                                'user_id' => $request->user_id,
                                'promo_code_id' => isset($request->promo_code_id) ? $request->promo_code_id : null,
                                'promo_discount' => isset($request->promo_discount) ? $request->promo_discount : '0.00',
                                'products' => isset($request->cartProducts) ? $request->cartProducts : null,
                            ]
                        ]);
                    }else{
                        session()->forget('promo_code');
                    }
                    return response()->json(['status' => 1, 'message' => 'Promo code stored in session successfully.']);
                } else {
                    Auth::logout();
                    return response()->json(['status' => 0, 'message' => 'Your access time has expired.']);
                }
            }else{
                if((isset($request->promo_code_id) && $request->promo_code_id != null && $request->promo_code_id != '') && (isset($request->promo_discount) && $request->promo_discount != null && $request->promo_discount != ''))
                    {
                        session([
                            'promo_code' => [
                                'user_id' => $request->user_id,
                                'promo_code_id' => isset($request->promo_code_id) ? $request->promo_code_id : null,
                                'promo_discount' => isset($request->promo_discount) ? $request->promo_discount : '0.00',
                                'products' => isset($request->cartProducts) ? $request->cartProducts : null,
                            ]
                        ]);
                    }else{
                        session()->forget('promo_code');
                    }
                    return response()->json(['status' => 1, 'message' => 'Promo code stored in session successfully.']);
            }
        }
    }
    public function check_user_access(Request $request)
    {
        if(isset($request->user_id) && $request->user_id != null && $request->user_id != '')
        {
            $user = User::findOrfail($request->user_id);
            if(isset($user->role) && $user->role != null && $user->role == 'customer')
            {
                event(new AccessChanged($user));
                event(new ProductAccessChanged($user));
                return response()->json(['status' => 1]);
            }else{
                return response()->json(['status' => 0]);
            }
        }else{
            return response()->json(['status' => 0]);
        }
    }
}