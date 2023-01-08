<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Product;
use App\Models\Category;
use App\Models\Attribute;
use App\Models\CategoryAttribute;
use App\Models\ProductAttributeValue;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;

class AdminProductEditComponent extends Component
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
    
    public $imageName;
    public $gallery;
    public $product_id;
    
    public $exit = false;

    public $attr;
    public $inputs = [];
    public $attribute_arr = [];
    public $attribute_values = [];
    
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
        'images.*' => 'nullable|image|max:1024',
        // 'category' => ,
    ];

    public function mount($slug){
        $product = $this->product = Product::where('slug', $slug)->firstOrFail();
        $this->name = $product->name ;
        $this->slug = $product->slug ;
        $this->category_id = $product->category_id ;
        $this->short_description = $product->short_description ;
        $this->description = $product->description ;
        $this->regular_price = $product->regular_price ;
        $this->sale_price = $product->sale_price ;
        $this->SKU = (str_replace("DIGI","",$product->SKU));
        $this->stock_status = $product->stock_status ;
        $this->featured = $product->featured ;
        $this->quantity = $product->quantity ;
        //$this->image = $product->image ;
        //$this->images = explode(",",$product->images) ;
        $this->imageName = $product->image ;
        $this->gallery = $product->images ;
        $this->category = $product->category ;
        $this->product_id = $product->id ;

        // attribute values
        $attribute_arr =  $this->attribute_arr = $this->inputs = $product->attributeValues->where('product_id', $product->id)->unique('attribute_id')->pluck('attribute_id');

        foreach ($attribute_arr as $a_arr) {
            $allAttributeValue = ProductAttributeValue::where('product_id',$product->id)->where('attribute_id', $a_arr)->get()->pluck('value');
            $valueString = '';
            foreach ($allAttributeValue as $value) {
                $valueString = $valueString . $value . ',';
            }
            $this->attribute_values[$a_arr] = rtrim($valueString,","); 
        }
    }

    public function render()
    {
        return view('livewire.admin.admin-product-edit-component',[
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
                    'title' => 'Edit Product',
                    'link' => '',
                ],
                
            ],
            'nav' => [
                'master'        => 'active',
                'products'    => 'active'
            ]
        ]);
    }

    public function addAttribute(){
        if(!$this->attribute_arr->contains($this->attr)){
            $this->inputs->push($this->attr);
            $this->attribute_arr->push($this->attr);
        }
    }

    public function removeAttribute($attr){
        unset($this->inputs[$attr]);
        unset($this->attribute_arr[$attr]);
    }

    public function update(){
        // Validate request
        $this->validate();    
        try{
            // Update category
            $product = Product::where('slug', $this->product->slug)->first();
            $product->name = $this->name;
            $product->slug = $this->slug;
            $product->category_id = $this->category_id;
            $product->short_description = $this->short_description;
            $product->description = $this->description;
            $product->regular_price = $this->regular_price;
            $product->sale_price = $this->sale_price;
            $product->SKU = 'DIGI'.(str_replace("DIGI","",$this->SKU));
            $product->stock_status = $this->stock_status;
            $product->featured = $this->featured;
            $product->quantity = $this->quantity;
            
            if($this->image){
                $imageName = now()->timestamp.'.'.$this->image->extension();
                $this->image->storeAs('products', $imageName);
                $product->image = $imageName;
            }

            if($this->images){

                $gallery = [];
                $productGallery = explode(",", $product->images);
                foreach ($productGallery as $key=>$image) {
                    if($image != ''){
                        unlink(public_path('assets/images/products/'.$image));
                    }
                }

                foreach ($this->images as $key=>$image) {
                    $imageName = now()->timestamp.$key.'.'.$image->extension();
                    $image->storeAs('products', $imageName);
                    $gallery[] = $imageName;
                }

                $product->images = implode($gallery,',');
            }

            $product->save();

            ProductAttributeValue::where('product_id', $product->id)->delete();
            foreach ($this->attribute_values as $key => $attribute_value) {
                $avalues = explode(',', $attribute_value);
                foreach ($avalues as $avalue) {
                    $attr_value = new ProductAttributeValue();
                    $attr_value->attribute_id = $key;
                    $attr_value->category_id = $product->category_id ?? null;
                    $attr_value->value = trim($avalue);
                    $attr_value->product_id = $product->id;
                    $attr_value->save();
                }
            }

            $this->dispatchBrowserEvent('toastr:success',[
                'message' => 'Product has been Updated successfully!'
            ]);    

        }catch(\Throwable $th){
            $this->dispatchBrowserEvent('toastr:error',[
                'message' => $th->getMessage()
            ]);
            $this->exit = false;
        }
        if($this->exit){
            return redirect()->route('admin.products');
        }
    }

    public function generateSlug(){
        $this->slug = Str::slug($this->name);
    }

    public function saveAndExit(){
        $this->exit = true;
        $this->update();
        
    }

    public function resetData(){
        $this->image = null;
    }
}
