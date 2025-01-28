<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactUsSetting extends Model
{
    use HasFactory;
     protected $fillable = ['title','address_line_1','address_line_2','country','state','city','pincode','first_name','last_name','phone_number','country_code','alt_number','email','alt_email','status','country_number','phone_numbers','w_numbers'];
}
