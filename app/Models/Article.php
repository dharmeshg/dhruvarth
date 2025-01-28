<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;
use Illuminate\Support\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;

class Article extends Model
{
    use HasFactory, SoftDeletes, Sluggable;
    use Userstamps;
    public $timestamps = true;
    protected $userstamps = [
       'created_by' => 'created_by', 
       'updated_by' => 'updated_by',
       'deleted_by' => 'deleted_by',
   ];

    protected $fillable = [
        'title',
        'slug',
        'short_description',
        'content',
        'category_id',
        'tag_id',
        'published_at',
        'is_featured',
        'image',
        'author',
        'visibility',
        'password',
        'meta_title',
        'meta_keyword',
        'meta_description',
        'format',
        'status',
        'publish_status',   
    ];

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y/m/d');
    }
    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y/m/d');
    }
    public function category($id)
    {
        $category_ids = explode(',',$id);
        $html = '';
        for($i = 0; $i < count($category_ids); $i++){
            $cat = Category::where('id',$category_ids[$i])->first();
            if(isset($cat)){
                $html.= $cat->category;
            }
            if($i != (count($category_ids) - 1)){
                $html.= ', ';
            }
            // $html. = $cat;
        }
        return $html;
    }
    public function getCategoriesAttribute()
    {
        $categoryIds = explode(',', $this->category_id);
        $categories = Category::whereIn('id', $categoryIds)->get();
        return $categories->pluck('category')->implode(', ');
    }
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
            ]
        ];
    }

    public function author_name()
    {
        return $this->belongsTo(User::class, 'author');
    }
}
