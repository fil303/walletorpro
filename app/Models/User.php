<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\UserRole;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\URL;
use App\Notifications\MustEmailVerify;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;


/**
 * This is User Modal
 * 
 * @property UserRole $role
 * @property string $password
 * 
 */
class User extends Authenticatable implements MustEmailVerify
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "uid", "first_name", "last_name", "name", "username", "email", "role", "role_id", "country",
        "phone", "phone_verified_at", "email_verified_at", "email_token", "phone_token", "password",
        "image", "language", "status", "last_login", "password_reset_token", "google_2fa_secret","google_2fa",
        "email_2fa","phone_2fa","pin_code"
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
        'phone_verified_at' => 'datetime',
        'password' => 'hashed',
        'role'  => UserRole::class
    ];

    public function setAttribute($key, $value)
    {
        if ($key === 'role' && ! UserRole::tryFrom($value)) {
            $value = UserRole::USER;
        }
        return parent::setAttribute($key, $value);
    }

    /**
     * Generate New OTP Code
     * @return bool
     */
    public function generateNewTwoFactorPin(): bool
    {
        $this->pin_code = rand(111111, 999999);
        return $this->save();
    }

    /**
     * Get User Phone Number With Country Code
     * @return string
     */
    public function phone_number(): string
    {
        $country = ucwords($this->country);

        /** @var string $dial_code */
        $dial_code= countries_dial_code($country);
        return "$dial_code$this->phone";
    }

    public function getImage(): string
    {
        return $this->image
            ? asset_bind(Storage::url($this->image))
            : asset_bind(Storage::url("profile/user.png"));
    }
}
