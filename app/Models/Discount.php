<?php

namespace App\Models;

class Discount extends BaseModel
{
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
