<aside class="main-sidebar sidebar-light-navy elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard.index') }}" class="brand-link bg-navy">
        <img src="{{ url('resources/assets') }}/dist/img/AdminLTELogo.png" alt="AdminLTE Logo"
            class="brand-image img-circle">
        <span class="brand-text font-weight-light">{{ __('msg.system_name_en') }}</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ url('resources/assets') }}/dist/img/user2-160x160.jpg" class="img-circle mt-2"
                    alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Str::ucfirst(auth()->user()->full_name) }}</a>
                <a href="#" class="d-block"><small>{{ Str::ucfirst(auth()->user()->user_role) }}</small></a>
            </div>
        </div>
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{ route('dashboard.index') }}"
                        class="nav-link {{ Request::segment(1) == 'dashboard' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            {{ __('msg.menu_dashboard') }}
                        </p>
                    </a>
                </li>
                @if (auth()->user()->user_role == 'admin')
                    <li class="nav-item {{ Request::segment(1) == 'setting' ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ Request::segment(1) == 'setting' ? 'active' : '' }}">
                            <i class="nav-icon fas fa-cogs"></i>
                            <p>
                                {{ __('msg.menu_setting') }}
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <small>
                                    <a href="{{ route('setting.strategic.index') }}"
                                        class="nav-link {{ Request::segment(1) == 'setting' && Request::segment(2) == 'strategic' ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>{{ __('msg.menu_setting_strategic') }}</p>
                                    </a>
                                </small>
                            </li>
                            <li class="nav-item">
                                <small>
                                    <a href="{{ route('setting.year.index') }}"
                                        class="nav-link {{ Request::segment(1) == 'setting' && Request::segment(2) == 'year' ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>{{ __('msg.menu_setting_year') }}</p>
                                    </a>
                                </small>
                            </li>
                            <li class="nav-item">
                                <small>
                                    <a href="{{ route('setting.faculty.index') }}"
                                        class="nav-link {{ Request::segment(1) == 'setting' && Request::segment(2) == 'faculty' ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>{{ __('msg.menu_setting_faculty') }}</p>
                                    </a>
                                </small>
                            </li>
                            <li class="nav-item">
                                <small>
                                    <a href="{{ route('setting.budget.index') }}"
                                        class="nav-link {{ Request::segment(1) == 'setting' && Request::segment(2) == 'budget' ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>{{ __('msg.menu_setting_budget') }}</p>
                                    </a>
                                </small>
                            </li>
                            <li class="nav-item">
                                <small>
                                    <a href="{{ route('setting.project-type.index') }}"
                                        class="nav-link {{ Request::segment(1) == 'setting' && Request::segment(2) == 'project-type' ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>{{ __('msg.menu_setting_project_type') }}</p>
                                    </a>
                                </small>
                            </li>
                            <li class="nav-item">
                                <small>
                                    <a href="{{ route('setting.project-sub-type.index') }}"
                                        class="nav-link {{ Request::segment(1) == 'setting' && Request::segment(2) == 'project-sub-type' ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>{{ __('msg.menu_setting_project_sub_type') }}</p>
                                    </a>
                                </small>
                            </li>
                            <li class="nav-item">
                                <small>
                                    <a href="{{ route('setting.user.index') }}"
                                        class="nav-link {{ Request::segment(1) == 'setting' && Request::segment(2) == 'user' ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>{{ __('msg.menu_setting_user') }}</p>
                                    </a>
                                </small>
                            </li>
                        </ul>
                    </li>
                @endif
                <li class="nav-item {{ Request::segment(1) == 'setting-project' ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Request::segment(1) == 'setting-project' ? 'active' : '' }}">
                        {{-- <i class="fas fa-cogs"></i> --}}
                        <i class="nav-icon fas fa-list"></i>
                        <p>
                            {{ __('msg.menu_setting_project') }}
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @if (auth()->user()->user_role == 'admin')
                            <li class="nav-item">
                                <a href="{{ route('setting-project.project-main-type.index') }}"
                                    class="nav-link {{ Request::segment(1) == 'setting-project' && Request::segment(2) == 'project-main-type' ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>{{ __('msg.menu_setting_project_main_type') }}</p>
                                </a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a href="{{ route('setting-project.project-main.index') }}"
                                class="nav-link {{ Request::segment(1) == 'setting-project' && Request::segment(2) == 'project-main' ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('msg.menu_setting_project_main') }}</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- <li class="nav-item">
                    <a href="{{ route('project.index') }}"
                        class="nav-link {{ Request::segment(1) == 'project' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-folder-open"></i>
                        <p>
                            {{ __('msg.menu_project') }}
                        </p>
                    </a>
                </li> --}}
                @if (auth()->user()->user_role == 'admin')
                    <li class="nav-item">
                        <a href="{{ route('result-analysis.index') }}"
                            class="nav-link {{ Request::segment(1) == 'result-analysis' ? 'active' : '' }}">
                            <i class="nav-icon fas fa-file-alt"></i>
                            <p>
                                {{ __('msg.menu_result_analysis') }}
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('work.index') }}"
                            class="nav-link {{ Request::segment(1) == 'work' ? 'active' : '' }}">
                            <i class="nav-icon fas fa-warehouse"></i>
                            <p>
                                <small>{{ __('msg.menu_work') }}</small>
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('driven.index') }}"
                            class="nav-link {{ Request::segment(1) == 'driven' ? 'active' : '' }}">
                            <i class="nav-icon fas fa-warehouse"></i>
                            <p>
                                <small>{{ __('msg.menu_driven') }}</small>
                            </p>
                        </a>
                    </li>
                @endif
                <li class="nav-item">
                    <a href="#!" class="nav-link" data-toggle="modal" data-target="#modal-chang-password">
                        <i class="nav-icon fas fa-lock"></i>
                        <p>
                            {{ __('msg.menu_change_password') }}
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('auth.logout') }}" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>
                            {{ __('msg.menu_logout') }}
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
