<div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- jquery validation -->
                    <div class="card card-light">
                        <div class="card-header">
                            <h3 class="card-title">Add Category</h3>
                            <div class="card-tools">
                                <a class="btn btn-sm btn-primary" href="{{ route('admin.categories') }}">
                                    <i class="fas fa-chevron-left"></i> Back
                                </a>
                            </div>
                        </div>
                        <!-- /.card-header -->
    
                        <!-- form start -->
                        <form class="form-horizontal" id="f-category" wire:submit.prevent="store">

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label" for="parent_id">Parent Category</label>
                                            <select wire:model="parent_id" id="parent_id" name="parent_id"
                                                class="form-control" style="width: 100%;">
                                                <option value="" selected>-- no parent --</option>
                                                @foreach ($categories as $category)
                                                <option value="{{$category->id}}">{{$category->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('parent_id')
                                            <span class="invalid-feedback">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label" for="name">Category Name</label>
                                            <input wire:model="name" wire:change="generateSlug" wire:keyup="generateSlug" type="text" name="name"
                                                class="form-control" id="name" placeholder="Category Name">
                                        </div>
                                        @error('name')
                                        <span class="invalid-feedback">
                                            {{ $message }}
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label class="control-label" for="slug">Slug</label>
                                            <input wire:model="slug" type="text" name="slug" class="form-control" id="slug"
                                                readonly placeholder="Category Slug">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
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
