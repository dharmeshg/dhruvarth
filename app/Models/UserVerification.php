<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserVerification extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'user_verification';
    protected $dates = ['deleted_at'];
  
    protected $fillable = [
        'user_verification_email',
        'user_verification_code',
        'login_email_otp',
        'add_date',
    ];
}
