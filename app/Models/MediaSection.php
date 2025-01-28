<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Cviebrock\EloquentSluggable\Sluggable;
use Wildside\Userstamps\Userstamps;
// use App\Models\Sections;


class MediaSection extends Model
{
    use HasApiTokens,HasFactory, Notifiable, SoftDeletes, Sluggable;
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

     protected $table = 'media_sections';
    protected $fillable = [
        'type',
        'title',
        'image',
        'slug',
    ];


    public function subcategory()
    {
        return $this->hasMany(\App\Models\Category::class, 'parent_category');
    }

    public function parent()
    {
        return $this->belongsTo(\App\Models\Category::class, 'parent_category');
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
            ]
        ];
    }

    public function categoryList()
    {
        return $this->belongsTo(\App\Models\Sections::class,'sections_id');
    }


    public function posts(){
       return $this->hasMany(\App\Models\Post::class); 
    }
    public function items()
    {
        return $this->belongsToMany(Article::class);
    } 
  
}