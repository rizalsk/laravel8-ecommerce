<?php

namespace App\Http\Livewire\Admin\Categories;

use Livewire\Component;
use App\Models\Attribute;
use App\Models\Category;
use App\Models\CategoryAttribute;
use App\Models\Product;
use App\Models\ProductAttributeValue;

use Illuminate\Support\Str;

class SetProductAttributeComponent extends Component
{
    public $category;
    public $categoryProducts;
    public $categoryAttributes;
    public $products;
    public $allProducts;
    public $productsAttributes;
    public $attributes;

    public $attr;
    public $inputs = [];
    public $attribute_arr = [];
    public $attribute_values = [];
    public $attribute_products = [];
    public $not_attribute_products = [];
    public $product_attr;
    
    public $selectedAttributes = [];

    public $attribute_name;

    protected $rules = [
        'productIds' => 'required'
    ];

    public function addAttribute(){

        if(!in_array($this->attr, $this->attribute_arr)){

            array_push($this->inputs, $this->attr);
            array_push($this->attribute_arr, $this->attr);

            $productArray = $this->category->products->toArray();

            foreach ($productArray as $key => $value) {
                $productArray[$key]['value'] = null;
                $productArray[$key]['attribute_id'] = $this->attr;
            }

            $attribute_products = [
                'attribute_id' => $this->attr,
                'product_ids' => $this->category->products->pluck('id')->toArray(),
                'category_id' => $this->category->id,
                'products' => $productArray,
            ];

            $this->attribute_products[$this->attr] = $attribute_products;
        }

    }

    public function removeAttribute($attr){
        unset($this->inputs[$attr]);
        unset($this->attribute_arr[$attr]);
        unset($this->attribute_products[$attr]);
    }

    public function addAttributeProduct($attr_id){
        $product = Product::findOrFail($this->product_attr);
        if($product){

            $newArray = [
                'attribute_id' => $attr_id,
                'value' => null
            ];

            $productArr = array_merge($product->toArray(), $newArray);

            if(!in_array($product->id, $this->attribute_products[$attr_id]['product_ids'] )){
                array_push($this->attribute_products[$attr_id]['product_ids'],$product->id);
                array_push($this->attribute_products[$attr_id]['products'],$productArr );
            }
        }
    }

    public function removeAttributeProduct($attr_id,$prodk){
        unset($this->attribute_products[$attr_id]['products'][$prodk]);
        unset($this->attribute_products[$attr_id]['product_ids'][$prodk]);
    }

    public function storeAttribute(){
        
        // Validate request
        $this->validate([
            'attribute_name'   => 'required',
        ]);

        try{
            $attr = Attribute::firstOrCreate(['name' => trim($this->attribute_name)]);

            $cattr = new CategoryAttribute();
            $cattr->category_id = $this->category->id;
            $cattr->attribute_id = $attr->id;
            $cattr->save(); 

            $category = $this->category = Category::find($this->category->id);

            $this->categoryAttributes = $category->attributes;

            $this->dispatchBrowserEvent('toastr:success',[
                'message' => 'Attribute has been saved successfully!'
            ]);    
            $this->reset('attribute_name');
        }catch(\Throwable $th){
            $this->dispatchBrowserEvent('toastr:error',[
                'message' => $th->getMessage()
            ]);
        }

    }

    public function mount($slug){
        $this->slug = $slug;
        $category = $this->category = Category::where('slug', $slug)->firstOrFail();
        $categoryProducts = $this->categoryProducts = $category->products;
        
        //$allProducts = $this->allProducts = Product::whereNull('category_id')->doesntHave('category')->orderBy('name', 'asc')->get();
        //$allProducts = $allProducts->merge($categoryProducts);

        $categoryAttributes = $this->categoryAttributes = $category->attributes;
    }

    public function render()
    {

        return view('livewire.admin.categories.set-product-attribute-component',[
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
                    'title' => 'Attribute',
                    'link' => '',
                ],
                
            ],
            'nav' => [
                'master'        => 'active',
                'categories'    => 'active'
            ]
        ]);
    }

    public function store(){

        try {
            //delete
            foreach ( $this->attribute_products as $key => $value) {
                $products = $value['products'];
                if(count($products) > 0){
                    foreach ( $products as $idx => $prd) {
                        $product = (object) $prd;
                        if(isset($product->value)){
                            if($product->value != null && $product->value != ''){
                                ProductAttributeValue::where('product_id', $product->id)->delete();
                            }
                        }
                    }
                }
            }

            //set
            foreach ( $this->attribute_products as $key => $value) {
                $products = $value['products'];
                if(count($products) > 0){
                    foreach ( $products as $idx => $prd) {
                        $product = (object) $prd;
                        
                        if(isset($product->value)){
                            if($product->value != null && $product->value != ''){
                                $avalues = explode(',', $product->value);
                                foreach ($avalues as $avalue) {
                                    $attr_value = new ProductAttributeValue();
                                    $attr_value->attribute_id = $key;
                                    $attr_value->category_id = $product->category_id;
                                    $attr_value->value = trim($avalue);
                                    $attr_value->product_id = $product->id;
                                    $attr_value->save();
                                }
                            }
                        }
                    }
                }
            }

            $this->dispatchBrowserEvent('toastr:success',[
                'message' => 'Product has been created successfully!'
            ]);

        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('toastr:error',[
                'message' => $th->getMessage()
            ]);
        }
    }


}
