<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class ProductImage extends Model
{
    use HasFactory, SoftDeletes;
    use Userstamps;

    public $timestamps = true;
    public $table = 'product_images';
   protected $fillable = ['product_id','name','type','add_type','priority'];
    protected $userstamps = [
       'created_by' => 'created_by', 
       'updated_by' => 'updated_by',
       'deleted_by' => 'deleted_by',
   ];
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function variantProduct()
    {
        return $this->belongsTo(VariantProduct::class, 'product_id');
    }

}
