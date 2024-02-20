<?php

namespace App\Models;

class Campaign extends BaseModel
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

    protected $fillable = [
        'name',
        'image',
        'start_date',
        'end_date',
        'status',
        'campaign_budget',
        'campaign_description'
    ];

    protected $dates = [
        'start_date',
        'end_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
