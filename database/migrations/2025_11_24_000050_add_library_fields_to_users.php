<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('library_uid')->nullable()->after('id')->comment('Associated library');
            $table->enum('role', ['admin', 'staff'])->default('staff')->after('password')->comment('User role within library');
            $table->boolean('is_active')->default(false)->after('role')->comment('Account active status');

            $table->foreign('library_uid')
                ->references('uid')
                ->on('libraries')
                ->onDelete('cascade');

            $table->index('library_uid');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['library_uid']);
            $table->dropIndex(['library_uid']);
            $table->dropColumn(['library_uid', 'role', 'is_active']);
        });
    }
};
