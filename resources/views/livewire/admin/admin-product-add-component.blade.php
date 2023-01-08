<div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- jquery validation -->
                    <div class="card card-light">
                        <div class="card-header">
                            <h3 class="card-title">Add Product</h3>
                            <div class="card-tools">
                                <a class="btn btn-sm btn-primary" href="{{ route('admin.products') }}">
                                    <i class="fas fa-chevron-left"></i> Back
                                </a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                        </div>
                        <!-- form start -->
                        <form class="form-horizontal" id="f-product" wire:submit.prevent="store">

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label" for="category_id">Category</label>
                                            <select wire:model="category_id" id="category_id" name="category_id"
                                                class="form-control" style="width: 100%;">
                                                <option value="" selected>-- select category --</option>
                                                @foreach ($categories as $category)
                                                <option value="{{$category->id}}">{{$category->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('category_id')
                                            <span class="invalid-feedback">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label" for="name">Product Name</label>
                                            <input wire:model="name" wire:change="generateSlug"
                                                 type="text" name="name" class="form-control"
                                                id="name" placeholder="Product Name">
                                        </div>
                                        @error('name')
                                        <span class="invalid-feedback">
                                            {{ $message }}
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label" for="slug">Slug</label>
                                            <input wire:model="slug" type="text" name="slug" class="form-control" id="slug" readonly
                                                placeholder="Product Slug">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label class="control-label" for="slug">Short Description</label>
                                            <textarea wire:model="short_description" name="short_description" class="form-control" id="short_description"
                                                placeholder="Short Description"></textarea>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label class="control-label" for="slug">Description</label>
                                            <textarea wire:model="description" name="description" class="form-control" id="description"
                                                placeholder="Description" row="5"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label" for="regular_price">Regular price</label>
                                            <input wire:model="regular_price" type="number" name="regular_price"
                                                class="form-control" id="regular_price" placeholder="00.00">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label" for="sale_price">Sale price</label>
                                            <input wire:model="sale_price" type="number" name="sale_price" class="form-control" id="sale_price" 
                                                placeholder="0">
                                        </div>
                                    </div>

                                    {{-- SKU --}}
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label" for="SKU">SKU</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon3">DIGI</span>
                                                </div>
                                                <input wire:model="SKU" type="number" name="SKU" class="form-control" id="SKU" placeholder="0">
                                            </div>
                                            
                                        </div>
                                    </div>
                                    
                                    {{-- Stock Status --}}
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label" for="stoct_status">Stock</label>
                                            <select wire:model="stoct_status" id="stoct_status" name="stoct_status" class="form-control" style="width: 100%;">
                                                <option value="instock" selected>In stock</option>
                                                <option value="outofstock" selected>Out of stock</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label" for="featured">Featured</label>
                                            <select wire:model="featured" id="featured" name="featured" class="form-control" style="width: 100%;">
                                                <option value="0" selected>No</option>
                                                <option value="1" selected>Yes</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label" for="quantity">Quantity</label>
                                            <input wire:model="quantity" type="number" name="quantity" class="form-control" id="quantity" placeholder="0">
                                            @error('quantity') <p class="text-danger">{{$message}}</p>@enderror
                                        </div>
                                    </div>

                                    {{-- image banner --}}
                                    <div class="col-md-4">

                                        <div class="form-group">
                                            <div class="bg-sky-300 h-48">
                                                Photo Preview:
                                                @if ($image)
                                                    <img class="object-contain hover:object-scale-down" src="{{ $image->temporaryUrl() }}" width="100">

                                                @endif
                                                <div wire:loading wire:target="image">
                                                    <div>
                                                        <div class="spinner-grow spinner-grow-sm text-primary" role="status">
                                                            <span class="sr-only">Loading...</span>
                                                        </div>
                                                        <div class="spinner-grow spinner-grow-sm text-secondary" role="status">
                                                            <span class="sr-only">Loading...</span>
                                                        </div>
                                                        <div class="spinner-grow spinner-grow-sm text-success" role="status">
                                                            <span class="sr-only">Loading...</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <label class="control-label" for="image">Banner image</label>
                                            <input type="file" wire:model="image" name="image" class="form-control" id="image" width="50" >
                                            @error('image') <p class="text-danger">{{$message}}</p>@enderror
                                        </div>
                                    </div>

                                    {{-- image gallery --}}
                                    <div class="col-md-8 mt-auto">
                                    
                                        <div class="form-group">
                                            <div class="bg-sky-300 h-48 mb-3">
                                                Preview Gallery:
                                                <small class="text-danger">select multiple images</small>
                                                <div class="flex">
                                                
                                                    @if ($images)
                                                        @foreach ($images as $image)
                                                            <img class="" width="70" src="{{ $image->temporaryUrl() }}">
                                                        @endforeach
                                                    @endif
                                                </div>    
                                                <div wire:loading wire:target="images">
                                                    <div>
                                                        <div class="spinner-grow spinner-grow-sm text-primary" role="status">
                                                            <span class="sr-only">Loading...</span>
                                                        </div>
                                                        <div class="spinner-grow spinner-grow-sm text-secondary" role="status">
                                                            <span class="sr-only">Loading...</span>
                                                        </div>
                                                        <div class="spinner-grow spinner-grow-sm text-success" role="status">
                                                            <span class="sr-only">Loading...</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- ./loader --}}
                                            </div>
                                    
                                            {{-- <label class="control-label" for="images">Gallery</label> --}}
                                            <input type="file" wire:model="images" name="images" class="form-control" id="images" multiple>
                                            @error('images') <p class="text-danger">{{$message}}</p> @enderror

                                        </div>
                                    </div>
                                    
                                    
                                </div>

                                {{-- Attributes --}}
                                <div class="row border-top mt-3 pt-3">
                                    <div class="col-md-4">
                                        <div class="form-group row d-flex d-flex-inline justiry-content-end">
                                            <div class="col-md-9 col-sm-9">
                                                <label class="control-label" for="attributes">Attribute</label>
                                                <select wire:model="attr" id="attributes" name="attributes" class="form-control" style="width: 100%;">
                                                    <option value="" selected>-- select attr --</option>
                                                    @foreach ($pattributes as $attr)
                                                    <option value="{{$attr->id}}">{{$attr->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-3 col-sm-3 mt-auto">
                                                <button wire:click.prevent="addAttribute" type="button" class="btn btn-info btn-block">Add</button>
                                            </div>
                                        </div>
                                        @error('attr') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    
                                    @foreach ($inputs as $key => $value)
                                        @php
                                        $selectedAttr = $pattributes->where('id', $attribute_arr[$key])->first();
                                        @endphp
                                        @if ($selectedAttr)
                                            <div class="col-md-4">
                                                <div class="form-group row d-flex d-flex-inline justiry-content-end">
                                                    <div class="col-md-9 col-sm-9">
                                                        <label class="control-label" for="attr-{{$key}}">{{ $selectedAttr->name }}</label>
                                                        <input wire:model="attribute_values.{{$value}}" type="text" class="form-control" id="attr-{{$key}}"
                                                            placeholder="{{ $selectedAttr->name }}">
                                                    </div>
                                                    <div class="col-md-3 col-sm-3 mt-auto">
                                                        <button type="button" class="btn btn-danger btn-block" wire:click.prevent="removeAttribute({{$key}})">
                                                            <i class="fas fa-trash" aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                                {{-- ./Add Attributes --}}
                            </div>

                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>

                        </form>
                    </div>
                    <!-- /.card -->
                </div>
                <!--/.col (left) -->
                <!-- right column -->
                <div class="col-md-6">

                </div>
                <!--/.col (right) -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
</div>