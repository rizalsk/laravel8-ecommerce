<div>
    <section class="content ">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Category List</h3>
                            <div class="card-tools">
                                <a class="btn btn-sm btn-primary" href="{{ route('admin.categories.add') }}">
                                    <i class="fas fa-plus"></i> Add
                                </a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="tb-category" class="datatable table table-sm table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Category Name</th>
                                        <th>Slug</th>
                                        <th>Parent</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categories as $category)
                                        <tr>
                                            <td>{{$category->id}}</td>
                                            <td>{{$category->name}}</td>
                                            <td>{{$category->slug}}</td>
                                            <td>{{ $category->parent()->first()->name ?? '' }}</td>
                                            <td>
                                                <a class="btn btn-sm btn-warning" href="{{route('admin.categories.edit', $category->slug)}}">
                                                    <i class="fas fa-edit" aria-hidden="true"></i>
                                                </a>
                                                <a class="btn btn-sm btn-danger" wire:click="confirmDelete({{$category->id}})" wire:loading.attr='disabled' href="#">
                                                    <i class="fas fa-trash" aria-hidden="true"></i>
                                                </a>
                                                <a class="btn btn-sm btn-info" href="{{route('admin.categories.attributes.products', $category->slug)}}">
                                                    <i class="fas fa-edit" aria-hidden="true"></i>
                                                    set product attributes
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                {{-- <tfoot>
                                    <tr>
                                        <th>Rendering engine</th>
                                        <th>Browser</th>
                                        <th>Platform(s)</th>
                                        <th>Engine version</th>
                                        <th>CSS grade</th>
                                    </tr>
                                </tfoot> --}}
                            </table>
                            {{$categories->links()}}

                            

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
            Delete Category
        </x-slot>
    
        <x-slot name="content">
            Are you sure you want to delete this category?
            
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