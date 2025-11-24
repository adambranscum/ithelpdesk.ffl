<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('libraries', function (Blueprint $table) {
            $table->id();
            $table->string('uid')->unique()->comment('Unique library identifier');
            $table->string('name');
            $table->string('subdomain')->unique()->comment('Subdomain for library');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zip')->nullable();

            // Approval status
            $table->boolean('is_approved')->default(false)->comment('Manual approval required');

            // Branding
            $table->string('logo_path')->nullable();
            $table->string('brand_color')->default('#0066cc');
            $table->string('primary_color')->default('#003d99');
            $table->text('ticket_page_title')->nullable();
            $table->text('ticket_page_description')->nullable();

            $table->timestamps();

            $table->index('subdomain');
            $table->index('is_approved');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('libraries');
    }
};
