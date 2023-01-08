<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <x-partials.admin.layouts.head :title="$title ?? '' " />
    <!-- Styles -->
    @livewireStyles
    @stack('styles')
</head>

<body class="hold-transition sidebar-mini">
<div class="wrapper">

    <!-- Navbar -->
    {{-- <livewire:admin.partials.layouts.navigation-menu /> --}}
    {{-- @livewire('navigation-menu') --}}
    <x-partials.admin.layouts.nav :breadcrumbs="$breadcrumbs ?? []"/>
    <!-- /.navbar -->

    <!-- Aside -->
    <x-partials.admin.layouts.side :nav="$nav ?? []"/>
    <!-- /.Aside -->

    <!-- Content Wrapper. Contains page content -->
    {{-- @yield('content') --}}
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper pt-2">
        {{ $slot }}
        @livewire('livewire-toast')
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <x-partials.admin.layouts.footer />
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<x-partials.admin.layouts.scripts />
<script src="{{ asset('js/app.js') }}" defer></script>
@stack('scripts')
@livewireScripts
</body>
</html>
