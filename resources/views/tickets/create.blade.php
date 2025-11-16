<x-app-layout>

<div class="container mt-4 shadow py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            
            <div class="mb-4">
                <a href="{{ route('tickets.index') }}" class="btn btn-outline-secondary">
                    Back to Tickets
                </a>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        Create New Ticket
                    </h4>
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
                                <label for="office_location" class="form-label fw-semibold">
                                    Office Location <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('office_location') is-invalid @enderror" 
                                        id="office_location" 
                                        name="office_location"
                                        required>
                                    <option value="">Select office location...</option>
                                    <option value="Argenta Branch">Argenta Branch</option>
                                    <option value="Laman Branch">Laman Branch</option>
                                    <option value="The Hub">The Hub</option>
                                    <option value="Rover Branch">Rover Branch</option>
                                </select>
                                @error('office_location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                           
                           <div class="col-md-6">
                            <label class="form-label small">Department <span class="text-danger">*</span></label>
                            <select name="department" class="form-select">
                                <option value="">Select department...</option>
                                @foreach($departments as $dept)
                                    <option value="{{ $dept['department'] }}">
                                        {{ $dept['department'] }} ({{ $dept['location'] }})
                                    </option>
                                @endforeach
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
                                <option value="Staff WiFi">Staff WiFi</option>
                                <option value="Public WiFi">Public WiFi</option>
                                <option value="Guest WiFi">Guest WiFi</option>
                                <option value="Wired Network">Wired Network</option>
                                <option value="VPN Connection">VPN Connection</option>
                                <option value="Printer Network">Printer Network</option>
                                <option value="Fax Network">Fax Network</option>
                                <option value="Other">Other</option>
                            </select>
                            <small class="text-muted">If issue is network related</small>
                            </div>

                            <div class="col-md-6">
                               
                            <label class="form-label">Website Name</label>
                            <select name="website_name" class="form-select">
                                <option value="">Select website...</option>
                                <option value="nlrlibrary.org">nlrlibrary.org</option>
                                <option value="blog.nlrlibrary.org">blog.nlrlibrary.org</option>
                                <option value="selaonline.org">selaonline.org</option>
                                <option value="hub.nlrlibrary.org">hub.nlrlibrary.org</option>
								<option value="ms365-conn.nlrlibrary.org">ms365-conn.nlrlibrary.org</option>
                                <option value="ithelpdesk.nlrlibrary.org">ithelpdesk.nlrlibrary.org</option>
                                <option value="arhub.org">arhub.org</option>
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
                                <option value="PHISHING">Phishing</option>
                                <option value="ALLOWLIST">Allow List</option>
                                <option value="DENYLIST">Deny List</option>
                                <option value="EMAIL ALLOWLIST">Email Allow List</option>
                                <option value="EMAIL DENYLIST">Email Deny List</option>
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
    </div>
</div>
</x-app-layout>