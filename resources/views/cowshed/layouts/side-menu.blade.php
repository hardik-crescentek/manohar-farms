<?php
$routeName = request()->route()->getName();
?>
<!-- Sidemenu -->
<div class="main-sidebar main-sidebar-sticky side-menu">
    <div class="sidemenu-logo">
        <a class="main-logo" href="{{ route('cowshed.dashboard') }}">
            <!-- <img src="{{URL::asset('assets/img/brand/logo-light.png')}}" class="header-brand-img desktop-logo" alt="logo">
            <img src="{{URL::asset('assets/img/brand/icon-light.png')}}" class="header-brand-img icon-logo" alt="logo">
            <img src="{{URL::asset('assets/img/brand/logo.png')}}" class="header-brand-img desktop-logo theme-logo" alt="logo">
            <img src="{{URL::asset('assets/img/brand/icon.png')}}" class="header-brand-img icon-logo theme-logo" alt="logo"> -->
            Cowshed
        </a>
    </div>
    <div class="main-sidebar-body">
        <ul class="nav">
            <li class="nav-header"><span class="nav-label">Dashboard</span></li>
            <li class="nav-item {{ $routeName == 'dashboard' ? 'active' : '' }}">
                <a class="nav-link" href="{{route('cowshed.dashboard')}}"><span class="shape1"></span><span class="shape2"></span><img src="{{ asset('assets/img/svgs/Dashboard.svg') }}" class="sidemenu-icon" alt=""><span class="sidemenu-label">Dashboard</span></a>
            </li>
            <li class="nav-header"><span class="nav-label">Applications</span></li>

            @if( Auth::user()->hasrole('super-admin') || Auth::user()->hasAnyPermission(['cows-add','cows-edit','cows-delete','cows-view']) )
                <li class="nav-item {{ $routeName == 'cowshed.cows.index' || $routeName == 'cowshed.cows.create' || $routeName == 'cowshed.cows.edit' || $routeName == 'cowshed.cows.show' ? 'active' : '' }}">
                    <a class="nav-link" href="{{route('cowshed.cows.index')}}"><span class="shape1"></span><span class="shape2"></span><img src="{{ asset('assets/img/svgs/Cow.svg') }}" class="sidemenu-icon" alt=""><span class="sidemenu-label">Cows</span></a>
                </li>
            @endif

            <li class="nav-item {{ $routeName == 'cowshed.staffs.index' || $routeName == 'cowshed.staffs.create' || $routeName == 'cowshed.staffs.edit' ? 'active' : '' }}">
                <a class="nav-link" href="{{route('cowshed.staffs.index')}}"><span class="shape1"></span><span class="shape2"></span><img src="{{ asset('assets/img/svgs/Staff Expenses.svg') }}" class="sidemenu-icon" alt=""><span class="sidemenu-label">Staff expenses</span></a>
            </li>

            <li class="nav-item {{ $routeName == 'cowshed.expenses.index' || $routeName == 'cowshed.expenses.create' || $routeName == 'cowshed.expenses.edit' ? 'active' : '' }}">
                <a class="nav-link" href="{{route('cowshed.expenses.index')}}"><span class="shape1"></span><span class="shape2"></span><img src="{{ asset('assets/img/svgs/miscellaneous 1.svg') }}" class="sidemenu-icon" alt=""><span class="sidemenu-label">Miscellaneous expenses</span></a>
            </li>

            <li class="nav-item {{ $routeName == 'cowshed.grass.index' || $routeName == 'cowshed.grass.create' || $routeName == 'cowshed.grass.edit' ? 'active' : '' }}">
                <a class="nav-link" href="{{route('cowshed.grass.index')}}"><span class="shape1"></span><span class="shape2"></span><img src="{{ asset('assets/img/svgs/grass 1.svg') }}" class="sidemenu-icon" alt=""><span class="sidemenu-label">Grass management</span></a>
            </li>

            <li class="nav-item {{ $routeName == 'cowshed.customers.index' || $routeName == 'cowshed.customers.create' || $routeName == 'cowshed.customers.edit' ? 'active' : '' }}">
                <a class="nav-link" href="{{route('cowshed.customers.index')}}"><span class="shape1"></span><span class="shape2"></span><img src="{{ asset('assets/img/svgs/customer 1.svg') }}" class="sidemenu-icon" alt=""><span class="sidemenu-label">Customers</span></a>
            </li>

            @if( Auth::user()->hasrole('super-admin'))
                <li class="nav-item {{ $routeName == 'cowshed.daily-milk.index' || $routeName == 'cowshed.daily-milk.create' || $routeName == 'cowshed.daily-milk.edit' || $routeName == 'cowshed.milk-payments.index' || $routeName == 'cowshed.milk-payments.create' || $routeName == 'cowshed.milk-payments.edit' ? 'active show' : '' }}">
                    <a class="nav-link with-sub" href="#"><span class="shape1"></span><span class="shape2"></span><img src="{{ asset('assets/img/svgs/Milk Management.svg') }}" class="sidemenu-icon" alt=""><span class="sidemenu-label">Milk management</span></a>
                    <ul class="nav-sub">
                        @if( Auth::user()->hasrole('super-admin'))
                            <li class="nav-sub-item">
                                <a class="nav-sub-link" href="{{route('cowshed.daily-milk.index')}}">Daily milk delivery</a>
                            </li>
                        @endif
                        @if( Auth::user()->hasrole('super-admin'))
                            <li class="nav-sub-item">
                                <a class="nav-sub-link" href="{{route('cowshed.milk-payments.index')}}">Milk Payments</a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif

            @if( Auth::user()->hasrole('super-admin'))
                <li class="nav-item {{ $routeName == 'cowshed.ghee-management.index' || $routeName == 'cowshed.ghee-management.create' || $routeName == 'cowshed.ghee-management.edit' || $routeName == 'cowshed.ghee-sellings.index' || $routeName == 'cowshed.ghee-sellings.create' || $routeName == 'cowshed.ghee-sellings.edit' ? 'active show' : '' }}">
                    <a class="nav-link with-sub" href="#"><span class="shape1"></span><span class="shape2"></span><img src="{{ asset('assets/img/svgs/ghee 1.svg') }}" class="sidemenu-icon" alt=""><span class="sidemenu-label">Ghee management</span></a>
                    <ul class="nav-sub">
                        @if( Auth::user()->hasrole('super-admin'))
                            <li class="nav-sub-item">
                                <a class="nav-sub-link" href="{{route('cowshed.ghee-management.index')}}">Ghee Entries</a>
                            </li>
                        @endif
                        @if( Auth::user()->hasrole('super-admin'))
                            <li class="nav-sub-item">
                                <a class="nav-sub-link" href="{{route('cowshed.ghee-sellings.index')}}">Ghee Selling</a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif

            <!-- <li class="nav-item {{ $routeName == 'cowshed.ghee-management.index' || $routeName == 'cowshed.ghee-management.create' || $routeName == 'cowshed.ghee-management.edit' ? 'active' : '' }}">
                <a class="nav-link" href="{{route('cowshed.ghee-management.index')}}"><span class="shape1"></span><span class="shape2"></span><img src="{{ asset('assets/img/svgs/ghee 1.svg') }}" class="sidemenu-icon" alt=""><span class="sidemenu-label">Ghee management</span></a>
            </li> -->

            @if(Auth::user()->hasrole('super-admin'))
                <li class="nav-item {{ $routeName == 'cowshed.reports.milk-report' || $routeName == 'cowshed.reports.staff-report' || $routeName == 'cowshed.expenses-reports.index' || $routeName == 'cowshed.reports.grass-report' || $routeName == 'cowshed.reports.ghee-report' || $routeName == 'cowshed.reports.ghee-selling-report' ? 'active show' : '' }}">
                    <a class="nav-link with-sub" href="#"><span class="shape1"></span><span class="shape2"></span><img src="{{ asset('assets/img/svgs/report-white.svg') }}" class="sidemenu-icon" alt=""><span class="sidemenu-label">Reports</span></a>
                    <ul class="nav-sub">
                        @if( Auth::user()->hasrole('super-admin'))
                            <li class="nav-sub-item">
                                <a class="nav-sub-link" href="{{route('cowshed.reports.milk-report')}}">Milk Reports</a>
                            </li>
                        @endif
                        @if( Auth::user()->hasrole('super-admin'))
                            <li class="nav-sub-item">
                                <a class="nav-sub-link" href="{{route('cowshed.reports.staff-report')}}">Staff Reports</a>
                            </li>
                        @endif
                        @if( Auth::user()->hasrole('super-admin'))
                            <li class="nav-sub-item">
                                <a class="nav-sub-link" href="{{route('cowshed.expenses-reports.index')}}">Expense Reports</a>
                            </li>
                        @endif
                        @if( Auth::user()->hasrole('super-admin'))
                            <li class="nav-sub-item">
                                <a class="nav-sub-link" href="{{route('cowshed.reports.grass-report')}}">Grass Reports</a>
                            </li>
                        @endif
                        @if( Auth::user()->hasrole('super-admin'))
                            <li class="nav-sub-item">
                                <a class="nav-sub-link" href="{{route('cowshed.reports.ghee-report')}}">Ghee Management Reports</a>
                            </li>
                        @endif
                        @if( Auth::user()->hasrole('super-admin'))
                            <li class="nav-sub-item">
                                <a class="nav-sub-link" href="{{route('cowshed.reports.ghee-selling-report')}}">Ghee Selling Reports</a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif
        </ul>
    </div>
</div>
<!-- End Sidemenu -->