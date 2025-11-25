<x-app-layout>

<div class="container mt-5">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="display-4 fw-bold">Category Settings</h1>
            <p class="lead text-muted">Manage categories for {{ $library->name }}</p>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <h6 class="alert-heading">Please fix the following errors:</h6>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Add New Category Section -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-light border-bottom">
            <h5 class="mb-0 fw-semibold">Add New Category</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('library.admin.categories.store') }}">
                @csrf

                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <label for="type" class="form-label">Category Type <span class="text-danger">*</span></label>
                        <select id="type" name="type" required class="form-control">
                            <option value="">Select a type...</option>
                            @foreach ($categoryTypes as $categoryType)
                                <option value="{{ $categoryType }}" {{ old('type') === $categoryType ? 'selected' : '' }}>
                                    {{ ucfirst($categoryType) }}
                                </option>
                            @endforeach
                        </select>
                        @error('type')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-8">
                        <label for="name" class="form-label">Category Name <span class="text-danger">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required class="form-control"
                            placeholder="e.g., Main Office, WiFi, Phishing">
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Add Category</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Categories by Type -->
    @foreach ($categoryTypes as $categoryType)
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-light border-bottom">
                <h5 class="mb-0 fw-semibold">{{ ucfirst($categoryType) }} Categories</h5>
            </div>
            <div class="card-body">
                @if ($groupedCategories[$categoryType]->isEmpty())
                    <p class="text-muted">No categories yet.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($groupedCategories[$categoryType] as $category)
                                    <tr>
                                        <td>{{ $category->name }}</td>
                                        <td>
                                            <span class="badge {{ $category->is_active ? 'bg-success' : 'bg-secondary' }}">
                                                {{ $category->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td>
                                            <form method="POST" action="{{ route('library.admin.categories.toggleActive', $category) }}" style="display: inline;">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-link text-primary">
                                                    {{ $category->is_active ? 'Deactivate' : 'Activate' }}
                                                </button>
                                            </form>

                                            <form method="POST" action="{{ route('library.admin.categories.destroy', $category) }}" style="display: inline;"
                                                onsubmit="return confirm('Are you sure you want to delete this category?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-link text-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    @endforeach
</div>

</x-app-layout>
