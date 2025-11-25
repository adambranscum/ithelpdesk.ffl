<x-app-layout>

<div class="container mt-5">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="display-4 fw-bold">Branding Preview</h1>
            <p class="lead text-muted">This is how your ticket submission page will appear to patrons</p>
        </div>
    </div>

    <!-- Preview -->
    <div class="card shadow-sm overflow-hidden mb-5">
        <!-- Header with branding -->
        <div style="background-color: {{ $library->primary_color }}; color: white;" class="p-5">
            <div class="row align-items-center g-4">
                <div class="col-auto">
                    @if($library->logo_path)
                        <img src="{{ asset('storage/' . $library->logo_path) }}" alt="{{ $library->name }}" style="max-height: 100px;">
                    @else
                        <div style="height: 100px; width: 100px; background-color: {{ $library->brand_color }}; opacity: 0.5;" class="rounded"></div>
                    @endif
                </div>
                <div class="col">
                    <h2 class="h2 fw-bold mb-2">{{ $library->ticket_page_title ?? 'Submit a Ticket' }}</h2>
                    <p class="mb-0">{{ $library->ticket_page_description ?? 'We\'re here to help. Submit your IT support request below.' }}</p>
                </div>
            </div>
        </div>

        <!-- Form preview -->
        <div class="card-body">
            <h3 class="h5 fw-semibold mb-4">Ticket Information</h3>

            <div class="row g-4" style="max-width: 600px;">
                <div class="col-12">
                    <label class="form-label">Your Name</label>
                    <input type="text" placeholder="John Doe" disabled
                        class="form-control" style="background-color: #f8f9fa;">
                </div>

                <div class="col-12">
                    <label class="form-label">Email Address</label>
                    <input type="email" placeholder="john@example.com" disabled
                        class="form-control" style="background-color: #f8f9fa;">
                </div>

                <div class="col-12">
                    <label class="form-label">Subject</label>
                    <input type="text" placeholder="Brief description of your issue" disabled
                        class="form-control" style="background-color: #f8f9fa;">
                </div>

                <div class="col-12">
                    <label class="form-label">Description</label>
                    <textarea rows="6" placeholder="Please provide details about your issue..." disabled
                        class="form-control" style="background-color: #f8f9fa;"></textarea>
                </div>

                <div class="col-12">
                    <button disabled style="background-color: {{ $library->brand_color }};" class="btn w-100 text-white opacity-50">
                        Submit Ticket
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Color Reference -->
    <div class="row g-4 mb-5">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-light border-bottom">
                    <h5 class="mb-0 fw-semibold">Brand Colors Used</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3 mb-3">
                        <div class="col-auto">
                            <div style="height: 60px; width: 60px; background-color: {{ $library->primary_color }};" class="rounded"></div>
                        </div>
                        <div class="col">
                            <p class="small text-muted mb-1">Primary Color</p>
                            <p class="fw-semibold font-monospace">{{ $library->primary_color }}</p>
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-auto">
                            <div style="height: 60px; width: 60px; background-color: {{ $library->brand_color }};" class="rounded"></div>
                        </div>
                        <div class="col">
                            <p class="small text-muted mb-1">Brand Color</p>
                            <p class="fw-semibold font-monospace">{{ $library->brand_color }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-light border-bottom">
                    <h5 class="mb-0 fw-semibold">Library Info</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <p class="text-muted small mb-1">Library Name</p>
                            <p class="fw-semibold">{{ $library->name }}</p>
                        </div>
                        <div class="col-12">
                            <p class="text-muted small mb-1">Subdomain</p>
                            <p class="fw-semibold">{{ $library->subdomain }}.{{ config('app.domain') }}</p>
                        </div>
                        <div class="col-12">
                            <p class="text-muted small mb-1">Logo</p>
                            <p class="fw-semibold">{{ $library->logo_path ? 'Uploaded' : 'Not set' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end mb-5">
        <a href="{{ route('library.admin.settings') }}" class="btn btn-primary">
            Edit Settings
        </a>
    </div>
</div>

</x-app-layout>
