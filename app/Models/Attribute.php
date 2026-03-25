<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    public $guarded = [];
    use HasFactory;

    public function AttributeValue(){
        return $this->hasMany(AttributeValue::class);
    }

    
}
