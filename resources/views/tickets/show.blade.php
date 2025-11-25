<x-app-layout>

<div class="container shadow mt-4 pt-4 pb-4">
    <div class="d-flex">
        <h2 class="mb-4 fw-bolder me-auto text-gradient-primary">Ticket #{{ $ticket->id }} — {{ $ticket->subject }}</h2>
        <a class="ms-auto btn btn-sm d-flex align-items-center logout-btn mb-4" href="{{ route('tickets.index') }}">Back to Tickets</a>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Ticket Header --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <p><strong>From:</strong> {{ $ticket->from_name }} ({{ $ticket->from_email }})</p>
            <p><strong>Assigned To:</strong> {{ $ticket->assigned_to }}</p>
            <p><strong>Created:</strong> {{ $ticket->created_at}}</p>
            @if($ticket->end_time)
                <p><strong>Closed:</strong> {{$ticket->end_time}}</p>
            @endif
            <p class="mt-3"><strong>Message:</strong></p>
            <div class="p-3 bg-light border rounded">
                {!!html_entity_decode($ticket->body)!!}
            </div>
        </div>
    </div>

  {{-- Update Status --}}
<div class="card shadow-sm mb-4">
    <div class="card-header" style="background: white; background: linear-gradient(90deg, #a855f7, #7c3aed); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;" class="fw-bold">Update Status</div>
    <div class="card-body">
        <form method="POST" action="{{ route('tickets.updateStatus', $ticket->id) }}" class="row g-3 align-items-end">
            @csrf
            @method('PATCH')
            <div class="col-md-6">
                <label class="form-label">Change Status</label>
                <select name="status" class="form-select" required>
                    <option value="">Select Status</option>
                    <option value="new" {{ $ticket->status == 'new' ? 'selected' : '' }}>New</option>
                    <option value="in_progress" {{ $ticket->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="resolved" {{ $ticket->status == 'resolved' ? 'selected' : '' }}>Resolved</option>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-sm d-flex align-items-center logout-btn w-100 justify-content-center">Update</button>
            </div>
        </form>
    </div>
</div>

{{-- Update Tech --}}
<div class="card shadow-sm mb-4">
    <div class="card-header" style="background: white; background: linear-gradient(90deg, #a855f7, #7c3aed); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;" class="fw-bold">Change Tech</div>
    <div class="card-body">
        <form method="POST" action="{{ route('tickets.transfer', $ticket->id) }}" class="row g-3 align-items-end">
            @csrf
            @method('PATCH')

            <div class="col-md-6">
                <label class="form-label">Change Tech</label>
                <select name="assigned_to" class="form-select form-select-sm selectpicker" data-live-search="true" required>
                    <option value="">Select a technician...</option>
                    @forelse ($users as $user)
                        <option value="{{ $user->id }}" {{ $ticket->assigned_to == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @empty
                        <option disabled>No technicians available</option>
                    @endforelse
                </select>
            </div>

            <div class="col-md-3">
                <button type="submit" class="btn btn-sm d-flex align-items-center logout-btn w-100 justify-content-center">Update</button>
            </div>
        </form>
    </div>
</div>


    {{-- Update Ticket Details --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header" style="background: white; background: linear-gradient(90deg, #a855f7, #7c3aed); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;" class="fw-bold">Update Ticket Details</div>
        <div class="card-body">
            <form method="POST" action="{{ route('tickets.update', $ticket->id) }}" class="row g-3">
                @csrf
                @method('PATCH')
                   <div class="col-md-6">
                            <label class="form-label small">Problem Type</label>
                            <select name="problem_type" class="form-select form-select-sm">
                                <option value="">Select problem type...</option>
                                <option value="Hardware" {{ $ticket->problem_type == 'Hardware' ? 'selected' : '' }}>Hardware</option>
                                <option value="Software" {{ $ticket->problem_type == 'Software' ? 'selected' : '' }}>Software</option>
                                <option value="Network" {{ $ticket->problem_type == 'Network' ? 'selected' : '' }}>Network</option>
                                <option value="Email" {{ $ticket->problem_type == 'Email' ? 'selected' : '' }}>Email</option>
                                <option value="Printer" {{ $ticket->problem_type == 'Printer' ? 'selected' : '' }}>Printer</option>
                                <option value="Fax" {{ $ticket->problem_type == 'Fax' ? 'selected' : '' }}>Fax</option>
                                <option value="Phone" {{ $ticket->problem_type == 'Phone' ? 'selected' : '' }}>Phone</option>
                                <option value="Website" {{ $ticket->problem_type == 'Website' ? 'selected' : '' }}>Website</option>
                                <option value="Account Access" {{ $ticket->problem_type == 'Account Access' ? 'selected' : '' }}>Account Access</option>
                                <option value="Security" {{ $ticket->problem_type == 'Security' ? 'selected' : '' }}>Security</option>
                                <option value="Other" {{ $ticket->problem_type == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>

                               <div class="col-md-6">
                            <label class="form-label small">Network Name</label>
                            <select name="network_name" class="form-select form-select-sm">
                                <option value="">Select network...</option>
                                @forelse($categories['network'] ?? [] as $category)
                                    <option value="{{ $category->name }}" {{ $ticket->network_name == $category->name ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @empty
                                    <option disabled>No networks available</option>
                                @endforelse
                            </select>
                        </div>

          <div class="col-md-6">
    <label class="form-label small">Device Name</label>
    <select name="device_name" class="form-select form-select-sm selectpicker" data-live-search="true">
        <option value="">-- Choose a device --</option>
        @foreach ($devices as $device)
           <option value="{{ $device->device_name }}" 
                {{ $ticket->device_name == $device->device_name ? 'selected' : '' }}>
                {{ $device->device_name }}
            </option>
        @endforeach
    </select>
</div>

                          <div class="col-md-6">
                                <label for="device_name" class="form-label small">Software</label>
                                <select class="form-select form-select-sm" id="software_name" name="software_name">
                                    <option value="">-- Choose Software --</option>
                                    @foreach($softwares as $software)
                                        <option value="{{ $software->software }}"{{ $ticket->software_name == $software->software ? 'selected' : '' }}>
                                            {{ $software->software }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                <div class="col-md-6">
                            <label class="form-label small">Security</label>
                            <select name="security_name" class="form-select form-select-sm">
                                <option value="">Select issue...</option>
                                @forelse($categories['security'] ?? [] as $category)
                                    <option value="{{ $category->name }}" {{ $ticket->security_name == $category->name ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @empty
                                    <option disabled>No security issues available</option>
                                @endforelse
                            </select>
                        </div>
                 <div class="col-md-6">
                            <label class="form-label small">Website Name</label>
                            <select name="website_name" class="form-select form-select-sm">
                                <option value="">Select website...</option>
                                @forelse($categories['website'] ?? [] as $category)
                                    <option value="{{ $category->name }}" {{ $ticket->website_name == $category->name ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @empty
                                    <option disabled>No websites available</option>
                                @endforelse
                            </select>
                        </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-sm d-flex align-items-center logout-btn w-100 justify-content-center mt-2">Save Details</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Comments Section --}}
    <div class="card shadow-sm">
        <div class="card-header" style="background: white; background: linear-gradient(90deg, #a855f7, #7c3aed); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;" class="fw-bold">Comments</div>
        <div class="card-body">
            @if($ticket->comment)
                <div class="bg-light p-3 rounded mb-3" style="white-space: pre-wrap; font-family: monospace;">
                    {{ $ticket->comment }}
                </div>
            @else
                <p class="text-muted">No comments yet.</p>
            @endif

            <form method="POST" action="{{ route('tickets.addComment', $ticket->id) }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Add Comment</label>
                    <textarea name="comment" class="form-control" rows="3" placeholder="Enter your comment here..." required></textarea>
                </div>
                <button type="submit" class="btn btn-sm d-flex align-items-center logout-btn">Add Comment</button>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.selectpicker').selectpicker();
    });
</script>

</x-app-layout>
