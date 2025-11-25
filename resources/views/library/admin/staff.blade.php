<x-app-layout>

<div class="container mt-5">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="display-4 fw-bold">Manage Staff</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('library.admin.staff.create') }}" class="btn btn-primary">
                Add Staff Member
            </a>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-light border-bottom">
            <h5 class="mb-0 fw-semibold">Staff Members</h5>
        </div>

        @if (session('success'))
            <div class="alert alert-success mb-0 border-0 rounded-0">
                {{ session('success') }}
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="fw-semibold">Name</th>
                        <th class="fw-semibold">Email</th>
                        <th class="fw-semibold">Status</th>
                        <th class="fw-semibold">Joined</th>
                        <th class="fw-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($staff as $member)
                        <tr>
                            <td class="fw-medium">{{ $member->name }}</td>
                            <td>{{ $member->email }}</td>
                            <td>
                                <span class="badge"
                                    style="background-color: {{ $member->is_active ? '#28a745' : '#dc3545' }};">
                                    {{ $member->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>{{ $member->created_at->format('M d, Y') }}</td>
                            <td>
                                <a href="{{ route('library.admin.staff.edit', $member->id) }}" class="btn btn-sm btn-link text-primary">
                                    Edit
                                </a>
                                @if($member->is_active)
                                    <form action="{{ route('library.admin.staff.deactivate', $member->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-link text-danger"
                                            onclick="return confirm('Are you sure you want to deactivate this staff member?');">
                                            Deactivate
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('library.admin.staff.reactivate', $member->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-link text-primary">
                                            Reactivate
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <p class="mb-3">No staff members yet.</p>
                                <a href="{{ route('library.admin.staff.create') }}" class="btn btn-sm btn-primary">
                                    Create the first one
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

</x-app-layout>
