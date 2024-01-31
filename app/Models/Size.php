<?php

namespace App\Models;

class Size extends BaseModel
{
    // status
    public const STATUS_ACTIVE = 1;
    public const STATUS_DISACTIVE = 0;

    public static $statuses = [
        self::STATUS_ACTIVE => 'Đang hoạt động',
        self::STATUS_DISACTIVE => 'Không hoạt động'
    ];

    protected $fillable = [
        'name',
        'status'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
