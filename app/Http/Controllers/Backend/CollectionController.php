<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Collection;
use App\Models\Catalogue;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Services\SlugService;
use DateTime;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class CollectionController extends Controller
{
    public function index()
    {
        return view('collection.index');
    }
    public function add()
    {
        return view('collection.add');
    }
    public function save(Request $request)
    {
        // dd($request->all());
        if(isset($request->collection_id) && $request->collection_id != null && $request->collection_id != '')
        {
            $collection = Collection::findOrfail($request->collection_id);
        }else{
            $collection = new Collection();
        }
        if ($request->hasFile('cover_image')) {
                $current = Carbon::now()->format('YmdHs');
                $uploadvideo = $request->file('cover_image');
                $video_name = $current . $uploadvideo->getClientOriginalName();
                $uploadvideo->move('uploads/collections/', $video_name);
                $videoName = $video_name;

                $manager = new ImageManager(new Driver());
                $image = $manager->read(base_path('/public/uploads/collections/').$video_name);

                $image = $image->resize(300,300);
                $image->save(base_path('/public/uploads/collections/300/'.$video_name));
        }else{
            $videoName = isset($request->cover_old_img) ? $request->cover_old_img : null;
        }
        $slug = SlugService::createSlug(Collection::class, 'slug', $request->name);
        $collection->slug = $slug;
        $collection->name = isset($request->name) ? $request->name : null;
        $collection->status = isset($request->status) && $request->status == 'on' ? 1 : 0;
        $collection->cover_image = isset($videoName) ? $videoName : null;
        $collection->link = isset($request->link) ? $request->link : null;
        $collection->description = isset($request->description) ? $request->description : null;
        $collection->save();
        return redirect()->route('collection.index')->with('success','Collection Saved Successfully.');
    }

    public function list(Request $request)
    {
        $collections = Collection::latest()->get();
        $counter = 1;
        $collections->transform(function ($item) use (&$counter) {
            $item['ser_id'] = $counter++;
            if(isset($item['catalogue_id']) && $item['catalogue_id'] != '' && $item['catalogue_id'] != null)
            {
                $catalogueId = $item['catalogue_id'];
                if (substr($catalogueId, 0, 1) == ',') {
                    $catalogueId = substr($catalogueId, 1);
                }
                $item['product_count'] = count(explode(',', $catalogueId)); 
            }
            
            if(isset($item['cover_image']) && $item['cover_image'] != '' && $item['cover_image'] != null)
            {
                $frst_path = base_path('public/uploads/collections/300/'.$item['cover_image']);
                  
                    if(file_exists($frst_path))
                        $path = asset('uploads/collections/300/'.$item['cover_image']);
                    else
                        $path = asset('uploads/collections/'.$item['cover_image']);

            }else{
                $path = asset('assets/images/user/img-demo_1041.jpg');
            }
            
            $item['p_title_div'] = '<div class="p_details"><img src="'.$path.'"><p>'.(isset($item['name']) ? $item['name'] : '-').' ('.(isset($item['product_count']) ? $item['product_count'] : 0) .')</p></div>';

            if (isset($item['updated_at']) && $item['updated_at'] != '') {
                $dateTime = new DateTime($item['updated_at']);
                $formattedDate = $dateTime->format('d-m-Y | h:iA');
                $item['date'] = $formattedDate; 
            }else{
                $item['date'] = "-";
            }

            if ($item['status'] == '1') {
                $item['status'] = '<input type="checkbox" data-id="' . $item['id'] . '" data-toggle="toggle" id="is_featured"  checked class="is_featured_class">';
            } else {
                $item['status'] = '<input type="checkbox" data-id="' . $item['id'] . '" data-toggle="toggle" id="is_featured"  class="is_featured_class">';
            }
            $item['action'] = '<a href="' . route('collection.edit', $item['id']) . '" class="table-btn table-btn1 mx-2 edit" data-id="' . $item['id'] . '" title="Click here for Edit Collection"  ><img src="'.asset('images/dashbord/create.png').'" class="image-fuild" alt="user-img"></a>';
            $item['action'] .= '<a href="javascript:;" data-href="' . route('collection.delete', $item['id']) . '" class="table-btn table-btn1 delete" title="Click here for Delete Collection"  ><img src="'.asset('images/dashbord/delete.png').'" class="image-fuild" alt="user-img"></a><a href="'.route('collection.different.view',$item['slug']).'" class="list_text" title="Click here to Add Catalogues in Collection">Add Catalogues</a>';
            return $item;
        });

        return response()->json(['data' => $collections]);
    }

    public function edit($id)
    {
        $collection = Collection::findOrfail($id);
        return view('collection.add',compact('collection'));
    }
    public function delete($id)
    {
        $collection = Collection::findOrfail($id);
        if(isset($collection) && $collection != '' && $collection != null)
        {
            $collection->delete();
            return redirect()->route('collection.index')->with('error', 'Collection Deleted Successfully!');
        }else{
            return redirect()->route('collection.index')->with('error', 'Something Went Wrong!');
        }
    }
    public function status(Request $request)
    {
        $collection = Collection::findOrfail($request->id); 
        if(isset($request->isChecked) && $request->isChecked == 'true')
        {
          $collection->update(['status' => 1]);  
          return response()->json(['status' => 1,'message' => 'Collection Enable Successfully']);
        }else{
           $collection->update(['status' => 0]); 
           return response()->json(['status' => 1,'message' => 'Collection Disable Successfully']);
        }
    }

    public function different_view($slug)
    {
        $collection = Collection::where('slug', $slug)->first();
        if (isset($collection) && $collection != null && $collection != '') {
            $added_products = explode(',', $collection->catalogue_id);
        }
        $catalogues = Catalogue::latest()->take(20)->get();
        $total_count = Catalogue::count();
        $itemsPerPage = 20;
        $currentPage = ceil(1 / $itemsPerPage); // Assuming you want the first page by default
        return view('collection.different-view', compact('collection', 'catalogues', 'added_products', 'total_count', 'itemsPerPage', 'currentPage'));
    }
    public function show_count_cat(Request $request)
    {
        $query = Catalogue::where('status',1);
        if(isset($request->text) && $request->text != '' && $request->text != null)
        {
            $query->where('name', 'like', '%'.$request->text.'%');
        }
        $total_count = $query->count();
        $itemsPerPage = isset($request->show_count) ? $request->show_count : 25;
        $catalogues = $query->latest()->take($itemsPerPage)->get();
        $collection = Collection::where('id', $request->collection_id)->first();
        if (isset($collection) && $collection != null && $collection != '') {
            $added_products = explode(',', $collection->catalogue_id);
        }
  
        $currentPage = ceil(1 / $itemsPerPage);
        $view = view('collection.combine-view', compact('catalogues','added_products','collection','total_count', 'currentPage','itemsPerPage'))->render();
        return response()->json(['html' => $view]);
    }
    public function add_catalogue_cat(Request $request)
    {
        if(isset($request->ids) && $request->ids != null && $request->ids != '')
        {
            $uniqueIds = array_values(array_unique($request->ids));
        }else{
            $uniqueIds = [];
        }
        $collection = Collection::findOrfail($request->collection_id); 
        if(isset($collection) && $collection != '' && $collection != null)
        {
            $catalogues = implode(',', $uniqueIds);
            $collection->catalogue_id = isset($catalogues) ? $catalogues : null;
            $collection->save();
            return response()->json(['status' => 1, 'message' => 'Catalogues Added in Collection Successfully.']);
        }else{
            return response()->json(['status' => 0, 'message' => 'Something Went Wrong!']);
        }
    }

    public function search_catalogue_cat(Request $request)
    {
        // dd($request->all());
        $query = Catalogue::where('status',1);
        if(isset($request->text) && $request->text != '' && $request->text != null)
        {
            $query->where('name', 'like', '%'.$request->text.'%');
        }
        $total_count = $query->count();
        $itemsPerPage = isset($request->show_count) ? $request->show_count : 25;
        $catalogues = $query->latest()->take($itemsPerPage)->get();
        $collection = Collection::where('id', $request->collection_id)->first();
        if (isset($collection) && $collection != null && $collection != '') {
            $added_products = explode(',', $collection->catalogue_id);
        }
        $itemsPerPage = isset($request->show_count) ? $request->show_count : 25;
    
        $currentPage = ceil(1 / $itemsPerPage);
        $view = view('collection.combine-view', compact('catalogues','added_products','collection','total_count', 'currentPage','itemsPerPage'))->render();
        return response()->json(['status' => 1, 'html' => $view]);
    }
    public function page_catalogue_cat(Request $request)
    {
        $itemsPerPage = $request->show_count;
        $start = $request->start;
        $end = $request->end;
        $query = Catalogue::where('status',1);
        if(isset($request->text) && $request->text != '' && $request->text != null)
        {
            $query->where('name', 'like', '%'.$request->text.'%');
        }
        $total_count = $query->count();
        $catalogues = Catalogue::latest()->skip($start - 1)->take($itemsPerPage)->get();
        $collection = Collection::where('id', $request->collection_id)->first();
        if (isset($collection) && $collection != null && $collection != '') {
            $added_products = explode(',', $collection->catalogue_id);
        }
        $currentPage = floor(((int)$start) / $itemsPerPage);
        // dd((int)$currentPage);
        $view = view('collection.combine-view', compact('catalogues', 'added_products','total_count', 'currentPage','itemsPerPage'))->render();
        return response()->json(['status' => 1, 'html' => $view,'currentPage' =>(int)$currentPage]);
    }

    public function filter_cat(Request $request)
    {
        $query = Collection::select('*');

        if(isset($request->search_text) && $request->search_text != '')
        {
            $query->where('name', 'like', '%'.$request->search_text.'%');
        }
        if ($request->status != "2") {
            $query->where('status',$request->status);
        }

        if ($request->from_date != "") {
            $from_date = Carbon::createFromFormat('m/d/Y', $request->from_date)->startOfDay();
            $query->where('updated_at', '>=',$from_date);

        }

        if ($request->to_date != "") {
             $to_date = Carbon::createFromFormat('m/d/Y', $request->to_date)->endOfDay();
             $query->where('updated_at', '<=', $to_date);
        }

        $collections =  $query->latest()->get();
        $counter = 1;
        $collections->transform(function ($item) use (&$counter) {
            $item['ser_id'] = $counter++;
            if(isset($item['catalogue_id']) && $item['catalogue_id'] != '' && $item['catalogue_id'] != null)
            {
                $catalogueId = $item['catalogue_id'];
                if (substr($catalogueId, 0, 1) == ',') {
                    $catalogueId = substr($catalogueId, 1);
                }
                $item['product_count'] = count(explode(',', $catalogueId)); 
            }
            
            if(isset($item['cover_image']) && $item['cover_image'] != '' && $item['cover_image'] != null)
            {
                $frst_path = base_path('public/uploads/collections/300/'.$item['cover_image']);
                  
                    if(file_exists($frst_path))
                        $path = asset('uploads/collections/300/'.$item['cover_image']);
                    else
                        $path = asset('uploads/collections/'.$item['cover_image']);

            }else{
                $path = asset('assets/images/user/img-demo_1041.jpg');
            }
            
            $item['p_title_div'] = '<div class="p_details"><img src="'.$path.'"><p>'.(isset($item['name']) ? $item['name'] : '-').' ('.(isset($item['product_count']) ? $item['product_count'] : 0) .')</p></div>';

            if (isset($item['updated_at']) && $item['updated_at'] != '') {
                $dateTime = new DateTime($item['updated_at']);
                $formattedDate = $dateTime->format('d-m-Y | h:iA');
                $item['date'] = $formattedDate; 
            }else{
                $item['date'] = "-";
            }

            if ($item['status'] == '1') {
                $item['status'] = '<input type="checkbox" data-id="' . $item['id'] . '" data-toggle="toggle" id="is_featured"  checked class="is_featured_class">';
            } else {
                $item['status'] = '<input type="checkbox" data-id="' . $item['id'] . '" data-toggle="toggle" id="is_featured"  class="is_featured_class">';
            }
            $item['action'] = '<a href="' . route('collection.edit', $item['id']) . '" class="table-btn table-btn1 mx-2 edit" data-id="' . $item['id'] . '" title="Click here for Edit Collection"  ><img src="'.asset('images/dashbord/create.png').'" class="image-fuild" alt="user-img"></a>';
            $item['action'] .= '<a href="javascript:;" data-href="' . route('collection.delete', $item['id']) . '" class="table-btn table-btn1 delete" title="Click here for Delete Collection"  ><img src="'.asset('images/dashbord/delete.png').'" class="image-fuild" alt="user-img"></a><a href="'.route('collection.different.view',$item['slug']).'" class="list_text" title="Click here to Add Catalogues in Collection">Add Catalogues</a>';
            return $item;
        });
        return response()->json(['data' => $collections]);
    }
}
