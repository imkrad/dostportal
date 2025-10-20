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
        Schema::create('notice_of_awards', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('noa_no')->unique(); 
            $table->integer('purchase_request_id')->unsigned()->index();
            $table->foreign('purchase_request_id')->references('id')->on('purchase_requests');
            $table->integer('created_by_id')->unsigned()->index();
            $table->foreign('created_by_id')->references('id')->on('users');
            $table->integer('approved_by_id')->unsigned()->index();
            $table->foreign('approved_by_id')->references('id')->on('users');
            $table->tinyInteger('status_id')->unsigned()->index();
            $table->foreign('status_id')->references('id')->on('list_statuses');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notice_of_awards');
    }
};
