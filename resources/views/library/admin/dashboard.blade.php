<x-app-layout>

<div class="container-fluid mt-5">
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
                            <svg class="text-primary" width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm.465-4.492a.75.75 0 0 0-.832.832A9.97 9.97 0 0 1 8 15a9.97 9.97 0 0 1-1.633-13.66.75.75 0 0 0-.832-.832A11.47 11.47 0 0 0 5 1c-3.59 0-6.708 2.162-8.196 5.332C-9.52 9.672-7.157 15 2.5 15h5c4.657 0 7.02-5.328 5.696-8.668C14.712 3.162 11.593 1 8 1c-.463 0-.908.025-1.35.078z"/>
                            </svg>
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
                            <svg class="text-success" width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.777.416L8 13.101l-5.223 2.815A.5.5 0 0 1 2 15.5V2zm2-1a1 1 0 0 0-1 1v12.566l4.723-2.482a.5.5 0 0 1 .554 0L13 14.566V2a1 1 0 0 0-1-1H4z"/>
                            </svg>
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
                            <svg width="24" height="24" fill="{{ $library->is_approved ? '#0f5132' : '#664d03' }}" viewBox="0 0 16 16">
                                <path d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                            </svg>
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
                        <svg width="16" height="16" fill="currentColor" class="me-2" viewBox="0 0 16 16">
                            <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm.465-4.492a.75.75 0 0 0-.832.832A9.97 9.97 0 0 1 8 15a9.97 9.97 0 0 1-1.633-13.66.75.75 0 0 0-.832-.832A11.47 11.47 0 0 0 5 1c-3.59 0-6.708 2.162-8.196 5.332C-9.52 9.672-7.157 15 2.5 15h5c4.657 0 7.02-5.328 5.696-8.668C14.712 3.162 11.593 1 8 1c-.463 0-.908.025-1.35.078z"/>
                        </svg>
                        Manage Staff
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="{{ route('library.admin.settings') }}" class="btn btn-outline-primary w-100">
                        <svg width="16" height="16" fill="currentColor" class="me-2" viewBox="0 0 16 16">
                            <path d="M9.405 1.02c-.413-1.642-2.397-1.642-2.81 0l-.094.319a.873.873 0 0 1-1.255.52l-.292-.16c-1.64-.892-3.433.902-2.54 2.541l.159.292a.873.873 0 0 1-.52 1.255l-.319.094c-1.642.413-1.642 2.397 0 2.81l.319.094a.873.873 0 0 1 .52 1.255l-.16.292c-.892 1.64.901 3.434 2.541 2.54l.292-.159a.873.873 0 0 1 1.255.52l.094.319c.413 1.642 2.397 1.642 2.81 0l.094-.319a.873.873 0 0 1 1.255-.52l.292.16c1.64.893 3.434-.902 2.54-2.541l-.159-.292a.873.873 0 0 1 .52-1.255l.319-.094c1.642-.413 1.642-2.397 0-2.81l-.319-.094a.873.873 0 0 1-.52-1.255l.16-.292c.893-1.64-.902-3.433-2.541-2.54l-.292.159a.873.873 0 0 1-1.255-.52l-.094-.319zm-2.466 11.383c1.658 0 3-1.339 3-2.997s-1.342-2.996-3-2.996-3 1.339-3 2.996 1.342 2.997 3 2.997z"/>
                        </svg>
                        Library Settings
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="{{ route('library.admin.branding-preview') }}" class="btn btn-outline-primary w-100">
                        <svg width="16" height="16" fill="currentColor" class="me-2" viewBox="0 0 16 16">
                            <path d="M5 2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0V2.5h-4V4a.5.5 0 0 1-1 0V2z"/>
                            <path d="M3 5a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5zm2-1a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V5a1 1 0 0 0-1-1H5z"/>
                        </svg>
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
                        <svg width="14" height="14" fill="currentColor" class="me-1" viewBox="0 0 16 16">
                            <path d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v-1a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v1zm5-1v1H6V1h3z"/>
                        </svg>
                        Copy URL
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

</x-app-layout>
