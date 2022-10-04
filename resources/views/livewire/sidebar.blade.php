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
                {{-- <a href="#" class="d-block">{{ Str::ucfirst(auth()->user()->full_name) }}</a>
                <a href="#" class="d-block"><small>{{ Str::ucfirst(auth()->user()->user_role) }}</small></a> --}}
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
                                <a href="{{ route('setting.user.index') }}"
                                    class="nav-link {{ Request::segment(1) == 'setting' && Request::segment(2) == 'user' ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>{{ __('msg.menu_setting_user') }}</p>
                                </a>
                            </small>
                        </li>
                        {{-- <li class="nav-item">
                            <small>
                                <a href="{{ route('setting.bank.index') }}"
                                    class="nav-link {{ Request::segment(1) == 'setting' && Request::segment(2) == 'bank' ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>{{ __('msg.menu_setting_bank') }}</p>
                                </a>
                            </small>
                        </li>
                        <li class="nav-item">
                            <small>
                                <a href="{{ route('setting.contact.index') }}"
                                    class="nav-link {{ Request::segment(1) == 'setting' && Request::segment(2) == 'contact' ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>{{ __('msg.menu_setting_contact') }}</p>
                                </a>
                            </small>
                        </li>
                        <li class="nav-item">
                            <small>
                                <a href="{{ route('setting.facilities.index') }}"
                                    class="nav-link {{ Request::segment(1) == 'setting' && Request::segment(2) == 'facilities' ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>{{ __('msg.menu_setting_facilities') }}</p>
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
                        <li class="nav-item">
                            <small>
                                <a href="{{ route('setting.room.index') }}"
                                    class="nav-link {{ Request::segment(1) == 'setting' && Request::segment(2) == 'room' ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>{{ __('msg.menu_setting_room') }}</p>
                                </a>
                            </small>
                        </li> --}}
                    </ul>
                </li>
                {{-- <li class="nav-item {{ Request::segment(1) == 'booking' ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Request::segment(1) == 'booking' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-home"></i>
                        <p>
                            {{ __('msg.menu_booking') }}
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <small>
                                <a href="{{ route('booking.reservation.index') }}"
                                    class="nav-link {{ Request::segment(1) == 'booking' && Request::segment(2) == 'reservation' ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>{{ __('msg.menu_booking_reservation') }}</p>
                                </a>
                            </small>
                        </li>
                        <li class="nav-item">
                            <small>
                                <a href="{{ route('booking.checkin.index') }}"
                                    class="nav-link {{ Request::segment(1) == 'booking' && Request::segment(2) == 'checkin' ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>{{ __('msg.menu_booking_checkin') }}</p>
                                </a>
                            </small>
                        </li>
                        <li class="nav-item">
                            <small>
                                <a href="{{ route('booking.checkout.index') }}"
                                    class="nav-link {{ Request::segment(1) == 'booking' && Request::segment(2) == 'checkout' ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>{{ __('msg.menu_booking_checkout') }}</p>
                                </a>
                            </small>
                        </li>
                        <li class="nav-item">
                            <small>
                                <a href="{{ route('booking.check.index') }}"
                                    class="nav-link {{ Request::segment(1) == 'booking' && Request::segment(2) == 'check' ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>{{ __('msg.menu_booking_check') }}</p>
                                </a>
                            </small>
                        </li>
                    </ul>
                </li>
                <li class="nav-item {{ Request::segment(1) == 'account-owner' ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-money-check"></i>
                        <p>
                            {{ __('msg.menu_account_owner') }}
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <small>
                                <a href="{{ route('account-owner.expenses.index') }}"
                                    class="nav-link {{ Request::segment(1) == 'account-owner' && Request::segment(2) == 'expenses' ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>{{ __('msg.menu_account_owner_expenses') }}</p>
                                </a>
                            </small>
                        </li>
                    </ul>
                </li>
                <li class="nav-item {{ Request::segment(1) == 'account-agent' ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-money-check"></i>
                        <p>
                            {{ __('msg.menu_account_agent') }}
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <small>
                                <a href="{{ route('account-agent.expenses.index') }}"
                                    class="nav-link {{ Request::segment(1) == 'account-agent' && Request::segment(2) == 'expenses' ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>{{ __('msg.menu_account_agent_expenses') }}</p>
                                </a>
                            </small>
                        </li>
                    </ul>
                </li>
                <li class="nav-item {{ Request::segment(1) == 'report' ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>
                            {{ __('msg.menu_report') }}
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <small>
                                <a href="{{ route('report.income-owner.index') }}" class="nav-link {{ Request::segment(1) == 'report' && Request::segment(2) == 'income-owner' ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>{{ __('msg.menu_report_income_owner') }}</p>
                                </a>
                            </small>
                        </li>
                        <li class="nav-item">
                            <small>
                                <a href="{{ route('report.income-agent.index') }}" class="nav-link {{ Request::segment(1) == 'report' && Request::segment(2) == 'income-agent' ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>{{ __('msg.menu_report_income_agent') }}</p>
                                </a>
                            </small>
                        </li>
                        <li class="nav-item">
                            <small>
                                <a href="{{ route('report.analyze.index') }}" class="nav-link {{ Request::segment(1) == 'report' && Request::segment(2) == 'analyze' ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>{{ __('msg.menu_report_analyze') }}</p>
                                </a>
                            </small>
                        </li>
                        <li class="nav-item">
                            <small>
                                <a href="{{ route('report.province.index') }}" class="nav-link {{ Request::segment(1) == 'report' && Request::segment(2) == 'province' ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>{{ __('msg.menu_report_province') }}</p>
                                </a>
                            </small>
                        </li>
                        <li class="nav-item">
                            <small>
                                <a href="{{ route('report.room.index') }}" class="nav-link {{ Request::segment(1) == 'report' && Request::segment(2) == 'room' ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>{{ __('msg.menu_report_room') }}</p>
                                </a>
                            </small>
                        </li>
                        <li class="nav-item">
                            <small>
                                <a href="{{ route('report.expenses-agent.index') }}" class="nav-link {{ Request::segment(1) == 'report' && Request::segment(2) == 'expenses-agent' ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>{{ __('msg.menu_report_expenses_agent') }}</p>
                                </a>
                            </small>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ route('print.index') }}" class="nav-link {{ Request::segment(1) == 'print' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-print"></i>
                        <p>
                            {{ __('msg.menu_print') }}
                        </p>
                    </a>
                </li>--}}
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
