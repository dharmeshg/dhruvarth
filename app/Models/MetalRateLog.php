<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\SoftDeletes;

class MetalRateLog extends Model
{
    use HasFactory;
    public $timestamps = true;
     protected $userstamps = [
        'created_by' => 'created_by', 
        'updated_by' => 'updated_by',
        'deleted_by' => 'deleted_by',
    ];
    public function metal_purity()
    {
        return $this->belongsTo(\App\Models\MetalPurity::class, 'purity');
    }
}
