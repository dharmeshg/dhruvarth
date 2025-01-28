<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Video extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'title','url','path','short_description','content','section_id','category_id','tag_id','published_at','is_featured','author'
    ];
}
