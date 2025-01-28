<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Maatwebsite\Excel\Facades\Excel;
use Redirect;
use Illuminate\Support\Str;
use App\Models\PromoCode;
use App\Models\Category;
use App\Models\Product;
use App\Models\VariantProduct;
use App\Models\Order;
use App\Imports\dataimport; 

class PromoCodeController extends Controller
{
    public function index()
    {
        return view('promo_code.index');
    }
    public function add()
    {
        $categories = Category::all();
        return view('promo_code.add',compact('categories'));
    }
    public function dashboard()
    {
        return view('promo_code.dashboard');
    }
    public function save(Request $request)
    {
        // dd($request->all());
        if(isset($request->promocode_id) && $request->promocode_id != null && $request->promocode_id != '')
        {
            $promocode = PromoCode::findOrfail($request->promocode_id);
        }else{
            $promocode = new PromoCode();
        }
        $promocode->title = isset($request->title) ? $request->title : null;
        $promocode->code = isset($request->code) ? $request->code : null;
        $promocode->description = isset($request->description) ? $request->description : null;
        $promocode->startDate = isset($request->start_date) ? $request->start_date : null;
        $promocode->endDate = isset($request->end_date) ? $request->end_date : null;
        $promocode->status = isset($request->status) ? $request->status : null;
        $promocode->single_time_use = isset($request->single_time_use) ? $request->single_time_use : null;
        $promocode->discounted_product = isset($request->discount_on_dis_product) ? $request->discount_on_dis_product : null;
        $promocode->discount_type = isset($request->type) ? $request->type : null;
        $promocode->discount = isset($request->discount) ? $request->discount : null;
        $promocode->minimum_cart_amount = isset($request->min_cart_amount) ? $request->min_cart_amount : null;
        $promocode->max_discount_amount = isset($request->max_discount_amount) ? $request->max_discount_amount : null;
        $promocode->one_time_use = isset($request->one_time_use) ? $request->one_time_use : null;
        if(isset($request->one_time_use) && $request->one_time_use != null && $request->one_time_use == 'yes')
        {
            $promocode->publish_status = 'no';
        }else{
            $promocode->publish_status = isset($request->public) ? $request->public : null;
        }
        if(isset($request->include_category) && $request->include_category != null && count($request->include_category) > 0)
        {
            if(in_array('all',$request->include_category))
            {
                $included_cats = 'all';
            }else{
                $included_cats = implode(',',$request->include_category);
            }
        }
        if(isset($request->exclude_category) && $request->exclude_category != null && count($request->exclude_category) > 0)
        {
            if(in_array('all',$request->exclude_category))
            {
                $excluded_cats = 'all';
            }else{
                $excluded_cats = implode(',',$request->exclude_category);
            }
        }
        $promocode->included_category = isset($included_cats) ? $included_cats : 'all';
        $promocode->included_products = isset($request->all_included_products) ? $request->all_included_products : null;
        $promocode->excluded_category = isset($excluded_cats) ? $excluded_cats : null;
        $promocode->excluded_products = isset($request->all_excluded_products) ? $request->all_excluded_products : null;
        $promocode->save();
        return redirect()->route('promo_code.index')->with('success','Promocode Saved Successfully.');
    }

