<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Wildside\Userstamps\Userstamps;
// use App\Models\Sections;


class PromoCode extends Model
{
    use HasApiTokens,HasFactory, Notifiable, SoftDeletes;
    use Userstamps;
      /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

     public $timestamps = true;
     protected $userstamps = [
        'created_by' => 'created_by', 
        'updated_by' => 'updated_by',
        'deleted_by' => 'deleted_by',
    ];

     protected $table = 'promo_code';
    protected $fillable = [
        'title',
        'code',
        'description',
        'startDate',
        'endDate',
        'status',
        'single_time_use',
        'publish_status',
        'discounted_product',
        'discount_type',
        'discount',
        'minimum_cart_amount',
        'max_discount_amount',
        'included_category',
        'included_products',
        'excluded_category',
        'excluded_products',
        'no_of_use',
        'one_time_use',
    ];
    public function orders()
    {
        return $this->hasMany(Order::class, 'promo_code_id');
    }
    public function userorders()
    {
        return $this->hasMany(Order::class, 'user_id');
    }
}