<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //order states
    const PENDING = 'pending';
    const COMPLETED = 'completed';
    const ORDER_RECEIVED = 'received';
    const ORDER_IN_PROCESS = 'order_in_process';
    const DELIVERY_IN_PROGRESS = 'delivery_in_progress';
    const PACKAGE_DELIVERED = 'package_delivered';

    const DELIVERY_FEE = 10;

    const MIN_SERVICE_FEE = 0.12;
    const MAX_SERVICE_FEE = 0.10;

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeIsPending($query)
    {
        return $query->where('status', '!=', self::PACKAGE_DELIVERED);
    }

    public function getDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }
}
