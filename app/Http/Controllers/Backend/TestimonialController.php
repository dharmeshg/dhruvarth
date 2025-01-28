<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Testimonial;
use Illuminate\Support\Facades\File;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Support\Str;
use App\Models\Updatelog;
use DateTime;
use Carbon\Carbon;

class TestimonialController extends Controller
{
    public function index()
    {
        return view('testimonials.index');
    }
    public function add()
    {
        return view('testimonials.add');
    }
    public function list(Request $request)
    {

        $testi_list = Testimonial::latest()->get();
        $counter = 1;
        $testi_list->transform(function ($item) use (&$counter) {
            $item['ser_id'] = $counter++;
            if (isset($item['updated_at']) && $item['updated_at'] != '') {
                $dateTime = new DateTime($item['updated_at']);
                $formattedDate = $dateTime->format('d-m-Y | h:iA');
                $item['date'] = $formattedDate; 
            }else{
                $item['date'] = "-";
            }
            $item['action'] = '<a href="javascript:;" style="color: #e0b667;" class="view_comment first-button" data-id="' . $item['id'] . '" title="Click Here To View Comment"><img src="'.asset('images/dashbord/Eye image.png').'" class="image-fuild" alt="user-img"></a> </a><a href="' . route('testimonials.edit', $item['id']) . '" data-href="" data-title="testrete" data-original-title="Edit Tags" class="tags_edit table-btn table-btn1 edit " title="Click Here To Edit Testimonial"><img src="'.asset('images/dashbord/create.png').'" class="image-fuild" alt="user-img"></a>  <a href="javascript:;" data-href="' . route('testimonials.delete', $item['id']) . '" data-title="testrete" data-original-title="Delete Tags" class="tags_delete table-btn table-btn1 delete" title="Click Here To Delete Testimonial"><img src="'.asset('images/dashbord/delete.png').'" class="image-fuild" alt="user-img"></a>';

             if ($item['is_featured'] == '1') {
                $item['is_featured'] = '<input type="checkbox" class="is_featured_class" data-id="' . $item['id'] . '"  id="is_featured" name="is_featured" checked>';
            } else {
                $item['is_featured'] = '<input type="checkbox" class="is_featured_class" data-id="' . $item['id'] . '" id="is_featured" name="is_featured">';
            }

            if (isset($item['rating']) && $item['rating'] != '') {
                 $rating = max(min($item['rating'], 5), 0);
                $integerPart = floor($rating);
                $decimalPart = $rating - $integerPart;
                $reting = '';
                for ($i = 1; $i <= $integerPart; $i++) {
                    $reting .= '<i class="fa fa-star" style="color: #E4B513; font-size: 20px; margin-right: 5px;"></i>';
                }
                if ($decimalPart > 0) {
                    $reting .= '<i class="fa fa-star-half-o" style="color: #E4B513; font-size: 20px; margin-right: 5px;"></i>';
                    $integerPart++; 
                }
                for ($i = $integerPart + 1; $i <= 5; $i++) {
                     $reting .= '<i class="fa fa-star-o" style="color: #E4B513; font-size: 20px; margin-right: 5px;"></i>';
                }
                $item['rating'] = $reting;
            }
            return $item;

        });

        return response()->json(['data' => $testi_list]);
    }
    public function store(Request $request)
    {   
        if(isset($request->testimonial_id) && $request->testimonial_id != null && $request->testimonial_id != '')
        {
            $testi = Testimonial::findOrfail($request->testimonial_id);
        }else{
            $testi = new Testimonial();
        }

        // $testi = new Testimonial();
        $testi->name = isset($request->name) ? $request->name : '';
        $testi->rating = isset($request->rating) ? $request->rating : null;
        $testi->phone = isset($request->autocomplete_search) ? $request->autocomplete_search : null;
        $testi->sub_content = isset($request->description) ? $request->description : '';
        // $testi->status_select = isset($request->is_featured) ? $request->is_featured : '';
        $testi->save();
        return redirect()->route('testimonials.index')->with('success','Testimonial Saved Successfully.');
    }
 
    public function edit($id)
    {
        $testimonial = Testimonial::findOrfail($id);
        return view('testimonials.add',compact('testimonial'));
    }
    public function update($id)
    {
        $testimonial = Testimonial::findOrfail($id);
        return redirect()->route('testimonials.index')
        ->withSuccess('Testimonial Update Successfully.');
    }
    public function delete($id)
    {
        if ($id != "") {
            $record = Testimonial::find($id);
            $record->delete();
            return redirect()->route('testimonials.index')
                ->withSuccess('Testimonial Delete Successfully.');

        }
    }

