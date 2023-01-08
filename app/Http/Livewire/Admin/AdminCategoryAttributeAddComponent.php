<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\CategoryAttribute;

class AdminCategoryAttributeAddComponent extends Component
{
    public $name;

    protected $rules = [
        'name'   => 'required',
    ];

    public function store(){
        $this->validate();

        try {
            $attribute = new CategoryAttribute();
            $attribute->name = $this->name;
            $attribute->save();
            $this->dispatchBrowserEvent('toastr:success',[
                'message' => 'Attribute has been created successfully!'
            ]);
            return redirect()->route('admin.categoryattributes.edit', $attribute->id);
        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('toastr:error',[
                'message' => 'Duplicate Entry'
            ]);
        }
    }

    public function render()
    {
        return view('livewire.admin.admin-category-attribute-add-component',[
        ])
        ->layout('layouts.admin.base')
        ->layoutData([
            'title' => 'New Attribute',
            'breadcrumbs' => [
                'master'        => [
                    'title' => 'Dahboard',
                    'link' => route('admin.dashboard'),
                ],
                'categoryattributes'        => [
                    'title' => 'Categories',
                    'link' => route('admin.categoryattributes'),
                ],
                'newattributes'        => [
                    'title' => 'New User Attribute',
                    'link' => '',
                ],
                
            ],
            'nav' => [
                'categoryattributes'        => 'active',
            ]
        ]);
    }
}
