<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\ResetPasswordCustom;

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
        'password',
        'is_active',
        'provider',
        'provider_id'
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

    public function cart(){
        return $this->hasOne(Cart::class);
    }

    public function sendPasswordResetNotification($token){
        $this->notify(new ResetPasswordCustom($token));
    }
    
    public function shippingAddresses(){
        return $this->hasMany(ShippingAddress::class);
    }

    public function wishlists(){
        return $this->hasMany(Wishlist::class);
    }


}
