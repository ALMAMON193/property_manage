<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{

    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'salutation',
        'first_name',
        'last_name',
        'company_name',
        'legal_status',
        'email',
        'phone',
        'image',
        'password',
        'user_type',
        'email_verified_at',
        'provider',
        'provider_id',
        'date_of_birth',
        'place_of_birth',
        'address_line_1',
        'address_line_2',
        'country',
        'city',
        'postal_code',
        'is_verified',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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


    public function isOtpExpired()
    {
        return $this->otp_expires_at && Carbon::now()->gt($this->otp_expires_at);
    }

    public function contact()
    {
        return $this->hasOne(Contact::class);
    }

    public function bankDetail()
    {
        return $this->hasOne(BankDetail::class);
    }

    // Add the required JWT methods
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
