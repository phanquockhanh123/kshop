<?php

namespace App\Models;

class ProductInfos extends BaseModel
{
    protected $fillable = [
        'product_id',
        'size_id',
        'color_id',
        'quantity',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * Get the product that owns the product.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the size that owns the product.
     */
    public function size()
    {
        return $this->belongsTo(Size::class);
    }

    /**
     * Get the color that owns the product.
     */
    public function color()
    {
        return $this->belongsTo(Color::class);
    }
}
