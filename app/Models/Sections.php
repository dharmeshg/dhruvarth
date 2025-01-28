<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;
use App\Models\Category;



class Sections extends Model
{
    use HasFactory, SoftDeletes, Sluggable;

    protected $dates = ['deleted_at'];

    protected $table = 'sections';
    protected $fillable = [
        'title',
        'slug',
        'description',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
            ]
        ];
    }

    public function student()
    {
        return $this->belongsToMany(Category::class, 'sections_id');
    }

  
}
