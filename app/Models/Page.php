<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Cviebrock\EloquentSluggable\Sluggable;

class Page extends Model
{
    use HasFactory, SoftDeletes, Userstamps, Sluggable;
    public $timestamps = true;
    protected $userstamps = [
       'created_by' => 'created_by', 
       'updated_by' => 'updated_by',
       'deleted_by' => 'deleted_by',
   ];
   
   public function getCreatedAtAttribute($value)
   {
       return Carbon::parse($value)->format('Y/m/d');
   }
   public function getUpdatedAtAttribute($value)
   {
       return Carbon::parse($value)->format('Y/m/d');
   }
    public function authorUser()
    {
        return $this->belongsTo(User::class, 'author');
    }
    public function parent()
    {
        return $this->belongsTo(Page::class, 'page_attribute');
    }
    public function setDateAttribute( $value ) {
        $this->attributes['published_at'] = (new Carbon($value))->format('d/m/y');
      }
      public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
            ]
        ];
    }
}
