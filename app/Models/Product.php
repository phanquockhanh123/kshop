<?php

namespace App\Models;

class Product extends BaseModel
{
    // status
    public const STATUS_ACTIVE = 1;
    public const STATUS_DISACTIVE = 0;

    public static $statuses = [
        self::STATUS_ACTIVE => 'Đang hoạt động',
        self::STATUS_DISACTIVE => 'Không hoạt động'
    ];

    protected $fillable = [
        'category_id',
        'discount_id',
        'campaign_id',
        'name',
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
     * Get the productInfos that owns the product.
     */
    public function productInfos()
    {
        return $this->hasMany(ProductInfos::class);
    }

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
