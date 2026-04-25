<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'email',
        'city_id',
        'address',
        'status',
        'rating',
        'notes'
    ];


    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function reviews()
{
    return $this->hasMany(Review::class);
}
}
