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
        Schema::create('support_tickets', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('requested_by')->unsigned()->index();
            $table->foreign('requested_by')->references('id')->on('users');
            $table->string('request_number');  
            $table->string('dv_number')->nullable();  
            $table->integer('payee_id')->unsigned()->index();
            $table->foreign('payee_id')->references('id')->on('payees');
            $table->decimal('amount');  
            $table->string('status'); 
            $table->string('problem_details');  
            $table->string('corrective_actions')->nullable();  
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('support_tickets');
    }
};
