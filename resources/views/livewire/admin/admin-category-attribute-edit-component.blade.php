<div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- jquery validation -->
                    <div class="card card-light">
                        <div class="card-header">
                            <h3 class="card-title">New Attribute</h3>
                            <div class="card-tools">
                                <a class="btn btn-sm btn-primary" href="{{ route('admin.categoryattributes') }}">
                                    <i class="fas fa-chevron-left"></i> Back
                                </a>
                            </div>
                        </div>
                        <!-- /.card-header -->

                        <!-- form start -->
                        <form class="form-horizontal" id="f-attribute" wire:submit.prevent="update">

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label" for="name">Attribute Name</label>
                                            <input wire:model="name" type="text" name="name" class="form-control"
                                                id="name" placeholder="Category Name">
                                        </div>
                                        @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Save and continue</button>
                                <a wire:click="saveAndExit" class="btn btn-success">Save and exit</a>
                                <a href="{{ route('admin.categoryattributes') }}" class="btn btn-danger">Cancel</a>
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