    public function list(Request $request)
    {
        // dd($request->all());
        $perPage = $request->input('length', 10);
        $page = $request->input('start', 0) / $perPage;
        $query = PromoCode::select('*');
        if(isset($request->search_text) && $request->search_text != '')
        {
            $searchText = $request->search_text;
            $query->where(function($query) use ($searchText) {
                $query->where('title', 'like', '%'.$searchText.'%')
                    ->orWhere('code', 'like', '%'.$searchText.'%');
            });
        }
        if ($request->discount_type != "2") {
            $query->where('discount_type',$request->discount_type);  
        }
        if ($request->status != "2") {
            $query->where('status',$request->status);  
        }
        if ($request->public_status != "2") {
            $query->where('publish_status',$request->public_status);  
        }
        if (!empty($request->from_date) && !empty($request->to_date)) {
            $query->where(function ($query) use ($request) {
                $query->where('startDate', '<=', $request->to_date)
                      ->where('endDate', '>=', $request->from_date);
            });
        } elseif (!empty($request->from_date)) {
            $query->where('endDate', '>=', $request->from_date);
        } elseif (!empty($request->to_date)) {
            $query->where('startDate', '<=', $request->to_date);
        }
        $totalRecords = $query->count();
        $promocodes = $query->latest()->skip($page * $perPage)->take($perPage)->get();

        $counter = 1;
        $promocodes->transform(function ($item) use (&$counter) {

            $item['ser_id'] = $counter++;
            
            $item['action'] = '<div class="action_div"><a href="' . route('promo_code.edit', ['id' => $item['id']]) . '" class="table-btn table-btn1 mx-2 edit" data-id="' . $item['id'] . '" title="Click here to Edit Product" ><img src="'.asset('images/dashbord/create.png').'" class="image-fuild" alt="user-img"></a>';
            
            $item['action'] .= '<a href="javascript:;" data-href="' . route('promo_code.delete', ['id' => $item['id']]) . '" class="table-btn table-btn1 delete"><img src="'.asset('images/dashbord/delete.png').'" title="Click here to Delete Product" class="image-fuild" alt="user-img"></a></div>';

            if ($item['status'] == 'active') {
                $item['p_status'] = '<input type="checkbox" class="is_featured_class" data-id="' . $item['id'] . '" data-type="status" name="status" checked>';
            } else {
                $item['p_status'] = '<input type="checkbox" class="is_featured_class" data-id="' . $item['id'] . '" data-type="status" name="status">';
            }
            if(isset($item['no_of_use']) && $item['no_of_use'] != null && $item['no_of_use'] > 0)
            {
                $item['no_of_use_d'] = '<a href="'.route('promo_code.used',['code' => $item['code']]).'">'.$item['no_of_use'].'</a>';
            }else{
                $item['no_of_use_d'] = 0;
            }
            // $item['no_of_use_d'] = isset($item['no_of_use']) ? $item['no_of_use'] : '0';
            
            if ($item['publish_status'] == 'yes') {
                $item['p_publish_status'] = '<input type="checkbox" class="is_featured_class" data-id="' . $item['id'] . '"  data-type="publish_status" name="is_featured" checked>';
            } else {
                $item['p_publish_status'] = '<input type="checkbox" class="is_featured_class" data-id="' . $item['id'] . '" data-type="publish_status" name="is_featured">';
            }
            if ($item['discount_type'] == 'amount') {
                $item['t_discount'] = 'Amount';
            } else {
                $item['t_discount'] = 'Percentage';
            }
            return $item;
        });

        return response()->json([
            'draw' => $request->input('draw'),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords, // For simplicity, assuming no filtering is applied
            'data' => $promocodes,
        ]);
    }

    public function check_featured(Request $request)
    {
        // dd($request->all());
        $id = $request->id;

        if (isset($request->isChecked) && $request->isChecked != 'true') {
            if(isset($request->type) && $request->type != null && $request->type =='publish_status')
            {
                $data['publish_status'] = 'no';
                $response['message'] = "Publish Status Disable Successfully.";
            }else{
                $data['status'] = 'inactive';
                $response['message'] = "Status InActive Successfully.";
            }
            
            $save = PromoCode::where('id', $id)->update($data);
            $response['status'] = 1;
            
        } else {
            if(isset($request->type) && $request->type != null && $request->type =='publish_status')
            {
                $data['publish_status'] = 'yes';
                $response['message'] = "Publish Status Enable Successfully.";
            }else{
                $data['status'] = 'active';
                $response['message'] = "Status Active Successfully.";
            }
            $promo_code = PromoCode::where('id', $id)->first();
            if(isset($promo_code->one_time_use) && $promo_code->one_time_use != null && $promo_code->one_time_use == 'yes' && $request->type =='publish_status')
            {
                $response['status'] = 0;
                $response['message'] = "This promo code is intended for one-time use only, so it cannot be made public.";
            }else{
                $save = PromoCode::where('id', $id)->update($data);
                $response['status'] = 2;
            }
            
        }
        return response()->json($response);
    }

    public function delete($id)
    {
        if ($id != "") {
            $record = PromoCode::find($id);
            $record->delete();
            return redirect()->route('promo_code.index')->with('success','Promo Code Delete Successfully.');
        }else{
            return redirect()->route('promo_code.index')->with('error','Something Went Wrong!');
        }
    }

