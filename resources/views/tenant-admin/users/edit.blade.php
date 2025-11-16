<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit User') }}
            </h2>
            <a href="{{ route('tenant-admin.users.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Back to Users
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="row">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm mb-4">
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

                            <form method="POST" action="{{ route('tenant-admin.users.update', $user) }}">
                                @csrf
                                @method('PATCH')

                                <!-- Name -->
                                <div class="mb-4">
                                    <label for="name" class="form-label fw-semibold">
                                        Full Name <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control form-control-lg @error('name') is-invalid @enderror" 
                                           id="name" 
                                           name="name" 
                                           value="{{ old('name', $user->name) }}" 
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
                                           value="{{ old('email', $user->email) }}" 
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
                                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>
                                            Administrator
                                        </option>
                                        <option value="tech" {{ old('role', $user->role) == 'tech' ? 'selected' : '' }}>
                                            Tech Account
                                        </option>
                                    </select>
                                    @error('role')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
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
                                           value="{{ old('usertype', $user->usertype) }}" 
                                           required>
                                    @error('usertype')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Status -->
                                <div class="mb-4">
                                    <label for="status" class="form-label fw-semibold">
                                        Status <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select form-select-lg @error('status') is-invalid @enderror" 
                                            id="status" 
                                            name="status" 
                                            required>
                                        <option value="active" {{ old('status', $user->status) == 'active' ? 'selected' : '' }}>
                                            Active
                                        </option>
                                        <option value="suspended" {{ old('status', $user->status) == 'suspended' ? 'selected' : '' }}>
                                            Suspended
                                        </option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Submit Buttons -->
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="bi bi-check-circle"></i> Update User
                                    </button>
                                    <a href="{{ route('tenant-admin.users.index') }}" class="btn btn-outline-secondary btn-lg">
                                        Cancel
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Actions -->
                <div class="col-lg-4">
                    <!-- Reset Password Card -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Reset Password</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('tenant-admin.users.reset-password', $user) }}">
                                @csrf
                                
                                <div class="mb-3">
                                    <label for="new_password" class="form-label">New Password</label>
                                    <input type="password" 
                                           class="form-control" 
                                           id="new_password" 
                                           name="password" 
                                           required>
                                </div>

                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                                    <input type="password" 
                                           class="form-control" 
                                           id="password_confirmation" 
                                           name="password_confirmation" 
                                           required>
                                </div>

                                <button type="submit" class="btn btn-warning w-100">
                                    <i class="bi bi-key"></i> Reset Password
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Account Info Card -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Account Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <small class="text-muted">Created</small>
                                <div>{{ $user->created_at->format('F d, Y') }}</div>
                            </div>
                            <div class="mb-3">
                                <small class="text-muted">Last Updated</small>
                                <div>{{ $user->updated_at->format('F d, Y') }}</div>
                            </div>
                            @if($user->email_verified_at)
                                <div>
                                    <small class="text-muted">Email Verified</small>
                                    <div>{{ $user->email_verified_at->format('F d, Y') }}</div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>