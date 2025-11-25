<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('library_uid');
            $table->enum('type', ['department', 'branch', 'network', 'website', 'security']);
            $table->string('name');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('library_uid')->references('uid')->on('libraries')->onDelete('cascade');
            $table->unique(['library_uid', 'type', 'name']);
            $table->index(['library_uid', 'type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
