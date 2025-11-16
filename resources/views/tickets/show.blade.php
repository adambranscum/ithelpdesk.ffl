<x-app-layout>

<div class="container shadow mt-4 mb-5 pb-3 pt-2">
    <a href="{{ route('tickets.index') }}" class="btn btn-outline-secondary mb-3 mt-2">
        &larr; Back to Tickets
    </a>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Ticket Header --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Ticket #{{ $ticket->id }} — {{ $ticket->subject }}</h4>
            <span class="badge bg-light text-dark">{{ ucfirst($ticket->status) }}</span>
        </div>
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
    <div class="card-header bg-info text-dark fw-bold">Update Status</div>
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
                <button type="submit" class="btn btn-info w-100">Update</button>
            </div>
        </form>
    </div>
</div>

{{-- Update Tech --}}
<div class="card shadow-sm mb-4">
    <div class="card-header bg-success text-white fw-bold">Change Tech</div>
    <div class="card-body">
        <form method="POST" action="{{ route('tickets.transfer', $ticket->id) }}" class="row g-3 align-items-end">
            @csrf
            @method('PATCH')

            <div class="col-md-6">
                <label class="form-label">Change Tech</label>
                <select name="transfer_to" class="form-select form-select-sm selectpicker" data-live-search="true" required>
                    
                    @foreach ($users as $user)
                        <option value="{{ $user->usertype }}" {{ $ticket->assigned_to == $user->usertype ? 'selected' : '' }}>
                            {{ $user->usertype}}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <button type="submit" class="btn btn-success w-100">Update</button>
            </div>
        </form>
    </div>
</div>


    {{-- Update Ticket Details --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-warning text-dark fw-bold">Update Ticket Details</div>
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
                                <option value="Staff WiFi" {{ $ticket->network_name == 'Staff WiFi' ? 'selected' : '' }}>Staff WiFi</option>
                                <option value="Public WiFi" {{ $ticket->network_name == 'Public WiFi' ? 'selected' : '' }}>Public WiFi</option>
                                <option value="Guest WiFi" {{ $ticket->network_name == 'Guest WiFi' ? 'selected' : '' }}>Guest WiFi</option>
                                <option value="Wired Network" {{ $ticket->network_name == 'Wired Network' ? 'selected' : '' }}>Wired Network</option>
                                <option value="VPN Connection" {{ $ticket->network_name == 'VPN Connection' ? 'selected' : '' }}>VPN Connection</option>
                                <option value="Printer Network" {{ $ticket->network_name == 'Printer Network' ? 'selected' : '' }}>Printer Network</option>
                                <option value="Fax Network" {{ $ticket->network_name == 'Fax Network' ? 'selected' : '' }}>Fax Network</option>
                                <option value="Other" {{ $ticket->network_name == 'Other' ? 'selected' : '' }}>Other</option>
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
                                <option value="PHISHING" {{ $ticket->security_name == 'PHISHING' ? 'selected' : '' }}>Phishing</option>
                                <option value="ALLOWLIST" {{ $ticket->security_name == 'ALLOWLIST' ? 'selected' : '' }}>Allow List</option>
                                <option value="DENYLIST" {{ $ticket->security_name == 'DENYLIST' ? 'selected' : '' }}>Deny List</option>
                                <option value="EMAIL ALLOWLIST" {{ $ticket->security_name == 'EMAIL ALLOWLIST' ? 'selected' : '' }}>Email Allow List</option>
                                <option value="EMAIL DENYLIST" {{ $ticket->security_name == 'EMAIL DENYLIST' ? 'selected' : '' }}>Email Deny List</option>
                                <option value="ALARM PANEL" {{ $ticket->security_name == 'ALARM PANEL' ? 'selected' : '' }}>Alarm Panel</option>
                                <option value="SECURITY CAMERA" {{ $ticket->security_name == 'SECURITY CAMERA' ? 'selected' : '' }}>Security Camera</option>
                                <option value="ADMIN BYPASS" {{ $ticket->security_name == 'ADMIN BYPASS' ? 'selected' : '' }}>Admin Bypass</option>
                            </select>
                        </div>
                 <div class="col-md-6">
                            <label class="form-label small">Website Name</label>
                            <select name="website_name" class="form-select form-select-sm">
                                <option value="">Select website...</option>
                                <option value="nlrlibrary.org" {{ $ticket->website_name == 'nlrlibrary.org' ? 'selected' : '' }}>nlrlibrary.org</option>
                                <option value="blog.nlrlibrary.org" {{ $ticket->website_name == 'blog.nlrlibrary.org' ? 'selected' : '' }}>blog.nlrlibrary.org</option>
                                <option value="selaonline.org" {{ $ticket->website_name == 'selaonline.org' ? 'selected' : '' }}>selaonline.org</option>
                                <option value="hub.nlrlibrary.org" {{ $ticket->website_name == 'hub.nlrlibrary.org' ? 'selected' : '' }}>hub.nlrlibrary.org</option>
                                <option value="arhub.org" {{ $ticket->website_name == 'arhub.org' ? 'selected' : '' }}>arhub.org</option>
								<option value="ithelpdesk.nlrlibrary.org" {{ $ticket->website_name == 'ithelpdesk.nlrlibrary.org' ? 'selected' : '' }}>ithelpdesk.nlrlibrary.org</option>
								<option value="ms365-conn.nlrlibrary.org" {{ $ticket->website_name == 'ms365-conn.nlrlibrary.org' ? 'selected' : '' }}>ms365-conn.nlrlibrary.org</option>
                            </select>
                        </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-warning w-100 mt-2">Save Details</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Comments Section --}}
    <div class="card shadow-sm">
        <div class="card-header bg-secondary text-white fw-bold">Comments</div>
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
                <button type="submit" class="btn btn-secondary">Add Comment</button>
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
