@extends('layouts.app')

@section('content')
<div class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Library Admin Dashboard</h1>
                    <p class="mt-2 text-gray-600">Manage {{ $library->name }}</p>
                </div>
                @if($library->logo_path)
                    <img src="{{ asset('storage/' . $library->logo_path) }}" alt="{{ $library->name }}" class="h-16">
                @endif
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Active Staff Members</p>
                        <p class="text-3xl font-bold text-gray-900 mt-1">{{ $staffCount }}</p>
                    </div>
                    <div class="h-12 w-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-2a6 6 0 0112 0v2z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Total Tickets</p>
                        <p class="text-3xl font-bold text-gray-900 mt-1">{{ $ticketCount }}</p>
                    </div>
                    <div class="h-12 w-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Approval Status</p>
                        <p class="text-lg font-bold mt-1">
                            <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold"
                                style="background-color: {{ $library->is_approved ? '#d1fae5' : '#fef3c7' }}; color: {{ $library->is_approved ? '#065f46' : '#92400e' }};">
                                {{ $library->is_approved ? 'Approved' : 'Pending Approval' }}
                            </span>
                        </p>
                    </div>
                    <div class="h-12 w-12 rounded-lg flex items-center justify-center" style="background-color: {{ $library->is_approved ? '#d1fae5' : '#fef3c7' }};">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: {{ $library->is_approved ? '#065f46' : '#92400e' }};">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-lg shadow mb-8">
            <div class="border-b border-gray-200 px-6 py-4">
                <h2 class="text-lg font-semibold text-gray-900">Quick Actions</h2>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="{{ route('library.admin.staff') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Manage Staff
                </a>
                <a href="{{ route('library.admin.settings') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    Library Settings
                </a>
                <a href="{{ route('library.admin.branding-preview') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a2 2 0 012-2h6a2 2 0 012 2v14a2 2 0 01-2 2H6a2 2 0 01-2-2V5z"></path>
                    </svg>
                    Preview Branding
                </a>
            </div>
        </div>

        <!-- Library Info -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Library Information</h3>
                <div class="space-y-3 text-sm">
                    <div>
                        <p class="text-gray-600">Library UID</p>
                        <p class="font-mono text-gray-900">{{ $library->uid }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600">Subdomain</p>
                        <p class="text-blue-600 font-medium">{{ $library->subdomain }}.{{ config('app.domain', 'domain.com') }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600">Email</p>
                        <p class="text-gray-900">{{ $library->email }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600">Phone</p>
                        <p class="text-gray-900">{{ $library->phone ?? 'Not provided' }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Ticket Submission URL</h3>
                <div class="bg-gray-50 p-4 rounded border border-gray-200">
                    <p class="text-sm text-gray-600 mb-2">Share this URL with your patrons:</p>
                    <p class="font-mono text-sm text-gray-900 break-all">https://{{ $library->getUrl() }}</p>
                    <button onclick="navigator.clipboard.writeText('https://{{ $library->getUrl() }}')" class="mt-3 text-sm text-blue-600 hover:text-blue-800 font-medium">
                        Copy URL
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
