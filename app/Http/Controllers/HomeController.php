<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Mail\MeetingMail;
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
use App\Models\SliderBanner;
use App\Models\AboutUsSetting;
use App\Models\ContactUsSetting;
use App\Models\ProductImage;
use App\Models\Order;
use App\Models\MetalPurity;
use App\Models\User;
use App\Models\WishList;
use App\Models\VariantProduct;
use Illuminate\Support\Facades\Auth;
use App\Models\PrAttributeValue;
use App\Models\Occasion;
use App\Models\Trend;
use App\Models\Metal; 
use App\Models\BizProductAttachment; 
use App\Models\Tags; 
use App\Models\BizProductsNew; 
use App\Models\BusinessSetting; 
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductsImport;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use DB;








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
    public function queue_cron_job()
    {
        Log::info('queue_cron_job called');
        try {
            \Artisan::call('queue:work');
            Log::info('queue:work command executed');
        } catch (\Exception $e) {
            Log::error('Error executing queue:work command: ' . $e->getMessage());
        }
    }
    public function index()
    {
       
        // $home = HomePageSetting::first();
        // $about = json_decode($home->about_us_sec);
        // $service = json_decode($home->our_service_sec);
        // $story = json_decode($home->the_story_sec);
        // $testi = json_decode($home->testimonial_sec);
        // $video = json_decode($home->video_sec);
        // $married = json_decode($home->married_sec);
        // $gallery = json_decode($home->gallery_sec);
        // $form = json_decode($home->form_sec);
        // $recent = json_decode($home->recent_post_sec);
        // $product_services = ProductService::take(6)->latest()->get();
        // $testimonials = Testimonial::where('is_featured', 1)->orderBy('id', 'desc')->get();
        // $slider = Slider::where('status', 1)->take(5)->get();
        // // $how_to_get = Married::where('status', 1)->take(2)->latest()->get();
        // $how_to_get = Married::where('status', 1)->whereNotIn('id', [4])->take(5)->latest()->get();
        // $gallery_images = ProjectGallery::where('is_publish', 1)->where('is_featured', 1)->take(5)->latest()->get();
        // $recent_articles = Article::where('status', 1)->take(5)->latest()->get();
        // return view('front.home_new',compact('home','about','service','story','product_services','testi','married','gallery','recent','testimonials','slider','how_to_get','recent_articles','gallery_images','video','form'));
        // return view('front.layout.index');

        $slider_banner = SliderBanner::where('status' , 1)->get();
        $catalogs = Catalogue::where('status' , 1)->get();
        $collection = Collection::where('status' , 1)->get();
        $testimonials = Testimonial::where('is_featured' , 1)->latest()->get();
        $products = Product::where('visiblity' , 1)->where('is_public','1')->latest()->take(8)->get();

        $order = Order::select('product_id', DB::raw('count(*) as count'))
                        ->groupBy('product_id')->orderByDesc('count')->take(8)->get();

        $SEOController = new SEOController();
        $this->param['SEOTitleDescription'] = $SEOController->_seoTitleDescriptionHome();


        // $catalogs_count = Catalogue::where('status' , 1)->count();


        return view('front.home', compact('slider_banner','catalogs','collection','testimonials','products','order',$this->param));

    }
    public function about_us()
    {
        return view('front.about_us');
    }
    public function how_to_get_married()
    {
        $pagename = "how_to_get_married";
        return view('front.how_to_get_married', compact('pagename'));
    }
    public function getting_marriage_license()
    {
        $pagename = "getting_marriage_license";
        return view('front.how_to_get_married', compact('pagename'));
    }
    public function getting_marriage_certificate()
    {
        $pagename = "getting_marriage_certificate";
        return view('front.how_to_get_married', compact('pagename'));
    }
    public function license_wedding_officiant()
    {
        $pagename = "license_wedding_officiant";
        return view('front.how_to_get_married', compact('pagename'));
    }
    public function photo_gallary()
    {
        return view('front.photogallary');
    }
    public function services()
    {
        return view('front.service');
    }
    public function servicesnew()
    {
        return view('front.servicenext');
    }
    public function service_detail($slug)
    {
        $service = ProductService::where('slug',$slug)->first();
        $gallery_images = ProjectGallery::where('is_publish', 1)->where('is_featured', 1)->take(5)->latest()->get();
        if($service){
            $pagename = "formal_wedding";
            return view('front.service_detail', compact('pagename','service','gallery_images'));
        }else{
            abort(404);
        }
    }
    public function formal_wedding()
    {
        $pagename = "formal_wedding";
        return view('front.servicenext', compact('pagename'));
    }
    public function casual_wedding()
    {
        $pagename = "casual_wedding";
        return view('front.servicenext', compact('pagename'));
    }
    public function rehearsal()
    {
        $pagename = "rehearsal";
        return view('front.servicenext', compact('pagename'));
    }
    public function renewal_of_vows()
    {
        $pagename = "renewal_of_vows";
        return view('front.servicenext', compact('pagename'));
    }
    public function contact_us()
    {
        return view('front.contact_us');
    }
    public function posts()
    {
        $blogs = Article::where('status',1)->latest()->paginate(10);
        return view('front.blogs',compact('blogs'));
    }
    public function blog_detail()
    {
        return view('front.blog_detail');
    }
    public function blog_detail_2()
    {
        return view('front.blog_detail_next');
    }
    public function meeting_form(Request $request)
    {
        // dd($request->all());
        if(!$request->has('g-recaptcha-response') || !$request->filled('g-recaptcha-response'))
        {
            return redirect()->back()->with(['error' => 'The reCAPTCHA verification is required.'])->withInput()->withFragment('recaptcha-error');
        }
        $request->validate([
                'g-recaptcha-response' => [
                    'required',
                    function ($attribute, $value, $fail) {
                        $response = Http::get("https://www.google.com/recaptcha/api/siteverify", [
                            'secret'   => env('GOOGLE_RECAPTCHA_SECRET'),
                            'response' => $value,
                        ]);
                        if (!$response->json('success')) {
                            return redirect()->back()->with(['error' => 'The reCAPTCHA verification failed. Please try again.'])->withInput()->withFragment('recaptcha-error');
                            $fail('The reCAPTCHA verification failed. Please try again.');
                        }
                    },
                ],
            ]);
        $user_data = $request->all();
        Mail::to("info@randystrattonofficiant.ca")->send(new MeetingMail($user_data));
        
        return redirect()->back()->with(['success' => 'Your inquiry has been successfully sent via email.']);
    }

    public function home_dynamic()
    {
        $home = HomePageSetting::first();
        $about = json_decode($home->about_us_sec);
        $service = json_decode($home->our_service_sec);
        $story = json_decode($home->the_story_sec);
        $testi = json_decode($home->testimonial_sec);
        $video = json_decode($home->video_sec);
        $married = json_decode($home->married_sec);
        $gallery = json_decode($home->gallery_sec);
        $recent = json_decode($home->recent_post_sec);
        $product_services = ProductService::take(4)->latest()->get();
        $testimonials = Testimonial::where('is_featured', 1)->take(5)->latest()->get();
        $slider = Slider::where('status', 1)->take(5)->latest()->get();
        $how_to_get = Married::where('status', 1)->whereNotIn('id', [4])->take(5)->latest()->get();
        $gallery_images = ProjectGallery::where('is_publish', 1)->take(5)->latest()->get();
        $recent_articles = Article::where('status', 1)->take(5)->latest()->get();
        // dd($product_services);
        return view('front.home_new',compact('home','about','service','story','product_services','testi','married','gallery','recent','testimonials','slider','how_to_get','recent_articles','gallery_images','video'));
    }

    public function single_blog_detail($slug)
    {
        $blog_widgets = SidebarWidget::where('sidebar_id',2)->orderby('sequence')->get();
        $article = Article::where('slug',$slug)->where('status', 1)->first();
        $related= Article::where('id', '!=', $article->id)->where('status', 1)->get();
        $recent= Article::latest()->where('id', '!=', $article->id)->where('status', 1)->get();
        $comment_setting = CommentSetting::first();
        $all_comments = Comment::where('blog_id',$article->id)->where('parent_id', '=', null)->where('approved_status',1)->where('spam_status', 0)->latest()->get();
        return view('front.blog_detail',compact('article','related','recent','blog_widgets','comment_setting','all_comments'));
    }
     public function testimonials()
    {
        $testi_list = Testimonial::select('testimonials.*')->orderBy('id', 'desc')->where('is_featured',1)->paginate(10);

        
        return view('front.testimonial', compact('testi_list'));
    }
    public function married_detail($slug)
    {
        $married = Married::where('status', 1)->where('slug', $slug)->latest()->first();
        $all_married = Married::where('status', 1)->latest()->get();
        return view('front.married_details', compact('married', 'all_married'));
    }

    public function gallery()
    {
        $categories = GalleryCategory::get();
        $photos = ProjectGallery::where('is_publish',1)->latest()->get(); 
        return view('front.new_project_gallery',compact('photos','categories'));
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
        // $product_details = Product::where('p_category' , $request->id)->get();
        $product_id = $request->id;
        $product_details = Family::whereRaw('FIND_IN_SET(?, category_id)', $request->id)->orderBy('family', 'asc')->get();
        $product_images = Product::where('p_category' , $request->id)->latest()->take(4)->get();
        $category = Category::where('id', $request->id)->first();
        $collection = Collection::latest()->take(6)->get();


        if (isset($product_details)) {
           $htmlVal = view('front.include.product', compact('product_details','collection','product_images','product_id','category'));
        }else{
            $htmlVal = "";
        }

           return $htmlVal;
    }

    public function all_catalogue()
    {
        $catalogues = Catalogue::latest()->get();
        return view('front.catalogue',compact('catalogues'));
    }
    public function all_collection()
    {
        $collection = Collection::latest()->get();
        return view('front.collection',compact('collection'));
    }

    public function share_model(Request $request)
    {
        if(isset($request->type) && $request->type != "" && $request->type == 'catalogs'){
            $catalogs = Catalogue::where('id' , $request->id)->first();
            $data['image_path'] = asset('uploads/'.$catalogs->cover_image);
            $data['name'] = $catalogs->name;
            $data['slug'] = $catalogs->slug;
            $data['type'] = 'SHARE A CATALOGUES';

           
        }elseif (isset($request->type) && $request->type != "" && $request->type == 'collection') {
            $collection = Collection::where('id' , $request->id)->first();
            $data['image_path'] = asset('uploads/'.$collection->cover_image);
            $data['name'] = $collection->name;
            $data['slug'] = $collection->slug;
            $data['type'] = 'SHARE A COLLECTION';
        }elseif (isset($request->type) && $request->type != "" && $request->type == 'product') {
            $products = Product::where('id' , $request->id)->first();
            $p_image = ProductImage::where('product_id',$products->id)->first();
            $data['image_path'] = asset('uploads/'.$p_image->name);
            $data['name'] = $products->p_title;
            $data['slug'] = $products->p_slug;
            $data['type'] = 'SHARE A PRODUCT';
        }

        
        return $data;
    }

    public function about()
    {
        $about = AboutUsSetting::first();
        return view('front.about', compact('about'));

    }

    public function contact()
    {
        $contact = ContactUsSetting::first();

        return view('front.include.contact_us', compact('contact'));
    }

    public function catalogue_product($id)
    {
         $catalogues = Catalogue::where('slug', $id)->first();
         $catalogues_product = explode(',', $catalogues->product_id);
         return view('front.catalogues_product', compact('catalogues_product','catalogues'));
    }

    public function collection_catalogue($id)
    {
        $collection = Collection::where('slug', $id)->first();
        $collection_catalogues = explode(',', $collection->catalogue_id);
        return view('front.collection_catalogues', compact('collection_catalogues','collection'));
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
        // dd($request->all());
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
        }
        else{
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
        $products = $query->skip($request->start)->take($perPage)->where('visiblity',1)->latest()->get();


      
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

    public function my_account()
    {
        $userId = Auth::id();

        if (isset($userId) && $userId != "") {
            $user_details = User::where('id', $userId)->first();
            $order_details = Order::where('user_id', $user_details->id)->orderByDesc('id')->get();
             $Wishlist = WishList::where('user_id', $userId)->get();
            return view('front.my_account',compact('user_details','order_details','Wishlist'));
        }else{
              return redirect()->route('home');
        }

    }

    public function products_import()
    {
        $filePath = public_path('assets/biz_products.csv');
        $importedData = Excel::toArray(new ProductsImport, $filePath);
        $firstTenRows = array_slice($importedData[0], 3001, 499);
        // dd($firstTenRows);
        $attr_metal = '';
        $attr_gender = '';
        $attr_gender = '';
        $attr_style = '';
        $attr_hallmark = '';
        $attr_status = '';
        $attr_occasion = '';
        $attr_trend = '';
        $attr_purity = '';
        $attr_weight = '';
        $attr_weight_unit = '';
        $attr_metal_color = '';
        $attr_size = '';
        $attr_metal_weight = '';
        $diamond_data = [];
        $pearl_data = [];
        $gemstone_data = [];
        $certi_type = '';
        $certi_no = '';
        $unit = '';
        foreach($firstTenRows as $key => $row)
        {
            // dd($row);
            $attributes = PrAttributeValue::where('pattrkv_bpr_id',$row[0])->get();
            // dd($attributes);
            foreach($attributes as $attr)
            {
                if($attr->pattrkv_pattr_key == 'Metal')
                {
                    if(isset($attr->pattrkv_pattrv_value) && $attr->pattrkv_pattrv_value != '' && $attr->pattrkv_pattrv_value != null)
                    {
                        $metal_one = Metal::where('title',$attr->pattrkv_pattrv_value)->first();
                        $attr_metal == isset($metal_one) ? $metal_one->id : null;
                    }else{
                        $attr_metal == null;
                    }
                    
                }
                if($attr->pattrkv_pattr_key == 'Gender')
                {
                    // dd($attr->pattrkv_pattrv_value);
                    if($attr->pattrkv_pattrv_value == 'Ladies' || $attr->pattrkv_pattrv_value == 'Women')
                    {
                        $gender_c = 'Women';
                    }
                    else if($attr->pattrkv_pattrv_value == 'Gents' || $attr->pattrkv_pattrv_value == 'Men')
                    {
                        $gender_c = 'Men';
                    }else{
                        $gender_c = $attr->pattrkv_pattrv_value;
                    }   
                    $attr_gender = isset($gender_c) ? $gender_c : null;
                }
                if($attr->pattrkv_pattr_key == 'Style')
                {
                    $attr_style = isset($attr->pattrkv_pattrv_value) ? $attr->pattrkv_pattrv_value : null;
                }
                if($attr->pattrkv_pattr_key == 'Unit')
                {
                    $unit = isset($attr->pattrkv_pattrv_value) ? $attr->pattrkv_pattrv_value : null;
                }
                if($attr->pattrkv_pattr_key == 'Certificate')
                {
                    $attr_hallmark = isset($attr->pattrkv_pattrv_value) ? $attr->pattrkv_pattrv_value : null;
                }
                if($attr->pattrkv_pattr_key == 'Status')
                {
                    if(isset($attr->pattrkv_pattrv_value) && $attr->pattrkv_pattrv_value == 'By Order')
                    {
                        $c_status = 'by_order';
                    }else{
                        $c_status = 'ready_stock';
                    }
                    $attr_status = isset($c_status) ? $c_status : null;
                }
                if($attr->pattrkv_pattr_key == 'Occasion')
                {
                    $occassion = Occasion::where('title',$attr->pattrkv_pattrv_value)->first();
                    $attr_occasion = isset($occassion->id) ? $occassion->id : null;
                }
                if($attr->pattrkv_pattr_key == 'Trend')
                {
                    $trend = Trend::where('title',$attr->pattrkv_pattrv_value)->first();
                    $attr_trend = isset($trend->id) ? $trend->id : '';
                }
                if($attr->pattrkv_pattr_key == 'Metal Purity')
                {
                    $purity = MetalPurity::where('title',$attr->pattrkv_pattrv_value)->first();
                    $attr_purity = isset($purity->id) ? $purity->id : '';
                }
                if($attr->pattrkv_pattr_key == 'Weight Unit')
                {
                    $attr_weight_unit = isset($attr->pattrkv_pattrv_value) ? $attr->pattrkv_pattrv_value : '';
                }
                if($attr->pattrkv_pattr_key == 'Metal Weight')
                {
                    $attr_metal_weight = isset($attr->pattrkv_pattrv_value) ? $attr->pattrkv_pattrv_value : '';
                }
                if($attr->pattrkv_pattr_key == 'Metal Colour')
                {
                    $attr_metal_color = isset($attr->pattrkv_pattrv_value) ? $attr->pattrkv_pattrv_value : '';
                }
                if($attr->pattrkv_pattr_key == 'Size/Length')
                {
                    $attr_size = isset($attr->pattrkv_pattrv_value) ? $attr->pattrkv_pattrv_value : '';
                }
                if($attr->pattrkv_pattr_group == 'Diamond Jewellery')
                {
                    if($attr->pattrkv_pattr_key == 'Diamond Clarity')
                    {
                        $diamond_data['attr_clarity'] = isset($attr->pattrkv_pattrv_value) ? $attr->pattrkv_pattrv_value : '';
                    }
                    if($attr->pattrkv_pattr_key == 'Diamond Colour')
                    {
                        $diamond_data['attr_color'] = isset($attr->pattrkv_pattrv_value) ? $attr->pattrkv_pattrv_value : '';
                    }
                    if($attr->pattrkv_pattr_key == 'Diamond Composition')
                    {
                        $diamond_data['attr_type'] = isset($attr->pattrkv_pattrv_value) ? $attr->pattrkv_pattrv_value : '';
                    }
                    if($attr->pattrkv_pattr_key == 'Total Diamond Weight (cts)')
                    {
                        $diamond_data['attr_total_diamond_wight'] = isset($attr->pattrkv_pattrv_value) ? $attr->pattrkv_pattrv_value : '';
                    }
                    if($attr->pattrkv_pattr_key == 'Count of Total Diamond(s)')
                    {
                        $diamond_data['attr_total_diamond_count'] = isset($attr->pattrkv_pattrv_value) ? $attr->pattrkv_pattrv_value : '';
                    }
                    if($row[26] && $row[26] != 'NULL')
                    {
                        $diamond_data['attr_final_diamond_price'] = isset($row[26])  && $row[26] != 'NULL' ? $row[26] : '';
                    }
                    $diamond_json = json_encode([$diamond_data]);
                }
                if($attr->pattrkv_pattr_group == 'Pearl Jewellery')
                {
                    if($attr->pattrkv_pattr_key == 'Pearl Type')
                    {
                        $pearl_data['attr_pearl_gem'] = isset($attr->pattrkv_pattrv_value) ? $attr->pattrkv_pattrv_value : '';
                    }
                    if($attr->pattrkv_pattr_key == 'Pearl Composition')
                    {
                        $pearl_data['attr_pearl_type'] = isset($attr->pattrkv_pattrv_value) ? $attr->pattrkv_pattrv_value : '';
                    }
                    if($attr->pattrkv_pattr_key == 'Pearl Color')
                    {
                        $pearl_data['attr_pearl_color'] = isset($attr->pattrkv_pattrv_value) ? $attr->pattrkv_pattrv_value : '';
                    }
                    if($attr->pattrkv_pattr_key == 'Pearl Total Weight (cts)')
                    {
                        $pearl_data['attr_pearl_total_wight'] = isset($attr->pattrkv_pattrv_value) ? $attr->pattrkv_pattrv_value : '';
                    }
                    if($attr->pattrkv_pattr_key == 'Count of Total Pearls')
                    {
                        $pearl_data['attr_pearl_total_gem_count'] = isset($attr->pattrkv_pattrv_value) ? $attr->pattrkv_pattrv_value : '';
                    }
                    if($attr->pattrkv_pattr_key == 'Pearls Shape')
                    {
                        $pearl_data['attr_pearl_shape'] = isset($attr->pattrkv_pattrv_value) ? $attr->pattrkv_pattrv_value : '';
                    }
                    
                    $pearl_json = json_encode([$pearl_data]);
                }
                if($attr->pattrkv_pattr_group == 'Gemstone Jewellery')
                {
                    if($attr->pattrkv_pattr_key == 'Gemstone Type')
                    {
                        $gemstone_data['attr_gemstone_gem'] = isset($attr->pattrkv_pattrv_value) ? $attr->pattrkv_pattrv_value : '';
                    }
                    if($attr->pattrkv_pattr_key == 'Gemstone Shape')
                    {
                        $gemstone_data['attr_gemstone_shape'] = isset($attr->pattrkv_pattrv_value) ? $attr->pattrkv_pattrv_value : '';
                    }
                    if($attr->pattrkv_pattr_key == 'Total Gemstone(s)')
                    {
                        $gemstone_data['attr_gemstone_total_gem_count'] = isset($attr->pattrkv_pattrv_value) ? $attr->pattrkv_pattrv_value : '';
                    }
                    if($attr->pattrkv_pattr_key == 'Total Gemstone Weight (cts)')
                    {
                        $gemstone_data['attr_gemstone_total_wight'] = isset($attr->pattrkv_pattrv_value) ? $attr->pattrkv_pattrv_value : '';
                    }
                    if($attr->pattrkv_pattr_key == 'Gemstone Colour')
                    {
                        $gemstone_data['attr_gemstone_color'] = isset($attr->pattrkv_pattrv_value) ? $attr->pattrkv_pattrv_value : '';
                    }
                    if($attr->pattrkv_pattr_key == 'Gemstone Composition')
                    {
                        $gemstone_data['attr_gemstone_type'] = isset($attr->pattrkv_pattrv_value) ? $attr->pattrkv_pattrv_value : '';
                    }
                    
                    $gemstone_json = json_encode([$gemstone_data]);
                }
                if($attr->pattrkv_pattr_group == 'Certificate Details')
                {
                    if($attr->pattrkv_pattr_key == 'Certified by Lab')
                    {
                        $certi_type = $attr->pattrkv_pattrv_value;
                    }
                    if($attr->pattrkv_pattr_key == 'Certificate No.')
                    {
                        $certi_no = $attr->pattrkv_pattrv_value;
                    }
                }

            }
            $dateString = $row[46];
            $timestamp = strtotime($dateString);
            $cat = explode(',',$row[15]);
            // dd($cat);
            // $all_primary_cats = Category::pluck('category', 'id')->toArray();
            // $all_sec_cats = Category::whereBetween('id', [12, 19])->pluck('category', 'id')->toArray();
            // $primary_category_id = null;
            // $secondary_category_ids = [];

            // foreach ($cat as $category) {
            //     // Search for the category in the array of primary categories

            //     $category_id = array_search($category, $all_primary_cats);
            //     if ($category_id !== false) {
            //         // If category is found, set it as primary category ID
            //         if ($primary_category_id === null) {
            //             $primary_category_id = $category_id;
            //         } else {
            //             // If primary category is already set, add it to secondary categories
            //             $secondary_category_ids[] = $category_id;
            //         }
            //     } else {
            //         // Search for the category in the array of secondary categories
            //         $category_id = array_search($category, $all_sec_cats);
            //         if ($category_id !== false) {
            //             // If category is found, add it to secondary category IDs
            //             $secondary_category_ids[] = $category_id;
            //         }
            //     }
            // }
            // $secondary_category_ids_string = implode(',', $secondary_category_ids);
            $category = Category::where('category',$cat[0])->first();
            $family = Family::where('family',$row[8])->first();
            $product = new Product();
            $product->p_category = isset($category->id) ? $category->id : null;
            // $product->p_sec_category = isset($secondary_category_ids_string) && $secondary_category_ids_string != '' ? $secondary_category_ids_string : null;
            $product->p_video =  isset($row[36]) && $row[36] != 'NULL' ? $row[36] : null;
            $product->p_family = isset($family->id) ? $family->id : null;
            $product->p_status = isset($attr_status) ? $attr_status : null;
            $product->p_avail_stock_qty = isset($row[48]) && $row[48] != 'NULL' ? $row[48] : null;
            $product->p_ltd_stock_qty = isset($row[49]) && $row[49] != 'NULL' ? $row[49] : null;
            $product->p_title = isset($row[7]) && $row[7] != 'NULL' ? $row[7] : null;
            $product->p_sku = isset($row[35]) && $row[35] != 'NULL' ? $row[35] : null;
            $product->p_description = isset($row[17]) && $row[17] != 'NULL' ? $row[17] : null;
            $product->p_gender = isset($attr_gender) ? $attr_gender : null;
            $product->p_style = isset($attr_style) ? $attr_style : null;
            $product->p_size = isset($attr_size) ? $attr_size : null;
            $product->p_unit = isset($unit) ? $unit : null;
            $product->p_occasion = isset($attr_occasion) ? $attr_occasion : null;
            $product->p_trend = isset($attr_trend) ? $attr_trend : null;
            $product->p_gross_weight = isset($attr_metal_weight) ? $attr_metal_weight : null;
            $product->p_gross_weight_unit = isset($attr_weight_unit) ? $attr_weight_unit : null;
            $product->p_made_in = 101;
            $product->p_gross_weight_unit = isset($attr_weight_unit) ? $attr_weight_unit : null;
            $product->p_metal = isset($attr_metal) ? $attr_metal : null;
            $product->p_metal_purity = isset($attr_purity) ? $attr_purity : null;
            $product->p_metal_weigth = isset($attr_metal_weight) ? $attr_metal_weight : null;
            $product->p_metal_weight_unit = isset($attr_weight_unit) ? $attr_weight_unit : null;
            $product->p_metal_color = isset($attr_metal_color) ? $attr_metal_color : null;
            $product->p_laboraty = isset($certi_type) ? $certi_type : null;
            $product->p_certificate_no = isset($certi_no) ? $certi_no : null;
            $product->diamond_details = isset($diamond_json) ? $diamond_json : null;
            $product->gemstone_details = isset($gemstone_json) ? $gemstone_json : null;
            $product->pearl_details = isset($pearl_json) ? $pearl_json : null;
            if(isset($row[23]) && ($row[23] == 'Fixed' || $row[23] == ''))
            {
                $p_type = 'fix_price';
            }else{
                $p_type = 'dynamic';
                $product->p_pricebreakdown = 'yes';
            }
            $product->p_pricetype = isset($p_type) ? $p_type : null;
            if($row[23] == 'Fixed' || $row[23] == '')
            {
                $product->p_fix_price = isset($row[20]) ? $row[20] : null;
            }
            if(isset($row[21]) && $row[21] != 'NULL')
            {
                $product->fix_dis = 'price';
                $discount_price = $row[20] - $row[21];
                $product->p_discount = isset($discount_price) ? $discount_price : null;
            }
            $product->total_making_charges = isset($row[24]) && $row[24] != 'NULL' ? $row[24] : null;
            $product->dis_making_price = isset($row[25]) && $row[25] != 'NULL' ? $row[25] : null;
            $product->p_total_diamond_charge = isset($row[26]) && $row[26] != 'NULL' ? $row[26] : null;
            if(isset($row[27]) && $row[27] != 'NULL')
            {
                $product->diamond_dis = 'price';
            }
            $product->dis_diamond_price = isset($row[27]) && $row[27] != 'NULL' ? $row[27] : null;
            $product->p_total_other_charge = isset($row[30]) && $row[30] != 'NULL' ? $row[30] : null;
            $product->p_total_tax_charge = isset($row[31]) && $row[31] != 'NULL' ? $row[31] : null;
            $product->p_final_metal_price = isset($row[31]) && $row[31] != 'NULL' ? $row[31] : null;
            if(isset($row[14]) && $row[14] == 'Yes')
            {
                $visible = 1;
            }else{
                $visible = 0;
            }
            $product->visiblity = $visible;
            $product->p_slug = isset($row[5]) ? $row[5] : null;
            $product->p_tags = isset($row[51]) && $row[51] != 'NULL' ? $row[51] : null;
            $product->db_status = 'migrated';
            $product->old_updated_at = null;
            $product->save();
            $product_id = $product->id;
            if(isset($row[51]) && $row[51] != 'NULL' && $row[51] != null)
            {
                // dd($row[50]);
                $tags = explode(',',$row[51]);
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
            
            // $one_p_img = new ProductImage();
            // $one_p_img->product_id = $product_id;
            // $one_p_img->name = 'business_product/' . (isset($row[52]) && $row[52] != 'NULL' ? $row[52] : null);
            // $one_p_img->featured = 1;
            // $one_p_img->save();

            
            // dd($pro_images);
            // if (!empty($one_p_img->name) && !ProductImage::where('name', $one_p_img->name)->exists()) {
                $pro_images = BizProductAttachment::where('bpa_bpr_id',$row[0])->get();
                foreach($pro_images as $p_img)
                {
                    $existing_i = ProductImage::where('product_id',$product_id)->where('name','business_product/' .$p_img->bpa_attachment)->first();
                    if(isset($existing_i) && $existing_i != null &&  $existing_i != '')
                    {

                    }else{
                        $n_p_img = new ProductImage();
                        $n_p_img->product_id = $product_id;
                        $n_p_img->name = 'business_product/' . (isset($p_img->bpa_attachment) ? $p_img->bpa_attachment : null);
                        $n_p_img->featured = 0;
                        $n_p_img->save();
                    }
                }
            
        }

        echo 'added successfully';
    }

    public function import_catalogues()
    {
        $products_id = DB::table('biz_product_catalogue')->where('bcat_pr_bcat_id',4265)->where('bcat_pr_status', 'Active')->pluck('bcat_pr_bpr_id');
        $products_slugs = [];
        foreach($products_id as $id)
        {
            $products_slug = DB::table('biz_products')->where('bpr_id',$id)->first();
            $products_slugs[] = $products_slug->bpr_slug;
        }
        foreach($products_slugs as $slug)
        {
            $new_products = Product::where('p_slug',$slug)->where('visiblity',1)->first();
            if(isset($new_products) && $new_products != null)
            {
                $all_ids[] = $new_products->id;
            }
            
        }

        $catalog_id = implode(',',$all_ids);
        dd($catalog_id);
    }

    public function catalogue_sitemap_xml()

    {

        $catalogues = Catalogue::where('status', 1)->latest()->get();

        return response()->view('front.sitemaps.catalogue', compact('catalogues'))->header('Content-Type', 'application/xml');


    }
    public function collection_sitemap_xml()

    {

        $collections = Collection::where('status', 1)->latest()->get();

        return response()->view('front.sitemaps.collection', compact('collections'))->header('Content-Type', 'application/xml');

    }
    public function product_sitemap_xml()

    {

        $products = Product::where('visiblity', 1)->latest()->get();

        return response()->view('front.sitemaps.product', compact('products'))->header('Content-Type', 'application/xml');

    }
    public function productfilter_sitemap_xml()

    {

        $catagories = Category::withCount('products')->orderByDesc('products_count')->get();
        $families = Family::get();
        $carates = MetalPurity::get();
        $occasions = Occasion::get();
        return response()->view('front.sitemaps.product_filter', compact('catagories','families','carates','occasions'))->header('Content-Type', 'application/xml');

    }
    public function download_rss_xml()
    {
        $products = Product::with('category')->where('visiblity', 1)->where('is_public', 1)->where(function($query) {
            $query->where('publish_status', 'publish')
              ->orWhereNull('publish_status');
        })->latest()->get();
        $vproducts = VariantProduct::with('category')->where('visiblity', 1)->where('is_public', 1)->where(function($query) {
            $query->where('publish_status', 'publish')
            ->orWhereNull('publish_status');
        })->latest()->get();
        $mergedProducts = $products->concat($vproducts);
        $bs = BusinessSetting::first();
        return response()->view('front.rss_xml', compact('mergedProducts','bs'))->header('Content-Type', 'application/xml');

    }
}