<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    @if (isset($breadcrumbs))
        <ol class="breadcrumb bg-white">
            @foreach ($breadcrumbs as $breadcrumb)
                <li class="breadcrumb-item {{ $loop->iteration == count($breadcrumbs) ? 'active' : ''}}">
                    @if ($loop->iteration < count($breadcrumbs))
                        <a href="{{$breadcrumb['link']}}">{{$breadcrumb['title']}}</a>
                    @else
                        {{$breadcrumb['title']}}
                    @endif
                </li>
            @endforeach
            
        </ol>
    @endif
    

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link d-flex" data-toggle="dropdown" href="#">
                <span class="text-sm mr-2 mt-1">{{ auth()->user()->name }}</span>
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