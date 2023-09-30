<?php

namespace App\Models;

class Campaign extends BaseModel
{
    protected $fillable = [
        'name',
        'thumb',
        'filepath',
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
