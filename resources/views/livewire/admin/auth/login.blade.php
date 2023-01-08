<div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <a href="../../index2.html" class="h1"><b>Admin</b></a>
        </div>
        <div class="card-body">
            <p class="login-box-msg">Sign in to start your session</p>

            <x-jet-validation-errors class="mb-4" />

            @if (session('status'))
                <div class="mb-4 text-sm text-danger">
                    {{ session('status') }}
                </div>
            @endif

            <form id="f-login" wire:submit.prevent="login" action="{{ route('admin.login.post') }}" method="POST">
                @csrf
                <div class="input-group mb-3">
                    <input id="email" name="email" wire:model.lazy="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email"  type="email" name="email" :value="old('email')" required autofocus>
                    <div class="input-group-append">
                        <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                    @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror

                </div>
                <div class="input-group mb-3">
                    <input type="password" name="password" wire:model.lazy="password"
                                    class="form-control @error('password') is-invalid @enderror" placeholder="Password" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror

                </div>
                <div class="row">
                <div class="col-12">
                    <div class="icheck-primary">
                    <input type="checkbox" id="remember">
                    <label for="remember">
                        Remember Me
                    </label>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-6">
                    <a href="/" class="btn btn-primary btn-block">Cancel</a>
                </div>
                <div class="col-6">
                    <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                </div>
                <!-- /.col -->
                </div>
            </form>
            

        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>
<!-- /.login-box -->

@push('style')
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @stack('styles')
    @livewireStyles
@endpush