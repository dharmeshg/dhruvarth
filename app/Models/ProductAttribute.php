<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;
use Illuminate\Support\Carbon;

class ProductAttribute extends Model
{
    use HasFactory, SoftDeletes;
    use Userstamps;
    public $timestamps = true;
    protected $fillable = ['parent_product_id','child_product_id','attributes','diamond_attributes','pearl_attributes','gemstone_attributes'];
    protected $userstamps = [
       'created_by' => 'created_by', 
       'updated_by' => 'updated_by',
       'deleted_by' => 'deleted_by',
   ];
   public function product()
    {
        return $this->belongsTo(Product::class, 'parent_product_id');
    }

    public function variantProducts()
    {
        return $this->hasMany(VariantProduct::class, 'attr_id');
    }
}
