<x-app-layout>

<div class="container shadow mt-4 mb-5 p-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Back Button -->
            <div class="mb-4">
                <a href="{{ route('software.index') }}" class="btn btn-outline-secondary">
                    Back to Software List
                </a>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        Edit Software
                    </h4>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('software.update', $software) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Software Name -->
                        <div class="mb-4">
                            <label for="software" class="form-label fw-semibold">
                                Software Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control form-control-lg @error('software') is-invalid @enderror" 
                                   id="software" 
                                   name="software" 
                                   value="{{ old('software', $software->software) }}" 
                                   placeholder="e.g., Microsoft Office 365" 
                                   required>
                            @error('software')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Enter the name of the software</small>
                        </div>

                        <!-- License Quantity -->
                        <div class="mb-4" id="licence_quantity_field">
                            <label for="licence_quantity" class="form-label fw-semibold">
                                License Quantity <span class="text-danger">*</span>
                            </label>
                            <input type="number" 
                                   class="form-control form-control-lg @error('licence_quantity') is-invalid @enderror" 
                                   id="licence_quantity" 
                                   name="licence_quantity" 
                                   value="{{ old('licence_quantity', $software->licence_quantity) }}" 
                                   min="0" 
                                   required>
                            @error('licence_quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Number of licenses purchased</small>
                        </div>

                        <!-- Unlimited License Checkbox -->
                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       id="unlimited" 
                                       name="unlimited"
                                       value="1"
                                       onchange="toggleUnlimited()"
                                       {{ old('unlimited', $software->unlimited) == 1 ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold" for="unlimited">
                                    Unlimited Licenses (Freeware)
                                </label>
                            </div>
                            <small class="text-muted">Check this for free software with unlimited licenses</small>
                        </div>

                        <!-- Renewal Date -->
                        <div class="mb-4" id="renewal_date_field">
                            <label for="renewal_date" class="form-label fw-semibold">
                                Renewal Date
                            </label>
                            <input type="date" 
                                   class="form-control form-control-lg @error('renewal_date') is-invalid @enderror" 
                                   id="renewal_date" 
                                   name="renewal_date" 
                                   value="{{ old('renewal_date', $software->renewal_date?->format('Y-m-d')) }}">
                            @error('renewal_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">When the license needs to be renewed (optional)</small>
                        </div>

                        <!-- Forever Checkbox -->
                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       id="forever" 
                                       name="forever"
                                       value="1"
                                       onchange="toggleForever()"
                                       {{ old('forever', $software->forever) == 1 ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold" for="forever">
                                    Forever Software
                                </label>
                            </div>
                            <small class="text-muted">Check this for software that does not need to renew</small>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary btn-lg px-4">
                                Update Software
                            </button>
                            <a href="{{ route('software.index') }}" class="btn btn-outline-secondary btn-lg px-4">
                                Cancel
                            </a>
                        </div>
                    </form>

                    <!-- Delete Button -->
                    <div class="border-top mt-4 pt-4">
                        <h5 class="text-danger mb-3">Danger Zone</h5>
                        <p class="text-muted">Once you delete this software, there is no going back. Please be certain.</p>
                        <form action="{{ route('software.destroy', $software) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this software? This action cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                Delete Software
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function toggleUnlimited() {
    const checkbox = document.getElementById('unlimited');
    const field = document.getElementById('licence_quantity_field');
    const input = document.getElementById('licence_quantity');
    
    if (checkbox.checked) {
        field.style.opacity = '0.5';
        input.disabled = true;
        input.removeAttribute('required');
        input.value = '';
    } else {
        field.style.opacity = '1';
        input.disabled = false;
        input.setAttribute('required', 'required');
        if (!input.value) {
            input.value = '1';
        }
    }
}

function toggleForever() {
    const checkbox = document.getElementById('forever');
    const field = document.getElementById('renewal_date_field');
    const input = document.getElementById('renewal_date');
    
    if (checkbox.checked) {
        field.style.opacity = '0.5';
        input.disabled = true;
        input.value = '';
    } else {
        field.style.opacity = '1';
        input.disabled = false;
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    toggleUnlimited();
    toggleForever();
});
</script>
</x-app-layout>