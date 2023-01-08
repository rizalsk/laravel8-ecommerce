<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;
use App\Models\ProductAttribute;
use Illuminate\Pagination\Paginator;

class AdminProductComponent extends Component
{
    use WithPagination;
    public $confirmed;
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
    
    public function destroy(Product $product){
        if($product->image){
            unlink(public_path('assets/images/products/'.$product->image));
        }

        if($product->images){
            $gallery = explode(",", $product->images);
            foreach ($gallery as $key => $img) {
                if($img != '') unlink(public_path('assets/images/products/'.$img));
            }
        }

        $product->delete();
        $this->dispatchBrowserEvent('toastr:success',[
            'message' => 'Product has been deleted successfully!'
        ]);
    }

    public function render()
    {
        $search = '%'.$this->search.'%';
        
        return view('livewire.admin.admin-product-component',[
            'products' => Product::where(function($sub_query){
    							$sub_query->where('name', 'LIKE', '%'.$this->search.'%')
    									  ->orWhere('description', 'LIKE', '%'.$this->search.'%');
    						})->paginate(10),
        ])
        ->layout('layouts.admin.base')
        ->layoutData([
            'title' => 'Master Product',
            'breadcrumbs' => [
                'master'        => [
                    'title' => 'Dahboard',
                    'link' => route('admin.dashboard'),
                ],
                'product'        => [
                    'title' => 'Products',
                    'link' => '',
                ],
                
            ],
            'nav' => [
                'master'        => 'active',
                'products'    => 'active'
            ]
        ]);
        
    }

    // public function setPage($url)
    // {
    //     $this->currentPage = explode('page=', $url)[1];
    //     Paginator::currentPageResolver(function(){
    //         return $this->currentPage;
    //     });
    // }

    

}
