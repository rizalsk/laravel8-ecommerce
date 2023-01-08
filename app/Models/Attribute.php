<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;

    use HasFactory;
    protected $table = 'attributes';
    protected $guarded = [];

    public function attributes()
    {
        return $this->belongsToMany(Category::class, 'category_attributes',
        'category_id', 'attribute_id');
    }

    public function productAttributeValues(){
        return $this->hasMany( ProductAttributeValue::class );
    }

}
