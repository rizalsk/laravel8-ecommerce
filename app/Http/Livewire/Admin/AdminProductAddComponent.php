<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Product;
use App\Models\CategoryAttribute;
use App\Models\Attribute;
use App\Models\ProductAttributeValue;
use App\Models\Category;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;

class AdminProductAddComponent extends Component
{
    use WithFileUploads;

    public $name;
    public $slug;
    public $category_id;
    public $short_description;
    public $description;
    public $regular_price;
    public $sale_price;
    public $SKU;
    public $stock_status;
    public $featured;
    public $quantity;
    public $image;
    public $images;
    public $category;

    public $attr;
    public $inputs = [];
    public $attribute_arr = [];
    public $attribute_values;

    protected $rules = [
        'name' => 'required',
        'slug' => 'required',
        //'category_id' => 'required',
        'short_description' => 'nullable|max:191',
        //'description' => 'required',
        'regular_price' => 'numeric|nullable',
        'sale_price' => 'numeric|nullable',
        //'SKU' => 'required',
        // 'stock_status' => ,
        // 'featured' => ,
        // 'quantity' => ,
        'image' => 'nullable|image|max:1024',
        'images' => 'nullable|image|max:1024',
        // 'category' => ,
    ];

    public function mount(){
        $this->stock_status = 'instock';
        $this->featured = false;
    }

    public function addAttribute(){
        if(!in_array($this->attr, $this->attribute_arr)){
            array_push($this->inputs, $this->attr);
            array_push($this->attribute_arr, $this->attr);
        }
    }

    public function removeAttribute($attr){
        unset($this->inputs[$attr]);
        unset($this->attribute_arr[$attr]);
    }

    public function generateSlug(){
        $this->slug = Str::slug($this->name);
    }

    public function store(){
        $this->validate();

        try {
            $product = new Product();
            $product->name = $this->name;
            $product->slug = $this->slug;
            $product->category_id = $this->category_id;
            $product->short_description = $this->short_description;
            $product->description = $this->description;
            $product->regular_price = $this->regular_price;
            $product->sale_price = $this->sale_price ?? null;
            $product->SKU = 'DIGI'.($this->SKU ?? '');
            $product->stock_status = $this->stock_status;
            $product->featured = $this->featured ?? false;
            $product->quantity = $this->quantity ?? 0;
            
            if($this->image){
                $imageName = now()->timestamp.'.'.$this->image->extension();
                $this->image->storeAs('products', $imageName);
                $product->image = $imageName;
            }
            if($this->images){
                $gallery = [];

                foreach ($this->images as $key=>$image) {
                    $imageName = now()->timestamp.$key.'.'.$image->extension();
                    $image->storeAs('products', $imageName);
                    $gallery[] = $imageName;
                }

                $product->images = implode($gallery,',');
            }

            $product->save();

            foreach ($this->attribute_values as $key => $attribute_value) {
                $avalues = explode(",", $attribute_value);
                foreach ($avalues as $avalue) {
                    # code...
                    $attr_value = new ProductAttributeValue();
                    $attr_value->attribute_id = $key;
                    $attr_value->value = trim($avalue);
                    $attr_value->product_id = $product->id;
                    $attr_value->save();
                }
            }
            $this->dispatchBrowserEvent('toastr:success',[
                'message' => 'Product has been created successfully!'
            ]);
            return redirect()->route('admin.products.edit', $product->slug);

        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('toastr:error',[
                'message' => $th->getMessage()
            ]);
        }
    }

    public function render()
    {
        return view('livewire.admin.admin-product-add-component',[
            'categories' => Category::latest()->get(),
            'pattributes' => Attribute::all()
        ])
        ->layout('layouts.admin.base')
        ->layoutData([
            'title' => 'New Categories',
            'breadcrumbs' => [
                'master'        => [
                    'title' => 'Dahboard',
                    'link' => route('admin.dashboard'),
                ],
                'products'        => [
                    'title' => 'Products',
                    'link' => route('admin.products'),
                ],
                'newproducts'        => [
                    'title' => 'New Product',
                    'link' => '',
                ],
                
            ],
            'nav' => [
                'master'        => 'active',
                'products'    => 'active'
            ]
        ]);
    }
}
