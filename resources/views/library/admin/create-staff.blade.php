<x-app-layout>

<div class="container mt-5">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="display-4 fw-bold">Create Staff Account</h1>
        </div>
    </div>

    <div class="card shadow-sm" style="max-width: 600px;">
        <div class="card-header bg-light border-bottom">
            <h5 class="mb-0 fw-semibold">Add New Staff Member</h5>
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

        <form action="{{ route('library.admin.staff.store') }}" method="POST" class="card-body">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Staff Name <span class="text-danger">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                    class="form-control"
                    placeholder="John Smith">
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                    class="form-control"
                    placeholder="john@library.org">
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                <input type="password" id="password" name="password" required
                    class="form-control"
                    placeholder="••••••••">
                <small class="text-muted d-block mt-2">Minimum 8 characters, include uppercase, lowercase, number, and symbol</small>
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                <input type="password" id="password_confirmation" name="password_confirmation" required
                    class="form-control"
                    placeholder="••••••••">
            </div>

            <hr class="my-4">
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('library.admin.staff') }}" class="btn btn-outline-secondary">
                    Cancel
                </a>
                <button type="submit" class="btn btn-primary">
                    Create Staff Account
                </button>
            </div>
        </form>
    </div>
</div>

</x-app-layout>
