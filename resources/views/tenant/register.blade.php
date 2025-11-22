<x-guest-layout>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white text-center">
                    <h3 class="mb-0">Library Tenant Registration</h3>
                </div>

                <div class="card-body p-4">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>There were some problems with your input:</strong>
                            <ul class="mt-2 mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('tenant.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Library Name</label>
                            <input type="text" name="library_name" class="form-control" value="{{ old('library_name') }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Subdomain</label>
                            <div class="input-group">
                                <input type="text" name="subdomain" class="form-control" value="{{ old('subdomain') }}" required>
                                <span class="input-group-text">.{{ config('app.domain') }}</span>
                            </div>
                            <small class="text-muted">This will be your library’s login URL.</small>
                        </div>

                        <div class="divider my-4"></div>

                        <h5 class="text-primary">Admin Contact</h5>

                        <div class="mb-3 mt-3">
                            <label class="form-label">Admin Full Name</label>
                            <input type="text" name="admin_name" class="form-control" value="{{ old('admin_name') }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Admin Email</label>
                            <input type="email" name="admin_email" class="form-control" value="{{ old('admin_email') }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>

                        <button class="btn btn-primary w-100 py-2">Submit Registration</button>
                    </form>
                </div>

            </div>

        </div>
    </div>
</div>
</x-guest-layout>
