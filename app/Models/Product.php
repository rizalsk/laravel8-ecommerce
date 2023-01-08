<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';

    public function category(){
        return $this->belongsTo( \App\Models\Category::class, 'category_id');
    }

    public function attributeValues(){
        return $this->hasMany( \App\Models\ProductAttributeValue::class, 'product_id');
    }
}
