<?php

namespace App\Models;

class Product extends BaseModel
{
    protected $fillable = [
        'category_id',
        'discount_id',
        'campaign_id',
        'name',
        'price',
        'image',
        'description',
        'status',
        'priority',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * Get the categories that owns the product.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the discount that owns the product.
     */
    public function discount()
    {
        return $this->belongsTo(Discount::class);
    }
}
