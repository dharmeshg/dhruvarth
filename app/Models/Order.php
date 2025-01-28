<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;

class Order extends Model
{
    use HasFactory, SoftDeletes;
    use Userstamps;
    public $timestamps = true;
    protected $userstamps = [
       'created_by' => 'created_by', 
       'updated_by' => 'updated_by',
       'deleted_by' => 'deleted_by',
   ];

    protected $fillable = [
        'user_id',
        'product_id',
        'product_type',
        'checkout_method',
        'order_number',
        'total_qty',
        'total_cost',
        'status',
        'completed_order_id',
        'pdf_path',
        'comment',
        'payment_status',
        'promo_code_id',
        'promo_code_discount',
        'link'
    ];

    public function products()
    {
        return $this->hasMany('App\Models\Product', 'id', 'product_id');
    }

    public function get_order_user()
    {
        return $this->hasMany('App\Models\User', 'id', 'user_id');
    }
    public function order_items()
    {
        return $this->hasMany('App\Models\OrderItems', 'order_id', 'id');
    }
    public function check_shipping_amount($order_id)
    {
        $order_details = Order::where('id', $order_id)->orderByDesc('id')->first();
        $order_items = OrderItems::where('order_id',$order_details->id)->get();
        $address_details = UserAddress::where('user_id',$order_details->user_id)->first();
        $totalGrandPrice = 0;
        foreach($order_items as $single_items_w)
        {
            $product = Product::where('id',$single_items_w->product_id)->first();
            if(!$product)
            {
                continue;
            }
            $total_price = str_replace(',', '', $product->total_price($product->id));
            $total_price_numeric = (float) $total_price;
            $product_price = $total_price_numeric * $single_items_w->qty;
            $totalGrandPrice += $product_price;
        }
        $pincode = $address_details->zipcode;
        $all_code = Shipping::get();
        $final_code = [];
        $final_shipping = 0;
        $final_amount = '';
        $without_format = '';
        foreach($all_code as $key => $a_code)
        {
            $o_codes = explode(',',$a_code->code);
            foreach($o_codes as $s_code)
            {
                $code_by_id = DeliveryZip::where('id',$s_code)->first();
                if(isset($code_by_id) && $code_by_id->code == $pincode)
                {
                    $final_code = $a_code;
                    break;
                }
            }
        }
        if(isset($final_code) && !empty($final_code))
        {
            if(isset($final_code->p_time) && $final_code->p_time != '' && $final_code->p_time != null)
            {
                $days = intval($final_code->p_time);
                $final_shipping = 0;
                return $final_shipping;
            }
        }else{
            $response = Http::get("https://api.postalpincode.in/pincode/{$pincode}");
            if ($response->successful()) {
                $data = $response->json();
                $city = $data[0]['PostOffice'][0]['District'] ?? null;
                $state = $data[0]['PostOffice'][0]['State'] ?? null;
                $country = $data[0]['PostOffice'][0]['Country'] ?? null;
                $found = false;
                foreach($all_code as $key => $a_code)
                {
                    if ($found) {
                        break; 
                    }
                    $city_id = Citie::where('name',$city)->first();
                    $o_city = explode(',',$a_code->city);
                    if(!$found && $city_id != null)
                    {
                        foreach($o_city as $s_city)
                        {
                            if($s_city == $city_id->id)
                            {
                                $final_code = $a_code;
                                $found = true;
                                break;
                            }
                        }
                    }
                     
                    $state_id = State::where('name',$state)->first();
                    $o_state = explode(',',$a_code->state);

                    if(!$found && $a_code->city == null && $state_id != null)
                    {
                        foreach($o_state as $s_state)
                        {
                            if($s_state == $state_id->id)
                            {
                                $final_code = $a_code;
                                $found = true;
                                break;
                            }
                        }
                    }
                    $country_id = Country::where('name',$country)->first();
                    if(!$found && $a_code->city == null && $a_code->state == null && $country_id != null){
                        if($a_code->country == $country_id->id)
                        {
                            $final_code = $a_code;
                            $found = true;
                            break;
                        }
                    }
                    
                }

                if(isset($final_code) && $final_code != '' && $final_code != null)
                {
                    $shipping_cal = ShippingCalculation::where('shipping_id',$final_code->id)->first();
                    if(isset($shipping_cal) && $shipping_cal != null)
                    {
                        if(isset($shipping_cal->type) && $shipping_cal->type == 'fixed')
                        {
                            $final_shipping = $shipping_cal->fix_charge;
                        }
                        if(isset($shipping_cal->type) && $shipping_cal->type == 'on_price')
                        {
                            $data = json_decode($shipping_cal->data);
                            foreach ($data as $range) {
                                $from = $range->from;
                                $to = $range->to;
                                $shipping_amount = $range->shipping_amount;
                                if ($totalGrandPrice >= $from && $totalGrandPrice <= $to) {
                                    $final_shipping = $shipping_amount;
                                    break;
                                }
                            }
                        }
                    }
                    return floatval($final_shipping);
                }else{
                    return floatval($final_shipping);
                }
            }
            return floatval($final_shipping);
        } 
    }
}
