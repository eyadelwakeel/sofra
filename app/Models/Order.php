<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    
    protected $fillable = [
        'restaurant_id',
        'user_id',
        'customer_name',
        'customer_phone',
        'customer_email',
        'city_id',
        'customer_address',
        'requested_price',
        'delivery_fee',
        'total_price',
        'status',
        'notes'
    ];

    // العلاقات

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class , 'order_id');
    }

    public function items()
    {
        return $this->belongsToMany(Item::class, 'order_items')
            ->withPivot(['quantity', 'price', 'notes'])
            ->withTimestamps();
    }
}
