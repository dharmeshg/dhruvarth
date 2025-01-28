<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;
use Cviebrock\EloquentSluggable\Sluggable;


class GalleryCategory extends Model
{
    use HasApiTokens,HasFactory, Notifiable, SoftDeletes, Userstamps, sluggable;

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

     protected $table = 'gallery_categories';
    protected $fillable = [
        'category',
        'slug',
        'parent_category',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
            ]
        ];
    }

    public function subcategory()
    {
        return $this->hasMany(\App\Models\GalleryCategory::class, 'parent_category');
    }
}
