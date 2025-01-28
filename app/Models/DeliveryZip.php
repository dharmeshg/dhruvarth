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


class DeliveryZip extends Model
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

     protected $table = 'delivery_zips';
    protected $fillable = [
        'country',
        'state',
        'code',
        'city',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class, 'country');
    }
    public function get_state()
    {
        return $this->belongsTo(State::class, 'state');
    }
    public function get_city()
    {
        return $this->belongsTo(Citie::class, 'city');
    }
  
}