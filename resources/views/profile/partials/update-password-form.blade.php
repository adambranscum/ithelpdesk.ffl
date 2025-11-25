<form method="post" action="{{ route('password.update') }}">
    @csrf
    @method('put')

    <div class="mb-3">
        <label for="current_password" class="form-label fw-semibold">Current Password</label>
        <input id="current_password" name="current_password" type="password" class="form-control @error('current_password', 'updatePassword') is-invalid @enderror" autocomplete="current-password" />
        @error('current_password', 'updatePassword')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="password" class="form-label fw-semibold">New Password</label>
        <input id="password" name="password" type="password" class="form-control @error('password', 'updatePassword') is-invalid @enderror" autocomplete="new-password" />
        @error('password', 'updatePassword')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="password_confirmation" class="form-label fw-semibold">Confirm Password</label>
        <input id="password_confirmation" name="password_confirmation" type="password" class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror" autocomplete="new-password" />
        @error('password_confirmation', 'updatePassword')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <div class="d-flex gap-2 align-items-center">
        <button type="submit" class="btn btn-primary">Update Password</button>

        @if (session('status') === 'password-updated')
            <p class="text-success small mb-0">Password updated successfully!</p>
        @endif
    </div>
</form>
