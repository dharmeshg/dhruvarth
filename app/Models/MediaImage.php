<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

class MediaImage extends Model
{
    use HasFactory, SoftDeletes;
    use Userstamps;

    public $timestamps = true;
    protected $userstamps = [
       'created_by' => 'created_by', 
       'updated_by' => 'updated_by',
       'deleted_by' => 'deleted_by',
   ];

    protected $table = 'media_images';
   protected $fillable = [
       'name',
       'path',
       'extention',
       'type',
       'alt_text',
       'title',
       'caption',
       'description',
   ];

   public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y/m/d');
    }
    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y/m/d');
    }
}
