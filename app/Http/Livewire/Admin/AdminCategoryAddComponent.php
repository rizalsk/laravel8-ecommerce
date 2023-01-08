<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Category;
use App\Models\Attribute;
use App\Models\CategoryAttribute;
use Illuminate\Support\Str;

class AdminCategoryAddComponent extends Component
{
    public $parent_id;
    public $name;
    public $slug;

    public $selectedAttributes = [];
    
    protected $listeners = [
        'selectedAttributeItem',
    ];

    public function hydrate()
    {
        $this->emit('select2');
    }

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

            if(count($this->selectedAttributes) > 0){

                CategoryAttribute::where('category_id', $category->id)->delete();
                foreach ($this->selectedAttributes as $key => $value) {
                    $catAttribute = new CategoryAttribute();
                    $catAttribute->category_id = $category->id;
                    $catAttribute->attribute_id = $value;
                    $catAttribute->save();
                }
            }

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
        $attributes = $this->attributes = Attribute::orderBy('name', 'asc')->get();
        return view('livewire.admin.admin-category-add-component',[
            'categories' => Category::whereNull('parent_id')->latest()->get(),
            'attributes' => $attributes
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
