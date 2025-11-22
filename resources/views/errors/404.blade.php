<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card border-0 shadow-lg text-center">
                    <div class="card-body p-5">
                        <h1 class="display-1 fw-bold text-primary">404</h1>
                        <h2 class="mb-4">Page Not Found</h2>
                        <p class="text-muted mb-4">
                            Sorry, the page you're looking for doesn't exist.
                        </p>
                        
                        @php
                            $isTenant = false;
                            try {
                                $isTenant = tenancy()->initialized ?? false;
                            } catch (\Exception $e) {
                                $isTenant = false;
                            }
                        @endphp
                        
                        @if($isTenant)
                            {{-- Tenant domain --}}
                            @auth
                                <a href="{{ route('tickets.index') }}" class="btn btn-primary">
                                    Go to Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-primary">
                                    Go to Login
                                </a>
                            @endauth
                        @else
                            {{-- Central domain --}}
                            @auth
                                @if(auth()->user()->isSuperAdmin())
                                    <a href="{{ route('super-admin.tenants.index') }}" class="btn btn-primary">
                                        Go to Dashboard
                                    </a>
                                @else
                                    <a href="{{ route('home') }}" class="btn btn-primary">
                                        Go Home
                                    </a>
                                @endif
                            @else
                                <a href="{{ route('home') }}" class="btn btn-primary">
                                    Go Home
                                </a>
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>