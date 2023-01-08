<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Str;

class AdminCategoryAddComponent extends Component
{
    public $parent_id;
    public $name;
    public $slug;

    public function generateSlug(){
        $this->slug = Str::slug($this->name);
    }

    public function store(){
        $this->validate([
            'name'   => 'required',
            'slug' => 'required',
        ]);

        try {
            $category = new Category();
            $category->name = $this->name;
            $category->slug = $this->slug;
            $category->parent_id = $this->parent_id == '' ? null : $this->parent_id;
            $category->save();
            session()->flash('message','Category has been created successfully!');
            $this->dispatchBrowserEvent('toastr:success',[
                'message' => 'Category has been created successfully!'
            ]);
            return redirect()->route('admin.categories.edit', $category->slug);
        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('toastr:error',[
                'message' => 'Duplicate Entry'
            ]);
        }
    }

    public function render()
    {
        return view('livewire.admin.admin-category-add-component',[
            'categories' => Category::whereNull('parent_id')->latest()->get()
        ])
        ->layout('layouts.admin.base')
        ->layoutData([
            'title' => 'New Categories',
            'breadcrumbs' => [
                'master'        => [
                    'title' => 'Dahboard',
                    'link' => route('admin.dashboard'),
                ],
                'categories'        => [
                    'title' => 'Categories',
                    'link' => route('admin.categories'),
                ],
                'newcategories'        => [
                    'title' => 'New Category',
                    'link' => '',
                ],
                
            ],
            'nav' => [
                'master'        => 'active',
                'categories'    => 'active'
            ]
        ]);
    }
}