    public function edit($id)
    {
        $promocode = PromoCode::findOrFail($id);
        $categories = Category::all();
        $exploded_i_cats = explode(',',$promocode->included_category);
        $exploded_e_cats = explode(',',$promocode->excluded_category);
        $exploded_i_products = explode(',',$promocode->included_products);
        $exploded_e_products = explode(',',$promocode->excluded_products);
        return view('promo_code.add', compact('promocode','categories','exploded_i_cats','exploded_e_cats','exploded_i_products','exploded_e_products'));
    }
    public function check_existing(Request $request)
    {
        if(isset($request->code) && $request->code != null && $request->code != '')
        {
            $promocode = PromoCode::where('code',$request->code)->first();
            if(isset($promocode) && $promocode != null && $promocode != '')
            {
                return response()->json(['status' => 1, 'message' => 'This Promo code is already taken.']);
            }else{
                return response()->json(['status' => 0]);
            }  
        }
    }
    public function file_store(Request $request)
    {
        $rules = [
            'file' => 'required|file|mimes:xlsx,xls'
        ];
        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->with('error','Invalid File!');
        }
        $file = $request->file('file');
        try {
            $data = Excel::toArray([], $file);
            $rows = $data[0];
            $invalid = false;
            foreach ($rows as $index => $row) {
                if ($index === 0) {
                    continue;
                }
                $code = $row[0];
                $f_start_date = $row[6];
                $f_dateTime = \DateTime::createFromFormat('d-m-Y', $f_start_date);
                $f_formattedDate = $f_dateTime ? $f_dateTime->format('m/d/Y') : null;

                // Process end date
                $f_end_date = $row[7];
                $f_enddateTime = \DateTime::createFromFormat('d-m-Y', $f_end_date);
                $f_end_formattedDate = $f_enddateTime ? $f_enddateTime->format('m/d/Y') : null;

                if (preg_match('/^[A-Z0-9\W]{8}$/', $code)) {
                    if(isset($code) && $code != null) {
                        $promocode = PromoCode::where('code', $code)->first();
                    }
                    if (!$promocode) {
                        $promocode = new PromoCode();
                    }
                    // Populate the PromoCode object
                    $promocode->title = isset($row[1]) ? $row[1] : null;
                    $promocode->code = isset($code) ? $code : null;
                    $promocode->description = isset($row[8]) ? $row[8] : null;
                    $promocode->startDate = isset($f_formattedDate) ? $f_formattedDate : null;
                    $promocode->endDate = isset($f_end_formattedDate) ? $f_end_formattedDate : null;
                    $promocode->status = isset($row[9]) && $row[9] == 'Active' ? 'active' : 'inactive';
                    $promocode->single_time_use = isset($row[11]) && $row[11] == 'Yes' ? 'yes' : 'no';
                    $promocode->publish_status = isset($row[12]) && $row[12] == 'Yes' ? 'yes' : 'no';
                    $promocode->discounted_product = isset($row[10]) && $row[10] == 'Yes' ? 'yes' : 'no';
                    $promocode->discount_type = isset($row[3]) && $row[3] == 'Amount' ? 'amount' : 'percentage';
                    $promocode->discount = isset($row[4]) ? $row[4] : null;
                    if(isset($row[3]) && $row[3] == 'Percentage')
                    {
                        $promocode->max_discount_amount = isset($row[5]) ? $row[5] : null;
                    }
                    $promocode->minimum_cart_amount = isset($row[2]) ? $row[2] : null;
                    if(isset($row[13]) && $row[13] != null && $row[13] != '')
                    {
                        $i_cat_string = '';
                        $i_cats = explode(',',$row[13]);
                        $i_cats = array_map('trim', $i_cats);
                        if(in_array("All", $i_cats))
                        {
                            $i_cat_string = 'all';
                        }else{
                            $i_db_cats = Category::whereIn('category',$i_cats)->pluck('id')->toArray();
                            if(isset($i_db_cats) && count($i_db_cats) > 0)
                            {
                                $i_cat_string = implode(',',$i_db_cats);
                            }
                        }
                    }
                    if(isset($row[14]) && $row[14] != null && $row[14] != '')
                    {
                        $i_pro_string = $row[14];
                    }
                    if(isset($row[15]) && $row[15] != null && $row[15] != '')
                    {
                        $e_cat_string = '';
                        $e_cats = explode(',',$row[13]);
                        $e_cats = array_map('trim', $e_cats);
                        if(in_array("All", $e_cats))
                        {
                            $e_cat_string = 'all';
                        }else{
                            $e_db_cats = Category::whereIn('category',$e_cats)->pluck('id')->toArray();
                            if(isset($e_db_cats) && count($e_db_cats) > 0)
                            {
                                $e_cat_string = implode(',',$e_db_cats);
                            }
                        }
                    }
                    if(isset($row[16]) && $row[16] != null && $row[16] != '')
                    {
                        $e_pro_string = $row[16];
                    }
                    $promocode->included_category = isset($i_cat_string) ? $i_cat_string : null;
                    $promocode->included_products = isset($i_pro_string) ? $i_pro_string : null;
                    $promocode->excluded_category = isset($e_cat_string) ? $e_cat_string : null;
                    $promocode->excluded_products = isset($e_pro_string) ? $e_pro_string : null;    
                    $promocode->save();
                    
                } else {
                    $invalid = true;
                    $invalidCodes[] = $code;
                }
            }
            if(isset($invalidCodes) && count($invalidCodes) > 0)
            {
                $invalid_codes = implode(', ',$invalidCodes);
                $invalid_string = 'Invalid Promo Codes '.$invalid_codes.'';
            }else{
                $invalid_string = '';
            }
            return response()->json(['status' => 1, 'invalid' => $invalid_string ,'message' => 'Promo Code Saved Successfully.']);
        } catch (\Exception $e) {
            return response()->json(['status' => 0]);
        }
    }
    public function search_product(Request $request)
    {
        // dd($request->all());
        if(isset($request->sku) && $request->sku != null && $request->sku != '')
        {
            $products = Product::where('p_sku', 'like', '%'.$request->sku.'%')->orwhere('p_title', 'like', '%'.$request->sku.'%')->get();
            $variants = VariantProduct::where('p_sku', 'like', '%'.$request->sku.'%')->orwhere('p_title', 'like', '%'.$request->sku.'%')->get();
            $mergedResults = $products->merge($variants);
            if(isset($mergedResults) && count($mergedResults) > 0)
            {
                return response()->json(['status' => 1, 'data' => $mergedResults]);
            }else{
                return response()->json(['status' => 2]);
            }
        }else{
            return response()->json(['status' => 0]);
        }
    }
    public function used_promocode($code)
    {
        $promo_code = PromoCode::where('code',$code)->first();
        return view('promo_code.used',compact('promo_code'));
    }
    public function used_promocode_list(Request $request)
    {
        $perPage = $request->input('length', 10);
        $page = $request->input('start', 0) / $perPage;
        $query = Order::select('orders.*')->where('promo_code_id',$request->promo_id)->join('users', 'orders.user_id', '=', 'users.id');
        if(isset($request->search_text) && $request->search_text != '' && $request->search_text != null)
        {
            $searchText = $request->input('search_text');
            $query->where(function ($q) use ($searchText) {
                $q->where('users.name', 'like', "%{$searchText}%")
                ->orWhere('users.email', 'like', "%{$searchText}%");
            });
        }
        if ((isset($request->from_date) && $request->from_date != '' && $request->from_date != null) && (isset($request->to_date) && $request->to_date != '' && $request->to_date != null)) {
            $fromDate = Carbon::createFromFormat('m/d/Y', $request->from_date)->startOfDay()->format('Y-m-d H:i:s');
            $endDate = Carbon::createFromFormat('m/d/Y', $request->to_date)->endOfDay()->format('Y-m-d H:i:s');
            $query->whereBetween('orders.updated_at', [$fromDate, $endDate]);
        }
        $totalRecords = $query->count();
        $orders = $query->latest()->skip($page * $perPage)->take($perPage)->get();

        $counter = 1;
        $orders->transform(function ($item) use (&$counter) {
            $total_price = 0;
            if(isset($item->order_items) && $item->order_items->count() > 0)
            {
                foreach($item->order_items as $o_item)
                {
                    $total_price += $o_item->total_price;
                }
            }
            $item['ser_id'] = $counter++;
            $item['user_name'] = isset($item->get_order_user[0]->name) ? $item->get_order_user[0]->name : '';
            
            $item['user_email'] = isset($item->get_order_user[0]->email) ? $item->get_order_user[0]->email : '';

            $item['used_date'] = isset($item->updated_at) ? date('d-m-Y | h:iA', strtotime($item->updated_at)) : '';

            $item['order_price'] = isset($total_price) ? number_format($total_price,2) : '';

            $item['order_discount'] = isset($item->promo_code_discount) ? number_format($item->promo_code_discount,2) : '';

            $item['action'] = '<div class="action_div"><a href="' . route('orders.details', $item['id']) . '" title="Click here to View Order" class=" table-btn table-btn1 mx-2" data-id="' . $item['id'] . '"><img src="'.asset('images/dashbord/Eye image.png').'" class="image-fuild" alt="user-img"></a></div>';
            
            return $item;
        });
        return response()->json([
            'draw' => $request->input('draw'),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords, // For simplicity, assuming no filtering is applied
            'data' => $orders,
        ]);
    }
    public function download_categories(Request $request)
    {
        $data_ar = [];

        $categories = Category::all();
        if (isset($categories) && $categories != '' && count($categories) > 0) {

            foreach ($categories as $key => $val) {
                $data_ar[$key]['Category'] = isset($val->category) && $val->category != '' ? $val->category : '-';
            }
        }else{
                $data_ar = 'blank';
        }
        echo json_encode($data_ar);
        die;
    }
}