<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DateTime;
use App\Models\User;
use App\Models\Order;
use App\Models\Cart;
use App\Models\WishList;
use App\Models\OrderItems;
use App\Models\ProductImage;
use App\Models\VariantProduct;
use App\Models\Product;
use App\Models\RegistrationFormSetting;
use App\Models\Country;
use App\Models\UserAddress;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use App\Mail\ApprovalMail;
use Illuminate\Support\Facades\Mail;
use App\Events\AccessChanged;
use App\Events\ProductAccessChanged;

class CustomersController extends Controller
{
    public function customers_index()
    {
        $setting = Setting::first();
        $limited_access = $setting->access_limited_access;
        return view('customers.index',compact('limited_access'));
    }
    public function list(Request $request)
    {
        $perPage = $request->input('length', 10);
        $page = $request->input('start', 0) / $perPage;
        $query = User::select('users.name', 'users.id', 'users.updated_at','users.created_at', 'users.status', 'users.email', 'users.phone', 'users.country_code_number','users.approval','users.product_access')->where('role','customer');
        $totalRecords = $query->count();
        if (isset($request->pro_status) && count($request->pro_status) > 0) {
            $pro_status_count = count($request->pro_status);
            if ($pro_status_count == 1) {

                foreach ($request->pro_status as $key => $value) {
                    if ($value == 'Order') {
                        $query->join('orders', 'orders.user_id', '=', 'users.id');
                    } elseif ($value == 'Cart') {
                        $query->join('carts', 'carts.user_id', '=', 'users.id');
                    }elseif ($value == 'Wish List') {
                        $query->join('wish_lists', 'wish_lists.user_id', '=', 'users.id');
                    }
                }
            }elseif ($pro_status_count == 2) {
                $string = implode(",", $request->pro_status);
                if ($string == "Order,Cart" || $string == "Cart,Order") {
                    $query->join('orders', 'orders.user_id', '=', 'users.id')
                            ->join('carts', 'carts.user_id', '=', 'users.id')
                            ->leftJoin('wish_lists', function ($join) {
                                $join->on('users.id', '=', 'wish_lists.user_id')
                                    ->whereRaw('wish_lists.user_id = orders.user_id');
                });
                }elseif ($string == "Order,Wish List" || $string == "Wish List,Order") {
                    $query->join('orders', 'orders.user_id', '=', 'users.id')
                            ->join('wish_lists', 'wish_lists.user_id', '=', 'users.id')
                            ->leftJoin('carts', function ($join) {
                                $join->on('users.id', '=', 'carts.user_id')
                                    ->whereRaw('carts.user_id = wish_lists.user_id');
                    });
                }elseif ($string == "Cart,Wish List" || $string == "Wish List,Cart") {
                    $query->join('carts', 'carts.user_id', '=', 'users.id')
                            ->join('wish_lists', 'wish_lists.user_id', '=', 'users.id')
                            ->leftJoin('orders', function ($join) {
                                $join->on('users.id', '=', 'orders.user_id')
                                    ->whereRaw('orders.user_id = wish_lists.user_id');
                    });
                }
            }elseif ($pro_status_count == 3) {
                $query->join('orders', 'orders.user_id', '=', 'users.id');
                $query->join('carts', 'carts.user_id', '=', 'users.id');
                $query->join('wish_lists', 'wish_lists.user_id', '=', 'users.id');
            }
        }
        if ($request->search_text != "") {
            $query->where('users.name', 'LIKE', '%' . $request->search_text . '%');
        }
        if ($request->from_date != "") {
            $from_date = Carbon::createFromFormat('m/d/Y', $request->from_date)->startOfDay();
            $query->where('users.updated_at', '>=',$from_date);
        }
        if ($request->to_date != "") {
            $to_date = Carbon::createFromFormat('m/d/Y', $request->to_date)->endOfDay();
            $query->where('users.updated_at', '<=', $to_date);
        }
        $customers =  $query->latest()->distinct('users.id')->skip($page * $perPage)->take($perPage)->get();
        // $customers = $query->latest()->skip($page * $perPage)->take($perPage)->get();
        $counter = 1;
        $customers->transform(function ($item) use (&$counter) {
        
        $item['ser_id_num'] = $counter++;

        $item['ser_id'] = '<div class="custom-control custom-checkbox">
        <input type="checkbox" class="pinned_chekbox" id="is_featured" val="'.$item['id'].'" name="customers_list_download[]" data-id="' . $item['id'] . '"';

        if ($item['pinned'] == 1) {
            $item['ser_id'] .= ' checked';
        }

        $item['ser_id'] .= '></div>';

        $orders = Order::where('user_id', $item['id'] )->first();
        $carts = Cart::where('user_id', $item['id'] )->first();
        $wishLists = WishList::where('user_id', $item['id'] )->first();

        $item['pro_status'] = "";

        if (isset($orders) && $orders->id != "") {
            $item['pro_status'] = '<a href="' . route('customers.product_list', $item['id']) . '?status=orders" class="customer_product table-btn table-btn1 mx-2 edit" data-id="' . $item['id'] . '">Order</a>';
            if ((isset($carts) && $carts->id != "") || (isset($wishLists) && $wishLists->id != "")) {
                $item['pro_status'] .= "|";
            }

        }
        if (isset($carts) && $carts->id != "") {
            $item['pro_status'] .= '<a href="' . route('customers.product_list', $item['id']) . '?status=cart" class="customer_product table-btn table-btn1 mx-2 edit" data-id="' . $item['id'] . '">Cart</a>';
            if (isset($wishLists) && $wishLists->id != "") {
                $item['pro_status'] .= "|";
            }
        }
        if (isset($wishLists) && $wishLists->id != "") {
            $item['pro_status'] .= '<a href="' . route('customers.product_list', $item['id']) . '?status=wish-list" class="customer_product table-btn table-btn1 mx-2 edit" data-id="' . $item['id'] . '">Wish List</a>';
        }
        if ($item['pro_status'] === "") {
            $item['pro_status'] = "-";
        }
        if (isset($item['phone']) && $item['phone'] != '') {
            $item['mo_num'] = (isset($item['country_code_number']) ? $item['country_code_number'] : '+91') .' '. $item['phone'];
        }else{
            $item['mo_num'] = '-';
        }
        if (isset($item['updated_at']) && $item['updated_at'] != '') {
            $dateTime = new DateTime($item['updated_at']);
            $formattedDate = $dateTime->format('d-m-Y | h:iA');
            $item['date'] = $formattedDate; 
        }else{
            $item['date'] = "-";
        }
        if(isset($item['approval']) && $item['approval'] != null && $item['approval'] == 1)
        {
           $item['a_status'] = '<div class="action_div">
                                    <span class="p_status" style="background: green;">Approved</span>
                                    <a href="javascript:;" class="table-btn table-btn1 mx-2 chage_user_status" data-type="reject" data-id="'.$item['id'].'">
                                        <img src="'.asset('images/dashbord/remove.png').'" title="Click here to Reject User" class="image-fuild" alt="user-img" style="width: auto !important;">
                                    </a>
                                    <a href="javascript:;" class="table-btn table-btn1 edit_access" data-type="site_access" data-id="'.$item['id'].'">
                                        <img src="'.asset('images/dashbord/editaccess.svg').'" title="Click here to Edit User Site Access" class="image-fuild" alt="user-img" style="width: auto !important;">
                                    </a>
                                </div>';
        }else if(isset($item['approval']) && $item['approval'] != null && $item['approval'] == 2){
           $item['a_status'] = '<div class="action_div">
                                    <span class="p_status" style="background: red;">Rejected</span>
                                    <a href="javascript:;" class="table-btn table-btn1 mx-2 chage_user_status" data-type="approve" data-id="'.$item['id'].'">
                                        <img src="'.asset('images/dashbord/approve.png').'" title="Click here to Approve User" class="image-fuild" alt="user-img" style="width: auto !important;">
                                    </a>
                                </div>';
        }else{
            $item['a_status'] = '<div class="action_div">
                                    <span class="p_status" style="background: #ff6000;">Pending</span>
                                    <a href="javascript:;" class="table-btn table-btn1 mx-2 chage_user_status" data-type="approve" data-id="'.$item['id'].'">
                                        <img src="'.asset('images/dashbord/approve.png').'" title="Click here to Approve User" class="image-fuild" alt="user-img" style="width: auto !important;">
                                    </a>
                                    <a href="javascript:;" class="table-btn table-btn1 chage_user_status" data-type="reject" data-id="'.$item['id'].'">
                                        <img src="'.asset('images/dashbord/remove.png').'" title="Click here to Reject User" class="image-fuild" alt="user-img" style="width: auto !important;">
                                    </a>
                                </div>';
        }
        if(isset($item['product_access']) && $item['product_access'] != null && $item['product_access'] == 0)
        {
            $item['access_status'] = 'Unlimited <a href="javascript:;" class="edit_access" data-type="product_access" data-id="'.$item['id'].'">Edit Access</a>';
        }else if(isset($item['product_access']) && $item['product_access'] != null && $item['product_access'] == 1){
            $item['access_status'] = 'Limited <a href="javascript:;" class="edit_access" data-type="product_access" data-id="'.$item['id'].'">Edit Access</a>';
        }else{
            $item['access_status'] = '<a href="javascript:;" class="edit_access" data-type="product_access" data-id="'.$item['id'].'">Edit Access</a>';
        }
        $item['action'] = '<div class="action_div"><a href="' . route('customers.view', $item['id']) . '" class=" table-btn table-btn1 mx-2 edit" data-id="' . $item['id'] . '" title="Click Here To View Customer" ><img src="'.asset('images/dashbord/Eye image.png').'" class="image-fuild" alt="user-img"></a><a href="' . route('customers.edit', $item['id']) . '" class=" table-btn table-btn1 mx-2 edit" data-id="' . $item['id'] . '" title="Click Here To Edit Customer" ><img src="'.asset('images/dashbord/create.png').'" class="image-fuild" alt="user-img"></a></div>';

        return $item;
    });

    return response()->json([
        'draw' => $request->input('draw'),
        'recordsTotal' => $totalRecords,
        'recordsFiltered' => $totalRecords,
        'data' => $customers,
    ]);
    }

