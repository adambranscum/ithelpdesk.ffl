<x-guest-layout>

<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl w-full bg-white rounded-lg shadow-md p-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Library Account Registration</h1>
        <p class="text-gray-600 mb-8">Register your library to use our IT helpdesk system. Your account will require approval before activation.</p>

        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-md">
                <h3 class="font-semibold text-red-800 mb-2">Please fix the following errors:</h3>
                <ul class="text-red-700 text-sm list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="/library/register" class="space-y-8">
            @csrf

            <!-- Library Information -->
            <div class="border-t pt-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Library Information</h2>

                <div class="space-y-4">
                    <div>
                        <label for="library_name" class="block text-sm font-medium text-gray-700 mb-1">Library Name *</label>
                        <input type="text" id="library_name" name="library_name" value="{{ old('library_name') }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="Main Public Library">
                    </div>

                    <div>
                        <label for="subdomain" class="block text-sm font-medium text-gray-700 mb-1">Subdomain *</label>
                        <div class="flex items-center gap-2">
                            <input type="text" id="subdomain" name="subdomain" value="{{ old('subdomain') }}" required
                                class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="mainlib"
                                pattern="^[a-z0-9-]+$"
                                title="Lowercase letters, numbers, and hyphens only">
                            <span class="text-gray-600">.yourdomain.com</span>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Lowercase letters, numbers, and hyphens only</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Library Email *</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="contact@library.org">
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                            <input type="tel" id="phone" name="phone" value="{{ old('phone') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="(555) 123-4567">
                        </div>
                    </div>

                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                        <input type="text" id="address" name="address" value="{{ old('address') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="123 Library Lane">
                    </div>

                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label for="city" class="block text-sm font-medium text-gray-700 mb-1">City</label>
                            <input type="text" id="city" name="city" value="{{ old('city') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>

                        <div>
                            <label for="state" class="block text-sm font-medium text-gray-700 mb-1">State</label>
                            <input type="text" id="state" name="state" value="{{ old('state') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>

                        <div>
                            <label for="zip" class="block text-sm font-medium text-gray-700 mb-1">ZIP Code</label>
                            <input type="text" id="zip" name="zip" value="{{ old('zip') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Admin User Information -->
            <div class="border-t pt-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Admin Account</h2>
                <p class="text-sm text-gray-600 mb-4">Create the primary administrator account for your library</p>

                <div class="space-y-4">
                    <div>
                        <label for="admin_name" class="block text-sm font-medium text-gray-700 mb-1">Administrator Name *</label>
                        <input type="text" id="admin_name" name="admin_name" value="{{ old('admin_name') }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="John Doe">
                    </div>

                    <div>
                        <label for="admin_email" class="block text-sm font-medium text-gray-700 mb-1">Administrator Email *</label>
                        <input type="email" id="admin_email" name="admin_email" value="{{ old('admin_email') }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="admin@library.org">
                    </div>

                    <div>
                        <label for="admin_password" class="block text-sm font-medium text-gray-700 mb-1">Password *</label>
                        <input type="password" id="admin_password" name="admin_password" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="••••••••">
                        <p class="text-xs text-gray-500 mt-1">Minimum 8 characters, include uppercase, lowercase, number, and symbol</p>
                    </div>

                    <div>
                        <label for="admin_password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password *</label>
                        <input type="password" id="admin_password_confirmation" name="admin_password_confirmation" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="••••••••">
                    </div>
                </div>
            </div>

            <!-- Terms -->
            <div class="border-t pt-6">
                <label class="flex items-start gap-3">
                    <input type="checkbox" name="agree_terms" required class="mt-1"
                        {{ old('agree_terms') ? 'checked' : '' }}>
                    <span class="text-sm text-gray-700">
                        I agree to the Terms of Service and understand that my library account will be reviewed and must be approved before it becomes active.
                    </span>
                </label>
            </div>

            <!-- Submit -->
            <div class="border-t pt-6 flex gap-4">
                <a href="/" class="flex-1 px-6 py-2 border border-gray-300 rounded-md text-center font-medium text-gray-700 hover:bg-gray-50">
                    Cancel
                </a>
                <button type="submit" class="flex-1 px-6 py-2 bg-blue-600 text-white rounded-md font-medium hover:bg-blue-700">
                    Submit Registration
                </button>
            </div>
        </form>
    </div>
</div>
</x-guest-layout>
