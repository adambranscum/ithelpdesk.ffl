<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NLRPLS IT Support Ticketing System</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            position: relative;
            overflow: hidden;
        }
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="%23ffffff" fill-opacity="0.1" d="M0,96L48,112C96,128,192,160,288,186.7C384,213,480,235,576,213.3C672,192,768,128,864,128C960,128,1056,192,1152,197.3C1248,203,1344,149,1392,122.7L1440,96L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>') no-repeat bottom;
            background-size: cover;
        }
        .stat-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.2) !important;
        }
        .pulse {
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }
        .feature-icon {
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            margin: 0 auto 1rem;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark position-absolute w-100" style="z-index: 1000;">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center" href="/">
              NLRPLS IT Support
            </a>
            
            <div class="ms-auto d-flex gap-2">
                @auth
                    <a href="{{ url('/tickets') }}" class="btn btn-light">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-light">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="me-1" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M10 3.5a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-2a.5.5 0 0 1 1 0v2A1.5 1.5 0 0 1 9.5 14h-8A1.5 1.5 0 0 1 0 12.5v-9A1.5 1.5 0 0 1 1.5 2h8A1.5 1.5 0 0 1 11 3.5v2a.5.5 0 0 1-1 0v-2z"/>
                            <path fill-rule="evenodd" d="M4.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H14.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z"/>
                        </svg>
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-light">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="me-1" viewBox="0 0 16 16">
                            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                            <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
                        </svg>
                        Register
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container position-relative" style="z-index: 1;">
            <div class="row min-vh-100 align-items-center">
                <div class="col-lg-6 text-white">
                    <h1 class="display-3 fw-bold mb-4">NLRPLS IT Support Ticketing System</h1>
                    <p class="lead mb-4">
                       
                    </p>
                    <div class="d-flex gap-3 mb-5">
                        @auth
                            <a href="{{ url('/tickets') }}" class="btn btn-light btn-lg px-4">
                                Go to Dashboard
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="ms-2" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
                                </svg>
                            </a>
                        @else
                            <a href="{{ route('register') }}" class="btn btn-light btn-lg px-4">
                                Register
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="ms-2" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
                                </svg>
                            </a>
                            <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg px-4">
                                Sign In
                            </a>
                        @endauth
                    </div>
                </div>

                <div class="col-lg-6">
                    <!-- Live Statistics -->
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="card border-0 shadow-lg stat-card h-100 d-flex">
                                <div class="card-body text-center p-4 mx-auto my-auto">
                                    <h2 class="display-4 fw-bold mb-2 text-dark">{{ $stats['total'] ?? 0 }}</h2>
                                    <p class="text-dark fw-bold mb-0 fw-bold h2">Total Tickets</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="card border-0 shadow-lg stat-card h-100 bg-warning bg-opacity-10 d-flex">
                                <div class="text-center p-4 mx-auto my-auto">
                                    <h2 class="display-4 fw-bold mb-2 text-white">{{ $stats['new'] ?? 0 }}</h2>
                                    <p class="text-white fw-bold mb-0 h2">New Tickets</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="card border-0 shadow-lg stat-card h-100 bg-info bg-opacity-10 d-flex">
                                <div class="card-body text-center p-4 text-white mx-auto">
                                    <h2 class="display-4 fw-bold mb-2">{{ $stats['in_progress'] ?? 0 }}</h2>
                                    <p class="mb-0 h2 fw-bold">In Progress</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="card border-0 shadow-lg stat-card h-100 bg-success bg-opacity-10 d-flex">
                                <div class="card-body text-center p-4 mx-auto my-auto">
                                    <h2 class="display-4 fw-bold mb-2 text-white">{{ $stats['resolved'] ?? 0 }}</h2>
                                    <p class="fw-bold text-white mb-0 h2">Resolved</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4">
        <div class="container text-center">
            <p class="mb-0">www.nlrlibrary.org</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>