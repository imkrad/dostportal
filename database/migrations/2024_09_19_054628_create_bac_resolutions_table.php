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
        Schema::create('bac_resolutions', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->tinyIncrements('id');
            $table->string('bac_resolution_number')->unique(); 
            $table->text('body'); 
            $table->integer('purchase_request_id')->unsigned()->index();
            $table->foreign('purchase_request_id')->references('id')->on('purchase_requests');
            $table->integer('created_by_id')->unsigned()->index();
            $table->foreign('created_by_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bac_resolutions');
    }
};
