<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Catalogue;
use App\Models\Category;
use App\Models\Family;
use App\Models\Product;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Services\SlugService;
use DateTime;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class CatalogueController extends Controller
{
    public function index()
    {
        return view('catalogue.index');
    }

    public function add()
    {
        return view('catalogue.add');
    }

    public function save(Request $request)
    {
        // dd($request->all());
        if (isset($request->catalogue_id) && $request->catalogue_id != null && $request->catalogue_id != '') {
            $catalogue = Catalogue::findOrfail($request->catalogue_id);
        } else {
            $catalogue = new Catalogue();
        }
        if ($request->hasFile('cover_image')) {
            $current = Carbon::now()->format('YmdHs');
            $uploadvideo = $request->file('cover_image');
            $video_name = $current . $uploadvideo->getClientOriginalName();
            $uploadvideo->move('uploads/catalogue/', $video_name);
            $videoName = $video_name;

            $manager = new ImageManager(new Driver());
            $image = $manager->read(base_path('/public/uploads/catalogue/') . $video_name);

            $image = $image->resize(300, 300);
            $image->toJpeg(80)->save(base_path('/public/uploads/catalogue/300/' . $video_name));

        } else {
            $videoName = isset($request->cover_old_img) ? $request->cover_old_img : null;
        }
        $slug = SlugService::createSlug(Catalogue::class, 'slug', $request->name);
        $catalogue->slug = $slug;
        $catalogue->name = isset($request->name) ? $request->name : null;
        $catalogue->status = isset($request->status) && $request->status == 'on' ? 1 : 0;
        $catalogue->cover_image = isset($videoName) ? $videoName : null;
        $catalogue->link = isset($request->link) ? $request->link : null;
        $catalogue->save();
        //$catalogue->makeThumbnail('cover_image',$videoName);
        return redirect()->route('catalogue.index')->with('success', 'Catalogue Saved Successfully.');
    }

    public function list(Request $request)
    {
        $catalogues = Catalogue::latest()->get();
        $counter = 1;

        $catalogues->transform(function ($item) use (&$counter) {
            $item['ser_id'] = $counter++;
            if (isset($item['product_id']) && $item['product_id'] != '' && $item['product_id'] != null) {
                $productId = $item['product_id'];
                if (substr($productId, 0, 1) == ',') {
                    $productId = substr($productId, 1);
                }
                $item['product_count'] = count(explode(',', $productId));
            }
            // $item['product_count'] = $counter++;
            if (isset($item['cover_image']) && $item['cover_image'] != '' && $item['cover_image'] != null) {

                $frst_path = base_path('public/uploads/catalogue/300/' . $item['cover_image']);

                if (file_exists($frst_path))
                    $path = asset('uploads/catalogue/300/' . $item['cover_image']);
                else
                    $path = asset('uploads/catalogue/' . $item['cover_image']);

            } else {
                $path = asset('assets/images/user/img-demo_1041.jpg');
            }

            $item['p_title_div'] = '<div class="p_details"><img src="' . $path . '"><p>' . (isset($item['name']) ? $item['name'] : '-') . ' (' . (isset($item['product_count']) ? $item['product_count'] : 0) . ')</p></div>';

            if (isset($item['updated_at']) && $item['updated_at'] != '') {
                $dateTime = new DateTime($item['updated_at']);
                $formattedDate = $dateTime->format('d-m-Y');
                $item['date'] = $formattedDate;
            } else {
                $item['date'] = "-";
            }

            if ($item['status'] == '1') {
                $item['status'] = '<input type="checkbox" data-id="' . $item['id'] . '" data-toggle="toggle" id="is_featured"  checked class="is_featured_class">';
            } else {
                $item['status'] = '<input type="checkbox" data-id="' . $item['id'] . '" data-toggle="toggle" id="is_featured"  class="is_featured_class">';
            }
            $text = 'Add';
            if (isset($item['product_id']) && $item['product_id'] != null && $item['product_id'] != '') {
                $text = 'Add';
            }

            $item['action'] = '<a href="' . route('catalogue.edit', $item['id']) . '" class="table-btn table-btn1 mx-2 edit" data-id="' . $item['id'] . '" title="Click here to Edit Catalogue"  ><img src="' . asset('images/dashbord/create.png') . '" class="image-fuild" alt="user-img"></a>';
            $item['action'] .= '<a href="javascript:;" data-href="' . route('catalogue.delete', $item['id']) . '" class="table-btn table-btn1 delete" title="Click here to Delete Catalogue" ><img src="' . asset('images/dashbord/delete.png') . '" class="image-fuild" alt="user-img"></a><a href="' . route('catalogue.different.view', $item['slug']) . '" class="list_text" title="Click here to Add Products in Catalogue">' . $text . ' Products</a>';

            return $item;
        });


        return response()->json(['data' => $catalogues]);
    }

    public function edit($id)
    {
        $catalogue = Catalogue::findOrfail($id);
        return view('catalogue.add', compact('catalogue'));
    }

    public function delete($id)
    {
        $catalogue = Catalogue::findOrfail($id);
        if (isset($catalogue) && $catalogue != '' && $catalogue != null) {
            $catalogue->delete();
            return redirect()->route('catalogue.index')->with('error', 'Catalogue Deleted Successfully!');
        } else {
            return redirect()->route('catalogue.index')->with('error', 'Something Went Wrong!');
        }
    }

    public function status(Request $request)
    {
        $catalogue = Catalogue::findOrfail($request->id);
        if (isset($request->isChecked) && $request->isChecked == 'true') {
            $catalogue->update(['status' => 1]);
            return response()->json(['status' => 1, 'message' => 'Catalogue Enable Successfully']);
        } else {
            $catalogue->update(['status' => 0]);
            return response()->json(['status' => 1, 'message' => 'Catalogue Disable Successfully']);
        }
    }

    public function different_view($slug)
    {
        $categories = Category::all();
        $catalogue = Catalogue::where('slug', $slug)->first();
        if (isset($catalogue) && $catalogue != null && $catalogue != '') {
            $added_products = explode(',', $catalogue->product_id);
        }
        return view('catalogue.different-view', compact('categories', 'catalogue', 'added_products'));
    }

    public function show_count_cat(Request $request)
    {
        $query = Product::where('visiblity', 1);
        if (isset($request->text) && $request->text != '' && $request->text != null) {
            $query->where('p_title', 'like', '%' . $request->text . '%')->orWhere('p_sku', 'like', '%' . $request->text . '%');
        }
        if (isset($request->cat) && $request->cat != '' && $request->cat != null) {
            $query->where('p_category', $request->cat);
        }
        if (isset($request->fam) && $request->fam != '' && $request->fam != null && $request->fam != 'Select Family') {
            $query->where('p_family', $request->fam);
        }
        if (isset($request->tag) && $request->tag != '') {
            $query->where('p_tags', 'like', '%' . $request->tag . '%');
        }
        $total_count = $query->count();
        $catalogue = Catalogue::where('id', $request->catalogue_id)->first();
        if (isset($catalogue) && $catalogue != null && $catalogue != '') {
            $added_products = array_filter(explode(',', $catalogue->product_id), function ($value) {
                if ($value !== "") {
                    return $value;
                }
            });
        }
        if (count($added_products) > 0) {
            $query->orderByRaw('FIELD(id, ' . implode(',', $added_products) . ') DESC');
        }
        $products = $query->latest()->take($request->show_count)->get();
        $itemsPerPage = $request->show_count;
        $currentPage = ceil(1 / $itemsPerPage);
        $view = view('catalogue.combine-view', compact('products', 'added_products', 'catalogue', 'total_count', 'currentPage', 'itemsPerPage'))->render();
        return response()->json(['html' => $view]);
    }

    public function add_product_cat(Request $request)
    {
        if (isset($request->ids) && $request->ids != null && $request->ids != '') {
            $uniqueIds = array_values(array_unique($request->ids));
        } else {
            $uniqueIds = [];
        }
        $catalogue = Catalogue::findOrfail($request->catalogue_id);
        if (isset($catalogue) && $catalogue != '' && $catalogue != null) {
            $products = implode(',', $uniqueIds);
            $catalogue->product_id = isset($products) ? $products : null;
            $catalogue->save();
            return response()->json(['status' => 1, 'message' => 'Products Added in Catalogue Successfully.']);
        } else {
            return response()->json(['status' => 0, 'message' => 'Something Went Wrong!']);
        }
    }

    public function search_product_cat(Request $request)
    {
        // dd($request->all());
        $query = Product::where('visiblity', 1);
        if (isset($request->text) && $request->text != '' && $request->text != null) {
            $query->where('p_title', 'like', '%' . $request->text . '%')->orWhere('p_sku', 'like', '%' . $request->text . '%');
        }
        if (isset($request->cat) && $request->cat != '' && $request->cat != null) {
            $query->where('p_category', $request->cat);
        }
        if (isset($request->fam) && $request->fam != '' && $request->fam != null && $request->fam != 'Select Family') {
            $query->where('p_family', $request->fam);
        }
        if (isset($request->tag) && $request->tag != '') {
            $query->where('p_tags', 'like', '%' . $request->tag . '%');
        }
        $total_count = $query->count();
        $itemsPerPage = $request->show_count;
        $start = 0;
        $products = $query->latest()->skip($start - 1)->take($itemsPerPage)->get();
        $catalogue = Catalogue::where('id', $request->catalogue_id)->first();
        if (isset($catalogue) && $catalogue != null && $catalogue != '') {
            $added_products = explode(',', $catalogue->product_id);
        }
        $currentPage = ceil(1 / $itemsPerPage);
        $view = view('catalogue.combine-view', compact('products', 'added_products', 'catalogue', 'total_count', 'currentPage', 'itemsPerPage'))->render();
        return response()->json(['status' => 1, 'html' => $view, 'currentPage' => (int)$currentPage]);
    }

    public function page_product_cat(Request $request)
    {
        // dd($request->all());
        $itemsPerPage = $request->show_count;
        $start = $request->start;
        $end = $request->end;
        $query = Product::where('visiblity', 1);
        if (isset($request->text) && $request->text != '' && $request->text != null) {
            $query->where('p_title', 'like', '%' . $request->text . '%')->orWhere('p_sku', 'like', '%' . $request->text . '%');
        }
        if (isset($request->cat) && $request->cat != '' && $request->cat != null) {
            $query->where('p_category', $request->cat);
        }
        if (isset($request->fam) && $request->fam != '' && $request->fam != null && $request->fam != 'Select Family') {
            $query->where('p_family', $request->fam);
        }
        if (isset($request->tag) && $request->tag != '') {
            $query->where('p_tags', 'like', '%' . $request->tag . '%');
        }
        $total_count = $query->count();
        $products = $query->latest()->skip($start - 1)->take($itemsPerPage)->get();
        $currentPage = floor(((int)$start) / $itemsPerPage);
        $catalogue = Catalogue::where('id', $request->catalogue_id)->first();
        if (isset($catalogue) && $catalogue != null && $catalogue != '') {
            $added_products = explode(',', $catalogue->product_id);
        }
        // dd((int)$currentPage);
        $view = view('catalogue.combine-view', compact('products', 'added_products', 'total_count', 'currentPage', 'itemsPerPage'))->render();
        return response()->json(['status' => 1, 'html' => $view, 'currentPage' => (int)$currentPage]);
    }

    public function filter_cat(Request $request)
    {
        // dd($request->all());
        $query = Catalogue::select('*');
        if (isset($request->search_text) && $request->search_text != '') {
            $query->where('name', 'like', '%' . $request->search_text . '%');
        }
        if ($request->status != "2") {
            $query->where('status', $request->status);
        }

        if ($request->from_date != "") {
            $from_date = Carbon::createFromFormat('m/d/Y', $request->from_date)->startOfDay();
            $query->where('updated_at', '>=', $from_date);
        }
        if ($request->to_date != "") {
            $to_date = Carbon::createFromFormat('m/d/Y', $request->to_date)->endOfDay();
            $query->where('updated_at', '<=', $to_date);
        }

        $catalogues = $query->latest()->get();
        $counter = 1;
        $catalogues->transform(function ($item) use (&$counter) {
            $item['ser_id'] = $counter++;

            if (isset($item['product_id']) && $item['product_id'] != '' && $item['product_id'] != null) {
                $productId = $item['product_id'];
                if (substr($productId, 0, 1) == ',') {
                    $productId = substr($productId, 1);
                }
                $item['product_count'] = count(explode(',', $productId));
            }
            // $item['product_count'] = $counter++;
            if (isset($item['cover_image']) && $item['cover_image'] != '' && $item['cover_image'] != null) {

                $frst_path = base_path('public/uploads/catalogue/300/' . $item['cover_image']);

                if (file_exists($frst_path))
                    $path = asset('uploads/catalogue/300/' . $item['cover_image']);
                else
                    $path = asset('uploads/catalogue/' . $item['cover_image']);

            } else {
                $path = asset('assets/images/user/img-demo_1041.jpg');
            }

            $item['p_title_div'] = '<div class="p_details"><img src="' . $path . '"><p>' . (isset($item['name']) ? $item['name'] : '-') . ' (' . (isset($item['product_count']) ? $item['product_count'] : 0) . ')</p></div>';


            if (isset($item['updated_at']) && $item['updated_at'] != '') {
                $dateTime = new DateTime($item['updated_at']);
                $formattedDate = $dateTime->format('d-m-Y');
                $item['date'] = $formattedDate;
            } else {
                $item['date'] = "-";
            }

            if ($item['status'] == '1') {
                $item['status'] = '<input type="checkbox" data-id="' . $item['id'] . '" data-toggle="toggle" id="is_featured"  checked class="is_featured_class">';
            } else {
                $item['status'] = '<input type="checkbox" data-id="' . $item['id'] . '" data-toggle="toggle" id="is_featured"  class="is_featured_class">';
            }
            $text = 'Add';
            if (isset($item['product_id']) && $item['product_id'] != null && $item['product_id'] != '') {
                $text = 'Add';
            }

            $item['action'] = '<a href="' . route('catalogue.edit', $item['id']) . '" class="table-btn table-btn1 mx-2 edit" data-id="' . $item['id'] . '" title="Click here to Edit Catalogue"  ><img src="' . asset('images/dashbord/create.png') . '" class="image-fuild" alt="user-img"></a>';
            $item['action'] .= '<a href="javascript:;" data-href="' . route('catalogue.delete', $item['id']) . '" class="table-btn table-btn1 delete" title="Click here to Delete Catalogue" ><img src="' . asset('images/dashbord/delete.png') . '" class="image-fuild" alt="user-img"></a><a href="' . route('catalogue.different.view', $item['slug']) . '" class="list_text" title="Click here to Add Products in Catalogue">' . $text . ' Products</a>';

            return $item;
        });
        return response()->json(['data' => $catalogues]);
    }

    public function fetch_family(Request $request)
    {
        $families = Family::whereRaw('FIND_IN_SET(?, category_id)', $request->cat)->get();
        return response()->json(['families' => $families]);
    }

    public function createThumbnail($path, $width, $height)
    {
        $img = Image::make($path)->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
        });
        $img->save($path);
    }
}
