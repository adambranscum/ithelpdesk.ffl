<x-guest-layout>
<div class="min-vh-100 d-flex align-items-center justify-content-center py-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8">
                <div class="card border-0 shadow-lg">
                    <div class="card-body p-4 p-md-5">
                        <!-- Header -->
                        <div class="text-center mb-4">
                            <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex p-3 mb-3">
                                <img width="60" height="60" src="../images/logo.png" alt="Logo">
                            </div>
                            <h2 class="fw-bold mb-2">Register Your Library</h2>
                            <p class="text-muted">Create a new IT support ticketing system for your library</p>
                        </div>

                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('tenant.register') }}">
                            @csrf

                            <!-- Library Information -->
                            <h5 class="text-primary mb-3">Library Information</h5>
                            
                            <div class="mb-3">
                                <label for="library_name" class="form-label fw-semibold">
                                    Library Name <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control form-control-lg @error('library_name') is-invalid @enderror" 
                                       id="library_name" 
                                       name="library_name" 
                                       value="{{ old('library_name') }}" 
                                       placeholder="e.g., Springfield Public Library"
                                       required>
                                @error('library_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="subdomain" class="form-label fw-semibold">
                                    Subdomain <span class="text-danger">*</span>
                                </label>
                                <div class="input-group input-group-lg">
                                    <input type="text" 
                                           class="form-control @error('subdomain') is-invalid @enderror" 
                                           id="subdomain" 
                                           name="subdomain" 
                                           value="{{ old('subdomain') }}" 
                                           placeholder="springfield"
                                           required>
                                    <span class="input-group-text">.{{ config('app.domain') }}</span>
                                </div>
                                <small class="text-muted">This will be your unique URL to access the system</small>
                                @error('subdomain')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Administrator Information -->
                            <h5 class="text-primary mb-3 mt-4">Administrator Information</h5>

                            <div class="mb-3">
                                <label for="admin_name" class="form-label fw-semibold">
                                    Full Name <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control form-control-lg @error('admin_name') is-invalid @enderror" 
                                       id="admin_name" 
                                       name="admin_name" 
                                       value="{{ old('admin_name') }}" 
                                       required>
                                @error('admin_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="admin_email" class="form-label fw-semibold">
                                    Email Address <span class="text-danger">*</span>
                                </label>
                                <input type="email" 
                                       class="form-control form-control-lg @error('admin_email') is-invalid @enderror" 
                                       id="admin_email" 
                                       name="admin_email" 
                                       value="{{ old('admin_email') }}" 
                                       required>
                                @error('admin_email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
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
                                <small class="text-muted">Must be at least 8 characters</small>
                            </div>

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

                            <!-- Terms -->
                            <div class="form-check mb-4">
                                <input class="form-check-input" type="checkbox" id="terms" required>
                                <label class="form-check-label" for="terms">
                                    I agree to the terms of service and understand that my registration requires approval
                                </label>
                            </div>

                            <!-- Submit Button -->
                            <div class="d-grid gap-2 mb-4">
                                <button type="submit" class="btn btn-primary btn-lg py-3">
                                    Submit Registration
                                </button>
                            </div>

                            <!-- Login Link -->
                            <div class="text-center">
                                <p class="text-muted mb-0">
                                    Already have an account? 
                                    <a href="{{ route('login') }}" class="text-decoration-none fw-semibold">
                                        Sign in here
                                    </a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</x-guest-layout>