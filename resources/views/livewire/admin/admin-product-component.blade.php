<div class="">
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Product List</h3>
                            <div class="card-tools">
                                <a class="btn btn-sm btn-primary" href="{{ route('admin.products.add') }}">
                                    <i class="fas fa-plus"></i> Add
                                </a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="fflex mb-3 row justify-content-end">
                                <div class="col-md-3">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Search" wire:model.debounce.500ms="search" aria-label="Search term"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="basic-addon2">
                                                <i class="fa fa-search" aria-hidden="true"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <table id="tb-datatable" class="datatable table table-sm table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Banner</th>
                                        <th>Product Name</th>
                                        <th>Stock</th>
                                        <th>Price</th>
                                        <th>Sale Price</th>
                                        <th>Quantity</th>
                                        <th>Category</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                        <tr>
                                            <td>{{$product->id}}</td>
                                            <td>
                                                @if (!is_null($product->image))
                                                    <img src="{{ asset('assets/images/products') }}/{{$product->image}}" width="60" alt="">
                                                @endif
                                            </td>
                                            <td>{{$product->name}}</td>
                                            <td>{{$product->stock_status}}</td>
                                            <td>{{$product->regular_price}}</td>
                                            <td>{{$product->sale_price}}</td>
                                            <td>{{$product->quantity}}</td>
                                            <td>{{$product->category->name}}</td>
                                            <td>{{$product->created_at}}</td>
                                            <td>
                                                <a class="btn btn-sm btn-warning"
                                                    href="{{route('admin.products.edit', $product->slug)}}">
                                                    <i class="fas fa-edit" aria-hidden="true"></i>
                                                </a>
                                                <a class="btn btn-sm btn-danger"
                                                    wire:click.prevent="confirmDelete({{$product->id}})" href="#">
                                                    <i class="fas fa-trash" aria-hidden="true"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="mt-2">
                                {{ $products->links() }}
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    {{-- confirm modal --}}
    <x-jet-confirmation-modal wire:model="confirmed" maxWidth="sm" class="flex items-center my-custom-class">
        <x-slot name="title">
            Delete Product
        </x-slot>
    
        <x-slot name="content">
            Are you sure you want to delete this product?
    
        </x-slot>
    
        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('confirmed', false)" wire:loading.attr="disabled">
                Cancel
            </x-jet-secondary-button>
    
            <x-jet-danger-button class="ml-2" wire:click="destroy({{$confirmed}})" wire:loading.attr="disabled">
                Yes
            </x-jet-danger-button>
        </x-slot>
    
    </x-jet-confirmation-modal>
    {{-- /confirm modal --}}
</div>
@push('scripts')
<script>
    $(function () {
        // $('table.datatable').DataTable({
        //     "paging": true,
        //     "lengthChange": false,
        //     "searching": true,
        //     "ordering": true,
        //     "info": true,
        //     "autoWidth": false,
        //     "responsive": true,
        // });
    });
</script>
@endpush