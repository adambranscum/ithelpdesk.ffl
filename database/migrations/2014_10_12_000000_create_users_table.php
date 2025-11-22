<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            
            // New role-based system
            $table->string('role')->default('tech'); // tech, admin, super_admin
            $table->boolean('is_tenant_admin')->default(false);
            $table->string('status')->default('active'); // active, suspended, pending
            
            // Legacy fields for backwards compatibility
            $table->string('admin')->default('no'); // yes, no
            $table->string('usertype')->default('TECH'); // ADMIN, TECH, etc
            
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};