<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Community Helpdesk - Library IT Support System</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/">
                The Community Helpdesk
            </a>

            <div class="ms-auto d-flex gap-2">
                @auth
                    <a href="{{ url('/tickets') }}" class="btn btn-sm btn-primary">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-sign-in-alt me-1"></i> Login
                    </a>
                    <a href="/library/register" class="btn btn-sm btn-primary">
                        <i class="fas fa-building me-1"></i> Register
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="hero-content">
                <h1>Library IT Support Made Simple</h1>
                <p class="lead">
                    A powerful, free ticketing system designed for libraries to manage IT support efficiently, organize staff, and keep patrons happy.
                </p>
                <div class="d-flex gap-3 justify-content-center flex-wrap mt-4">
                    @auth
                        <a href="{{ url('/tickets') }}" class="btn btn-hero btn-primary-light">
                            <i class="fas fa-arrow-right me-2"></i> Go to Dashboard
                        </a>
                    @else
                        <a href="/library/register" class="btn btn-hero btn-primary-light">
                            <i class="fas fa-building me-2"></i> Register Your Library
                        </a>
                        <a href="{{ route('login') }}" class="btn btn-hero btn-outline-light">
                            <i class="fas fa-sign-in-alt me-2"></i> Sign In
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section">
        <div class="container">
            <div class="section-title">
                <h2>Powerful Features for Your Library</h2>
                <p>Everything you need to manage IT support efficiently</p>
            </div>

            <div class="row g-4">
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-ticket-alt"></i>
                        </div>
                        <h4>Ticket Management</h4>
                        <p>Create, track, and manage IT support tickets with ease. Never miss a patron request again.</p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h4>Staff Management</h4>
                        <p>Organize your IT team, assign tickets, and track who's handling what.</p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-chart-bar"></i>
                        </div>
                        <h4>Detailed Analytics</h4>
                        <p>Get insights into device inventory, software licenses, and support trends.</p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-cog"></i>
                        </div>
                        <h4>Device Tracking</h4>
                        <p>Maintain a complete inventory of library devices with warranty info and history.</p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-lock"></i>
                        </div>
                        <h4>License Management</h4>
                        <p>Monitor software licenses, renewal dates, and usage across your library.</p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-book"></i>
                        </div>
                        <h4>Knowledge Base</h4>
                        <p>Build a library of standard operating procedures and common IT solutions.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Hosting Section -->
    <section class="hosting-section">
        <div class="container">
            <div class="hosting-content">
                <div class="hosting-text">
                    <h2>Ready for More?</h2>
                    <p>You're using the free Community Helpdesk freeware edition – great for getting started! We also offer a privately hosted version with advanced features.</p>
                    <p>Get professional hosting, advanced integrations, and dedicated support to take your IT operations to the next level.</p>
                    <p style="color: var(--dark); font-weight: 600;">Perfect for libraries wanting enterprise-level features without the complexity.</p>
                </div>

                <div class="hosting-card">
                    <h3><i class="fas fa-cloud me-2"></i>Private Hosting</h3>
                    <ul class="feature-list">
                        <li>
                            <i class="fas fa-check-circle"></i>
                            <span>Office 365 Integration</span>
                        </li>
                        <li>
                            <i class="fas fa-check-circle"></i>
                            <span>Email-to-Ticket Conversion</span>
                        </li>
                        <li>
                            <i class="fas fa-check-circle"></i>
                            <span>Dedicated Support Team</span>
                        </li>
                        <li>
                            <i class="fas fa-check-circle"></i>
                            <span>Custom Integrations</span>
                        </li>
                        <li>
                            <i class="fas fa-check-circle"></i>
                            <span>Advanced Reporting</span>
                        </li>
                        <li>
                            <i class="fas fa-check-circle"></i>
                            <span>Priority Updates</span>
                        </li>
                    </ul>
                    <a href="mailto:webmaster@freewareforlibraries.org" class="btn">
                        <i class="fas fa-envelope me-2"></i>Contact Us Today
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <p>&copy; 2024 The Community Helpdesk. Powering IT support for libraries everywhere.</p>
            <p style="margin-top: 0.5rem; font-size: 0.9rem;">www.thecommunityhelpdesk.org</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>