<div>
    <p class="text-muted mb-3">
        Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.
    </p>

    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirm-user-deletion">
        Delete Account
    </button>
</div>

<!-- Delete Account Modal -->
<div class="modal fade" id="confirm-user-deletion" tabindex="-1" aria-labelledby="confirm-user-deletion-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="{{ route('profile.destroy') }}">
                @csrf
                @method('delete')

                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="confirm-user-deletion-label">Delete Account</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <p class="mb-3">
                        <strong>Are you sure you want to delete your account?</strong>
                    </p>

                    <p class="text-muted small mb-3">
                        Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.
                    </p>

                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold">Password</label>
                        <input
                            id="password"
                            name="password"
                            type="password"
                            class="form-control @error('password', 'userDeletion') is-invalid @enderror"
                            placeholder="Enter your password"
                            required
                        />
                        @error('password', 'userDeletion')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete Account</button>
                </div>
            </form>
        </div>
    </div>
</div>
