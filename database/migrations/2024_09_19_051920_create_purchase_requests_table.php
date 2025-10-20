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
        Schema::create('purchase_requests', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('purchase_request_number'); 
            $table->string('purchase_request_title')->nullable(); 
            $table->date('purchase_request_date'); 
            $table->string('purchase_request_purpose'); 
            $table->string('referrence_no')->nullable(); 
            $table->tinyInteger('division_id')->unsigned()->index();
            $table->foreign('division_id')->references('id')->on('list_dropdowns');
            $table->tinyInteger('section_id')->unsigned()->index();
            $table->foreign('section_id')->references('id')->on('sections');
            $table->integer('requested_by')->unsigned()->index();
            $table->foreign('requested_by')->references('id')->on('users');
            $table->integer('approved_by')->unsigned()->index();
            $table->foreign('approved_by')->references('id')->on('users');
            $table->tinyInteger('fund_cluster_id')->unsigned()->index();
            $table->foreign('fund_cluster_id')->references('id')->on('fund_clusters');
            $table->integer('quotation_count')->nullable();
            $table->tinyInteger('status_id')->unsigned()->index();
            $table->foreign('status_id')->references('id')->on('list_statuses');
            $table->tinyInteger('sub_status_id')->unsigned()->index();
            $table->foreign('sub_status_id')->references('id')->on('list_statuses');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_requests');
    }
};
