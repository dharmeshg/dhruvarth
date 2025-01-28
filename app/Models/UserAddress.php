<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;
use Illuminate\Support\Carbon;

class UserAddress extends Model
{
    use HasFactory, SoftDeletes;
    use Userstamps;
    public $timestamps = true;

    public $table = 'user_addresses';
    protected $userstamps = [
       'created_by' => 'created_by', 
       'updated_by' => 'updated_by',
       'deleted_by' => 'deleted_by',
   ];

    protected $fillable = [
        'user_id',
        'fullname',
        'address',
        'address2',
        'country',
        'state',
        'zipcode',
        'city',
        'email',
        'gst_number',
        'social_1',
        'social_2',
    ];

    public function products()
    {
        return $this->hasMany('App\Models\Product', 'id', 'product_id');
    }

    public function get_order_user()
    {
        return $this->hasMany('App\Models\User', 'id', 'user_id');
    }
    public function get_city()
    {
        return $this->belongsTo(Citie::class, 'city');
    }
    public function get_state()
    {
        return $this->belongsTo(State::class, 'state');
    }
    public function get_country()
    {
        return $this->belongsTo(Country::class, 'country');
    }
}
