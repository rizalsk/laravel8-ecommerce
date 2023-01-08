<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Category;

class HomeComponent extends Component
{
    public function render()
    {
        $categories = Category::with('products')->whereHas('products')->limit(6)->get();
        return view('livewire.home-component', [
            'categories' => $categories
        ])->layout('layouts.base')
        ->layoutData([
            'home_icon' => 'home-icon',
        ]);
    }
}
