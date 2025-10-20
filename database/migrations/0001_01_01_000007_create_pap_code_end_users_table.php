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
        Schema::create('pap_code_end_users', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('pap_code_id')->unsigned()->index();
            $table->foreign('pap_code_id')->references('id')->on('list_pap_codes');
            $table->integer('end_user_id')->unsigned()->index();
            $table->foreign('end_user_id')->references('id')->on('end_users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pap_code_end_users');
    }
};
