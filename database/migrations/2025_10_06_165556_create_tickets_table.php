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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->text('subject')->nullable();
            $table->longText('body')->nullable();
            $table->string('from_email')->nullable()->index();
            $table->string('from_name')->nullable();
            $table->dateTime('received_time')->nullable()->index();
            $table->string('office_location')->nullable();
            $table->string('department')->nullable();
            $table->string('status')->default('new')->index();
            $table->string('problem_type')->nullable();
            $table->string('device_name')->nullable();
            $table->string('software_name')->nullable();
            $table->string('network_name')->nullable();
            $table->string('website_name')->nullable();
            $table->string('security_name')->nullable();
            $table->dateTime('end_time')->nullable();
            $table->text('comment')->nullable();
            $table->string('assigned_to')->nullable()->index();
            $table->string('email_id')->nullable()->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};