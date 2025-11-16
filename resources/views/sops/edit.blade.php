<x-app-layout>

<div class="container mt-4 shadow py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
          
            <div class="mb-4">
                <a href="{{ route('sops.show', $sop) }}" class="btn btn-outline-secondary">
                    Back to SOP
                </a>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        Edit Standard Operating Procedure
                    </h4>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('sops.update', $sop) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                           
                            <div class="col-12">
                                <label for="title" class="form-label fw-semibold">
                                    Title <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control form-control-lg @error('title') is-invalid @enderror" 
                                       id="title" 
                                       name="title" 
                                       value="{{ old('title', $sop->title) }}" 
                                       placeholder="e.g., How to Reset User Password"
                                       required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="category" class="form-label fw-semibold">Category</label>
                                <select class="form-select @error('category') is-invalid @enderror" 
                                        id="category" 
                                        name="category">
                                    <option value="">Select category...</option>
                                    <option value="Hardware" {{ old('category', $sop->category) == 'Hardware' ? 'selected' : '' }}>Hardware</option>
                                    <option value="Software" {{ old('category', $sop->category) == 'Software' ? 'selected' : '' }}>Software</option>
                                    <option value="Network" {{ old('category', $sop->category) == 'Network' ? 'selected' : '' }}>Network</option>
                                    <option value="Email" {{ old('category', $sop->category) == 'Email' ? 'selected' : '' }}>Email</option>
                                    <option value="Printer" {{ old('category', $sop->category) == 'Printer' ? 'selected' : '' }}>Printer</option>
                                    <option value="Phone" {{ old('category', $sop->category) == 'Phone' ? 'selected' : '' }}>Phone</option>
                                    <option value="Security" {{ old('category', $sop->category) == 'Security' ? 'selected' : '' }}>Security</option>
                                    <option value="User Management" {{ old('category', $sop->category) == 'User Management' ? 'selected' : '' }}>User Management</option>
                                    <option value="Other" {{ old('category', $sop->category) == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('category')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                           
                            <div class="col-md-4">
                                <label for="difficulty" class="form-label fw-semibold">Difficulty Level</label>
                                <select class="form-select @error('difficulty') is-invalid @enderror" 
                                        id="difficulty" 
                                        name="difficulty">
                                    <option value="">Select difficulty...</option>
                                    <option value="Easy" {{ old('difficulty', $sop->difficulty) == 'Easy' ? 'selected' : '' }}>Easy</option>
                                    <option value="Moderate" {{ old('difficulty', $sop->difficulty) == 'Moderate' ? 'selected' : '' }}>Moderate</option>
                                    <option value="Advanced" {{ old('difficulty', $sop->difficulty) == 'Advanced' ? 'selected' : '' }}>Advanced</option>
                                </select>
                                @error('difficulty')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                       
                            <div class="col-md-4">
                                <label for="estimated_time" class="form-label fw-semibold">Estimated Time (minutes)</label>
                                <input type="number" 
                                       class="form-control @error('estimated_time') is-invalid @enderror" 
                                       id="estimated_time" 
                                       name="estimated_time" 
                                       value="{{ old('estimated_time', $sop->estimated_time) }}" 
                                       min="1"
                                       placeholder="15">
                                @error('estimated_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                         
                            <div class="col-12">
                                <label for="description" class="form-label fw-semibold">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          id="description" 
                                          name="description" 
                                          rows="3"
                                          placeholder="Brief overview of this procedure...">{{ old('description', $sop->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        
                            <div class="col-12">
                                <label for="steps" class="form-label fw-semibold">
                                    Step-by-Step Instructions <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control" 
                                          id="editor" 
                                          name="steps" 
                                          rows="10"
                                          placeholder="1. First step...&#10;2. Second step...&#10;3. Third step..."
                                          required>{!!html_entity_decode($sop->steps)!!}</textarea>
                                @error('steps')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Write detailed step-by-step instructions. Each step should be clear and actionable.</small>
                            </div>

                          
                            <div class="col-12">
                                <label for="tags" class="form-label fw-semibold">Tags</label>
                                <input type="text" 
                                       class="form-control @error('tags') is-invalid @enderror" 
                                       id="tags" 
                                       name="tags" 
                                       value="{{ old('tags', $sop->tags) }}" 
                                       placeholder="password, reset, active directory">
                                @error('tags')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Separate tags with commas for better searchability</small>
                            </div>

                           
                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $sop->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">
                                        Active (visible to all users)
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 d-flex gap-2">
                            <button type="submit" class="btn btn-primary btn-lg px-4">
                                Update SOP
                            </button>
                            <a href="{{ route('sops.show', $sop) }}" class="btn btn-outline-secondary btn-lg px-4">
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