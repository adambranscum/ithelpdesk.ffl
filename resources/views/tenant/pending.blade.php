<x-guest-layout>
<div class="min-vh-100 d-flex align-items-center justify-content-center py-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card border-0 shadow-lg">
                    <div class="card-body p-5 text-center">
                        <!-- Success Icon -->
                        <div class="mb-4">
                            <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex p-4 mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-hourglass-split text-warning" viewBox="0 0 16 16">
                                    <path d="M2.5 15a.5.5 0 1 1 0-1h1v-1a4.5 4.5 0 0 1 2.557-4.06c.29-.139.443-.377.443-.59v-.7c0-.213-.154-.451-.443-.59A4.5 4.5 0 0 1 3.5 3V2h-1a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1h-1v1a4.5 4.5 0 0 1-2.557 4.06c-.29.139-.443.377-.443.59v.7c0 .213.154.451.443.59A4.5 4.5 0 0 1 12.5 13v1h1a.5.5 0 0 1 0 1h-11zm2-13v1c0 .537.12 1.045.337 1.5h6.326c.216-.455.337-.963.337-1.5V2h-7zm3 6.35c0 .701-.478 1.236-1.011 1.492A3.5 3.5 0 0 0 4.5 13s.866-1.299 3-1.48V8.35zm1 0v3.17c2.134.181 3 1.48 3 1.48a3.5 3.5 0 0 0-1.989-3.158C8.978 9.586 8.5 9.052 8.5 8.351z"/>
                                </svg>
                            </div>
                        </div>

                        <!-- Message -->
                        <h2 class="fw-bold mb-3">Registration Submitted!</h2>
                        <p class="text-muted mb-4">
                            Thank you for registering your library. Your account is currently pending approval from our administrators.
                        </p>

                        @if($tenant)
                            <div class="bg-light rounded p-4 mb-4">
                                <div class="row text-start">
                                    <div class="col-12 mb-3">
                                        <small class="text-muted d-block mb-1">Library Name</small>
                                        <strong>{{ $tenant->name }}</strong>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <small class="text-muted d-block mb-1">Subdomain</small>
                                        <strong>{{ $tenant->domain }}.{{ config('app.domain') }}</strong>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <small class="text-muted d-block mb-1">Administrator Email</small>
                                        <strong>{{ $tenant->admin_email }}</strong>
                                    </div>
                                    <div class="col-12">
                                        <small class="text-muted d-block mb-1">Status</small>
                                        <span class="badge bg-warning">Pending Approval</span>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Instructions -->
                        <div class="alert alert-info mb-4">
                            <h6 class="mb-2">What happens next?</h6>
                            <ul class="text-start mb-0 small">
                                <li>Our team will review your registration</li>
                                <li>You'll receive an email once your account is approved</li>
                                <li>After approval, you can log in at your subdomain</li>
                                <li>This process typically takes 1-2 business days</li>
                            </ul>
                        </div>

                        <!-- Contact Info -->
                        <p class="small text-muted mb-4">
                            If you have any questions, please contact us at 
                            <a href="mailto:support@{{ config('app.domain') }}" class="text-decoration-none">
                                support@{{ config('app.domain') }}
                            </a>
                        </p>

                        <!-- Back to Home -->
                        <a href="{{ route('home') }}" class="btn btn-outline-primary">
                            Back to Home
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</x-guest-layout>