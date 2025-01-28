<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'website',
        'role',
        'password',
        'country_code_number',
        'approval',
        'access',
        'start_date',
        'end_date',
        'site_access_start_date',
        'site_access_start_time',
        'site_access_end_date',
        'site_access_end_time',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function hasProductAccess()
    {
        if ($this->product_access == 0) {
            return true;
        }
        $currentDate = Carbon::now()->format('m/d/Y');
        $currentTime = Carbon::now()->format('H:i');
        // Check if the current date and time fall within the user's access period
        return $this->product_access == 1 &&
               $this->start_date <= $currentDate &&
               $this->end_date >= $currentDate &&
               $this->start_time <= $currentTime &&
               $this->end_time >= $currentTime;
    }
    
    public function user_order()
    {
        return $this->hasMany('App\Models\Order', 'user_id', 'id');
    }

    public static function check_user_login($email,$mobile)
    {

                    $query = User::withTrashed();

                    if (!empty($email)) {
                        $query->where('email', $email);
                    }

                    if (!empty($mobile)) {
                        $query->orWhere('phone', $mobile);
                    }

                    $collection = $query->get(); 

        return $collection;
    }
}
