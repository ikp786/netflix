<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Passport\HasApiTokens;

use App\Models\Category;
use App\Models\Specialist; 

use Spatie\Permission\Traits\HasRoles;
use DB;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'country',
        'country_code',
        'country_flag_code',
        'phone',
        'concated_phone',
        'is_term_accept',
        'owner_business_type',
        'phone_verified_at',
        'profile_photo_path',
        'subscription_status',
        'status',
        'push_notification_status',
        'password',
        'role_id', 
        'verify_code',
        'device_token',
        'device_type',
        'facebook_id',
        'google_id',
        'latitude',
        'longitude'
    ];
 
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];
 
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
   
    public function getUserRole()
    {
        $getResult = Role::where('id',$this->role_id)->first();

        return $getResult;
    }

    public function getRoleNames()
    {
        $getResult = Role::where('id',$this->role_id)->first();

        return $getResult;
    }
  
}
 