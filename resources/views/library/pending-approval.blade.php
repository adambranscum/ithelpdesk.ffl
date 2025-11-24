@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full bg-white rounded-lg shadow-md p-8 text-center">
        <div class="mb-6">
            <svg class="mx-auto h-12 w-12 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>

        <h1 class="text-2xl font-bold text-gray-900 mb-2">Registration Pending Approval</h1>
        <p class="text-gray-600 mb-6">
            Thank you for registering! Your library account is currently pending manual approval.
            You will receive an email notification once your account has been approved and is ready to use.
        </p>

        <div class="bg-blue-50 border border-blue-200 rounded-md p-4 mb-6">
            <p class="text-sm text-blue-800">
                <strong>What happens next?</strong> Our team will review your registration and contact you if we need any additional information.
                Once approved, you'll receive login credentials to access your library's dashboard.
            </p>
        </div>

        <a href="/" class="inline-block px-6 py-2 bg-blue-600 text-white rounded-md font-medium hover:bg-blue-700">
            Return to Home
        </a>
    </div>
</div>
@endsection
