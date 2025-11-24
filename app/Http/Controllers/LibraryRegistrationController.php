<?php

namespace App\Http\Controllers;

use App\Models\Library;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class LibraryRegistrationController extends Controller
{
    public function showRegistrationForm()
    {
        return view('library.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'library_name' => ['required', 'string', 'max:255'],
            'subdomain' => ['required', 'string', 'lowercase', 'max:50', 'unique:libraries,subdomain', 'regex:/^[a-z0-9-]+$/'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:500'],
            'city' => ['nullable', 'string', 'max:100'],
            'state' => ['nullable', 'string', 'max:100'],
            'zip' => ['nullable', 'string', 'max:20'],
            'admin_name' => ['required', 'string', 'max:255'],
            'admin_email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'admin_password' => ['required', Password::defaults()],
            'agree_terms' => ['required', 'accepted'],
        ]);

        try {
            DB::transaction(function () use ($validated) {
                // Create library with pending approval
                $library = Library::create([
                    'uid' => Library::generateUid(),
                    'name' => $validated['library_name'],
                    'subdomain' => $validated['subdomain'],
                    'email' => $validated['email'],
                    'phone' => $validated['phone'] ?? null,
                    'address' => $validated['address'] ?? null,
                    'city' => $validated['city'] ?? null,
                    'state' => $validated['state'] ?? null,
                    'zip' => $validated['zip'] ?? null,
                    'is_approved' => false,
                    'brand_color' => '#0066cc',
                    'primary_color' => '#003d99',
                ]);

                // Create admin user for the library
                User::create([
                    'library_uid' => $library->uid,
                    'name' => $validated['admin_name'],
                    'email' => $validated['admin_email'],
                    'password' => Hash::make($validated['admin_password']),
                    'role' => 'admin',
                    'is_active' => false, // Will be activated after approval
                    'email_verified_at' => now(),
                ]);
            });

            return redirect('/')->with('success', 'Library registration submitted successfully! Your account will be reviewed and activated shortly.');
        } catch (\Exception $e) {
            return back()->with('error', 'Registration failed. Please try again.')->withInput();
        }
    }

    public function pending()
    {
        return view('library.pending-approval');
    }
}
