@extends('layouts.app')

@section('content')
<div class="py-12 bg-gray-50">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow">
            <div class="border-b border-gray-200 px-6 py-4">
                <h1 class="text-2xl font-bold text-gray-900">Library Settings</h1>
            </div>

            @if ($errors->any())
                <div class="p-6 bg-red-50 border-b border-red-200">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">Please fix the following errors:</h3>
                            <ul class="mt-2 list-disc list-inside text-sm text-red-700">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            @if (session('success'))
                <div class="p-6 bg-green-50 border-b border-green-200">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ route('library.admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-8">
                @csrf

                <!-- Library Basic Info -->
                <div class="border-t pt-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Basic Information</h2>
                    <div class="space-y-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Library Name</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $library->name) }}" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email', $library->email) }}" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                            <input type="tel" id="phone" name="phone" value="{{ old('phone', $library->phone) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                    </div>
                </div>

                <!-- Address -->
                <div class="border-t pt-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Address</h2>
                    <div class="space-y-4">
                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Street Address</label>
                            <input type="text" id="address" name="address" value="{{ old('address', $library->address) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>

                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <label for="city" class="block text-sm font-medium text-gray-700 mb-1">City</label>
                                <input type="text" id="city" name="city" value="{{ old('city', $library->city) }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                            <div>
                                <label for="state" class="block text-sm font-medium text-gray-700 mb-1">State</label>
                                <input type="text" id="state" name="state" value="{{ old('state', $library->state) }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                            <div>
                                <label for="zip" class="block text-sm font-medium text-gray-700 mb-1">ZIP Code</label>
                                <input type="text" id="zip" name="zip" value="{{ old('zip', $library->zip) }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Branding -->
                <div class="border-t pt-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Branding</h2>
                    <div class="space-y-4">
                        <div>
                            <label for="logo" class="block text-sm font-medium text-gray-700 mb-1">Logo</label>
                            <input type="file" id="logo" name="logo" accept="image/*"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <p class="text-xs text-gray-500 mt-1">PNG, JPG up to 2MB. Recommended: 100x100px minimum</p>
                            @if ($library->logo_path)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $library->logo_path) }}" alt="Current logo" class="h-16">
                                </div>
                            @endif
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="brand_color" class="block text-sm font-medium text-gray-700 mb-1">Brand Color</label>
                                <div class="flex items-center">
                                    <input type="color" id="brand_color" name="brand_color" value="{{ old('brand_color', $library->brand_color) }}"
                                        class="h-10 w-20 border border-gray-300 rounded-md cursor-pointer">
                                    <input type="text" name="brand_color" value="{{ old('brand_color', $library->brand_color) }}" class="ml-2 w-24 px-3 py-2 border border-gray-300 rounded-md text-sm">
                                </div>
                            </div>

                            <div>
                                <label for="primary_color" class="block text-sm font-medium text-gray-700 mb-1">Primary Color</label>
                                <div class="flex items-center">
                                    <input type="color" id="primary_color" name="primary_color" value="{{ old('primary_color', $library->primary_color) }}"
                                        class="h-10 w-20 border border-gray-300 rounded-md cursor-pointer">
                                    <input type="text" name="primary_color" value="{{ old('primary_color', $library->primary_color) }}" class="ml-2 w-24 px-3 py-2 border border-gray-300 rounded-md text-sm">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Ticket Page Customization -->
                <div class="border-t pt-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Ticket Submission Page</h2>
                    <div class="space-y-4">
                        <div>
                            <label for="ticket_page_title" class="block text-sm font-medium text-gray-700 mb-1">Page Title</label>
                            <input type="text" id="ticket_page_title" name="ticket_page_title" value="{{ old('ticket_page_title', $library->ticket_page_title) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Submit a Support Request">
                        </div>

                        <div>
                            <label for="ticket_page_description" class="block text-sm font-medium text-gray-700 mb-1">Page Description</label>
                            <textarea id="ticket_page_description" name="ticket_page_description" rows="4"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Provide a brief description for your ticket submission page...">{{ old('ticket_page_description', $library->ticket_page_description) }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Submit -->
                <div class="border-t pt-6 flex justify-end gap-4">
                    <a href="{{ route('library.admin.dashboard') }}" class="px-6 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                        Cancel
                    </a>
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-md text-sm font-medium hover:bg-blue-700">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
