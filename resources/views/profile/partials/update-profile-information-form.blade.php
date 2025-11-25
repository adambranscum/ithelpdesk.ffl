<form method="post" action="{{ route('profile.update') }}">
    @csrf
    @method('patch')

    <div class="mb-3">
        <label for="name" class="form-label fw-semibold">Name</label>
        <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
        @error('name')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="email" class="form-label fw-semibold">Email</label>
        <input id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required autocomplete="username" />
        @error('email')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror

        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div class="mt-2">
                <p class="text-muted small">
                    Your email address is unverified.
                    <form id="send-verification" method="post" action="{{ route('verification.send') }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-link p-0">Click here to re-send the verification email.</button>
                    </form>
                </p>

                @if (session('status') === 'verification-link-sent')
                    <p class="mt-2 text-success small">
                        A new verification link has been sent to your email address.
                    </p>
                @endif
            </div>
        @endif
    </div>

    <div class="d-flex gap-2 align-items-center">
        <button type="submit" class="btn btn-primary">Save Changes</button>

        @if (session('status') === 'profile-updated')
            <p class="text-success small mb-0">Saved successfully!</p>
        @endif
    </div>
</form>
