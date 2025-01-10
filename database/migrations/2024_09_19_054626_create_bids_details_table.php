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
        Schema::create('bids_details', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->tinyIncrements('id');
            $table->Integer('purchase_request_id')->unsigned()->index();
            $table->foreign('purchase_request_id')->references('id')->on('purchase_requests');
            $table->Integer('pr_detail_id')->unsigned()->index();
            $table->foreign('pr_detail_id')->references('id')->on('purchase_request_details');
            $table->tinyInteger('bids_id')->unsigned()->index();
            $table->foreign('bids_id')->references('id')->on('bids');
            $table->decimal('bids_abc')->nullable();
            $table->text('bids_description')->nullable();
            $table->integer('bids_quantity')->nullable();
            $table->decimal('bids_price')->nullable();
            $table->tinyInteger('bids_unit_type_id')->unsigned()->index();;
            $table->foreign('bids_unit_type_id')->references('id')->on('list_dropdowns');
            $table->string('remarks')->nullable();
            $table->integer('bids_count')->nullable();
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
        Schema::dropIfExists('bids_details');
    }
};
