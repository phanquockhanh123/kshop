<?php

namespace App\Models;

class Product extends BaseModel
{
    protected $fillable = [
        'category_id',
        'name',
        'price',
        'description',
        'status'
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
}
