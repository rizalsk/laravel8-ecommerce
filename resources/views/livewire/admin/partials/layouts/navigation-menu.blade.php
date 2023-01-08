<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="index3.html" class="nav-link">Home</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="#" class="nav-link">Contact</a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <div class="image">
                    <img src="{{ asset('adminlte') }}/dist/img/user2-160x160.jpg" class="img-circle img-size-32 elevation-2" alt="User Image">
                </div>
                <span class="badge badge-warning navbar-badge">15</span>
            </a>

            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">

                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-user mr-2"></i> Profile
                </a>

                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('f-logout').submit();">
                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                </a>

                <form id="f-logout" method="POST" action="{{ route('logout') }}">
                    @csrf
                </form>
            </div>
        </li>
    </ul>
</nav>