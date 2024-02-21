<?php

namespace App\Models;

class StoreInfo extends BaseModel
{
    protected $fillable = [
        'name',
        'phone',
        'address',
        'country',
        'province',
        'district',
        'wards',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
