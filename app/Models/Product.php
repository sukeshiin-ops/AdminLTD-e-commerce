<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    public $guarded = [];

    public function categories_rel()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }






    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'product_id');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function orders()
    {
        return $this->belongsToMany(
            Order::class,
            'order_details',
            'product_id',
            'order_id'
        );
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    // Product.php
    // public function inventory()
    // {
    //     return $this->hasOne(ProductInventory::class, 'product_id');
    // }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class, 'product_id');
    }

    public function productVariant()
    {
        return $this->hasMany(ProductVariant::class);
    }
}
