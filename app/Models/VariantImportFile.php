<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class VariantImportFile extends Model
{
    use HasFactory, SoftDeletes, Userstamps;
    public $timestamps = true;
    public $table = 'variant_import_files';
    protected $fillable = ['file_name','completed_file','invalid_file','updated_file','status','publish_status','progress'];
    protected $userstamps = [
       'created_by' => 'created_by', 
       'updated_by' => 'updated_by',
       'deleted_by' => 'deleted_by',
   ];
}
