<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tenant Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Cards -->
            <div class="row g-4 mb-4">
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="text-muted small mb-1">Total Tenants</p>
                                    <h3 class="mb-0">{{ $stats['total'] }}</h3>
                                </div>
                                <div class="bg-primary bg-opacity-10 rounded p-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-building text-primary" viewBox="0 0 16 16">
                                        <path d="M4 2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm3.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1ZM4 5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1ZM7.5 5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1Zm2.5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1ZM4.5 8a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1Zm2.5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm3.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1Z"/>
                                        <path d="M2 1a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V1Zm11 0H3v14h3v-2.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5V15h3V1Z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="text-muted small mb-1">Pending</p>
                                    <h3 class="mb-0">{{ $stats['pending'] }}</h3>
                                </div>
                                <div class="bg-warning bg-opacity-10 rounded p-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-hourglass-split text-warning" viewBox="0 0 16 16">
                                        <path d="M2.5 15a.5.5 0 1 1 0-1h1v-1a4.5 4.5 0 0 1 2.557-4.06c.29-.139.443-.377.443-.59v-.7c0-.213-.154-.451-.443-.59A4.5 4.5 0 0 1 3.5 3V2h-1a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1h-1v1a4.5 4.5 0 0 1-2.557 4.06c-.29.139-.443.377-.443.59v.7c0 .213.154.451.443.59A4.5 4.5 0 0 1 12.5 13v1h1a.5.5 0 0 1 0 1h-11zm2-13v1c0 .537.12 1.045.337 1.5h6.326c.216-.455.337-.963.337-1.5V2h-7zm3 6.35c0 .701-.478 1.236-1.011 1.492A3.5 3.5 0 0 0 4.5 13s.866-1.299 3-1.48V8.35zm1 0v3.17c2.134.181 3 1.48 3 1.48a3.5 3.5 0 0 0-1.989-3.158C8.978 9.586 8.5 9.052 8.5 8.351z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="text-muted small mb-1">Active</p>
                                    <h3 class="mb-0">{{ $stats['active'] }}</h3>
                                </div>
                                <div class="bg-success bg-opacity-10 rounded p-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-check-circle text-success" viewBox="0 0 16 16">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                        <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="text-muted small mb-1">Suspended</p>
                                    <h3 class="mb-0">{{ $stats['suspended'] }}</h3>
                                </div>
                                <div class="bg-danger bg-opacity-10 rounded p-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-x-circle text-danger" viewBox="0 0 16 16">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters and Search -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <form method="GET" action="{{ route('super-admin.tenants.index') }}">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <input type="text" 
                                       name="search" 
                                       class="form-control" 
                                       placeholder="Search libraries..." 
                                       value="{{ request('search') }}">
                            </div>
                            <div class="col-md-3">
                                <select name="status" class="form-select">
                                    <option value="">All Status</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="suspended" {{ request('status') == 'suspended' ? 'selected' : '' }}>Suspended</option>
                                </select>
                            </div>
                            <div class="col-md-5">
                                <button type="submit" class="btn btn-primary me-2">
                                    <i class="bi bi-search"></i> Filter
                                </button>
                                <a href="{{ route('super-admin.tenants.index') }}" class="btn btn-outline-secondary">
                                    Clear
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tenants List -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">All Tenants</h5>
                </div>
                <div class="card-body p-0">
                    @if($tenants->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Library Name</th>
                                        <th>Domain</th>
                                        <th>Admin</th>
                                        <th>Status</th>
                                        <th>Registered</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($tenants as $tenant)
                                        <tr>
                                            <td>
                                                <strong>{{ $tenant->name }}</strong>
                                            </td>
                                            <td>
                                                <code>{{ $tenant->domain }}.{{ config('app.domain') }}</code>
                                            </td>
                                            <td>
                                                <div>{{ $tenant->admin_name }}</div>
                                                <small class="text-muted">{{ $tenant->admin_email }}</small>
                                            </td>
                                            <td>
                                                @if($tenant->status == 'pending')
                                                    <span class="badge bg-warning">Pending</span>
                                                @elseif($tenant->status == 'active')
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-danger">Suspended</span>
                                                @endif
                                            </td>
                                            <td>
                                                <small>{{ $tenant->created_at->format('M d, Y') }}</small>
                                            </td>
                                            <td class="text-end">
                                                <div class="btn-group">
                                                    <a href="{{ route('super-admin.tenants.show', $tenant) }}" 
                                                       class="btn btn-sm btn-outline-primary">
                                                        View
                                                    </a>
                                                    
                                                    @if($tenant->status == 'pending')
                                                        <form method="POST" 
                                                              action="{{ route('super-admin.tenants.approve', $tenant) }}" 
                                                              class="d-inline">
                                                            @csrf
                                                            <button type="submit" 
                                                                    class="btn btn-sm btn-success"
                                                                    onclick="return confirm('Are you sure you want to approve this tenant?')">
                                                                Approve
                                                            </button>
                                                        </form>
                                                    @elseif($tenant->status == 'active')
                                                        <form method="POST" 
                                                              action="{{ route('super-admin.tenants.suspend', $tenant) }}" 
                                                              class="d-inline">
                                                            @csrf
                                                            <button type="submit" 
                                                                    class="btn btn-sm btn-warning"
                                                                    onclick="return confirm('Are you sure you want to suspend this tenant?')">
                                                                Suspend
                                                            </button>
                                                        </form>
                                                    @else
                                                        <form method="POST" 
                                                              action="{{ route('super-admin.tenants.activate', $tenant) }}" 
                                                              class="d-inline">
                                                            @csrf
                                                            <button type="submit" 
                                                                    class="btn btn-sm btn-success"
                                                                    onclick="return confirm('Are you sure you want to activate this tenant?')">
                                                                Activate
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="card-footer bg-white">
                            {{ $tenants->links() }}
                        </div>
                    @else
                        <div class="p-5 text-center text-muted">
                            <p class="mb-0">No tenants found</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>