@extends('layouts.app')

@section('content')
<div class="py-12 bg-gray-50">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Branding Preview</h1>
            <p class="text-gray-600 mt-2">This is how your ticket submission page will appear to patrons</p>
        </div>

        <!-- Preview -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <!-- Header with branding -->
            <div style="background-color: {{ $library->primary_color }}; color: white;" class="px-8 py-12">
                <div class="flex items-center gap-6">
                    @if($library->logo_path)
                        <img src="{{ asset('storage/' . $library->logo_path) }}" alt="{{ $library->name }}" class="h-24">
                    @else
                        <div class="h-24 w-24 rounded-lg" style="background-color: {{ $library->brand_color }}; opacity: 0.5;"></div>
                    @endif
                    <div>
                        <h2 class="text-3xl font-bold">{{ $library->ticket_page_title ?? 'Submit a Ticket' }}</h2>
                        <p class="mt-2 text-opacity-90" style="color: white;">{{ $library->ticket_page_description ?? 'We\'re here to help. Submit your IT support request below.' }}</p>
                    </div>
                </div>
            </div>

            <!-- Form preview -->
            <div class="p-8">
                <div class="max-w-2xl">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Ticket Information</h3>

                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Your Name</label>
                            <input type="text" placeholder="John Doe" disabled
                                class="w-full px-4 py-2 border border-gray-300 rounded-md bg-gray-50 text-gray-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                            <input type="email" placeholder="john@example.com" disabled
                                class="w-full px-4 py-2 border border-gray-300 rounded-md bg-gray-50 text-gray-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Subject</label>
                            <input type="text" placeholder="Brief description of your issue" disabled
                                class="w-full px-4 py-2 border border-gray-300 rounded-md bg-gray-50 text-gray-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                            <textarea rows="6" placeholder="Please provide details about your issue..." disabled
                                class="w-full px-4 py-2 border border-gray-300 rounded-md bg-gray-50 text-gray-500"></textarea>
                        </div>

                        <button disabled style="background-color: {{ $library->brand_color }};" class="w-full text-white font-medium py-2 rounded-md opacity-50 cursor-not-allowed">
                            Submit Ticket
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Color Reference -->
        <div class="mt-8 grid grid-cols-2 gap-6">
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-sm font-medium text-gray-700 mb-4">Brand Colors Used</h3>
                <div class="space-y-4">
                    <div class="flex items-center gap-4">
                        <div class="h-16 w-16 rounded" style="background-color: {{ $library->primary_color }};"></div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Primary Color</p>
                            <p class="text-sm text-gray-600 font-mono">{{ $library->primary_color }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="h-16 w-16 rounded" style="background-color: {{ $library->brand_color }};"></div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Brand Color</p>
                            <p class="text-sm text-gray-600 font-mono">{{ $library->brand_color }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-sm font-medium text-gray-700 mb-4">Library Info</h3>
                <dl class="space-y-2">
                    <div>
                        <dt class="text-xs font-medium text-gray-600">Library Name</dt>
                        <dd class="text-sm text-gray-900">{{ $library->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-gray-600">Subdomain</dt>
                        <dd class="text-sm text-gray-900">{{ $library->subdomain }}.{{ config('app.domain') }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-gray-600">Logo</dt>
                        <dd class="text-sm text-gray-900">{{ $library->logo_path ? 'Uploaded' : 'Not set' }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        <div class="mt-8 flex justify-end">
            <a href="{{ route('library.admin.settings') }}" class="px-6 py-2 bg-blue-600 text-white rounded-md font-medium hover:bg-blue-700">
                Edit Settings
            </a>
        </div>
    </div>
</div>
@endsection
