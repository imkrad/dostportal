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
        Schema::create('pr_pap_codes', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->tinyIncrements('id');
            $table->foreign('purchase_request_id')->references('id')->on('purchase_requests');
            $table->Integer('purchase_request_id')->unsigned()->index();
            $table->foreign('list_pap_code_id')->references('id')->on('list_pap_codes');
            $table->integer('list_pap_code_id')->unsigned()->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pr_pap_codes');
    }
};
