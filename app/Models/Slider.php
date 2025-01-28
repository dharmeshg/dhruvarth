<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class Slider extends Model
{
    use HasFactory, SoftDeletes, Userstamps;

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
        'sub_title',
        'url',
        'btn_name',
        'description',
        'image',
        'status',
    ];
   
}
