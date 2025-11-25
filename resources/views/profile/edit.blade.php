<x-app-layout>

<div class="container shadow mt-4 pt-4 pb-4">
    <div class="d-flex">
        <h2 class="mb-4 fw-bolder me-auto text-gradient-primary">Account Settings</h2>
        <a href="/tickets" class="ms-auto btn btn-outline-primary mb-4">
            &larr; Back to Tickets
        </a>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-primary text-white fw-bold">Change Password</div>
        <div class="card-body p-4">
            @include('profile.partials.update-password-form')
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-danger text-white fw-bold">Delete Account</div>
        <div class="card-body p-4">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</div>

</x-app-layout>
