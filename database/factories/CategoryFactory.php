<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Category;

class CategoryFactory extends Factory
{
    protected $model = Category::class;
    
    public function definition()
    {
        $category_name = $this->faker->unique()->words($nb=2, $asText = true);
        $slug = Str::slug($category_name);
        return [
            'name' => ucfirst($category_name),
            'slug' => $slug,
        ];
    }
}
