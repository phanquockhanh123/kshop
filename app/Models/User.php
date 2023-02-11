<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    // role
    public const ROLE_MEMBER = 0;
    public const ROLE_PATIENT = 1;
    public const ROLE_CASE_HANDLER = 2;
    public const ROLE_RECEPTIONIST = 3;
    public const ROLE_PHARMACIST = 4;
    public const ROLE_NURSE = 5;
    public const ROLE_DOCTOR = 6;
    public const ROLE_ADMIN_ROOT = 7;

    public static $roles = [
        self::ROLE_MEMBER => 'Member',
        self::ROLE_PATIENT => 'Patient',
        self::ROLE_CASE_HANDLER => 'Case Handler',
        self::ROLE_RECEPTIONIST => 'Receptionist',
        self::ROLE_PHARMACIST => 'Pharmacist',
        self::ROLE_NURSE => 'Admin nurse',
        self::ROLE_DOCTOR => 'Admin doctor',
        self::ROLE_ADMIN_ROOT => 'Admin root',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'role',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
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
}
