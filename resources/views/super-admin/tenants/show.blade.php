<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Tenant Details') }}
            </h2>
            <a href="{{ route('super-admin.tenants.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Back to List
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="row g-4">
                <!-- Main Info Card -->
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Library Information</h5>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th width="200">Library Name</th>
                                        <td>{{ $tenant->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Subdomain</th>
                                        <td>
                                            <code>{{ $tenant->domain }}.{{ config('app.domain') }}</code>
                                            @if($tenant->isActive())
                                                <a href="https://{{ $tenant->domain }}.{{ config('app.domain') }}" 
                                                   target="_blank" 
                                                   class="btn btn-sm btn-link">
                                                    Visit <i class="bi bi-box-arrow-up-right"></i>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Database Name</th>
                                        <td><code>{{ $tenant->database }}</code></td>
                                    </tr>
                                    <tr>
                                        <th>Administrator Name</th>
                                        <td>{{ $tenant->admin_name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Administrator Email</th>
                                        <td>
                                            <a href="mailto:{{ $tenant->admin_email }}">{{ $tenant->admin_email }}</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Registration Date</th>
                                        <td>{{ $tenant->created_at->format('F d, Y \a\t g:i A') }}</td>
                                    </tr>
                                    @if($tenant->approved_at)
                                        <tr>
                                            <th>Approved Date</th>
                                            <td>{{ $tenant->approved_at->format('F d, Y \a\t g:i A') }}</td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <th>Status</th>
                                        <td>
                                            @if($tenant->status == 'pending')
                                                <span class="badge bg-warning">Pending Approval</span>
                                            @elseif($tenant->status == 'active')
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-danger">Suspended</span>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Notes Section -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Notes</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('super-admin.tenants.update-notes', $tenant) }}">
                                @csrf
                                @method('PATCH')
                                <textarea name="notes" 
                                          class="form-control" 
                                          rows="5" 
                                          placeholder="Add internal notes about this tenant...">{{ $tenant->notes }}</textarea>
                                <div class="mt-3">
                                    <button type="submit" class="btn btn-primary">
                                        Save Notes
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Actions Sidebar -->
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Actions</h5>
                        </div>
                        <div class="card-body">
                            @if($tenant->isPending())
                                <form method="POST" 
                                      action="{{ route('super-admin.tenants.approve', $tenant) }}" 
                                      class="mb-3">
                                    @csrf
                                    <button type="submit" 
                                            class="btn btn-success w-100"
                                            onclick="return confirm('Are you sure you want to approve this tenant? This will create their database and admin account.')">
                                        <i class="bi bi-check-circle"></i> Approve Tenant
                                    </button>
                                </form>
                            @elseif($tenant->isActive())
                                <form method="POST" 
                                      action="{{ route('super-admin.tenants.suspend', $tenant) }}" 
                                      class="mb-3">
                                    @csrf
                                    <button type="submit" 
                                            class="btn btn-warning w-100"
                                            onclick="return confirm('Are you sure you want to suspend this tenant? They will not be able to access their system.')">
                                        <i class="bi bi-pause-circle"></i> Suspend Tenant
                                    </button>
                                </form>
                            @else
                                <form method="POST" 
                                      action="{{ route('super-admin.tenants.activate', $tenant) }}" 
                                      class="mb-3">
                                    @csrf
                                    <button type="submit" 
                                            class="btn btn-success w-100"
                                            onclick="return confirm('Are you sure you want to reactivate this tenant?')">
                                        <i class="bi bi-play-circle"></i> Reactivate Tenant
                                    </button>
                                </form>
                            @endif

                            @if(!$tenant->isActive())
                                <form method="POST" 
                                      action="{{ route('super-admin.tenants.destroy', $tenant) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-danger w-100"
                                            onclick="return confirm('Are you sure you want to DELETE this tenant? This action cannot be undone and will delete all their data!')">
                                        <i class="bi bi-trash"></i> Delete Tenant
                                    </button>
                                </form>
                            @endif

                            <hr class="my-3">

                            <div class="alert alert-info small mb-0">
                                <strong>Note:</strong> Tenants can only be deleted when they are suspended or pending.
                            </div>
                        </div>
                    </div>

                    <!-- Quick Stats -->
                    <div class="card border-0 shadow-sm mt-4">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Quick Stats</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Total Users:</span>
                                <strong>-</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Total Tickets:</span>
                                <strong>-</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Total Devices:</span>
                                <strong>-</strong>
                            </div>
                            <small class="text-muted">
                                <em>Stats will be available after tenant is approved</em>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>