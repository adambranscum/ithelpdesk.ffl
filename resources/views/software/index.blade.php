<x-app-layout>

<div class="container mt-4 mb-5 shadow p-4">
    <!-- Page Header -->
    <div class="row mb-4 mt-4">
        <div class="col-md-8">
            <h1 class="display-6 fw-bold">Software Management</h1>
            <p class="text-muted">Track software licenses and renewal dates</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('software.create') }}" class="btn btn-primary">
                Add Software
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted mb-1">Total Software</h6>
                    <h2 class="mb-0 fw-bold">{{ $stats['total'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted mb-1">Total Paid Licenses</h6>
                    <h2 class="mb-0 fw-bold text-primary">{{ $stats['total_licenses'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted mb-1">Expiring Soon</h6>
                    <h2 class="mb-0 fw-bold text-warning">{{ $stats['expiring_soon'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted mb-1">Expired</h6>
                    <h2 class="mb-0 fw-bold text-danger">{{ $stats['expired'] }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Software Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            @if($software->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="px-4 py-3">Software Name</th>
                            <th class="py-3">License Quantity</th>
                            <th class="py-3">Renewal Date</th>
                            <th class="py-3">Status</th>
                            <th class="py-3 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($software as $item)
                        <tr>
                            <td class="px-4 py-3 fw-semibold">{{ $item->software }}</td>
                            <td class="py-3">
                                @if($item->unlimited == 1)
                                    <span class="text-muted">&infin;</span>
                                @else
                                    <span class="badge bg-primary">{{ $item->licence_quantity }} licenses</span>
                                @endif
                            </td>
                            <td class="py-3">
                                @if($item->forever == 1)
                                    <span class="text-muted">&infin;</span>
                                @elseif($item->renewal_date)
                                    <div>{{ $item->renewal_date->format('M d, Y') }}</div>
                                    <small class="text-muted">{{ $item->renewal_date->diffForHumans() }}</small>
                                @else
                                    <span class="text-muted">Not set</span>
                                @endif
                            </td>
                            <td class="py-3">
                                @if($item->isExpired())
                                    <span class="badge bg-danger">Expired</span>
                                @elseif($item->isExpiringSoon())
                                    <span class="badge bg-warning text-dark">Expiring Soon</span>
                                @else
                                    <span class="badge bg-success">Active</span>
                                @endif
                            </td>
                            <td class="py-3 text-center">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('software.edit', $item) }}" class="btn btn-sm btn-outline-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                        </svg>
                                        Edit
                                    </a>
                                    <form action="{{ route('software.destroy', $item) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this software?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                                <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                            </svg>
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="p-4 border-top">
                {{ $software->links('pagination::bootstrap-5') }}
            </div>
            @else
            <div class="text-center py-5">
                <h4 class="text-muted">No software found</h4>
                <p class="text-muted">Start by adding your first software license.</p>
                <a href="{{ route('software.create') }}" class="btn btn-primary mt-3">
                    Add Software
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
</x-app-layout>