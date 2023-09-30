<?php

namespace App\Models;

class Discount extends BaseModel
{
    // status
    public const STATUS_ACTIVE = 1;
    public const STATUS_DISACTIVE = 0;

    public static $statuses = [
        self::STATUS_ACTIVE => 'Đang hoạt động',
        self::STATUS_DISACTIVE => 'Không hoạt động'
    ];

    // discount type
    public const DISCOUNT_TYPE_PERCENT = '%';
    public const DISCOUNT_TYPE_VND = 'VND';
    public const DISCOUNT_TYPE_USD = 'USD';

    public static $discountType = [
        self::DISCOUNT_TYPE_PERCENT => '%',
        self::DISCOUNT_TYPE_VND => 'VND',
        self::DISCOUNT_TYPE_USD => 'USD',
    ];

    protected $fillable = [
        'discount_code',
        'discount_type',
        'discount_value',
        'start_date',
        'end_date',
        'status'
    ];

    protected $dates = [
        'start_date',
        'end_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
