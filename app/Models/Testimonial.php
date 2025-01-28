<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;
use Illuminate\Support\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;

class Testimonial extends Model
{
    use HasFactory,SoftDeletes, Sluggable;
    use Userstamps;

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

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
            ]
        ];
    }
}
