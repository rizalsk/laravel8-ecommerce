<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Category;
use App\Models\Attribute;
use App\Models\CategoryAttribute;
use Illuminate\Support\Str;

class AdminCategoryEditComponent extends Component
{
    public $original;

    public $parent_id;
    public $name;
    public $slug;
    public $category;
    public $attributes;

    public $updateCategory = false;
    public $search = false;

    public $exit = false;

    protected $rules = [
        'name'   => 'required',
        'slug' => 'required',
    ];

    public $attr;
    public $inputs = [];
    public $attribute_arr = [];
    public $attribute_values = [];
    
    public $selectedAttributes = [];
    
    protected $listeners = [
        'selectedAttributeItem',
    ];

    public function hydrate()
    {
        $this->emit('select2');
    }

    public function mount($slug){
        $this->slug = $slug;
        $category = $this->original = $this->category = Category::where('slug', $slug)->firstOrFail();
        $this->parent_id = $category->parent_id;
        $this->name = $category->name;
        $this->selectedAttributes = $selectedAttributes = $category->attributes()->pluck('attributes.id')->toArray();
    }
    
    public function render()
    {
        $attributes = $this->attributes = Attribute::orderBy('name', 'asc')->get();
        return view('livewire.admin.admin-category-edit-component', [
            //whereNull('parent_id')->
            'categories' => Category::where('id','!=',$this->category->id)->latest()->get(),
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
                    'title' => 'Edit Category',
                    'link' => '',
                ],
                
            ],
            'nav' => [
                'master'        => 'active',
                'categories'    => 'active'
            ]
        ]);
    }

    public function resetFields(){
        $this->parent_id = '';
        $this->name = '';
        $this->slug = '';
    }

    public function generateSlug(){
        $this->slug = Str::slug($this->name);
    }

    public function edit($slug){
        $category = Category::where('slug', $slug)->firstOrFail();;
        $this->name = $category->name;
        $this->description = $category->description;
        $this->category_id = $category->id;
        $this->updateCategory = true;
    }

    public function cancel()
    {
        $this->updateCategory = false;
        $this->resetFields();
    }

    public function update(){

        // Validate request
        $this->validate();

        try{
            // Update category
            $category = Category::where('slug', $this->category->slug )->first();

            $category->update([
                'name' => $this->name,
                'slug' => $this->slug,
                'parent_id' => $this->parent_id
            ]);

            if(count($this->selectedAttributes) > 0){

                CategoryAttribute::where('category_id', $this->category->id)->delete();
                foreach ($this->selectedAttributes as $key => $value) {
                    $catAttribute = new CategoryAttribute();
                    $catAttribute->category_id = $this->category->id;
                    $catAttribute->attribute_id = $value;
                    $catAttribute->save();
                }
            }

            $this->dispatchBrowserEvent('toastr:success',[
                'message' => 'Category has been Updated successfully!'
            ]);

            session()->flash('success','Category Updated Successfully!!');

        }catch(\Throwable $th){
            $this->dispatchBrowserEvent('toastr:error',[
                'message' => $th->getMessage()
            ]);
        }
    }
}
