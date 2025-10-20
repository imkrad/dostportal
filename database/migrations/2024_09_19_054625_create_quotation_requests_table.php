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
        Schema::create('quotation_requests', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->tinyIncrements('id');
            $table->dateTime('date'); 
            $table->string('rfq_no')->unique(); 
            $table->date('submission_not_later_than'); 
            $table->Integer('supplier_id')->unsigned()->index();
            $table->foreign('supplier_id')->references('id')->on('suppliers');
            $table->Integer('supply_officer_id')->unsigned()->index();
            $table->foreign('supply_officer_id')->references('id')->on('user_profiles');
            $table->Integer('purchase_request_id')->unsigned()->index();
            $table->foreign('purchase_request_id')->references('id')->on('purchase_requests');
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
        Schema::dropIfExists('quotation_requests');
    }
};
