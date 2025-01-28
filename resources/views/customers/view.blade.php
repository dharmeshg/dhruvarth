@extends('layouts.backend.index')

@section('main_content')
<style>
.is_featured_class{margin: 0px 10px -4px 10px;}
.iti--allow-dropdown{
    width: 100%;
}
#mobile_code{
    padding-left: 82px !important;
}
.user-img{text-align: center;}
.user-img img{width: 150px;border-radius: 50%;height: 150px;}
.user-details .each-detail{color: #000;display: flex;}
.user-details .each-detail span{font-weight: 800;margin-right: 15px;}
h4{font-weight: 600;
    font-size: 22px;}
</style>

<div class="pcoded-wrapper">
	<div class="pcoded-content">
		<div class="pcoded-inner-content">
			<div class="custom_breadcum">
                <ul>
                    <li class="breadcum-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                    <li class="breadcum-item"><a href="{{route('orders.dash_index')}}"> Orders </a></li>
                    <li class="breadcum-item"><a href="{{route('customers.index')}}"> Customers</a></li>
                    <li class="breadcum-item active"><a href="javascript:;"> Customer Details </a></li>
                </ul>
            </div>

			<div class="main-body">
				<div class="page-wrapper">
					<div class="card card-body Recent-Users mb-4">
						<div class="row">
							<h4>Details</h4>
							<div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">
								<div class="user-img">
									@if(isset($user->image) && $user->image != '' && $user->image != null)
									<img src="{{asset('uploads/users/'.$user->image)}}">
									@else
									<img src="{{asset('assets/images/user/img-demo_1041.jpg')}}">
									@endif
								</div>
							</div>
							<div class="col-xxl-8 col-xl-8 col-lg-8 col-md-8 col-sm-12 col-xs-12">
								<div class="user-details">
									<div class="each-detail"><span>ID#</span> <p>{{ isset($user->id) ? $user->id : '' }}</p></div>
									<div class="each-detail"><span>Name</span> <p>{{ isset($user->name) ? $user->name : '' }}</p></div>
									<div class="each-detail"><span>Email</span> <p>{{ isset($user->email) ? $user->email : '' }}</p></div>
									<div class="each-detail"><span>Phone</span> <p>{{ isset($user->phone) ? $user->phone : '' }}</p></div>
									<div class="each-detail"><span>Joined</span> 
										<p>@if($user->created_at->diff(now())->m > 0)
									    {{ $user->created_at->diff(now())->format('%m months and') }}
										@endif
										@if($user->created_at->diff(now())->d > 0)
										    {{ $user->created_at->diff(now())->format(' %d days') }}
										@endif
										ago</p>
									</div>
								</div>
							</div>
						</div>
						<div class="order-table">
							<h4>Products Ordered</h4>
							<div class="table-responsive" role="tabpanel" id="">
                                <table class="table table-hover" id="myTable" style="width:100%">
                                    <thead>
                                        <tr class="unread">
                                            <th scope="col">No.</th>
                                            <th scope="col">Order ID</th>
                                            <th scope="col">Purchase Date</th>
                                            <th scope="col">Amount</th>
                                            <th scope="col">Payment Method</th>
                                            <th scope="col">Payment Status</th>
                                            <th scope="col">Order Status</th>
                                            <th scope="col">Details</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    	@php 
                                    		$counter = 1;
                                    		$totalGrandPrice = 0;
                                    	@endphp
                                    	@if(isset($orders) && count($orders) > 0)
                                    	@foreach($orders as $order)
                                    	@php
                                    		$order_items = App\Models\OrderItems::where('order_id',$order->id)->get();
                                    		foreach($order_items as $item)
                                    		{
                                    			$product = App\Models\Product::where('id',$item->product_id)->first();
                                    			$total_price = str_replace(',', '', $product->total_price($product->id));
			                                    $total_price_numeric = (float) $total_price;
												$product_price = $total_price_numeric * $item->qty;
												$totalGrandPrice += $product_price;
                                    		}
                                    	@endphp
                                    	<tr>
	                    					<td>{{ $counter }}</td>
	                                        <td><a href="{{$order->pdf_path}}" target="new" style="cursor: pointer;">{{ isset($order->id) ? $order->id : '-' }}</a></td>
	                                        <td>{{ isset($order->updated_at) ? $order->updated_at : '-' }}</td>
	                                        <td>{{ isset($totalGrandPrice) ? number_format($totalGrandPrice, 2, '.', ',') : '-' }}</td>
	                                        <td>{{ isset($order->checkout_method) ? $order->checkout_method : '-' }}</td>
	                                        <td>{{ isset($order->payment_status) && $order->payment_status == 'Paid' ? 'Paid' : 'Unpaid'}}</td>
	                                        <td>{{ isset($order->status) ? $order->status : '-' }}</td>
	                                        <td><a href="{{route('orders.details',['id' => $order->id])}}"><img src="{{asset('images/dashbord/Eye image.png')}}" class="image-fuild" alt="user-img"></a></td>
	                                    </tr>
	                                    @php
	                                    	$counter++
	                                    @endphp
	                                    @endforeach
	                                    @endif
                                    </tbody>
                                </table>
                            </div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>



	@endsection


	@section('script')
    @endsection
