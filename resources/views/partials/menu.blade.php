<aside class="main-sidebar sidebar-dark-primary elevation-4" style="min-height: 917px;">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <span class="brand-text font-weight-light">{{ trans('panel.site_title') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route("admin.home") }}" class="nav-link {{ request()->is("admin") || request()->is("admin") ? "active" : "" }}">
                        <i class="fas fa-fw fa-tachometer-alt nav-icon">
                        </i>
                        <p>
                            {{ trans('global.dashboard') }}
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route("admin.system-calendar.index") }}" class="nav-link {{ request()->is("admin/system-calendar") || request()->is("admin/system-calendar/*") ? "active" : "" }}">
                        <i class="fas fa-fw fa-calendar nav-icon">

                        </i>
                        <p>
                            {{ trans('global.systemCalendar') }}
                        </p>
                    </a>
                </li>
                @can('time_entry_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.time-entries.index") }}" class="nav-link {{ request()->is("admin/time-entries") || request()->is("admin/time-entries/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-clock">

                            </i>
                            <p>
                                {{ trans('cruds.timeEntry.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('time_work_type_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.time-work-types.index") }}" class="nav-link {{ request()->is("admin/time-work-types") || request()->is("admin/time-work-types/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-briefcase">

                            </i>
                            <p>
                                {{ trans('cruds.timeWorkType.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('time_population_type_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.time-population-types.index") }}" class="nav-link {{ request()->is("admin/time-population-types") || request()->is("admin/time-population-types/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-user-tag">

                            </i>
                            <p>
                                Population types
                            </p>
                        </a>
                    </li>
                @endcan
                @can('time_caseload_type_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.time-caseload-types.index") }}" class="nav-link {{ request()->is("admin/time-caseload-types") || request()->is("admin/time-caseload-types/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon far fa-address-book">

                            </i>
                            <p>
                                Caseload types
                            </p>
                        </a>
                    </li>
                @endcan
                @can('time_report_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.time-reports.index") }}" class="nav-link {{ request()->is("admin/time-reports") || request()->is("admin/time-reports/*") ? "active" : "" }}">
                            <i class="fa-fw nav-icon fas fa-chart-line">

                            </i>
                            <p>
                                Time report
                            </p>
                        </a>
                    </li>
                @endcan
                @can('user_management_access')
                    <li class="nav-item has-treeview {{ request()->is("admin/users*") ? "menu-open" : "" }} {{ request()->is("admin/roles*") ? "menu-open" : "" }} {{ request()->is("admin/permissions*") ? "menu-open" : "" }}">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="fa-fw nav-icon fas fa-users">

                            </i>
                            <p>
                                {{ trans('cruds.userManagement.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('user_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.users.index") }}" class="nav-link {{ request()->is("admin/users") || request()->is("admin/users/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-user">

                                        </i>
                                        <p>
                                            {{ trans('cruds.user.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('role_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.roles.index") }}" class="nav-link {{ request()->is("admin/roles") || request()->is("admin/roles/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-briefcase">

                                        </i>
                                        <p>
                                            {{ trans('cruds.role.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('permission_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.permissions.index") }}" class="nav-link {{ request()->is("admin/permissions") || request()->is("admin/permissions/*") ? "active" : "" }}">
                                        <i class="fa-fw nav-icon fas fa-unlock-alt">

                                        </i>
                                        <p>
                                            {{ trans('cruds.permission.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @if(file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php')))
                    @can('profile_password_edit')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('profile/password') || request()->is('profile/password/*') ? 'active' : '' }}" href="{{ route('profile.password.edit') }}">
                                <i class="fa-fw fas fa-user-cog nav-icon">
                                </i>
                                <p>
                                    Account settings
                                </p>
                            </a>
                        </li>
                    @endcan
                @endif
                <li class="nav-item">
                    <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                        <p>
                            <i class="fas fa-fw fa-sign-out-alt nav-icon">

                            </i>
                            <p>{{ trans('global.logout') }}</p>
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>