<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Laravel\Fortify\TwoFactorAuthenticatable;
// use Laravel\Jetstream\HasProfilePhoto;
// use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable;
    // use HasApiTokens;
    // use HasFactory;
    // use HasProfilePhoto;
    // use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','class_user' ,'avatar', 'ban_status' , 'username' ,'surname','address',
        'tel','alias','sid','address_full','subdistric','distric','province','zipcode','social_id',
        'social_type','check_repass','bank_name','bank_no','bank_acc','bank_type','bank_branch','bank_file','sex','birthday','approve_consignment' ,
        'name_send' , 'phone_send'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function getPayment()
    {
        return $this->hasOne(Payment::class,'id' ,'bank_name');
    }
}
