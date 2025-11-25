<x-app-layout>

<div class="container mt-5">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="display-4 fw-bold">Library Settings</h1>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-light border-bottom">
            <h5 class="mb-0 fw-semibold">Update Library Settings</h5>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger mb-0 border-0 rounded-0">
                <h6 class="alert-heading">Please fix the following errors:</h6>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success mb-0 border-0 rounded-0">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('library.admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="card-body">
            @csrf

            <!-- Library Basic Info -->
            <h2 class="h5 fw-semibold mb-4">Basic Information</h2>
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label for="name" class="form-label">Library Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $library->name) }}" required
                        class="form-control">
                </div>

                <div class="col-md-6">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $library->email) }}" required
                        class="form-control">
                </div>

                <div class="col-md-6">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input type="tel" id="phone" name="phone" value="{{ old('phone', $library->phone) }}"
                        class="form-control">
                </div>
            </div>

            <hr class="my-4">

            <!-- Address -->
            <h2 class="h5 fw-semibold mb-4">Address</h2>
            <div class="row g-3 mb-4">
                <div class="col-12">
                    <label for="address" class="form-label">Street Address</label>
                    <input type="text" id="address" name="address" value="{{ old('address', $library->address) }}"
                        class="form-control">
                </div>

                <div class="col-md-6">
                    <label for="city" class="form-label">City</label>
                    <input type="text" id="city" name="city" value="{{ old('city', $library->city) }}"
                        class="form-control">
                </div>
                <div class="col-md-3">
                    <label for="state" class="form-label">State</label>
                    <input type="text" id="state" name="state" value="{{ old('state', $library->state) }}"
                        class="form-control">
                </div>
                <div class="col-md-3">
                    <label for="zip" class="form-label">ZIP Code</label>
                    <input type="text" id="zip" name="zip" value="{{ old('zip', $library->zip) }}"
                        class="form-control">
                </div>
            </div>

            <hr class="my-4">

            <!-- Branding -->
            <h2 class="h5 fw-semibold mb-4">Branding</h2>
            <div class="row g-3 mb-4">
                <div class="col-12">
                    <label for="logo" class="form-label">Logo</label>
                    <input type="file" id="logo" name="logo" accept="image/*"
                        class="form-control">
                    <small class="text-muted d-block mt-2">PNG, JPG up to 2MB. Recommended: 100x100px minimum</small>
                    @if ($library->logo_path)
                        <div class="mt-3">
                            <img src="{{ asset('storage/' . $library->logo_path) }}" alt="Current logo" style="max-height: 60px;">
                        </div>
                    @endif
                </div>

                <div class="col-md-6">
                    <label for="brand_color" class="form-label">Brand Color</label>
                    <div class="input-group">
                        <input type="color" id="brand_color" name="brand_color" value="{{ old('brand_color', $library->brand_color) }}"
                            class="form-control form-control-color" style="max-width: 60px;">
                        <input type="text" name="brand_color" value="{{ old('brand_color', $library->brand_color) }}" class="form-control">
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="primary_color" class="form-label">Primary Color</label>
                    <div class="input-group">
                        <input type="color" id="primary_color" name="primary_color" value="{{ old('primary_color', $library->primary_color) }}"
                            class="form-control form-control-color" style="max-width: 60px;">
                        <input type="text" name="primary_color" value="{{ old('primary_color', $library->primary_color) }}" class="form-control">
                    </div>
                </div>
            </div>

            <hr class="my-4">

            <!-- Ticket Page Customization -->
            <h2 class="h5 fw-semibold mb-4">Ticket Submission Page</h2>
            <div class="row g-3 mb-4">
                <div class="col-12">
                    <label for="ticket_page_title" class="form-label">Page Title</label>
                    <input type="text" id="ticket_page_title" name="ticket_page_title" value="{{ old('ticket_page_title', $library->ticket_page_title) }}"
                        class="form-control"
                        placeholder="Submit a Support Request">
                </div>

                <div class="col-12">
                    <label for="ticket_page_description" class="form-label">Page Description</label>
                    <textarea id="ticket_page_description" name="ticket_page_description" rows="4"
                        class="form-control"
                        placeholder="Provide a brief description for your ticket submission page...">{{ old('ticket_page_description', $library->ticket_page_description) }}</textarea>
                </div>
            </div>

            <!-- Submit -->
            <hr class="my-4">
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('library.admin.dashboard') }}" class="btn btn-outline-secondary">
                    Cancel
                </a>
                <button type="submit" class="btn btn-primary">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

</x-app-layout>