    public function view($id)
    {
        $user = User::where('id',$id)->first();
        $orders = Order::where('user_id',$user->id)->get();
        return view('customers.view',compact('user','orders'));
    }
    public function edit($id)
    {
        $users = User::findOrfail($id);
        $userAddress = UserAddress::where('user_id',$users->id)->first();
        $countries = Country::all();
        $data['business_name'] = RegistrationFormSetting::where('title','Business Name')->first();
        $data['full_name'] = RegistrationFormSetting::where('title','Full Name')->first();
        $data['email'] = RegistrationFormSetting::where('title','Email')->first();
        $data['mobile'] = RegistrationFormSetting::where('title','Mobile Number + country code')->first();
        $data['password'] = RegistrationFormSetting::where('title','Password + Confirm Password')->first();
        $data['address_1'] = RegistrationFormSetting::where('title','Address Line 1')->first();
        $data['address_2'] = RegistrationFormSetting::where('title','Address Line 2')->first();
        $data['country_state_city'] = RegistrationFormSetting::where('title','Country + State + City')->first();
        $data['country'] = RegistrationFormSetting::where('title','Country')->first();
        $data['business_card'] = RegistrationFormSetting::where('title','Business Card Image')->first();
        $data['gat_number'] = RegistrationFormSetting::where('title','GST Number')->first();
        $data['website'] = RegistrationFormSetting::where('title','Website')->first();
        $data['social_1'] = RegistrationFormSetting::where('title','Social 1')->first();
        $data['social_2'] = RegistrationFormSetting::where('title','Social 2')->first();
        return view('customers.add', compact('users','countries','data','userAddress'));
    }
    public function add()
    {
        $countries = Country::all();
        $data['business_name'] = RegistrationFormSetting::where('title','Business Name')->first();
        $data['full_name'] = RegistrationFormSetting::where('title','Full Name')->first();
        $data['email'] = RegistrationFormSetting::where('title','Email')->first();
        $data['mobile'] = RegistrationFormSetting::where('title','Mobile Number + country code')->first();
        $data['password'] = RegistrationFormSetting::where('title','Password + Confirm Password')->first();
        $data['address_1'] = RegistrationFormSetting::where('title','Address Line 1')->first();
        $data['address_2'] = RegistrationFormSetting::where('title','Address Line 2')->first();
        $data['country_state_city'] = RegistrationFormSetting::where('title','Country + State + City')->first();
        $data['country'] = RegistrationFormSetting::where('title','Country')->first();
        $data['business_card'] = RegistrationFormSetting::where('title','Business Card Image')->first();
        $data['gat_number'] = RegistrationFormSetting::where('title','GST Number')->first();
        $data['website'] = RegistrationFormSetting::where('title','Website')->first();
        $data['social_1'] = RegistrationFormSetting::where('title','Social 1')->first();
        $data['social_2'] = RegistrationFormSetting::where('title','Social 2')->first();

        return view('customers.add',compact('countries','data'));
    }
    public function save(Request $request)
    {
        // dd($request->all());
        if ($request->hasFile('image')) {
            $current = Carbon::now()->format('YmdHs');
            $uploadpdf = $request->file('image');
            $image = $current . $uploadpdf->getClientOriginalName();
            $uploadpdf->move('uploads/users/', $image);
            $imageName = $image;
        }else{

            $imageName = $request->old_img;
        }
        if ($request->hasFile('business_card')) {
            $current = Carbon::now()->format('YmdHs');
            $uploadpdf1 = $request->file('business_card');
            $image1 = $current . $uploadpdf1->getClientOriginalName();
            $uploadpdf1->move('uploads/users/', $image1);
            $imageName1 = $image1;
        }else{

            $imageName1 = $request->b_old_img;
        }
        $setting = Setting::first();
        if(isset($request->customers_id) && $request->customers_id != null && $request->customers_id != '')
        {
            $updates = User::findOrfail($request->customers_id);
        }else{
            $check_exist = User::check_user_login($request->mail_id,$request->phone);
            if(isset($check_exist) && count($check_exist) > 0)
            {
                foreach($check_exist as $check)
                {
                    if(isset($check) && $check->deleted_at != '' && $check->deleted_at != null)
                    {
                        $check->forceDelete();
                    }
                }
            }
            if(isset($check_exist) && count($check_exist) == 0){
                $updates = new User();
                $updates->role = 'customer';
                if(isset($setting->approval_for_login) && $setting->approval_for_login == 0)
                {
                    $updates->site_access = 0;
                    $updates->approval = 1;
                }
            }else{
                return redirect()->back()->with('error', 'User Already Exists!');
            }
        }
        if (isset($request->country_number) && $request->country_number != '') {
            if (strpos($request->country_number, '+') !== 0) {
                $country_number = '+'. $request->country_number;
            } else {
                $country_number = $request->country_number;
            }
        }
        $updates->image = isset($imageName) ? $imageName : null;
        $updates->name = isset($request->name) ? $request->name : null;
        $updates->phone = isset($request->phone) ? $request->phone : null;
        $updates->country_code = isset($request->country_code) ? $request->country_code : null;
        $updates->country_code_number = isset($country_number) ? $country_number : null;
        $updates->email = isset($request->mail_id) ? $request->mail_id : null;
        $updates->business_name = isset($request->business_name) ? $request->business_name : null;
        $updates->business_card = isset($imageName1) ? $imageName1 : null;
        $updates->website = isset($request->website) ? $request->website : null;
        $updates->product_access = isset($request->product_access) ? $request->product_access : null;
        $updates->start_date = isset($request->start_date) ? $request->start_date : null;
        $updates->end_date = isset($request->end_date) ? $request->end_date : null;
        $updates->start_time = isset($request->start_time) ? $request->start_time : null;
        $updates->end_time = isset($request->end_time) ? $request->end_time : null;
        if (isset($request->con_password) && $request->con_password != '' && $request->con_password != null && $request->con_password == $request->new_password) {
            $updates->password = Hash::make($request->con_password);
        }

        // $updates->status = isset($request->is_featured) && $request->is_featured == 'on' ? 1 : 0;
        $updates->save();
        $userAddress = UserAddress::where('user_id',$updates->id)->first();
        if(!$userAddress)
        {
            $userAddress = new UserAddress();
        }
        $userAddress->user_id = $updates->id;
        $userAddress->address = isset($request->address_1) ? $request->address_1 : null;
        $userAddress->address2 = isset($request->address_2) ? $request->address_2 : null;
        $userAddress->country = isset($request->country) ? $request->country : null;
        $userAddress->state = isset($request->state) ? $request->state : null;
        $userAddress->city = isset($request->city) ? $request->city : null;
        $userAddress->gst_number = isset($request->gst_no) ? $request->gst_no : null;
        $userAddress->social_1 = isset($request->social_1) ? $request->social_1 : null;
        $userAddress->social_2 = isset($request->social_2) ? $request->social_2 : null;
        $userAddress->email = isset($request->mail_id) ? $request->mail_id : null;
        $userAddress->fullname = isset($request->name) ? $request->name : null;
        $userAddress->save();
        return redirect()->route('customers.index')->with('success', 'Customer Saved Successfully!');
    }

