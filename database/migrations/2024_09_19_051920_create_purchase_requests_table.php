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
            $table->string('purchase_request_date'); 
            $table->string('request_sai_number')->nullable(); 
            $table->dateTime('request_sai_date')->nullable(); 
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
            $table->tinyInteger('supplier_id')->unsigned()->index()->nullable();
            $table->foreign('supplier_id')->references('id')->on('suppliers');
            $table->tinyInteger('fund_cluster_id')->unsigned()->index();
            $table->foreign('fund_cluster_id')->references('id')->on('list_dropdowns');
            $table->string('po_number')->nullable();
            $table->string('pap_code')->nullable();
            $table->string('fund_cluster')->nullable();
            $table->tinyInteger('status_id')->unsigned()->index();
            $table->foreign('status_id')->references('id')->on('purchase_request_statuses');
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