      public function check_featured(Request $request)
    {
        $id = $request->id;
        $response['status'] = 0;
        $response['message'] = "Check Featured canceled";
      

        if (isset($request->isChecked) && $request->isChecked != 'true') {
            $data['is_featured'] = 0;
            $save = Testimonial::where('id', $id)->update($data);
            $response['status'] = 1;
            $response['message'] = "Disable Successfully";

        } else {
            $data['is_featured'] = 1;
            $save = Testimonial::where('id', $id)->update($data);
            $response['status'] = 2;
            $response['message'] = "Enable Successfully";

        }
        return response()->json($response);
    }

public function search_testi_status(Request $request)
    {
        // dd($request->all());
        $query = Testimonial::select('*');        
        if(isset($request->search_text) && $request->search_text != '')
        {
            $query->where('name', 'like', '%'.$request->search_text.'%');
        }

        if ($request->from_date != "") {
            $from_date = Carbon::createFromFormat('m/d/Y', $request->from_date)->startOfDay();
            $query->where('updated_at', '>=',$from_date);
        }
        if ($request->to_date != "") {
             $to_date = Carbon::createFromFormat('m/d/Y', $request->to_date)->endOfDay();
             $query->where('updated_at', '<=', $to_date);
        }
        if ($request->has('status') && $request->status === '0') {
            $query->where(function($query) {
                $query->where('is_featured', 0)
                      ->orWhereNull('is_featured'); 
            });
        } elseif ($request->has('status') && $request->status === '1') {
            $query->where('is_featured', 1); 
        } else {
            
        }
        
        $testi_list =  $query->latest()->get();

        $counter = 1;
        $testi_list->transform(function ($item) use (&$counter) {
            $item['ser_id'] = $counter++;
            if (isset($item['updated_at']) && $item['updated_at'] != '') {
                $dateTime = new DateTime($item['updated_at']);
                $formattedDate = $dateTime->format('d-m-Y | h:iA');
                $item['date'] = $formattedDate; 
            }else{
                $item['date'] = "-";
            }
            $item['action'] = '<a href="javascript:;" style="color: #e0b667;" class="view_comment first-button" data-id="' . $item['id'] . '" title="Click Here To View Comment"><img src="'.asset('images/dashbord/Eye image.png').'" class="image-fuild" alt="user-img"></a> </a><a href="' . route('testimonials.edit', $item['id']) . '" data-href="" data-title="testrete" data-original-title="Edit Tags" class="tags_edit table-btn table-btn1 edit " title="Click Here To Edit Testimonial"><img src="'.asset('images/dashbord/create.png').'" class="image-fuild" alt="user-img"></a>  <a href="javascript:;" data-href="' . route('testimonials.delete', $item['id']) . '" data-title="testrete" data-original-title="Delete Tags" class="tags_delete table-btn table-btn1 delete" title="Click Here To Delete Testimonial"><img src="'.asset('images/dashbord/delete.png').'" class="image-fuild" alt="user-img"></a>';

             if ($item['is_featured'] == '1') {
                $item['is_featured'] = '<input type="checkbox" class="is_featured_class" data-id="' . $item['id'] . '"  id="is_featured" name="is_featured" checked>';
            } else {
                $item['is_featured'] = '<input type="checkbox" class="is_featured_class" data-id="' . $item['id'] . '" id="is_featured" name="is_featured">';
            }

            if (isset($item['rating']) && $item['rating'] != '') {
                 $rating = max(min($item['rating'], 5), 0);
                $integerPart = floor($rating);
                $decimalPart = $rating - $integerPart;
                $reting = '';
                for ($i = 1; $i <= $integerPart; $i++) {
                    $reting .= '<i class="fa fa-star" style="color: #E4B513; font-size: 20px; margin-right: 5px;"></i>';
                }
                if ($decimalPart > 0) {
                    $reting .= '<i class="fa fa-star-half-o" style="color: #E4B513; font-size: 20px; margin-right: 5px;"></i>';
                    $integerPart++; 
                }
                for ($i = $integerPart + 1; $i <= 5; $i++) {
                     $reting .= '<i class="fa fa-star-o" style="color: #E4B513; font-size: 20px; margin-right: 5px;"></i>';
                }
                $item['rating'] = $reting;
            }
            return $item;

        });

        return response()->json(['data' => $testi_list]);
    }

    public function get_comment(Request $request)
    {
        $comment = Testimonial::select('sub_content', 'name')->where('id', $request->id)->first();
        
        if (!$comment) {
            return response()->json(['error' => 'Comment not found for the provided ID'], 404);
        }
        
        $response = [];
        
        if(isset($comment->sub_content) && $comment->sub_content != '' && $comment->sub_content != null)
        {
            $response['sub_content'] = $comment->sub_content;
        } else {
            $response['sub_content'] = 'No Comment Added';
        }
    
        if(isset($comment->name) && $comment->name != '' && $comment->name != null)
        {
            $response['name'] = $comment->name;
        } else {
            $response['name'] = 'No Name Added';
        }
    
        return response()->json(['comment' => $response]);
    }
    
         
}
