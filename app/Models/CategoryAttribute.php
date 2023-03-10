<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryAttribute extends Model
{
    use HasFactory;
    protected $table = 'category_attributes';
    protected $guarded = [];

    public function productAttributeValues(){
        return $this->hasMany( ProductAttributeValue::class );
    }

    public function attribute(){
        return $this->belongsTo( Attribute::class );
    }

    public function category(){
        return $this->belongsTo( Category::class );
    }
}
