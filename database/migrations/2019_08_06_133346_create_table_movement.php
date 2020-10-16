<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableMovement extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_movs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cash_id')->unsigned();
            $table->foreign('cash_id')->references('id')->on('cashes');
            $table->integer('mov_reason_id')->unsigned();
            $table->foreign('mov_reason_id')->references('id')->on('mov_reasons');
            $table->integer('payment_method_id')->unsigned()->nullable(); //null para poder ejecutar scrip de migraciones--- corregir
            $table->foreign('payment_method_id')->references('id')->on('payment_methods');
            $table->decimal('amount',10,2)->nullable();
            $table->string('description')->nullable();
            $table->string('reference')->nullable();
            $table->string('method')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cash_movs');
    }
}
