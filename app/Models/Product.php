<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    const PENDING = 'pending';
    const PUBLISHED = 'published';

    protected $casts = [
        'unit_and_price'       => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getPriceAttribute()
    {
        return '$' . number_format((float) $this->unit_and_price['price'], 2);
    }

    public function getTitleAttribute()
    {
        return $this->name . ' ' . $this->unit_and_price['unit'];
    }

    public function getActualPriceAttribute()
    {
        return number_format((float) $this->unit_and_price['price'], 2);
    }

    public function scopeIsPublished($query)
    {
        return $query->where('status', self::PUBLISHED);
    }

    public function scopeIsPending()
    {
        return $this->status == self::PENDING;
    }
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
