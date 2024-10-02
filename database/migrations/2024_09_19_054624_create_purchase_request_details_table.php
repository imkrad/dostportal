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
        Schema::create('purchase_request_item_details', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->tinyInteger('unit_id')->unsigned()->index();
            $table->foreign('unit_id')->references('id')->on('sections');
            $table->tinyInteger('item_unit_type_id')->unsigned()->index();;
            $table->foreign('item_unit_type_id')->references('id')->on('list_dropdowns');
            $table->string('item_description')->nullable();
            $table->string('item_quantity')->nullable();
            $table->string('item_price')->nullable();
            $table->string('item_bid_price')->nullable();
            $table->string('total')->nullable();
            $table->tinyInteger('status_id')->unsigned()->index();
            $table->foreign('status_id')->references('id')->on('list_dropdowns');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_request_item_details');
    }
};
