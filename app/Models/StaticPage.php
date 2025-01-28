<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;
use Illuminate\Support\Carbon;

class StaticPage extends Model
{
    use HasFactory, SoftDeletes;


    protected $fillable = [
        'page',
        'content',
    ];



}
