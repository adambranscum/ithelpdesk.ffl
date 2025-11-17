<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Library name
            $table->string('domain')->unique(); // subdomain.yourdomain.com
            $table->string('database')->unique(); // tenant database name
            $table->enum('status', ['pending', 'active', 'suspended'])->default('pending');
            $table->string('admin_email')->unique();
            $table->string('admin_name');
            $table->text('notes')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->json('data')->nullable(); 
            $table->timestamps();
        });

        Schema::create('domains', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->onDelete('cascade');
            $table->string('domain')->unique();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('domains');
        Schema::dropIfExists('tenants');
    }
};