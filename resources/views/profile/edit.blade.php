<x-app-layout>

<div class="container shadow mt-4 mb-5 pb-3 pt-2">
    <a href="/tickets" class="btn btn-outline-secondary mb-3 mt-2">
        &larr; Back
    </a>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Profile Information</h4>
        </div>
        <div class="card-body p-4">
            @include('profile.partials.update-profile-information-form')
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-info text-dark fw-bold">Change Password</div>
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
