<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Community Helpdesk - Library IT Support System</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary: #667eea;
            --secondary: #764ba2;
            --accent: #f093fb;
            --dark: #1a1a2e;
            --light: #f8f9fa;
        }

        * {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #fff;
            color: #333;
        }

        /* Navbar Styling */
        .navbar {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .navbar-brand {
            font-size: 1.5rem;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 700;
        }

        .navbar a.btn {
            font-weight: 600;
            transition: all 0.3s ease;
        }

        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            position: relative;
            overflow: hidden;
            padding: 120px 0;
            min-height: 85vh;
            display: flex;
            align-items: center;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background:
                radial-gradient(circle at 20% 50%, rgba(255, 147, 251, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(102, 126, 234, 0.1) 0%, transparent 50%);
            z-index: 1;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            text-align: center;
            color: white;
        }

        .hero-content h1 {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            line-height: 1.2;
            letter-spacing: -1px;
        }

        .hero-content .lead {
            font-size: 1.3rem;
            opacity: 0.95;
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        .btn-hero {
            padding: 12px 30px;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.3s ease;
            border: none;
        }

        .btn-primary-light {
            background: white;
            color: var(--primary);
        }

        .btn-primary-light:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        }

        .btn-outline-light {
            border: 2px solid white;
        }

        .btn-outline-light:hover {
            background: white;
            color: var(--primary);
            transform: translateY(-2px);
        }

        /* Features Section */
        .features-section {
            padding: 80px 0;
            background: #f8f9fa;
        }

        .section-title {
            text-align: center;
            margin-bottom: 60px;
        }

        .section-title h2 {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 1rem;
            color: var(--dark);
        }

        .section-title p {
            font-size: 1.1rem;
            color: #666;
            max-width: 600px;
            margin: 0 auto;
        }

        .feature-card {
            background: white;
            padding: 2.5rem;
            border-radius: 12px;
            text-align: center;
            transition: all 0.3s ease;
            border: 1px solid #f0f0f0;
            height: 100%;
        }

        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(102, 126, 234, 0.15);
            border-color: var(--primary);
        }

        .feature-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2rem;
            color: white;
        }

        .feature-card h4 {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: var(--dark);
        }

        .feature-card p {
            color: #666;
            line-height: 1.6;
        }

        /* Pricing/Hosting Section */
        .hosting-section {
            padding: 80px 0;
            background: white;
        }

        .hosting-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
        }

        .hosting-text h2 {
            font-size: 2.2rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            color: var(--dark);
        }

        .hosting-text p {
            font-size: 1.05rem;
            color: #666;
            margin-bottom: 1.2rem;
            line-height: 1.7;
        }

        .hosting-card {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            padding: 3rem;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(102, 126, 234, 0.25);
            text-align: center;
        }

        .hosting-card h3 {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 2rem;
        }

        .feature-list {
            list-style: none;
            margin-bottom: 2.5rem;
        }

        .feature-list li {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
            font-size: 1rem;
        }

        .feature-list i {
            color: var(--accent);
            margin-right: 1rem;
            font-size: 1.2rem;
        }

        .hosting-card .btn {
            background: white;
            color: var(--primary);
            padding: 12px 30px;
            font-weight: 600;
            border-radius: 8px;
            border: none;
            transition: all 0.3s ease;
        }

        .hosting-card .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        /* CTA Section */
        .cta-section {
            background: linear-gradient(135deg, var(--dark) 0%, #2d2d44 100%);
            padding: 60px 0;
            text-align: center;
            color: white;
        }

        .cta-section h2 {
            font-size: 2.2rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
        }

        .cta-section p {
            font-size: 1.1rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }

        /* Footer */
        footer {
            background: #0f0f1e;
            color: #999;
            padding: 40px 0;
            text-align: center;
        }

        footer p {
            margin: 0;
            font-size: 0.95rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-content h1 {
                font-size: 2.2rem;
            }

            .hero-content .lead {
                font-size: 1.05rem;
            }

            .section-title h2 {
                font-size: 2rem;
            }

            .hosting-content {
                grid-template-columns: 1fr;
            }

            .cta-section h2 {
                font-size: 1.8rem;
            }
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in-up {
            animation: fadeInUp 0.6s ease-out;
        }
    </style>
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

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <h2>Join Hundreds of Libraries Using Community Helpdesk</h2>
            <p>Start managing your IT support better today – it's free and easy to get started</p>
            <div class="d-flex gap-3 justify-content-center flex-wrap">
                @auth
                    <a href="{{ url('/tickets') }}" class="btn btn-hero btn-primary-light">
                        Go to Dashboard
                    </a>
                @else
                    <a href="/library/register" class="btn btn-hero btn-primary-light">
                        <i class="fas fa-arrow-right me-2"></i> Get Started Free
                    </a>
                    <a href="{{ route('login') }}" class="btn btn-hero btn-outline-light">
                        Sign In
                    </a>
                @endauth
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