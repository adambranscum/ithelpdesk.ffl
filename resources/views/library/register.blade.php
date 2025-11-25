<x-guest-layout>

<div class="min-vh-100 d-flex align-items-center justify-content-center py-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="card border-0 shadow-lg my-4">
                    <div class="card-body p-4 p-md-5">
                        <!-- Header -->
                        <div class="text-center mb-4">
                            <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 120px; height: 120px;">
                               <img width="100" height="100" src="../images/logo.png" style="border-radius: 50%;">
                            </div>
                            <h2 class="fw-bold mb-2" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">Register Your Library</h2>
                            <p class="text-muted">Join The Community Helpdesk</p>
                        </div>

                        <!-- Error Messages -->
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                                <h5 class="alert-heading">Please fix the following errors:</h5>
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form method="POST" action="/library/register">
                            @csrf

                            <!-- Library Name -->
                            <div class="mb-3">
                                <label for="library_name" class="form-label fw-semibold">
                                    Library Name <span class="text-danger">*</span>
                                </label>
                                <input type="text" id="library_name" name="library_name" class="form-control form-control-lg @error('library_name') is-invalid @enderror"
                                       value="{{ old('library_name') }}" required
                                       placeholder="Main Public Library">
                                @error('library_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Subdomain -->
                            <div class="mb-3">
                                <label for="subdomain" class="form-label fw-semibold">
                                    Subdomain <span class="text-danger">*</span>
                                </label>
                                <div class="input-group input-group-lg">
                                    <input type="text" id="subdomain" name="subdomain" class="form-control @error('subdomain') is-invalid @enderror"
                                           value="{{ old('subdomain') }}" required
                                           placeholder="mainlib"
                                           pattern="^[a-z0-9-]+$"
                                           title="Lowercase letters, numbers, and hyphens only">
                                    <span class="input-group-text">.thecommunityhelpdesk.org</span>
                                </div>
                                <small class="form-text text-muted">Lowercase letters, numbers, and hyphens only</small>
                                @error('subdomain')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold">
                                    Library Email <span class="text-danger">*</span>
                                </label>
                                <input type="email" id="email" name="email" class="form-control form-control-lg @error('email') is-invalid @enderror"
                                       value="{{ old('email') }}" required
                                       placeholder="contact@library.org">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Phone -->
                            <div class="mb-3">
                                <label for="phone" class="form-label fw-semibold">
                                    Phone Number
                                </label>
                                <input type="tel" id="phone" name="phone" class="form-control form-control-lg @error('phone') is-invalid @enderror"
                                       value="{{ old('phone') }}"
                                       placeholder="(555) 123-4567">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Address -->
                            <div class="mb-3">
                                <label for="address" class="form-label fw-semibold">
                                    Address
                                </label>
                                <input type="text" id="address" name="address" class="form-control form-control-lg @error('address') is-invalid @enderror"
                                       value="{{ old('address') }}"
                                       placeholder="123 Library Lane">
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- City, State, ZIP -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="city" class="form-label fw-semibold">City</label>
                                    <input type="text" id="city" name="city" class="form-control form-control-lg @error('city') is-invalid @enderror"
                                           value="{{ old('city') }}">
                                    @error('city')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label for="state" class="form-label fw-semibold">State</label>
                                    <input type="text" id="state" name="state" class="form-control form-control-lg @error('state') is-invalid @enderror"
                                           value="{{ old('state') }}">
                                    @error('state')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label for="zip" class="form-label fw-semibold">ZIP Code</label>
                                    <input type="text" id="zip" name="zip" class="form-control form-control-lg @error('zip') is-invalid @enderror"
                                           value="{{ old('zip') }}">
                                    @error('zip')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Divider -->
                            <hr class="my-4">

                            <!-- Admin Name -->
                            <div class="mb-3">
                                <label for="admin_name" class="form-label fw-semibold">
                                    Administrator Name <span class="text-danger">*</span>
                                </label>
                                <input type="text" id="admin_name" name="admin_name" class="form-control form-control-lg @error('admin_name') is-invalid @enderror"
                                       value="{{ old('admin_name') }}" required
                                       placeholder="John Doe">
                                @error('admin_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Admin Email -->
                            <div class="mb-3">
                                <label for="admin_email" class="form-label fw-semibold">
                                    Administrator Email <span class="text-danger">*</span>
                                </label>
                                <input type="email" id="admin_email" name="admin_email" class="form-control form-control-lg @error('admin_email') is-invalid @enderror"
                                       value="{{ old('admin_email') }}" required
                                       placeholder="admin@library.org">
                                @error('admin_email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Admin Password -->
                            <div class="mb-3">
                                <label for="admin_password" class="form-label fw-semibold">
                                    Password <span class="text-danger">*</span>
                                </label>
                                <input type="password" id="admin_password" name="admin_password" class="form-control form-control-lg @error('admin_password') is-invalid @enderror"
                                       required
                                       placeholder="••••••••">
                                <small class="form-text text-muted">Minimum 8 characters, include uppercase, lowercase, number, and symbol</small>
                                @error('admin_password')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="mb-3">
                                <label for="admin_password_confirmation" class="form-label fw-semibold">
                                    Confirm Password <span class="text-danger">*</span>
                                </label>
                                <input type="password" id="admin_password_confirmation" name="admin_password_confirmation" class="form-control form-control-lg @error('admin_password_confirmation') is-invalid @enderror"
                                       required
                                       placeholder="••••••••">
                                @error('admin_password_confirmation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Terms Checkbox -->
                            <div class="mb-4">
                                <div class="form-check">
                                    <input class="form-check-input @error('agree_terms') is-invalid @enderror" type="checkbox" name="agree_terms" id="agree_terms" required {{ old('agree_terms') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="agree_terms">
                                        I agree to the Terms of Service and understand that my library account will be reviewed and must be approved before it becomes active.
                                    </label>
                                    @error('agree_terms')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="d-grid gap-2 mb-3">
                                <button type="submit" class="btn btn-lg py-3 login-submit-btn" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; font-weight: 600; transition: all 0.3s ease;">
                                    Complete Registration
                                </button>
                            </div>

                            <!-- Back to Home Link -->
                            <div class="text-center">
                                <p class="text-muted mb-0">
                                    Already have an account?
                                    <a href="{{ route('login') }}" class="text-decoration-none fw-semibold" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
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
