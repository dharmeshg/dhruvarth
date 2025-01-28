<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Wildside\Userstamps\Userstamps;
// use App\Models\Sections;


class DirectionLink extends Model
{
    use HasApiTokens,HasFactory, Notifiable, SoftDeletes;
    use Userstamps;
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

     protected $table = 'direction_link';
    protected $fillable = [
        'link',
    ];
  
}