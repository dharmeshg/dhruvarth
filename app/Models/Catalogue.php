<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;
use Illuminate\Support\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Intervention\Image\Laravel\Facades\Image;

class Catalogue extends Model
{
    use HasFactory, SoftDeletes, Sluggable;
    use Userstamps;

    public $timestamps = true;
    protected $userstamps = [
       'created_by' => 'created_by', 
       'updated_by' => 'updated_by',
       'deleted_by' => 'deleted_by',
   ];
   protected $fillable = ['slug','product_id','name','cover_image','link','status'];
   
   public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
            ]
        ];
    }
}
