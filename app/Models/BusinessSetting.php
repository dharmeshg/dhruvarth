<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;
use Illuminate\Support\Carbon;

class BusinessSetting extends Model
{
    use HasFactory;
    use Userstamps;
    public $timestamps = true;
    protected $userstamps = [
       'created_by' => 'created_by', 
       'updated_by' => 'updated_by',
   ];
   protected $fillable = [
        'business_name',
        'business_logo',
        'business_favicon',
        'theme_color',
        'defalt_color',
        'business_nature',
        'business_currency',
        'primary_category',
        'secondary_category',
        'ios_link',
        'android_link',
        'email',
        'whatsapp_number',
        'country_code',
        'street',
        'street2',
        'area',
        'country',
        'state',
        'city',
        'pincode',
        'youtube_video',
        'website_link',
        'facebook_link',
        'linkedin_link',
        'pinterest_link',
        'twitter_link',
        'insta_link',
        'youtube_link',
        'instore_link',
        'monday',
        'tuesday',
        'wedsday',
        'thursday',
        'friday',
        'sat',
        'sun',
        'country_code_number',
        'intro_sec',
        'buy_desc',
        'buy_icons',
        'buy_sec_title',
    ];

}
