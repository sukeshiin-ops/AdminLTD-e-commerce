<?php

namespace App\Models;

use App\Models\VariantAttribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    protected $fillable = [
        'variant_id',
        'quantity'
    ];

    use HasFactory;



    public function product()
    {
        return $this->belongsTo(Product::class);
    }


    public function attributes()
    {
        return $this->hasMany(VariantAttribute::class, 'variant_id');
    }

    public function inventory()
    {
        return $this->hasOne(ProductInventory::class, 'variant_id');
    }
}