    public function product_list($id)
    {
        $pro_status = $_GET['status'];
        $users = User::where('id', $id )->first();
        return view('customers.product_list', compact('users','pro_status'));
    }

    public function product_details_list(Request $request)
    {

        $product_status = $request->product_status;
        $customer_id = $request->customer_id;
        $product_list = [];
        if (isset($product_status) && $product_status == "orders") {
            $orders = Order::where('user_id', $customer_id)->get();
            foreach($orders as $order)
            {
                $product_list = OrderItems::where('order_id',$order->id)->get();
            }
        }

        if (isset($product_status) && $product_status == "cart") {
            $product_list = Cart::where('user_id', $customer_id)->get();
        }

        if (isset($product_status) && $product_status == "wish-list") {
            $product_list = WishList::where('user_id', $customer_id)->get();
        }
        $counter = 1;


        $product_list->transform(function ($item) use (&$counter) {
            if($item->product_type == 'simple')
            {
                $product = Product::where('id',$item->product_id)->first();
            }else{
                $product = VariantProduct::where('id',$item->product_id)->first();
            }
            $p_image = ProductImage::Where('product_id',$product->id)->where('type',$item->product_type)->first();
            if(isset($p_image) && $p_image != null && $p_image != '')
            {
                if(isset($product->db_status) && $product->db_status != null && $product->db_status != '' && $product->db_status == 'manually')
                {
                    $path = asset('product_media/product_images/'.$p_image->name);
                }else{
                    $path = asset('uploads/'.$p_image->name);
                }
            }else{
                $path = asset('assets/images/user/img-demo_1041.jpg');
            }
            $item['ser_id_num'] = $counter++;
            if(isset($item->comment) && $item->comment != null && $item->comment != '')
            {
                $item['comment'] = '<a href="javascript:;" class="view_comment" data-id="'. $item->id .'"><img src="'.asset('images/dashbord/Eye image.png').'" class="image-fuild w-auto" alt="user-img" ></a>';
            }else{
                $item['comment'] = '-';
            }
            $item['pro_name'] = isset($product->p_title) ? $product->p_title : '-';
                            // $item['pro_image'] = $product['image'];
            $item['pro_unit'] = $product['p_sku'];

                $item['pro_image'] = '<img src="' . $path . '" class="img-fluid white_logo" alt="" style="width:50px;height:50px;">';

            if (isset($product['updated_at']) && $product['updated_at'] != '') {
                $dateTime = new DateTime($product['updated_at']);
                $formattedDate = $dateTime->format('d-m-Y | h:iA');
                $item['date'] = $formattedDate; 
            }else{
                $item['date'] = "-";
            }

            return $item;
        });

        return response()->json(['data' => $product_list]);
    }

