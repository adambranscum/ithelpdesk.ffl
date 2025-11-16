<x-app-layout>

<div class="container p-4 mt-4 shadow">
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
                        Add New Device
                    </h4>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('devices.store') }}" method="POST">
                        @csrf

                        <div class="row g-3">
                            <!-- Device Name -->
                            <div class="col-md-6">
                                <label for="device_name" class="form-label fw-semibold">Device Name</label>
                                <input type="text" 
                                       class="form-control @error('device_name') is-invalid @enderror" 
                                       id="device_name" 
                                       name="device_name" 
                                       value="{{ old('device_name') }}" 
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
                                    <option value="Laman Branch" {{ old('branch') == 'Laman Branch' ? 'selected' : '' }}>Laman Branch</option>
                                    <option value="Argenta Branch" {{ old('branch') == 'Argenta Branch' ? 'selected' : '' }}>Argenta Branch</option>
                                    <option value="The Hub" {{ old('branch') == 'The Hub' ? 'selected' : '' }}>The Hub</option>
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
                                    <option value="Dell" {{ old('make') == 'Dell' ? 'selected' : '' }}>Dell</option>
                                    <option value="HP" {{ old('make') == 'HP' ? 'selected' : '' }}>HP</option>
                                    <option value="Lenovo" {{ old('make') == 'Lenovo' ? 'selected' : '' }}>Lenovo</option>
                                    <option value="Apple" {{ old('make') == 'Apple' ? 'selected' : '' }}>Apple</option>
                                    <option value="Microsoft" {{ old('make') == 'Microsoft' ? 'selected' : '' }}>Microsoft</option>
                                    <option value="Asus" {{ old('make') == 'Asus' ? 'selected' : '' }}>Asus</option>
                                    <option value="Acer" {{ old('make') == 'Acer' ? 'selected' : '' }}>Acer</option>
                                    <option value="Other" {{ old('make') == 'Other' ? 'selected' : '' }}>Other</option>
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
                                       value="{{ old('model') }}" 
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
                                       value="{{ old('serial') }}" 
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
                                    <option value="1 Year" {{ old('warranty') == '1 Year' ? 'selected' : '' }}>1 Year</option>
                                    <option value="2 Years" {{ old('warranty') == '2 Years' ? 'selected' : '' }}>2 Years</option>
                                    <option value="3 Years" {{ old('warranty') == '3 Years' ? 'selected' : '' }}>3 Years</option>
                                    <option value="Extended" {{ old('warranty') == 'Extended' ? 'selected' : '' }}>Extended</option>
                                    <option value="Lifetime" {{ old('warranty') == 'Lifetime' ? 'selected' : '' }}>Lifetime</option>
                                    <option value="None" {{ old('warranty') == 'None' ? 'selected' : '' }}>None</option>
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
                                       value="{{ old('purchased') }}">
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
                                       value="{{ old('warranty_end') }}">
                                @error('warranty_end')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="mt-4 d-flex gap-2">
                            <button type="submit" class="btn btn-primary btn-lg px-4">    
                                Save Device
                            </button>
                            <a href="{{ route('devices.index') }}" class="btn btn-outline-secondary btn-lg px-4">
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