<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;
use Wildside\Userstamps\Userstamps;



class Tags extends Model
{
    use HasFactory, SoftDeletes, Sluggable;
    use Userstamps;

    protected $dates = ['deleted_at'];

    protected $table = 'tags';

    public $timestamps = true;

    protected $userstamps = [
        'created_by' => 'created_by', 
        'updated_by' => 'updated_by',
        'deleted_by' => 'deleted_by',
    ];
    protected $fillable = [
        'product_id',
        'name',
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
}
