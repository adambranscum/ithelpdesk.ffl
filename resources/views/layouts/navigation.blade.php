<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold d-flex align-items-center" href="{{ Auth::user()->isSuperAdmin() ? route('super-admin.tenants.index') : (Auth::user()->isTenantAdmin() ? route('tenant-admin.users.index') : route('tickets.index')) }}">
            NLRPLS IT Support
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto align-items-lg-center">
                
                {{-- Home Link - Dynamic based on role --}}
                <li class="nav-item">
                    @if(Auth::user()->isSuperAdmin())
                        <a class="nav-link text-white d-flex align-items-center" href="{{ route('super-admin.tenants.index') }}">
                            Home
                        </a>
                    @elseif(Auth::user()->isTenantAdmin())
                        <a class="nav-link text-white d-flex align-items-center" href="{{ route('tenant-admin.users.index') }}">
                            Home
                        </a>
                    @else
                        <a class="nav-link text-white d-flex align-items-center" href="{{ route('tickets.index') }}">
                            Home
                        </a>
                    @endif
                </li>

                {{-- Show tenant-specific menu items only if NOT super admin --}}
                @if(!Auth::user()->isSuperAdmin())
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white d-flex align-items-center" href="#" id="inventoryDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Inventory
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="inventoryDropdown">
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="{{ route('devices.index') }}">
                                    Device Inventory
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="{{ route('software.index') }}">
                                    Software Inventory
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white d-flex align-items-center" href="#" id="statisticsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Statistics
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="statisticsDropdown">
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="{{ route('tickets.stats') }}">
                                    Ticket Statistics
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="{{ route('software.stats') }}">
                                    Software Statistics
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="{{ route('devices.stats') }}">
                                    Device Statistics
                                </a>
                            </li>
                        </ul>
                    </li>

                    @if(Auth::user()->canAccessAdminPanel())
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-white d-flex align-items-center" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Admin Tools
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="adminDropdown">
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.index') }}">
                                        Admin Ticket DB
                                    </a>
                                </li>
                                @if(Auth::user()->isTenantAdmin())
                                    <li>
                                        <a class="dropdown-item" href="{{ route('tenant-admin.users.index') }}">
                                            Manage Users
                                        </a>
                                    </li>
                                @endif
                                <li>
                                    <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                        Change Password
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif

                    <li class="nav-item">
                        <a class="nav-link text-white d-flex align-items-center" href="{{ route('sops.index') }}">
                            SOPs
                        </a>
                    </li>
                @endif

                {{-- Super Admin specific menu --}}
                @if(Auth::user()->isSuperAdmin())
                    <li class="nav-item">
                        <a class="nav-link text-white d-flex align-items-center" href="{{ route('super-admin.tenants.index') }}">
                            Manage Tenants
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white d-flex align-items-center" href="{{ route('profile.edit') }}">
                            Settings
                        </a>
                    </li>
                @endif

                {{-- Logout Button --}}
                <li class="nav-item ms-lg-2">
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault(); this.closest('form').submit();"
                            class="btn btn-outline-light btn-sm d-flex align-items-center"
                            style="cursor: pointer;">
                            Logout
                        </a>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>