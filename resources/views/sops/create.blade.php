<x-app-layout>

<div class="container mt-4 shadow py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <!-- Back Button -->
            <div class="mb-4">
                <a href="{{ route('sops.index') }}" class="btn btn-outline-secondary">
                    Back to SOPs
                </a>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        Create Standard Operating Procedure
                    </h4>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('sops.store') }}" method="POST">
                        @csrf

                        <div class="row g-3">
                            <!-- Title -->
                            <div class="col-12">
                                <label for="title" class="form-label fw-semibold">
                                    Title <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control form-control-lg @error('title') is-invalid @enderror" 
                                       id="title" 
                                       name="title" 
                                       value="{{ old('title') }}" 
                                       placeholder="e.g., How to Reset User Password"
                                       required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Category -->
                            <div class="col-md-4">
                                <label for="category" class="form-label fw-semibold">Category</label>
                                <select class="form-select @error('category') is-invalid @enderror" 
                                        id="category" 
                                        name="category">
                                    <option value="">Select category...</option>
                                    <option value="Hardware" {{ old('category') == 'Hardware' ? 'selected' : '' }}>Hardware</option>
                                    <option value="Software" {{ old('category') == 'Software' ? 'selected' : '' }}>Software</option>
                                    <option value="Network" {{ old('category') == 'Network' ? 'selected' : '' }}>Network</option>
                                    <option value="Email" {{ old('category') == 'Email' ? 'selected' : '' }}>Email</option>
                                    <option value="Printer" {{ old('category') == 'Printer' ? 'selected' : '' }}>Printer</option>
                                    <option value="Phone" {{ old('category') == 'Phone' ? 'selected' : '' }}>Phone</option>
                                    <option value="Security" {{ old('category') == 'Security' ? 'selected' : '' }}>Security</option>
                                    <option value="User Management" {{ old('category') == 'User Management' ? 'selected' : '' }}>User Management</option>
                                    <option value="Other" {{ old('category') == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('category')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Difficulty -->
                            <div class="col-md-4">
                                <label for="difficulty" class="form-label fw-semibold">Difficulty Level</label>
                                <select class="form-select @error('difficulty') is-invalid @enderror" 
                                        id="difficulty" 
                                        name="difficulty">
                                    <option value="">Select difficulty...</option>
                                    <option value="Easy" {{ old('difficulty') == 'Easy' ? 'selected' : '' }}>Easy</option>
                                    <option value="Moderate" {{ old('difficulty') == 'Moderate' ? 'selected' : '' }}>Moderate</option>
                                    <option value="Advanced" {{ old('difficulty') == 'Advanced' ? 'selected' : '' }}>Advanced</option>
                                </select>
                                @error('difficulty')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Estimated Time -->
                            <div class="col-md-4">
                                <label for="estimated_time" class="form-label fw-semibold">Estimated Time (minutes)</label>
                                <input type="number" 
                                       class="form-control @error('estimated_time') is-invalid @enderror" 
                                       id="estimated_time" 
                                       name="estimated_time" 
                                       value="{{ old('estimated_time') }}" 
                                       min="1"
                                       placeholder="15">
                                @error('estimated_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div class="col-12">
                                <label for="description" class="form-label fw-semibold">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          id="description" 
                                          name="description" 
                                          rows="3"
                                          placeholder="Brief overview of this procedure...">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Steps -->
                            <div class="col-12">
                                <label for="steps" class="form-label fw-semibold">
                                    Step-by-Step Instructions <span class="text-danger">*</span>
                                </label>
                                 <textarea id="editor" name="steps" placeholder="1. First step...&#10;2. Second step...&#10;3. Third step..." cols="30" rows="10"></textarea>
                                @error('steps')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Write detailed step-by-step instructions. Each step should be clear and actionable.</small>
                            </div>

                            <!-- Tags -->
                            <div class="col-12">
                                <label for="tags" class="form-label fw-semibold">Tags</label>
                                <input type="text" 
                                       class="form-control @error('tags') is-invalid @enderror" 
                                       id="tags" 
                                       name="tags" 
                                       value="{{ old('tags') }}" 
                                       placeholder="password, reset, active directory">
                                @error('tags')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Separate tags with commas for better searchability</small>
                            </div>

                            <!-- Is Active -->
                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">
                                        Active (visible to all users)
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="mt-4 d-flex gap-2">
                            <button type="submit" class="btn btn-primary btn-lg px-4">
                                Create SOP
                            </button>
                            <a href="{{ route('sops.index') }}" class="btn btn-outline-secondary btn-lg px-4">
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