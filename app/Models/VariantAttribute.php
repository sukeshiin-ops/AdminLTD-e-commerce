<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VariantAttribute extends Model
{
    protected $table = 'variant_attributes'; 
    public $guarded = [];
    public $timestamps = false;


    public function attributeValue()
    {
        return $this->belongsTo(AttributeValue::class, 'attribute_value_id');
    }

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }


    public function attribute()
    {
        return $this->belongsTo(Attribute::class, 'attribute_id');
    }
}
