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
        Schema::create('purchase_request_items', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('item_no');
            $table->Integer('purchase_request_id')->unsigned()->index();
            $table->foreign('purchase_request_id')->references('id')->on('purchase_requests');
            $table->tinyInteger('item_unit_type_id')->unsigned()->index();;
            $table->foreign('item_unit_type_id')->references('id')->on('list_dropdowns');
            $table->text('item_description')->nullable();
            $table->string('item_quantity')->nullable();
            $table->decimal('item_unit_cost')->nullable();
            $table->decimal('total_cost')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_request_items');
    }
};
