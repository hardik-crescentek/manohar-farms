<?php
$routeName = request()->route()->getName();
?>
<!-- Sidemenu -->
<div class="main-sidebar main-sidebar-sticky side-menu">
    <div class="sidemenu-logo">
        <a class="main-logo" href="{{ url('dashboard') }}">
            <!-- <img src="{{ URL::asset('assets/img/brand/logo-light.png') }}" class="header-brand-img desktop-logo" alt="logo">
            <img src="{{ URL::asset('assets/img/brand/icon-light.png') }}" class="header-brand-img icon-logo" alt="logo">
            <img src="{{ URL::asset('assets/img/brand/logo.png') }}" class="header-brand-img desktop-logo theme-logo" alt="logo">
            <img src="{{ URL::asset('assets/img/brand/icon.png') }}" class="header-brand-img icon-logo theme-logo" alt="logo"> -->
            Manohar Farms
        </a>
    </div>
    <div class="main-sidebar-body">
        <ul class="nav">
            <li class="nav-header"><span class="nav-label">Dashboard</span></li>
            <li class="nav-item {{ $routeName == 'dashboard' ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('dashboard') }}"><span class="shape1"></span><span
                        class="shape2"></span><img src="{{ asset('assets/img/svgs/Dashboard.svg') }}"
                        class="sidemenu-icon" alt=""><span class="sidemenu-label">Dashboard</span></a>
            </li>
            <li class="nav-header"><span class="nav-label">Applications</span></li>

            {{-- @if (Auth::user()->hasrole('super-admin') || Auth::user()->hasAnyPermission(['modules-add', 'modules-edit', 'modules-delete', 'modules-view']))
                <li class="nav-item {{ $routeName == 'modules.index' || $routeName == 'modules.create' || $routeName == 'modules.edit' ? 'active' : '' }}">
                    <a class="nav-link" href="{{route('modules.index')}}"><span class="shape1"></span><span class="shape2"></span><img src="{{ asset('assets/img/svgs/infrastructure.svg') }}" class="sidemenu-icon" alt=""><span class="sidemenu-label">Modules</span></a>
                </li>
            @endif --}}

            @if (Auth::user()->hasrole('super-admin') ||
                    Auth::user()->hasAnyPermission(['admins-add', 'admins-edit', 'admins-delete', 'admins-view']))
                <li
                    class="nav-item {{ $routeName == 'admins.index' || $routeName == 'admins.create' || $routeName == 'admins.edit' ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('admins.index') }}"><span class="shape1"></span><span
                            class="shape2"></span><img src="{{ asset('assets/img/svgs/Admin.svg') }}"
                            class="sidemenu-icon" alt=""><span class="sidemenu-label">Admins</span></a>
                </li>
            @endif

            @if (Auth::user()->hasrole('super-admin') ||
                    Auth::user()->hasAnyPermission(['plants-add', 'plants-edit', 'plants-delete', 'plants-view']))
                <li
                    class="nav-item {{ $routeName == 'plants.index' || $routeName == 'plants.create' || $routeName == 'plants.edit' ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('plants.index') }}"><span class="shape1"></span><span
                            class="shape2"></span><img src="{{ asset('assets/img/svgs/plants.svg') }}"
                            class="sidemenu-icon" alt=""><span class="sidemenu-label">Plants</span></a>
                </li>
            @endif

            @if (Auth::user()->hasrole('super-admin') ||
                    Auth::user()->hasAnyPermission([
                        'fertilizer-pesticides-add',
                        'fertilizer-pesticides-edit',
                        'fertilizer-pesticides-delete',
                        'fertilizer-pesticides-view',
                    ]))
                <li
                    class="nav-item {{ $routeName == 'fertilizer-pesticides.index' || $routeName == 'fertilizer-pesticides.create' || $routeName == 'fertilizer-pesticides.edit' || $routeName == 'fertilizer-pesticides.compost.index' || $routeName == 'jivamrut-fertilizer.index' || $routeName == 'jivamrut-fertilizer.create' || $routeName == 'jivamrut-fertilizer.edit' || $routeName == 'jivamrut-fertilizer.show' || $routeName == 'vermi-compost.index' || $routeName == 'vermi-compost.create' || $routeName == 'vermi-compost.edit' ? 'active show' : '' }}">
                    <a class="nav-link with-sub" href="#"><span class="shape1"></span><span
                            class="shape2"></span><img
                            src="{{ asset('assets/img/svgs/Fertilizer and Pesticides.svg') }}" class="sidemenu-icon"
                            alt=""><span class="sidemenu-label">Fertilizer and Pesticides</span></a>
                    <ul class="nav-sub">
                        <li class="nav-sub-item">
                            <a class="nav-sub-link" href="{{ route('fertilizer-pesticides.index') }}">Fertilizer and
                                Pesticides Managements</a>
                        </li>
                        <li class="nav-sub-item">
                            <a class="nav-sub-link" href="{{ route('jivamrut-fertilizer.index') }}">Jivamrut
                                Fertilizer</a>
                        </li>
                        <li class="nav-sub-item">
                            <a class="nav-sub-link" href="{{ route('vermi-compost.index') }}">Vermi compost</a>
                        </li>
                    </ul>
                </li>
            @endif

            <!-- @if (Auth::user()->hasrole('super-admin') ||
                    Auth::user()->hasAnyPermission(['staffs-add', 'staffs-edit', 'staffs-delete', 'staffs-view']))
