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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->Increments('id');
            $table->string('name')->nullable(); 
            $table->string('mayors_permit_no')->nullable(); 
            $table->string('tin')->nullable(); 
            $table->string('philgeps_registration_no')->nullable(); 
            $table->string('address')->nullable(); 
            $table->string('contact')->nullable(); 
            $table->string('code'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