    public function product_list_search(Request $request)
    {
        $product_list = collect();
        if (isset($request->product_status)) {
            switch ($request->product_status) {
                case "orders":
                    $product_list = Order::where('user_id', $request->customer_id)->get();
                    break;
                case "cart":
                    $product_list = Cart::where('user_id', $request->customer_id)->get();
                    break;
                case "wish-list":
                    $product_list = WishList::where('user_id', $request->customer_id)->get();
                    break;
            }
        }
        $counter = 1;
        $from_date = $request->from_date ? Carbon::createFromFormat('m/d/Y', $request->from_date)->startOfDay() : null;
        $to_date = $request->to_date ? Carbon::createFromFormat('m/d/Y', $request->to_date)->endOfDay() : null;
        $product_list->transform(function ($item) use (&$counter, $request,$from_date, $to_date) {
            if ($item->product_type == 'simple') {
                $product = Product::where('id', $item->product_id)->first();
            } else {
                $product = VariantProduct::where('id', $item->product_id)->first();
            }
            if (isset($request->search_text) && $request->search_text != '') {
                $search_text = strtolower($request->search_text);
                if (
                    !str_contains(strtolower($product->p_title), $search_text) &&
                    !str_contains(strtolower($product->p_sku), $search_text)
                ) {
                    return null;
                }
            }
            if (isset($from_date) || isset($to_date)) {
                $updated_at = Carbon::parse($product->updated_at);
                if ($from_date && $updated_at->lt($from_date)) {
                    return null; 
                }
                if ($to_date && $updated_at->gt($to_date)) {
                    return null;
                }
            }
            $p_image = ProductImage::where('product_id', $product->id)
                ->where('type', $item->product_type)
                ->first();

            if (isset($p_image) && $p_image != null && $p_image != '') {
                if (isset($product->db_status) && $product->db_status == 'manually') {
                    $path = asset('product_media/product_images/' . $p_image->name);
                } else {
                    $path = asset('uploads/' . $p_image->name);
                }
            } else {
                $path = asset('assets/images/user/img-demo_1041.jpg');
            }

            // Assign the transformed properties
            $item['ser_id_num'] = $counter++;
            $item['comment'] = isset($item->comment) && $item->comment != '' ? 
                '<a href="javascript:;" class="view_comment" data-id="' . $item->id . '"><img src="' . asset('images/dashbord/Eye image.png') . '" class="image-fuild w-auto" alt="user-img" ></a>' 
                : '-';
            $item['pro_name'] = isset($product->p_title) ? $product->p_title : '-';
            $item['pro_unit'] = $product->p_sku;
            $item['pro_image'] = '<img src="' . $path . '" class="img-fluid white_logo" alt="" style="width:50px;height:50px;">';
            $item['date'] = isset($product->updated_at) && $product->updated_at != '' ? 
                (new DateTime($product->updated_at))->format('d-m-Y | h:iA') 
                : '-';

            return $item;
        });
        $filtered_list = $product_list->filter()->values();

        return response()->json(['data' => $filtered_list]);
    }

