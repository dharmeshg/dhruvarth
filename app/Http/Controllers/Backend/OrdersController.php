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
use App\Models\UserAddress;
use App\Http\Controllers\Frontend\MailController;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;


class OrdersController extends Controller
{
	public function orders_dash_index()
	{
		return view('orders.dash_index');
	}

	public function orders_index()
	{

		return view('orders.index');
	}

	public function list(Request $request)
	{
		$order = Order::with('get_order_user')->where('status', '!=', null)->where('payment_status','!=',NULL)->latest()->get();
		//$order = Order::with('get_order_user')->latest()->get();
		

		$counter = 1;
		
		$order->transform(function ($item) use (&$counter) {
			$order_items = OrderItems::where('order_id',$item->id)->get();
			$user = User::where('id',$item->user_id)->first();
			$total_qty = 0;
			$total_cost = 0;
			foreach($order_items as $val)
			{
				$total_qty += $val->qty;
				$cost = $val->qty * $val->total_price;
				$total_cost += $cost;
			}
			$item['ser_id_num'] = $counter++;

			$item['ser_id'] = '<div class="custom-control custom-checkbox">
			<input type="checkbox" class="pinned_chekbox" id="is_featured" val="'.$item['id'].'" name="orders_list_download[]" data-id="' . $item['id'] . '"';

			if ($item['pinned'] == 1) {
				$item['ser_id'] .= ' checked';
			}

			$item['ser_id'] .= '></div>';

			
			if(isset($user) && $user->email != null)
			{
				$item['customers_mail'] = $user->email;
			}
			else{
				$item['customers_mail'] = '-';
			}
			if (isset($total_qty) && $total_qty != '') {
				$item['total_qty'] = $total_qty;
			}else{
				$item['total_qty'] = "-";
			}
			if (isset($total_cost) && $total_cost != '') {
				$item['total'] = "₹ ". number_format($total_cost, 2, '.', ',');
			}else{
				$item['total'] = "-";
			}   


			if (isset($item['updated_at']) && $item['updated_at'] != '') {
				$dateTime = new DateTime($item['updated_at']);
				$formattedDate = $dateTime->format('d-m-Y');
				$item['date'] = $formattedDate; 
			}else{
				$item['date'] = "-";
			}



			$item['p_status'] = $item['payment_status'];

			$item['action'] = '<div class="action_div"><a href="' . route('orders.details', $item['id']) . '" title="Click here to View Order" class=" table-btn table-btn1 mx-2" data-id="' . $item['id'] . '"><img src="'.asset('images/dashbord/Eye image.png').'" class="image-fuild" alt="user-img"></a><a href="javascript:;" class="table-btn table-btn1 mx-2 edit" data-id="' . $item['id'] . '" title="Click here to Edit Order" ><img src="'.asset('images/dashbord/create.png').'" class="image-fuild" alt="user-img"></a></div>';

			return $item;
		});

		return response()->json(['data' => $order]);
	}

	public function search_orders(Request $request)
	{

		$order = Order::with('get_order_user');

		if (isset($request->pro_status) && $request->pro_status != '') {
			$order->where('status' , $request->pro_status);
		}

		if ($request->from_date != "") {
			$from_date = Carbon::createFromFormat('m/d/Y', $request->from_date)->startOfDay();
			$order->where('updated_at', '>=',$from_date);
		}

		if ($request->to_date != "") {
			$to_date = Carbon::createFromFormat('m/d/Y', $request->to_date)->endOfDay();
			$order->where('updated_at', '<=', $to_date);
		}

		$order_list = $order->latest()->get();

		$counter = 1;
		$order_list->transform(function ($item) use (&$counter) {
			$order_items = OrderItems::where('order_id',$item->id)->get();
			$user = User::where('id',$item->user_id)->first();
			$total_qty = 0;
			$total_cost = 0;
			foreach($order_items as $val)
			{
				$total_qty += $val->qty;
				$cost = $val->qty * $val->total_price;
				$total_cost += $cost;
			}

			$item['ser_id_num'] = $counter++;

			$item['ser_id'] = '<div class="custom-control custom-checkbox">
			<input type="checkbox" class="pinned_chekbox" id="is_featured" val="'.$item['id'].'" name="customers_list_download[]" data-id="' . $item['id'] . '"';

			if ($item['pinned'] == 1) {
				$item['ser_id'] .= ' checked';
			}

			$item['ser_id'] .= '></div>';

			if(isset($user) && $user->email != null)
			{
				$item['customers_mail'] = $user->email;
			}
			else{
				$item['customers_mail'] = '-';
			}
			if (isset($total_qty) && $total_qty != '') {
				$item['total_qty'] = $total_qty;
			}else{
				$item['total_qty'] = "-";
			}
			if (isset($total_cost) && $total_cost != '') {
				$item['total'] = "₹ ". number_format($total_cost, 2, '.', ',');
			}else{
				$item['total'] = "-";
			}   

			if (isset($item['updated_at']) && $item['updated_at'] != '') {
				$dateTime = new DateTime($item['updated_at']);
				$formattedDate = $dateTime->format('d-m-Y');
				$item['date'] = $formattedDate; 
			}else{
				$item['date'] = "-";
			}
			$item['p_status'] = $item['payment_status'];
			$item['action'] = '<div class="action_div"><a href="' . route('orders.details', $item['id']) . '" title="Click here to View Order" class=" table-btn table-btn1 mx-2" data-id="' . $item['id'] . '"><img src="'.asset('images/dashbord/Eye image.png').'" class="image-fuild" alt="user-img"></a><a href="javascript:;" class="table-btn table-btn1 mx-2 edit" data-id="' . $item['id'] . '" title="Click here to Edit Order" ><img src="'.asset('images/dashbord/create.png').'" class="image-fuild" alt="user-img"></a></div>';

			return $item;
		});

		return response()->json(['data' => $order_list]);

	}

