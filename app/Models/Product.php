<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use phpDocumentor\Reflection\Types\This;

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
        return $this->name;
    }

    public function getActualPriceAttribute()
    {
        return number_format((float) $this->unit_and_price['price'], 2, '.', '');
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

    public function reviews()
    {
        return $this->hasMany(ProductReview::class, 'product_id', 'id')->latest();
    }

    public function getRateAttribute()
    {
        if($this->reviews()->count()){
            return number_format($this->reviews->sum('rate') / $this->reviews()->count(), 1);
        }
        return 0;
    }
}
