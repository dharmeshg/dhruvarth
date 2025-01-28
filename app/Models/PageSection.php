<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class PageSection extends Model
{
    use HasFactory,SoftDeletes,Userstamps;

    public $timestamps = true;
    protected $userstamps = [
       'created_by' => 'created_by', 
       'updated_by' => 'updated_by',
       'deleted_by' => 'deleted_by',
   ];

   public function getWidgetBySequence($sequence)
    {
        return $this->widgets()->where('sequence', $sequence)->get();
    }

    public function widgets()
    {
        return $this->hasMany(SectionWidget::class, 'section_id')->orderBy('sequence');
    }
}
