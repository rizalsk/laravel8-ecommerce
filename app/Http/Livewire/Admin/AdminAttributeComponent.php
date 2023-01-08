<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Attribute;

class AdminAttributeComponent extends Component
{
    use WithPagination;

    public $confirmed = false;

    protected $paginationTheme = 'tailwind';

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function confirmDelete($id)
    {
        $this->confirmed = $id;
    }

    public function destroy(Attribute $attribute){
        $attribute->delete();
        $this->dispatchBrowserEvent('toastr:success',[
            'message' => 'Attribute has been deleted successfully!'
        ]);
        $this->confirmed = false;
    }

    public function render()
    {
        return view('livewire.admin.admin-attribute-component',[
            'attributes' => Attribute::where(function($sub_query){
    							$sub_query->where('name', 'LIKE', '%'.$this->search.'%');
    						})->paginate(10)
        ])
        ->layout('layouts.admin.base')
        ->layoutData([
            'title' => 'Master Product Attribute',
            'breadcrumbs' => [
                'master'        => [
                    'title' => 'Dahboard',
                    'link' => route('admin.dashboard'),
                ],
                'attributes'        => [
                    'title' => 'User Attribute',
                    'link' => '',
                ],
                
            ],
            'nav' => [
                'attributes'        => 'active',
            ]
        ]);
    }
}
