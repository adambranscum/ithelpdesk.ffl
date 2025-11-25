<x-app-layout>

<div class="container mt-5">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="display-4 fw-bold">Library Admin Dashboard</h1>
            <p class="lead text-muted">Manage {{ $library->name }}</p>
        </div>
        @if($library->logo_path)
            <div class="col-md-4 text-end">
                <img src="{{ asset('storage/' . $library->logo_path) }}" alt="{{ $library->name }}" style="max-height: 80px;">
            </div>
        @endif
    </div>

    <!-- Statistics Cards -->
    <div class="row g-3 mb-5">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted small fw-semibold mb-1">Active Staff Members</p>
                            <h3 class="display-5 fw-bold mb-0">{{ $staffCount }}</h3>
                        </div>
                        <div class="bg-primary bg-opacity-10 rounded p-3">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted small fw-semibold mb-1">Total Tickets</p>
                            <h3 class="display-5 fw-bold mb-0">{{ $ticketCount }}</h3>
                        </div>
                        <div class="bg-success bg-opacity-10 rounded p-3">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted small fw-semibold mb-1">Approval Status</p>
                            @if($library->is_approved)
                                <span class="badge bg-success fs-6">Approved</span>
                            @else
                                <span class="badge bg-warning text-dark fs-6">Pending</span>
                            @endif
                        </div>
                        <div class="rounded p-3" style="background-color: {{ $library->is_approved ? '#d1e7dd' : '#fff3cd' }};">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="card shadow-sm mb-5">
        <div class="card-header bg-light border-bottom">
            <h5 class="mb-0 fw-semibold">Quick Actions</h5>
        </div>
        <div class="card-body">
            <div class="row g-2">
                <div class="col-md-4">
                    <a href="{{ route('library.admin.staff') }}" class="btn btn-primary w-100">
                        Manage Staff
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="{{ route('library.admin.settings') }}" class="btn btn-outline-primary w-100">
                        Library Settings
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="{{ route('library.admin.branding-preview') }}" class="btn btn-outline-primary w-100">
                        Preview Branding
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Library Info -->
    <div class="row g-3">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-light border-bottom">
                    <h5 class="mb-0 fw-semibold">Library Information</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <p class="text-muted small mb-1">Library UID</p>
                            <p class="font-monospace fw-semibold">{{ $library->uid }}</p>
                        </div>
                        <div class="col-12">
                            <p class="text-muted small mb-1">Subdomain</p>
                            <p class="text-primary fw-semibold">{{ $library->subdomain }}.{{ config('app.domain', 'domain.com') }}</p>
                        </div>
                        <div class="col-12">
                            <p class="text-muted small mb-1">Email</p>
                            <p class="fw-semibold">{{ $library->email }}</p>
                        </div>
                        <div class="col-12">
                            <p class="text-muted small mb-1">Phone</p>
                            <p class="fw-semibold">{{ $library->phone ?? 'Not provided' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-light border-bottom">
                    <h5 class="mb-0 fw-semibold">Ticket Submission URL</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted small mb-2">Share this URL with your patrons:</p>
                    <div class="bg-light p-3 rounded border mb-3">
                        <p class="font-monospace small text-break mb-0">https://{{ $library->getUrl() }}</p>
                    </div>
                    <button onclick="navigator.clipboard.writeText('https://{{ $library->getUrl() }}')" class="btn btn-sm btn-outline-primary">
                        Copy URL
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

</x-app-layout>
