<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Str;

class AdminCategoryEditComponent extends Component
{
    public $original;

    public $parent_id;
    public $name;
    public $slug;
    public $category;
    public $updateCategory = false;
    public $search = false;


    public $exit = false;

    protected $rules = [
        'name'   => 'required',
        'slug' => 'required',
    ];

    protected $listeners = ['deleteCategory'=>'destroy'];

    public function mount($slug){
        $this->slug = $slug;
        $category = $this->original = $this->category = Category::where('slug', $slug)->firstOrFail();
        $this->parent_id = $category->parent_id;
        $this->name = $category->name;
    }

    public function render()
    {
        return view('livewire.admin.admin-category-edit-component', [
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
            Category::where('slug', $this->category->slug )->update([
                'name' => $this->name,
                'slug' => $this->slug,
                'parent_id' => $this->parent_id
            ]);

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
