<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $library->ticket_page_title ?? 'Submit a Ticket' }} - {{ $library->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }
        .header {
            background-color: {{ $library->primary_color ?? '#0d6efd' }};
            color: white;
            padding: 2.5rem 0;
            margin-bottom: 3rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        .logo-section {
            display: flex;
            align-items: center;
            gap: 2rem;
        }
        .logo {
            max-height: 80px;
            object-fit: contain;
        }
        .form-section {
            background: white;
            padding: 2.5rem;
            border-radius: 0.75rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        .form-section-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid {{ $library->brand_color ?? '#0d6efd' }};
        }
        .form-row-group {
            margin-bottom: 1.5rem;
        }
        .form-control {
            border: 1px solid #e0e0e0;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            border-color: {{ $library->brand_color ?? '#0d6efd' }};
            box-shadow: 0 0 0 0.2rem rgba({{ (str_replace('#', '', $library->brand_color ?? '#0d6efd')) }}, 0.25);
        }
        .btn-submit {
            background-color: {{ $library->brand_color ?? '#0d6efd' }};
            border-color: {{ $library->brand_color ?? '#0d6efd' }};
            color: white;
            font-weight: 600;
            padding: 0.75rem 2rem;
            transition: all 0.3s ease;
        }
        .btn-submit:hover {
            background-color: {{ $library->brand_color ?? '#0c63e4' }};
            border-color: {{ $library->brand_color ?? '#0c63e4' }};
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        .required-note {
            color: #666;
            font-size: 0.9rem;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid #e0e0e0;
        }
    </style>
</head>
<body>
    <!-- Header with branding -->
    <div class="header">
        <div class="container">
            <div class="logo-section">
                @if($library->logo_path)
                    <img src="{{ asset('storage/' . $library->logo_path) }}" alt="{{ $library->name }}" class="logo">
                @else
                    <div style="height: 80px; width: 80px; background-color: {{ $library->brand_color ?? '#0d6efd' }}; border-radius: 0.5rem; opacity: 0.5;"></div>
                @endif
                <div>
                    <h1 class="h2 mb-2">{{ $library->ticket_page_title ?? 'Submit a Ticket' }}</h1>
                    <p class="mb-0">{{ $library->ticket_page_description ?? 'We\'re here to help. Submit your IT support request below.' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <h5 class="alert-heading">Please fix the following errors:</h5>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="form-section">
                    <form method="POST" action="{{ route('library.public.store') }}">
                        @csrf

                        <!-- Contact Information Section -->
                        <div class="form-section-title">Contact Information</div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Your Name <span class="text-danger">*</span></label>
                                    <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                        class="form-control @error('name') is-invalid @enderror"
                                        placeholder="John Doe">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                        class="form-control @error('email') is-invalid @enderror"
                                        placeholder="john@example.com">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Organization Information Section -->
                        <div class="form-section-title">Organization Information</div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="branch" class="form-label">Branch <span class="text-secondary">(Optional)</span></label>
                                    <select id="branch" name="branch"
                                        class="form-select @error('branch') is-invalid @enderror">
                                        <option value="">Select a branch...</option>
                                        @forelse($categories['branch'] ?? [] as $category)
                                            <option value="{{ $category->name }}" {{ old('branch') === $category->name ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @empty
                                            <option disabled>No branches available</option>
                                        @endforelse
                                    </select>
                                    @error('branch')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="department" class="form-label">Department <span class="text-secondary">(Optional)</span></label>
                                    <select id="department" name="department"
                                        class="form-select @error('department') is-invalid @enderror">
                                        <option value="">Select a department...</option>
                                        @forelse($categories['department'] ?? [] as $category)
                                            <option value="{{ $category->name }}" {{ old('department') === $category->name ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @empty
                                            <option disabled>No departments available</option>
                                        @endforelse
                                    </select>
                                    @error('department')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Issue Information Section -->
                        <div class="form-section-title">Issue Details</div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="network" class="form-label">Network <span class="text-secondary">(Optional)</span></label>
                                    <select id="network" name="network"
                                        class="form-select @error('network') is-invalid @enderror">
                                        <option value="">Select a network...</option>
                                        @forelse($categories['network'] ?? [] as $category)
                                            <option value="{{ $category->name }}" {{ old('network') === $category->name ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @empty
                                            <option disabled>No networks available</option>
                                        @endforelse
                                    </select>
                                    @error('network')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="website" class="form-label">Website <span class="text-secondary">(Optional)</span></label>
                                    <select id="website" name="website"
                                        class="form-select @error('website') is-invalid @enderror">
                                        <option value="">Select a website...</option>
                                        @forelse($categories['website'] ?? [] as $category)
                                            <option value="{{ $category->name }}" {{ old('website') === $category->name ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @empty
                                            <option disabled>No websites available</option>
                                        @endforelse
                                    </select>
                                    @error('website')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="security" class="form-label">Security Issue <span class="text-secondary">(Optional)</span></label>
                            <select id="security" name="security"
                                class="form-select @error('security') is-invalid @enderror">
                                <option value="">Select a security issue type...</option>
                                @forelse($categories['security'] ?? [] as $category)
                                    <option value="{{ $category->name }}" {{ old('security') === $category->name ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @empty
                                    <option disabled>No security issues available</option>
                                @endforelse
                            </select>
                            @error('security')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="subject" class="form-label">Subject <span class="text-danger">*</span></label>
                            <input type="text" id="subject" name="subject" value="{{ old('subject') }}" required
                                class="form-control @error('subject') is-invalid @enderror"
                                placeholder="Brief description of your issue">
                            @error('subject')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                            <textarea id="description" name="description" rows="6" required
                                class="form-control @error('description') is-invalid @enderror"
                                placeholder="Please provide details about your issue...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Form Actions -->
                        <div class="d-flex gap-2 justify-content-end">
                            <button type="reset" class="btn btn-outline-secondary">
                                Clear Form
                            </button>
                            <button type="submit" class="btn btn-submit">
                                Submit Ticket
                            </button>
                        </div>

                        <p class="required-note"><span class="text-danger">*</span> Required fields</p>
                    </form>
                </div>

                <div class="mt-4 text-center text-muted">
                    <p><small>Your information is secure and will only be used to process your support request.</small></p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
