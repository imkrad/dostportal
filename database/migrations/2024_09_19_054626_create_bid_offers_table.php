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
        Schema::create('bid_offers', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->tinyIncrements('id');
            $table->Integer('bid_item_id')->unsigned()->index();
            $table->foreign('bid_item_id')->references('id')->on('bid_items')->onDelete('cascade');
            $table->decimal('item_bid_price')->nullable();
            $table->text('technical_proposal')->nullable();
            $table->string('delivery_term')->nullable();
            $table->boolean('is_checked')->default(0);
            $table->boolean('rank')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bid_offers');
    }
};
