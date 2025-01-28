<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;
use Wildside\Userstamps\Userstamps;





class ProjectGallery extends Model
{
    use HasFactory, SoftDeletes, Sluggable, Userstamps;

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

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'title',
        'slug',
        'is_publish',
        'description',
        'featured_img',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
            ]
        ];
    }
    

}
