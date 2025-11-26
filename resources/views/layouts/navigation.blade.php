<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold d-flex align-items-center text-gradient-primary" href="https://thecommunityhelpdesk.org">
            The Community Helpdesk
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"
            style="border: none; padding: 0.25rem 0.75rem;">
            <span class="navbar-toggler-icon" style="background-image: url('data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 30 30%22><line x1=%225%22 y1=%227%22 x2=%2225%22 y2=%227%22 stroke=%22url(%23grad1)%22 stroke-width=%223%22 stroke-linecap=%22round%22/><line x1=%225%22 y1=%2215%22 x2=%2225%22 y2=%2215%22 stroke=%22url(%23grad1)%22 stroke-width=%223%22 stroke-linecap=%22round%22/><line x1=%225%22 y1=%2223%22 x2=%2225%22 y2=%2223%22 stroke=%22url(%23grad1)%22 stroke-width=%223%22 stroke-linecap=%22round%22/><defs><linearGradient id=%22grad1%22 x1=%220%25%22 y1=%220%25%22 x2=%22100%25%22 y2=%220%25%22><stop offset=%220%25%22 style=%22stop-color:%239b59b6;stop-opacity:1%22/><stop offset=%22100%25%22 style=%22stop-color:%23e74c3c;stop-opacity:1%22/></linearGradient></defs></svg>'); width: 1.5em; height: 1.5em;"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto align-items-lg-center">
                @if(Auth::user() && Auth::user()->is_active)
                    <li class="nav-item">
                        <a class="nav-link text-dark d-flex align-items-center" href="{{ route('tickets.index') }}">
                            Home
                        </a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-dark d-flex align-items-center" href="#" id="inventoryDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
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
                        <a class="nav-link dropdown-toggle text-dark d-flex align-items-center" href="#" id="inventoryDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Statistics
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="inventoryDropdown">
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

                    @if(Auth::user() && Auth::user()->role === 'admin')
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-dark d-flex align-items-center" href="#" id="adminToolsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Admin Tools
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="adminToolsDropdown">
                                <li>
                                    <a class="nav-link text-dark d-flex align-items-center" href="{{ route('library.admin.dashboard') }}">
                                        Library Admin
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="nav-link text-dark d-flex align-items-center" href="{{ route('admin.index') }}">
                                        Admin Ticket Db
                                    </a>
                                </li>
                                <li>
                                    <a class="nav-link text-dark d-flex align-items-center" href="{{ route('profile.edit') }}">
                                        Change Password
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link text-dark d-flex align-items-center" href="{{ route('profile.edit') }}">
                                Change Password
                            </a>
                        </li>
                    @endif

                    <li class="nav-item">
                        <a class="nav-link text-dark d-flex align-items-center" href="{{ route('sops.index') }}">
                            SOPs
                        </a>
                    </li>
                @endif

                <li class="nav-item ms-lg-2">
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault(); this.closest('form').submit();"
                            class="btn btn-sm d-flex align-items-center logout-btn"
                            style="cursor: pointer;">
                            Logout
                        </a>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>