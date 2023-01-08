<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\CategoryAttribute;

class AdminCategoryAttributeEditComponent extends Component
{
    public $name;
    public $attribute_id;
    public $categoryAttribute;

    protected $rules = [
        'name'   => 'required',
    ];

    public function mount($id){
        $this->categoryAttribute = $attribute = CategoryAttribute::findOrFail($id);
        $this->name = $attribute->name;
        $this->attribute_id = $attribute->id;
    }

    public function saveAndExit(){
        $this->update();
        return redirect()->route('admin.categoryattributes');
    }

    public function update(){

        // Validate request
        $this->validate();

        try{
            // Update category
            $categoryAttribute = CategoryAttribute::find($this->attribute_id);
            $categoryAttribute->update([
                'name' => $this->name
            ]);

            $this->dispatchBrowserEvent('toastr:success',[
                'message' => 'Attribute has been Updated successfully!'
            ]);    
            session()->flash('success','Attribute Updated Successfully!!');

        }catch(\Throwable $th){
            $this->dispatchBrowserEvent('toastr:error',[
                'message' => $th->getMessage()
            ]);
        }
    }

    public function render()
    {
        return view('livewire.admin.admin-category-attribute-edit-component')
        ->layout('layouts.admin.base')
            ->layoutData([
                'title' => 'Edit User Attribute',
                'breadcrumbs' => [
                    'master'        => [
                        'title' => 'Dahboard',
                        'link' => route('admin.dashboard'),
                    ],
                    'categoryattributes'        => [
                        'title' => 'Attribute',
                        'link' => route('admin.categoryattributes'),
                    ],
                    'editattributes'        => [
                        'title' => 'Edit User Attribute',
                        'link' => '',
                    ],
                    
                ],
                'nav' => [
                    'categoryattributes'        => 'active',
                ]
            ]);
    }
}
