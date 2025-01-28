<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class Menu_list extends Model
{
    use HasFactory, Userstamps;

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
        'menus_id',
        'name',
        'slug',
        'parent_id',
    ];

    public function children()
    {
        return $this->hasMany(Menu_list::class, 'parent_id');
    }
   
}
