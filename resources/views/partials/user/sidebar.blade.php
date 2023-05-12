<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <!-- <a href="#"> <img alt="image" src="{{ asset('assets/img/image0.png') }}" class="header-logo" /> -->
            <!-- <span class="logo-name" style="font-weight: 600; font-size:21px;">CarterBiggs Logistics</span> -->
            <center>
            <img alt="image" style="width:70%;" src="{{ asset('assets/img/logo_b.png') }}">
          </center>

          <br>
        </div>



        <ul class="sidebar-menu">
            @can('isAdmin')
                <li class="menu-header">MAIN</li>
                <li class="">
                    <a href="/dashboard" class="menu-toggle nav-link"><i
                            data-feather="airplay"></i><span>Dashboard</span></a>
                </li>
                @can('isLabAdmin')
                    <li>
                        <a href="/my-lab" class="menu-toggle nav-link"><i class="fa fa-vial"></i><span>Lab</span></a>
                    </li>
                @endcan

                <li class="dropdown">
                    <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="menu"></i><span>Collections</span></a>
                    <ul class="dropdown-menu">
                        <li class="dropdown">
                            <a href="#" class="menu-toggle nav-link has-dropdown"><span>Sample
                                    Pickup Request</span></a>
                            <ul class="dropdown-menu">
                                <li><a class="nav-link" href="/create-order">Request Sample</a></li>
                                <li><a class="nav-link" href="/all-orders">All Requests</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="menu-toggle nav-link has-dropdown"><span>Care Pack
                                    Request</span></a>
                            <ul class="dropdown-menu">
                                <li><a class="nav-link" href="/pack-request">Request Care Pack</a></li>
                                <li><a class="nav-link" href="/all-care-packs">All Requests</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
            <!-- @endcan

            @can('isLabAdmin')
                <li>
                    <a href="/my-lab" class="menu-toggle nav-link"><i class="fa fa-vial"></i><span>Lab</span></a>
                </li>
            @endcan -->

            @can('isSuperAdminOrMmiaAgents')
            <li class="dropdown">
                <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="file-plus"></i><span>MMIA
                        info</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="/create-flight">Enter Flight info</a></li>
                    <li><a class="nav-link" href="/all-flights">Manage information</a></li>
                    <!-- <li><a class="nav-link" href="#">Generate Reports</a></li> -->
                </ul>
            </li>
            @endcan


            @can('isSuperAdmin')
            {{-- Flights --}}

                <li class="dropdown">
                    <a href="#" class="menu-toggle nav-link has-dropdown"><i
                            data-feather="briefcase"></i><span>Inventory</span></a>
                    <ul class="dropdown-menu">
                      <li><a class="nav-link" href="/inventory-category">Create New</a></li>
                      <li><a class="nav-link" href="/inventory-activity">Inventory Activity</a></li>
                      <li><a class="nav-link" href="/manage-packs">View Inventory
                              Items</a></li>
                    </ul>
                </li>
                {{-- Share route --}}
                <!-- <li class="dropdown">
                    <a href="#" class="menu-toggle nav-link has-dropdown"><i class="fa fa-vials"></i><span>Sharing
                        </span></a>
                    <ul class="dropdown-menu">
                        @can('isSuperAdmin')
                            <li><a class="nav-link" href="/share-requests">Share Requests</a></li>
                        @endcan
                        <li><a class="nav-link" href="/all-share-requests">Open Shares</a></li>
                        <li><a class="nav-link" href="/all-delivered-samples">All Delivered</a></li>
                    </ul>
                </li> -->

                {{-- Users routes for super admin --}}
                <li class="menu-header">Users</li>
                <li class="dropdown">
                    <a href="#" class="menu-toggle nav-link has-dropdown"><i
                            data-feather="user-check"></i><span>Lab</span></a>
                    <ul class="dropdown-menu">
                        <li><a class="nav-link" href="/create-lab">Create lab</a></li>
                        <li><a class="nav-link" href="/manage-lab">Manage lab</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="menu-toggle nav-link has-dropdown"><i
                            data-feather="user-check"></i><span>Warehouse</span></a>
                    <ul class="dropdown-menu">
                        <li><a class="nav-link" href="/manage-warehouse">Manage warehouse</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="user-check"></i><span>Admin
                            Users</span></a>
                    <ul class="dropdown-menu">
                        <li><a class="nav-link" href="/create-admin">Register admin</a></li>
                        <li><a class="nav-link" href="/manage-admin">Manage admin users</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="user"></i><span>Riders</span></a>
                    <ul class="dropdown-menu">
                        <li><a class="nav-link" href="/create-rider">Register Riders</a></li>
                        <li><a class="nav-link" href="/manage-rider">Manage Riders</a></li>
                    </ul>
                </li>
            @endcan
            {{-- Supervisor --}}
            @can('isSupervisor')
                <li class="menu-header">Users</li>
                <li class="dropdown">
                    <a href="#" class="menu-toggle nav-link has-dropdown"><i
                            data-feather="user-check"></i><span>Profilers</span></a>
                    <ul class="dropdown-menu">
                        <li><a class="nav-link" href="/manage-profilers">Manage profilers</a></li>
                    </ul>
                </li>
            @endcan
            @canany(['isSuperAdmin', 'oxygen-admin'])
                <li class="menu-header">Oxygen</li>
                <li class="dropdown">
                    <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="user-check"></i><span>Oxygen
                            Inventory</span></a>
                    <ul class="dropdown-menu">
                        <li><a class="nav-link" href="/oxygen/inventory">Overview</a></li>
                        <li><a class="nav-link" href="/oxygen/inventory/add-actions">Cylinder Addition Action</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="user-check"></i><span>Oxygen
                            Supplies</span></a>
                    <ul class="dropdown-menu">
                        <li><a class="nav-link" href="/oxygen/request/create">Create Supplies</a></li>
                        <li><a class="nav-link" href="/oxygen/request/manage">Manage All Supplies</a></li>
                        <li><a class="nav-link" href="/oxygen/request/manage?pickupRequest=true">Pickup Requests</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="menu-toggle nav-link has-dropdown"><i
                            data-feather="user-check"></i><span>Plant</span></a>
                    <ul class="dropdown-menu">
                        <li><a class="nav-link" href="/oxygen/plant/create">Create Plant</a></li>
                        <li><a class="nav-link" href="/oxygen/plant/manage">Manage Plants</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="menu-toggle nav-link has-dropdown"><i
                            data-feather="user-check"></i><span>Client</span></a>
                    <ul class="dropdown-menu">
                        <li><a class="nav-link" href="/oxygen/client/create">Create Client</a></li>
                        <li><a class="nav-link" href="/oxygen/client/manage">Manage Clients</a></li>
                    </ul>
                </li>
            @endcanany
            <li class="menu-header">Account</li>
            <li class="dropdown">
                <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="layout"></i><span>User
                        settings</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="/user-profile">My profile</a></li>
                    <li><a class="nav-link" href="/auth-password-reset/{{ Auth::user()->uuid }}">Change Password</a>
                    </li>
                </ul>
            </li>

        </ul>
    </aside>
</div>
