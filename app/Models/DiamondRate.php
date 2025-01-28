<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\SoftDeletes;

class DiamondRate extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $userstamps = [
        'created_by' => 'created_by', 
        'updated_by' => 'updated_by',
        'deleted_by' => 'deleted_by',
    ];
    public function type()
    {
        return $this->belongsTo(\App\Models\DynamicDiamondType::class, 'type');
    }
}
