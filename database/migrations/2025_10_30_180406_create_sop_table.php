<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sops', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('category')->nullable()->index();
            $table->text('description')->nullable();
            $table->longText('steps');
            $table->text('tags')->nullable();
            $table->string('difficulty')->nullable(); // Easy, Moderate, Advanced
            $table->integer('estimated_time')->nullable(); // in minutes
            $table->boolean('is_active')->default(true)->index();
            $table->integer('view_count')->default(0);
            $table->timestamps();
        });
        
        // Pivot table for linking SOPs to tickets
        Schema::create('sop_ticket', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sop_id')->constrained()->onDelete('cascade');
            $table->foreignId('ticket_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            
            $table->unique(['sop_id', 'ticket_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sop_ticket');
        Schema::dropIfExists('sops');
    }
};