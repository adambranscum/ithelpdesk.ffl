<x-app-layout>

<div class="container p-4 mt-4 shadow my-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <!-- Back Button -->
            <div class="mb-4">
                <a href="{{ route('devices.index') }}" class="btn btn-sm d-flex align-items-center logout-btn">
                    Back to Devices
                </a>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-header" style="background: white; background: linear-gradient(90deg, #a855f7, #7c3aed); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;" class="fw-bold">
                    <h4 class="mb-0">
                        Add New Device
                    </h4>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('devices.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="library_uid" value="{{ Auth::user()->library_uid }}">

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
                                    @forelse($branches as $branch)
                                        <option value="{{ $branch->name }}" {{ old('branch') == $branch->name ? 'selected' : '' }}>
                                            {{ $branch->name }}
                                        </option>
                                    @empty
                                        <option disabled>No branches available</option>
                                    @endforelse
                                </select>
                                @error('branch')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Make -->
                            <div class="col-md-6">
                                <label for="make" class="form-label fw-semibold">Manufacturer</label>
                                <input type="text" 
                                       class="form-control @error('model') is-invalid @enderror" 
                                       id="make" 
                                       name="make" 
                                       value="{{ old('make') }}" 
                                       placeholder="e.g., Dell..">
                                @error('model')
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
                            <button type="submit" class="btn btn-sm d-flex align-items-center logout-btn">
                                Save Device
                            </button>
                            <a href="{{ route('devices.index') }}" class="btn btn-outline-danger btn-sm">
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