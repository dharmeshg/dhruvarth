<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\SoftDeletes;

class SectionWidget extends Model
{
    use HasFactory, SoftDeletes, Userstamps;

    public $timestamps = true;
    protected $userstamps = [
       'created_by' => 'created_by', 
       'updated_by' => 'updated_by',
       'deleted_by' => 'deleted_by',
   ];
   public function widget()
    {
        return $this->belongsTo(Widget::class, 'widget_id');
    }
}
