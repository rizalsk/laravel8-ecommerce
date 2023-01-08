<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Category;

class AdminCategoryComponent extends Component
{
    use WithPagination;

    public $confirmed = false;

    public function confirmDelete($id)
    {
        $this->confirmed = $id;
    }

    public function destroy(Category $category){
        $category->delete();
        $this->dispatchBrowserEvent('toastr:success',[
            'message' => 'Category has been deleted successfully!'
        ]);
        $this->confirmed = false;
    }

    public function render()
    {
        $categories = Category::paginate(10);

        return view('livewire.admin.admin-category-component',[
            'categories' => $categories,
        ])
        ->layout('layouts.admin.base')
        ->layoutData([
            'title' => 'Master Categories',
            'breadcrumbs' => [
                'master'        => [
                    'title' => 'Dahboard',
                    'link' => route('admin.dashboard'),
                ],
                'categories'        => [
                    'title' => 'Categories',
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
