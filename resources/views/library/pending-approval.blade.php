<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registration Pending - Community Helpdesk</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}?v={{ time() }}">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="/">
                The Community Helpdesk
            </a>

            <div class="ms-auto d-flex gap-2">
                @auth
                    <a href="{{ url('/tickets') }}" class="btn btn-sm btn-primary">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-sm btn-outline-primary">
                        Login
                    </a>
                    <a href="/library/register" class="btn btn-sm btn-outline-primary">
                        Register
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Hero Section with Pending Status -->
    <section class="hero-section min-vh-100">
        <div class="container">
            <div class="hero-content">
                <h1>Registration Pending Approval</h1>
                <p class="lead">
                    Thank you for registering with the Community Helpdesk! Your library account is currently pending manual approval.
                </p>

                <div class="mt-5 p-4 bg-white bg-opacity-95 rounded-3 shadow-sm" style="max-width: 700px; margin: 2rem auto; text-align: left;">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <h5 class="text-gradient-primary mb-3">
                                What's Happening
                            </h5>
                            <p class="text-dark">
                                Our team is reviewing your library's registration and verifying all the information you provided. This usually takes 1-2 business days.
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h5 class="text-gradient-primary mb-3">
                                Stay Informed
                            </h5>
                            <p class="text-dark">
                                You'll receive an email notification as soon as your account has been approved. We may also reach out if we need any additional information.
                            </p>
                        </div>
                    </div>

                    <hr class="my-4">

                    <h5 class="text-gradient-primary mb-3">
                        Once Approved
                    </h5>
                    <ul class="list-unstyled text-dark" style="line-height: 1.8;">
                        <li>Full access to the library dashboard</li>
                        <li>Ability to create and manage IT support tickets</li>
                        <li>Staff and device management features</li>
                        <li>Analytics and reporting tools</li>
                    </ul>
                </div>

                <div class="d-flex gap-3 justify-content-center flex-wrap mt-4">
                    <a href="/" class="btn btn-hero btn-primary-light">
                        Return to Home
                    </a>
                    <a href="mailto:webmaster@freewareforlibraries.org" class="btn btn-hero btn-outline-light">
                        Contact Support
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <p>&copy; 2024 www.thecommunityhelpdesk.org</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