    public function is_status(Request $request)
    {
            $id = $request->id;
            $response['status'] = 0;
            $response['message'] = "Status canceled";
            

            if (isset($request->isChecked) && $request->isChecked != 'true') {
                $data['status'] = 0;
                $save = User::where('id', $id)->update($data);
                $response['status'] = 1;
                $response['message'] = "Disable Successfully";

            } else {
                $data['status'] = 1;
                $save = User::where('id', $id)->update($data);
                $response['status'] = 1;
                $response['message'] = "Enable Successfully";

            }
            return response()->json($response);
    }


    public function export(Request $request)
    {
        $data_ar = [];

        if (isset($request->selectedValues) && count($request->selectedValues) > 0) {
            $customer_id = $request->selectedValues;
            $customers = [];
            foreach ($customer_id as $key => $id) {
                if ($id != null) {
                $customers[] = User::select('*')->where('role','customer')->where('id',$id)->first();
                }
            }
        }else{
            $customers = User::select('*')->where('role','customer')->latest()->get();
        }

        if (isset($customers) && $customers != '' && count($customers) > 0) {

            foreach ($customers as $key => $val) {

                $data_ar[$key]['Sr no'] = $key + 1;
                $data_ar[$key]['Customers'] = isset($val->name) && $val->name != '' ? $val->name : '-';

                if (isset($val->phone) && $val->phone != '') {
                $data_ar[$key]['Mobile no.'] = $val->country_code_number .' '. $val->phone;
                }else{
                $data_ar[$key]['Mobile no.'] = '';
                }
                $data_ar[$key]['Mobile no.'] = isset($val->phone) && $val->phone != '' ? $val->phone : '-';
                $data_ar[$key]['Email'] = isset($val->email) && $val->email != '' ? $val->email : '-';
                if (isset($val->updated_at) && $val->updated_at != '') {
                        $dateTime = new DateTime($val->updated_at);
                        $formattedDate = $dateTime->format('d-m-Y | h:iA');
                    $data_ar[$key]['Register Date & Time'] = isset($formattedDate) && $formattedDate != '' ? $formattedDate : '-';
                }else{
                $data_ar[$key]['Register Date & Time'] = '-';
                }
            }
        }else{
                $data_ar = 'blank';
        }
        echo json_encode($data_ar);
        die;
    }

