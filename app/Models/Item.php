<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'restaurant_id',
        'name',
        'description',
        'price',
        'preparation_time',
        'notes'
    ];


    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class , 'item_id');
    }

    public function orders()
{
    return $this->belongsToMany(Order::class, 'order_items');
}
}