	public function export(Request $request)
	{
		$data_ar = [];

		if (isset($request->selectedValues) && count($request->selectedValues) > 0) {
			$oreders_id = $request->selectedValues;

			foreach ($oreders_id as $key => $id) {
				if ($id != null) {
					$orders[] = Order::with('get_order_user')->where('id',$id)->first();
				}

			}
		}else{
			$orders = Order::with('get_order_user')->get();

		}





		if (isset($orders) && $orders != '' && count($orders) > 0) {

			foreach ($orders as $key => $val) {
				$order_items = OrderItems::where('order_id',$val->id)->get();
				$total_qty = 0;
				$total_cost = 0;
				foreach($order_items as $val2)
				{
					$total_qty += $val2->qty;
					$cost = $val2->qty * $val2->total_price;
					$total_cost += $cost;
				}

				$data_ar[$key]['Sr no'] = $key + 1;


				$data_ar[$key]['Customers Email'] = isset($val->get_order_user[0]['email']) && $val->get_order_user[0]['email'] != '' ? $val->get_order_user[0]['email'] : '-';


				if (isset($val->id) && $val->id != '') {
					$data_ar[$key]['Order Number'] = isset($val->id) && $val->id != '' ? $val->id : '-';
				}else{
					$data_ar[$key]['Order Number'] = '';
				}

				if (isset($val->total_cost) && $val->total_cost != '') {
					$total_cost = "₹ $val->total_cost";
				}


				$data_ar[$key]['Total Qty'] = isset($total_qty) && $total_qty != '' ? $total_qty : '-';
				$data_ar[$key]['Total Cost'] = isset($total_cost) && $total_cost != '' ? $total_cost : '-';
				$data_ar[$key]['Status'] = isset($val->status) && $val->status != '' ? $val->status : '-';




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

	public function details($id)
	{

		$order = Order::with('get_order_user')->where('id', $id)->first();
		$order_items = OrderItems::where('order_id',$order->id)->get();
		$user_address = UserAddress::where('user_id',$order->user_id)->first();
		$user = User::where('id',$order->user_id)->first();
		return view('orders.orders_details', compact('order','order_items','user_address','user'));
	}

	public function get_status(Request $request)
	{
		$order = Order::findOrfail($request->id);
		return response()->json(['status' => 1, 'data' => $order]);
	}
	public function change_status(Request $request)
	{
		$order = Order::findOrfail($request->id);
		$order->payment_status = isset($request->p_status) ? $request->p_status : null;
		$order->status = isset($request->o_status) ? $request->o_status : null;
		if($request->o_status == 'On Delivery'){
			$order->link = $request->link;
		}else{
			$order->link = '';
		}
	
		$order->save();
		if($order->status == 'Declined')
		{
			$MailController = new MailController();
	        $MailController->send_cancel_order_mail_to_user($order->id,$order->user_id);
		}
		if($order->status == 'Processing')
		{
			$MailController = new MailController();
	        $MailController->send_processing_order_mail_to_user($order->id,$order->payment_status,$order->user_id);
		}
		if($order->status == 'On Delivery')
		{
			$MailController = new MailController();
	        $MailController->send_dispatched_order_mail_to_user($order->id,$order->payment_status,$order->user_id, $order->link);
		}
		if($order->status == 'Completed')
		{
			$MailController = new MailController();
	        $MailController->send_completed_order_mail_to_user($order->id,$order->payment_status,$order->user_id);
		}
		return response()->json(['status' => 1, 'message' => 'Order Status Updated Successfully.']);
	}

}