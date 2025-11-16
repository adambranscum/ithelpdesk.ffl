<x-app-layout>

<div class="container mt-4">
    <h2 class="mb-4">Tickets Assigned to {{ $userType }}</h2>

    {{-- tickets.index Stats --}}
    <div class="row mb-4 text-center">
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-primary">
                <div class="card-body">
                    <h5 class="card-title text-primary">Total</h5>
                    <h3>{{ $stats['total'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-info">
                <div class="card-body">
                    <h5 class="card-title text-info">New</h5>
                    <h3>{{ $stats['new'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-warning">
                <div class="card-body">
                    <h5 class="card-title text-warning">In Progress</h5>
                    <h3>{{ $stats['in_progress'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-success">
                <div class="card-body">
                    <h5 class="card-title text-success">Resolved</h5>
                    <h3>{{ $stats['resolved'] }}</h3>
                </div>
            </div>
        </div>
    </div>

    {{-- Filter Form --}}
    <form method="GET" action="{{ route('tickets.index') }}" class="row mb-4 g-2">
        <div class="col-md-4">
            <input 
                type="text" 
                name="search" 
                class="form-control" 
                placeholder="Search by subject, name, or email"
                value="{{ request('search') }}"
            >
        </div>
        <div class="col-md-3">
            <select name="status" class="form-select">
                <option value="">All Statuses</option>
                <option value="new" {{ request('status') == 'new' ? 'selected' : '' }}>New</option>
                <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Resolved</option>
            </select>
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary w-100">Filter</button>
        </div>
        <div class="col-md-2">
            <a href="{{ route('tickets.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
        </div>
    </form>

    {{-- Tickets Table --}}
    <div class="card shadow-sm">
        <div class="card-body">
            @if($tickets->count())
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Subject</th>
                            <th scope="col">From</th>
                            <th scope="col">Email</th>
                            <th scope="col">Status</th>
                            <th scope="col">Updated</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tickets as $ticket)
                            <tr>
                                <td>{{ $ticket->id }}</td>
                                <td>
                                    <a href="{{ route('tickets.show', $ticket->id) }}" class="text-decoration-none">
                                        {{ $ticket->subject }}
                                    </a>
                                </td>
                                <td>{{ $ticket->from_name }}</td>
                                <td>{{ $ticket->from_email }}</td>
                                <td>
                                    @if($ticket->status == 'new')
                                        <span class="badge bg-info text-dark">New</span>
                                    @elseif($ticket->status == 'in_progress')
                                        <span class="badge bg-warning text-dark">In Progress</span>
                                    @elseif($ticket->status == 'resolved')
                                        <span class="badge bg-success">Resolved</span>
                                    @else
                                        <span class="badge bg-secondary">{{ ucfirst($ticket->status) }}</span>
                                    @endif
                                </td>
                                <td>{{ $ticket->updated_at->diffForHumans() }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-3">
                    {{ $tickets->withQueryString()->links('pagination::bootstrap-5') }}
                </div>
            @else
                <p class="text-center text-muted mb-0">No tickets found.</p>
            @endif
        </div>
    </div>
</div>


</x-app-layout>
