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
            $table->string('role')->default('tech')->after('password'); // tech, admin, super_admin
            $table->boolean('is_tenant_admin')->default(false)->after('role');
            $table->string('status')->default('active')->after('is_tenant_admin'); // active, suspended, pending
            $table->string('admin')->default('no')->after('status'); // yes, no (legacy)
            $table->string('usertype')->default('TECH')->after('admin'); // ADMIN, TECH, etc (legacy)
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
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
