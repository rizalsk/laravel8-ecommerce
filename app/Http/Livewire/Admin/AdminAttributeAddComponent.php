<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Attribute;

class AdminAttributeAddComponent extends Component
{
    public $name;

    protected $rules = [
        'name'   => 'required',
    ];

    public function store(){
        $this->validate();

        try {
            $attribute = new Attribute();
            $attribute->name = $this->name;
            $attribute->save();
            $this->dispatchBrowserEvent('toastr:success',[
                'message' => 'Attribute has been created successfully!'
            ]);
            return redirect()->route('admin.attributes.edit', $attribute->id);
        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('toastr:error',[
                'message' => 'Duplicate Entry'
            ]);
        }
    }

    public function render()
    {
        return view('livewire.admin.admin-attribute-add-component')
            ->layout('layouts.admin.base')
            ->layoutData([
                'title' => 'New Attribute',
                'breadcrumbs' => [
                    'master'        => [
                        'title' => 'Dahboard',
                        'link' => route('admin.dashboard'),
                    ],
                    'attributes'        => [
                        'title' => 'Categories',
                        'link' => route('admin.attributes'),
                    ],
                    'newattributes'        => [
                        'title' => 'New User Attribute',
                        'link' => '',
                    ],
                    
                ],
                'nav' => [
                    'attributes'        => 'active',
                ]
            ]);
    }
}
