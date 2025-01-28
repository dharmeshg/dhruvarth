<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;
use Illuminate\Support\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;

class Updatelog extends Model
{
    use HasFactory, SoftDeletes, Sluggable;
    use Userstamps;
    public $timestamps = true;
    protected $userstamps = [
       'created_by' => 'created_by', 
   ];

    protected $fillable = [
        'tablename',
        'table_primary_id',
        'edit_log'
    ];
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
            ]
        ];
    }

}
