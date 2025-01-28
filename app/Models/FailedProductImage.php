<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class FailedProductImage extends Model
{
    use HasFactory, SoftDeletes;
    use Userstamps;

    public $timestamps = true;
    public $table = 'failed_product_images';
    protected $fillable = ['sku','name','priority'];
        protected $userstamps = [
        'created_by' => 'created_by', 
        'updated_by' => 'updated_by',
        'deleted_by' => 'deleted_by',
    ];
}
