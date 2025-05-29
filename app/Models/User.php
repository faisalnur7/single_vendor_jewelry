<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    const ACTIVE = 1;
    const INACTIVE = 0;

    // User Type
    const ADMIN = 1;
    const CUSTOMER = 3;

    // Affiliate type
    const GENERAL = 1;
    const PRIME = 2;

    const PRIME_VERIFIED_STATUS_REF_INCOMPLETED = 0;
    const PRIME_VERIFIED_STATUS_VERIFIED        = 1;
    const PRIME_VERIFIED_STATUS_POSTAL_ASSIGN   = 2;
    const PRIME_VERIFIED_STATUS_NOMINEE         = 3;
    const PRIME_VERIFIED_STATUS_PACKAGE         = 4;
    const PRIME_VERIFIED_STATUS_PAYMENT         = 5;
    const PRIME_VERIFIED_STATUS_COMPLETED       = 6;

    const PRIME_STATUS = [
        'Reference'             => self::PRIME_VERIFIED_STATUS_VERIFIED,
        'Postal Info'           => self::PRIME_VERIFIED_STATUS_POSTAL_ASSIGN,
        'Nominee'               => self::PRIME_VERIFIED_STATUS_NOMINEE,
        'Package'               => self::PRIME_VERIFIED_STATUS_PACKAGE,
        'Payment'               => self::PRIME_VERIFIED_STATUS_PAYMENT,
    ];


    const USER_TYPES = [
        'Admin' => self::ADMIN,
        'Customer' => self::CUSTOMER
    ];

    const AFFILIATE_TYPES = [
        'General' => self::GENERAL,
        'Prime' => self::PRIME
    ];

    const USER_PACKAGE_INACTIVE = 0;
    const USER_PACKAGE_ACTIVE = 1;
    const USER_PACKAGE_PENDING = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'is_active',
        'phone_verified_at',
        'user_type',
        'user_affiliate_type',
        'reference_id',
        'reference_user_id',
        'district_id',
        'police_station_id',
        'post_office_id',
        'postal_code'
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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function kyc(){
        return $this->hasOne(Kyc::class,'user_id');
    }

    public function prime_request(){
        return $this->hasOne(PrimeRequest::class,'requester_id');
    }

    public function district(){
        return $this->belongsTo(District::class,'district_id');
    }

    public function police_station(){
        return $this->belongsTo(PoliceStation::class,'police_station_id');
    }

    public function post_office(){
        return $this->belongsTo(PostOffice::class,'post_office_id');
    }

    public function nominee(){
        return $this->hasOne(NomineeInfo::class,'user_id');
    }

    public function packages(){
        return $this->belongsToMany(
            SubscriptionPackage::class,
            'package_users',              // correct pivot table
            'user_id',                    // foreign key on pivot pointing to users
            'subscription_package_id'     // foreign key on pivot pointing to subscription_packages
        )->withPivot([
            'id',
            'payment_option_id',
            'transaction_number',
            'transaction_mobile_number',
            'amount',
            'assigned_at',
            'expires_at',
            'status',
            'is_verified',
        ]);
    }
    

}
