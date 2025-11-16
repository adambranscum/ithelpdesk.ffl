<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Create New User') }}
            </h2>
            <a href="{{ route('tenant-admin.users.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Back to Users
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">User Information</h5>
                        </div>
                        <div class="card-body p-4">
                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('tenant-admin.users.store') }}">
                                @csrf

                                <!-- Name -->
                                <div class="mb-4">
                                    <label for="name" class="form-label fw-semibold">
                                        Full Name <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control form-control-lg @error('name') is-invalid @enderror" 
                                           id="name" 
                                           name="name" 
                                           value="{{ old('name') }}" 
                                           required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div class="mb-4">
                                    <label for="email" class="form-label fw-semibold">
                                        Email Address <span class="text-danger">*</span>
                                    </label>
                                    <input type="email" 
                                           class="form-control form-control-lg @error('email') is-invalid @enderror" 
                                           id="email" 
                                           name="email" 
                                           value="{{ old('email') }}" 
                                           required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Role -->
                                <div class="mb-4">
                                    <label for="role" class="form-label fw-semibold">
                                        Role <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select form-select-lg @error('role') is-invalid @enderror" 
                                            id="role" 
                                            name="role" 
                                            required>
                                        <option value="">Select Role</option>
                                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>
                                            Administrator
                                        </option>
                                        <option value="tech" {{ old('role') == 'tech' ? 'selected' : '' }}>
                                            Tech Account
                                        </option>
                                    </select>
                                    @error('role')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">
                                        Administrators can manage users and access all features. Tech accounts can manage tickets and devices.
                                    </small>
                                </div>

                                <!-- User Type -->
                                <div class="mb-4">
                                    <label for="usertype" class="form-label fw-semibold">
                                        User Type <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control form-control-lg @error('usertype') is-invalid @enderror" 
                                           id="usertype" 
                                           name="usertype" 
                                           value="{{ old('usertype') }}" 
                                           placeholder="e.g., IT Technician, Help Desk, System Administrator"
                                           required>
                                    @error('usertype')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">
                                        This is used for categorizing users in your organization
                                    </small>
                                </div>

                                <!-- Password -->
                                <div class="mb-4">
                                    <label for="password" class="form-label fw-semibold">
                                        Password <span class="text-danger">*</span>
                                    </label>
                                    <input type="password" 
                                           class="form-control form-control-lg @error('password') is-invalid @enderror" 
                                           id="password" 
                                           name="password" 
                                           required>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">
                                        Must be at least 8 characters
                                    </small>
                                </div>

                                <!-- Confirm Password -->
                                <div class="mb-4">
                                    <label for="password_confirmation" class="form-label fw-semibold">
                                        Confirm Password <span class="text-danger">*</span>
                                    </label>
                                    <input type="password" 
                                           class="form-control form-control-lg" 
                                           id="password_confirmation" 
                                           name="password_confirmation" 
                                           required>
                                </div>

                                <!-- Submit Buttons -->
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="bi bi-check-circle"></i> Create User
                                    </button>
                                    <a href="{{ route('tenant-admin.users.index') }}" class="btn btn-outline-secondary btn-lg">
                                        Cancel
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>