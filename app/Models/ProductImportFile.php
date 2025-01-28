<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class ProductImportFile extends Model
{
    use HasFactory, SoftDeletes;
    use Userstamps;
    public $timestamps = true;
    public $table = 'product_import_files';
    protected $fillable = ['category','file_name','status','completed_filename','invalid_filename','updated_filename','publish_status','progress'];
    protected $userstamps = [
       'created_by' => 'created_by', 
       'updated_by' => 'updated_by',
       'deleted_by' => 'deleted_by',
   ];
   public function getcategory()
    {
        return $this->belongsTo(Category::class, 'category');
    }
}
