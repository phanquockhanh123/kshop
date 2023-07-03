<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Admin extends BaseModel implements Authenticatable
{
    use HasApiTokens;
    use AuthenticatableContract;

    

    // gender
    public const GENDER_MALE = 0;
    public const GENDER_FEMALE = 1;
    public const GENDER_OTHER = 2;

    public static $genders = [
        self::GENDER_MALE => 'Nam',
        self::GENDER_FEMALE => 'Nữ',
        self::GENDER_OTHER => 'Khác',
    ];

    // status
    public const STATUS_ACTIVE = 1;
    public const STATUS_DEACTIVATED = 0;

    public static $status = [
        self::STATUS_ACTIVE => 'Đang hoạt động',
        self::STATUS_DEACTIVATED => 'Đã vô hiệu',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'name',
        'gender',
        'date_of_birth',
        'email_address',
        'telephone',
        'password',
        'status',
        'first_login_flag',
        'refresh_token',
        'refresh_token_expired_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    protected $dates = [
        'date_of_birth',
        'refresh_token_expired_at',
        'date_of_birth',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}