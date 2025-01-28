<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;
use Illuminate\Support\Carbon;

class Gender extends Model
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
        'name',
    ];

    // public function products_genders()
    // {
    //     return $this->hasMany('App\Models\Product', 'id', 'product_id');
    // }
   
}
