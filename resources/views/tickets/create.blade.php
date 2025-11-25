<x-app-layout>

<div class="container shadow mt-4 pt-4 pb-4">
    <div class="d-flex">
        <h2 class="mb-4 fw-bolder me-auto text-gradient-primary">Create New Ticket</h2>
        <a class="ms-auto btn btn-outline-info mb-4" href="{{ route('tickets.index') }}">Back to Tickets</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Ticket Information</h4>
        </div>

                <div class="card-body p-4">
                    <form action="{{ route('tickets.store') }}" method="POST">
                        @csrf

                        <div class="row g-3">
                            
                            <div class="col-12">
                                <label for="subject" class="form-label fw-semibold">
                                    Subject <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control form-control-lg @error('subject') is-invalid @enderror" 
                                       id="subject" 
                                       name="subject" 
                                       value="{{ old('subject') }}" 
                                       placeholder="Brief description of the issue"
                                       required>
                                @error('subject')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                           
                            <div class="col-12">
                                <label for="body" class="form-label fw-semibold">
                                    Description <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control @error('body') is-invalid @enderror" 
                                          id="body" 
                                          name="body" 
                                          rows="6"
                                          placeholder="Provide detailed information about the issue..."
                                          required>{{ old('body') }}</textarea>
                                @error('body')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            
                            <div class="col-12">
                                <h5 class="text-primary border-bottom pb-2 mb-3">Staff Information</h5>
                            </div>

                           
                            <div class="col-md-6">
                                <label for="from_name" class="form-label fw-semibold">
                                    Name <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control" 
                                       id="from_name" 
                                       name="from_name" 
                                       placeholder="Staff members full name"
                                       required>
                                @error('from_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                         
                            <div class="col-md-6">
                                <label for="from_email" class="form-label fw-semibold">
                                    Email <span class="text-danger">*</span>
                                </label>
                                <input type="email" 
                                       class="form-control @error('from_email') is-invalid @enderror" 
                                       id="from_email" 
                                       name="from_email" 
                                       placeholder="your.email@nlrlibrary.org"
                                       required>
                                @error('from_email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                           <div class="col-md-6">
                            <label class="form-label small">Branch</label>
                            <select name="branch" class="form-select">
                                <option value="">Select branch...</option>
                                @forelse($categories['branch'] ?? [] as $category)
                                    <option value="{{ $category->name }}">
                                        {{ $category->name }}
                                    </option>
                                @empty
                                    <option disabled>No branches available</option>
                                @endforelse
                            </select>
                            </div>


                           <div class="col-md-6">
                            <label class="form-label small">Department</label>
                            <select name="department" class="form-select">
                                <option value="">Select department...</option>
                                @forelse($categories['department'] ?? [] as $category)
                                    <option value="{{ $category->name }}">
                                        {{ $category->name }}
                                    </option>
                                @empty
                                    <option disabled>No departments available</option>
                                @endforelse
                            </select>
                        </div>

                            
                            <div class="col-12 mt-4">
                                <h5 class="text-primary border-bottom pb-2 mb-3">Ticket Details</h5>
                            </div>

                            <div class="col-md-6">
                                <label for="problem_type" class="form-label fw-semibold">Problem Type</label>
                                <select class="form-select @error('problem_type') is-invalid @enderror" 
                                        id="problem_type" 
                                        name="problem_type">
                                  <option value="">Select problem type...</option>
                                <option value="Hardware">Hardware</option>
                                <option value="Software">Software</option>
                                <option value="Network">Network</option>
                                <option value="Email">Email</option>
                                <option value="Printer">Printer</option>
                                <option value="Fax">Fax</option>
                                <option value="Phone">Phone</option>
                                <option value="Website">Website</option>
                                <option value="Account Access">Account Access</option>
                                <option value="Security">Security</option>
                                <option value="Other">Other</option>
                                </select>
                                <small class="text-muted">Pick the the most relevant type</small>
                            </div>

                            <div class="col-md-6">
                                <label for="device_name" class="form-label fw-semibold">Device Name</label>
                                <select class="form-select" id="device_name" name="device_name">
                                    <option value="">Select device (if applicable)...</option>
                                    @foreach($devices as $device)
                                        <option value="{{ $device->device_name }}">
                                            {{ $device->device_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('device_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">If issue is device related</small>
                            </div>

                          <div class="col-md-6">
                                <label for="device_name" class="form-label fw-semibold">Software</label>
                                <select class="form-select" id="software_name" name="software_name">
                                    <option value="">Select Software (if applicable)...</option>
                                    @foreach($softwares as $software)
                                        <option value="{{ $software->software }}">
                                            {{ $software->software }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('software')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">If issue is software related</small>
                            </div>

                            <div class="col-md-6">
                            <label class="form-label small">Network Name</label>
                            <select name="network_name" class="form-select">
                                <option value="">Select network...</option>
                                @forelse($categories['network'] ?? [] as $category)
                                    <option value="{{ $category->name }}">
                                        {{ $category->name }}
                                    </option>
                                @empty
                                    <option disabled>No networks available</option>
                                @endforelse
                            </select>
                            <small class="text-muted">If issue is network related</small>
                            </div>

                            <div class="col-md-6">

                            <label class="form-label">Website Name</label>
                            <select name="website_name" class="form-select">
                                <option value="">Select website...</option>
                                @forelse($categories['website'] ?? [] as $category)
                                    <option value="{{ $category->name }}">
                                        {{ $category->name }}
                                    </option>
                                @empty
                                    <option disabled>No websites available</option>
                                @endforelse
                            </select>

                                @error('website_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">If issue is website-related</small>
                            </div>

                            <div class="col-md-6">
                                 <label class="form-label">Security</label>
                            <select name="security_name" class="form-select">
                                <option value="">Select issue...</option>
                                @forelse($categories['security'] ?? [] as $category)
                                    <option value="{{ $category->name }}">
                                        {{ $category->name }}
                                    </option>
                                @empty
                                    <option disabled>No security issues available</option>
                                @endforelse
                            </select>
                                @error('security_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">If issue is security-related</small>
                            </div>

                            
                            <input type="hidden" name="status" value="new">
                            <input type="hidden" name="received_time" value="{{ now() }}">
                        </div>


                        <div class="mt-4 d-flex gap-2">
                            <button type="submit" class="btn btn-primary btn-lg px-4">
                                Submit Ticket
                            </button>
                            <a href="{{ route('tickets.index') }}" class="btn btn-outline-secondary btn-lg px-4">
                                Cancel
                            </a>
                        </div>
                    </form>
        </div>
    </div>
</div>

</x-app-layout>