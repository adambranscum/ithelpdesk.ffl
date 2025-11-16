<x-app-layout>
    
<div class="container mt-4 shadow p-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <!-- Back Button -->
            <div class="mb-4">
                <a href="{{ route('devices.index') }}" class="btn btn-outline-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                    </svg>
                    Back to Devices
                </a>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        Edit Device
                    </h4>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('devices.update', $device) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <!-- Device Name -->
                            <div class="col-md-6">
                                <label for="device_name" class="form-label fw-semibold">Device Name</label>
                                <input type="text" 
                                       class="form-control @error('device_name') is-invalid @enderror" 
                                       id="device_name" 
                                       name="device_name" 
                                       value="{{ old('device_name', $device->device_name) }}" 
                                       placeholder="e.g., Office Desktop #1">
                                @error('device_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Branch -->
                            <div class="col-md-6">
                                <label for="branch" class="form-label fw-semibold">Branch</label>
                                <select class="form-select @error('branch') is-invalid @enderror" 
                                        id="branch" 
                                        name="branch">
                                    <option value="">Select branch...</option>
                                    <option value="Laman Branch" {{ old('branch', $device->branch) == 'Laman Branch' ? 'selected' : '' }}>Laman Branch</option>
                                    <option value="Argenta Branch" {{ old('branch', $device->branch) == 'Argenta Branch' ? 'selected' : '' }}>Argenta Branch</option>
                                    <option value="The Hub" {{ old('branch', $device->branch) == 'The Hub' ? 'selected' : '' }}>The Hub</option>
                                </select>
                                @error('branch')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Make -->
                            <div class="col-md-6">
                                <label for="make" class="form-label fw-semibold">Make</label>
                                <select class="form-select @error('make') is-invalid @enderror" 
                                        id="make" 
                                        name="make">
                                    <option value="">Select make...</option>
                                    <option value="Dell" {{ old('make', $device->make) == 'Dell' ? 'selected' : '' }}>Dell</option>
                                    <option value="HP" {{ old('make', $device->make) == 'HP' ? 'selected' : '' }}>HP</option>
                                    <option value="Lenovo" {{ old('make', $device->make) == 'Lenovo' ? 'selected' : '' }}>Lenovo</option>
                                    <option value="Apple" {{ old('make', $device->make) == 'Apple' ? 'selected' : '' }}>Apple</option>
                                    <option value="Microsoft" {{ old('make', $device->make) == 'Microsoft' ? 'selected' : '' }}>Microsoft</option>
                                    <option value="Asus" {{ old('make', $device->make) == 'Asus' ? 'selected' : '' }}>Asus</option>
                                    <option value="Acer" {{ old('make', $device->make) == 'Acer' ? 'selected' : '' }}>Acer</option>
                                    <option value="Other" {{ old('make', $device->make) == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('make')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Model -->
                            <div class="col-md-6">
                                <label for="model" class="form-label fw-semibold">Model</label>
                                <input type="text" 
                                       class="form-control @error('model') is-invalid @enderror" 
                                       id="model" 
                                       name="model" 
                                       value="{{ old('model', $device->model) }}" 
                                       placeholder="e.g., OptiPlex 7090">
                                @error('model')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Serial Number -->
                            <div class="col-md-6">
                                <label for="serial" class="form-label fw-semibold">Serial Number</label>
                                <input type="text" 
                                       class="form-control @error('serial') is-invalid @enderror" 
                                       id="serial" 
                                       name="serial" 
                                       value="{{ old('serial', $device->serial) }}" 
                                       placeholder="e.g., SN123456789">
                                @error('serial')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Warranty -->
                            <div class="col-md-6">
                                <label for="warranty" class="form-label fw-semibold">Warranty Type</label>
                                <select class="form-select @error('warranty') is-invalid @enderror" 
                                        id="warranty" 
                                        name="warranty">
                                    <option value="">Select warranty type...</option>
                                    <option value="1 Year" {{ old('warranty', $device->warranty) == '1 Year' ? 'selected' : '' }}>1 Year</option>
                                    <option value="2 Years" {{ old('warranty', $device->warranty) == '2 Years' ? 'selected' : '' }}>2 Years</option>
                                    <option value="3 Years" {{ old('warranty', $device->warranty) == '3 Years' ? 'selected' : '' }}>3 Years</option>
                                    <option value="Extended" {{ old('warranty', $device->warranty) == 'Extended' ? 'selected' : '' }}>Extended</option>
                                    <option value="Lifetime" {{ old('warranty', $device->warranty) == 'Lifetime' ? 'selected' : '' }}>Lifetime</option>
                                    <option value="None" {{ old('warranty', $device->warranty) == 'None' ? 'selected' : '' }}>None</option>
                                </select>
                                @error('warranty')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Purchase Date -->
                            <div class="col-md-6">
                                <label for="purchased" class="form-label fw-semibold">Purchase Date</label>
                                <input type="date" 
                                       class="form-control @error('purchased') is-invalid @enderror" 
                                       id="purchased" 
                                       name="purchased" 
                                       value="{{ old('purchased', $device->purchased?->format('Y-m-d')) }}">
                                @error('purchased')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Warranty End Date -->
                            <div class="col-md-6">
                                <label for="warranty_end" class="form-label fw-semibold">Warranty End Date</label>
                                <input type="date" 
                                       class="form-control @error('warranty_end') is-invalid @enderror" 
                                       id="warranty_end" 
                                       name="warranty_end" 
                                       value="{{ old('warranty_end', $device->warranty_end?->format('Y-m-d')) }}">
                                @error('warranty_end')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="mt-4 d-flex gap-2">
                            <button type="submit" class="btn btn-primary btn-lg px-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="me-1" viewBox="0 0 16 16">
                                    <path d="M2 1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H9.5a1 1 0 0 0-1 1v7.293l2.646-2.647a.5.5 0 0 1 .708.708l-3.5 3.5a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L7.5 9.293V2a2 2 0 0 1 2-2H14a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h2.5a.5.5 0 0 1 0 1H2z"/>
                                </svg>
                                Update Device
                            </button>
                            <a href="{{ route('devices.index') }}" class="btn btn-outline-secondary btn-lg px-4">
                                Cancel
                            </a>
                        </div>
                    </form>

                    <!-- Delete Button -->
                    <div class="border-top mt-4 pt-4">
                        <h5 class="text-danger mb-3">Danger Zone</h5>
                        <p class="text-muted">Once you delete this device, there is no going back. Please be certain.</p>
                        <form action="{{ route('devices.destroy', $device) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this device? This action cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="me-1" viewBox="0 0 16 16">
                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                </svg>
                                Delete Device
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</x-app-layout>