    public function view_cart_comment(Request $request)
    {
        $cart = Cart::findOrfail($request->cart_id);
        if(isset($cart) && $cart != null)
        {
            return response()->json(['status' => 1, 'comment' => $cart->comment]);
        }else{
            return response()->json(['status' => 0]);
        }
    }
    public function update_approval_status(Request $request)
    {
        // dd($request->all());
        if(isset($request->user_id) && $request->user_id != null && $request->user_id != '')
        {
            $user = User::findOrfail($request->user_id);
            if(isset($user) && $user != null)
            {
                $user->approval = isset($request->approval) ? $request->approval : null;
                if(isset($request->s_access_type) && $request->s_access_type == 'limited_access')
                {
                    $user->site_access = 1;
                    $user->site_access_start_date = isset($request->start_date) ? $request->start_date : null;
                    $user->site_access_start_time = isset($request->start_time) ? $request->start_time : null;
                    $user->site_access_end_date = isset($request->end_date) ? $request->end_date : null;
                    $user->site_access_end_time = isset($request->end_time) ? $request->end_time : null;
                }else{
                    $user->site_access = 0;
                }
                $user->save();
                event(new AccessChanged($user));
                if(isset($user->approval) && $user->approval == 0 && isset($request->approval) && $request->approval == 1)
                {
                    Mail::to($user->email)->send(new ApprovalMail($user));
                }
                return response()->json(['status' => 1, 'message' => 'User Approval Status Updated Successfully.']);
            }else{
                return response()->json(['status' => 0, 'message' => 'User Not Found!']);
            }
        }else{
            return response()->json(['status' => 0, 'message' => 'Something Went Wrong!']);
        }
    }
    public function check_user_access(Request $request)
    {
        if(isset($request->user_id) && $request->user_id != null && $request->user_id != '')
        {
            $user = User::findOrfail($request->user_id);
            if(isset($user) && $user != null)
            {
                if(isset($user->site_access) && $user->site_access != null && $user->site_access == 0)
                {
                    $setting = Setting::first();
                    if(isset($setting->access_limited_access) && $setting->access_limited_access != null && $setting->access_limited_access == 1)
                    {
                        $currentDateTime = now();
                        $globalAccessHours = (int) $setting->global_access_hours;
                        $globalAccessMinutes = (int) $setting->global_access_min;
                        $endDateTime = $currentDateTime->copy()->addHours($globalAccessHours)->addMinutes($globalAccessMinutes);
                        $siteAccessStartDate = $currentDateTime->format('m/d/Y');
                        $siteAccessStartTime = $currentDateTime->format('H:i');
                        $siteAccessEndDate = $endDateTime->format('m/d/Y');
                        $siteAccessEndTime = $endDateTime->format('H:i');
                        $user->site_access_start_date = $siteAccessStartDate;
                        $user->site_access_start_time = $siteAccessStartTime;
                        $user->site_access_end_date = $siteAccessEndDate;
                        $user->site_access_end_time = $siteAccessEndTime;
                    }
                }
                return response()->json(['status' => 1, 'message' => 'User Approval Status Updated Successfully.', 'user' => $user]);
            }else{
                return response()->json(['status' => 0, 'message' => 'User Not Found!']);
            }
        }else{
            return response()->json(['status' => 0, 'message' => 'Something Went Wrong!']);
        }
    }
    public function update_user_access(Request $request)
    {
        // dd($request->all());
        if(isset($request->user_id) && $request->user_id != null && $request->user_id != '')
        {
            $user = User::findOrfail($request->user_id);
            if(isset($user) && $user != null)
            {
                $user->product_access = isset($request->access_type) && $request->access_type == 'limited_access' ? 1 : 0;
                $user->start_date = isset($request->start_date) ? $request->start_date : null;
                $user->start_time = isset($request->start_time) ? $request->start_time : null;
                $user->end_date = isset($request->end_date) ? $request->end_date : null;
                $user->end_time = isset($request->end_time) ? $request->end_time : null;
                $user->save();
                event(new ProductAccessChanged($user));
                return response()->json(['status' => 1, 'message' => 'User Access Updated Successfully.']);
            }else{
                return response()->json(['status' => 0, 'message' => 'User Not Found!']);
            }
        }else{
            return response()->json(['status' => 0, 'message' => 'Something Went Wrong!']);
        }
    }
}
