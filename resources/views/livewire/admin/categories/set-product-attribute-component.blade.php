<div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- jquery validation -->
                    <div class="card card-light">

                        <div class="card-header">
                            <h3 class="card-title">Add Attribute to products</h3>
                            <div class="card-tools">
                                <a class="btn btn-sm btn-primary" href="{{ route('admin.categories') }}">
                                    <i class="fas fa-chevron-left"></i> Back
                                </a>
                            </div>
                        </div>
                        <!-- /.card-header -->

                        <!-- form start -->
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
                            <div class="row mb-3">
                                <div class="col-md-12 text-center">
                                    Category: <h3>{{ $category->name}}</h3>
                                </div>
                            </div>
                            {{-- section add attributes --}}
                            <div class="row border border-bottom mb-3">

                                <div class="col-md-6 ">
                                    <form class="form-horizontal" id="f-attribute" wire:submit.prevent="storeAttribute">
                                        <div class="form-group">
                                            <label for="inputEmail3" class="">New Attribute</label>
                                            <div class="input-group mb-3">
                                                <input type="text" wire:model="attribute_name" class="form-control" placeholder="Attribute" aria-label="Attribute"
                                                    aria-describedby="basic-addon2">
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary" type="submit">Save</button>
                                                </div>
                                            </div>
                                        </div>
                                        @error('attribute_name')
                                        <span class="invalid-feedback">
                                            {{ $message }}
                                        </span>
                                        @enderror
                                    </form>
                                </div>
                                <div class="col-md-6 border-left">
                                    <div class="form-group">
                                        <label class="" for="categoryAttributes">Set Attribute to Products</label>
                                        <div class="input-group">
                                            <select wire:model="attr" id="categoryAttributes" name="categoryAttributes" class="custom-select">
                                                <option value="" selected>-- select attr --</option>
                                                @foreach ($categoryAttributes as $ca)
                                                <option value="{{$ca->id}}">{{$ca->name}}</option>
                                                @endforeach
                                            </select>
                                            <div class="input-group-append">
                                                <button wire:click.prevent="addAttribute" type="button" class="btn btn-info ">Set</button>
                                            </div>
                                        </div>
                                    </div>

                                    @error('attr') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <form class="form-horizontal" id="f-attribute-product" wire:submit.prevent="store">
                                {{-- SET PRODUCT ATTRIBUTES --}}
                                <div class="row border border-bottom">
                                    
                                    @foreach ($inputs as $key => $value)
                                        @php
                                            $attribut_id = $attribute_arr[$key];
                                            $selectedAttr = $categoryAttributes->where('id', $attribut_id)->first();
                                        @endphp
                                        @if ($selectedAttr)
                                            <div class="card col-12 px-2">
                                                <div class="card-body row">
                                                    <div class="col-md-3 col-sm-3">
                                                        <label class="control-label" for="attr-{{$key}}">{{ $selectedAttr->name }}</label>
                                                    </div>
                                                    <div class="col-md-9 col-sm-9">
                                                        <table class="table">
                                                            <tbody>
                                                                @foreach ($attribute_products[$attribut_id]['products'] as $pkey => $product)
                                                                    <tr>
                                                                        <td>
                                                                            {{$product['name'] ?? 'name'}}
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" wire:key="product-{{$attribut_id}}-{{ $product['id'] }}" wire:model="attribute_products.{{$attribut_id}}.products.{{$pkey}}.value"  class="form-control"
                                                                                id="attr-{{$attribut_id}}-{{$key}}">
                                                                        </td>
                                                                        <td>
                                                                            <button type="button" class="btn btn-danger btn-block" wire:click.prevent="removeAttributeProduct({{$attribut_id}},{{$pkey}})">
                                                                                <i class="fas fa-trash" aria-hidden="true"></i>
                                                                            </button>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                        <div class="d-flex justify-content-between">
                                                            @php
                                                                $product_ids = $attribute_products[$attribut_id]['product_ids'];
                                                                
                                                                $unselectedProducts = $categoryProducts->whereNotIn('id', $product_ids);
                                                            @endphp
                                                            <div>
                                                                <div class="input-group">
                                                                    <select class="custom-select" wire:model="product_attr">
                                                                        <option value="" selected>-- select product --</option>
                                                                        @foreach ($unselectedProducts as $up)
                                                                        <option value="{{$up->id}}">{{$up->name ?? ''}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    <div class="input-group-prepend">
                                                                        <button wire:click.prevent="addAttributeProduct({{$attribut_id}})" type="button" class="btn btn-info ">Add Product</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="col-md-3 col-sm-3 mt-auto">
                                                                <button type="button" class="btn btn-danger btn-block" wire:click.prevent="removeAttribute({{$key}})">
                                                                    <i class="fas fa-trash" aria-hidden="true"></i>
                                                                </button>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach 
                                    
                                </div>

                                <div class="row border border-bottom">
                                    <div class="col-12 d-flex justify-content-between">
                                        <div>
                                            <button type="submit" class="btn btn-primary">Save Product Attributes</button>
                                        </div>
                                        <div>
                                            <a href="{{route('admin.categories')}}" class="btn btn-danger">Cancel</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- /.card-body -->
                        <div class="card-footer">
                            
                        </div>

                    </div>
                    <!-- /.card -->
                </div>
                <!--/.col (left) -->
                
                <!-- right column -->
                <div class="col-md-12">

                </div>
                <!--/.col (right) -->
                
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        
        window.initSelectCompanyDrop = () => {
            $('#selectAttribute').select2({
                placeholder: 'Select attributes',
                allowClear: true
            });
        }
        
        $('#selectAttribute').select2();

        $('#selectAttribute').on('change', function (e) {
            var data = $('#selectAttribute').select2("val");
            @this.set('selectedAttributes', data);
        });
        
        window.livewire.on('select2',()=>{
            initSelectCompanyDrop();
        });
        
        window.addEventListener('attribute-saved', event => {
            alert('Name updated to: ' + event.detail.newName);
            $('#modal-sm').modal('hide');
        })
        
    });
</script>
@endpush