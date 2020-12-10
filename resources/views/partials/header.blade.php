<header id="topnav">
    <div class="topbar-main">
        <div class="container-fluid">

            <!-- Logo container-->
            <div class="logo">
                <!-- Text Logo -->
                <a href="javascript:void(0);" class="logo">
                {{ config('app.name')  }}
                </a>
                <!-- Image Logo -->
               <!-- <a href="{{ route('home') }}" class="logo">
                    <!--<img src="assets/images/logo_darks.png" alt="" height="20" class="logo-lg">
                    <img src="{{ asset('assets/images/logo.jpg') }}" alt="" height="20" class="logo-lg">
                    <img src="{{ asset('assets/images/logo.jpg') }}" alt="" height="20" class="logo-sm">
                </a>-->

            </div>
            <!-- End Logo container-->

            <div class="menu-extras topbar-custom">

                <ul class="list-inline float-right mb-0">

                    <li class="menu-item list-inline-item">
                        <!-- Mobile menu toggle-->
                        <a class="navbar-toggle nav-link">
                            <div class="lines">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </a>
                        <!-- End mobile menu toggle-->
                    </li>
                    <!--<li class="list-inline-item dropdown notification-list">
                        <a class="nav-link dropdown-toggle arrow-none waves-light waves-effect" data-toggle="dropdown" href="page-starter#" role="button"
                           aria-haspopup="false" aria-expanded="false">
                            <i class="dripicons-bell noti-icon"></i>
                            <span class="badge badge-pink noti-icon-badge">4</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-arrow dropdown-lg" aria-labelledby="Preview">
                            <!-- item
                            <div class="dropdown-item noti-title">
                                <h5><span class="badge badge-danger float-right">5</span>Notification</h5>
                            </div>

                            <!-- item
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <div class="notify-icon bg-success"><i class="icon-bubble"></i></div>
                                <p class="notify-details">Robert S. Taylor commented on Admin<small class="text-muted">1 min ago</small></p>
                            </a>

                            <!-- item
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <div class="notify-icon bg-info"><i class="icon-user"></i></div>
                                <p class="notify-details">New user registered.<small class="text-muted">1 min ago</small></p>
                            </a>

                            <!-- item
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <div class="notify-icon bg-danger"><i class="icon-like"></i></div>
                                <p class="notify-details">Carlos Crouch liked <b>Admin</b><small class="text-muted">1 min ago</small></p>
                            </a>

                            <!-- All
                            <a href="javascript:void(0);" class="dropdown-item notify-item notify-all">
                                View All
                            </a>

                        </div>
                    </li>-->

                    <li class="list-inline-item dropdown notification-list">
                        <a class="nav-link dropdown-toggle waves-effect waves-light nav-user" data-toggle="dropdown" href="page-starter#" role="button"
                           aria-haspopup="false" aria-expanded="false">
                            {{ auth()->user()->username }}
                            <i class="fa fa-caret-down"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right profile-dropdown " aria-labelledby="Preview">
                            <!-- item-->
                            <!--<a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="md md-account-circle"></i> <span>Profile</span>
                            </a>-->

                            <!-- item-->
                            <a href="{{ route('account.settings') }}" class="dropdown-item notify-item">
                                <i class="md md-settings"></i> <span>Settings</span>
                            </a>

                            <!-- item-->
                            <!--<a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="md md-lock-open"></i> <span>Lock Screen</span>
                            </a>-->

                            <!-- item-->

                            <a href="{{ route('logout') }}" class="dropdown-item notify-item"
                               onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                <span class="md md-settings-power"></span>
                                <span> Logout</span>
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </div>
                    </li>

                </ul>
            </div>
            <!-- end menu-extras -->

            <div class="clearfix"></div>

        </div> <!-- end container -->
    </div>
    <!-- end topbar-main -->

    <div class="navbar-custom">
        <div class="container-fluid">
            <div id="navigation">
                <!-- Navigation Menu-->
                <ul class="navigation-menu">

                    <li class="has-submenu">
                        <a href="{{ route('home') }}"><i class="md md-dashboard"></i>Dashboard</a>
                    </li>

                    @if(auth()->user()->can('components_show') || auth()->user()->can('components_create')  )
                    <li class="has-submenu">
                        <a href="#"><i class="fa fa-th-list"></i>Components</a>
                        <ul class="submenu">
                            @can('components_create')
                            <li>
                                <a href="{{ route('components.create') }}">
                                    <i class="fa fa-plus-circle"></i>
                                    Add new Component
                                </a>
                            </li>
                            @endcan
                            @can('components_show')
                            <li>
                                <a href="{{ route('components.index') }}">
                                    <i class="fa fa-list"></i>
                                    View all Components
                                </a>
                            </li>
                                @endcan
                        </ul>
                    </li>
                    @endif

                    @if(auth()->user()->can('items_show') || auth()->user()->can('items_create')  )
                    <li class="has-submenu">
                        <a href="#"><i class="fa fa-tag"></i>Items</a>
                        <ul class="submenu">
                            @isset($item->id)
                                <li hidden><a href="">{{ route('items.show',  $item->id ) }}</a></li>
                            @endisset
                            @isset($item->id)
                                <li hidden><a href="">{{ route('items.edit',  $item->id ) }}</a></li>
                            @endisset
                                @can('items_create')
                                <li>
                                <a href="{{ route('items.create') }}">
                                    <i class="fa fa-plus-circle"></i>
                                    Add new Item
                                </a>
                                </li>
                                <li>
                                <a href="{{ route('items.import') }}">
                                    <i class="fa fa-cloud-upload"></i>
                                    Import Items
                                </a>
                                </li>
                                @endcan
                                @can('items_show')
                                <li>
                                <a href="{{ route('items.index') }}">
                                    <i class="fa fa-list"></i>
                                    View all Items
                                </a>
                                </li>
                                @endcan
                        </ul>
                    </li>
                    @endif

                    @if(auth()->user()->can('mixes_show') || auth()->user()->can('mixes_create')  )

                    <li class="has-submenu">
                        <a href="#"><i class="fa fa-flask"></i>Mixes</a>
                        <ul class="submenu">
                            @isset($mix->id)
                                <li hidden><a href="">{{ route('mixes.show',  $mix->id ) }}</a></li>
                            @endisset
                            @isset($mix->id)
                                <li hidden><a href="">{{ route('mixes.edit',  $mix->id ) }}</a></li>
                            @endisset
                            @can('mixes_create')
                                <li>
                                <a href="{{ route('mixes.create') }}">
                                    <i class="fa fa-plus-circle"></i>
                                    Add new Mix
                                </a>
                                </li>
                            @endcan
                            @can('mixes_show')
                                <li>
                                <a href="{{ route('mixes.index') }}">
                                    <i class="fa fa-list"></i>
                                    View all Mixes
                                </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                    @endif

                    @can('logs_show')
                    <li class="has-submenu">
                        <a href="{{ url('logs') }}"><i class="md md-report"></i>Logs</a>
                    </li>
                    @endcan

                    @hasrole('super_admin')
                    <li class="has-submenu">
                        <a href="#"><i class="fa fa-lock"></i>Roles</a>
                        <ul class="submenu">
                            @isset($role->id)
                                <li hidden><a href="">{{ route('roles.edit',  $role->id ) }}</a></li>
                            @endisset
                            <li>
                                <a href="{{ route('roles.create') }}">
                                    <i class="fa fa-plus-circle"></i>
                                    Add new Role
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('roles.index') }}">
                                    <i class="fa fa-list"></i>
                                    View all Roles
                                </a>
                            </li>
                        </ul>
                    </li>
                    @endhasrole

                    @hasrole('super_admin')
                    <li class="has-submenu">
                        <a href="#"><i class="fa fa-users"></i>System Users</a>
                        <ul class="submenu">
                            @isset($user->id)
                                <li hidden><a href="">{{ route('users.edit',  $user->id ) }}</a></li>
                            @endisset
                            <li>
                                <a href="{{ route('users.create') }}">
                                    <i class="fa fa-plus-circle"></i>
                                    Add new User
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('users.index') }}">
                                    <i class="fa fa-list"></i>
                                    View all Users
                                </a>
                            </li>
                        </ul>
                    </li>
                    @endhasrole
                </ul>
                <!-- End navigation menu -->
            </div> <!-- end #navigation -->
        </div> <!-- end container -->
    </div> <!-- end navbar-custom -->
</header>
