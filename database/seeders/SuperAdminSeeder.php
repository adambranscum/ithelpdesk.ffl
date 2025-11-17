<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       User::create([
            'name' => 'Super Admin',
            'email' => 'admin@thecommunityhelpdesk.org',
            'password' => Hash::make('4ndr0m3d@'),
            'role' => 'super_admin',
            'is_tenant_admin' => false,
            'status' => 'active',
            'admin' => 'yes',
            'usertype' => 'SUPERADMIN',
            'email_verified_at' => now(),
        ]);
    }
}
