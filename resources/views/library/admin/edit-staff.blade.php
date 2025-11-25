<x-app-layout>

<div class="container mt-5">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="display-4 fw-bold">Edit Staff Account</h1>
        </div>
    </div>

    <div class="card shadow-sm" style="max-width: 600px;">
        <div class="card-header bg-light border-bottom">
            <h5 class="mb-0 fw-semibold">Update Staff Member</h5>
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

        <form action="{{ route('library.admin.staff.update', $staff->id) }}" method="POST" class="card-body">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Staff Name <span class="text-danger">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name', $staff->name) }}" required
                    class="form-control"
                    placeholder="John Smith">
            </div>

            <div class="mb-4">
                <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                <input type="email" id="email" name="email" value="{{ old('email', $staff->email) }}" required
                    class="form-control"
                    placeholder="john@library.org">
            </div>

            <hr class="my-4">
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('library.admin.staff') }}" class="btn btn-outline-secondary">
                    Cancel
                </a>
                <button type="submit" class="btn btn-primary">
                    Update Staff Account
                </button>
            </div>
        </form>
    </div>
</div>

</x-app-layout>
