<!-- Left Sidebar Start -->
<div class="app-sidebar-menu">
    <div class="h-100" data-simplebar>

        <!--- Sidemenu -->
        <div id="sidebar-menu">

            <div class="logo-box text-center py-3">
                <a href="{{ route('dashboard') }}" class="text-decoration-none fw-bold fs-4 text-primary">
                    Janilyn's Place
                </a>
            </div>

            <ul id="side-menu">

                <li class="menu-title">Menu</li>

                <li>
                    <a href="{{ route('dashboard') }}" class="tp-link">
                        <i data-feather="home"></i>
                        <span> Dashboard </span>
                    </a>
                </li>
                
                <li>
                    <a href="#sidebarDashboards" data-bs-toggle="collapse">
                        <i data-feather="map"></i>
                        <span> Accommodation </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarDashboards">
                        <ul class="nav-second-level">
                            <li>
                                <a href="#" class="tp-link">Categories</a>
                            </li>
                            <li>
                                <a href="#" class="tp-link">Rooms</a>
                            </li>
                            <li>
                                <a href="#" class="tp-link">Venues</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="{{ route('users') }}" class="tp-link">
                        <i data-feather="users"></i>
                        <span> Users </span>
                    </a>
                </li>

            </ul>

        </div>
        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
</div>
<!-- Left Sidebar End -->