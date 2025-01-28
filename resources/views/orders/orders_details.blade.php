@extends('layouts.backend.index')
@section('main_content')
<style>
.datepicker-days{display: block !important;}
.customer_product{cursor: pointer;}

.select2-container .select2-selection--multiple{
    color: #000 !important;
    border-radius: unset !important;
    background: #FFFFFF !important;
    padding: 5px !important;
    border: 1px solid #CED4DA !important;
}

.heading-area{background: #f4f4f4;padding: 10px 30px 10px;border: 1px solid #e3e3e3;}
.heading-area h4{margin: 0;}
.order_details_table{padding: 10px 30px 10px;}
.add-article-btn-new{background-color: var(--theme-orange-red);color: #40404c;padding: 8px 13px;font-size: 15px;border-radius: 5px;}
.add-article-btn-new:hover{color: #40404c;}
.payment-class td{padding-bottom: 0 !important;padding-top: 0 !important;}
.payment-class td span{padding: 5px;background: #dc3545;border-radius: 10px;color: #fff;font-size: 12px;font-weight: 600;}
.above_table table th,.above_table table td{padding: 5px !important;}
</style>


<div class="pcoded-wrapper">
    <div class="pcoded-content">
        <div class="pcoded-inner-content">
            <div class="custom_breadcum">
                <ul>
                    <li class="breadcum-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                    <li class="breadcum-item"><a href="{{route('orders.dash_index')}}"> Orders </a></li>
                    <li class="breadcum-item"><a href="{{route('orders.index')}}"> Orders</a></li>
                    <li class="breadcum-item active"><a href="javascript:;"> Orders Details</a></li>
                </ul>
            </div>

            <div class="main-body">
                <div class="page-wrapper">
                    <div class="row">
                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="card Recent-Users mb-4">
                                <div class="card-header">
                                    <h5>Orders Details</h5>
                                    <a href="{{route('orders.index')}}" style="cursor: pointer;" class="add-article-btn">Back Orders List</a>
                                </div>
                                <div class="card-body card-block px-0 py-3">
                                    <div class="row">
                                     <div class="col-lg-6">
                                        <div class="special-box">
                                            <div class="heading-area">
                                                <h4 class="title">
                                                    Order Details
                                                </h4>
                                            </div>
                                            @php
                                            $total_qty = 0;
                                            $total_cost = 0;
                                            foreach($order_items as $val)
                                            {
                                                $total_qty += $val->qty;
                                                $cost = $val->qty * $val->total_price;
                                                $total_cost += $cost;
                                            }
                                            @endphp
                                            <div class="table-responsive-sm order_details_table above_table">
                                                <span class="badge badge-danger"></span><table class="table">
                                                    <tbody>
                                                        <tr class="payment-class">
                                                            <td>
                                                                @if(isset($order->payment_status) && $order->payment_status != null && $order->payment_status == 'Paid')
                                                                <span style="background:#28a745;">Paid</span>
                                                                @else
                                                                <span >UnPaid</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th class="45%" width="45%">Order ID</th>
                                                            <td width="10%">:</td>
                                                            <td class="45%" width="45%">{{isset($order->id) ? $order->id : ''}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th width="45%">Total Product</th>
                                                            <td width="10%">:</td>
                                                            <td width="45%">{{isset($total_qty) ? $total_qty : ''}}</td>
                                                        </tr>

                                                        <tr>
                                                            <th width="45%">Total Cost</th>
                                                            <td width="10%">:</td>
                                                            <td width="45%">{{isset($total_cost) ? number_format($total_cost, 2, '.', ',') : ''}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th width="45%">Ordered Date</th>
                                                            <td width="10%">:</td>
                                                            <td width="45%">{{ $order->updated_at->format('l, d M Y h:i A') }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th width="45%">Payment Method</th>
                                                            <td width="10%">:</td>
                                                            <td width="45%">{{isset($order->checkout_method) ? $order->checkout_method : ''}}</td>
                                                        </tr>
                                                        <tr><th width="45%">Payment Status</th>
                                                            <th width="10%">:</th>
                                                            <td width="45%">{{isset($order->status) ? $order->status : ''}}</td>
                                                        </tr>
                                                        <tr><th width="45%">Shipping Charges</th>
                                                            @php
                                                                $shipping_amount = $order->check_shipping_amount($order->id);   
                                                            @endphp
                                                            <th width="10%">:</th>
                                                            <td width="45%">{{number_format($shipping_amount, 2)}}</td>
                                                        </tr>
                                                        @if(isset($order->promo_code_id) && $order->promo_code_id != null && $order->promo_code_id != '')
                                                        <tr><th width="45%">Used Promo Code</th>
                                                            @php
                                                                $promo_code = App\Models\PromoCode::where('id',$order->promo_code_id)->first();   
                                                            @endphp
                                                            <th width="10%">:</th>
                                                            <td width="45%">{{ isset($promo_code->code) ? $promo_code->code : '' }}</td>
                                                        </tr>
                                                        <tr><th width="45%">Discount Amount</th>
                                                            <th width="10%">:</th>
                                                            <td width="45%">{{number_format($order->promo_code_discount, 2)}}</td>
                                                        </tr>
                                                        @endif
                                                        <tr>
                                                            <td>
                                                                <a href="{{$order->pdf_path}}" target="new" style="cursor: pointer;" class="add-article-btn-new"><i class="fa fa-eye"></i> View Invoice</a>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="special-box">
                                                <div class="heading-area">
                                                    <h4 class="title">
                                                        Billing Details
                                                    </h4>
                                                </div>
                                                <div class="table-responsive-sm order_details_table above_table">
                                                    <span class="badge badge-danger"></span><table class="table">
                                                        <tbody>
                                                            <tr>
                                                                <th class="45%" width="45%">Name</th>
                                                                <td width="10%">:</td>
                                                                <td class="45%" width="45%">{{ isset($user_address->fullname) ? $user_address->fullname : ''}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th width="45%">Email</th>
                                                                <td width="10%">:</td>
                                                                <td width="45%">{{ isset($user_address->email) ? $user_address->email : ''}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th width="45%">Phone</th>
                                                                <td width="10%">:</td>
                                                                <td width="45%">{{ isset($user->country_code_number) ? $user->country_code_number : '' }} {{ isset($user->phone) ? $user->phone : ''}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th width="45%">Address</th>
                                                                <td width="10%">:</td>
                                                                <td width="45%">{{ isset($user_address->address) ? $user_address->address : ''}}, {{ isset($user_address->address2) ? $user_address->address2 : ''}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th width="45%">Country</th>
                                                                <td width="10%">:</td>
                                                                <td width="45%">{{ isset($user_address->get_country->name) ? $user_address->get_country->name : ''}}</td>
                                                            </tr>
                                                            <tr><th width="45%">State</th>
                                                                <th width="10%">:</th>
                                                                <td width="45%">{{ isset($user_address->get_state->name) ? $user_address->get_state->name : ''}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th width="45%">City</th>
                                                                <td width="10%">:</td>
                                                                <td width="45%">{{ isset($user_address->get_city->name) ? $user_address->get_city->name : ''}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th width="45%">Postal Code</th>
                                                                <td width="10%">:</td>
                                                                <td width="45%">{{ isset($user_address->zipcode) ? $user_address->zipcode : ''}}</td>
                                                            </tr>
                                                        </tbody>
                                                        </table>
                                                    </div>

                                                </div>
                                            </div>


                                        </div>


                                        <div class="table-responsive" role="tabpanel" id="">
                                            <table class="table table-hover" id="myTable" style="width:100%">
                                                <thead>
                                                    <tr class="unread">
                                                        <th scope="col">No.</th>
                                                        <th scope="col">Product Name</th>
                                                        <th scope="col">Product SKU</th>
                                                        <th scope="col">Order Number</th>
                                                        <th scope="col">Total Qty</th>
                                                        @if($order_items->contains('promo_code_id', '!=', null))
                                                        <th scope="col">Code Discount</th>
                                                        @endif
                                                        <th scope="col">Total Cost</th>
                                                        <th scope="col">Register Date & Time</th>
                                                        <th scope="col">Product Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                    $counter = 1;
                                                    @endphp
                                                    @foreach($order_items as $item)
                                                    @php
                                                    if($item->product_type == 'simple')
                                                    {
                                                        $product = App\Models\Product::where('id',$item->product_id)->first();
                                                        $slug = route('product.edit',['id' => $product->id, 'slug' => 'simple']);
                                                    }else{
                                                        $product = App\Models\VariantProduct::where('id',$item->product_id)->first();
                                                        $slug = route('product.edit',['id' => $product->id, 'slug' => 'variant']);
                                                    }
                                                        
                                                        $single_price = $item->qty * $item->total_price;
                                                        $promo_discount = 0;
                                                    @endphp
                                                    <tr>
                                                        <td>{{$counter}}</td>
                                                        <td><a href="{{ $slug }}" target="new" style="color: #000 !important">{{$product->p_title}}</a></td>
                                                        <td>{{$product->p_sku}}</td>
                                                        <td>{{$order->id}}</td>
                                                        <td>{{$item->qty}}</td>
                                                        @if($order_items->contains('promo_code_id', '!=', null))
                                                        @php
                                                            $promo_discount = isset($item->promo_code_discount) ? $item->promo_code_discount : 0;
                                                        @endphp
                                                        <td>{{number_format($promo_discount, 2, '.', ',')}}</td>
                                                        @endif
                                                        <td>{{number_format($single_price - $promo_discount, 2, '.', ',')}}</td>
                                                        <td>{{$item->updated_at->format('l, d M Y h:i A')}}</td>
                                                        @if(isset($item->p_status) && $item->p_status == 'by_order')
                                                            <td>By Order</td>
                                                        @else
                                                            <td>Ready Stock</td>
                                                        @endif
                                                        @php $counter++ @endphp
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- </div> -->
                                        <!-- </div> -->
                                    </div>
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