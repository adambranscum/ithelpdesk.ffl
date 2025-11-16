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
        Schema::create('failedjobs', function (Blueprint $table) {
            $table->id();
            $table->text('sender');
            $table->text('department');
            $table->text('branch');
            $table->text('problem');
            $table->text('Description');
            $table->text('status');
            $table->text('type');
            $table->text('dns');
            $table->text('end');
            $table->text('ticket');
            $table->text('comments');
            $table->text('assigned');
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
        Schema::dropIfExists('failedjobs');
    }
};
