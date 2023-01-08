<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Attribute;

class AdminAttributeEditComponent extends Component
{
    public $name;
    public $attribute_id;
    public $attribute;

    protected $rules = [
        'name'   => 'required',
    ];

    public function mount($id){
        $this->attribute = $attribute = Attribute::findOrFail($id);
        $this->name = $attribute->name;
        $this->attribute_id = $attribute->id;
    }

    public function saveAndExit(){
        $this->update();
        return redirect()->route('admin.attributes');
    }
    public function update(){

        // Validate request
        $this->validate();

        try{
            // Update attribute
            $attribute = Attribute::find($this->attribute_id);
            $attribute->update([
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
        return view('livewire.admin.admin-attribute-edit-component')
            ->layout('layouts.admin.base')
                ->layoutData([
                    'title' => 'Edit User Attribute',
                    'breadcrumbs' => [
                        'master'        => [
                            'title' => 'Dahboard',
                            'link' => route('admin.dashboard'),
                        ],
                        'attributes'        => [
                            'title' => 'Attribute',
                            'link' => route('admin.attributes'),
                        ],
                        'editattributes'        => [
                            'title' => 'Edit User Attribute',
                            'link' => '',
                        ],
                        
                    ],
                    'nav' => [
                        'attributes'        => 'active',
                    ]
                ]);
    }
}
