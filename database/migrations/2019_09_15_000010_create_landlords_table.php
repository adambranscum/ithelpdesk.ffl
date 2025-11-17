<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->string('id', 255)->primary(); // Explicitly set length to 255
            $table->string('name');
            $table->string('domain')->unique();
            $table->string('database')->unique();
            $table->enum('status', ['pending', 'active', 'suspended'])->default('pending');
            $table->string('admin_email')->unique();
            $table->string('admin_name');
            $table->text('notes')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->json('data')->nullable();
            $table->timestamps();
        });

        Schema::create('domains', function (Blueprint $table) {
            $table->increments('id');
            $table->string('domain', 255)->unique();
            $table->string('tenant_id', 255); // Match the length of tenants.id
            $table->timestamps();

            $table->foreign('tenant_id')
                  ->references('id')
                  ->on('tenants')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('domains');
        Schema::dropIfExists('tenants');
    }
};