<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $library->ticket_page_title ?? 'Submit a Ticket' }} - {{ $library->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .header {
            background-color: {{ $library->primary_color ?? '#0d6efd' }};
            color: white;
            padding: 3rem 0;
            margin-bottom: 2rem;
        }
        .logo-section {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .logo {
            max-height: 80px;
        }
        .form-section {
            background: white;
            padding: 2rem;
            border-radius: 0.5rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }
        .btn-submit {
            background-color: {{ $library->brand_color ?? '#0d6efd' }};
            border-color: {{ $library->brand_color ?? '#0d6efd' }};
            color: white;
        }
        .btn-submit:hover {
            background-color: {{ $library->brand_color ?? '#0c63e4' }};
            border-color: {{ $library->brand_color ?? '#0c63e4' }};
            color: white;
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

                        <div class="mb-3">
                            <label for="name" class="form-label">Your Name <span class="text-danger">*</span></label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                class="form-control @error('name') is-invalid @enderror"
                                placeholder="John Doe">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                class="form-control @error('email') is-invalid @enderror"
                                placeholder="john@example.com">
                            @error('email')
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

                        <div class="mb-4">
                            <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                            <textarea id="description" name="description" rows="6" required
                                class="form-control @error('description') is-invalid @enderror"
                                placeholder="Please provide details about your issue...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2 justify-content-end">
                            <button type="reset" class="btn btn-outline-secondary">
                                Clear
                            </button>
                            <button type="submit" class="btn btn-submit">
                                Submit Ticket
                            </button>
                        </div>
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