<li class="nav-item {{ $routeName == 'staffs.index' || $routeName == 'staffs.create' || $routeName == 'staffs.edit' || $routeName == 'staff.teams' ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('staffs.index') }}"><span class="shape1"></span><span class="shape2"></span><i class="fa fa-users sidemenu-icon"></i><span class="sidemenu-label">Staffs</span></a>
                </li>
@endif -->

            @if (Auth::user()->hasrole('super-admin') ||
                    Auth::user()->hasAnyPermission(['staffs-add', 'staffs-edit', 'staffs-delete', 'staffs-view']))
                <li
                    class="nav-item {{ $routeName == 'staffs.index' || $routeName == 'staffs.create' || $routeName == 'staffs.edit' || $routeName == 'staff.teams' || $routeName == 'staff.attendance-history' || $routeName == 'staff.daily-attendance' ? 'active show' : '' }}">
                    <a class="nav-link with-sub" href="#"><span class="shape1"></span><span
                            class="shape2"></span><img src="{{ asset('assets/img/svgs/Staff Management.svg') }}"
                            class="sidemenu-icon" alt=""><span class="sidemenu-label">Staff
                            Management</span></a>
                    <ul class="nav-sub">
                        @if (Auth::user()->hasrole('super-admin') ||
                                Auth::user()->hasAnyPermission(['staffs-add', 'staffs-edit', 'staffs-delete', 'staffs-view']))
                            <li class="nav-sub-item">
                                <a class="nav-sub-link" href="{{ route('staffs.index') }}">Staffs</a>
                            </li>
                        @endif
                        @if (Auth::user()->hasrole('super-admin') ||
                                Auth::user()->hasAnyPermission(['staffs-add', 'staffs-edit', 'staffs-delete', 'staffs-view']))
                            <li class="nav-sub-item">
                                <a class="nav-sub-link" href="{{ route('staff.daily-attendance') }}">Daily
                                    attendance</a>
                            </li>
                        @endif
                        @if (Auth::user()->hasrole('super-admin') ||
                                Auth::user()->hasAnyPermission(['staffs-add', 'staffs-edit', 'staffs-delete', 'staffs-view']))
                            <li class="nav-sub-item">
                                <a class="nav-sub-link" href="{{ route('staff.attendance-history') }}">Attendance
                                    History</a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif

            @if (Auth::user()->hasrole('super-admin') ||
                    Auth::user()->hasAnyPermission(['vehicles-add', 'vehicles-edit', 'vehicles-delete', 'vehicles-view']))
                <li
                    class="nav-item {{ $routeName == 'vehicles.index' || $routeName == 'vehicles.create' || $routeName == 'vehicles.edit' ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('vehicles.index') }}"><span class="shape1"></span><span
                            class="shape2"></span><img src="{{ asset('assets/img/svgs/car 1.svg') }}"
                            class="sidemenu-icon" alt=""><span class="sidemenu-label">Vehicles and
                            Attachments</span></a>
                </li>
            @endif

            @if (Auth::user()->hasrole('super-admin') ||
                    Auth::user()->hasAnyPermission([
                        'diesels-add',
                        'diesels-edit',
                        'diesels-delete',
                        'diesels-view',
                        'diesel-entries-add',
                        'diesel-entries-edit',
                        'diesel-entries-delete',
                        'diesel-entries-view',
                    ]))
                <li
                    class="nav-item {{ $routeName == 'diesels.index' || $routeName == 'diesels.create' || $routeName == 'diesels.edit' || $routeName == 'diesel-entries.index' || $routeName == 'diesel-entries.create' || $routeName == 'diesel-entries.edit' ? 'active show' : '' }}">
                    <a class="nav-link with-sub" href="#"><span class="shape1"></span><span
                            class="shape2"></span><img src="{{ asset('assets/img/svgs/Diesel Management.svg') }}"
                            class="sidemenu-icon" alt=""><span class="sidemenu-label">Diesel
                            Managements</span></a>
                    <ul class="nav-sub">
                        @if (Auth::user()->hasrole('super-admin') ||
                                Auth::user()->hasAnyPermission(['diesels-add', 'diesels-edit', 'diesels-delete', 'diesels-view']))
                            <li class="nav-sub-item">
                                <a class="nav-sub-link" href="{{ route('diesels.index') }}">Diesel Managements</a>
                            </li>
                        @endif
                        @if (Auth::user()->hasrole('super-admin') ||
                                Auth::user()->hasAnyPermission([
                                    'diesel-entries-add',
                                    'diesel-entries-edit',
                                    'diesel-entries-delete',
                                    'diesel-entries-view',
                                ]))
                            <li class="nav-sub-item">
                                <a class="nav-sub-link" href="{{ route('diesel-entries.index') }}">Diesel Entries</a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif

            @if (Auth::user()->hasrole('super-admin') ||
                    Auth::user()->hasAnyPermission(['lands-add', 'lands-edit', 'lands-delete', 'lands-view']))
                <li
                    class="nav-item {{ $routeName == 'lands.index' || $routeName == 'lands.create' || $routeName == 'lands.edit' || $routeName == 'lands.maps' ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('lands.index') }}"><span class="shape1"></span><span
                            class="shape2"></span><img src="{{ asset('assets/img/svgs/infrastructure.svg') }}"
                            class="sidemenu-icon" alt=""><span class="sidemenu-label">Plots</span></a>
                </li>
            @endif

            @if (Auth::user()->hasrole('super-admin') ||
                    Auth::user()->hasAnyPermission(['water-add', 'water-edit', 'water-delete', 'water-view']))
                <li
                    class="nav-item {{ $routeName == 'water.index' || $routeName == 'water.create' || $routeName == 'water.edit' ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('water.index') }}"><span class="shape1"></span><span
                            class="shape2"></span><img src="{{ asset('assets/img/svgs/water-Management.svg') }}"
                            class="sidemenu-icon" alt=""><span class="sidemenu-label">Water
                            management</span></a>
                </li>
            @endif

            @if (Auth::user()->hasrole('super-admin') ||
                    Auth::user()->hasAnyPermission(['bore-wells-add', 'bore-wells-edit', 'bore-wells-delete', 'bore-wells-view']))
                <li
                    class="nav-item {{ $routeName == 'bore-wells.index' || $routeName == 'bore-wells.create' || $routeName == 'bore-wells.edit' ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('bore-wells.index') }}"><span class="shape1"></span><span
                            class="shape2"></span><img src="{{ asset('assets/img/svgs/water-Management.svg') }}"
                            class="sidemenu-icon" alt=""><span class="sidemenu-label">Bore & Wells
                            management</span></a>
                </li>
            @endif

            @if (Auth::user()->hasrole('super-admin') ||
                    Auth::user()->hasAnyPermission(['bills-add', 'bills-edit', 'bills-delete', 'bills-view']))
                <li
                    class="nav-item {{ $routeName == 'bills.index' || $routeName == 'bills.create' || $routeName == 'bills.edit' ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('bills.index') }}"><span class="shape1"></span><span
                            class="shape2"></span><img src="{{ asset('assets/img/svgs/Bill.svg') }}"
                            class="sidemenu-icon" alt=""><span class="sidemenu-label">Bills
                            management</span></a>
                </li>
            @endif

            @if (Auth::user()->hasrole('super-admin') ||
                    Auth::user()->hasAnyPermission(['expenses-add', 'expenses-edit', 'expenses-delete', 'expenses-view']))
                <li
                    class="nav-item {{ $routeName == 'expenses.index' || $routeName == 'expenses.create' || $routeName == 'expenses.edit' ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('expenses.index') }}"><span class="shape1"></span><span
                            class="shape2"></span><img src="{{ asset('assets/img/svgs/Expenses.svg') }}"
                            class="sidemenu-icon" alt=""><span class="sidemenu-label">Expenses</span></a>
                </li>
            @endif


            @if (Auth::user()->hasrole('super-admin') ||
                    Auth::user()->hasAnyPermission([
                        'infrastructure-add',
                        'infrastructure-edit',
                        'infrastructure-delete',
                        'infrastructure-view',
                    ]))
                <li
                    class="nav-item {{ $routeName == 'infrastructure.index' || $routeName == 'infrastructure.create' || $routeName == 'infrastructure.edit' ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('infrastructure.index') }}"><span class="shape1"></span><span
                            class="shape2"></span> <img src="{{ asset('assets/img/svgs/infrastructure.svg') }}"
                            class="sidemenu-icon" alt=""> <span
                            class="sidemenu-label">Infrastructure</span></a>
                </li>
            @endif

            @if (Auth::user()->hasrole('super-admin') ||
                    Auth::user()->hasAnyPermission(['tasks-add', 'tasks-edit', 'tasks-delete', 'tasks-view']))
                <li
                    class="nav-item {{ $routeName == 'tasks.index' || $routeName == 'tasks.create' || $routeName == 'tasks.edit' ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('tasks.index') }}"><span class="shape1"></span><span
                            class="shape2"></span><img src="{{ asset('assets/img/svgs/to-do-list.svg') }}"
                            class="sidemenu-icon" alt=""><span class="sidemenu-label">Tasks</span></a>
                </li>
            @endif

            @if (Auth::user()->hasrole('super-admin') ||
                    Auth::user()->hasAnyPermission(['cameras-add', 'cameras-edit', 'cameras-delete', 'cameras-view']))
                <li
                    class="nav-item {{ $routeName == 'cameras.index' || $routeName == 'cameras.create' || $routeName == 'cameras.edit' ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('cameras.index') }}"><span class="shape1"></span><span
                            class="shape2"></span><img src="{{ asset('assets/img/svgs/Expenses.svg') }}"
                            class="sidemenu-icon" alt=""><span class="sidemenu-label">Camera
                            Details</span></a>
                </li>
            @endif

            {{-- This is a Miscellaneous --}}
            @if (Auth::user()->hasrole('super-admin') ||
                    Auth::user()->hasAnyPermission([
                        'miscellaneous-add',
                        'miscellaneous-edit',
                        'miscellaneous-delete',
                        'miscellaneous-view',
                    ]))
                <li
                    class="nav-item {{ $routeName == 'miscellaneous.index' || $routeName == 'miscellaneous.create' || $routeName == 'miscellaneous.edit' ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('miscellaneous.index') }}"><span class="shape1"></span><span
                            class="shape2"></span><img src="{{ asset('assets/img/svgs/miscellaneous.svg') }}"
                            class="sidemenu-icon" alt=""><span
                            class="sidemenu-label">Miscellaneous</span></a>
                </li>
            @endif

            @if (Auth::user()->hasrole('super-admin') || Auth::user()->hasAnyPermission(['reports-view']))
                <li
                    class="nav-item {{ $routeName == 'reports.index' || $routeName == 'expenses-reports.index' || $routeName == 'water-reports.index' || $routeName == 'diesel-reports.index' || $routeName == 'bill-reports.index' || $routeName == 'plant-reports.index' || $routeName == 'fertilizer-pesticides-reports.index' || $routeName == 'staffs-reports.index' || $routeName == 'vehicles-services-reports.index' || $routeName == 'diesel-management-reports.index' || $routeName == 'infrastructure-reports.index' ? 'active show' : '' }}">
                    <a class="nav-link with-sub" href="#"><span class="shape1"></span><span
                            class="shape2"></span><img src="{{ asset('assets/img/svgs/report.svg') }}"
                            class="sidemenu-icon" alt=""><span class="sidemenu-label">Reports</span></a>
                    <ul class="nav-sub">

                        <li class="nav-sub-item {{ $routeName == 'reports.index' ? 'active' : '' }}">
                            <a class="nav-sub-link" href="{{ route('reports.index') }}">Reports</a>
                        </li>

                        <li class="nav-sub-item {{ $routeName == 'plant-reports.index' ? 'active' : '' }}">
                            <a class="nav-sub-link" href="{{ route('plant-reports.index') }}">Plants</a>
                        </li>

                        <li
                            class="nav-sub-item {{ $routeName == 'fertilizer-pesticides-reports.index' ? 'active' : '' }}">
                            <a class="nav-sub-link"
                                href="{{ route('fertilizer-pesticides-reports.index') }}">Fertilizer Pesticides</a>
                        </li>

                        <li class="nav-sub-item {{ $routeName == 'staffs-reports.index' ? 'active' : '' }}">
                            <a class="nav-sub-link" href="{{ route('staffs-reports.index') }}">Staffs</a>
                        </li>

                        <li
                            class="nav-sub-item {{ $routeName == 'vehicles-services-reports.index' ? 'active' : '' }}">
                            <a class="nav-sub-link" href="{{ route('vehicles-services-reports.index') }}">Vehicle
                                Service</a>
                        </li>

                        <li class="nav-sub-item {{ $routeName == 'diesel-reports.index' ? 'active' : '' }}">
                            <a class="nav-sub-link" href="{{ route('diesel-reports.index') }}">Diesels</a>
                        </li>

                        <li
                            class="nav-sub-item {{ $routeName == 'diesel-management-reports.index' ? 'active' : '' }}">
                            <a class="nav-sub-link" href="{{ route('diesel-management-reports.index') }}">Diesel
                                Management</a>
                        </li>

                        <li class="nav-sub-item {{ $routeName == 'water-reports.index' ? 'active' : '' }}">
                            <a class="nav-sub-link" href="{{ route('water-reports.index') }}">Waters</a>
                        </li>

                        <li class="nav-sub-item {{ $routeName == 'bill-reports.index' ? 'active' : '' }}">
                            <a class="nav-sub-link" href="{{ route('bill-reports.index') }}">Bills</a>
                        </li>

                        <li class="nav-sub-item {{ $routeName == 'expenses-reports.index' ? 'active' : '' }}">
                            <a class="nav-sub-link" href="{{ route('expenses-reports.index') }}">Expenses</a>
                        </li>

                        <li class="nav-sub-item {{ $routeName == 'infrastructure-reports.index' ? 'active' : '' }}">
                            <a class="nav-sub-link"
                                href="{{ route('infrastructure-reports.index') }}">Infrastructure</a>
                        </li>

                        {{-- Plot Report --}}
                        <li class="nav-sub-item {{ $routeName == 'plot-reports.index' ? 'active' : '' }}">
                            <a class="nav-sub-link"
                                href="{{ route('plot-reports.index') }}">Plot</a>
                        </li>
                    </ul>
                </li>
            @endif
        </ul>
    </div>
</div>
<!-- End Sidemenu -->
