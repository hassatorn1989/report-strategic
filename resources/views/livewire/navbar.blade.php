<nav class="main-header navbar navbar-expand navbar-warning navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>

    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        {{-- @if (Request::segment(1) != 'booking' && Request::segment(2) != 'reservation') --}}
            {{-- <li class="nav-item">
                <a href="#!" class="nav-link" data-toggle="modal" data-target="#modal-search-room"><i
                        class="fas fa-search"></i> {{ __('msg.menu_search_room') }}</a>
            </li> --}}
        {{-- @endif --}}
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('auth.logout') }}">
                <i class="fas fa-sign-out-alt"></i>
            </a>
        </li>
    </ul>
</nav>
