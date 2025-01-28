<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;
use Illuminate\Support\Carbon;

class OrderItems extends Model
{
    use HasFactory, SoftDeletes;
    use Userstamps;
    public $timestamps = true;

    public $table = 'order_items';
    
    protected $userstamps = [
       'created_by' => 'created_by', 
       'updated_by' => 'updated_by',
       'deleted_by' => 'deleted_by',
   ];

    protected $fillable = [
        'user_id',
        'order_id',
        'product_id',
        'qty',
        'total_price',
        'promo_code_id',
        'promo_code_discount',
    ];

    public function products()
    {
        return $this->hasMany('App\Models\Product', 'id', 'product_id');
    }

    public function get_order_user()
    {
        return $this->hasMany('App\Models\User', 'id', 'user_id');
    }

   



}
